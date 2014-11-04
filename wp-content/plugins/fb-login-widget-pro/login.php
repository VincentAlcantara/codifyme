<?php
/*
Plugin Name: Facebook Login Widget (PRO)
Plugin URI: http://avifoujdar.wordpress.com/category/my-wp-plugins/
Description: This is a social login plugin as widget. It supports login from Facebook, Google, Twitter and LinkedIn accounts. This widget also supports default user login of wordpress. 
Version: 3.1.1
Author: avimegladon
Author URI: http://avifoujdar.wordpress.com/
*/

/**
	  |||||   
	<(`0_0`)> 	
	()(afo)()
	  ()-()
**/

function plug_install_afo_fb_login_pro(){
	include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
	if ( is_plugin_active( 'facebook-login-afo/login.php' ) or is_plugin_active( 'login-sidebar-widget/login.php' ) ) {
	 	wp_die('It seems you have <strong>Facebook Login Widget</strong> or <strong>Login Widget With Shortcode</strong> plugin activated. Please deactivate them to continue.');
		exit;
	}
	include_once dirname( __FILE__ ) . '/settings.php';
	include_once dirname( __FILE__ ) . '/login_afo_widget.php';
	include_once dirname( __FILE__ ) . '/forgot_pass_class.php';
	include_once dirname( __FILE__ ) . '/data.php';
	include_once dirname( __FILE__ ) . '/login_afo_widget_shortcode.php';
	new afo_fb_login;
}

class afo_fb_login_pro_checking {
	function __construct() {
		plug_install_afo_fb_login_pro();
	}
}
new afo_fb_login_pro_checking;

function afo_fb_login_pro_set_default_data() {
	$forgot_password_link_mail_subject = "Password Reset Request";
 	$forgot_password_link_mail_body = "
	Someone requested that the password be reset for the following account:
	\r\n
	#siteurl#
	\r\n
	Username: #username#
	\r\n
	If this was a mistake, just ignore this email and nothing will happen.
	\r\n
	To reset your password, visit the following address:
	\r\n
	#resetlink#
	";
	$new_password_mail_subject = "Password Reset Request";
	$new_password_mail_body = "
	Your new password for the account at:
	\r\n
	#siteurl#
	\r\n
	Username: #username#
	\r\n
	Password: #password#
	\r\n
	You can now login with your new password at:
	#siteurl#
	";
	update_option( 'forgot_password_link_mail_subject', $forgot_password_link_mail_subject );
    update_option( 'forgot_password_link_mail_body', $forgot_password_link_mail_body );
	update_option( 'new_password_mail_subject', $new_password_mail_subject );
    update_option( 'new_password_mail_body', $new_password_mail_body );
}
register_activation_hook( __FILE__, 'afo_fb_login_pro_set_default_data' );

function fb_social_logins(){
	$fb = new fb_login_wid;
	$fb->social_logins();
}