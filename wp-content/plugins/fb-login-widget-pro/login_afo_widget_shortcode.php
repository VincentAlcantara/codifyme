<?php
function fb_login_widget_pro_shortcode( $atts ) {
     global $post;
	 extract( shortcode_atts( array(
	      'title' => '',
     ), $atts ) );
     
	ob_start();
	$wid = new fb_login_wid;
	if($title){
		echo '<h2>'.$title.'</h2>';
	}
	$wid->loginForm();
	$ret = ob_get_contents();	
	ob_end_clean();
	return $ret;
}
add_shortcode( 'fb_login_pro', 'fb_login_widget_pro_shortcode' );

function forgot_password_afo_shortcode( $atts ) {
     global $post;
	 extract( shortcode_atts( array(
	      'title' => '',
     ), $atts ) );
     
	ob_start();
	$fpc = new afo_forgot_pass_class;
	if($title){
		echo '<h2>'.$title.'</h2>';
	}
	$fpc->ForgotPassForm();
	$ret = ob_get_contents();	
	ob_end_clean();
	return $ret;
}
add_shortcode( 'forgot_password', 'forgot_password_afo_shortcode' );
?>