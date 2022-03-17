(function($) {
   "use strict";

   /* ready */
   $(document).ready(function() {

      $( '#signupform' ).submit( function(e) {

      	
        
         var submit = true;

      	$('.required').each( function(event){

      		if( $(this).val() == '' ){
      			var msg = $(this).data('msg');
               alert(msg);
               submit = false;
	      		return false;
	      	}
            
      	});

         if( $('input[name="password"]').length ){
            var password_val = $('input[name="password"]').val();
            if( password_val.length < 9 ){
               var pass_error = $('input[name="password"]').data('error');
               alert( pass_error );
               return false;
            }
         }
         
         if( $( '.register_term:checkbox' ).hasClass( 'required' ) ){
            if( $( '.register_term:checkbox:checked' ).length <= 0 && submit == true){
                  var msg_checkbox = $( '.register_term:checkbox' ).data('msg');
                  alert(msg_checkbox);
                  submit = false;
                  return false;
            }
         }

         

         if( submit == true ){
            return true;
         }

         e.preventDefault();
          

      } );


      

   });

} )(jQuery);