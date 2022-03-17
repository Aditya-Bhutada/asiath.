<?php 
defined( 'ABSPATH' ) || exit();

if( !class_exists( 'EL_PDF' ) ){

	class EL_PDF {

		function make_pdf_ticket( $ticket_id ){

			$ticket = array();

			$start_time = get_post_meta( $ticket_id,  OVA_METABOX_EVENT . 'date_start', true );
			$end_time = get_post_meta( $ticket_id, OVA_METABOX_EVENT . 'date_end', true );
			$seat = get_post_meta( $ticket_id, OVA_METABOX_EVENT . 'seat', true );
			$name_customer = get_post_meta( $ticket_id, OVA_METABOX_EVENT . 'name_customer', true );
			$desc_ticket = get_post_meta( $ticket_id, OVA_METABOX_EVENT . 'desc_ticket', true );
			$venue = get_post_meta( $ticket_id, OVA_METABOX_EVENT . 'venue', true );
			$logo_id = get_post_meta($ticket_id, OVA_METABOX_EVENT . "img", true);

			// Get info ticket
			$ticket['ticket_id'] = $ticket_id;
			$ticket['event_name'] = get_post_meta( $ticket_id, OVA_METABOX_EVENT . 'name_event', true );

			if (is_array($venue)) {
				$ticket['venue'] = implode(', ',$venue);
			}

			$ticket['address'] = get_post_meta( $ticket_id, OVA_METABOX_EVENT . 'address', true );

			$ticket['color_border_ticket'] = get_post_meta( $ticket_id, OVA_METABOX_EVENT . 'color_ticket', true );
			if ($ticket['color_border_ticket'] == "#fff" || $ticket['color_border_ticket'] == "#ffffff" || empty($ticket['color_border_ticket'])) {
				$ticket['color_border_ticket'] = '#cccccc';
			}

			$ticket['color_label_ticket'] = get_post_meta( $ticket_id, OVA_METABOX_EVENT . 'color_label_ticket', true );
			if ($ticket['color_label_ticket'] == "#fff" || $ticket['color_label_ticket'] == "#ffffff" || empty($ticket['color_label_ticket'])) {
				$ticket['color_label_ticket'] = '#666666';	
			}

			$ticket['color_content_ticket'] = get_post_meta( $ticket_id, OVA_METABOX_EVENT . 'color_content_ticket', true );
			if ($ticket['color_content_ticket'] == "#fff" || $ticket['color_content_ticket'] == "#ffffff" || empty($ticket['color_content_ticket'])) {
				$ticket['color_content_ticket'] = '#333333';	
			}


			$ticket['private_desc_ticket'] = get_post_meta( $ticket_id, OVA_METABOX_EVENT . 'private_desc_ticket', true );
			//sub string
			$ticket['desc_ticket'] = sub_string_word($desc_ticket, 230);
			
			$ticket['date'] =  date_i18n(get_option('date_format'), $start_time);
			$ticket['time'] = date_i18n(get_option('time_format'), $start_time) . ' - ' . date_i18n(get_option('time_format'), $end_time);

			$ticket['qrcode_str'] = get_post_meta( $ticket_id, OVA_METABOX_EVENT . 'qr_code', true );
			$ticket['type_ticket'] = $seat ? get_the_title() .' - '. $seat : get_the_title();
			$ticket['order_info'] = esc_html__( 'Ordered by', 'eventlist' ).' '.$name_customer;
			// Logo
			$ticket['logo_url'] = $logo_id ? wp_get_attachment_image_url( $logo_id, 'full' ) : '';

			$upload_dir   = wp_upload_dir();

			// Add Font
			$defaultConfig = (new Mpdf\Config\ConfigVariables())->getDefaults();
			$fontDirs = $defaultConfig['fontDir'];

			$defaultFontConfig = (new Mpdf\Config\FontVariables())->getDefaults();
			$fontData = $defaultFontConfig['fontdata'];


			$config_mpdf = array(
				'tempDir' => $upload_dir['basedir'],
				'default_font_size' => apply_filters( 'el_pdf_font_size_'.apply_filters( 'wpml_current_language', NULL ), 12 ),
				'default_font' => apply_filters( 'el_pdf_font_'.apply_filters( 'wpml_current_language', NULL ), 'DejaVuSans' ),
				'fontDir' => array_merge( $fontDirs, array( get_stylesheet_directory() . '/font' ) ),
			);

			

			$attach_file = '';

			ob_start();
				el_get_template( 'pdf/template.php', array( 'ticket' => $ticket ) );
				$html = ob_get_contents();
			ob_get_clean();

			try {
			    $mpdf = new \Mpdf\Mpdf( apply_filters( 'el_config_mpdf', $config_mpdf ) );
				$mpdf->WriteHTML( $html );
				$attach_file = WP_CONTENT_DIR.'/uploads/event__ticket'.$ticket_id.'.pdf';
				$mpdf->Output( $attach_file, 'F' );
			} catch (\Mpdf\MpdfException $e) { // Note: safer fully qualified exception name used for catch
			    // Process the exception, log, print etc.
			    echo $e->getMessage();
			}
			
			return $attach_file;
			
		}

		

	}
	

}











