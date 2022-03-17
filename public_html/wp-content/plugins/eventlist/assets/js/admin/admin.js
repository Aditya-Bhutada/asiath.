(function ($) {

   /* object js */
   EL_Admin = {
      init: function () {
         $( "#tabs" ).tabs();
         this.admin_setting_tab();
         this.gallery_image();
         this.map();
         this.edit_full_address();
         this.el_load_venue();
         this.contact();
         this.date_time_picker();
         this.radio_single_banner();
         this.image_banner();

         this.add_image_ticket();
         this.remove_image_ticket();
         this.radio_seat_option();
         this.radio_type_price();
         this.add_image_ticket_map();
         this.remove_image_ticket_map();
         this.color_picker_ticket();

         this.add_ticket();
         this.add_seat_map();
         this.add_desc_seat_map();
         this.sortable_ticket();
         this.toggle_ticket();
         this.count_tickets();
         this.repair_key_ticket();
         this.remove_ticket();

         this.calendar();

         this.coupon();

         this.create_ticket_send_mail();
         this.download_ticket();

         this.update_status_proccess();

         // Category
         this.add_image_category();
         this.remove_image_category();

         // Add Manual Booking in Admin
         this.add_custom_booking();

         //date picker
         this.el_datepicker();

         this.ova_checkout_field();
         this.ova_metabox_booking_checkout_field();

         // event type
         this.el_choose_event_type();

         // link ticket
         this.el_choose_link_ticket();
         // enable cancel booking
         this.el_enable_cancellation_booking();
      },

      el_choose_event_type: function(){

         if( $( "input[name='ova_mb_event_event_type']" ).length > 0 ){

            var event_type = $("input[name='ova_mb_event_event_type']:checked").val();

            if( event_type == 'online' ){
               $( "#mb_basic #mb_location" ).hide();
               $( "body" ).addClass('online_event');
            }else if( event_type == 'classic' ){
               $( "#mb_basic #mb_location" ).show();
               $( "body" ).removeClass('online_event');
            }

            $( "input[name='ova_mb_event_event_type']" ).on( 'click', function(){

               event_type = $("input[name='ova_mb_event_event_type']:checked").val();
                
               if( event_type == 'online' ){
                  $( "#mb_basic #mb_location" ).hide();
                  $( "body" ).addClass('online_event');
                  
               }else if( event_type == 'classic' ){
                  $( "#mb_basic #mb_location" ).show();
                  $( "body" ).removeClass('online_event');
                  
               }

            });



         }
      },

      el_choose_link_ticket: function(){

        if( $( "input[name='ova_mb_event_ticket_link']" ).length > 0 ){

            var ticket_link = $("input[name='ova_mb_event_ticket_link']:checked").val();

            if( ticket_link == 'ticket_internal_link' ){
               $( "#mb_ticket .ticket_internal_link" ).show();
               $( "#mb_ticket .ticket_external_link" ).hide();
            }else if( ticket_link == 'ticket_external_link' ){
               $( "#mb_ticket .ticket_internal_link" ).hide();
               $( "#mb_ticket .ticket_external_link" ).show();
            }

            $( "input[name='ova_mb_event_ticket_link']" ).on( 'click', function(){

               ticket_link = $("input[name='ova_mb_event_ticket_link']:checked").val();
                
               if( ticket_link == 'ticket_internal_link' ){
                  $( "#mb_ticket .ticket_internal_link" ).show();
                  $( "#mb_ticket .ticket_external_link" ).hide();
               }else if( ticket_link == 'ticket_external_link' ){
                  $( "#mb_ticket .ticket_internal_link" ).hide();
                  $( "#mb_ticket .ticket_external_link" ).show();
               }

            });



         }

      },

      el_enable_cancellation_booking:function(){
         if( $( "input[name='ova_mb_event_allow_cancellation_booking']" ).length > 0 ){

            var allow_cancel_bk = $("input[name='ova_mb_event_allow_cancellation_booking']:checked").val();

            if( allow_cancel_bk == 'yes' ){
               $( "#mb_cancel_booking .cancel_bk_before_x_day" ).show();
               
            }else if( allow_cancel_bk == 'no' ){
               $( "#mb_cancel_booking .cancel_bk_before_x_day" ).hide();
               
            }

            $( "input[name='ova_mb_event_allow_cancellation_booking']" ).on( 'click', function(){

               allow_cancel_bk = $("input[name='ova_mb_event_allow_cancellation_booking']:checked").val();
                
               if( allow_cancel_bk == 'yes' ){
                  $( "#mb_cancel_booking .cancel_bk_before_x_day" ).show();
                  
               }else if( allow_cancel_bk == 'no' ){
                  $( "#mb_cancel_booking .cancel_bk_before_x_day" ).hide();
                  
               }

            });

         }
      },

      ova_metabox_booking_checkout_field: function() {
         var list_key_checkout_field = $('#el_meta_booking_list_key_checkout_field').val();
         var data_checkout_field = {};

         if(list_key_checkout_field) {
            list_key_checkout_field = JSON.parse(list_key_checkout_field);
            for( var key_ckf in list_key_checkout_field ) {

               var value_ckf = $("#" + list_key_checkout_field[key_ckf] ).val();
               var name_ckf = list_key_checkout_field[key_ckf];

               if( $(".el_booking_detail #" + name_ckf).hasClass('ova_select') ) {
                  $(".el_booking_detail #" + name_ckf).on("change", function() {
                     var bk_data_checkout_field = $('#bk_data_checkout_field').val();
                     bk_data_checkout_field = JSON.parse(bk_data_checkout_field);

                     let value_input = $(this).val();
                     var id_field = $(this).attr('id');

                     bk_data_checkout_field[id_field] = value_input;
                     bk_data_checkout_field = JSON.stringify(bk_data_checkout_field);

                     $('#bk_data_checkout_field').val(bk_data_checkout_field);

                  });
               } else {
                  $(".el_booking_detail #" + name_ckf).on("keyup", function() {

                     var bk_data_checkout_field = $('#bk_data_checkout_field').val();
                     bk_data_checkout_field = JSON.parse(bk_data_checkout_field);

                     let value_input = $(this).val();
                     var id_field = $(this).attr('id');

                     bk_data_checkout_field[id_field] = value_input;
                     bk_data_checkout_field = JSON.stringify(bk_data_checkout_field);

                     $('#bk_data_checkout_field').val(bk_data_checkout_field);

                  });
               }

            }
         }

      },

      ova_checkout_field: function(){

         var OVA_OPTION_ROW_HTML  = '';
             OVA_OPTION_ROW_HTML += '<tr>';
             OVA_OPTION_ROW_HTML += '<td ><input type="text" name="ova_options_key[]" placeholder="Option Value" /></td>';
             OVA_OPTION_ROW_HTML += '<td ><input type="text" name="ova_options_text[]" placeholder="Option Text" /></td>';
             OVA_OPTION_ROW_HTML += '<td class="ova-box "><a href="javascript:void(0)" class=" ovabrw_addfield btn btn-blue" title="Add new option">+</a></td>';
             OVA_OPTION_ROW_HTML += '<td class="ova-box "><a href="javascript:void(0)"  class=" ovabrw_remove_row btn btn-red" title="Remove option">x</a></td>';
             OVA_OPTION_ROW_HTML += '<td class="ova-box sort ui-sortable-handle"></td>';
             OVA_OPTION_ROW_HTML += '</tr>';
            

             
             jQuery(document).on('click', '.ovabrw_addfield', function(e){

                 var table = jQuery(this).closest('table');
                 var optionsSize = table.find('tbody tr').size();


                 var height = jQuery('.ova-wrap-popup-ckf').attr('height');
                 if(height) {
                     height = parseInt(height) + 5;
                 } else {
                     height = 110;
                 }
                 
                 jQuery('.ova-wrap-popup-ckf').attr('height', height);
                 jQuery('.ova-wrap-popup-ckf').css('height', height + 'vh');
                 if(optionsSize > 0){
                     table.find('tbody tr:last').after(OVA_OPTION_ROW_HTML);
                 }else{
                     
                     table.find('tbody').append(OVA_OPTION_ROW_HTML);        
                 }
             })
             
             jQuery(document).on('click','.ovabrw_remove_row', function(e){
                 var table = jQuery(this).closest('table');
                 jQuery(this).closest('tr').remove();
                 var optionsSize = table.find('tbody tr').size();
                     
                 if(optionsSize == 0){
                     table.find('tbody').append(OVA_OPTION_ROW_HTML);
                 }
             })


             jQuery('.ovabrw_edit_field_form').on('click', function(e){

                 var data = jQuery(this).data('data_edit');

                 var name = data.name;
                 var type = (data.type) ? data.type : 'text';
                 var label = data.label;
                 var placeholder = data.placeholder;
                 var default_value = data.default;
                 var ova_class = data.class;

                 var ova_options_key = data.ova_options_key;
                 var ova_options_text = data.ova_options_text;

                 if( type == 'select' ) {
                     jQuery('.ova-wrap-popup-ckf .ova-popup-wrapper tr.ova-row-placeholder').css('display', 'none');
                 } else {
                     jQuery('.ova-wrap-popup-ckf .ova-popup-wrapper tr.ova-row-placeholder').css('display', 'table-row');
                 }

                 var option_html_edit = '';
                 
                 if( type === 'select' ) {
                     jQuery('.ova-wrap-popup-ckf .ova-popup-wrapper tr.row-options table.ova-sub-table tbody').empty();
                     jQuery('.ova-wrap-popup-ckf .ova-popup-wrapper tr.row-options').css('display', 'table-row');
                     ova_options_key.forEach(function(item, key){
                         option_html_edit += '<tr>';
                         option_html_edit += '<td ><input type="text" name="ova_options_key[]" placeholder="Option Value" value="'+item+'" /></td>';
                         option_html_edit += '<td ><input type="text" name="ova_options_text[]" placeholder="Option Text" value="'+ova_options_text[key]+'" /></td>';
                         option_html_edit += '<td class="ova-box "><a href="javascript:void(0)"  class="ovabrw_addfield btn btn-blue" title="Add new option">+</a></td>';
                         option_html_edit += '<td class="ova-box "><a href="javascript:void(0)" class="ovabrw_remove_row btn btn-red" title="Remove option">x</a></td>';
                         option_html_edit += '<td class="ova-box sort ui-sortable-handle"></td>';
                         option_html_edit += '</tr>';
                     });
                     jQuery('.ova-wrap-popup-ckf .ova-popup-wrapper tr.row-options table.ova-sub-table tbody').append(option_html_edit)
                 } else {
                     jQuery('.ova-wrap-popup-ckf .ova-popup-wrapper tr.row-options').css('display', 'none');
                 }


                 jQuery('#ova_popup_field_form input[name="ova_action"]').val('edit');
                 jQuery('#ova_popup_field_form input[name="ova_old_name"]').val(name);

                 jQuery('#ova_type').val(type);
                 jQuery('#ova_popup_field_form .ova-row-name input').val(name);
                 jQuery('#ova_popup_field_form .ova-row-label input').val(label);
                 jQuery('#ova_popup_field_form .ova-row-placeholder input').val(placeholder);
                 jQuery('#ova_popup_field_form .ova-row-default input').val(default_value);
                 jQuery('#ova_popup_field_form .ova-row-class input').val(ova_class);

                 jQuery('.ova-wrap-popup-ckf').css('display', 'block');
             })


             jQuery('#ovabrw_openform').on('click', function(e){
                 jQuery('#ova_popup_field_form input[name="ova_action"]').val('new');
                 jQuery('#ova_popup_field_form input[name="ova_old_name"]').val('');
                 jQuery('.ova-wrap-popup-ckf').css('display', 'block');
                 

                 jQuery('#ova_type').val('text');
                 jQuery('.ova-wrap-popup-ckf input[name="name"]').val('');
                 jQuery('.ova-wrap-popup-ckf input[name="label"]').val('');
                 jQuery('.ova-wrap-popup-ckf input[name="placeholder"]').val('');
                 jQuery('.ova-wrap-popup-ckf input[name="default"]').val('');
                 jQuery('.ova-wrap-popup-ckf .row-options').css('display', 'none');
             })

             jQuery('#ovabrw_manage_custom_checkout_field').on('change', function(){
                 jQuery('.ovabrw_product_custom_checkout_field_field').css('display', 'block');
                 if( jQuery(this).val() == 'all' ) {
                     jQuery('.ovabrw_product_custom_checkout_field_field').css('display', 'none');
                 }
             });

             jQuery('#ova_type').on('change', function(){
                 jQuery('.ova-wrap-popup-ckf .ova-popup-wrapper tr.row-options').css('display', 'none');
                 jQuery('.ova-wrap-popup-ckf .ova-popup-wrapper tr.ova-row-placeholder').css('display', 'table-row');
                 if( jQuery(this).val() == 'select' ) {
                     jQuery('.ova-wrap-popup-ckf .ova-popup-wrapper tr.row-options').css('display', 'table-row');
                     jQuery('.ova-wrap-popup-ckf .ova-popup-wrapper tr.ova-row-placeholder').css('display', 'none');
                 }
             });

             jQuery('#ovabrw_select_all_field').on('click', function(e){

                 var checkAll = jQuery(this).prop('checked');
                 jQuery( '.ova-list-checkout-field table tbody tr td.ova-checkbox input' ).prop( 'checked', checkAll );
             })

             jQuery('#ovabrw_close_popup').on('click', function(e){
                 jQuery('.ova-wrap-popup-ckf').css('display', 'none');
             })

             jQuery('.ova_remove').on('click', function(e) {
                 var result = ovabrwconfirmRemove('Are you sure?');
                 if(!result) {
                     e.preventDefault();
                 }
                 
             });


             function ovabrwconfirmRemove( $mess="" ) {
                 var result = confirm($mess);
                 return result;
             }


      },


     

      update_status_proccess: function () {
         $(".update-pay-profit").off().on('click', function(){
            if (!confirm("Are you sure change status?")) return false;
            var that = $(this);
            var id_event = that.attr('data-id');
            var nonce_update_pay_profit = that.attr('data-nonce');
            var status = that.attr('data-status');
            that.siblings(".submit-load-more").css("z-index", 1);
            $.ajax({
               url: ajax_object.ajax_url,
               type: 'POST',
               data: {
                  action: 'update_status_proccess',
                  nonce_update_pay_profit: nonce_update_pay_profit,
                  id_event: id_event,
                  status: status,
               },
               success: function(response) {

                  if (response == 'success') {
                     that.parent(".button-load-ova").siblings(".text").text(status);
                     that.parent(".button-load-ova").css("display", "none");
                     $(".submit-load-more").css("z-index", -1);
                  } else {
                     that.parent(".button-load-ova").css("display", "none");
                     $(".submit-load-more").css("z-index", -1);
                  }
               }
            });
         });
      },


      create_ticket_send_mail: function () {
         $(".create-ticket-send-mail").off().on("click", function(e){
            e.preventDefault();
            var id_booking = $(this).attr("data-id-booking");
            var el_create_send_ticket_nonce = $(this).attr("data-nonce");

            $(this).siblings(".submit-load-more.sendmail").css({"z-index":"1"});
            $.ajax({
               url: ajax_object.ajax_url,
               type: 'POST',
               data: {
                  action: 'create_ticket_send_mail',
                  el_create_send_ticket_nonce: el_create_send_ticket_nonce,
                  id_booking: id_booking,
               },
               success:function(response) {
                  
                  var data = JSON.parse(response);
                  $(".el_booking_detail .status").css("display", "none");
                  if (data.status == "success") {
                     $(".submit-load-more.sendmail").css({"z-index":"-1"});
                     $(".success").text(data.message).css({"display":"block","color":"#28a745"});
                  } else if (data.status = "error") {
                     $(".submit-load-more.sendmail").css({"z-index":"-1"});
                     $(".error").text(data.message).css({"display":"block","color":"#dc3545"});
                  }
               },
            })

         });
      },


      download_ticket: function() {
         $('.download-ticket').off().on('click', function(e) {
            e.preventDefault();
            var id_booking = $(this).attr("data-id-booking");
            var el_download_ticket_nonce = $(this).attr('data-nonce');

            $(this).siblings(".submit-load-more.dowload-ticket").css({"z-index":"1"});
            $.ajax({
               url: ajax_object.ajax_url,
               type: 'POST',
               data: {
                  action: 'download_ticket',
                  el_download_ticket_nonce: el_download_ticket_nonce,
                  id_booking: id_booking,
               },
               success:function(response) {
                  var data = JSON.parse(response);
                  var data_url = data.list_url_ticket;


                  if (data.status == "error") {
                    $('.download-ticket').siblings(".submit-load-more.dowload-ticket").css({"z-index":"-1"});
                    $(".submit-load-more.sendmail").css({"z-index":"-1"});
                    $(".error").text(data.message).css({"display":"block","color":"#dc3545"});

                  }else{

                      data_url.map(function(item) {
                         var link = document.createElement('a');
                         link.href = item;
                         let name_ticket = item.slice(item.lastIndexOf("/") + 1);

                         link.download = name_ticket;
                         link.dispatchEvent(new MouseEvent('click'));
                         $(".submit-load-more.dowload-ticket").css({"z-index":"-1"});
                      });

                      /* delete file */
                      $.ajax({
                         url: ajax_object.ajax_url,
                         type: 'POST',
                         data: {
                            action: 'unlink_download_ticket',
                            data_url: data_url,
                         },
                         success:function(response) {

                         },
                      });

                  }

                  

               },
            })

         });
      },


      /* tab setting function */
      admin_setting_tab: function () {

         $('.ova_el_wrapper_content > div:not(:first)').hide();

         $(document).on('click', '.ova_el_settings_wrapper .nav-tab-wrapper a', function (e) {
            e.preventDefault();

            var a_tabs = $('.ova_el_settings_wrapper .nav-tab-wrapper a');
            a_tabs.removeClass('nav-tab-active');
            var _self = $(this),
            _tab_id = _self.attr('data-tab');

            _self.addClass('nav-tab-active');
            $('.ova_el_wrapper_content > div').hide();
            $('.ova_el_wrapper_content #' + _tab_id).fadeIn();

            return false;
         });


         $('#checkout > div:not(:first)').hide();
         $(document).on('click', '#checkout h3 a', function (e) {
            e.preventDefault();

            $('#checkout h3 a').removeClass('active');
            var _self = $(this),
            _data_id = _self.attr('id');

            _self.addClass('active');
            $('#checkout > div').hide();

            $('#checkout > div[data-tab-id^="' + _data_id + '"]').show();

         });

         $('#mail > div:not(:first)').hide();
         $(document).on('click', '#mail h3 a', function (e) {
            e.preventDefault();

            $('#mail h3 a').removeClass('active');
            var _self = $(this),
            _data_id = _self.attr('id');

            _self.addClass('active');
            $('#mail > div').hide();

            $('#mail > div[data-tab-id^="' + _data_id + '"]').show();

         });

         $('#event > div:not(:first)').hide();
         $(document).on('click', '#event h3 a', function (e) {
            e.preventDefault();

            $('#event h3 a').removeClass('active');
            var _self = $(this),
            _data_id = _self.attr('id');

            _self.addClass('active');
            $('#event > div').hide();

            $('#event > div[data-tab-id^="' + _data_id + '"]').show();

         });


      },


      /*** Upload Image ***/
      gallery_image: function() {
         var file_frame;
         $(document).on('click', '#mb_gallery a.gallery-add', function(e) {

            e.preventDefault();

            if (file_frame) file_frame.close();

            file_frame = wp.media.frames.file_frame = wp.media({
               title: $(this).data('uploader-title'),
               button: {
                  text: $(this).data('uploader-button-text'),
               },
               multiple: true
            });
            file_frame.on('select', function() {
               var listIndex = $('#gallery-metabox-list li').index($('#gallery-metabox-list li:last'));
               selection = file_frame.state().get('selection');
               var index;
               selection.map(function(attachment, i) {
                  attachment = attachment.toJSON();
                  index      = listIndex + (i + 1);
                  
                  if (attachment.sizes.el_thumbnail) {
                     $('#gallery-metabox-list').append('<li><input type="hidden" name="ova_mb_event_gallery[' + index + ']" value="' + attachment.id + '"><img class="image-preview" src="' + attachment.sizes.el_thumbnail.url + '"><a class="change-image button button-small" href="#" data-uploader-title="Change image" data-uploader-button-text="Change image">Change image</a><small><a class="remove-image" href="#">Remove image</a></small></li>');
                  } else {
                     $('#gallery-metabox-list').append('<li><input type="hidden" name="ova_mb_event_gallery[' + index + ']" value="' + attachment.id + '"><img class="image-preview" src="' + attachment.sizes.full.url + '"><a class="change-image button button-small" href="#" data-uploader-title="Change image" data-uploader-button-text="Change image">Change image</a><small><a class="remove-image" href="#">Remove image</a></small></li>');
                  }
               });
            });

            makeSortable_gallery();

            file_frame.open();
         });

         $(document).on('click', '#mb_gallery a.change-image', function(e) {

            e.preventDefault();

            var that = $(this);

            if (file_frame) file_frame.close();

            file_frame = wp.media.frames.file_frame = wp.media({
               title: $(this).data('uploader-title'),
               button: {
                  text: $(this).data('uploader-button-text'),
               },
               multiple: false
            });

            file_frame.on( 'select', function(attachment) {
               attachment = file_frame.state().get('selection').first().toJSON();

               that.parent().find('input:hidden').attr('value', attachment.id);
               if (attachment.sizes.el_thumbnail) {
                  that.parent().find('img.image-preview').attr('src', attachment.sizes.el_thumbnail.url);
               } else {
                  that.parent().find('img.image-preview').attr('src', attachment.sizes.full.url);
               }
            });

            file_frame.open();
         });

         /* resetIndex_gallery(); */
         function resetIndex_gallery() {
            $('#mb_gallery #gallery-metabox-list li').each(function(i) {
               $(this).find('input:hidden').attr('name', 'ova_mb_event_gallery[' + i + ']');
            });
         }
         

         function makeSortable_gallery() {
            $('#mb_gallery #gallery-metabox-list').sortable({
               opacity: 0.6,
               stop: function() {
                  resetIndex_gallery();
               }
            });
         }

         /* makeSortable_gallery(); */
         $(document).on('click', '#mb_gallery a.remove-image', function(e) {
            e.preventDefault();

            $(this).parents('li').animate({ opacity: 0 }, 200, function() {
               $(this).remove();
               resetIndex_gallery();
            });
         });
      },


      /* Edit Latitude Longitude */
      edit_full_address: function() {
         $(document).find('#edit_full_address').change( function() {
            var checked = $(this).prop('checked');
            if ( checked ) {
               $(this).val('checked');
               $(this).parents('.edit_address').find('.address').removeClass('readonly');
               $(this).parents('.edit_address').find('.address').removeAttr('readonly');
            } else {
               $(this).val('');
               $(this).parents('.edit_address').find('.address').attr('readonly', 'readonly').addClass('readonly');
            }
         });
      },


      /*** Map ***/
      map: function() {
         $.fn.event_map = function( paramObject ){

            paramObject = $.extend( { lat: -33.8688, lng: 151.2195, zoom: 17 }, paramObject );

            var map = new google.maps.Map(document.getElementById('admin_show_map'), {
               center: {
                  lat: paramObject.lat,
                  lng: paramObject.lng
               },
               zoom: paramObject.zoom,
               gestureHandling: 'cooperative'
            });

            var input = document.getElementById('pac-input');

            var autocomplete = new google.maps.places.Autocomplete(input);

            autocomplete.bindTo('bounds', map);

            map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

            var mapIWcontent = '';
            var infowindow = new google.maps.InfoWindow({
               content: mapIWcontent,
            });

            
            var marker = new google.maps.Marker({
               map: map,
               position: map.getCenter()
            });
            marker.addListener('click', function() {
               infowindow.open(map, marker);
            });

            autocomplete.addListener('place_changed', function() {
               infowindow.close();
               var place = autocomplete.getPlace();

               $('.edit_address .address').val($('#admin_show_map #pac-input').val());
               
               if (!place.geometry) {
                  return;
               }

               if (place.geometry.viewport) {
                  map.fitBounds(place.geometry.viewport);
               } else {
                  map.setCenter(place.geometry.location);
                  map.setZoom(17);
               }

               /* Set the position of the marker using the place ID and location. */
               marker.setPlace({
                  placeId: place.place_id,
                  location: place.geometry.location
               });
               marker.setVisible(true);
               

               $('#map_name').val(place.name);
               $('#map_address').val(place.formatted_address);

               $('#map_lat').val(place.geometry.location.lat());
               $('#map_lng').val(place.geometry.location.lng());

               infowindow.open(map, marker);
            });
         }

         if( typeof google !== 'undefined' && $("#admin_show_map").length > 0 ){
            var map_lat = parseFloat( $('input#map_lat').val() );
            var map_lng = parseFloat( $('input#map_lng').val() );

            $("#admin_show_map").event_map({ lat: map_lat, lng: map_lng, zoom: 17 });   
         }
      },


      /* Load Venue */
      el_load_venue: function() {

         $('#add_venue').autocomplete({
            source: function(request, response){
               var keyword = extractLast(request.term);

               $.ajax({
                  url: ajax_object.ajax_url,
                  type: 'POST',
                  dataType: "json",
                  data: {
                     action: 'el_load_venue',
                     keyword: keyword,
                  },
                  success:function(data) {
                     response(data);
                  },
               })
            },
            select: function( event, ui ) {
               var terms = split( $('#add_venue').val() );

               terms.pop();

               terms.push( ui.item.label );

               terms.push( "" );
               $('#add_venue').val(terms.join( ", " ));

               

               return false;
            },

            delay: 0,
         });

         function split( val ) {
            return val.split( /,\s*/ );
         }

         function extractLast( term ) {
            return split( term ).pop();
         }

         /* Check List Venue */
         $('.check_venue').on('click', function(e) {
            e.preventDefault();
            var that = $(this);
            var add_venue = that.closest('#mb_venue').find('#add_venue').val();

            var list_venue = [];
            that.closest('#mb_venue').find('#data_venue li').each(function() {
               list_venue += $(this).find('span').html();
               list_venue += ', ';

            });

            $.ajax({
               url: ajax_object.ajax_url,
               type: 'POST',
               data: {
                  action: 'el_load_checklist_venue',
                  add_venue: add_venue,
                  list_venue: list_venue,
               },
               success:function(data) {

                  that.closest('#mb_venue').find('#data_venue').html(data);
                  that.closest('#mb_venue').find('#add_venue').val('');
                  delete_venue();
               },
            })
         });

         function delete_venue() {
            $(document).find('.remove_venue').on('click', function(e) {
               e.preventDefault();
               $(this).parent().remove();
            });
         }
         delete_venue();
      },


      /*** Contact ***/
      contact: function() {
         var info_organizer = $('#info_organizer');
         var prefix = $('.prefix').val();

         if (info_organizer.attr('checked') == 'checked') {
            $('#show_rewrite').css('display', 'block');
         }

         info_organizer.change(function() {
            var checked = $(this).prop('checked');
            if (checked == true) {
               $(this).val('checked');
               $('#show_rewrite').css('display', 'block');
            } else {
               $(this).val('');
               $(this).removeAttr('checked');
               $('#show_rewrite').css('display', 'none');
            }
         });

         /* Add item social */
         $('#social_organizer .add_social').on('click', function(e){
            e.preventDefault();
            var index = 0;
            var index = $('#social_list .social_item').length;

            $.post( ajax_object.ajax_url, {
               action: 'mb_add_social',
               data: {
                  index: index,
               },
            }, function(response) {
               $('#social_list').append(response);
               resetIndex_social();
               makeSortable_social();
               $('select').select2({ width: '100%' });
            });
         });

         function resetIndex_social() {
            $('#social_list .social_item').each(function(i) {
               $(this).find('.link_social').attr('name', prefix+'social_organizer[' + i + '][link_social]');
               $(this).find('.icon_social').attr('name', prefix+'social_organizer[' + i + '][icon_social]');
            });
         }
         /* resetIndex_social(); */

         function makeSortable_social() {
            $('#social_list').sortable({
               opacity: 0.6,
               stop: function() {
                  resetIndex_social();
               }
            });
         }

         $(document).on('click', '#social_organizer .remove_social', function(e) {
            e.preventDefault();

            $(this).parents('.social_item').animate({ opacity: 0 }, 200, function() {
               $(this).remove();
               resetIndex_social();
            });
         });

         /* makeSortable_social(); */
      },


      /*** Date Time Picker ***/
      date_time_picker: function() {

         if($().datepicker) {
            $('.event_start_date, .event_end_date, .calendar_date, .calendar_end_date, .calendar_start_date, .coupon_start_date, .coupon_end_date, .start_ticket_date, .close_ticket_date, .disable_date .start_date, .disable_date .end_date, .start_ticket_date_map, .close_ticket_date_map, .date_cal').each(function(){
               var format = $(this).attr('data-format');

               $(this).datepicker({
                  dateFormat: format,
                  changeMonth : true,
                  changeYear: true,
                  minDate: 0,
               });
            }); 
         }

         if($().datepicker) {
            $('.range_datepicker.to, .range_datepicker.from').each(function(){
               var format = $(this).attr('data-format');
               $(this).datepicker({
                  dateFormat: format,
                  changeMonth : true,
                  changeYear: true,
               });
            }); 
         }

         if($().timepicker) {
            $('.event_start_time, .event_end_time, .calendar_start_time, .calendar_end_time, .calendar_recurrence_start_time, .calendar_recurrence_end_time, .coupon_start_time, .coupon_end_time, .start_ticket_time, .close_ticket_time, .start_ticket_time_map, .close_ticket_time_map').each(function(){

               if ($(this).attr('data-time') == '12') {
                  var time = 'hh:mm p'
               } else {
                  var time = 'HH:mm'
               }
               $(this).timepicker({
                  timeFormat: time,
                  interval: 15,
                  dynamic: false,
                  dropdown: true,
                  scrollbar: true
               });
            });
         }
      },


      /*** Radio Single Banner ***/
      radio_single_banner: function() {
         $('.single_banner').on('click', function(){
            var val = $(this).val()
            if (val == 'gallery' || val == 'video') {
               $(this).closest('.wrap_single_banner').find('.wrap_image_banner').css('display', 'none');
            } else {
               $(this).closest('.wrap_single_banner').find('.wrap_image_banner').css('display', 'block');
            }

         });
      },


      /*** Image Banner ***/
      image_banner: function() {

         /* Add Image Banner */
         $('.add_image_banner').on('click', function(e) {
            e.preventDefault();

            var that = $(this);

            var file_frame;
            if (file_frame) file_frame.close();

            file_frame = wp.media({
               title: $(this).data('uploader-title'),
               button: {
                  text: $(this).data('uploader-button-text'),
               },
               multiple: false
            });

            file_frame.on( 'select', function(attachment) {
               attachment = file_frame.state().get('selection').first().toJSON();

               that.parent().find('input').val(attachment.id);
               that.parent().find('.content_image').html('<img class="image-preview-banner" src="' + attachment.sizes.full.url + '" alt="image banner" style="max-height: 200px;"><button class="button remove_image_banner">Remove</button> ');
            });

            file_frame.open();
         });

         /* Remove Image Banner */
         $(document).on('click', '.remove_image_banner', function(e) {
            e.preventDefault();
            $(this).closest('.image_banner').find('input').val('');
            $(this).parent().empty();
         });
      },


      /*** Add Image Ticket ***/
      add_image_ticket: function() {
         var file_frame;
         $(document).on( 'click','#mb_ticket .add_image_ticket', function(e) {
            e.preventDefault();
            var that = $(this);

            if (file_frame) file_frame.close();

            file_frame = wp.media.frames.file_frame = wp.media({
               multiple: false
            });
            file_frame.on('select', function() {
               var index = that.parent().data('index'),
               selection = file_frame.state().get('selection');

               selection.map(function(attachment) {
                  attachment = attachment.toJSON();

                  if (attachment.sizes.el_thumbnail) {
                     $(that).html('<input type="hidden" name="ova_mb_event_ticket['+index+'][image_ticket]" id="image_ticket" value="' + attachment.id + '"><img class="image-preview-ticket" src="' + attachment.sizes.el_thumbnail.url + '" alt="image ticket">');
                     $(that).parent().find('.remove_image_ticket').html('<span>x</span>');
                  } else {
                     $(that).html('<input type="hidden" name="ova_mb_event_ticket['+index+'][image_ticket]" id="image_ticket" value="' + attachment.id + '"><img class="image-preview-ticket" src="' + attachment.sizes.full.url + '" alt="image ticket">');
                     $(that).parent().find('.remove_image_ticket').html('<span>x</span>');
                  }
               });
            });
            file_frame.open(that);
            return false;
         })
      },


      /*** Add Image Ticket ***/
      add_image_ticket_map: function() {
         var file_frame;
         $(document).on( 'click','#mb_ticket .add_image_ticket_map', function(e) {
            e.preventDefault();
            var that = $(this);

            if (file_frame) file_frame.close();

            file_frame = wp.media.frames.file_frame = wp.media({
               multiple: false
            });
            file_frame.on('select', function() {
               selection = file_frame.state().get('selection');

               selection.map(function(attachment) {
                  attachment = attachment.toJSON();

                  if (attachment.sizes.el_thumbnail) {
                     $(that).html('<input type="hidden" name="ova_mb_event_ticket_map[image_ticket]" class="image_ticket_map" value="' + attachment.id + '"><img class="image-preview-ticket" src="' + attachment.sizes.el_thumbnail.url + '" alt="image ticket">');
                     $(that).parent().find('.remove_image_ticket_map').html('<span>x</span>');
                  } else {
                     $(that).html('<input type="hidden" name="ova_mb_event_ticket_map[image_ticket]" class="image_ticket_map" value="' + attachment.id + '"><img class="image-preview-ticket" src="' + attachment.sizes.full.url + '" alt="image ticket">');
                     $(that).parent().find('.remove_image_ticket_map').html('<span>x</span>');
                  }
               });
            });
            file_frame.open(that);
            return false;
         })
      },

      /*** Remove Image Ticket ***/
      remove_image_ticket_map: function() {
         $(document).on( 'click', '.remove_image_ticket_map', function(e) {
            e.preventDefault();
            var answer = confirm('Are you sure?');
            var index = $(this).parent().data('index');
            if (answer == true) {
               $(this).empty();
               $(this).parent().find('.add_image_ticket_map').html('<i class="icon_plus_alt2"></i>Add ticket logo (.jpg, .png)<br><span>Recommended size: 130x50px</span>');
            }
            return false;
         });
      },


      /*** Radio seat option ***/
      radio_seat_option: function(){
         $('.seat_option').click(function() {

            val = $(this).val();

            if ( val == 'map' ) {
               $(this).parents('#mb_ticket').find('.ticket_none_simple').css('display', 'none');
               $(this).parents('#mb_ticket').find('.ticket_map').css('display', 'block');
               $(this).parents('#mb_ticket').find('.add_ticket').css('display', 'none');

            } else {
               $(this).parents('#mb_ticket').find('.add_ticket').css('display', 'block');
               $(this).parents('#mb_ticket').find('.ticket_none_simple').css('display', 'block');
               $(this).parents('#mb_ticket').find('.ticket_map').css('display', 'none');
               if( val == 'simple' ) {
                  $(this).parents('#mb_ticket').find('.wrap_seat_list').css('display', 'flex');
                  $(this).parents('#mb_ticket').find('.wrap_setup_seat').css('display', 'flex');
               } else {
                  $(this).parents('#mb_ticket').find('.wrap_seat_list').css('display', 'none');
                  $(this).parents('#mb_ticket').find('.wrap_setup_seat').css('display', 'none');
               }
            }

            $(this).parents('#mb_ticket').find('.add_ticket').attr('data-seat_option', val);
         });
      },


      radio_type_price: function() {
         $(document).find('.type_price').click(function(){
            $(this).closest('.col_price_ticket').find('#price_ticket').removeAttr('disabled');
            $(this).closest('.col_price_ticket').find('#price_ticket').css('display', 'block');

            var val = $(this).val();
            if (val == 'free') {
               $(this).closest('.col_price_ticket').find('#price_ticket').attr({'value': '0', 'disabled': 'disabled'});
            }
         });
      },


      /*** Remove Image Ticket ***/
      remove_image_ticket: function() {
         $(document).on( 'click', '.remove_image_ticket', function(e) {
            e.preventDefault();
            var answer = confirm('Are you sure?');
            var index = $(this).parent().data('index');
            if (answer == true) {
               $(this).empty();
               $(this).parent().find('.add_image_ticket').html('<i class="icon_plus_alt2"></i>Add ticket logo (.jpg, .png)<br><span>Recommended size: 130x50px</span>');
            }
            return false;
         });
      },


      /*** Color Picker Ticket ***/
      color_picker_ticket: function() {
         if ( $('.color_ticket').length > 0 ) {
            $('.color_ticket').wpColorPicker();
         }

         if ( $('.color_label_ticket').length > 0 ) {
            $('.color_label_ticket').wpColorPicker();
         }

         if ( $('.color_content_ticket').length > 0 ) {
            $('.color_content_ticket').wpColorPicker();
         }

         if ( $('.map_color_type_seat').length > 0 ) {
            $('.map_color_type_seat').wpColorPicker();
         }

         if ( $('.color_label_ticket_map').length > 0 ) {
            $('.color_label_ticket_map').wpColorPicker();
         }

         if ( $('.color_ticket_map').length > 0 ) {
            $('.color_ticket_map').wpColorPicker();
         }

         if ( $('.color_content_ticket_map').length > 0 ) {
            $('.color_content_ticket_map').wpColorPicker();
         }
      },


      /*** Toggle Ticket ***/
      toggle_ticket: function() {

         $(document).on( "click", '#mb_ticket .edit_ticket, #mb_ticket .save_ticket', function(e){
            e.preventDefault();

            $(this).closest('.ticket_item').find(".content_ticket").toggle();
            if ($(this).closest('.ticket_item').find('.content_ticket').css('display') == 'none') {
               $(this).closest('.ticket_item').find('.heading_ticket').css('border-radius', '10px');
            } else {
               $(this).closest('.ticket_item').find('.heading_ticket').css('border-radius', '10px 10px 0 0');
            }
            return false;
         });

         $(document).find('a[href="#mb_ticket"]').on( "click", function(){
            $(this).closest('#tabs, .content').find(".content_ticket").css('display', 'none');
            if ($(this).closest('#tabs, .content').find('.content_ticket').css('display') == 'none') {
               $(this).closest('#tabs, .content').find('.heading_ticket').css('border-radius', '10px');
            } else {
               $(this).closest('#tabs, .content').find('.heading_ticket').css('border-radius', '10px 10px 0 0');
            }
            return false;
         });
      },


      /*** Add Ticket ***/
      add_ticket: function() {
         $('#mb_ticket .add_ticket').on('click', function(e){
            e.preventDefault();
            var that = $(this);
            that.find('.submit-load-more').css('z-index', '9');

            EL_Admin.radio_seat_option();
            var count_tickets = EL_Admin.count_tickets();
            var event_id = $(this).data('event_id');
            var seat_option = $(document).find('.add_ticket').attr('data-seat_option');

            $.post( ajax_object.ajax_url, {
               action: 'mb_add_ticket',
               data: {
                  event_id: event_id,
                  count_tickets: count_tickets,
                  seat_option: seat_option,
               },
            }, function(response) {
               that.find('.submit-load-more').css('z-index', '-1');
               $('#mb_ticket .ticket_none_simple').append(response);
               EL_Admin.radio_type_price();
               EL_Admin.color_picker_ticket();
               EL_Admin.date_time_picker();
               EL_Admin.repair_key_ticket();
            });

         });
      },


      /*** Add Seat Map ***/
      add_seat_map: function() {
         $('#mb_ticket .add_seat_map').on('click', function(e){
            e.preventDefault();
            var that = $(this);
            that.find('.submit-load-more').css('z-index', '9');

            EL_Admin.radio_seat_option();
            var count_seat = $(document).find('#mb_ticket .item_seat').length;
            console.log(count_seat);

            $.post( ajax_object.ajax_url, {
               action: 'add_seat_map',
               data: {
                  count_seat: count_seat,
               },
            }, function(response) {
               that.find('.submit-load-more').css('z-index', '-1');
               $('#mb_ticket .wrap_seat_map').append(response);
               remove_seat_map();
               sortable_seat_map();
            });

         });

         function remove_seat_map() {
            $(document).on('click', '.remove_seat_map', function(e){
               e.preventDefault();
               $(this).closest('.item_seat').remove();
               sortable_seat_map();
            });
         }
         remove_seat_map();

         function sortable_seat_map() {
            var i = 0;

            $('#mb_ticket .item_seat').each(function(){

               var prefix = $(this).data('prefix');

               $(this).find( '.map_name_seat' ).attr( 'name', prefix+'ticket_map[seat]['+i+'][id]' );
               $(this).find( '.map_price_seat' ).attr( 'name', prefix+'ticket_map[seat]['+i+'][price]' );
               i++;
            });
         }
      },


      /*** Add Description Seat Map ***/
      add_desc_seat_map: function() {
         $('#mb_ticket .add_desc_seat_map').on('click', function(e){
            e.preventDefault();
            var that = $(this);
            that.find('.submit-load-more').css('z-index', '9');

            EL_Admin.radio_seat_option();
            var count_seat = $(document).find('#mb_ticket .item_desc_seat').length;
            console.log(count_seat);

            $.post( ajax_object.ajax_url, {
               action: 'add_desc_seat_map',
               data: {
                  count_seat: count_seat,
               },
            }, function(response) {
               that.find('.submit-load-more').css('z-index', '-1');
               $('#mb_ticket .wrap_desc_seat_map').append(response);
               remove_desc_seat_map();
               sortable_desc_seat_map();
               EL_Admin.color_picker_ticket();
            });

         });

         function remove_desc_seat_map() {
            $(document).on('click', '.remove_desc_seat_map', function(e){
               e.preventDefault();
               $(this).closest('.item_desc_seat').remove();
               sortable_desc_seat_map();
            });
         }
         remove_desc_seat_map();

         function sortable_desc_seat_map() {
            var i = 0;

            $('#mb_ticket .item_desc_seat').each(function(){

               var prefix = $(this).data('prefix');

               $(this).find( '.map_type_seat' ).attr( 'name', prefix+'ticket_map[desc_seat]['+i+'][map_type_seat]' );
               $(this).find( '.map_price_type_seat' ).attr( 'name', prefix+'ticket_map[desc_seat]['+i+'][map_price_type_seat]' );
               $(this).find( '.map_desc_type_seat' ).attr( 'name', prefix+'ticket_map[desc_seat]['+i+'][map_desc_type_seat]' );
               $(this).find( '.map_color_type_seat' ).attr( 'name', prefix+'ticket_map[desc_seat]['+i+'][map_color_type_seat]' );

               i++;
            });
         }
      },


      /*** Sortable Ticket ***/
      sortable_ticket: function(){
      },


      /*** Count Ticket ***/
      count_tickets: function(){
         var count = $('#mb_ticket .ticket_item').length;
         return count;
      },


      /*** Repair Key Ticket ***/
      repair_key_ticket: function() {
         var count_tickets = EL_Admin.count_tickets();
         var i = 0;

         $('#mb_ticket .ticket_item').each(function(){

            var prefix = $(this).data('prefix');

            $(this).find( '#ticket_id' ).attr( 'name', prefix+'ticket['+i+'][ticket_id]' );
            $(this).find( '#name_ticket' ).attr( 'name', prefix+'ticket['+i+'][name_ticket]' );
            $(this).find( '.type_price' ).attr( 'name', prefix+'ticket['+i+'][type_price]' );
            $(this).find( '#price_ticket' ).attr( 'name', prefix+'ticket['+i+'][price_ticket]' );
            $(this).find( '#number_total_ticket' ).attr( 'name', prefix+'ticket['+i+'][number_total_ticket]' );
            $(this).find( '#number_min_ticket' ).attr( 'name', prefix+'ticket['+i+'][number_min_ticket]' );
            $(this).find( '#number_max_ticket' ).attr( 'name', prefix+'ticket['+i+'][number_max_ticket]' );
            $(this).find( '.start_ticket_date' ).attr( 'name', prefix+'ticket['+i+'][start_ticket_date]' );
            $(this).find( '#start_ticket_time' ).attr( 'name', prefix+'ticket['+i+'][start_ticket_time]' );
            $(this).find( '.close_ticket_date' ).attr( 'name', prefix+'ticket['+i+'][close_ticket_date]' );
            $(this).find( '#close_ticket_time' ).attr( 'name', prefix+'ticket['+i+'][close_ticket_time]' );
            $(this).find( '#color_ticket' ).attr( 'name', prefix+'ticket['+i+'][color_ticket]' );
            $(this).find( '#color_label_ticket' ).attr( 'name', prefix+'ticket['+i+'][color_label_ticket]' );
            $(this).find( '#color_content_ticket' ).attr( 'name', prefix+'ticket['+i+'][color_content_ticket]' );
            $(this).find( '#desc_ticket' ).attr( 'name', prefix+'ticket['+i+'][desc_ticket]' );
            $(this).find( '#image_ticket' ).attr( 'name', prefix+'ticket['+i+'][image_ticket]' );
            $(this).find( '.setup_seat' ).attr( 'name', prefix+'ticket['+i+'][setup_seat]' );

            i++;
         });

         EL_Admin.radio_checked_ticket();
      },


      radio_checked_ticket: function() {
         $("#mb_ticket .ticket_item").find("input:radio:checked").each(function () {
            $(this).attr("data-checked", "true");
            $(this).prop("checked", true);
            $(this).trigger( 'click' );
         });
      },


      /*** Repair Key Ticket ***/
      remove_ticket: function() {
         $(document).on('click', '.delete_ticket', function(){
            $(this).closest('.ticket_item').remove();
            EL_Admin.repair_key_ticket();
         });
      },


      /*** Calendar ***/
      calendar: function() {

         // Add calendar
         $('.calendar .add_calendar').on('click', function(e){
            e.preventDefault();
            var that = $(this);

            var index = 0;
            var index = that.parent().find('.item_calendar').length;
            
            that.find('.submit-load-more').css('z-index', '9');

            $.post( ajax_object.ajax_url, {
               action: 'mb_add_calendar',
               data: {
                  index: index,
               },
            }, function(response) {
               that.find('.submit-load-more').css('z-index', '-1');
               $('.list_calendar').append(response);
               resetIndex_calendar();
               makeSortable_calendar();
               EL_Admin.date_time_picker();
            });
         });

         /* Reset index calendar */
         function resetIndex_calendar() {
            var i = 0;
            $('.calendar .item_calendar').each(function() {
               $(this).find('.calendar_id').attr('name', 'ova_mb_event_calendar[' + i + '][calendar_id]');
               $(this).find('.calendar_date').attr('name', 'ova_mb_event_calendar[' + i + '][date]');
               $(this).find('.calendar_start_time').attr('name', 'ova_mb_event_calendar[' + i + '][start_time]');
               $(this).find('.calendar_end_time').attr('name', 'ova_mb_event_calendar[' + i + '][end_time]');

               i++;
            });
         }
         resetIndex_calendar();


         /* Make Sortable calendar */
         function makeSortable_calendar() {
            if ($('.list_calendar').length > 0 && $(window).width() > 767.98 ) {
               $('.list_calendar').sortable({
                  opacity: 0.6,
                  stop: function() {
                     resetIndex_calendar();
                  }
               });
            }
         }

         /* Remove calendar */
         $(document).on('click', '.calendar .remove_calendar', function(e) {
            e.preventDefault();

            $(this).parent().animate({ opacity: 0 }, 200, function() {
               $(this).remove();
               resetIndex_calendar();
            });
         });

         makeSortable_calendar();

         $(document).find('.option_calendar input').click( function() {
            var val = $(this).val();
            if (val !== 'auto') {
               $(this).closest('.calendar').find('.manual').css('display', 'block');
               $(this).closest('.calendar').find('.auto').css('display', 'none');
               $(this).closest('.calendar').find('.calendar_recurrence_start_time, .calendar_recurrence_end_time, .calendar_start_date, .calendar_end_date').removeAttr('required');
            } else {
               $(this).closest('.calendar').find('.manual').css('display', 'none');
               $(this).closest('.calendar').find('.auto').css('display', 'block');
               $(this).closest('.calendar').find('.calendar_recurrence_start_time, .calendar_recurrence_end_time, .calendar_start_date, .calendar_end_date').attr('required', 'required');
            }
         });

         function updateIntervalDescriptor () { 
            $(".interval-desc").hide();
            var number = "-plural";
            if ($('input#recurrence-interval').val() == 1 || $('input#recurrence-interval').val() == "") number = "-singular";
            var descriptor = "span#interval-"+$("select#recurrence-frequency").val()+number;
            $(descriptor).show();
         }

         function updateIntervalSelectors () {
            $('.alternate-selector').hide();   
            $('#'+ $('select#recurrence-frequency').val() + "-selector").show();
            $('#'+ $('select#recurrence-frequency').val() + "-selector").css('display', 'inline-block');
         }

         updateIntervalDescriptor();
         updateIntervalSelectors();

         $('input#recurrence-interval').keyup(updateIntervalDescriptor);
         $('select#recurrence-frequency').change(updateIntervalDescriptor);
         $('select#recurrence-frequency').change(updateIntervalSelectors);

         /* Disable Date */
         function disable_date() {
            $('.disable_date .add_disable_date').click( function(e) {
               e.preventDefault();
               var that = $(this);

               var index = 0;
               var index = that.parents('.disable_date').find('.item_disable_date').length;

               that.find('.submit-load-more').css('z-index', '9');

               $.post( ajax_object.ajax_url, {
                  action: 'mb_add_disable_date',
                  data: {
                     index: index,
                  },
               }, function(response) {
                  that.find('.submit-load-more').css('z-index', '-1');
                  $('.wrap_disable_date').append(response);
                  EL_Admin.date_time_picker();
               });
            });
         }
         disable_date();

         /* Reset Index Disable Date */
         function resetIndex_disable_date() {
            var i = 0;
            $('.calendar .item_disable_date').each(function() {
               $(this).find('.start_date').attr('name', 'ova_mb_event_disable_date[' + i + '][start_date]');
               $(this).find('.end_date').attr('name', 'ova_mb_event_disable_date[' + i + '][end_date]');

               i++;
            });
         }

         /* Remove Disable Date */
         $(document).on('click', '.disable_date .remove_disable_date', function(e) {
            e.preventDefault();

            $(this).parents('.item_disable_date').animate({ opacity: 0 }, 200, function() {
               $(this).remove();
               resetIndex_disable_date();
            });
         });
      },


      /*** Coupon ***/
      coupon: function() {

         // Add coupon
         $('.coupon .add_coupon').on('click', function(e){
            e.preventDefault();
            var that = $(this);
            var index = 0;
            var index = that.parent().find('.item_coupon').length;
            var post_id = that.data('post_id');
            that.find('.submit-load-more').css('z-index', '9');

            $.post( ajax_object.ajax_url, {
               action: 'mb_add_coupon',
               data: {
                  index: index,
                  post_id: post_id,
               },
            }, function(response) {
               that.find('.submit-load-more').css('z-index', '-1');
               $('.list_coupon').append(response);
               resetIndex_coupon();
               makeSortable_coupon();
               EL_Admin.date_time_picker();
               checkAllTicket_coupon();
               checkTicket_coupon();
            });
         });

         /* Reset index coupon */
         function resetIndex_coupon() {
            var i = 0;
            $('.coupon .item_coupon').each(function() {
               $(this).find('.coupon_id').attr('name', 'ova_mb_event_coupon[' + i + '][coupon_id]');
               $(this).find('.discount_code').attr('name', 'ova_mb_event_coupon[' + i + '][discount_code]');
               $(this).find('.discount_amout_number').attr('name', 'ova_mb_event_coupon[' + i + '][discount_amout_number]');
               $(this).find('.discount_amount_percent').attr('name', 'ova_mb_event_coupon[' + i + '][discount_amount_percent]');
               $(this).find('.coupon_start_date').attr('name', 'ova_mb_event_coupon[' + i + '][start_date]');
               $(this).find('.coupon_end_date').attr('name', 'ova_mb_event_coupon[' + i + '][end_date]');
               $(this).find('.coupon_start_time').attr('name', 'ova_mb_event_coupon[' + i + '][start_time]');
               $(this).find('.coupon_end_time').attr('name', 'ova_mb_event_coupon[' + i + '][end_time]');
               $(this).find('.coupon_all_ticket').attr('name', 'ova_mb_event_coupon[' + i + '][all_ticket]');
               $(this).find('.coupon_quantity').attr('name', 'ova_mb_event_coupon[' + i + '][quantity]');

               var k = 0;
               $(this).find('.item_ticket').each(function() {
                  $(this).find('.list_ticket').attr('name', 'ova_mb_event_coupon[' + i + '][list_ticket]['+k+']');
                  k++;
               });
               
               i++;
            });
         }
         resetIndex_coupon();


         /* Make Sortable coupon */
         function makeSortable_coupon() {
            if ($('.list_coupon').length > 0 && $(window).width() > 767.98 ) {
               $('.list_coupon').sortable({
                  opacity: 0.6,
                  stop: function() {
                     resetIndex_coupon();
                  }
               });
            }
         }

         /* Remove coupon */
         $(document).on('click', '.coupon .remove_coupon', function(e) {
            e.preventDefault();

            $(this).parent().animate({ opacity: 0 }, 200, function() {
               $(this).remove();
               resetIndex_coupon();
            });
         });

         makeSortable_coupon();


         /* Check tick all ticket */
         function checkAllTicket_coupon(){
            $(document).find('.coupon_all_ticket').change(function() {
               var checked = $(this).prop('checked');
               
               if (checked) {
                  $(this).val('checked');
               } else {
                  $(this).val('');
               }

               if (checked) {

                  $(this).closest('.number_coupon_ticket').find('.item_ticket input').attr('checked', 'checked');
               } else {

                  $(this).closest('.number_coupon_ticket').find('.item_ticket input').removeAttr('checked');
               }
            });
         }
         checkAllTicket_coupon();

         /* Check tick ticket */
         function checkTicket_coupon() {
            $(document).find('.number_coupon_ticket .item_ticket input').change(function() {
               var checked = $(this).prop('checked');
               if (checked) {
                  $(this).attr('checked', 'checked');
               } else {
                  $(this).removeAttr('checked');
               }

               var count = $(this).closest('.wrap_list_ticket').find('.item_ticket').length;
               var count_selected = $(this).closest('.wrap_list_ticket').find('input:checked').length;
               
               if (count == count_selected) {
                  $(this).closest('.number_coupon_ticket').find('.coupon_all_ticket').val('checked');
                  $(this).closest('.number_coupon_ticket').find('.coupon_all_ticket').attr('checked', 'checked');
               } else {
                  $(this).closest('.number_coupon_ticket').find('.coupon_all_ticket').val('');
                  $(this).closest('.number_coupon_ticket').find('.coupon_all_ticket').removeAttr('checked');
               }

            });
         }
         checkTicket_coupon();

         /* Check after add new ticket */
         function loadCheckTicket() {
            $(document).find('.item_coupon').each(function() {
               var that = $(this).find('.number_coupon_ticket .item_ticket');
               var length = that.find('input').length;
               var length_checked = that.find('input:checked').length;
               if (length == length_checked) {
                  that.closest('.number_coupon_ticket').find('.coupon_all_ticket').val('checked');
                  that.closest('.number_coupon_ticket').find('.coupon_all_ticket').attr('checked', 'checked');
               } else {
                  that.closest('.number_coupon_ticket').find('.coupon_all_ticket').val('');
                  that.closest('.number_coupon_ticket').find('.coupon_all_ticket').removeAttr('checked');
               }
            });
         }
         loadCheckTicket();
      },


      /*** Image Category ***/
      add_image_category: function(){

         $(document).on('click', '.term-image-wrap .gallery-add', function( event ){
            let that = $(this);
            let file_frame;
            event.preventDefault();

            if ( file_frame ) {
               file_frame.open();
               return;
            }

            file_frame = wp.media.frames.file_frame = wp.media({
               title: that.data( 'uploader-title' ),
               button: {
                  text: that.data( 'uploader-button-text' ),
               },
               multiple: false
            });

            file_frame.on( 'select', function() {
               attachment = file_frame.state().get('selection').first().toJSON();

               if (attachment.sizes.el_img_rec) {
                  $(that).parent().find('.wrap_image_cat').html('<input type="hidden" name="_category_image" class="image_category" value="' + attachment.id + '"><img class="image-preview" src="' + attachment.sizes.el_img_rec.url + '" alt="Banner Category"><small><a class="remove-image" href="#">Remove image</a></small>');
               } else {
                  $(that).parent().find('.wrap_image_cat').html('<input type="hidden" name="_category_image" class="image_category" value="' + attachment.id + '"><img class="image-preview" src="' + attachment.sizes.full.url + '" alt="Banner Category"><small><a class="remove-image" href="#">Remove image</a></small>');
               }
            });

            file_frame.open();
         });
      },
      remove_image_category: function(){
         $(document).on('click', '.wrap_image_cat .remove-image', function( event ){
            let that = $(this);
            event.preventDefault();

            that.parents('.wrap_image_cat').html('<input type="hidden" name="_category_image" class="image_category" value=""><img class="image-preview" src="" alt="">');
         });
      },

      add_custom_booking: function(){


         /* Add item for cart */
         $('.el_booking_detail .cart-total a').on('click', function(e){
            e.preventDefault();
            var that = $(this);
            var index = 0;
            var type_seat = that.parents('.el_booking_detail').find('.seat_option_type').val();
            var index = $(document).find('.el_booking_detail .cart-item').length;
            $.post( ajax_object.ajax_url, {
               action: 'add_custom_booking',
               data: {
                  type_seat: type_seat,
                  index: index
               }
            }, function(response) {
               $('.el_booking_detail .cart tbody').append(response);
            });
         });

         // Remove item booking
         $(document).on('click', '.el_booking_detail .delete_item', function( event ){
            let that = $(this);
            event.preventDefault();

            that.parents('.cart-item').remove();
         });

         function repair_key_item() {
            var i = 0;
            var prefix = $('.el_booking_detail .seat_option_type').data('prefix');
            var seat_type = $('.el_booking_detail .seat_option_type').val();
            $('.el_booking_detail .cart-item').each(function(){
               if (seat_type == 'map') {
                  $(this).find( 'input.name' ).attr( 'name', prefix+'cart['+i+'][id]' );
                  $(this).find( 'input.qty' ).attr( 'name', prefix+'cart['+i+'][qty]' );
                  $(this).find( 'input.seat' ).attr( 'name', prefix+'cart['+i+'][seat]' );
                  $(this).find( 'input.price' ).attr( 'name', prefix+'cart['+i+'][price]' );
               } else {
                  $(this).find( 'input.name' ).attr( 'name', prefix+'cart['+i+'][name]' );
                  $(this).find( 'input.qty' ).attr( 'name', prefix+'cart['+i+'][qty]' );
                  $(this).find( 'input.seat' ).attr( 'name', prefix+'cart['+i+'][seat]' );
                  $(this).find( 'input.price' ).attr( 'name', prefix+'cart['+i+'][price]' );
               }
               i++;
            });
         }
         /* /Add item for cart */

         
         // Show Calendar
         $(document).on('change', '.el_booking_detail .id_event', function( e ){
            
            var that = $(this);
            var id_event = that.val();
            var id_cal = $('.el_booking_detail .id_cal').data('id_cal');
            e.preventDefault();
            $.post( ajax_object.ajax_url, {
               action: 'el_get_idcal_seatopt',
               data: {
                  id_event: id_event,
                  id_cal: id_cal
                  
               }
            }, function(response) {
               $('.el_booking_detail .id_cal').html(response);
               var seat_option = $('.el_booking_detail .seat_option').val();
               $( '.el_booking_detail .seat_option_type' ).val( seat_option );
               $('.el_booking_detail .cart tbody').html('');

               var $html_head_cart = '';
               if( seat_option  == 'none' || seat_option  == 'simple' ){
                  
                  var name = $( '.el_booking_detail .detail_booking_head_cart' ).data( 'name' );
                  var qty = $( '.el_booking_detail .detail_booking_head_cart' ).data( 'qty' );
                  var sub_total = $( '.el_booking_detail .detail_booking_head_cart' ).data( 'sub_total' );

                  $html_head_cart = '<tr><th class="name">'+name+'</th><th class="qty">'+qty+'</th><th class="sub-total">'+sub_total+'</th></tr>';   

               }else if( seat_option  == 'map' ){

                  var name_map = $( '.el_booking_detail .detail_booking_head_cart' ).data( 'name' );
                  var sub_total_map = $( '.el_booking_detail .detail_booking_head_cart' ).data( 'sub_total' );

                  $html_head_cart = '<tr><th>'+name_map+'</th><th>'+sub_total_map+'</th></tr>';

               }
               
               $('.el_booking_detail .cart thead').html($html_head_cart);

            });

           

         });

      },

      el_datepicker: function(){
         if($().datepicker) {
            $('.membership_date').each(function(){
               var format = $(this).attr('data-format');

               $(this).datepicker({
                  dateFormat: format,
                  changeMonth : true,
                  changeYear: true,
               });
            }); 
         }
      }

   };

   
   $(document).ready(function () {
      EL_Admin.init();
   });

})(jQuery);