<?php
/**
 * Template Name: Login TempPage
 *
 */
get_header('no-image');
?>

<div class="container">
	<div class="row">
		<div id="primary" <?php bavotasan_primary_attr(); ?>>
			<?php $args = array(
				'echo' => true,
				'redirect' => site_url(),
				'form_id' => 'loginform',
				'label_username' => __( 'Username' ),
				'label_password' => __( 'Password' ),
				'label_remember' => __( 'Remember Me' ),
				'label_log_in' => __( 'Log In' ),
				'id_username' => 'user_login',
				'id_password' => 'user_pass',
				'id_remember' => 'rememberme',
				'id_submit' => 'wp-submit',
				'remember' => true,
				'value_username' => NULL,
				'value_remember' => false );

			if(isset($_GET['login']) && $_GET['login'] == 'failed')
			{ 
				?>
				<div id="login-error" style="background-color: #FFEBE8;border:1px solid #C00;padding:5px;">
					<p>Login failed: You have entered an incorrect Username or password, please try again.</p>
				</div>
				<?php
			}
			add_action( 'login_form_bottom', 'custom_login_form_bottom' );

			function custom_login_form_bottom (){
				$html = '<div id="custom_login_form_bottom"><a href="/register">New User?</a><a href="/wp-login.php?action=lostpassword">Lost Password?</a></div>';
//<i class="fa fa-pencil-square-o"></i>
				return $html;
			}

			wp_login_form( $args );
			?>
		</div>
	</div>
</div>
<script>
jQuery(document).ready(function(){
    jQuery('#user_login').attr('placeholder', 'User Name');
    jQuery('#user_email').attr('placeholder', 'User Email');
    jQuery('#user_pass').attr('placeholder', 'User Password');
});
</script>

<?php get_footer(); ?>