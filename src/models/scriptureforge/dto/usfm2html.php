<?php

toHtml($input) {
    $in = file_get_contents($input);
    // Convert chapters
    $out = preg_replace('#\\\\c ([0-9]+) (.*)#', '<div class="c">\\1</div> \\2', $in);
    // Convert verses
    $out = preg_replace('#\\\\v ([0-9]+) (.*)#', '<sup>\\1</sup> \\2', $out);
    // Convert paragrahs
    $out = str_replace('\\p', "</p>\n<p>", $out);

    // these won't be able to handle the nested tags that don't have a closing tag though
    // Convert add
    $out = preg_replace('#\\\\\\+?add#', '<span class="add">', $out);
    $out = preg_replace('#\\\\\\+?add*#', "</span>", $out);
    // Convert wj
    $out = preg_replace('#\\\\\\+?wj#', 'span class="wj">', $out);
    $out = preg_replace('#\\\\\\+?wj*#', "</span>", $out);

    // Don't put a closing tag before the first paragraph
    $out = preg_replace('#^\\s*</p>#', '', $out);

    return $out;
}
