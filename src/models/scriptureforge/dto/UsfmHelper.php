<?php

namespace models\scriptureforge\dto;

class UsfmHelper
{
	private $_usfm;
	private $_out;
	
	public function __construct($usfm) {
		$this->_usfm = $usfm;
	}
	
	/**
	 * @deprecated
	 */
	public function toHtmlOld() {
		$out = $this->_usfm;
		
		// Escape HTML special characters
		$out = htmlspecialchars($out);
		
		// For display, there are some lines we just don't care about.
		// We'll eliminate these.
		$out = preg_replace('#\\\\(id|ide) (.*)#', '', $out);
		
		// CSS classes for (h)eadings, major titles (mt), and other types of divs
		$out = preg_replace('#\\\\(h|mt|li[0-9]*) (.*)#', '<div class="usfm-\\1">\\2</div>', $out);
		// Introduction paragraphs
		$out = preg_replace('#\\\\(ip) (.*)#', '<p class="usfm-\\1">\\2</p>', $out);
		
		// Blank lines
		$out = preg_replace('#\\\\b\\s+(.*)#', '<p class="usfm-\\1">\\2</p>', $out);
		
		// Span classes
		$out = preg_replace('#\\\\(d|io1|iot|imt[0-9]*) (.*)#', '<span class="usfm-\\1">\\2</span>', $out);
		
		// Convert chapters
		$out = preg_replace('#\\\\c ([0-9]+)(.*)#', '<div class="usfm-c">Chapter \\1</div>\\2', $out);
		// Convert verses
		$out = preg_replace('#\\\\v ([0-9]+) (.*)#', '<sup>\\1</sup> \\2', $out);
		// Convert paragrahs
		$out = preg_replace('#\\\\(p|m)\\s+#', "</p>\n<p class=\"usfm-\\1\">", $out);
		
		// TODO Handle the nested tags that don't have a closing tag
		// Convert add
		$out = preg_replace('#\\\\\\+?add\\s#', '<span class="usfm-add">', $out);
		$out = preg_replace('#\\\\\\+?add\\*#', "</span>", $out);
		// Convert wj
		$out = preg_replace('#\\\\\\+?wj\\s#', '<span class="usfm-wj">', $out);
		$out = preg_replace('#\\\\\\+?wj\\*#', "</span>", $out);
		
		
		// Catch-all: Wrap unrecognized tags 
		$out = preg_replace('#\\\\([A-Za-z0-9]+)[+*]*(.*)#', '<span class="usfm-\\1">\\2</span>', $out);
		
		
		// This is a work in progress; there is more to do here.
		
		
		// Don't put a closing tag before the first paragraph
		//$out = preg_replace('#^(.*?)</p>#', '\\1', $out);
		
		$this->_out = $out;
		return $this->_out;
	}
	
