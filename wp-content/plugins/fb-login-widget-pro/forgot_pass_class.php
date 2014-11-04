<?php

class afo_forgot_pass_class {
	
	public function ForgotPassForm(){
		if(!session_id()){
			@session_start();
		}
		
		$this->error_message();
		if(!is_user_logged_in()){
		?>
		<form name="forgot" id="forgot" method="post" action="">
		<input type="hidden" name="option" value="afo_forgot_pass" />
			<ul class="login_wid forgot_pass">
				<li><?php _e('Email','flp');?></li>
				<li><input type="text" name="user_username" required="required"/></li>
				<li><input name="forgot" type="submit" value="<?php _e('Submit','flp');?>" /></li>
				<li class="forgot-text"><?php _e('Please enter your email. The password reset link will be provided in your email.','flp');?></li>
			</ul>
		</form>
		<?php 
		}
	}
	
	public function message_close_button(){
		$cb = '<a href="javascript:void(0);" onclick="closeMessage();" class="close_button_afo">x</a>';
		return $cb;
	}
	
	public function error_message(){
		if(!session_id()){
			@session_start();
		}
		
		if($_SESSION['msg']){
			echo '<div class="'.$_SESSION['msg_class'].'">'.$_SESSION['msg'].$this->message_close_button().'</div>';
			unset($_SESSION['msg']);
			unset($_SESSION['msg_class']);
		}
	}
} 


function forgot_pass_validate(){
	if(!session_id()){
		@session_start();
	}
	if (!function_exists('set_html_content_type')) {
		function set_html_content_type() {
			return 'text/html';
		}
	}
	
	if(isset($_GET['key']) && $_GET['action'] == "reset_pwd") {
		global $wpdb;
		$reset_key = $_GET['key'];
		$user_login = $_GET['login'];
		$user_data = $wpdb->get_row($wpdb->prepare("SELECT ID, user_login, user_email FROM $wpdb->users WHERE user_activation_key = %s AND user_login = %s", $reset_key, $user_login));
		
		$user_login = $user_data->user_login;
		$user_email = $user_data->user_email;
		
		if(!empty($reset_key) && !empty($user_data)) {
			$new_password = wp_generate_password(7, false);
			wp_set_password( $new_password, $user_data->ID );
			//mailing reset details to the user
			$headers = 'From: '.get_bloginfo('name').' <no-reply@wordpress.com>' . "\r\n";
			$message = nl2br(get_option('new_password_mail_body'));
			$message = str_replace(array('#siteurl#','#username#','#password#'), array(site_url(),$user_login,$new_password), $message);
			add_filter( 'wp_mail_content_type', 'set_html_content_type' );
			if ( $message && !wp_mail($user_email, get_option('new_password_mail_subject'), $message, $headers) ) {
				wp_die('Email failed to send for some unknown reason');
				exit;
			}
			else {
				wp_die('New Password successfully sent to your mail address.');
				exit;
			}
			remove_filter( 'wp_mail_content_type', 'set_html_content_type' );
		} 
		else {
			wp_die('Not a Valid Key.');
			exit;
		}
}

	if($_POST['option'] == "afo_forgot_pass"){
	
		global $wpdb;
		$msg = '';
		if(empty($_POST['user_username'])) {
			$_SESSION['msg_class'] = 'error_wid_login';
			$msg .= __('Email is empty!','flp');
		}
		
		$user_username = $wpdb->escape(trim($_POST['user_username']));
		
		$user_data = get_user_by('email', $user_username);
		if(empty($user_data)) { 
			$_SESSION['msg_class'] = 'error_wid_login';
			$msg .= __('Invalid E-mail address!','flp');
		}
		
		$user_login = $user_data->data->user_login;
		$user_email = $user_data->data->user_email;
		
		if($user_email){
			$key = $wpdb->get_var($wpdb->prepare("SELECT user_activation_key FROM $wpdb->users WHERE user_login = %s", $user_login));
			if(empty($key)) {
				$key = wp_generate_password(10, false);
				$wpdb->update($wpdb->users, array('user_activation_key' => $key), array('user_login' => $user_login));	
			}
			
			//mailing reset details to the user
			$headers = 'From: '.get_bloginfo('name').' <no-reply@wordpress.com>' . "\r\n";
			$resetlink = site_url() . "?action=reset_pwd&key=$key&login=" . rawurlencode($user_login);
			$message = nl2br(get_option('forgot_password_link_mail_body'));
			$message = str_replace(array('#siteurl#','#username#','#resetlink#'), array(site_url(),$user_login,$resetlink), $message);
			
			add_filter( 'wp_mail_content_type', 'set_html_content_type' );
			if ( !wp_mail($user_email, get_option('forgot_password_link_mail_subject'), $message, $headers) ) {
				$_SESSION['msg_class'] = 'error_wid_login';
				$_SESSION['msg'] = __('Email failed to send for some unknown reason.','flp');
			}
			else {
				$_SESSION['msg_class'] = 'success_wid_login';
				$_SESSION['msg'] = __('We have just sent you an email with Password reset instructions.','flp');
			}
			remove_filter( 'wp_mail_content_type', 'set_html_content_type' );
		} else {
			$_SESSION['msg_class'] = 'error_wid_login';
			$_SESSION['msg'] = $msg;
		}
	}
}
add_action( 'init', 'forgot_pass_validate' );
?>