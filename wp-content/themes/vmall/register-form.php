<div class="login" id="theme-my-login<?php $template->the_instance(); ?>">

	<?php //$template->the_action_template_message( 'register' ); ?>

	<?php //$template->the_errors(); ?>

    <form name="registerform" id="registerform<?php $template->the_instance(); ?>" action="<?php $template->the_action_url( 'register' ); ?>" method="post">
        <!--<fieldset class="user_type">
            <label for="buyer" class="buyer">Buyer</label>
            <input type="radio" name="user_type" id="buyer" checked="checked" />
            <label for="seller" class="seller">Seller</label>
            <input type="radio" name="user_type" id="seller" />
        </fieldset>-->

        <fieldset class="user_buyer">

            <label for="user_login<?php $template->the_instance(); ?>"><?php _e( 'Username', 'theme-my-login' ) ?></label>

            <input type="text" name="user_login" id="user_login<?php $template->the_instance(); ?>" class="input" value="<?php $template->the_posted_value( 'user_login' ); ?>" size="20" tabindex="10" />

            <label for="user_email<?php $template->the_instance(); ?>"><?php _e( 'E-mail', 'theme-my-login' ) ?></label>

           <input type="text" name="user_email" id="user_email<?php $template->the_instance(); ?>" class="input" value="<?php $template->the_posted_value( 'user_email' ); ?>" size="20" tabindex="11" />
        </fieldset>
        <!--     <label for="first_name">First name</label>
            <input id="first_name" type="text" size="25" value="<?php echo $_POST['first_name']; ?>" name="first_name" tabindex="12" />


            <label for="last_name">Last name</label>
            <input id="last_name" type="text" size="25" value="<?php echo $_POST['last_name']; ?>" name="last_name" tabindex="13" />

            <label for="buyer_paypal">Paypal E-mail</label>
            <input id="buyer_paypal" type="text" size="25" value="<?php echo $_POST['buyer_paypal']; ?>" name="buyer_paypal" tabindex="14" />

             <label for="postcode">Postcode</label>
            <input id="postcode" type="text" size="4" value="<?php echo $_POST['postcode']; ?>" name="postcode" tabindex="15" />
            

        <fieldset class="user_seller">
            <label for="acn">ACN</label>
            <input type="text" name="acn" id="acn" tabindex="16" />
            <label for="abn">ABN</label>
            <input type="text" name="abn" id="abn" tabindex="17" />
            <label for="seller_paypal">Paypal Business E-mail</label>
            <input type="text" name="seller_paypal" id="seller_paypal"  tabindex="18" />
            <label for="seller_website">Website</label>
            <input type="text" name="seller_website" id="seller_website"  tabindex="19" />
        </fieldset>-->

<?php

do_action( 'register_form' ); // Wordpress hook

do_action_ref_array( 'tml_register_form', array( &$template ) ); //TML hook

?>

		<fieldset id="reg_passmail<?php $template->the_instance(); ?>"><?php echo apply_filters( 'tml_register_passmail_template_message', __( 'A password will be e-mailed to you.', 'theme-my-login' ) ); ?></fieldset>

        <fieldset class="submit">

            <input type="submit" name="wp-submit" id="wp-submit<?php $template->the_instance(); ?>" value="<?php _e( 'Register', 'theme-my-login' ); ?>" tabindex="100" />

			<input type="hidden" name="redirect_to" value="<?php $template->the_redirect_url( 'login' ); ?>" />

			<input type="hidden" name="instance" value="<?php $template->the_instance(); ?>" />

        </fieldset>

    </form>

	<?php $template->the_action_links( array( 'register' => false ) ); ?>

</div>