	public function toHtml() {
		
		
		// Test data: Image placements for the book of John.
		// TODO Get these from a parameter or something.
		// They ultimately come from an "illustration.conf" file.
		$illustrations = array(
			'2:6' => 'lb00135',
			'2:13' => 'lb00250',
			'5:8' => 'lb00308',
			'10:2' => 'bk00004',
			'13:21' => 'lb00320',
			'21:3' => 'hk00207',
		);
		
		
		// Preset marker collections
		$markersToIgnore = array('id', 'ide');
		$paragraphMarkers = array('p', 'm');
		//$paragraphMarkers = array('p', 'm', 'pmo', 'pm', 'pmc', 'pmr', 'pi', 'mi', 'nb', 'cls', 'li', 'pc', 'pr', 'ph');
		$poetryMarkers = array('q', 'qr', 'qc', 'qs', 'qs*', 'qa', 'qac', 'qac*', 'qm', 'b');
		$titleMarkers = array('h', 'mt', 'mte', 'ms', 'mr', 's', 'sr', 'r', 'rq', 'rq*', 'd', 'sp');
		
		// Get the lines of the file with this split function.
		$lines = explode("\n", $this->_usfm);
		
		// initialize variables
		$inParagraph = false;
		$paragraphID = null;
		$paragraphText = '';
		$paragraphType = '';
		$paragraphJustEnded = false;
		$chapter = 0;
		$out = '';
		
		// Loop through the lines of the input file
		// and process line-level markers.
		foreach ($lines as $line) {
			
			// UTF8 decoding is needed for characters like slanted apostrophes
			//$line = utf8_encode($line);
			$line = htmlspecialchars($line);
			
			$paragraphJustEnded = false;
			
			// Check the first marker.
			if (!preg_match("#^\\s*\\\\((\\S+?)[0-9]*)(\\s+.*)?$#", $line, $matches)) {
				// The line does not begin with a marker. (Example: a blank line)
				// Add the line to the output or the current paragraph and move on.
				if ($inParagraph) {
					$paragraphText .= $line;
				} else {
					$out .= $line;
				}
				continue;
			}
			$firstMarkerWithNumber = $matches[1];
			$firstMarker = $matches[2];
			$textAfterMarker = (isset($matches[3])) ? trim($matches[3]) : '';
			
			// If it is an ignore_marker, such as "id" or "ide", skip the line.
			if (in_array($firstMarker, $markersToIgnore)) {
				continue;
			}
			
			// If it is paragraph marker such as "p" OR a poetry marker, heading marker, or chapter marker,
			// and we are currently in a paragraph, end the current paragraph.
			if (in_array($firstMarker, $paragraphMarkers) || in_array($firstMarker, $poetryMarkers)
				|| in_array($firstMarker, $titleMarkers) || $firstMarker == 'c') {
				if ($inParagraph) {
					// Initiating paragraph termination sequence in 3... 2... 1... :
					
					// Append $paragraphText to $out.
					$out .= $this->makeParagraph($paragraphText, $paragraphID, $paragraphType);
					
					// Clear paragraph variables.
					$inParagraph = false;
					$paragraphID = null;
					$paragraphText = '';
					$paragraphType = '';
					
					$paragraphJustEnded = true;
				}
			}
			
			// If it is a paragraph marker (we will first support "p" and "m" for this):
			if (in_array($firstMarker, $paragraphMarkers)) {
				// Start a new paragraph.
				// Keep track of the marker used to start this paragraph.
				$inParagraph = true;
				$paragraphType = $firstMarker;
			} else if ($firstMarker == 'c') {
				
				// If it is a chapter marker "c":
				// - Save the $chapter number.
				// - Output the chapter number.
				// - Move to the next line.
				
				// Get the chapter number and keep track of what chapter we are in.
				preg_match('#^([0-9]+)#', $textAfterMarker, $matches);
				$chapter = $matches[1];
				
				// Output the chapter number.
				$out .= "\n" . '<div class="chapter-number">Chapter '
					. $chapter . '</div>' . "\n";
				
				continue;
			} else if ($firstMarker == 'v') {
				// Verse marker
				
				// Get the verse number.
				preg_match('#^([0-9]+)\\s*(.*?)$#', $textAfterMarker, $matches);
				$verseNumber = $matches[1];
				$verseText = $matches[2];
				
				// - If we are in a paragraph and we don't have an $id for this paragraph yet,
				//   use this verse number with the current $chapter number as the paragraph id,
				//   such as "c1v1".
				// - Output the superscripted verse number (either to output or the current paragraph).
				// - Output the verse text.
				if ($inParagraph) {
					if ($paragraphID == '') {
						$paragraphID = 'c' . $chapter . 'v' . $verseNumber;
					}
					$paragraphText .= ' <sup>' . $verseNumber . '</sup> ' . $verseText;
				} else {
					$out .= ' <sup>' . $verseNumber . '</sup> ' . $verseText;
				}
				
				// Output illustration placeholder, if any.
				if (isset($illustrations[$chapter . ":" . $verseNumber])) {
					$illustrationID = $illustrations[$chapter . ":" . $verseNumber];
					if ($inParagraph) {
						$paragraphText .= ' <span id="illustration-' . $illustrationID
							. '" class="illustration-placeholder">Illustration</span> ';
					} else {
						$out .= ' <span id="illustration-' . $illustrationID
							. '" class="illustration-placeholder">Illustration</span> ';
					}
				}
				
				continue;
			} else if (in_array($firstMarker, $titleMarkers) || in_array($firstMarker, $poetryMarkers)) {
				// Headings and poetry lines:
				// Add the line (without the marker) to $out.
				// If we were in a paragraph before, this marker ended that paragraph,
				// as implemented in the code above, so we aren't adding to a paragraph.
				
				// TODO: put these in a <div>?
				//$out .= '<div class="usfm-' . $firstMarkerWithNumber . '">';
				
				// Only put a line break in if a paragraph didn't just end.
				if (! $paragraphJustEnded) {
					$out .= "<br />\n";
				}
			} else {
				// For all other markers, add the line to the output, including the marker.
				if ($inParagraph) {
					$paragraphText .= $line;
				} else {
					$out .= $line;
				}
				continue;
			}
			
			// Output the rest of the line.
			if ($inParagraph) {
				$paragraphText .= $textAfterMarker;
			} else {
				$out .= $textAfterMarker;
			}
		}
		
		// If we in an unfinished paragraph (likely), add it to the output.
		if ($inParagraph) {
			$out .= $this->makeParagraph($paragraphText, $paragraphID, $paragraphType);
		}
		
		// Then perform replacements to place text between markers
		// such as "wj", "add", and others in classed spans.
		$out = $this->handleInlineTags($out);
		
		return $out;
	}
	
	private function makeParagraph($text, $id, $type) {
		// Ignore blank paragraphs
		if (! $text) {
			return "\n";
		}
		
		// If there is an $id, begin the $paragraph with "<p id="$paragraphID">";
		//   otherwise just use "<p>".
		// End the paragraph with "</p>" and a new line in the source code.
		if ($id) {
			return '<p id="' . $id . '" class="usfm-' . $type . '">' . $text . '</p>' . "\n";
		} else {
			return '<p class="usfm-' . $type . '">' . $text . '</p>' . "\n";
		}
	}
	
	private function handleInlineTags($usfm) {
		$out = $usfm;
		 
		// TODO Handle the nested tags that don't have a closing tag
		
		// Convert add
		$out = preg_replace('#\\\\\\+?add\\s#', '<span class="usfm-add">', $out);
		$out = preg_replace('#\\\\\\+?add\\*#', "</span>", $out);
		// Convert wj
		$out = preg_replace('#\\\\\\+?wj\\s#', '<span class="usfm-wj">', $out);
		$out = preg_replace('#\\\\\\+?wj\\*#', "</span>", $out);
		
		// Catch-all: Remove unrecognized tags
    	$out = preg_replace('#\\\\(\\S)+#', '', $out);
		
		return $out;
	}
	
}
