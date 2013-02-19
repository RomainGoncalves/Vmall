<?php
#PAGE FOR LOGIN
/*-----------------------------------------------------------------------------------*/
/*	Adding required fields to the registration page
/*-----------------------------------------------------------------------------------*/	

	//add_action('register_post','check_fields',10,3);
	add_action('user_register', 'register_extra_fields');

	function check_fields ( $login, $email, $errors )
	{
		
		if ( $_POST['first_name'] == '' )
		{
			$errors->add( 'empty_realname', "<strong>ERROR</strong>: Please enter the name of your first name" );
		}
		
		if ( $_POST['last_name'] == '' )
		{
			$errors->add( 'empty_realname', "<strong>ERROR</strong>: Please enter the name of your first name" );
		}

		if ( $_POST['buyer_paypal'] == '' )
		{
			$errors->add( 'empty_realname', "<strong>ERROR</strong>: Please enter your buyer_paypalpaypal E-mail" );
		}

		if ( $_POST['postcode'] == '' )
		{
			$errors->add( 'empty_realname', "<strong>ERROR</strong>: Please enter your postcode" );
		}

	}

	function register_extra_fields ( $user_id, $password = "", $meta = array() )
	{
		update_user_meta( $user_id, 'first_name', $_POST['first_name'] );
		update_user_meta( $user_id, 'last_name', $_POST['last_name'] );
		update_user_meta( $user_id, 'buyer_paypal', $_POST['buyer_paypal'] );
		update_user_meta( $user_id, 'postcode', $_POST['postcode'] );
		update_user_meta( $user_id, 'acn', $_POST['acn'] );
		update_user_meta( $user_id, 'abn', $_POST['abn'] );
		update_user_meta( $user_id, 'seller_paypal', $_POST['seller_paypal'] );
		update_user_meta( $user_id, 'seller_website', $_POST['seller_website'] );

	}
/*-----------------------------------------------------------------------------------*/  
/*  Change 'register' to 'join' 
/*-----------------------------------------------------------------------------------*/   
  
    function tml_title_filter( $title, $action ) {  
    if ( $action == 'register' )  
        return __( 'Sign Up' );  
    return $title;  
    }  
    add_filter( 'tml_title', 'tml_title_filter', 10, 2 );
/*-----------------------------------------------------------------------------------*/  
/*  Reomve fields from profile 
/*-----------------------------------------------------------------------------------*/  
    function extra_contact_info($contactmethods) {  
        unset($contactmethods['aim']);  
        unset($contactmethods['yim']);  
        unset($contactmethods['jabber']);  
          
        //$contactmethods['postcode'] = 'Post code (required)';

        //$contactmethods['buyer_paypal'] = 'Paypal E-mail (required)';
          
        return $contactmethods;  
    }  
    add_filter('user_contactmethods', 'extra_contact_info'); 