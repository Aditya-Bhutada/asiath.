( function($) {
	"use strict";
	

	$(window).on('elementor/frontend/init', function () {

		// Add js for each element

		//event slider
		elementorFrontend.hooks.addAction('frontend/element_ready/ova_event_slider.default', function(){
			var responsive_value = {
				0: {
					items: 1,
				},
				768:  {
					items: 2,
				},
				991:  {
					items: 3,
				},

			};
			var navText = [
			'<i class="arrow_left"></i>',
			'<i class="arrow_right"></i>'
			];

			$(".event-slider").each(function(){
				var owlsl = $(this) ;
				var owlsl_df = {
					margin: 0, 
					responsive: false, 
					smartSpeed:500,
					autoplay:false,
					autoplayTimeout: 6000,
					items:3,
					loop:true, 
					nav: true, 
					dots: true,
					center:false,
					autoWidth:false,
					thumbs:false, 
					autoplayHoverPause: true,
					slideBy: 1,
				};
				var owlsl_ops = owlsl.data('options') ? owlsl.data('options') : {};
				owlsl_ops = $.extend({}, owlsl_df, owlsl_ops);
				owlsl.owlCarousel({
					autoWidth: owlsl_ops.autoWidth,
					margin: owlsl_ops.margin,
					items: owlsl_ops.items,
					loop: owlsl_ops.loop,
					autoplay: owlsl_ops.autoplay,
					autoplayTimeout: owlsl_ops.autoplayTimeout,
					center: owlsl_ops.center,
					nav: owlsl_ops.nav,
					dots: owlsl_ops.dots,
					thumbs: owlsl_ops.thumbs,
					autoplayHoverPause: owlsl_ops.autoplayHoverPause,
					slideBy: owlsl_ops.slideBy,
					smartSpeed: owlsl_ops.smartSpeed,
					navText: navText,
					responsive: responsive_value,
				});

			});

		});
		// end event slider

		//event grid
		elementorFrontend.hooks.addAction('frontend/element_ready/ova_event_grid.default', function(){
			$('.ova-event-grid .el-button-filter button:first-child').addClass('active');
			var button = $('.ova-event-grid .el-button-filter');
			button.each(function() {
				button.on('click', 'button', function() {
					button.find('.active').removeClass('active');
					$(this).addClass('active');
				});
			});


			button.on('click', 'button', function(e) {
				e.preventDefault();

				var filter = $(this).data('filter');
				var status = $(this).data('status');
				var type_event = $(this).data('type');
				var order = $(this).data('order');
				var orderby = $(this).data('orderby');
				var number_post = $(this).data('number_post');
				var column = $(this).data('column');
				var term_id_filter_string = $(this).data('term_id_filter_string');

				$(this).parents('.ova-event-grid').find('.wrap_loader').fadeIn(500);

				$.ajax({
					url: ajax_object.ajax_url,
					type: 'POST',
					data: ({
						action: 'el_filter_elementor_grid',
						filter: filter,
						status: status,
						order: order,
						orderby: orderby,
						number_post: number_post,
						column: column,
						term_id_filter_string: term_id_filter_string,
						type_event: type_event,
					}),
					success: function(response){
						
						$('.ova-event-grid .wrap_loader').fadeOut(500);
						var items = $('.ova-event-grid .event_archive');
						items.html( response ).fadeOut(0).fadeIn(500);

					},
				})
			});
		});
		//end event grid


		//event venue slider
		elementorFrontend.hooks.addAction('frontend/element_ready/el_location_event.default', function(){
			var responsive_value = {
				0: {
					items: 1,
				},
				768:  {
					items: 3,
				},
				991:  {
					items: 5,
				},

			};
			var navText = [
			'<i class="arrow_left"></i>',
			'<i class="arrow_right"></i>'
			];

			$(".event-venue-slide").each(function(){
				var owlsl = $(this) ;
				var owlsl_df = {
					margin: 0, 
					responsive: false, 
					smartSpeed:500,
					autoplay:false,
					autoplayTimeout: 6000,
					items:3,
					loop:true, 
					nav: true, 
					dots: true,
					center:false,
					autoWidth:false,
					thumbs:false, 
					autoplayHoverPause: true,
					slideBy: 1,
				};
				var owlsl_ops = owlsl.data('options') ? owlsl.data('options') : {};
				owlsl_ops = $.extend({}, owlsl_df, owlsl_ops);
				owlsl.owlCarousel({
					autoWidth: owlsl_ops.autoWidth,
					margin: owlsl_ops.margin,
					items: owlsl_ops.items,
					loop: owlsl_ops.loop,
					autoplay: owlsl_ops.autoplay,
					autoplayTimeout: owlsl_ops.autoplayTimeout,
					center: owlsl_ops.center,
					nav: owlsl_ops.nav,
					dots: owlsl_ops.dots,
					thumbs: owlsl_ops.thumbs,
					autoplayHoverPause: owlsl_ops.autoplayHoverPause,
					slideBy: owlsl_ops.slideBy,
					smartSpeed: owlsl_ops.smartSpeed,
					navText: navText,
					responsive: responsive_value,
				});

			});

		});
		// end event venue slider


      /* Slide Show */
      elementorFrontend.hooks.addAction('frontend/element_ready/el_event_slideshow.default', function(){

         function fadeInReset(element) {
            $(element).find('*[data-animation]').each(function(){
               var animation = $(this).data( 'animation' );
               $(this).removeClass( 'animated' );
               $(this).removeClass( animation );
               $(this).css({ opacity: 0 });
            });
         }

         function fadeIn(element) {

            /* Title */
            var title = $(element).find( '.active .elementor-slide-title' );
            var animation_title = title.data( 'animation' );
            var duration_title  = parseInt( title.data( 'animation_dur' ) );

            setTimeout(function(){
               title.addClass(animation_title).addClass('animated').css({ opacity: 1 });
            }, duration_title);


            /* Tag */
            var tag = $(element).find( '.active .elementor-slide-tag' )
            var animation_tag = tag.data( 'animation' );
            var duration_tag  = parseInt( tag.data( 'animation_dur' ) );

            setTimeout(function(){
               tag.addClass(animation_tag).addClass('animated').css({ opacity: 1 });
            }, duration_tag);



            /* Description */
            var venue = $(element).find( '.active .elementor-slide-venue' );
            var animation_venue = venue.data( 'animation' );
            var duration_venue  = parseInt( venue.data( 'animation_dur' ) );

            setTimeout(function(){
               venue.addClass(animation_venue).addClass('animated').css({ opacity: 1 });
            }, duration_venue);


            /* Date */
            var date = $(element).find( '.active .elementor-slide-date' );
            var animation_date = date.data( 'animation' );
            var duration_date  = parseInt( date.data( 'animation_dur' ) );

            setTimeout(function(){
               date.addClass(animation_date).addClass('animated').css({ opacity: 1 });
            }, duration_date);

            
         }

         $(document).ready(function(){
            $('.elementor-slides').each(function(){

               var owl = $(this);
               var data = owl.data("owl_carousel");

               owl.on('initialized.owl.carousel', function(event) {
                  fadeIn(event.target);

                  let count_element = $(this).find('.owl-item.active .elementor-slide-bottom > div').length;
                  if ( count_element <= 1 ) {
                     $(this).find('.owl-item.active .elementor-slide-bottom > div').css({
                        'padding': '0',
                        'text-align': 'center'
                     });
                  }
               });

               owl.owlCarousel(
                  data
                  );
               
               owl.on('translate.owl.carousel', function(event){
                  fadeInReset(event.target);
                  owl.trigger('stop.owl.autoplay');
                  owl.trigger('play.owl.autoplay');
               });

               owl.on('translated.owl.carousel', function(event) {
                  fadeIn(event.target);
                  owl.trigger('stop.owl.autoplay');
                  owl.trigger('play.owl.autoplay');

                  let count_element = $(this).find('.owl-item.active .elementor-slide-bottom > div').length;
                  if ( count_element <= 1 ) {
                     $(this).find('.owl-item.active .elementor-slide-bottom > div').css({
                        'padding': '0',
                        'text-align': 'center'
                     });
                  }
               });
            });
         });

      });
      /* End Slide Show */

      /* Name Event Slider */
      elementorFrontend.hooks.addAction('frontend/element_ready/el_name_event_slider.default', function(){
         $(document).ready(function(){
            $('.el_name_event_slider .wrap_item').each(function(){
               var owl = $(this);
               var data = owl.data("owl");

               owl.owlCarousel(
                  data
                  );
            });
         });

      });
      /* End Name Event Slider */

      /* Search */
      elementorFrontend.hooks.addAction('frontend/element_ready/el_search_form.default', function(){

         $(document).ready(function(){
         	
	         $('.selectpicker').select2({
	            width: '100%',
	            dropdownParent: $( '.el_search_filters' )
	         });

           
         });

      });


   });

} ) (jQuery);