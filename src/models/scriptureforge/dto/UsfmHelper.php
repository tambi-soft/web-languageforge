<?php

namespace models\scriptureforge\dto;

class UsfmHelper
{
    private $_usfm;
    private $_out;
	
	public function __construct($usfm) {
		$this->_usfm = $usfm;
	}
	
    public function toHtml() {
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
    
}
