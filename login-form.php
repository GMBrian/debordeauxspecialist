<?php
/*
If you would like to edit this file, copy it to your current theme's directory and edit it there.
Theme My Login will always look in your theme's directory first, before using this default template.
*/
?>
<?php $template->the_errors(); ?>
<div class="wrapper-login">
	<div class="user-login col" id="theme-my-login<?php $template->the_instance(); ?>">
		<?php $template->the_action_template_message( 'login' ); ?>
		<form name="loginform" id="loginform<?php $template->the_instance(); ?>" action="<?php $template->the_action_url( 'login' ); ?>" method="post">
			<p>
				<label for="user_login<?php $template->the_instance(); ?>"><?php _e( 'Gebruiker of e-mailadres', 'theme-my-login' ) ?>:</label>
				<input type="text" name="log" id="user_login<?php $template->the_instance(); ?>" class="input" value="<?php $template->the_posted_value( 'log' ); ?>" placeholder="naam@voorbeeld.nl" size="20" />
			</p>
			<p>
				<label for="user_pass<?php $template->the_instance(); ?>"><?php _e( 'Wachtwoord', 'theme-my-login' ) ?>:</label>
				<input type="password" name="pwd" id="user_pass<?php $template->the_instance(); ?>" class="input" value="" size="20" placeholder="●●●●●●●●●●" />
			</p>
			<?php
				do_action( 'login_form' ); // Wordpress hook
				do_action_ref_array( 'tml_login_form', array( &$template ) ); // TML hook
			?>
			<p class="forgetmenot">
				<input name="rememberme" type="checkbox" id="rememberme<?php $template->the_instance(); ?>" value="forever" />
				<label for="rememberme<?php $template->the_instance(); ?>"><?php _e( 'Onthoud mij', 'theme-my-login' ); ?></label>
			</p>
			<p class="submit">
				<input type="submit" class="btn-login" name="wp-submit" id="wp-submit<?php $template->the_instance(); ?>" value="<?php _e( 'Log In', 'theme-my-login' ); ?>" />
				<input type="hidden" name="redirect_to" value="<?php $template->the_redirect_url( 'login' ); ?>" />
				<input type="hidden" name="testcookie" value="1" />
				<input type="hidden" name="instance" value="<?php $template->the_instance(); ?>" />
			</p>
		</form>
		<?php $template->the_action_links( array( 'login' => false ) ); ?>
		<div class="clearfix"></div>
	</div>
	<div class="user-login-subscribe col">
		<h3 class="title-header">Nog geen lid?</h3>
		<p>
			Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris at ligula a nisl viverra ornare. Donec non tortor vel purus dignissim malesuada in quis ipsum. Vestibulum cursus accumsan nibh, blandit semper tortor sodales sed. Nullam in augue quis erat pharetra lacinia.
		</p>
		<a class="btn-register" href="<?php site_url('/lid-worden'); ?>">Registreer</a>
	</div>
</div>
