(function($) {
	Modernizr.load({
		    test: Modernizr.input.placeholder,
		    nope: [
		            '/wp-content/themes/vmall/js/placeholder/placeholder_polyfill.min.css',
		            '/wp-content/themes/vmall/js/placeholder/placeholder_polyfill.jquery.min.combo.js'
		          ]
		});

		jQuery( function($) {

			//Moves comments to the tabs
			jQuery('#tabs-4').append(jQuery('#comments')) ;
			jQuery('#tabs-4').append(jQuery('#respond')) ;
			jQuery('#tabs-4').append(jQuery('.nocomments')) ;


			//Top slider
			jQuery('#slider').nivoSlider({
		        effect: 'fade', // Specify sets like: 'fold,fade,sliceDown'
		        slices: 5, // For slice animations
		        animSpeed: 500, // Slide transition speed
		        pauseTime: 10000, // How long each slide will show
		        directionNav: false, // Next & Prev navigation
		        directionNavHide: true, // Only show on hover
		        controlNav: true, // 1,2,3... navigation
		        pauseOnHover: true, // Stop animation while hovering
		        manualAdvance: false, // Force manual transitions
		        prevText: 'Prev', // Prev directionNav text
		        nextText: 'Next', // Next directionNav text
		    });

		    jQuery('label.seller').click(function(e){

		    	jQuery('.user_seller').show("slow") ;
		    	jQuery('.user_buyer, #reg_passmail1, #registerform1 .submit').animate({
		    		marginLeft: 0

		    	}, "slow") ;

		    }) ;

		    jQuery('label.buyer').click(function(e){

		    	jQuery('.user_seller').hide("slow") ;

		    	jQuery('.user_buyer, #reg_passmail1, #registerform1 .submit').animate({
		    		marginLeft: "125px"

		    	}, "slow") ;


		    }) ;
		
			jQuery( ".user_type" ).buttonset();
			jQuery('.mp_cart_payment_methods td').buttonset() ;

			jQuery('#tabs').tabs() ;

			jQuery('li.cat-item > a').click(function(e){

				//if the category has children
				if(jQuery(this).parent().children('.children').length > 0){

					var childUL = $(this).parent().children('ul.children') ;

					if(jQuery(this).hasClass('expanded') != true){
						e.preventDefault() ;
						childUL.show() ;
						jQuery(this).addClass('expanded') ;
					}
					else{
						e.preventDefault() ;
						childUL.hide() ;
						jQuery(this).removeClass('expanded') ;
					
					}
				}
			}) ;

			//Removes Chrome's yellow background because of auto-complete
			if (navigator.userAgent.toLowerCase().indexOf("chrome") >= 0) {
				$(window).load(function(){
				    $('input:-webkit-autofill').each(function(){
				        var text = $(this).val();
				        var name = $(this).attr('name');
				        $(this).after(this.outerHTML).remove();
				        $('input[name=' + name + ']').val(text);
				    });
				});
			}
			// Check if browser supports HTML5 input placeholder
			function supports_input_placeholder() {
				var i = document.createElement('input');
				return 'placeholder' in i;
			}

			// Change input text on focus
			if (!supports_input_placeholder()) {
				jQuery(':text').focus(function(){
					var self = jQuery(this);
					if (self.val() == self.attr('placeholder')) self.val('');
				}).blur(function(){
					var self = jQuery(this), value = jQuery.trim(self.val());
					if(val == '') self.val(self.attr('placeholder'));
				});
			} else {
				jQuery(':text').focus(function(){
					jQuery(this).css('color', '#000');
				});
			}
		}) ;

	/** Form Pickup Only functionnality **/
	//When checkbox is clicked
	jQuery('#pickup').click(function(){

		//First check if the box is already clicked - it will be check on first click as the state is enabled before jquery takes over
		if(this.checked){

			//We disable shipping box and nullify the value
			jQuery('#shipping').attr('disabled', true) ;
			jQuery('#shipping').val('') ;
			jQuery('#shipping').css('background-color', '#EBEBE4') ;

		}
		//Otherwise
		else{
			console.log('unchecked') ;
			//We then enable the shipping box
			jQuery('#shipping').removeAttr('disabled') ;
			jQuery('#shipping').css('background-color', '#FFFFFF') ;

		}


	});

	/** Form validation - ADD PRODUCT **/
	//To make it work we need to capture the keystroke in the editor and plug them to the textarea

	//When form is submitted
	jQuery('button.add-product, button-edit-product').click(function(e){
		e.preventDefault() ;

		var form = jQuery('#add_product') ;
		var error = 0;
		var errors = new Array() ;
		var i = 0 ;

		//We get value from iframes and add to textarea
		var desc = jQuery('iframe#description_ifr').contents().find('body p').text() ;
		jQuery('#add_product #description').append(desc) ;


		var details = jQuery('iframe#details_ifr').contents().find('body p').text() ;
		jQuery('#add_product #details').append(desc) ;


		var warranty = jQuery('iframe#warranty_ifr').contents().find('body p').text() ;
		jQuery('#add_product #warranty').append(desc) ;

		//Checking that nothing's left empty
		jQuery('#add_product .left input, #add_product .left textarea').each(function(){
			/*Logic:
				if pick is checked
				shipping should be ignored.

			  Construction:
			  When checking shipping element
			  	also check if pickup element is checked
			  		if yes -> ignore shipping (do not log an error)
			  		if no 	-> continue with shipping

			*/
			//console.log($(this).attr('id')) ;

			//If element is shipping
			if( ($(this).attr('id') == 'shipping') ){

				//Check if pickup is ticked
				if( $('#pickup').attr('checked') == 'checked' ){

					return true ;

				}

			}

			if($(this).val() == ''){

				$(this).css('background', '#B94A48') ;

				//console.log($(this).val());

				error = 1 ;
				errors[i] = $(this).attr('id') ;

			}

		i++ ;

		}) ;

		if(error >= 1){

			form.prepend('<span class="error">You forgot stuff:<br /></span>') ;

			for (var i=0;i<errors.length;i++){
				if(typeof(errors[i]) !== 'undefined'){
					form.prepend('<span class="error">'+ errors[i] + '</span>') ;
				}
			}

			$('.error').fadeOut(10000) ;

		}
		else{

			console.log('submitted') ;
			form.submit() ;

		}


	});
	jQuery('#add_product .left input, #add_product .left textarea').focus(function(){

		$(this).css('background', '#FFFFFF') ;

	});

	//Ask for confirmation to delete product
	jQuery('.delete-product').click(function(e){

		var check = confirm('Are you sure you want to delete this item?') ;

		//Check for true/false
		if(check == true){
			return true ;
		}
		else{
			e.preventDefault() ;
		}

	});

})(jQuery);