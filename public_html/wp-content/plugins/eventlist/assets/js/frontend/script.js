(function($) {
   "use strict";
   /* object js */
   var EL_Frontend = {
      init: function() {
         
         
         $('.content, #tabs').tabs();         

         $('select').select2({
            width: '100%'
         });
         this.ticket_info_according();
         this.cart_ticket_event();
         this.cart_discount();
         this.cart_change_customer_info();
         this.cart_edit_button();
         this.cart_payment_according();

         // detail
         this.event_calendar();
         this.comment_rating();
         this.slide_event_related();
         this.slide_event_single_gallery();
         this.banner_event_single();
         this.el_show_more_desc();

         this.image_profile();
         this.update_profile();
         this.update_role();

         this.add_social();
         this.save_social();
         this.remove_social();
         this.repair_key_social();

         this.check_password();
         this.change_password();
         this.view_password();

         this.select_event();
         this.el_pending_post();
         this.el_publish_post();
         this.el_trash_post();
         this.el_delete_post();
         this.el_bulk_action();

         // Edit post
         this.edit_lat_lng();
         this.cut_string_cat();
         this.image_feature();
         this.add_image_gallery();
         this.change_image_gallery();
         this.remove_image_gallery();
         this.el_load_location();
         this.el_save_edit_event();

         // Checkout
         this.process_checkout();

         this.cart_next_step();

         //export csv booking
         this.export_csv();

         //export csv ticket
         this.export_csv_ticket();

         // package
         this.add_package();

         this.update_wishlist();
         this.remove_wishlist();
         

         // Bank
         this.update_bank();

         // Search
         this.el_load_venue_search();
         this.datepicket_search();
         this.el_load_location_search();
         this.el_search_map();

         // Event Detail Map 
         this.event_map();

         //send mail
         this.el_single_send_mail_vendor();

         //send mail report
         this.el_single_send_mail_report();

         this.el_single_click_book();
         this.el_single_gallery();

         //menu vendor 
         this.el_menu_mobile();

         // event type
         this.el_choose_event_type();

         // link ticket
         this.el_choose_link_ticket();

         // cancel booking
         this.el_enable_cancellation_booking();

         this.el_tooltip();

         this.el_update_ticket_status();

         // Cancel
         this.el_cancel_booking();
      },

      el_update_ticket_status: function(){

         $('.update_ticket_status').on('click', function(e) {


            e.preventDefault();

            var that = $(this);

            $(this).closest('td').append( '<div class="el_loader"></div>' );
            $(this).hide();
         
            var qr_code = $(this).data('qr_code');
           

            $.post(ajax_object.ajax_url, {
               action: 'el_update_ticket_status',
               data: {
                  qr_code: qr_code,
               },
            }, function(response) {

               var res = JSON.parse(response);
               if(res.status == 'valid' ){

                  alert( res.msg_show );
                  that.closest('td').append( '<span class="update_ticket_success">'+res.msg_show+'</span>' );
                  that.closest('td').find('.el_loader').remove();
                  

               }else{
                  alert( res.msg );
               }

            });
         });
      },

      el_tooltip: function(){
         $(function () {
           $('[data-toggle="tooltip"]').tooltip()
         })
      },
      

      el_choose_event_type: function(){

         if( $( "input[name='ova_mb_event_event_type']" ).length > 0 ){

            var event_type = $("input[name='ova_mb_event_event_type']:checked").val();

            if( event_type == 'online' ){
               $( ".vendor_edit_event .location" ).hide();
               $( ".vendor_edit_event" ).addClass('online_event');
            }else if( event_type == 'classic' ){
               $( ".vendor_edit_event .location" ).show();
               $( ".vendor_edit_event" ).removeClass('online_event');
            }

            $( "input[name='ova_mb_event_event_type']" ).on( 'click', function(){

               event_type = $("input[name='ova_mb_event_event_type']:checked").val();
                
               if( event_type == 'online' ){
                  $( ".vendor_edit_event .location" ).hide();
                  $( ".vendor_edit_event" ).addClass('online_event');
                  
               }else if( event_type == 'classic' ){
                  $( ".vendor_edit_event .location" ).show();
                  $( ".vendor_edit_event" ).removeClass('online_event');
                  
               }

            });



         }
      },

      el_choose_link_ticket: function(){

         if( $( "input[name='ova_mb_event_ticket_link']" ).length > 0 ){

            var ticket_link = $("input[name='ova_mb_event_ticket_link']:checked").val();

            if( ticket_link == 'ticket_internal_link' ){
               $( ".vendor_edit_event .ticket_internal_link" ).show();
               $( ".vendor_edit_event .ticket_external_link" ).hide();
            }else if( ticket_link == 'ticket_external_link' ){
               $( ".vendor_edit_event .ticket_internal_link" ).hide();
               $( ".vendor_edit_event .ticket_external_link" ).show();
            }

            $( "input[name='ova_mb_event_ticket_link']" ).on( 'click', function(){

               ticket_link = $("input[name='ova_mb_event_ticket_link']:checked").val();
                
               if( ticket_link == 'ticket_internal_link' ){
                  $( ".vendor_edit_event .ticket_internal_link" ).show();
                  $( ".vendor_edit_event .ticket_external_link" ).hide();
               }else if( ticket_link == 'ticket_external_link' ){
                  $( ".vendor_edit_event .ticket_internal_link" ).hide();
                  $( ".vendor_edit_event .ticket_external_link" ).show();
               }

            });



         }
      },

      el_enable_cancellation_booking:function(){
         if( $( "input[name='ova_mb_event_allow_cancellation_booking']" ).length > 0 ){

            var allow_cancel_bk = $("input[name='ova_mb_event_allow_cancellation_booking']:checked").val();

            if( allow_cancel_bk == 'yes' ){
               $( ".vendor_edit_event .cancel_bk_before_x_day" ).show();
               
            }else if( allow_cancel_bk == 'no' ){
               $( ".vendor_edit_event .cancel_bk_before_x_day" ).hide();
               
            }

            $( "input[name='ova_mb_event_allow_cancellation_booking']" ).on( 'click', function(){

               allow_cancel_bk = $("input[name='ova_mb_event_allow_cancellation_booking']:checked").val();
                
               if( allow_cancel_bk == 'yes' ){
                  $( ".vendor_edit_event .cancel_bk_before_x_day" ).show();
                  
               }else if( allow_cancel_bk == 'no' ){
                  $( ".vendor_edit_event .cancel_bk_before_x_day" ).hide();
                  
               }

            });

         }
      },

      el_menu_mobile: function() {
         $('.el_vendor_mobile_menu a').on('click', function(){
            $(this).closest('.vendor_sidebar').find('.dashboard_nav').slideToggle();
         });
      },

      el_single_gallery: function() {

         if ($('.event-gallery .wrap_slide').slick) {
            $('.event-gallery .wrap_slide').slick({
               lazyLoad: 'ondemand',
               slidesToShow: 1,
               slidesToScroll: 1,
               dots: false,
               arrows: false,
               fade: true,
               asNavFor: '.event-gallery .thumbnail_gallery',
            });

            $('.event-gallery .thumbnail_gallery').slick({
               lazyLoad: 'ondemand',
               slidesToShow: 5,
               slidesToScroll: 3,
               asNavFor: '.event-gallery .wrap_slide',
               dots: false,
               arrows: false,
               centerPadding: '0px',
               focusOnSelect: true,
               centerMode: true,
               swipeToSlide: true,
               responsive: [{
                  breakpoint: 600,
                  settings: {
                     arrows: false,
                     slidesToShow: 3
                  }
               }, ]
            });
         }
      },

      event_calendar: function() {
         
         $('.fullcalendar').each(function() {
            var data_js = $(this).data('listevent');
            var local = $(this).data('local');
            var initdate = $(this).data( 'initdate' );
            

            $(this).fullCalendar({
               header: {
                  left: 'prev,next today',
                  center: 'title',
                  right: 'month,agendaWeek,agendaDay,listWeek'
               },
               navLinks: true,
               firstDay: 1,
               initialDate: initdate,
               locale: local,
               default: false,
               events: data_js,
               eventColor: '#ff775a',
               height: 'auto',
               eventClick: function(event) {
                  if (event.url) {
                     window.open(event.url, '_self');
                     return false;
                  }
               },
               viewRender: function() {
                  $('.fc-day-top.fc-past').find('.fc-day-number').removeAttr('data-goto');
                  $('.fc-day-top.fc-past').css('opacity', '0.3');

                  $('.fc-event-container a:not([href])').css({
                     'opacity': '0.3',
                     'color': '#fff'
                  });
               }
            });
            if( initdate ){
               $(this).fullCalendar( 'gotoDate', initdate );
            }
            
         });
      },

      el_load_location: function() {
         $('.location .get_country select').change(function() {
            var country = $(this).val();
            var $this = $(this).closest('.location');

            if (country == '') {
               $('.location .get_city select').attr('disabled', 'disabled');
            } else {
               $('.location .get_city select').removeAttr('disabled');
            }

            $.post(ajax_object.ajax_url, {
               action: 'el_load_location',
               data: {
                  country: country,
               },
            }, function(response) {
               $this.find('#event_city').html(response);
            });
         });

         $(window).load(function() {
            var country = $('.location .get_country select option:selected').val();
            var city_selected = $('.location .get_city select option:selected').val();

            if (country == '') {
               $('.location .get_city select').attr('disabled', 'disabled');
            } else {
               $('.location .get_city select').removeAttr('disabled');
            }

            $.post(ajax_object.ajax_url, {
               action: 'el_load_location',
               data: {
                  country: country,
                  city_selected: city_selected,
               },
            }, function(response) {
               $('.vendor_edit_event .location').find('#event_city').html(response);
            });
         });
      },

      ticket_info_according: function() {
         var heading_ticket = $('.ticket-info .heading-ticket');
         heading_ticket.each(function() {
            var empty_desc = $(this).data('desc');
            if (empty_desc) {
               $(this).children('p').children('i').css('display', 'none');
               $(this).css('cursor', 'unset');
            }

            $(this).off('click').on('click', function() {
               if (empty_desc) {
                  return false;
               }
               let i = 1;
               let data_according = $(this).attr('data-according');

               $('.ticket-info .heading-ticket').not(this).removeAttr('data-according');
               if (data_according > 1) {
                  $(this).siblings('.desc-ticket').slideToggle();
               } else {
                  i++;
                  $(this).attr('data-according', i);
                  $('.ticket-info .heading-ticket').not(this).siblings('.desc-ticket').slideUp();
                  $(this).siblings('.desc-ticket').slideDown();
               }
            });
         });
      },

      cart_payment_according: function() {
         $('.cart_detail .el_payments ul li .type-payment label').on('click', function() {
            $(".el_payments ul li.free .type-payment").css({
               'border-bottom': 'none'
            });
            $(".el_payments ul li.free .payment_form").css({
               'border-bottom': '1px solid #ddd'
            });

            var that = $(this).parent('.type-payment');

            $('.cart_detail .el_payments ul li .type-payment').not(that).siblings('.payment_form').slideUp();
            $(that).siblings('.payment_form').slideDown();

            let title_payment = $(this).text();
            $(".cart_detail .payment_method_choosed .content").text(title_payment);
         });
      },

      cart_ticket_event: function() {

         const CART = {
            KEY: '',
            contents: [],
            init: function() {
               CART.get_key_cart();
               let _contents = localStorage.getItem(CART.KEY);
               if (_contents) {
                  CART.contents = JSON.parse(_contents);
               } else {
                  CART.add_store();
               }
            },

            add_store: function() {
               let _cart = JSON.stringify(CART.contents);
               localStorage.setItem(CART.KEY, _cart);
            },

            get_key_cart: function() {
               let key = "";
               let id_event = "";
               let id_cal = "";
               id_event = $(".cart_detail .cart-content .cart-ticket-info").attr('data-id-event');
               id_cal = $(".cart_detail .cart-content .cart-ticket-info").attr('data-id-cal');
               if (id_event && id_cal) {
                  CART.KEY = id_event + '_' + id_cal;
               }
            },

            add_item: function(id, name, price, qty) {
               let obj = {
                  id: id,
                  name: name,
                  price: price,
                  qty: qty,
                  seat: []
               };

               //update localStorage
               var check_item = CART.check_item(id);
               if (check_item) {
                  //has item in cart increase qty +1
                  CART.contents = CART.contents.map(function(item) {
                     if (item.id === id)
                        item.qty = item.qty + 1;
                     return item;
                  });
               } else {
                  CART.contents.push(obj);
               }
               CART.add_store();
            },

            map_add_item: function(id, price) {
               let obj = {
                  id: id,
                  price: price,
               };

               //update localStorage
               var check_item = CART.check_item(id);
               if (check_item) {
                  //has item in cart increase qty +1
                  CART.contents = CART.contents.map(function(item) {
                     if (item.id === id)
                        return item;
                  });
               } else {
                  CART.contents.push(obj);
               }
               CART.add_store();
            },

            create_item: function(id, name, price, qty) {
               let obj = {
                  id: id,
                  name: name,
                  price: price,
                  qty: qty,
                  seat: []
               };

               var check_item = CART.check_item(id);
               if (!check_item) {
                  CART.contents.push(obj);
               }

               CART.add_store();
            },

            map_create_item: function(id, name, price, qty) {
               let obj = {
                  id: id,
                  price: price,
                  qty: qty,
               };

               var check_item = CART.check_item(id);
               if (!check_item) {
                  CART.contents.push(obj);
               }

               CART.add_store();
            },

            update_seat: function(id, position, seat) {

               CART.contents = CART.contents.map(function(item) {
                  if (item.id === id) {
                     let arr_seat = item.seat;
                     arr_seat[position] = seat;
                     item.seat = arr_seat;
                  }
                  return item;
               });
               CART.add_store();
            },

            reduce_seat: function(id, position) {

               CART.contents = CART.contents.map(function(item) {
                  if (item.id === id) {
                     if (typeof(item.seat) != 'undefined') {
                        let arr_seat = item.seat;
                        if (typeof(arr_seat[position]) !== 'undefined') {
                           arr_seat.splice(position, 1);
                        }
                        item.seat = arr_seat;
                     }
                  }
                  return item;
               });
               CART.add_store();
            },

            delete_seat: function(id) {
               CART.contents = CART.contents.map(function(item) {
                  if (item.id == id) {
                     if (typeof item.seat !== 'undefined') {
                        delete item.seat;
                     }
                  }
                  return item;
               });
               CART.add_store();
            },

            remove: function(id) {
               //remove an item entirely from CART.contents based on its id
               CART.contents = CART.contents.filter(function(item) {
                  if (item.id !== id)
                     return true;
               });
               //update localStorage
               CART.add_store()
            },

            reduce: function(id) {

               CART.contents = CART.contents.map(function(item) {
                  if (item.id === id)
                     item.qty = item.qty - 1;
                  return item;
               });
               CART.contents.forEach(function(item) {
                  if (item.id === id && item.qty === 0)
                     CART.remove(id);
               });
               CART.add_store();
            },

            check_item: function(id) {
               let match = CART.contents.filter(function(item) {
                  if (item.id == id)
                     return true;
               });
               if (match && match[0])
                  return match[0];
            },

            show_cart: function() {
               let contents = CART.contents;
               let html_info_cart = "";
               let total = 0;
               var seat_option = $(".cart_detail .cart-content .cart-ticket-info").attr("data-seat-option");
               //empty select in wp-select
               $(".cart_detail .cart-content .cart-ticket-info .item-ticket-type .wp-select-seat ").empty();

               var enable_tax = $(".cart_detail .cart-content .cart-ticket-info").attr("data-enable-tax");
               var data_percent_tax = $(".cart_detail .cart-content .cart-ticket-info").attr("data-percent-tax");
               //set background button when sold out all
               var value_sold_out_all = $("input[name=sold_all]").val();
               if (value_sold_out_all == '1') {
                  $(".cart_detail .cart-sidebar .checkout_button a, .cart_detail .cart-sidebar .next_step_button a ").css({
                     "background": "#ccc",
                     "border-color": "#b0b0b0",
                     "color": "#888",
                     "font-weight": "500",
                     "text-shadow": "none"
                  }).text("Sold out");
               }

               if (!jQuery.isEmptyObject(contents)) {
                  contents.forEach(function(item) {
                     if (item['discound_code']) {
                        return;
                     }

                     let sub_total, price, sub_total_display;
                     sub_total = item.qty * item.price;
                     price = EL_Frontend.cart_price_display(item.price);
                     sub_total_display = EL_Frontend.cart_price_display(sub_total);

                     var html_info_seat = '';
                     var setup_display_seat = $(".cart_detail .cart-content .cart-ticket-info .item-ticket-type.item-" + item.id).attr("data-setup_seat");
                     if (seat_option == 'simple' && setup_display_seat == 'yes') {
                        var list_seat_store = item.seat;

                        if (item.qty >= 1) {
                           for (let i = 0; i < item.qty; i++) {
                              let position = 'empty';
                              if (typeof list_seat_store != 'undefined') {
                                 if (list_seat_store.length > 0 && typeof list_seat_store[i] !== 'undefined' && list_seat_store[i] != "") {
                                    position = list_seat_store[i];
                                    html_info_seat += '<span class="seat-' + i + '">' + position + '</span>';
                                 }
                              }
                           }
                        }
                     }

                     html_info_cart += '<div data-qty="' + item.qty + '" data-price="' + sub_total + '"  class="item-info ' + item.id + '">';
                     html_info_cart += '<div class="info-type-ticket">';
                     html_info_cart += '<p class="title-ticket">' + item.name + '</p>';
                     html_info_cart += '<p class="price">' + price + '</p>';
                     html_info_cart += '<div class="wp-seat-info">' + html_info_seat + '</div>';
                     html_info_cart += '</div>';
                     html_info_cart += '<div class="info-sub-price">';
                     html_info_cart += '<p class="sub-number">' + item.qty + '</p>';
                     html_info_cart += '<p class="sub-price">' + sub_total_display + '</p>';
                     html_info_cart += '</div>';
                     html_info_cart += '</div>';
                     total += sub_total;

                     $(".cart-ticket-info .item-ticket-type .control span.qty-" + item.id).text(item.qty);


                     if (seat_option == 'simple' && setup_display_seat == 'yes') {

                        var qty_item = item.qty;
                        if (qty_item >= 1) {

                           for (var i = 0; i < qty_item; i++) {
                              var list_rest_seat = $(".cart_detail .cart-content .cart-ticket-info .item-ticket-type.item-" + item.id).attr("data-list-seat-rest");
                              var select_seat_text = $(".cart_detail .cart-content .cart-ticket-info .item-ticket-type.item-" + item.id).attr("data-select-seat-text");
                              var html_option = "";
                              var list_seat_store = item.seat;
                              if (typeof list_seat_store != 'undefined') {
                                 list_rest_seat = JSON.parse(list_rest_seat);

                                 html_option += "<option value=''>"+select_seat_text+"</option>";

                                 for (var key in list_rest_seat) {
                                    var selected = '';
                                    if (list_rest_seat[key] == list_seat_store[i]) {
                                       selected = 'selected="selected"';
                                    }

                                    html_option += "<option " + selected + " value='" + list_rest_seat[key] + "'>" + list_rest_seat[key] + "</option>"
                                 }
                              }


                              let html_select = "";
                              html_select += "<div class='item-select-num num-" + i + "' ><select data-position='" + i + "' data-id-ticket='" + item.id + "' name='select_seat' class='item-select-" + item.id + "'>";

                              html_select += html_option;
                              html_select += "</select></div>";
                              $(".cart_detail .cart-content .cart-ticket-info .item-ticket-type.item-" + item.id + " .wp-select-seat").append(html_select);
                           }
                        }
                     } else {
                        CART.delete_seat(item.id);
                     }

                     $(".cart_detail .cart-content .cart-ticket-info .item-ticket-type.item-" + item.id + " .wp-select-seat select").select2({
                        width: '100%'
                     });
                  });

                  var total_tax = 0;
                  if (enable_tax == 'yes') {
                     total_tax = (parseFloat(data_percent_tax) * total) / 100;
                     $(".cart_detail .cart-sidebar .cart-info .wp-cart-info .content-cart-info .total-tax").css({
                        'display': 'flex'
                     });
                     $(".cart_detail .cart-sidebar .cart-info .wp-cart-info .content-cart-info .total-tax .tax-number").empty().text("+" + EL_Frontend.cart_price_display(total_tax));
                     $(".cart_detail .cart-sidebar .cart-info .wp-cart-info .content-cart-info .total-tax .tax-number").attr("data-tax", total_tax);
                  }

                  total += total_tax;
                  let total_display = EL_Frontend.cart_price_display(total);
                  $(".cart_detail .cart-sidebar .cart-info .wp-cart-info .content-cart-info .placeholder").css({
                     'display': 'none'
                  });
                  $(".cart_detail .cart-sidebar .cart-info .wp-cart-info .content-cart-info .item-info.header").css({
                     'display': 'flex'
                  });
                  $(".cart_detail .cart-sidebar .cart-info .total-cart-info").attr("data-price", total);
                  $(".cart_detail .cart-sidebar .cart-info .total-cart-info span.total-price").empty().text(total_display);
               } else {
                  $(".cart_detail .cart-sidebar .cart-info .wp-cart-info .content-cart-info .placeholder").css({
                     'display': 'inline-block'
                  });
                  $(".cart_detail .cart-sidebar .cart-info .wp-cart-info .content-cart-info .item-info.header").css({
                     'display': 'none'
                  });
                  $(".cart_detail .cart-sidebar .cart-info .total-cart-info").attr("data-price", 0);
                  $(".cart_detail .cart-sidebar .cart-info .total-cart-info span.total-price").empty().text(0);
               }

               $(".cart_detail .cart-sidebar .cart-info .wp-cart-info .content-cart-info .wp-content-item").empty();
               $(".cart_detail .cart-sidebar .cart-info .wp-cart-info .content-cart-info .wp-content-item").append(html_info_cart);
            },

            seat_map: function() {
               var dataSeatBooked = $(document).find('.data-seat_booked').data('seat_booked');
               var dataSeat = $(document).find('.data-seat').data('seat');
               var dataSeatName = [];
               var dataSeatPrice = [];
               
               // Load seat in map
               $.imageMapProInitialized = function(imageMapName) {
                  if ($.imageMapProIsMobile()) {
                     $(document).find('.imp-fullscreen-button').css('display', 'none');
                  }

                  let html_info_cart = '';
                  let tax = $('.cart-ticket-info').data('percent-tax');

                  let id_event = $('.cart-ticket-info').data('id-event');
                  let id_cal = $('.cart-ticket-info').data('id-cal');
                  let data_localStorage = JSON.parse(localStorage.getItem(id_event + '_' + id_cal));
                  let total = 0;
                  let total_tax = 0;
                  let count_seat = 0;

                  html_info_cart += '<div class="item-info item-info-map">';
                  html_info_cart += '<div class="info-type-ticket">';
                  html_info_cart += '<div class="wp-seat-info"></div>';
                  html_info_cart += '</div>';
                  html_info_cart += '<div class="info-sub-price">';
                  html_info_cart += '</div>';
                  html_info_cart += '</div>';

                  $('.wp-content-item').html(html_info_cart);

                  if (Array.isArray(data_localStorage) && data_localStorage.length) {
                     $('.wp-content-item').css('display', 'block');
                     $('.item-info.header').css('display', 'flex');
                     $('.total-tax').css('display', 'flex');
                     $('.cart-info .placeholder').css('display', 'none');
                  } else {
                     $('.wp-content-item').css('display', 'none');
                     $('.item-info.header').css('display', 'none');
                     $('.total-tax').css('display', 'none');
                     $('.cart-info .placeholder').css('display', 'block');
                  }

                  // Map Seat Booked
                  for (var x = dataSeatBooked.length - 1; x >= 0; x--) {
                     for (var i = dataSeat.length - 1; i >= 0; i--) {
                        if (dataSeat[i].id.indexOf(dataSeatBooked[x]) != '-1') {
                           $(document).find('div[data-shape-title=' + dataSeatBooked[x] + ']').addClass('booked');
                        }
                     }
                  }

                  // Map Selected Local Storage
                  for (var i = 0; i < data_localStorage.length; i++) {
                     total += parseFloat(data_localStorage[i].price);
                     dataSeatName.push(data_localStorage[i].id);
                     dataSeatPrice.push(data_localStorage[i].price);
                     $(document).find('div.imp-shape[data-shape-title="' + data_localStorage[i].id + '"]').attr('selected', 'selected').addClass('selected');

                     // Add HTML Booking Info
                     let html_info = '<span class="seat-' + i + '">' + data_localStorage[i].id + '</span>';
                     $('.wp-content-item .wp-seat-info').append(html_info);
                  }

                  count_seat = $('.cart_detail .wp-seat-info').children('span').length;
                  $('.wp-content-item .item-info').attr('data-qty', count_seat);

                  $('.wp-content-item .info-sub-price').html(EL_Frontend.cart_price_display(total));

                  total_tax = (parseFloat(tax) * total) / 100;
                  $(".cart-info .tax-number").empty().text("+" + EL_Frontend.cart_price_display(total_tax));
                  $(".cart-info .total-price").empty().text(EL_Frontend.cart_price_display(total + total_tax));
                  $('.wp-content-item .item-info-map').attr('data-price', total);
                  $('.content-cart-info .tax-number').attr('data-tax', total_tax);

                  if (Array.isArray(data_localStorage) && data_localStorage.length) {
                     $('.cart_detail .total-cart-info').attr("data-price", total + total_tax);
                  } else {
                     $('.cart_detail .total-cart-info').attr("data-price", 0);
                  }

                  let number_max_ticket = parseFloat($('.event_ticket_map_type').data("max_ticket"));
                  let number_min_ticket = parseFloat($('.event_ticket_map_type').data("min_ticket"));
               };

               // Select seat in map
               $.imageMapProEventClickedShape = function(imageMapName, shapeTitle) {
                  if ($.inArray(shapeTitle, dataSeatBooked) !== -1) {
                     return;
                  } else {
                     $(document).find('.imp-shape-container div.imp-shape[data-shape-title="' + shapeTitle + '"]').off("click").one('click touchstart', function() {
                        let total = 0;
                        let count_seat = 0;

                        // unselected
                        if ($(this).hasClass('selected')) {


                           $(this).removeClass('selected').removeAttr('selected');
                           for (let i = dataSeatName.length - 1; i >= 0; i--) {
                              if (shapeTitle == dataSeatName[i]) {
                                 dataSeatName.splice(i, 1);
                                 dataSeatPrice.splice(i, 1);

                                 $(document).find('.wp-seat-info span:nth-child(' + (i + 1) + ')').remove();
                                 CART.remove(shapeTitle);
                              }
                           }

                           for (let i = dataSeatPrice.length - 1; i >= 0; i--) {
                              total += parseFloat(dataSeatPrice[i]);
                           }
                           $('.wp-content-item .info-sub-price').html(EL_Frontend.cart_price_display(total));


                           count_seat = $('.cart_detail .wp-seat-info').children('span').length;
                           $('.wp-content-item .item-info').attr('data-qty', count_seat);
                           $('.wp-content-item .item-info-map').attr('data-price', total);
                           $(".cart_detail .error.error-max-num").css('display', 'none');


                           // selected
                        } else {
                           count_seat = $('.cart_detail .wp-seat-info').children('span').length;

                           let max_ticket = $('.cart-ticket-info').data('max_ticket');
                           if (count_seat >= max_ticket) {
                              $(".cart_detail .error-number-seat").css('display', 'block');
                              $(".cart_detail .error.error-max-num").css('display', 'inline-block');
                              return false;
                           }

                           $(this).attr('selected', 'selected').addClass('selected');


                           for (let i = 0; i < dataSeat.length; i++) {

                              let html_info = '<span class="seat-' + i + '">' + shapeTitle + '</span>';
                              let seat;
                              seat = dataSeat[i].id.split(',');
                              seat = seat.filter(function(el) {
                                 return el != null && el != "" && el != " ";
                              });

                              seat = seat.map(function(el) {
                                 return el.trim();
                              });

                              if (seat.indexOf(shapeTitle) != '-1') {

                                 dataSeatName.push(shapeTitle);
                                 dataSeatPrice.push(dataSeat[i].price);

                                 $('.wp-seat-info').append(html_info);
                                 CART.map_add_item(shapeTitle, dataSeat[i].price);
                              }
                           }

                           for (let i = dataSeatPrice.length - 1; i >= 0; i--) {
                              total += parseFloat(dataSeatPrice[i]);
                           }

                           $('.wp-content-item .info-sub-price').html(EL_Frontend.cart_price_display(total));

                           count_seat = $('.cart_detail .wp-seat-info').children('span').length;
                           $('.wp-content-item .item-info').attr('data-qty', count_seat);
                           $('.wp-content-item .item-info-map').attr('data-price', total);
                        }

                        let tax = $('.cart-ticket-info').data('percent-tax');
                        let id_event = $('.cart-ticket-info').data('id-event');
                        let id_cal = $('.cart-ticket-info').data('id-cal');
                        let data_localStorage = JSON.parse(localStorage.getItem(id_event + '_' + id_cal));
                        let total_tax = 0;

                        total_tax = (parseFloat(tax) * total) / 100;
                        $(".cart-info .tax-number").empty().html("+" + EL_Frontend.cart_price_display(total_tax));
                        $(".cart-info .total-price").empty().html(EL_Frontend.cart_price_display(total + total_tax));
                        $('.content-cart-info .tax-number').attr('data-tax', total_tax);

                        if (Array.isArray(data_localStorage) && data_localStorage.length) {
                           $('.wp-content-item').css('display', 'block');
                           $('.item-info.header').css('display', 'flex');
                           $('.total-tax').css('display', 'flex');
                           $('.cart_detail .total-cart-info').attr("data-price", total + total_tax);
                           $('.cart-info .placeholder').css('display', 'none');
                        } else {
                           $('.wp-content-item').css('display', 'none');
                           $('.item-info.header').css('display', 'none');
                           $('.cart_detail .total-cart-info').attr("data-price", 0);
                           $('.total-tax').css('display', 'none');
                           $('.cart-info .placeholder').css('display', 'block');
                        }
                     });
                  }
                  $(".cart_detail .cart-sidebar .total-discount").css('display', 'none');
                  $(".cart_detail .cart-sidebar .form-discount").css('display', 'none');
                  $(".cart_detail .cart-sidebar #cart-discount-button").css('display', 'block');
               };
            }
         } //end const CART 

         $(document).ready(function() {
            CART.init();
            CART.show_cart();
            CART.seat_map();
         });

         $(".plus").on("click", function() {
            let id_ticket = $(this).attr("data-id-ticket");
            $(".cart_detail .cart-content .cart-ticket-info .item-ticket-type.item-" + id_ticket + " .quanty-ticket .error.error-max-num").css('display', 'none');
            $(".cart_detail .cart-content .cart-ticket-info .item-ticket-type.item-" + id_ticket + " .quanty-ticket .error.error-min-num").css('display', 'none');
            $(".cart_detail .cart-content .cart-ticket-info .item-ticket-type.item-" + id_ticket + " .control").css('padding-top', '0px');
            $(".cart_detail .cart-sidebar .total-discount").css('display', 'none');
            $(".cart_detail .cart-sidebar .form-discount").css('display', 'none');
            $(".cart_detail .cart-sidebar #cart-discount-button").css('display', 'block');

            let name_ticket = $(this).attr("data-title");
            let price_ticket = $(this).attr("data-price");
            let qty = parseInt($(this).siblings(".qty").text());
            let max_qty = parseInt($(this).attr("data-max-num"));
            let min_qty = parseInt($(this).siblings(".minus").attr("data-min-num"));
            let num_click = parseInt($(this).attr("data-mark"));

            qty = Math.max(qty, min_qty);
            if (min_qty == max_qty) {
               CART.create_item(id_ticket, name_ticket, price_ticket, qty);
               CART.show_cart();
            }

            if (qty >= max_qty) {
               $(".cart_detail .cart-content .cart-ticket-info .item-ticket-type.item-" + id_ticket + " .quanty-ticket .error.error-max-num").css('display', 'inline-block');
               $(".cart_detail .cart-content .cart-ticket-info .item-ticket-type.item-" + id_ticket + " .control").css('padding-top', '10px');
               return false;
            }

            CART.add_item(id_ticket, name_ticket, price_ticket, qty);
            CART.show_cart();
            $(this).attr("data-mark", num_click + 1);
         });

         $(".minus").on("click", function() {

            let id_ticket = $(this).attr("data-id-ticket");
            $(".cart_detail .cart-content .cart-ticket-info .item-ticket-type.item-" + id_ticket + " .quanty-ticket .error.error-min-num").css('display', 'none');
            $(".cart_detail .cart-content .cart-ticket-info .item-ticket-type.item-" + id_ticket + " .quanty-ticket .error.error-max-num").css('display', 'none');
            $(".cart_detail .cart-content .cart-ticket-info .item-ticket-type.item-" + id_ticket + " .control").css('padding-top', '0px');
            $(".cart_detail .cart-sidebar .total-discount").css('display', 'none');
            $(".cart_detail .cart-sidebar .form-discount").css('display', 'none');
            $(".cart_detail .cart-sidebar #cart-discount-button").css('display', 'block');

            let qty = parseInt($(this).siblings(".qty").text());
            let min_qty = parseInt($(this).attr("data-min-num"));

            if (qty <= min_qty) {
               $(".cart_detail .cart-content .cart-ticket-info .item-ticket-type.item-" + id_ticket + " .quanty-ticket .error.error-min-num").css('display', 'inline-block');
               $(".cart_detail .cart-content .cart-ticket-info .item-ticket-type.item-" + id_ticket + " .control").css('padding-top', '10px');
               return false;
            }

            CART.reduce(id_ticket);
            CART.reduce_seat(id_ticket, qty - 1);
            if (qty > 0) {
               qty = qty - 1;
               $(this).siblings(".qty").text(qty);
            }

            CART.show_cart();
         });

         //remove ticket by ticket id
         $(".btn-delete-item-cart").on("click", function() {
            let id_ticket = $(this).attr("data-id");
            let num_min = $(this).attr("data-min");

            $(this).siblings(".control").children(".qty").text(0);

            CART.remove(id_ticket);
            CART.show_cart();
         });

         $(".wp-select-seat ").on('change', 'select', function() {
            let seat = $(this).val();
            let position = $(this).attr("data-position");
            let id_ticket = $(this).attr("data-id-ticket");

            CART.update_seat(id_ticket, position, seat);
            if (seat.length == 0) {
               $("." + id_ticket + " .wp-seat-info .seat-" + position).remove();
            } else {
               var dom_info_item = $("." + id_ticket + " .wp-seat-info .seat-" + position);
               if (typeof dom_info_item != 'undefined' && dom_info_item.length > 0) {
                  dom_info_item.text(seat);
               } else {
                  let html_info = '<span class="seat-' + position + '">' + seat + '</span>';

                  $("." + id_ticket + " .wp-seat-info").append(html_info);
               }
            }
         });
      },

      cart_price_display: function(price) {

         let data_settings = $(".cart_detail .cart-content .cart-ticket-info").attr("data-setting");

         if (data_settings) {
            data_settings = JSON.parse(data_settings);

            var currency = ( data_settings.currency ) ? data_settings.currency : '$';
            var decimal_separator = ( data_settings.decimal_separator ) ? data_settings.decimal_separator : '.';
            var thousand_separator = ( data_settings.thousand_separator ) ? data_settings.thousand_separator : ',';
            var number_decimals = ( data_settings.number_decimals ) ? data_settings.number_decimals : 0;

            price = parseFloat(price).toFixed(parseInt(number_decimals));
            price = price.toString().replace(".", decimal_separator);
            var price = price.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1" + thousand_separator);


            switch (data_settings.currency_position) {
               case "left":
                  price = currency + price;
                  break;

               case "left_space":
                  price = currency + " " + price;
                  break;

               case "right":
                  price = price + currency;
                  break;

               case "right_space":
                  price = price + " " + currency;
                  break;
            }
            return price;
         }
      },

      /*** Cart Discount ***/
      cart_discount: function() {
         $(".cart_detail .cart-sidebar .cart-discount-button .form-discount input").on('focus', function() {
            $(this).siblings('button').css({
               'background': '#e86c60',
               'border-color': '#e86c60'
            });
         });

         $(".cart_detail .cart-sidebar .cart-discount-button .form-discount input").on('focusout', function() {
            $(this).siblings('button').css({
               'background': '#999',
               'border-color': '#828181'
            });
         });
         $(".cart_detail .cart-sidebar .cart-discount-button a").on("click", function() {
            $(this).css({
               'display': 'none'
            });
            $(this).siblings('.form-discount').css({
               'display': 'flex'
            });
         });
         $(".cart_detail .cart-sidebar .cart-discount-button .form-discount i").on('click', function() {
            $(this).parent('.form-discount').css({
               'display': 'none'
            });
            $(this).parent('.form-discount').siblings('#cart-discount-button').css({
               'display': 'block'
            });
            $(this).siblings('#submit-code-discount').attr('data-discount-code', '');
         });


         $("#submit-code-discount").on("click", function() {

            var code_discount = $(this).siblings('input').val();

            var id_event = $(this).attr('data-id');
            $.post(ajax_object.ajax_url, {
               action: 'el_check_discount',
               data: {
                  code_discount: code_discount,
                  id_event: id_event,
               },
            }, function(response) {
               // console.log(response);
               if (response) {
                  var enable_tax = $(".cart_detail .cart-content .cart-ticket-info").attr("data-enable-tax");
                  let seat_option = $(".cart_detail .cart-content .cart-ticket-info").data("seat-option");
                  let data_discount = JSON.parse(response);
                  let id_ticket = data_discount.id_ticket;
                  var discount_number = data_discount.discount_number;
                  var discount_percent = data_discount.discount_percenr;
                  var number_tax = parseFloat($(".cart_detail .cart-sidebar .cart-info .wp-cart-info .content-cart-info .total-tax .tax-number").attr("data-tax"));
                  var data_percent_tax = parseFloat($(".cart_detail .cart-content .cart-ticket-info").attr("data-percent-tax"));

                  if (isNaN(number_tax) || enable_tax === 'no') {
                     number_tax = 0;
                     data_percent_tax = 0;
                  }

                  if (id_ticket == null) {
                     $(".cart-discount-button .error").css({
                        'display': 'block'
                     });
                     $(".cart_detail .cart-sidebar .cart-info .wp-cart-info .content-cart-info .total-discount").css({
                        'display': 'none'
                     });
                     $(".cart_detail .cart-sidebar .cart-info .wp-cart-info .content-cart-info .total-discount .discount-number").empty();
                     $(".cart_detail .cart-sidebar .cart-info .wp-cart-info .content-cart-info .total-discount .discount-number").attr('data-discount', 0);
                     return false;
                  }

                  id_ticket = Object.values(id_ticket);
                  var total_discount = 0;

                  if (seat_option != 'map') {
                     id_ticket.forEach(function(item, index) {
                        let item_info_discount = $(".cart_detail .cart-sidebar .cart-info .wp-cart-info .content-cart-info .item-info." + item);

                        if (item_info_discount.length > 0) {
                           let qty_item = item_info_discount.attr('data-qty');
                           let sub_price_item = item_info_discount.attr('data-price');
                           let sub_total_discount;

                           if (discount_number) {
                              sub_total_discount = discount_number * qty_item
                           } else if (discount_percent) {
                              sub_total_discount = (sub_price_item * discount_percent) / 100;
                           }

                           qty_item = parseInt(qty_item);
                           sub_price_item = parseFloat(sub_price_item);

                           var sub_price_item_after_discount = sub_price_item - sub_total_discount;

                           var price_after_discount = EL_Frontend.cart_price_display(sub_price_item_after_discount);
                           total_discount += sub_total_discount;
                        }
                     });

                  } else {
                     let sub_total_discount = 0;
                     let qty_item = $('.wp-content-item .item-info-map').attr('data-qty');
                     let sub_price_item = $('.content-cart-info .item-info-map').attr('data-price');
                     if (discount_number) {
                        sub_total_discount = discount_number * qty_item
                     } else if (discount_percent) {
                        sub_total_discount = (sub_price_item * discount_percent) / 100;
                     }

                     qty_item = parseInt(qty_item);
                     sub_price_item = parseFloat(sub_price_item);

                     var sub_price_item_after_discount = sub_price_item - sub_total_discount;

                     var price_after_discount = EL_Frontend.cart_price_display(sub_price_item_after_discount);
                     total_discount += sub_total_discount;
                  }

                  $(".cart-discount-button .error").css({
                     'display': 'none'
                  });
                  let total_price = $(".cart_detail .cart-sidebar .cart-info .total-cart-info").attr('data-price');
                  total_price = parseFloat(total_price);

                  var total_before_tax = total_price - number_tax - total_discount;
                  var total_tax = (total_before_tax * data_percent_tax) / 100;

                  let total_price_after_discount, total_display, total_discount_display;
                  total_price_after_discount = total_tax + total_before_tax;
                  total_display = EL_Frontend.cart_price_display(total_price_after_discount);
                  total_discount_display = EL_Frontend.cart_price_display(total_discount);

                  $(".cart_detail .cart-sidebar .cart-info .total-cart-info span.total-price").empty().text(total_display);
                  $(".cart_detail .cart-sidebar .cart-info .wp-cart-info .content-cart-info .total-discount").css({
                     'display': 'flex'
                  });
                  $(".cart_detail .cart-sidebar .cart-info .wp-cart-info .content-cart-info .total-discount .discount-number").attr('data-discount', total_discount);
                  $(".cart_detail .cart-sidebar .cart-info .wp-cart-info .content-cart-info .total-discount .discount-number").empty().text("-" + total_discount_display);
                  $("#submit-code-discount").attr('data-discount-code', code_discount);
                  $(".cart_detail .cart-sidebar .cart-info .wp-cart-info .content-cart-info .total-tax .tax-number").empty().text("+" + EL_Frontend.cart_price_display(total_tax));
                  $('.content-cart-info .tax-number').attr('data-tax', total_tax);

               } else {
                  $(".cart-discount-button .error").css({
                     'display': 'block'
                  });
                  $(".cart_detail .cart-sidebar .cart-info .wp-cart-info .content-cart-info .total-discount").css({
                     'display': 'none'
                  });
                  $(".cart_detail .cart-sidebar .cart-info .wp-cart-info .content-cart-info .total-discount .discount-number").empty();
                  $(".cart_detail .cart-sidebar .cart-info .wp-cart-info .content-cart-info .total-discount .discount-number").attr('data-discount', 0);
               }
            });
         })
      },

      cart_next_step: function() {
         let seat_option = $(".cart_detail .cart-content .cart-ticket-info").data("seat-option");

         $("#cart-next-step").off().on('click', function() {

            var el_next_event_nonce = $(this).closest('.next_step_button').find('#el_next_event_nonce').val();
            var myaccount_page = $(this).closest('.next_step_button').find('#el_next_myaccount_page').val();
            var cart_page = $(this).closest('.next_step_button').find('#el_next_cart_page').val();

            var value_sold_out_all = $("input[name=sold_all]").val();
            if (value_sold_out_all == '1') {
               return false;
            }

            $(".cart_detail .cart-content .cart-ticket-info .error-empty-cart").css({
               "display": "none"
            });
            $(".cart_detail .cart-content .cart-ticket-info .error-empty-cart span").css({
               "display": "none"
            });

            let id_event, id_cal, key_store, cart;
            id_event = $(".cart_detail .cart-content .cart-ticket-info").attr('data-id-event');
            id_cal = $(".cart_detail .cart-content .cart-ticket-info").attr('data-id-cal');
            if (!id_event || !id_cal) {
               key_store = "";
            }

            key_store = id_event + '_' + id_cal;
            cart = localStorage.getItem(key_store);
            cart = JSON.parse(cart);

            //check seat 
            var cart_check = cart;
            var flag_check_seat = '';

            cart_check = cart_check.map(function(item) {
               if (typeof(item.seat) != 'undefined') {
                  let seat = item.seat;

                  if (seat.length !== item.qty) {
                     flag_check_seat = 'error_undefined';
                  }

                  let arr_duplicate = seat.filter(function(item, index) {
                     seat.indexOf(item) != index && (seat[index] != null);
                  });

                  if (arr_duplicate.length > 0) {
                     flag_check_seat = 'error_duplicate';
                  }

                  let arr_seat_empty = seat.filter(function(item, index) {
                     seat[index] == "" || seat[index] == null;
                  });
                  if (arr_seat_empty.length > 0) {
                     flag_check_seat = 'error_empty';
                  }
               }
            });

            $(".cart_detail .cart-sidebar .message-error-seat p").css('display', 'none');
            if (flag_check_seat == 'error_empty' || flag_check_seat == 'error_undefined') {

               $(".cart_detail .cart-content .cart-ticket-info .error-empty-cart").css({
                  "display": "block",
                  "text-align": "center"
               });
               $(".cart_detail .cart-content .cart-ticket-info .error-empty-cart span.error-empty").css({
                  "display": "inline-block"
               });
               return false;
            } else if (flag_check_seat == 'error_duplicate') {

               $(".cart_detail .cart-content .cart-ticket-info .error-empty-cart").css({
                  "display": "block",
                  "text-align": "center"
               });
               $(".cart_detail .cart-content .cart-ticket-info .error-empty-cart span.error-duplicate").css({
                  "display": "inline-block"
               });
               return false;
            }

            let data_price_total = $(".cart_detail .cart-sidebar .cart-info .total-cart-info").attr("data-price");
            data_price_total = parseFloat(data_price_total);
            var error_qty = true;
            var i = 0;
            var j = 0;
            $(".cart_detail .cart-content .cart-ticket-info .item-ticket-type .control span.qty").each(function() {
               var qty = parseInt($(this).text());
               if (qty <= 0) {
                  i++;
               }
               j++;
            });

            if (i == j) {
               error_qty = false;
            }


            if (seat_option == 'map' && (Array.isArray(cart) && cart.length)) {
               error_qty = true;
               let count_seat = $('.cart_detail .wp-seat-info').children('span').length;
               let min_ticket = $('.cart-ticket-info').data('min_ticket');
               if (count_seat < min_ticket) {
                  $(".cart_detail .error-number-seat").css('display', 'block');
                  $(".cart_detail .error.error-min-num").css('display', 'inline-block');
                  return false;
               }
            }

            if (error_qty) {
               var el_next_event_nonce = $(this).closest('.next_step_button').find('#el_next_event_nonce').val();
            var el_next_myaccount_page = $(this).closest('.next_step_button').find('#el_next_myaccount_page').val();
            var el_next_cart_page = $(this).closest('.next_step_button').find('#el_next_cart_page').val();

               $.post(ajax_object.ajax_url, {
                  action: 'el_check_user_login',
                  data: {
                     el_next_event_nonce: el_next_event_nonce,
                  },
               }, function(response) {
                  
                  if( response == 'true' ) {
                     var total = $(".cart_detail .cart-sidebar .cart-info .total-cart-info").attr("data-price");
                     total = parseFloat(total);
                     $(".el_payments ul li ").css('display', 'block');

                     if (!total) {
                        $(".el_payments ul li:not(.free)").css("display", "none");
                        $(".el_payments ul li input[type=radio]").removeAttr('checked');
                        $(".el_payments ul li.free").children('.type-payment').children('input[type=radio]').attr('checked', '');

                        var content_payment = $(".el_payments ul li.free .type-payment").children("label").text();
                        $(".el_payments ul li.free .payment_form").css({
                           'display': 'none'
                        });
                        $(".el_payments ul li.free .type-payment").css({
                           'border-bottom': '1px solid #ddd'
                        });
                     } else {
                        $(".el_payments ul li.free").css({
                           "display": "none"
                        });
                        $(".el_payments ul li input[type=radio]").removeAttr('checked');
                        $(".el_payments ul li:first").children('.type-payment').children('input[type=radio]').attr('checked', '');
                        $(".el_payments ul li.free").next().children('.type-payment').children('input[type=radio]').attr('checked', '');
                        var content_payment = $(".el_payments ul li:first").children('.type-payment').children("label").text();
                        if (content_payment) {
                           content_payment = $(".el_payments ul li.free").next().children('.type-payment').children("label").text();
                        }
                     }

                     $(".cart_detail .payment_method_choosed .content").text(content_payment);

                     $(".cart_detail .step-2").css({
                        'display': 'block'
                     });
                     $(".cart_detail .step-1-hide-step-2").css({
                        'display': 'none'
                     });
                     $(".cart_detail .next_step_button").css({
                        'display': 'none'
                     });
                     $(".cart_detail .cart-sidebar .cart-info .wp-cart-info .cart_title span.edit").css({
                        "display": "inline-block"
                     });
                  } else {

                     var current_url = window.location.origin + window.location.pathname + window.location.search;
                     window.location.href = myaccount_page + '?redirect_to=' + current_url;

                  }
               });

            } else {
               

               $(".cart_detail .cart-content .cart-ticket-info .error-empty-cart").css({
                  "display": "block"
               });
               $(".cart_detail .cart-content .cart-ticket-info .error-empty-cart span.empty-item-cart").css({
                  "display": "inline-block"
               });
               
            }

         });
      },

      cart_change_customer_info: function() {
         if ($(".cart_detail .input_ticket_receiver li input#fullname").val() != '') {
            let value_input = $(".cart_detail .input_ticket_receiver li input#fullname").val();
            $(".cart_detail .info_ticket_receiver li .span.fullname").text(value_input);
         }
         if ($(".cart_detail .input_ticket_receiver li input#email").val() != '') {
            let value_input = $(".cart_detail .input_ticket_receiver li input#email").val();
            $(".cart_detail .info_ticket_receiver li .span.email").text(value_input);
         }
         if ($(".cart_detail .input_ticket_receiver li input#phone").val() != '') {
            let value_input = $(".cart_detail .input_ticket_receiver li input#phone").val();
            $(".cart_detail .info_ticket_receiver li .span.phone").text(value_input);
         }
         if ($(".cart_detail .input_ticket_receiver li input#address").val() != '') {
            let value_input = $(".cart_detail .input_ticket_receiver li input#address").val();
            $(".cart_detail .info_ticket_receiver li .span.address").text(value_input);
         }

         $(".cart_detail .input_ticket_receiver li input#fullname").on("keyup", function() {
            let value_input = $(this).val();
            $(".cart_detail .info_ticket_receiver li .span.fullname").text(value_input);
         });

         $(".cart_detail .input_ticket_receiver li input#email").on("keyup", function() {
            let value_input = $(this).val();
            $(".cart_detail .info_ticket_receiver li .span.email").text(value_input);
         });

         $(".cart_detail .input_ticket_receiver li input#phone").on("keyup", function() {
            let value_input = $(this).val();
            $(".cart_detail .info_ticket_receiver li .span.phone").text(value_input);
         });

         $(".cart_detail .input_ticket_receiver li input#address").on("keyup", function() {
            let value_input = $(this).val();
            $(".cart_detail .info_ticket_receiver li .span.address").text(value_input);
         });


         var list_key_checkout_field = $('#el_list_key_checkout_field').val();

         var data_checkout_field = {};

         if(list_key_checkout_field) {
            list_key_checkout_field = JSON.parse(list_key_checkout_field);
            for( var key_ckf in list_key_checkout_field ) {


               var value_ckf = $("#" + list_key_checkout_field[key_ckf] ).val();
               var name_ckf = list_key_checkout_field[key_ckf];

               if( $(".cart_detail .input_ticket_receiver li #" + name_ckf).hasClass('ova_select') ) {
                  $(".cart_detail .input_ticket_receiver li #" + name_ckf).on("change", function() {
                     let value_input = $(this).val();
                     var id_field = $(this).attr('id');

                     $(".cart_detail .info_ticket_receiver li .span." + id_field).text(value_input);
                  });
               } else {
                  $(".cart_detail .input_ticket_receiver li #" + name_ckf).on("keyup", function() {
                     let value_input = $(this).val();
                     var id_field = $(this).attr('id');

                     $(".cart_detail .info_ticket_receiver li .span." + id_field).text(value_input);
                  });
               }


            }
         }


      },

      cart_edit_button: function() {
         $(".cart_detail .cart-sidebar .cart-info .wp-cart-info .cart_title span.edit").off().on("click", function() {
            // console.log('clicked');
            $(this).css({
               'display': 'none'
            });
            $(".cart_detail .step-2").css({
               'display': 'none'
            });
            $(".cart_detail .step-1-hide-step-2").css({
               'display': 'block'
            });
            $(".cart_detail .next_step_button").css({
               'display': 'block'
            });
         })
      },

      /* process_checkout */
      process_checkout: function() {
         $('#checkout-button').on('click', function(e) {

            $(".cart_detail .cart-sidebar .message-error p").empty();
            e.preventDefault();
            var $this = $(this);
            var valid = 1;

            var el_checkout_event_nonce = $this.closest('#el_cart').find('#el_checkout_event_nonce').val();
            var cart = '';

            let id_event, id_cal, key_store, name, email, phone, address, address_required, phone_required, payment_method, coupon, seat_option;
            id_event = $(".cart_detail .cart-content .cart-ticket-info").attr('data-id-event');
            id_cal = $(".cart_detail .cart-content .cart-ticket-info").attr('data-id-cal');
            if (!id_event || !id_cal) {
               key_store = "";
            }

            name = $(".cart_detail .info_ticket_receiver li .span.fullname").text();
            email = $(".cart_detail .info_ticket_receiver li .span.email").text();
            phone = $(".cart_detail .info_ticket_receiver li .span.phone").text();
            address = $(".cart_detail .info_ticket_receiver li .span.address").text();
            address_required = $(".cart_detail .info_ticket_receiver li input.address_required").val();
            phone_required = $(".cart_detail .info_ticket_receiver li input.phone_required").val();
            coupon = $("#submit-code-discount").attr("data-discount-code");
            payment_method = $('input[name=payment]:checked').val();
            seat_option = $(".cart_detail .cart-content .cart-ticket-info").data("seat-option");

            key_store = id_event + '_' + id_cal;
            cart = localStorage.getItem(key_store);
            cart = JSON.parse(cart);

            $(".error-empty-input").css({
               "display": "none"
            });
            let flag = null;
            if (!$("#fullname").val()) {
               $(".error-fullname").css({
                  "display": "block"
               });
               $(".error-fullname").siblings("li").css({
                  "border-bottom": "1px solid #ccc"
               });
               $(".error-fullname").siblings("li").css({
                  "margin-bottom": "10px"
               });
               flag = 'error';
            }

            if (!$("#email").val()) {
               $(".error-email").css({
                  "display": "block"
               });
               $(".error-email").siblings("li").css({
                  "border-bottom": "1px solid #ccc"
               });
               $(".error-email").siblings("li").css({
                  "margin-bottom": "10px"
               });
               flag = 'error';
            }


            if (!$("#email_confirm").val()) {
               $(".error-email-confirm-require").css({
                  "display": "block"
               });
               $(".error-email-confirm-require").siblings("li").css({
                  "border-bottom": "1px solid #ccc"
               });
               $(".error-email-confirm-require").siblings("li").css({
                  "margin-bottom": "10px"
               });
               flag = 'error';
            } else {
               var email_confirm = $("#email_confirm").val();
               var email_one = $("#email").val();

               if( email_one != email_confirm ) {
                  $(".error-email-confirm-not-match").css({
                     "display": "block"
                  });
                  $(".error-email-confirm-not-match").siblings("li").css({
                     "border-bottom": "1px solid #ccc"
                  });
                  $(".error-email-confirm-not-match").siblings("li").css({
                     "margin-bottom": "10px"
                  });
                  flag = 'error';
               }
            }


            if (!$("#phone").val() && phone_required == 'true') {
               $(".error-phone").css({
                  "display": "block"
               });
               $(".error-phone").siblings("li").css({
                  "border-bottom": "1px solid #ccc"
               });
               $(".error-phone").siblings("li").css({
                  "margin-bottom": "10px"
               });
               flag = 'error';
            }

            if (!$("#address").val() && address_required == 'true') {
               $(".error-address").css({
                  "display": "block"
               });
               $(".error-address").siblings("li").css({
                  "border-bottom": "1px solid #ccc"
               });
               $(".error-address").siblings("li").css({
                  "margin-bottom": "10px"
               });
               flag = 'error';
            }

            if (!$('input:radio[name=payment]').is(':checked')) {
               $(".error-payment").css({
                  "display": "block"
               });
               flag = 'error';
            }

            var list_key_checkout_field = $('#el_list_key_checkout_field').val();

            var data_checkout_field = {};

            if(list_key_checkout_field) {
               list_key_checkout_field = JSON.parse(list_key_checkout_field);
               for( var key_ckf in list_key_checkout_field ) {


                  var value_ckf = $("#" + list_key_checkout_field[key_ckf] ).val();
                  var name_ckf = list_key_checkout_field[key_ckf];


                  if ( ! value_ckf && $("#" + list_key_checkout_field[key_ckf]).hasClass('required')) {
                     $( ".error-" + list_key_checkout_field[key_ckf] ).css({
                        "display": "block"
                     });
                     $( ".error-" + list_key_checkout_field[key_ckf] ).siblings("li").css({
                        "border-bottom": "1px solid #ccc"
                     });
                     $( ".error-"  + list_key_checkout_field[key_ckf] ).siblings("li").css({
                        "margin-bottom": "10px"
                     });
                     flag = 'error';
                  }

                  data_checkout_field[name_ckf] = value_ckf;


               }
            }


            if (flag !== null) {
            
               var h_wpadmin = $('#wpadminbar').outerHeight();
               var h_ovamenu = $(document).find('.ovamenu_shrink .elementor-container').height();

               $('html, body').animate({
                  scrollTop: ($(".cart_detail").offset().top - h_wpadmin - h_ovamenu)
               }, 1000);

               return false;
            }

            $(".submit-load-more").css({
               "z-index": "1"
            });

            if (valid) {
               $.post(ajax_object.ajax_url, {
                  action: 'el_process_checkout',
                  data: {
                     el_checkout_event_nonce: el_checkout_event_nonce,
                     cart: cart,
                     ide: id_event,
                     idcal: id_cal,
                     name: name,
                     email: email,
                     phone: phone,
                     address: address,
                     payment_method: payment_method,
                     coupon: coupon,
                     data_checkout_field: data_checkout_field,
                     seat_option: seat_option
                  },
               }, function(response) {

                  var data = JSON.parse(response);
                  var message_error = data.el_message;

                  // Check seat map
                  if (data.el_option == 'map') {
                     for (var i = data.el_content.length - 1; i >= 0; i--) {
                        for (var k = cart.length - 1; k >= 0; k--) {
                           if ( data.el_content[i] == cart[k].id ) cart.splice(k, 1);
                        }
                     }
                     localStorage.setItem(key_store, JSON.stringify(cart));
                     $(".cart_detail .cart-sidebar .message-error .auto_reload").append(data.el_reload_page);
                     setTimeout(function() {
                        location.reload();
                     }, 5000);
                  }

                  if (!message_error) {
                     localStorage.removeItem(key_store);
                     let url = data.el_url;
                     window.location.href = url;
                     $(".submit-load-more").css({
                        "z-index": "-1"
                     });
                  } else {
                     $(".cart_detail .cart-sidebar .message-error p").append(message_error);
                     $(".submit-load-more").css({
                        "z-index": "-1"
                     });
                  }
               });
            }
            
         });
      },

      /*** Image Profile ***/
      image_profile: function() {

         /* Add Image Banner */
         var file_frame;
         $(document).on('click', '.author_image .add_image', function(e) {

            e.preventDefault();

            if (typeof file_frame != 'undefined') {
               file_frame.close();
            }

            var that = $(this);

            file_frame = wp.media.frames.file_frame = wp.media({
               title: $(this).data('uploader-title'),
               button: {
                  text: $(this).data('uploader-button-text'),
               },
               library: {
                  type: ['image']
               },
               multiple: false
            });

            file_frame.on('select', function() {
               var selection = file_frame.state().get('selection');

               selection.map(function(attachment, i) {
                  attachment = attachment.toJSON();
                  
                  if (attachment.sizes.el_thumbnail) {
                     that.parent().find('.wrap').html('<img class="image-preview" src="' + attachment.sizes.el_thumbnail.url + '"><button class="button remove_image">Remove Image</button>');
                     that.closest('.vendor_wrap').find('.vendor_sidebar .vendor_user_profile .wrap_image').html('<img class="user_image" src="' + attachment.sizes.el_thumbnail.url + '">');
                  } else {
                     that.parent().find('.wrap').html('<img class="image-preview" src="' + attachment.sizes.full.url + '"><button class="button remove_image">Remove Image</button>');
                     that.closest('.vendor_wrap').find('.vendor_sidebar .vendor_user_profile .wrap_image').html('<img class="user_image" src="' + attachment.sizes.full.url + '">');
                  }
                  that.parent().find('input').val(attachment.id);

                  // Change image profile sidebar
               });
            });

            file_frame.open();
         });

         /* Remove Image Banner */
         $(document).on('click', '.author_image .remove_image', function(e) {
            e.preventDefault();
            $(this).closest('.author_image').find('input').val('');
            $(this).parent().empty();
            $('.vendor_user_profile .wrap_image').empty();
         });
      },

      /*** Update Profile ***/
      update_profile: function() {
         $(document).on('click', 'input[name="el_update_profile"]', function(e) {
            e.preventDefault();

            var el_update_profile_nonce = $(this).closest('#el_save_profile').find('#el_update_profile_nonce').val();
            var author_id_image = $(this).closest('#el_save_profile').find('#author_id_image').val();
            var display_name = $(this).closest('#el_save_profile').find('#display_name').val();
            var user_job = $(this).closest('#el_save_profile').find('#user_job').val();
            var user_phone = $(this).closest('#el_save_profile').find('#user_phone').val();
            var user_address = $(this).closest('#el_save_profile').find('#user_address').val();
            var description = $(this).closest('#el_save_profile').find('#description').val();

            $.post(ajax_object.ajax_url, {
               action: 'el_update_profile',
               data: {
                  el_update_profile_nonce: el_update_profile_nonce,
                  author_id_image: author_id_image,
                  display_name: display_name,
                  user_job: user_job,
                  user_phone: user_phone,
                  user_address: user_address,
                  description: description,
               },
            }, function(a) {
               // console.log(a);
               if (a) {
                  location.reload();
               }
            });

         });
      },

      /*** Add social ***/
      add_social: function() {
         $(document).on('click', '#author_social .add_social', function(e) {
            e.preventDefault();

            var index = $(this).parent().find('.social_item').length;
            var that = $(this);
            $.post(ajax_object.ajax_url, {
               action: 'el_add_social',
               data: {
                  index: index,
               },
            }, function(a) {
               that.parent().find('.social_list').append(a);
               // $('select').select2({
               //    width: '100%'
               // });
            });
            EL_Frontend.remove_social();
         });
      },

      /*** Save social ***/
      save_social: function() {
         $(document).on('click', 'input[name="el_update_social"]', function(e) {
            e.preventDefault();

            var el_update_social_nonce = $(this).closest('#el_save_social').find('#el_update_social_nonce').val();
            var user_profile_social = [];

            $(this).closest('#el_save_social').find('.social_item').each(function() {
               var selectedIcon = $(this).find('.icon_social').val();
               var link_social = $(this).find('.link_social').val();

               var social_item = [link_social, selectedIcon];
               user_profile_social.push(social_item);
            });

            var that = $(this);

            $.post(ajax_object.ajax_url, {
               action: 'el_save_social',
               data: {
                  el_update_social_nonce: el_update_social_nonce,
                  user_profile_social: user_profile_social,
               },
            }, function(a) {
               location.reload();
            });

            EL_Frontend.repair_key_social();
         });
      },

      /*** Remove social ***/
      remove_social: function() {
         $(document).on('click', '#author_social .remove_social', function(e) {
            e.preventDefault();

            $(this).parent().remove();

            EL_Frontend.repair_key_social();
         });
      },

      /*** Repair key social ***/
      repair_key_social: function() {
         var i = 0;

         $(document).find('#author_social .social_item').each(function() {

            $(this).find('.link_social').attr('name', 'user_profile_social[' + i + '][link]');
            $(this).find('.icon_social').attr('name', 'user_profile_social[' + i + '][icon]');

            i++;
         });
      },

      /*** Check password ***/
      check_password: function() {
         $('#author_password #old_password').on('keyup', function() {
            var old_password = $(this).val();
            var that = $(this);

            $.post(ajax_object.ajax_url, {
               action: 'el_check_password',
               data: {
                  old_password: old_password,
               },
            }, function(response) {
               if (response == 'false') {
                  $('.check_old_pass').css('display', 'block');
                  that.closest('form').attr('novalidate', 'novalidate');
               } else {
                  $('.check_old_pass').css('display', 'none')
                  that.closest('form').removeAttr('novalidate');
               };
            });
         });

         $('input[name="el_update_password"]').click(function(event) {
            $("#el_save_password").validate({
               rules: {
                  old_password: "required",
                  new_password: "required",
                  confirm_password: {
                     equalTo: '#new_password'
                  }
               }
            });
         });
      },

      /*** Change password ***/
      change_password: function() {
         $('#author_password input[name="el_update_password"]').on('click', function(e) {
            e.preventDefault();
            // alert('x');
            var that = $(this);

            var valid = $(this).closest('form').valid();

            var el_update_password_nonce = that.closest('#el_save_password').find('#el_update_password_nonce').val();
            var old_password = that.closest('#el_save_password').find('#old_password').val();
            var new_password = that.closest('#el_save_password').find('#new_password').val();

            if (valid) {
               $.post(ajax_object.ajax_url, {
                  action: 'el_change_password',
                  data: {
                     el_update_password_nonce: el_update_password_nonce,
                     old_password: old_password,
                     new_password: new_password,
                  },
               }, function(response) {
                  if (response == 'true') {
                     location.reload();
                  }
               });
            }
         });
      },

      /*** View password ***/
      view_password: function() {
         $(document).find('.show_pass').toggle(
            function() {
               $(this).find('i').removeClass();
               $(this).find('i').addClass('dashicons dashicons-visibility');
               $(this).parent().find('input').attr('type', 'text');
            },
            function() {
               $(this).find('i').removeClass();
               $(this).find('i').addClass('dashicons dashicons-hidden');
               $(this).parent().find('input').attr('type', 'password');
            }
         );
      },

      /*** Selected Event ***/
      select_event: function() {
         $(document).find('.wrap_event .check_all_event').change(function() {
            var checked = $(this).prop('checked');
            if (checked) {
               $(this).closest('table').find('input[type=checkbox]').attr('checked', 'checked');
            } else {
               $(this).closest('table').find('input[type=checkbox]').removeAttr('checked');
            }
         });

         $(document).find('tbody .check_event input').change(function() {
            var count_post = $(this).closest('tbody').find('.check_event input').length;
            var count_post_selected = $(this).closest('tbody').find('.check_event input:checked').length;

            if (count_post == count_post_selected) {
               $(this).closest('table').find('thead input[type=checkbox]').attr('checked', 'checked');
            } else {
               $(this).closest('table').find('thead input[type=checkbox]').removeAttr('checked');
            }

         });
      },

      /*** Pending Post ***/
      el_pending_post: function() {
         $(document).find('.vendor_listing .action .pending, .vendor_listing .action .restore').on('click', function(e) {
            e.preventDefault();

            if (!confirm('Are you sure?')) return;

            var post_id = $(this).closest('.action').find("input[name^='post_id']").val();

            var el_pending_post_nonce = $(this).parent().find('#el_pending_post_nonce').val();

            $.post(ajax_object.ajax_url, {
               action: 'el_pending_post',
               data: {
                  post_id: post_id,
                  el_pending_post_nonce: el_pending_post_nonce,
               },
            }, function(a) {
               if (a) {
                  location.reload();
               }
            });
         });
      },

      /*** Publish Post ***/
      el_publish_post: function() {
         $(document).find('.vendor_listing .action .publish').on('click', function(e) {
            e.preventDefault();

            if (!confirm('Move to Publish?')) return;

            var post_id = $(this).closest('.action').find("input[name^='post_id']").val();

            var el_publish_post_nonce = $(this).parent().find('#el_publish_post_nonce').val();

            $.post(ajax_object.ajax_url, {
               action: 'el_publish_post',
               data: {
                  post_id: post_id,
                  el_publish_post_nonce: el_publish_post_nonce,
               },
            }, function(a) {
               if (a) {
                  location.reload();
               }
            });
         });
      },

      /*** Trash Post ***/
      el_trash_post: function() {
         $(document).find('.vendor_listing .action .trash').on('click', function(e) {
            e.preventDefault();

            if (!confirm('Move to Trash?')) return;

            var post_id = $(this).closest('.action').find("input[name^='post_id']").val();

            var el_trash_post_nonce = $(this).parent().find('#el_trash_post_nonce').val();

            $.post(ajax_object.ajax_url, {
               action: 'el_trash_post',
               data: {
                  post_id: post_id,
                  el_trash_post_nonce: el_trash_post_nonce,
               },
            }, function(a) {
               if (a) {
                  location.reload();
               }
            });
         });
      },

      /*** Trash Post ***/
      el_delete_post: function() {
         $(document).find('.vendor_listing .action .delete').on('click', function(e) {
            e.preventDefault();

            if (!confirm('Are you SURE you want to delete permanently this post?')) return;

            var post_id = $(this).closest('.action').find("input[name^='post_id']").val();

            var el_delete_post_nonce = $(this).parent().find('#el_delete_post_nonce').val();

            $.post(ajax_object.ajax_url, {
               action: 'el_delete_post',
               data: {
                  post_id: post_id,
                  el_delete_post_nonce: el_delete_post_nonce,
               },
            }, function(a) {
               if (a) {
                  location.reload();
               }
            });
         });
      },

      /*** Bulk Action Post ***/
      el_bulk_action: function() {
         $(document).find('.vendor_listing .bulk_action input').on('click', function(e) {
            e.preventDefault();
            var value_select = $(this).parent().find('select').val();
            var el_bulk_action_nonce = $(this).parent().find('#el_bulk_action_nonce').val();

            var post_id = [];

            $(this).closest('.vendor_listing').find(".check_event input[name^='post_id']").each(function() {
               if ($(this).prop('checked') == true) {
                  post_id.push($(this).val());
               }
            });

            if (value_select == 'publish') {

               var confirmation = confirm('Move to Publish?');
               bulk_action(confirmation, el_bulk_action_nonce, post_id, value_select)

            } else if (value_select == 'trash') {

               var confirmation = confirm('Move to Trash?');
               bulk_action(confirmation, el_bulk_action_nonce, post_id, value_select)

            } else if (value_select == 'pending' || value_select == 'restore') {

               var confirmation = confirm('Move to Pending?');
               bulk_action(confirmation, el_bulk_action_nonce, post_id, value_select)

            } else if (value_select == 'delete') {

               var confirmation = confirm('Are you SURE you want to delete permanently this post?');
               bulk_action(confirmation, el_bulk_action_nonce, post_id, value_select)
            }

         });

         function bulk_action(confirmation, el_bulk_action_nonce, post_id, value_select) {

            if (confirmation) {
               $.post(ajax_object.ajax_url, {
                  action: 'el_bulk_action',
                  data: {
                     el_bulk_action_nonce: el_bulk_action_nonce,
                     post_id: post_id,
                     value_select: value_select,
                  },
               }, function(a) {
                  if (a) {
                     location.reload();
                  }
               });
            }
         }
      },

      /* Edit Latitude Longitude */
      edit_lat_lng: function() {
         $(document).find('.location #editor_latlng').change(function() {
            var checked = $(this).prop('checked');
            if (checked) {
               $(this).parents('.edit_latlng').find('.wrap_lnglat input').removeClass('readonly');
               $(this).parents('.edit_latlng').find('.wrap_lnglat input').removeAttr('readonly');
            } else {
               $(this).parents('.edit_latlng').find('.wrap_lnglat input').attr('readonly', 'readonly').addClass('readonly');
               $(this).parents('.edit_latlng').find('.wrap_lnglat input').attr('readonly', 'readonly');
            }
         });
      },

      cut_string_cat: function() {
         $('.vendor_listing .tags').each(function() {
            var cat = $(this).html().trim().slice(0, -1);
            $(this).html(cat);
         });
      },

      /* Image Feature */
      image_feature: function() {
         var image_feature;
         $(document).on('click', '.image_feature .add_image', function(e) {

            e.preventDefault();

            if (typeof image_feature != 'undefined') {
               image_feature.close();
            }

            var that = $(this);

            image_feature = wp.media({
               title: $(this).data('uploader-title'),
               button: {
                  text: $(this).data('uploader-button-text'),
               },
               library: {
                  type: ['image']
               },
               multiple: false
            });

            image_feature.on('select', function() {
               var selection = image_feature.state().get('selection');

               selection.map(function(attachment, i) {
                  attachment = attachment.toJSON();

                  that.closest('.image_feature').find('.wrap').html('<img class="image-preview" src="' + attachment.sizes.full.url + '"><button class="button remove_image"><i class="far fa-trash-alt"></i></button>');
                  that.closest('.image_feature').find('input').val(attachment.id);
               });
            });

            image_feature.open();
         });

         /* Remove Image Feature */
         $(document).on('click', '.image_feature .remove_image', function(e) {
            e.preventDefault();
            $(this).closest('.image_feature').find('input').val('');
            $(this).parent().empty();
         });
      },

      /* Image Gallery */
      add_image_gallery: function() {
         var file_frame;
         $(document).on('click', '.image_gallery .add_image_gallery', function(e) {

            e.preventDefault();

            if (typeof file_frame != 'undefined') {
               file_frame.close();
            }

            var that = $(this);

            file_frame = wp.media({
               title: $(this).data('uploader-title'),
               button: {
                  text: $(this).data('uploader-button-text'),
               },
               library: {
                  type: ['image']
               },
               multiple: true
            });

            file_frame.on('select', function() {

               var selection = file_frame.state().get('selection');

               var listIndex = that.parent().find('.gallery_item:last').index();
               var index = listIndex + 1;

               selection.map(function(attachment, i) {
                  attachment = attachment.toJSON();

                  $.post(ajax_object.ajax_url, {
                     action: 'add_image_gallery',
                     data: {
                        attachment: attachment,
                        index: index,
                     },
                  }, function(response) {
                     that.parent().find('.gallery_list').append(response);
                     EL_Frontend.reset_index_gallery();
                  });
               });
            });

            file_frame.open();
         });
      },

      /* Reset Index Gallery */
      reset_index_gallery: function() {
         $('.image_gallery .gallery_item').each(function(i) {
            $(this).find('input:hidden').attr('name', 'ova_mb_event_gallery[' + i + ']');
         });
      },

      /* Change Image Gallery */
      change_image_gallery: function() {
         var file_frame;
         $(document).on('click', '.image_gallery .change_image_gallery', function(e) {

            e.preventDefault();

            if (typeof file_frame != 'undefined') {
               file_frame.close();
            }

            var that = $(this);

            file_frame = wp.media({
               title: $(this).data('uploader-title'),
               button: {
                  text: $(this).data('uploader-button-text'),
               },
               library: {
                  type: ['image']
               },
               multiple: false
            });

            file_frame.on('select', function(attachment) {
               attachment = file_frame.state().get('selection').first().toJSON();
               var index = that.parent().index();

               $.post(ajax_object.ajax_url, {
                  action: 'change_image_gallery',
                  data: {
                     attachment: attachment,
                     index: index,
                  },
               }, function(response) {
                  that.parent().html(response);
                  EL_Frontend.reset_index_gallery();
               });
            });


            file_frame.open();
         });
      },

      /* Remove Image Gallery */
      remove_image_gallery: function() {
         $(document).on('click', '.image_gallery .remove_image', function(e) {
            e.preventDefault();
            $(this).closest('.gallery_item').find('input').val('');
            $(this).parent().remove();
            EL_Frontend.reset_index_gallery();
         });
      },

      /*** Radio Single Banner ***/
      radio_single_banner: function() {
         $('.single_banner').on('click', function() {
            var val = $(this).val()
            if (val == 'gallery' || val == 'video') {
               $(this).closest('.single_banner').find('.image_banner').css('display', 'none');
            } else {
               $(this).closest('.single_banner').find('.image_banner').css('display', 'block');
            }

         });
      },

      /*** Image Banner ***/
      image_banner: function() {

         /* Add Image Banner */
         $('.add_image_banner').on('click', function(e) {
            e.preventDefault();

            var that = $(this);

            wp.media.editor.send.attachment = function(prop, attachment) {

               $(that).parent().find('input').val(attachment.id);
               $(that).parent().find('.content_image').html('<img class="image-preview-banner" src="' + attachment.sizes.full.url + '" alt="image banner" style="max-height: 200px;"><button class="button remove_image_banner">Remove</button> ');

            }
            wp.media.editor.open(that);
         });

         /* Remove Image Banner */
         $(document).on('click', '.remove_image_banner', function(e) {
            e.preventDefault();
            $(this).closest('.image_banner').find('input').val('');
            $(this).parent().empty();
         });
      },

      /* Save Event */
      el_save_edit_event: function() {
         $(document).find('.el_edit_event_submit').on('click', function(e) {
            e.preventDefault();

            $(".vendor_wrap p.error-total-event").css('display', 'none');
            $(".vendor_wrap p.error-time-limit").css('display', 'none');
            var that = $(this);
            var prefix = that.parents('.vendor_edit_event').find('#ova_prefix').val();
            var el_edit_event_nonce = that.parents('.vendor_edit_event').find('#el_edit_event_nonce').val();
            var post_id = that.parents('.vendor_edit_event').find('#post_id').val();

            var name_event = that.parents('.vendor_edit_event').find('#name_event').val();
            var event_tax = that.parents('.vendor_edit_event').find('#event_tax').val();

            var event_type = that.parents('.vendor_edit_event').find("input[name='ova_mb_event_event_type']:checked").val();
            var ticket_link = that.parents('.vendor_edit_event').find("input[name='ova_mb_event_ticket_link']:checked").val();
            var ticket_external_link = that.parents('.vendor_edit_event').find('input[name="ova_mb_event_ticket_external_link"]').val();

            tinyMCE.init({
               mode: "specific_textareas",
               editor_selector: "wp-editor-area"
            });
            var content_event = tinyMCE.get('content_event').getContent();


            var data_taxonomy = {};

            var list_taxonomy = that.parents('.vendor_edit_event').find('#el_list_slug_taxonomy').val();
            if( list_taxonomy ) {
               list_taxonomy = JSON.parse(list_taxonomy);
               for( var key in list_taxonomy ) {
                  console.log('slug_tax: ' + list_taxonomy[key]);
                  data_taxonomy[list_taxonomy[key]] = that.parents('.vendor_edit_event').find('#' + list_taxonomy[key]).val();

               }
            }

            var time_zone = that.parents('.vendor_edit_event').find('#time_zone').val();
            var event_cat = that.parents('.vendor_edit_event').find('#event_cat').val();
            var event_tag = that.parents('.vendor_edit_event').find('#event_tag').val();
            event_tag = event_tag.split(",").slice(0, 6);

            var status_pay = that.parents('.vendor_edit_event').find('#event_status_pay').val();

            var event_state = that.parents('.vendor_edit_event').find('#event_state').val();
            var event_city = that.parents('.vendor_edit_event').find('#event_city').val();

            var venue = [];
            that.parents('.vendor_edit_event').find('#data_venue li').each(function() {
               var arr_venue = $(this).find('span').html();
               venue.push(arr_venue);
            });

            var address = that.parents('.vendor_edit_event').find('#address').val();
            var map_lat = that.parents('.vendor_edit_event').find('#map_lat').val();
            var map_lng = that.parents('.vendor_edit_event').find('#map_lng').val();
            var map_address = that.parents('.vendor_edit_event').find('#pac-input').val();
            var edit_full_address = that.parents('.vendor_edit_event').find('#edit_full_address').val();

            var info_organizer = that.parents('.vendor_edit_event').find('#info_organizer').val();
            var name_organizer = that.parents('.vendor_edit_event').find('#name_organizer').val();
            var phone_organizer = that.parents('.vendor_edit_event').find('#phone_organizer').val();
            var mail_organizer = that.parents('.vendor_edit_event').find('#mail_organizer').val();
            var job_organizer = that.parents('.vendor_edit_event').find('#job_organizer').val();

            var social_organizer = [];
            that.parents('.vendor_edit_event').find('.social_item').each(function() {
               var array_social = [];

               var array_social = {
                  'link_social': $(this).find('.link_social').val(),
                  'icon_social': $(this).find('.icon_social').val()
               };
               social_organizer.push(array_social);
            });

            var img_thumbnail = that.parents('.vendor_edit_event').find('#img_thumbnail').val();

            var gallery = [];
            that.parents('.vendor_edit_event').find('.gallery_item').each(function() {
               var gallery_id = $(this).find('.gallery_id').val();
               gallery.push(gallery_id);
            });

            // Gallery & Video
            var link_video = that.parents('.vendor_edit_event').find('#link_video').val();
            
            var single_banner = that.parents('.vendor_edit_event').find('#single_banner:checked').val();
            var image_banner = that.parents('.vendor_edit_event').find('#image_banner').val();

            // Ticket
            var seat_option = that.parents('.vendor_edit_event').find('.seat_option:checked').val();
            var textare_seat_option = that.parents('.vendor_edit_event').find('#textare_seat_option').val();

            // Ticket map
            var short_code_map = that.parents('.vendor_edit_event').find('#short_code_map').val();
            var number_min_ticket_map = that.parents('.vendor_edit_event').find('.number_min_ticket_map').val();
            var number_max_ticket_map = that.parents('.vendor_edit_event').find('.number_max_ticket_map').val();
            var start_ticket_date_map = that.parents('.vendor_edit_event').find('.start_ticket_date_map').val();
            var start_ticket_time_map = that.parents('.vendor_edit_event').find('.start_ticket_time_map').val();
            var close_ticket_date_map = that.parents('.vendor_edit_event').find('.close_ticket_date_map').val();
            var close_ticket_time_map = that.parents('.vendor_edit_event').find('.close_ticket_time_map').val();
            var color_ticket_map = that.parents('.vendor_edit_event').find('.color_ticket_map').val();
            var color_label_ticket_map = that.parents('.vendor_edit_event').find('.color_label_ticket_map').val();
            var color_content_ticket_map = that.parents('.vendor_edit_event').find('.color_content_ticket_map').val();
            var desc_ticket_map = that.parents('.vendor_edit_event').find('.desc_ticket_map').val();
            var private_desc_ticket_map = that.parents('.vendor_edit_event').find('.private_desc_ticket_map').val();
            var map_image_ticket = that.parents('.vendor_edit_event').find('input.image_ticket_map').val();
            

            var ticket_map = {
               'short_code_map': short_code_map,
               'number_min_ticket': number_min_ticket_map,
               'number_max_ticket': number_max_ticket_map,
               'start_ticket_date': start_ticket_date_map,
               'start_ticket_time': start_ticket_time_map,
               'close_ticket_date': close_ticket_date_map,
               'close_ticket_time': close_ticket_time_map,
               'color_ticket': color_ticket_map,
               'color_label_ticket': color_label_ticket_map,
               'color_content_ticket': color_content_ticket_map,
               'desc_ticket': desc_ticket_map,
               'private_desc_ticket_map': private_desc_ticket_map,
               'image_ticket': map_image_ticket,
               'desc_seat': [],
               'seat': []
            };
            that.parents('.vendor_edit_event').find('.item_desc_seat').each(function() {
               let arr_ticket_map = {
                  'map_type_seat': $(this).find('.map_type_seat').val(),
                  'map_price_type_seat': $(this).find('.map_price_type_seat').val(),
                  'map_desc_type_seat': $(this).find('.map_desc_type_seat').val(),
                  'map_color_type_seat': $(this).find('.map_color_type_seat').val(),
               };
               ticket_map.desc_seat.push(arr_ticket_map);
            });
            that.parents('.vendor_edit_event').find('.item_seat').each(function() {
               let arr_ticket_map = {
                  'id': $(this).find('.map_name_seat').val(),
                  'price': $(this).find('.map_price_seat').val(),
               };
               ticket_map.seat.push(arr_ticket_map);
            });


            var ticket = [];
            that.parents('.vendor_edit_event').find('.ticket_item').each(function() {
               var arr_event = {
                  'ticket_id': $(this).find('#ticket_id').val(),
                  'name_ticket': $(this).find('#name_ticket').val(),

                  'type_price': $(this).find('#type_price:checked').val(),
                  'price_ticket': $(this).find('#price_ticket').val(),
                  'price_ticket_external': $(this).find('#price_ticket_external').val(),
                  'number_total_ticket': $(this).find('#number_total_ticket').val(),
                  'number_min_ticket': $(this).find('#number_min_ticket').val(),
                  'number_max_ticket': $(this).find('#number_max_ticket').val(),

                  'start_ticket_date': $(this).find('.start_ticket_date').val(),
                  'start_ticket_time': $(this).find('#start_ticket_time').val(),
                  'close_ticket_date': $(this).find('.close_ticket_date').val(),
                  'close_ticket_time': $(this).find('#close_ticket_time').val(),

                  'color_ticket': $(this).find('#color_ticket').val(),
                  'color_label_ticket': $(this).find('#color_label_ticket').val(),
                  'color_content_ticket': $(this).find('#color_content_ticket').val(),

                  'desc_ticket': $(this).find('#desc_ticket').val(),
                  'private_desc_ticket': $(this).find('#private_desc_ticket').val(),
                  'online_link': $(this).find('#online_link').val(),
                  'online_password': $(this).find('#online_password').val(),
                  'online_other': $(this).find('#online_other').val(),
                  'image_ticket': $(this).find('#image_ticket').val(),
                  'seat_list': $(this).find('#seat_list').val(),
                  'setup_seat': $(this).find('#setup_seat:checked').val(),
               };
               ticket.push(arr_event);
            });

            var calendar = [];
            that.parents('.vendor_edit_event').find('.item_calendar').each(function() {
               var arr_calendar = {
                  'calendar_id': $(this).find('.calendar_id').val(),
                  'date': $(this).find('.calendar_date').val(),
                  'end_date': $(this).find('.calendar_end_date').val(),
                  'start_time': $(this).find('.calendar_start_time').val(),
                  'end_time': $(this).find('.calendar_end_time').val(),
               };
               calendar.push(arr_calendar);
            });

            var disable_date = [];
            that.parents('.vendor_edit_event').find('.item_disable_date').each(function() {
               var arr_disable_date = {
                  'start_date': $(this).find('.start_date').val(),
                  'end_date': $(this).find('.end_date').val(),
               };
               disable_date.push(arr_disable_date);
            });

            var api_key = that.parents('.vendor_edit_event').find('.api_key').val();

            var allow_cancellation_booking = that.parents('.vendor_edit_event').find('input[name="ova_mb_event_allow_cancellation_booking"]:checked').val();
            var cancel_before_x_day = that.parents('.vendor_edit_event').find('input[name="ova_mb_event_cancel_before_x_day"]').val();
            

            var option_calendar = that.parents('.vendor_edit_event').find('.option_calendar:checked').val();
            var calendar_recurrence_id = that.parents('.vendor_edit_event').find('.calendar_recurrence_id').val();
            var calendar_recurrence_start_time = that.parents('.vendor_edit_event').find('.calendar_recurrence_start_time').val();
            var calendar_recurrence_end_time = that.parents('.vendor_edit_event').find('.calendar_recurrence_end_time').val();
            var recurrence_frequency = that.parents('.vendor_edit_event').find('#recurrence-frequency option:selected').val();
            var recurrence_interval = that.parents('.vendor_edit_event').find('#recurrence-interval').val();
            var recurrence_byweekno = that.parents('.vendor_edit_event').find('#monthly-modifier option:selected').val();
            var recurrence_byday = that.parents('.vendor_edit_event').find('#recurrence-weekday option:selected').val();
            var recurrence_bydays = [];
            that.parents('.vendor_edit_event').find("#weekly-selector input:checked").each(function() {
               recurrence_bydays.push($(this).val());
            });
            var calendar_start_date = that.parents('.vendor_edit_event').find('.calendar_auto_start_date').val();
            var calendar_end_date = that.parents('.vendor_edit_event').find('.calendar_auto_end_date').val();

            /* Coupon */
            var coupon = [];
            that.parents('.vendor_edit_event').find('.item_coupon').each(function() {

               var list_ticket = [];
               $(this).find('.list_ticket:checked').each(function() {
                  list_ticket.push($(this).val());
               });

               var arr_coupon = {
                  'coupon_id': $(this).find('.coupon_id').val(),
                  'discount_code': $(this).find('.discount_code').val(),
                  'discount_amout_number': $(this).find('.discount_amout_number').val(),
                  'discount_amount_percent': $(this).find('.discount_amount_percent').val(),
                  'start_date': $(this).find('.coupon_start_date').val(),
                  'start_time': $(this).find('.coupon_start_time').val(),
                  'end_date': $(this).find('.coupon_end_date').val(),
                  'end_time': $(this).find('.coupon_end_time').val(),
                  'all_ticket': $(this).find('.coupon_all_ticket').val(),
                  'quantity': $(this).find('.coupon_quantity').val(),
                  'list_ticket': list_ticket,
               };
               coupon.push(arr_coupon);
            });

            if (that.parents('.vendor_edit_event > form').valid()) {
               $(".vendor_wrap .wrap_btn_submit .submit-load-more").css('z-index', '3');

               $.post(ajax_object.ajax_url, {
                  action: 'el_save_edit_event',
                  data: {
                     el_edit_event_nonce: el_edit_event_nonce,
                     post_id: post_id,

                     name_event: name_event,
                     event_tax: event_tax,
                     event_type: event_type,
                     ticket_link: ticket_link,
                     ticket_external_link: ticket_external_link,
                     content_event: content_event,
                     event_cat: event_cat,
                     time_zone: time_zone,
                     data_taxonomy: data_taxonomy,
                     event_tag: event_tag,

                     status_pay: status_pay,

                     event_state: event_state,
                     event_city: event_city,
                     venue: venue,
                     address: address,
                     map_lat: map_lat,
                     map_lng: map_lng,
                     map_address: map_address,
                     edit_full_address: edit_full_address,

                     info_organizer: info_organizer,
                     name_organizer: name_organizer,
                     phone_organizer: phone_organizer,
                     mail_organizer: mail_organizer,
                     job_organizer: job_organizer,
                     social_organizer: social_organizer,

                     img_thumbnail: img_thumbnail,
                     gallery: gallery,
                     link_video: link_video,
                     
                     single_banner: single_banner,
                     image_banner: image_banner,

                     seat_option: seat_option,
                     textare_seat_option: textare_seat_option,
                     ticket: ticket,

                     ticket_map: ticket_map,

                     option_calendar: option_calendar,
                     calendar_recurrence_start_time: calendar_recurrence_start_time,
                     calendar_recurrence_end_time: calendar_recurrence_end_time,
                     recurrence_frequency: recurrence_frequency,
                     recurrence_interval: recurrence_interval,
                     recurrence_byweekno: recurrence_byweekno,
                     recurrence_byday: recurrence_byday,
                     recurrence_bydays: recurrence_bydays,
                     calendar_start_date: calendar_start_date,
                     calendar_end_date: calendar_end_date,
                     calendar: calendar,
                     disable_date: disable_date,

                     coupon: coupon,
                     api_key: api_key,
                     allow_cancellation_booking: allow_cancellation_booking,
                     cancel_before_x_day: cancel_before_x_day

                  },
               }, function(response) {
                  if (response == 'updated') {
                     location.reload();
                  } else if (response == 'false_total_event') {
                     $(".vendor_wrap p.error-total-event").css('display', 'block');
                     $(".vendor_wrap .wrap_btn_submit .submit-load-more").css('z-index', '-1');
                     return false;
                  } else if (response == 'false_time_membership') {
                     $(".vendor_wrap p.error-time-limit").css('display', 'block');
                     $(".vendor_wrap .wrap_btn_submit .submit-load-more").css('z-index', '-1');
                     return false;
                  } else {
                     window.location.replace(window.location.pathname + '?vendor=listing-edit&id=' + response);
                  }
                  $(".vendor_wrap .wrap_btn_submit .submit-load-more").css('z-index', '-1');
               });
            }
         });
      },

      export_csv: function() {
         $("#export-csv-extra").on("click", function() {
            $(this).siblings(".list-check-export-csv").slideToggle();
         });
         $("#button-submit-export-csv").on("click", function() {
            var id_event = $(this).attr("data-id-event");
            var slug_event = $(this).attr("data-slug-event");
            var li = $(this).siblings("ul").children("li");

            var check_id_booking = false;
            var check_event = false;
            var check_calendar = false;
            var check_name = false;
            var check_phone = false;
            var check_email = false;
            var check_total = false;
            var check_status = false;
            var check_ticket_type = false;
            var check_date_create = false;

            var list_ckf_check = {};

            var list_name_ckf = $('#el_list_ckf').val();
            if( list_name_ckf ) {
               list_name_ckf = JSON.parse(list_name_ckf);
               for( var key in list_name_ckf ){
                  if (li.children("input[name='"+list_name_ckf[key]+"']").is(':checked')) {
                     list_ckf_check[key] = list_name_ckf[key];
                  }
               }
            }




            if (li.children("input[name='id_booking']").is(':checked')) {
               check_id_booking = li.children("input[name='id_booking']").val();
            }

            if (li.children("input[name='event']").is(':checked')) {
               check_event = li.children("input[name='id_booking']").val();
            }

            if (li.children("input[name='calendar']").is(':checked')) {
               check_calendar = li.children("input[name='calendar']").val();
            }

            if (li.children("input[name='name']").is(':checked')) {
               check_name = li.children("input[name='name']").val();
            }

            if (li.children("input[name='phone']").is(':checked')) {
               check_phone = li.children("input[name='phone']").val();
            }

            if (li.children("input[name='email']").is(':checked')) {
               check_email = li.children("input[name='email']").val();
            }

            if (li.children("input[name='total']").is(':checked')) {
               check_total = li.children("input[name='total']").val();
            }

            if (li.children("input[name='status']").is(':checked')) {
               check_status = li.children("input[name='status']").val();
            }

            if (li.children("input[name='ticket_type']").is(':checked')) {
               check_ticket_type = li.children("input[name='ticket_type']").val();
            }

            if (li.children("input[name='date_create']").is(':checked')) {
               check_date_create = li.children("input[name='date_create']").val();
            }


            // console.log('check id_booking: ' + id_booking);
            $.post(ajax_object.ajax_url, {
               action: 'el_export_csv',
               data: {
                  id_event: id_event,
                  check_id_booking: check_id_booking,
                  check_event: check_event,
                  check_calendar: check_calendar,
                  check_name: check_name,
                  check_phone: check_phone,
                  check_email: check_email,
                  check_total: check_total,
                  check_status: check_status,
                  check_ticket_type: check_ticket_type,
                  check_date_create: check_date_create,
                  list_ckf_check: list_ckf_check,
               },
            }, function(response) {
               var data = response;
               // console.log(data);

               var data = JSON.parse(data);
               let csvContent = "data:text/csv;charset=utf-8," + "\uFEFF";

               data.forEach(function(rowArray) {
                  let row = rowArray.join(",");
                  csvContent += row + "\r\n";
               });

               var encodedUri = encodeURI(csvContent);
               var link = document.createElement("a");
               link.setAttribute("href", encodedUri);
               link.setAttribute("download", "list_bookings_" + slug_event + "_" + id_event + ".csv");
               document.body.appendChild(link); // Required for FF
               link.click();
            });
         });
      },

      export_csv_ticket: function() {
         $("#export-csv-extra-ticket").on("click", function() {
            $(this).siblings(".list-check-export-csv").slideToggle();
         });
         $("#button-submit-ticket-export-csv").on("click", function() {
            var id_event = $(this).attr("data-id-event");
            var slug_event = $(this).attr("data-slug-event");
            var li = $(this).siblings("ul").children("li");

            var check_event = false;
            var check_ticket_type = false;
            var check_name = false;
            var check_venue = false;
            var check_address = false;
            var check_seat = false;
            var check_qr_code = false;
            var check_start_date = false;
            var check_end_date = false;
            var check_date_create = false;

            var list_ckf_check = {};

            var list_name_ckf = $('#el_list_ckf').val();
            if( list_name_ckf ) {
               list_name_ckf = JSON.parse(list_name_ckf);
               for( var key in list_name_ckf ){
                  if (li.children("input[name='"+list_name_ckf[key]+"']").is(':checked')) {
                     list_ckf_check[key] = list_name_ckf[key];
                  }
               }
            }

            if (li.children("input[name='event']").is(':checked')) {
               check_event = li.children("input[name='event']").val();
            }

            if (li.children("input[name='ticket_type']").is(':checked')) {
               check_ticket_type = li.children("input[name='ticket_type']").val();
            }

            if (li.children("input[name='name']").is(':checked')) {
               check_name = li.children("input[name='name']").val();
            }

            if (li.children("input[name='venue']").is(':checked')) {
               check_venue = li.children("input[name='venue']").val();
            }

            if (li.children("input[name='address']").is(':checked')) {
               check_address = li.children("input[name='address']").val();
            }

            if (li.children("input[name='seat']").is(':checked')) {
               check_seat = li.children("input[name='seat']").val();
            }

            if (li.children("input[name='qr_code']").is(':checked')) {
               check_qr_code = li.children("input[name='qr_code']").val();
            }

            if (li.children("input[name='start_date']").is(':checked')) {
               check_start_date = li.children("input[name='start_date']").val();
            }

            if (li.children("input[name='end_date']").is(':checked')) {
               check_end_date = li.children("input[name='end_date']").val();
            }

            if (li.children("input[name='date_create']").is(':checked')) {
               check_date_create = li.children("input[name='date_create']").val();
            }


            $.post(ajax_object.ajax_url, {
               action: 'export_csv_ticket',
               data: {
                  id_event: id_event,
                  check_event: check_event,
                  check_ticket_type: check_ticket_type,
                  check_name: check_name,
                  check_venue: check_venue,
                  check_address: check_address,
                  check_seat: check_seat,
                  check_qr_code: check_qr_code,
                  check_start_date: check_start_date,
                  check_end_date: check_end_date,
                  check_date_create: check_date_create,
                  list_ckf_check: list_ckf_check,
               },
            }, function(response) {
               var data = response;

               // console.log(data);

               var data = response;
               var data = JSON.parse(data);

               let csvContent = "data:text/csv;charset=UTF-8," + "\uFEFF";

               data.forEach(function(rowArray) {
                  let row = rowArray.join(",");
                  csvContent += row + "\r\n";
               });




               var encodedUri = encodeURI(csvContent);
               var link = document.createElement("a");
               link.setAttribute("href", encodedUri);
               link.setAttribute("download", "list_tickets_" + slug_event + "_" + id_event + ".csv");
               document.body.appendChild(link); // Required for FF
               link.click();
            });
         });
      },

      /* add package */
      add_package: function() {
         $(document).find('.register_package').on('click', function(e) {
            e.preventDefault();
            var $this = $(this);
            var $pid = $this.data('pid');
            if ($pid != undefined) {
               $.post(ajax_object.ajax_url, {
                  action: 'el_add_package',
                  data: {
                     pid: $pid
                  },
               }, function(response) {

                  var data = JSON.parse(response);

                  if (data.code == '0') {
                     alert(data.status);
                     window.location.replace(data.url);
                  } else {
                     window.location.replace(data.url);
                  }
               });
            }
         });
      },

      comment_rating: function() {
         $(document).find('.event-single .rating-container input').on('mouseover', function() {
            var onStar = parseInt($(this).data('value'), 6); /* The star currently mouse on */

            /* Now highlight all the stars that's not after the current hovered star */
            $(this).parent().children('.star').each(function(e) {
               if (e < onStar) {
                  $(this).addClass('hover');
               } else {
                  $(this).removeClass('hover');
               }
            });

         }).on('mouseout', function() {
            $(this).parent().children('.rating-container input').each(function(e) {
               $(this).removeClass('hover');
            });
         });

         /* 2. Action to perform on click */
         $(document).find('.event-single .rating-container input').on('click', function() {
            var onStar = parseInt($(this).data('value'), 6); /* The star currently selected */
            var stars = $(this).parent().children('.star');
            var i = 0;
            for (i = 0; i < stars.length; i++) {
               $(stars[i]).removeClass('selected');
            }
            for (i = 0; i < onStar; i++) {
               $(stars[i]).addClass('selected');
            }
         });
      },

      update_wishlist: function() {
         $("body").on("click", ".el-wishlist", function() {
            
            if( $(this).hasClass('active') ){
               var that = $(this);
               var id_event = $(this).attr("data-id");
               $.post(ajax_object.ajax_url, {
                  action: 'el_remove_wishlist',
                  data: {
                     id_event: id_event,
                  }
               }, function(response) {
                  that.removeClass('active');
               });
            }else{
               $(this).addClass('active');
               var id_event = $(this).attr("data-id");
               $.post(ajax_object.ajax_url, {
                  action: 'el_add_wishlist',
                  data: {
                     id_event: id_event,
                  }
               }, function(response) {
               
               });         
            }

         });

      },

     

      delete_wishlist: function() {
         $(".wishlist_active").off().on("click", function() {
            
               var that = $(this);
               var id_event = $(this).attr("data-id");
               $.post(ajax_object.ajax_url, {
                  action: 'el_remove_wishlist',
                  data: {
                     id_event: id_event,
                  }
               }, function(response) {
                  that.removeClass('active');
               });

         });
      },

      remove_wishlist: function() {
         $(".el-my-wishlist td a.close-wl").off().on("click", function() {
            $(this).parent("td").parent("tr").fadeOut(700);
            var id_event = $(this).attr("data-id");
            $.post(ajax_object.ajax_url, {
               action: 'el_remove_wishlist',
               data: {
                  id_event: id_event,
               }
            }, function(response) {
               // console.log(response);
            });
         });
      },

      slide_event_related: function() {
         if ($(".event_related .wrap_event").length > 0) {
            $(".event_related .wrap_event").owlCarousel({
               margin: 45,
               nav: true,
               responsive: {
                  0: {
                     items: 1
                  },
                  600: {
                     items: 2
                  },
                  1000: {
                     items: 3
                  }
               },
               navText: ['<i class="arrow_left"></i>', '<i class="arrow_right"></i>'],
            });
         }
      },

      slide_event_single_gallery: function() {
         if ($(".event-banner .gallery-banner .wrap_event").length > 0) {
            $(".event-banner .gallery-banner .wrap_event").owlCarousel({
               margin: 0,
               nav: true,
               dots: false,
               autoplay: true,
               autoplayTimeout: 8000,
               loop: true,
               responsive: {
                  0: {
                     items: 1
                  },
                  600: {
                     items: 2
                  },
                  1000: {
                     items: 3
                  }
               },
               navText: ['<i class="arrow_left"></i>', '<i class="arrow_right"></i>'],
            });
         }
      },

      banner_event_single: function() {
         if ($(document).find('.event-banner .single-banner').length = 1) {
            let widthBanner = $(document).find('.event-banner .single-banner');
            widthBanner.outerWidth();
            widthBanner.css('height', widthBanner.outerWidth() / 2.6);
         }

         $(window).resize(function() {
            if ($(document).find('.event-banner .single-banner').length = 1) {
               let widthBanner = $(document).find('.event-banner .single-banner');
               widthBanner.outerWidth();
               widthBanner.css('height', widthBanner.outerWidth() / 2.6);
            }
         });
      },

      /*** Show more Description ***/
      el_show_more_desc: function() {
         var that = $('.single-event .event_desc .wrap_content');

         var h_data = that.outerHeight();

         if (that.data('height') != 'auto' && that.data('height') < h_data) {
            that.css('height', that.data('height'));

            that.find('.el_show_more_desc').css({
               'display': 'block',
            });

            that.find('.el_show_more_desc .btn_showmore').on('click', function(e) {
               e.preventDefault();

               let parent = $(this).parents('.wrap_content');
               parent.animate({
                  height: parent.get(0).scrollHeight
               }, 1000);

               $(this).parent().hide();
            });
         }
      },

      /*** Update Bank ***/
      update_bank: function() {
         $(document).on('click', '.el_update_bank', function(e) {
            e.preventDefault();

            var el_update_bank_nonce = $(this).parent().find('#el_update_bank_nonce').val();
            var user_bank_owner = $(this).parent().find('#user_bank_owner').val();
            var user_bank_number = $(this).parent().find('#user_bank_number').val();
            var user_bank_name = $(this).parent().find('#user_bank_name').val();
            var user_bank_branch = $(this).parent().find('#user_bank_branch').val();
            var user_bank_routing = $(this).parent().find('#user_bank_routing').val();
            var user_bank_paypal_email = $(this).parent().find('#user_bank_paypal_email').val();
            var user_bank_stripe_account = $(this).parent().find('#user_bank_stripe_account').val();


            if ($(this).parent().valid()) {
               $.post(ajax_object.ajax_url, {
                  action: 'el_update_bank',
                  data: {
                     el_update_bank_nonce: el_update_bank_nonce,
                     user_bank_owner: user_bank_owner,
                     user_bank_number: user_bank_number,
                     user_bank_name: user_bank_name,
                     user_bank_branch: user_bank_branch,
                     user_bank_routing: user_bank_routing,
                     user_bank_paypal_email: user_bank_paypal_email,
                     user_bank_stripe_account: user_bank_stripe_account,
                  },
               }, function(cons) {
                  if (cons) {
                     location.reload();
                  }
               });
            }

         });
      },

      /*** Form Search ***/
      el_load_venue_search: function() {

         $('.wrap_form_search .venue input').autocomplete({
            source: function(request, response) {
               $.ajax({
                  url: ajax_object.ajax_url,
                  type: 'POST',
                  dataType: "json",
                  data: {
                     action: 'el_load_venue',
                     keyword: request.term,
                  },
                  success: function(data) {
                     response(data);
                  },

               })
            },
            delay: 0,
         });
      },

      datepicket_search: function() {
         $('.wrap_form_search .el_select_date').each(function() {
            var format = $(this).attr('data-format');

            $(this).datepicker({
               dateFormat: format,
               changeMonth: true,
               changeYear: true,
               onSelect: function() {
                  $('.wrap_form_search .el_all_time').val(" ");
                  var $option_default = $('.wrap_form_search .el_all_time option').first().html();
                  $('.wrap_form_search .el_all_time option').first().attr('selected', 'selected');
                  $('.wrap_form_search .el_all_time span.select2-selection__rendered').html($option_default);
                  $('.wrap_form_search .el_all_time span.select2-selection__rendered').attr('title', $option_default);
               }
            });
         });

         $('.wrap_form_search .el_all_time select').on('change', function() {
            $('.wrap_form_search .el_start_date input').val("");
            $('.wrap_form_search .el_end_date input').val("");
         });
      },

      el_load_location_search: function() {
         $('.el_search_filters .loc_state select').change(function() {
            var country = $(this).val();
            var $this = $(this).parents('.el_search_filters');

            if (country == '') {
               $('.el_search_filters .loc_city select').attr('disabled', 'disabled');
            } else {
               $('.el_search_filters .loc_city select').removeAttr('disabled');
            }

            $.post(ajax_object.ajax_url, {
               action: 'el_load_location',
               data: {
                  country: country,
               },
            }, function(response) {
               $this.find('#event_city').html(response);
            });
         });

         $(window).load(function() {
            var country = $('.el_search_filters .loc_state select option:selected').val();
            var city_selected = $('.el_search_filters .loc_city select option:selected').val();

            if (country == '') {
               $('.el_search_filters .loc_city select').attr('disabled', 'disabled');
            } else {
               $('.el_search_filters .loc_city select').removeAttr('disabled');
            }

            $.post(ajax_object.ajax_url, {
               action: 'el_load_location',
               data: {
                  country: country,
                  city_selected: city_selected,
               },
            }, function(response) {
               $('.el_search_filters').find('#event_city').html(response);
            });
         });

         /* Location Autocomplete */
         $('.wrap_form_search .loc_input [name="loc_input"]').autocomplete({
            source: function(request, response) {
               $.ajax({
                  url: ajax_object.ajax_url,
                  type: 'POST',
                  dataType: "json",
                  data: {
                     action: 'el_load_location_search',
                     keyword: request.term,
                  },
                  success: function(data) {
                     // console.log(data);
                     response(data);
                  },
               })
            },
            delay: 0,
         });
      },

      /* Search Map */
      el_search_map: function() {

         var zoomMap = parseInt($(document).find('.wrap_search_map .search_result').attr('data-zoom'));
         var latDefault = parseFloat($(document).find('.wrap_search_map .search_result').attr('data-lat'));
         var lngDefault = parseFloat($(document).find('.wrap_search_map .search_result').attr('data-lng'));
         var marker_option = $(document).find('.wrap_search_map .search_result').attr('data-marker_option');
         var marker_icon = $(document).find('.wrap_search_map .search_result').attr('data-marker_icon');

         /* averageGeolocation */
         function averageGeolocation(data) {

            if (data.length == 1) {
               return data[0];
            }

            let $numCoords = data.length;

            let $X = 0.0;
            let $Y = 0.0;
            let $Z = 0.0;

            for (let i = 0; i < data.length; i++) {

               var lat = data[i]['lat'] * Math.PI / 180;
               var lng = data[i]['lng'] * Math.PI / 180;

               let $a = Math.cos(lat) * Math.cos(lng);
               let $b = Math.cos(lat) * Math.sin(lng);
               let $c = Math.sin(lat);

               $X += $a;
               $Y += $b;
               $Z += $c;
            }

            $X = $X / $numCoords;
            $Y = $Y / $numCoords;
            $Z = $Z / $numCoords;

            lng = Math.atan2($Y, $X);
            let $hyp = Math.sqrt($X * $X + $Y * $Y);
            lat = Math.atan2($Z, $hyp);

            return {
               'lat': lat * 180 / Math.PI,
               'lng': lng * 180 / Math.PI
            };
         }

         /* markerClusterer */
         function markerClusterer() {

            var locations = [];
            var locationsAverage = [];
            $(document).find('.data_event').each(function() {
               locations.push(JSON.parse(JSON.stringify({
                  'title': $(this).attr('data-title_event'),
                  'thumbnail': $(this).attr('data-thumbnail_event'),
                  'lat': $(this).attr('data-map_lat_event'),
                  'lng': $(this).attr('data-map_lng_event'),
                  'link': $(this).attr('data-link_event'),
                  'date': $(this).attr('data-date'),
                  'average_rating': $(this).attr('data-average_rating'),
                  'number_comment': $(this).attr('data-number_comment'),
                  'marker_price': $(this).attr('data-marker_price'),
                  'marker_date': $(this).attr('data-marker_date'),
               })));

               locationsAverage.push(JSON.parse(JSON.stringify({
                  'lat': parseFloat($(this).attr('data-map_lat_event')),
                  'lng': parseFloat($(this).attr('data-map_lng_event')),
               })));
            });

            locationsAverage = averageGeolocation(locationsAverage);
            if (isNaN(locationsAverage.lat) || isNaN(locationsAverage.lng)) {
               var map = new google.maps.Map(document.getElementById('show_map'), {
                  center: {
                     lat: parseFloat(latDefault),
                     lng: parseFloat(lngDefault)
                  },
                  zoom: zoomMap,
                  gestureHandling: 'cooperative'
               });
            } else {
               var map = new google.maps.Map(document.getElementById('show_map'), {
                  center: {
                     lat: parseFloat(locationsAverage.lat),
                     lng: parseFloat(locationsAverage.lng)
                  },
                  zoom: zoomMap,
                  gestureHandling: 'cooperative'
               });
            }

            var infowindow = new google.maps.InfoWindow();

            var markers = locations.map(function(location, i) {

               var lat = parseFloat(location.lat);
               var lng = parseFloat(location.lng);

               var average_rating = location.average_rating;
               var floor_num_rating = Math.floor(average_rating);
               var empty_num_rating = 5 - Math.ceil(average_rating);
               var number_comment = location.number_comment;
               var star = '';

               if (floor_num_rating > 0) {
                  for (var $i = 1; $i <= floor_num_rating; $i++) {
                     star += '<i class="fa fa-star"></i>';
                  }
               }

               if (floor_num_rating != Math.ceil(average_rating)) {
                  star += '<i class="fa fa-star-half-o" ></i>';
               }

               if (empty_num_rating > 0) {
                  for (var $j = 1; $j <= empty_num_rating; $j++) {
                     star += '<i class="fa fa-star-o"></i>';
                  }
               }

               if (!average_rating || average_rating == 0) {
                  var star = '';
               } else {}

               var show_comment = '';
               if (number_comment != 0) {
                  show_comment += '<span class="number second_font">(' + location.number_comment + ')</span>';
               }

               var contentString = '<div class="iw_map">' +
                  '<a href="' + location.link + '">' +
                  '<img style="max-width: 100%; width: 280px;" src="' + location.thumbnail + '" >' +
                  '<h2 class="title"><a href="' + location.link + '">' + location.title + '</a></h2>' +
                  '<div class="event-time"><span class="event-icon"><i class="fa fa-calendar"></i></span>' +
                  '<span class="date">' + location.date + '</span></div>' +
                  '<span class="event_ratting"><span class="star">' + star + '</span> ' + show_comment + ' </span>' +
                  '</a>' + 
                  '</div>';

               var infowindow = new google.maps.InfoWindow({
                  content: contentString
               });

               var latlngset = new google.maps.LatLng(lat, lng);

               
               if (marker_option == 'icon') {
                  var marker = new google.maps.Marker({
                     position: latlngset,
                     icon: marker_icon,
                  });
               } else if(marker_option == 'date') {
                  var marker = new RichMarker({
                     position: latlngset,
                     map: map,
                     draggable: false,
                     content: '<div class="my-marker">'+location.marker_date+'</div>',
                     shadow: 'none'
                  });
               } else {
                   var marker = new RichMarker({
                     position: latlngset,
                     map: map,
                     draggable: false,
                     content: '<div class="my-marker">'+location.marker_price+'</div>',
                     shadow: 'none'
                  });
               }
              
              
               google.maps.event.addListener(
                  marker,
                  'click',
                  (function(marker, i) {
                     return function() {
                        infowindow.open(map, marker);
                     }
                  })(marker, i)
               );

               return marker;
            });

            /* Add a marker clusterer to manage the markers. */
            var markerCluster = new MarkerClusterer(map, markers, {
               imagePath: 'https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/m'
            });
         }

         $.fn.event_map = function(paramObject) {

            paramObject = $.extend({
               lat: latDefault,
               lng: lngDefault,
               zoom: zoomMap
            }, paramObject);

            var input = document.getElementById('pac-input');

            var autocomplete = '';
            if( input ){
               var autocomplete = new google.maps.places.Autocomplete(input);
            }

            var locations = [];

            $('.data_event').each(function() {
               locations.push(JSON.parse(JSON.stringify({
                  'title': $(this).attr('data-title_event'),
                  'thumbnail': $(this).attr('data-thumbnail_event'),
                  'lat': $(this).attr('data-map_lat_event'),
                  'lng': $(this).attr('data-map_lng_event'),
                  'link': $(this).attr('data-link_event'),
                  'date': $(this).attr('data-date'),
                  'average_rating': $(this).attr('data-average_rating'),
                  'number_comment': $(this).attr('data-number_comment'),
               })));
            });

            /* Add a marker clusterer to manage the markers. */
            if (typeof google !== 'undefined' && $("#show_map").length > 0) {
               markerClusterer();
            }

            if( autocomplete !== '' ){
               autocomplete.addListener('place_changed', function() {

                  var place = autocomplete.getPlace();
                  if (!place.geometry) {
                     return;
                  }

                  var map = new google.maps.Map(document.getElementById('show_map'), {
                     center: {
                        lat: parseFloat(place.geometry.location.lat()),
                        lng: parseFloat(place.geometry.location.lng())
                     },
                     zoom: zoomMap,
                     gestureHandling: 'cooperative'
                  });

                  $("#map_name").val(place.name);
                  $("#map_address").val(place.formatted_address);

                  $('#map_lat').val(place.geometry.location.lat());
                  $('#map_lng').val(place.geometry.location.lng());

                  var point = {};
                  point.lat = place.geometry.location.lat();
                  point.lng = place.geometry.location.lng();
                  updatePointSearch(point);
               });
            }
         }

         if (typeof google !== 'undefined' && $("#show_map").length > 0) {
            var map_lat = parseFloat($('input#map_lat').val() ? $('input#map_lat').val() : latDefault);
            var map_lng = parseFloat($('input#map_lng').val() ? $('input#map_lng').val() : lngDefault);
            $("#show_map").event_map({
               lat: map_lat,
               lng: map_lng,
               zoom: zoomMap
            });
         }

         /* Autocomplete Address */
         function updatePointSearch(point) {

            var that = $(document).find('.wrap_search_map');

            var keyword = that.find('[name="keywords"]').val();
            var cat = that.find('[name="cat"]').val();
            var sort = that.find('[name="sort"]').val();
            var radius = that.find('[name="radius"]').val();

            var event_state = that.find('[name="event_state"]').val();
            var event_city = that.find('[name="event_city"]').val();
            var name_venue = that.find('[name="name_venue"]').val();

            var start_date = that.find('[name="start_date"]').val();
            var end_date = that.find('[name="end_date"]').val();
            var time = that.find('[name="time"]').val();

            var type = that.find('.search_result').attr('data-type');
            var column = that.find('.search_result').attr('data-column');

            var result = that.find('.search_result');

            $(document).find('.wrap_search_map .wrap_load_more').show();
            $(document).find('.wrap_search_map .event_archive').hide();

            $.post(ajax_object.ajax_url, {
               action: 'el_search_map',
               dataType: "json",
               data: {
                  keyword: keyword,
                  cat: cat,
                  radius: radius,
                  map_lat: point.lat,
                  map_lng: point.lng,
                  event_state: event_state,
                  event_city: event_city,
                  name_venue: name_venue,
                  start_date: start_date,
                  end_date: end_date,
                  time: time,
                  sort: sort,
                  type: type,
                  column: column,
               },
            }, function(response) {
               var json = JSON.parse(response);
               // console.log(json);

               var item = $(json.result).fadeOut(300).fadeIn(500);

               result.html(item);
               $(document).find('.listing_found').html(json.pagination);

               $(document).find('.wrap_search_map .wrap_load_more').hide();

               if (typeof google !== 'undefined' && $("#show_map").length > 0) {
                  markerClusterer();
               }
            });
         }


         var el_list_taxonomy = $('#el_search_map_list_taxonomy').val();

         if(el_list_taxonomy) {
            el_list_taxonomy = JSON.parse(el_list_taxonomy);

            // var data_taxonomy_custom = {};

            for( var key in el_list_taxonomy ) {
               var name_taxonomy = el_list_taxonomy[key];

               //change taxonomy customize
               $(' .wrap_search_map [name="' + name_taxonomy + '"]' ).on('change', function() {

                  var taxo = $(this).attr('name');

                  var el_data_taxonomy_custom = $('#data_taxonomy_custom').val();
                  if(el_data_taxonomy_custom) {
                     el_data_taxonomy_custom = JSON.parse(el_data_taxonomy_custom);


                     el_data_taxonomy_custom[taxo] = $(this).val();

                     el_data_taxonomy_custom = JSON.stringify(el_data_taxonomy_custom);

                     $('#data_taxonomy_custom').val(el_data_taxonomy_custom);
                  }
                  
                  var keyword = $(this).parents('.wrap_search_map').find('[name="keywords"]').val();
                  var cat = $(this).parents('.wrap_search_map').find('[name="cat"]').val();
                  var sort = $(this).parents('.wrap_search_map').find('[name="sort"]').val();
                  var radius = $(this).parents('.wrap_search_map').find('[name="radius"]').val();
                  if ($(this).parents('.wrap_search_map').find('[name="map_address"]').val() == '') {
                     var map_lat = '';
                     var map_lng = '';
                  } else {
                     var map_lat = $(this).parents('.wrap_search_map').find('[name="map_lat"]').val();
                     var map_lng = $(this).parents('.wrap_search_map').find('[name="map_lng"]').val();
                  }
                  var event_state = $(this).parents('.wrap_search_map').find('[name="event_state"]').val();
                  var event_city = $(this).parents('.wrap_search_map').find('[name="event_city"]').val();

                  var name_venue = $(this).parents('.wrap_search_map').find('[name="name_venue"]').val();
                  var start_date = $(this).parents('.wrap_search_map').find('[name="start_date"]').val();
                  var end_date = $(this).parents('.wrap_search_map').find('[name="end_date"]').val();
                  var time = $(this).parents('.wrap_search_map').find('[name="time"]').val();

                  var type = $(this).parents('.wrap_search_map').find('.search_result').attr('data-type');
                  var column = $(this).parents('.wrap_search_map').find('.search_result').attr('data-column');

                  var result = $(this).parents('.wrap_search_map').find('.search_result');

                  $(document).find('.wrap_search_map .wrap_load_more').show();
                  $(document).find('.wrap_search_map .event_archive').hide();



                  $.post(ajax_object.ajax_url, {
                     action: 'el_search_map',
                     dataType: "json",
                     data: {
                        keyword: keyword,
                        cat: cat,
                        radius: radius,
                        map_lat: map_lat,
                        map_lng: map_lng,
                        event_state: event_state,
                        event_city: event_city,
                        name_venue: name_venue,
                        start_date: start_date,
                        end_date: end_date,
                        time: time,
                        sort: sort,
                        type: type,
                        column: column,
                        el_data_taxonomy_custom: el_data_taxonomy_custom,
                     },
                  }, function(response) {
 
                     var json = JSON.parse(response);

                     var item = $(json.result).fadeOut(300).fadeIn(500);

                     result.html(item);
                     $(document).find('.listing_found').html(json.pagination);

                     $(document).find('.wrap_search_map .wrap_load_more').hide();

                     if (typeof google !== 'undefined' && $("#show_map").length > 0) {
                        markerClusterer();
                     }
                  });

               });
            }
         }



         /* change value search */
         $(' .wrap_search_map [name="keywords"], .wrap_search_map [name="cat"], .wrap_search_map [name="map_address"], .wrap_search_map [name="sort"], .wrap_search_map [name="time"], .wrap_search_map [name="event_state"], .wrap_search_map [name="event_city"], .wrap_search_map [name="name_venue"], .wrap_search_map .search_extra_field ').on('change', function(event) {

            var keyword = $(this).parents('.wrap_search_map').find('[name="keywords"]').val();
            var cat = $(this).parents('.wrap_search_map').find('[name="cat"]').val();
            var sort = $(this).parents('.wrap_search_map').find('[name="sort"]').val();
            var radius = $(this).parents('.wrap_search_map').find('[name="radius"]').val();
            if ($(this).parents('.wrap_search_map').find('[name="map_address"]').val() == '') {
               var map_lat = '';
               var map_lng = '';
            } else {
               var map_lat = $(this).parents('.wrap_search_map').find('[name="map_lat"]').val();
               var map_lng = $(this).parents('.wrap_search_map').find('[name="map_lng"]').val();
            }
            var event_state = $(this).parents('.wrap_search_map').find('[name="event_state"]').val();
            var event_city = $(this).parents('.wrap_search_map').find('[name="event_city"]').val();

            var name_venue = $(this).parents('.wrap_search_map').find('[name="name_venue"]').val();
            var start_date = $(this).parents('.wrap_search_map').find('[name="start_date"]').val();
            var end_date = $(this).parents('.wrap_search_map').find('[name="end_date"]').val();
            var time = $(this).parents('.wrap_search_map').find('[name="time"]').val();

            var type = $(this).parents('.wrap_search_map').find('.search_result').attr('data-type');
            var column = $(this).parents('.wrap_search_map').find('.search_result').attr('data-column');

            var result = $(this).parents('.wrap_search_map').find('.search_result');

            $(document).find('.wrap_search_map .wrap_load_more').show();
            $(document).find('.wrap_search_map .event_archive').hide();

            var el_data_taxonomy_custom = $('#data_taxonomy_custom').val();



            $.post(ajax_object.ajax_url, {
               action: 'el_search_map',
               dataType: "json",
               data: {
                  keyword: keyword,
                  cat: cat,
                  radius: radius,
                  map_lat: map_lat,
                  map_lng: map_lng,
                  event_state: event_state,
                  event_city: event_city,
                  name_venue: name_venue,
                  start_date: start_date,
                  end_date: end_date,
                  time: time,
                  sort: sort,
                  type: type,
                  column: column,
                  el_data_taxonomy_custom: el_data_taxonomy_custom
               },
            }, function(response) {

               var json = JSON.parse(response);

               var item = $(json.result).fadeOut(300).fadeIn(500);

               result.html(item);
               $(document).find('.listing_found').html(json.pagination);

               $(document).find('.wrap_search_map .wrap_load_more').hide();

               if (typeof google !== 'undefined' && $("#show_map").length > 0) {
                  markerClusterer();
               }
            });
         });

         /* Load when redirect form searchs */
         function loadFormSearch() {
            var that = $(document).find('.wrap_search_map');

            var keyword = that.find('[name="keywords"]').val();
            var cat = that.find('[name="cat"]').val();
            var sort = that.find('[name="sort"]').val();
            var radius = that.find('[name="radius"]').val();
            if (that.find('[name="map_address"]').val() == '') {
               var map_lat = '';
               var map_lng = '';
            } else {
               var map_lat = that.find('[name="map_lat"]').val();
               var map_lng = that.find('[name="map_lng"]').val();
            }

            var event_state = that.find('[name="event_state"]').val();
            var event_city = that.find('[name="event_city"]').val();
            var name_venue = that.find('[name="name_venue"]').val();

            var start_date = that.find('[name="start_date"]').val();
            var end_date = that.find('[name="end_date"]').val();
            var time = that.find('[name="time"]').val();

            var type = that.find('.search_result').attr('data-type');
            var column = that.find('.search_result').attr('data-column');

            var result = that.find('.search_result');

            $(document).find('.wrap_search_map .wrap_load_more').show();
            $(document).find('.wrap_search_map .event_archive').hide();

            $.post(ajax_object.ajax_url, {
               action: 'el_search_map',
               dataType: "json",
               data: {
                  keyword: keyword,
                  cat: cat,
                  map_lat: map_lat,
                  map_lng: map_lng,
                  event_state: event_state,
                  event_city: event_city,
                  name_venue: name_venue,
                  start_date: start_date,
                  end_date: end_date,
                  time: time,
                  sort: sort,
                  radius: radius,
                  type: type,
                  column: column,
               },
            }, function(response) {
               if (response != '') {
                  var json = JSON.parse(response);

                  var item = $(json.result).fadeOut(300).fadeIn(500);

                  result.html(item);
                  $(document).find('.listing_found').html(json.pagination);

                  $(document).find('.wrap_search_map .wrap_load_more').hide();

                  if (typeof google !== 'undefined' && $("#show_map").length > 0) {
                     markerClusterer();
                  }
               }
            });
         };
         if ($('form.job_filters').length > 0) {
            if (
               ($('.wrap_search_map [name="keywords"]').val() != '' && $('.wrap_search_map [name="keywords"]').length > 0) ||
               ($('.wrap_search_map [name="time"]').val() != '' && $('.wrap_search_map [name="time"]').length > 0) ||
               ($('.wrap_search_map [name="start_date"]').val() != '' && $('.wrap_search_map [name="start_date"]').length > 0) ||
               ($('.wrap_search_map [name="end_date"]').val() != '' && $('.wrap_search_map [name="end_date"]').length > 0) ||
               ($('.wrap_search_map [name="cat"]').val() != '' && $('.wrap_search_map [name="cat"]').length > 0) ||
               ($('.wrap_search_map [name="name_venue"]').val() != '' && $('.wrap_search_map [name="name_venue"]').length > 0) ||
               ($('.wrap_search_map [name="event_state"]').val() != '' && $('.wrap_search_map [name="event_state"]').length > 0) ||
               ($('.wrap_search_map [name="event_city"]').val() != '' && $('.wrap_search_map [name="event_city"]').length > 0)
            ) {
               loadFormSearch();
            }
         }

         var min_radius = 0; var max_radius = 0; var value_radius = 0;
         if( typeof map_range_radius_min !== 'undefined' ){
            min_radius = map_range_radius_min;
         }
         if( typeof map_range_radius_max  !== 'undefined' ){
            max_radius = map_range_radius_max;
         }
         if( typeof map_range_radius  !== 'undefined' ){
            value_radius = map_range_radius;
         }

         /* Slider Radius */
         $('#wrap_pointer').slider({
            min: min_radius,
            max: max_radius,
            step: 1,
            value: value_radius,
            change: function(event, ui) {
               $(this).parents('.wrap_search_map').find('[name="radius"]').val(ui.value);
               $(this).parents('.wrap_search_map').find('.result_radius').html(ui.value + 'km');

               var keyword = $(this).parents('.wrap_search_map').find('[name="keywords"]').val();
               var cat = $(this).parents('.wrap_search_map').find('[name="cat"]').val();
               var sort = $(this).parents('.wrap_search_map').find('[name="sort"]').val();
               var radius = ui.value;
               if ($(this).parents('.wrap_search_map').find('[name="map_address"]').val() == '') {
                  var map_lat = '';
                  var map_lng = '';
               } else {
                  var map_lat = $(this).parents('.wrap_search_map').find('[name="map_lat"]').val();
                  var map_lng = $(this).parents('.wrap_search_map').find('[name="map_lng"]').val();
               }

               var event_state = $(this).parents('.wrap_search_map').find('[name="event_state"]').val();
               var event_city = $(this).parents('.wrap_search_map').find('[name="event_city"]').val();
               var name_venue = $(this).parents('.wrap_search_map').find('[name="name_venue"]').val();

               var start_date = $(this).parents('.wrap_search_map').find('[name="start_date"]').val();
               var end_date = $(this).parents('.wrap_search_map').find('[name="end_date"]').val();
               var time = $(this).parents('.wrap_search_map').find('[name="time"]').val();

               var type = $(this).parents('.wrap_search_map').find('.search_result').attr('data-type');
               var column = $(this).parents('.wrap_search_map').find('.search_result').attr('data-column');

               var result = $(this).parents('.wrap_search_map').find('.search_result');

               $(document).find('.wrap_search_map .wrap_load_more').show();
               $(document).find('.wrap_search_map .event_archive').hide();

               $.post(ajax_object.ajax_url, {
                  action: 'el_search_map',
                  dataType: "json",
                  data: {
                     keyword: keyword,
                     cat: cat,
                     radius: radius,
                     map_lat: map_lat,
                     map_lng: map_lng,
                     event_state: event_state,
                     event_city: event_city,
                     name_venue: name_venue,
                     start_date: start_date,
                     end_date: end_date,
                     time: time,
                     sort: sort,
                     type: type,
                     column: column,
                  },
               }, function(response) {
                  var json = JSON.parse(response);

                  var item = $(json.result).fadeOut(300).fadeIn(500);

                  result.html(item);
                  $(document).find('.listing_found').html(json.pagination);

                  $(document).find('.wrap_search_map .wrap_load_more').hide();

                  if (typeof google !== 'undefined' && $("#show_map").length > 0) {
                     markerClusterer();
                  }
               });
            }
         });

         /* Ajax pagination search map */
         $(document).on('click', '.wrap_search_map .el-pagination span', function(e) {
            e.preventDefault();
            $(window).scrollTop(0);

            var that = $(this);
            var keyword = $(this).parents('.wrap_search_map').find('[name="keywords"]').val();
            var cat = $(this).parents('.wrap_search_map').find('[name="cat"]').val();
            var sort = $(this).parents('.wrap_search_map').find('[name="sort"]').val();
            var radius = $(this).parents('.wrap_search_map').find('[name="radius"]').val();
            if ($(this).parents('.wrap_search_map').find('[name="map_address"]').val() == '') {
               var map_lat = '';
               var map_lng = '';
            } else {
               var map_lat = $(this).parents('.wrap_search_map').find('[name="map_lat"]').val();
               var map_lng = $(this).parents('.wrap_search_map').find('[name="map_lng"]').val();
            }

            var event_state = $(this).parents('.wrap_search_map').find('[name="event_state"]').val();
            var event_city = $(this).parents('.wrap_search_map').find('[name="event_city"]').val();
            var name_venue = $(this).parents('.wrap_search_map').find('[name="name_venue"]').val();

            var start_date = $(this).parents('.wrap_search_map').find('[name="start_date"]').val();
            var end_date = $(this).parents('.wrap_search_map').find('[name="end_date"]').val();
            var time = $(this).parents('.wrap_search_map').find('[name="time"]').val();

            var type = $(this).parents('.wrap_search_map').find('.search_result').attr('data-type');
            var column = $(this).parents('.wrap_search_map').find('.search_result').attr('data-column');

            var paged = $(this).attr('data-paged');
            var result = $(this).parents('.wrap_search_map').find('.search_result');

            $(document).find('.wrap_search_map .wrap_load_more').show();
            $(document).find('.wrap_search_map .event_archive').hide();

            $.post(ajax_object.ajax_url, {
               action: 'el_search_map',
               dataType: "json",
               data: {
                  keyword: keyword,
                  cat: cat,
                  radius: radius,
                  map_lat: map_lat,
                  map_lng: map_lng,
                  event_state: event_state,
                  event_city: event_city,
                  name_venue: name_venue,
                  start_date: start_date,
                  end_date: end_date,
                  time: time,
                  sort: sort,
                  type: type,
                  column: column,
                  paged: paged,
               },
            }, function(response) {
               var json = JSON.parse(response);

               var item = $(json.result).fadeOut(300).fadeIn(500);

               result.html(item);
               $(document).find('.listing_found').html(json.pagination);

               $(document).find('.wrap_search_map .wrap_load_more').hide();

               if (typeof google !== 'undefined' && $("#show_map").length > 0) {
                  markerClusterer();
               }

            });
         });

         /* Click locate me */
         $('.locate-me').on('click', function() {
            if (navigator.geolocation) {
               navigator.geolocation.getCurrentPosition(showPosition);
            } else {
               x.innerHTML = "Geolocation is not supported by this browser.";
            }
         });

         /* Position locate me */
         function showPosition(position) {
            var map_lat = position.coords.latitude;
            var map_lng = position.coords.longitude;

            $('[name="map_lat"]').attr('value', map_lat);
            $('[name="map_lng"]').attr('value', map_lng);

            var latlng = {
               lat: parseFloat(map_lat),
               lng: parseFloat(map_lng)
            };
            var geocoder = new google.maps.Geocoder;
            geocoder.geocode({
               'location': latlng
            }, function(results, status) {
               if (status === 'OK') {
                  if (results[0]) {
                     $('.wrap_search_map [name="map_address"]').val(results[0].formatted_address);
                  } else {
                     window.alert('No results found');
                  }
               } else {
                  window.alert('Geocoder failed due to: ' + status);
               }
            });

            // Ajax load event
            var that = $(document).find('.wrap_search_map');
            var keyword = that.find('[name="keywords"]').val();
            var cat = that.find('[name="cat"]').val();
            var sort = that.find('[name="sort"]').val();
            var radius = that.find('[name="radius"]').val();

            var event_state = that.find('[name="event_state"]').val();
            var event_city = that.find('[name="event_city"]').val();
            var name_venue = that.find('[name="name_venue"]').val();

            var start_date = that.find('[name="start_date"]').val();
            var end_date = that.find('[name="end_date"]').val();
            var time = that.find('[name="time"]').val();

            var type = that.find('.search_result').attr('data-type');
            var column = that.find('.search_result').attr('data-column');

            var result = that.find('.search_result');

            $(document).find('.wrap_search_map .wrap_load_more').show();
            $(document).find('.wrap_search_map .event_archive').hide();

            $.post(ajax_object.ajax_url, {
               action: 'el_search_map',
               dataType: "json",
               data: {
                  keyword: keyword,
                  cat: cat,
                  radius: radius,
                  map_lat: map_lat,
                  map_lng: map_lng,
                  event_state: event_state,
                  event_city: event_city,
                  name_venue: name_venue,
                  start_date: start_date,
                  end_date: end_date,
                  time: time,
                  sort: sort,
                  type: type,
                  column: column,
               },
            }, function(response) {
               var json = JSON.parse(response);

               var item = $(json.result).fadeOut(300).fadeIn(500);

               result.html(item);
               $(document).find('.listing_found').html(json.pagination);

               $(document).find('.wrap_search_map .wrap_load_more').hide();

               if (typeof google !== 'undefined' && $("#show_map").length > 0) {
                  markerClusterer();
               }
            });
         }

         /* Change Date */
         $('.wrap_search_map .el_select_date').each(function() {
            var format = $(this).attr('data-format');

            $(this).datepicker({
               dateFormat: format,
               changeMonth: true,
               changeYear: true,
               onSelect: function() {
                  $('.wrap_search_map .wrap_search_time').val(" ");
                  var $option_default = $('.wrap_search_time option').first().html();
                  $('.wrap_search_map .wrap_search_time option').first().attr('selected', 'selected');
                  $('.wrap_search_map .wrap_search_time span.select2-selection__rendered').html($option_default);
                  $('.wrap_search_map .wrap_search_time span.select2-selection__rendered').attr('title', $option_default);

                  var keyword = $(this).parents('.wrap_search_map').find('[name="keywords"]').val();
                  var cat = $(this).parents('.wrap_search_map').find('[name="cat"]').val();
                  var sort = $(this).parents('.wrap_search_map').find('[name="sort"]').val();
                  var radius = $(this).parents('.wrap_search_map').find('[name="radius"]').val();
                  if ($(this).parents('.wrap_search_map').find('[name="map_address"]').val() == '') {
                     var map_lat = '';
                     var map_lng = '';
                  } else {
                     var map_lat = $(this).parents('.wrap_search_map').find('[name="map_lat"]').val();
                     var map_lng = $(this).parents('.wrap_search_map').find('[name="map_lng"]').val();
                  }

                  var event_state = $(this).parents('.wrap_search_map').find('[name="event_state"]').val();
                  var event_city = $(this).parents('.wrap_search_map').find('[name="event_city"]').val();
                  var name_venue = $(this).parents('.wrap_search_map').find('[name="name_venue"]').val();

                  var start_date = $(this).parents('.wrap_search_map').find('[name="start_date"]').val();
                  var end_date = $(this).parents('.wrap_search_map').find('[name="end_date"]').val();
                  var time = $(this).parents('.wrap_search_map').find('[name="time"]').val();

                  var type = $(this).parents('.wrap_search_map').find('.search_result').attr('data-type');
                  var column = $(this).parents('.wrap_search_map').find('.search_result').attr('data-column');

                  var result = $(this).parents('.wrap_search_map').find('.search_result');

                  $(document).find('.wrap_search_map .wrap_load_more').show();
                  $(document).find('.wrap_search_map .event_archive').hide();

                  $.post(ajax_object.ajax_url, {
                     action: 'el_search_map',
                     dataType: "json",
                     data: {
                        keyword: keyword,
                        cat: cat,
                        radius: radius,
                        map_lat: map_lat,
                        map_lng: map_lng,
                        event_state: event_state,
                        event_city: event_city,
                        name_venue: name_venue,
                        start_date: start_date,
                        end_date: end_date,
                        time: time,
                        sort: sort,
                        type: type,
                        column: column,
                     },
                  }, function(response) {
                     var json = JSON.parse(response);

                     var item = $(json.result).fadeOut(300).fadeIn(500);

                     result.html(item);
                     $(document).find('.listing_found').html(json.pagination);

                     $(document).find('.wrap_search_map .wrap_load_more').hide();

                     if (typeof google !== 'undefined' && $("#show_map").length > 0) {
                        markerClusterer();
                     }
                  });
               }
            });
         });

         /* Change Time */
         $('.wrap_search_map .wrap_search_time select').on('change', function() {
            $('.wrap_search_start_date input').val("");
            $('.wrap_search_end_date input').val("");
         });

         /* Toggle filters mobile */
         $('.wrap_search_map .toggle_filters').click(function() {
            $(this).parents('.wrap_search_map').find('.job_filters').slideToggle(300);
            $(this).find('.icon_down').toggle(300);
            $(this).find('.icon_up').toggle(300);
            $(this).toggleClass('active');
         });

         /* Change tabs mobile */
         $('.wrap_search_map .toggle_wrap span').on('click', function() {
            let id = $(this).attr('data-value');

            $('.wrap_search_map #show_map, .wrap_search_map #result_search').hide();
            $('#' + id).show();

            $('.wrap_search_map .toggle_wrap span').removeClass('active');
            $(this).addClass('active');
         });

         /* Autocomplete Venue */
         $('.wrap_search_map .venue input').autocomplete({
            source: function(request, response) {
               $.ajax({
                  url: ajax_object.ajax_url,
                  type: 'POST',
                  dataType: "json",
                  data: {
                     action: 'el_load_venue',
                     keyword: request.term,
                  },
                  success: function(data) {
                     response(data);
                  },

               })
            },
            select: function(e, i) {

               var keyword = $(this).parents('.wrap_search_map').find('[name="keywords"]').val();
               var cat = $(this).parents('.wrap_search_map').find('[name="cat"]').val();
               var sort = $(this).parents('.wrap_search_map').find('[name="sort"]').val();
               var radius = $(this).parents('.wrap_search_map').find('[name="radius"]').val();
               if ($(this).parents('.wrap_search_map').find('[name="map_address"]').val() == '') {
                  var map_lat = '';
                  var map_lng = '';
               } else {
                  var map_lat = $(this).parents('.wrap_search_map').find('[name="map_lat"]').val();
                  var map_lng = $(this).parents('.wrap_search_map').find('[name="map_lng"]').val();
               }

               var event_state = $(this).parents('.wrap_search_map').find('[name="event_state"]').val();
               var event_city = $(this).parents('.wrap_search_map').find('[name="event_city"]').val();
               // var name_venue = $(this).parents('.wrap_search_map').find('[name="name_venue"]').val();

               var start_date = $(this).parents('.wrap_search_map').find('[name="start_date"]').val();
               var end_date = $(this).parents('.wrap_search_map').find('[name="end_date"]').val();
               var time = $(this).parents('.wrap_search_map').find('[name="time"]').val();

               var type = $(this).parents('.wrap_search_map').find('.search_result').attr('data-type');
               var column = $(this).parents('.wrap_search_map').find('.search_result').attr('data-column');

               var result = $(this).parents('.wrap_search_map').find('.search_result');

               $(document).find('.wrap_search_map .wrap_load_more').show();
               $(document).find('.wrap_search_map .event_archive').hide();

               $.post(ajax_object.ajax_url, {
                  action: 'el_search_map',
                  dataType: "json",
                  data: {
                     keyword: keyword,
                     cat: cat,
                     radius: radius,
                     map_lat: map_lat,
                     map_lng: map_lng,
                     event_state: event_state,
                     event_city: event_city,
                     name_venue: i.item.value,
                     start_date: start_date,
                     end_date: end_date,
                     time: time,
                     sort: sort,
                     type: type,
                     column: column,
                  },
               }, function(response) {
                  var json = JSON.parse(response);

                  var item = $(json.result).fadeOut(300).fadeIn(500);

                  result.html(item);
                  $(document).find('.listing_found').html(json.pagination);

                  $(document).find('.wrap_search_map .wrap_load_more').hide();

                  if (typeof google !== 'undefined' && $("#show_map").length > 0) {
                     markerClusterer();
                  }
               });
            },
            delay: 0,
         });

         /* Calculator height google map */
         function heightGoogleMap() {
            let h_Header = $(document).find('.ovaheader').outerHeight();
            let h_Footer = $(document).find('.ovafooter').outerHeight();
            let h_Wpadminbar = $(document).find('#wpadminbar').outerHeight();
            // console.log(document.body.clientHeight);
            // console.log($(window).height());
            $(document).find('.wrap_search_map #show_map').css({
               'height': $(window).height() - h_Wpadminbar - h_Header,
               'top': h_Header + h_Wpadminbar,
               'bottom': h_Footer,
            });
         }
         heightGoogleMap();
         $(window).resize(function() {
            heightGoogleMap();
         });
      },

      event_map: function() {
         if ($('#event_map').length && (typeof google !== 'undefined')) {

            function initialize() {
               var lat = parseFloat($("#event_map").data('lat'));
               var lng = parseFloat($("#event_map").data('lng'));
               var address = $("#event_map").data('address');
               var zoom = parseInt($("#event_map").data('zoom'));

               var infoWindow = new google.maps.InfoWindow();

               var loc = {
                  lat: lat,
                  lng: lng
               };

               var map = new google.maps.Map(document.getElementById('event_map'), {
                  zoom: zoom,
                  center: loc,
                  scrollwheel: false
               });

               var marker = new google.maps.Marker({
                  position: loc,
                  map: map,
               });

               google.maps.event.addListener(marker, 'click', (function(marker) {
                  return function() {
                     infoWindow.setContent(address);
                     infoWindow.open(map, marker);
                  }
               })(marker));

            }
            if (typeof google !== 'undefined') {
               google.maps.event.addDomListener(window, "load", initialize);
            }

         }
      },

      el_single_send_mail_report: function(){

         $('.single-event').on('click', '.icon_close', function(){

            $(this).closest('.el_form_report').css({'display':'none'});
            $('.single-event .act_share .el_wrap_form_report').css({'z-index':'-1'});
         });



         $('.el_report_link').on('click', function(){
            var myaccount_page = $(this).data('myaccount_page');
            var id_event = $(this).data('id_event');
            
            $('.single-event .act_share .el_wrap_form_report').empty();
            $('.single-event .act_share .el_wrap_form_report').css({'z-index':'-1'});
            $.post(ajax_object.ajax_url, {

                  action: 'el_check_login_report',
                  id_event: id_event,

               }, function(response) {

               if( response !== 'false' ) {
                  $('.single-event .act_share .el_wrap_form_report').append(response);
                  $('.single-event .act_share .el_wrap_form_report').css({'z-index':'14'});

               } else {



                  var current_url = window.location.origin + window.location.pathname + window.location.search;
                  window.location.href = myaccount_page + '?redirect_to=' + current_url;

               }
            });
         })


         $(".single-event").on('click','.submit-sendmail-report', function(e) {
            e.preventDefault(e);
            var id_event = $(this).data('id_event');

            var message = $("textarea[name=el_message]").val();
            
            var flag = "";
            if (message == '') {
               $('.el_report .el-notify p.error-require').css('display', 'block');
               return false;
            }

            $('.el_report .el-notify p').css('display', 'none');
            $('.el_report  .submit-load-more').css('z-index', '9');
            $('.el_report .submit-load-more').css('display', 'block');
            $.post(ajax_object.ajax_url, {
               action: 'el_single_send_mail_report',
               data: {
                  id_event: id_event,
                  message: message,
               },
            }, function(response) {

               var data = response;
               if (data == 'true') {
                  $('.el_report .el-notify p.success').css('display', 'block');
                  $('.el_report .submit-load-more').css('z-index', '-1');
                  $('.el_report .submit-load-more').css('display', 'none');
               } else {
                  $('.el_report .el-notify p.error').css('display', 'block');
                  $('.el_report .submit-load-more').css('z-index', '-1');
                  $('.el_report .submit-load-more').css('display', 'none');
               }
            });
         });
      },

      el_single_send_mail_vendor: function() {
         $('.send_mess').on('click', function() {
            $(this).css('display', 'none');
            $(this).siblings('.el-sendmail-author').css('height', '100%');
         });

         $(".submit-sendmail").on('click', function(e) {
            e.preventDefault(e);
            var id_event = $(this).data('id');
            var name = $("input[name=name_customer]").val();
            var email = $("input[name=email_customer]").val();
            var phone = $("input[name=phone_customer]").val();
            var subject = $("input[name=subject_customer]").val();
            var content = $("textarea[name=content]").val();

            var flag = "";
            if (name == '' || email == '' || phone == '' || subject == '' || content == '') {
               $('.info_user .el-notify p.error-require').css('display', 'block');
               return false;
            }

            $('.info_user .el-notify p').css('display', 'none');
            $('.info_user .el-sendmail-author .submit-load-more').css('z-index', '9');
            $.post(ajax_object.ajax_url, {
               action: 'el_single_send_mail_vendor',
               data: {
                  id_event: id_event,
                  name: name,
                  email: email,
                  phone: phone,
                  subject: subject,
                  content: content,
               },
            }, function(response) {
               var data = response;

               if (data == 'true') {
                  $('.info_user .el-notify p.success').css('display', 'block');
                  $('.info_user .el-sendmail-author .submit-load-more').css('z-index', '-1');
               } else {
                  $('.info_user .el-notify p.error').css('display', 'block');
                  $('.info_user .el-sendmail-author .submit-load-more').css('z-index', '-1');
               }
            });
         });
      },

      el_single_click_book: function() {
         var h_wpadmin = $('#wpadminbar').outerHeight();
         var h_ovamenu = $(document).find('.ovamenu_shrink .elementor-container').height();

         if ($(".title-event-single").hasClass("no-empty-ticket")) {
            $(".booking_event_button").on('click', function(e) {
               e.preventDefault();
               if ($(".ticket-calendar").length) {
                  if ($(window).width() > 767) {
                     $('html, body').animate({
                        scrollTop: ($(".ticket-calendar").offset().top - h_wpadmin - h_ovamenu)
                     }, 2000);
                  } else {
                     $('html, body').animate({
                        scrollTop: ($(".ticket-calendar").offset().top)
                     }, 2000);
                  }

               }
            });
         } else {
            $(".booking_event_button").css('display', 'none');
         }

         $("#event_booking_single_button").on('click', function(e) {
            e.preventDefault();
            if ($(".ticket-calendar").length) {
               if ($(window).width() > 767) {
                  $('html, body').animate({
                     scrollTop: ($(".ticket-calendar").offset().top - h_wpadmin - h_ovamenu)
                  }, 2000);
               } else {
                  $('html, body').animate({
                     scrollTop: ($(".ticket-calendar").offset().top)
                  }, 2000);
               }
            }
         });
      },

      /*** Update Role at My account >> Profile >> Role tab ***/
      update_role: function() {
         $('#author_role input[name="el_update_role"]').on('click', function(e) {
            e.preventDefault();
            
            var that = $(this);

            var el_update_role_nonce = that.closest('#author_role').find('#el_update_role_nonce').val();
            var role = that.data( 'role' );

            
            $.post(ajax_object.ajax_url, {
               action: 'el_update_role',
               data: {
                  el_update_role_nonce: el_update_role_nonce,
                  role: role,
               },
            }, function(response) {
               console.log(response);
               if (response && response != 'true' ) {
                  window.location.replace( response );
               }else if( response == 'true' ){
                  location.reload();
               }
            });
            
         });
      },

      el_cancel_booking: function() {
         $('button.cancel-booking').off().on('click', function(e) {
            e.preventDefault();
            var id_booking = $(this).attr("data-id-booking");
            var el_cancel_booking_nonce = $(this).attr('data-nonce');

            $(this).siblings(".submit-load-more.cancel-booking").css({"z-index":"1"});
            $.ajax({
               url: ajax_object.ajax_url,
               type: 'POST',
               data: {
                  action: 'el_cancel_booking',
                  el_cancel_booking_nonce: el_cancel_booking_nonce,
                  id_booking: id_booking,
               },
               success:function(response) {

                  var data = JSON.parse(response);

                  if (data.status == "error") {
                     alert( data.msg );
                    $('.cancel-booking').siblings(".submit-load-more.cancel-booking").css({"z-index":"-1"});
                    
                  }else{
                     
                    alert( data.msg );
                    $('.cancel-booking').siblings(".submit-load-more.cancel-booking").css({"z-index":"-1"});
                    $('.booking_'+id_booking + ' .wp-button-my-booking').remove();

                  }
                  

               },
            })

         });
      },

     


   };

   /* ready */
   $(document).ready(function() {
      EL_Frontend.init();
   });

})(jQuery);