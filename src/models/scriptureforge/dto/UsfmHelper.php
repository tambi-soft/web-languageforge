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
    	
    	// For display, there are some lines we just don't care about.
    	// We'll eliminate these.
    	$out = preg_replace('#\\\\(id|ide) (.*)#', '', $out);
    	
    	// CSS classes for (h)eadings and (mt)whatever those are
    	$out = preg_replace('#\\\\(h|mt) (.*)#', '<p class="\\1">\\2</p>', $out);
    	
    	// Convert chapters
    	$out = preg_replace('#\\\\c ([0-9]+)(.*)#', '<div class="c">Chapter \\1</div>\\2', $out);
    	// Convert verses
    	$out = preg_replace('#\\\\v ([0-9]+) (.*)#', '<sup>\\1</sup> \\2', $out);
    	// Convert paragrahs
    	$out = str_replace('\\p', "</p>\n<p>", $out);
    	
    	// these won't be able to handle the nested tags that don't have a closing tag though
    	// Convert add
    	$out = preg_replace('#\\\\\\+?add\\s#', '<span class="add">', $out);
    	$out = preg_replace('#\\\\\\+?add\\*#', "</span>", $out);
    	// Convert wj
    	$out = preg_replace('#\\\\\\+?wj\\s#', '<span class="wj">', $out);
    	$out = preg_replace('#\\\\\\+?wj\\*#', "</span>", $out);
    	
    	
    	// This is a work in progress; there is more to do here.
    	
    	
    	// Don't put a closing tag before the first paragraph
    	$out = preg_replace('#^(.*?)</p>#', '\\1', $out);
    	
    	$this->_out = $out;
    	return $this->_out;
    }
    
}
