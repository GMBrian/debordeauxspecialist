<?php
/*
If you would like to edit this file, copy it to your current theme's directory and edit it there.
Theme My Login will always look in your theme's directory first, before using this default template.
*/
?>
<div class="user-register" id="theme-my-login<?php $template->the_instance(); ?>">
	<?php //$template->the_action_template_message( 'register' ); ?>
	<?php $page_id = 102; ?>
	<?php $field = get_field('inleiding', $page_id, false); ?>
	<?php 
		if(strlen($field) > 0):
			echo $field;
			echo '<hr>';
		endif;
	?>
    <form name="registerform" id="registerform<?php $template->the_instance(); ?>" action="<?php $template->the_action_url( 'register' ); ?>" method="post">
    	<?php $field = get_field('abonnementkeuze_titel', $page_id, false); ?>
    	<h2 class="caps-head"><?php echo $field; ?></h2>
    	<ul class="subscription">
    		<li><a class="subscription-gold subscription-button active">Goud</a></li>
    		<li><a class="subscription-silver subscription-button">Silver</a></li>
    		<div class="clearfix"></div>
    	</ul>
    	<ul class="subscription-info">
    		<li class="subscription-gold-info">
	    		<?php $field = get_field('goud_abonnement_product', $page_id); ?>
	    		<?php $price = get_post_meta($field->ID, '_price'); ?>
	    		<p class="subscription-price"><?php print_valuta($price[0]); ?><br><span style="font-size: 14px;"> prijs per jaar</span></p>
    			<?php $field = get_field('goud_beschrijving', $page_id, false); ?>
    			<?php echo $field; ?>
    		</li>
    		<li class="subscription-silver-info display-none">
	    		<?php $field = get_field('silver_abonnement_product', $page_id); ?>
	    		<?php $price = get_post_meta($field->ID, '_price'); ?>
	    		<p class="subscription-price"><?php print_valuta($price[0]); ?><br><span style="font-size: 14px;"> prijs per jaar</span></p>
    			<?php $field = get_field('silver_beschrijving', $page_id, false); ?>
    			<?php echo $field; ?>
    		</li>
    		<div class="clearfix"></div>
    	</ul>
		<hr>
    	<div class="clearfix"></div>
    	<h2 class="caps-head">Accountgegevens</h2>
		<?php $template->the_errors(); ?>
		<p>
			<label for="user_login<?php $template->the_instance(); ?>"><?php _e( 'Username' ); ?></label><small>Deze naam wordt publiek weergegeven als u een reactie plaatst</small>
			<input type="text" name="user_login" id="user_login<?php $template->the_instance(); ?>" class="input" value="<?php $template->the_posted_value( 'user_login' ); ?>" placeholder="Jansen123" size="20" />
		</p>
        <p>
            <label for="user_email<?php $template->the_instance(); ?>"><?php _e( 'E-mailadres', 'theme-my-login' ) ?></label>
            <input type="text" name="user_email" id="user_email<?php $template->the_instance(); ?>" class="input" value="<?php $template->the_posted_value( 'user_email' ); ?>" placeholder="naam@voorbeeld.nl" size="20" />
        </p>
        <?php 
			do_action('register_form'); // Wordpress hook
			do_action_ref_array('tml_register_form', array(&$template)); //TML hook
		?>
		<hr>
    	<h2 class="caps-head">Factuur- / Verzendadres</h2>
    	<h3>Factuuradres</h3>
        <p>
			<label for="first_name<?php $template->the_instance(); ?>"><?php _e( 'First name', 'theme-my-login' ) ?></label>
			<input type="text" name="first_name" id="first_name<?php $template->the_instance(); ?>" class="input" value="<?php $template->the_posted_value( 'first_name' ); ?>" placeholder="Jan" size="20">
		</p>
		<p>
			<label for="last_name<?php $template->the_instance(); ?>"><?php _e( 'Last name', 'theme-my-login' ) ?></label>
			<input type="text" name="last_name" id="last_name<?php $template->the_instance(); ?>" class="input" value="<?php $template->the_posted_value( 'last_name' ); ?>" placeholder="Jansen" size="20">
		</p>
		<p>
			<label for="billing_company<?php $template->the_instance(); ?>"><?php _e( 'Bedrijfsnaam', 'theme-my-login' ) ?></label>
			<input type="text" name="billing_company" id="billing_company<?php $template->the_instance(); ?>" class="input" value="<?php $template->the_posted_value('billing_company'); ?>" placeholder="Voorbeeld B.V." size="20">
		</p>
		<p>
			<label for="billing_address_1<?php $template->the_instance(); ?>"><?php _e( 'Adres', 'theme-my-login' ) ?></label>
			<input type="text" name="billing_address_1" id="address_1<?php $template->the_instance(); ?>" class="input" value="<?php $template->the_posted_value('billing_address_1'); ?>" placeholder="Hoofdstraat 1" size="20">
		</p>
		<p>
			<input type="text" name="billing_address_2" id="billing_address_2<?php $template->the_instance(); ?>" class="input" value="<?php $template->the_posted_value('billing_address_2'); ?>" placeholder="" size="20">
		</p>
		<p>
			<label for="billing_city<?php $template->the_instance(); ?>"><?php _e('Plaats', 'theme-my-login' ) ?></label>
			<input type="text" name="billing_city" id="billing_city<?php $template->the_instance(); ?>" class="input" value="<?php $template->the_posted_value('billing_city'); ?>" placeholder="Amsterdam" size="20">
		</p>
		<p>
			<label for="billing_postcode<?php $template->the_instance(); ?>"><?php _e('Postcode', 'theme-my-login' ) ?></label>
			<input type="text" name="billing_postcode" id="billing_postcode<?php $template->the_instance(); ?>" class="input" value="<?php $template->the_posted_value('billing_postcode'); ?>" placeholder="1234 AB" size="20">
		</p>
		<p>
			<label for="billing_country<?php $template->the_instance(); ?>"><?php _e('Land', 'theme-my-login' ) ?></label>
			<?php print_wc_country_dropdown('billing_country', $template); ?>
		</p>
    	<h3>Verzendadres</h3>
    	<p>
      		<label class="checkbox">
    			<input id="display-shipping-information" name="shipping_information" type="checkbox" checked>Gelijk aan factuuradres
    		</label>
    	</p>
    	<div id="shipping-information" class="display-none">
	        <p>
				<label for="shipping_first_name<?php $template->the_instance(); ?>"><?php _e( 'First name', 'theme-my-login' ) ?></label>
				<input type="text" name="shipping_first_name" id="shipping_first_name<?php $template->the_instance(); ?>" class="input" value="<?php $template->the_posted_value( 'shipping_first_name' ); ?>" placeholder="Jan" size="20">
			</p>
			<p>
				<label for="shipping_last_name<?php $template->the_instance(); ?>"><?php _e( 'Last name', 'theme-my-login' ) ?></label>
				<input type="text" name="shipping_last_name" id="shipping_last_name<?php $template->the_instance(); ?>" class="input" value="<?php $template->the_posted_value( 'shipping_last_name' ); ?>" placeholder="Jansen" size="20">
			</p>
			<p>
				<label for="shipping_company<?php $template->the_instance(); ?>"><?php _e( 'Bedrijfsnaam', 'theme-my-login' ) ?></label>
				<input type="text" name="shipping_company" id="shipping_company<?php $template->the_instance(); ?>" class="input" value="<?php $template->the_posted_value('shipping_company'); ?>" placeholder="Voorbeeld B.V." size="20">
			</p>
			<p>
				<label for="shipping_address_1<?php $template->the_instance(); ?>"><?php _e( 'Adres', 'theme-my-login' ) ?></label>
				<input type="text" name="shipping_address_1" id="address_1<?php $template->the_instance(); ?>" class="input" value="<?php $template->the_posted_value('shipping_address_1'); ?>" placeholder="Hoofdstraat 1" size="20">
			</p>
			<p>
				<input type="text" name="shipping_address_2" id="shipping_address_2<?php $template->the_instance(); ?>" class="input" value="<?php $template->the_posted_value('shipping_address_2'); ?>" placeholder="" size="20">
			</p>
			<p>
				<label for="shipping_city<?php $template->the_instance(); ?>"><?php _e('Plaats', 'theme-my-login' ) ?></label>
				<input type="text" name="shipping_city" id="shipping_city<?php $template->the_instance(); ?>" class="input" value="<?php $template->the_posted_value('shipping_city'); ?>" placeholder="Amsterdam" size="20">
			</p>
			<p>
				<label for="shipping_postcode<?php $template->the_instance(); ?>"><?php _e('Postcode', 'theme-my-login' ) ?></label>
				<input type="text" name="shipping_postcode" id="shipping_postcode<?php $template->the_instance(); ?>" class="input" value="<?php $template->the_posted_value('shipping_postcode'); ?>" placeholder="1234 AB" size="20">
			</p>
			<p>
				<label for="shipping_country<?php $template->the_instance(); ?>"><?php _e('Land', 'theme-my-login' ) ?></label>
				<?php print_wc_country_dropdown('shipping_country', $template); ?>
			</p>
		</div>
		<p id="reg_passmail<?php $template->the_instance(); ?>"><?php echo apply_filters( 'tml_register_passmail_template_message', __('A password will be e-mailed to you.', 'theme-my-login')); ?></p>
        <p class="submit">
            <input type="submit" class="btn-register" name="wp-submit" id="wp-submit<?php $template->the_instance(); ?>" value="<?php _e('Register', 'theme-my-login' ); ?>">
			<input type="hidden" name="redirect_to" value="<?php $template->the_redirect_url( 'register' ); ?>">
			<input type="hidden" name="instance" value="<?php $template->the_instance(); ?>">
        </p>
    </form>
	<?php //$template->the_action_links( array( 'register' => false ) ); ?>
</div>
