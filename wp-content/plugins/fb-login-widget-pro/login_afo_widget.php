<?php
class fb_login_wid extends WP_Widget {

	private $appId,$appSecret;
	
	public function __construct() {
		// facebook
		include_once  dirname( __FILE__ ) . '/facebook/facebook.php';
		// twitter
		include_once  dirname( __FILE__ ) . '/twitter/twitteroauth/twitteroauth.php';
		// google
		require_once dirname( __FILE__ ) . '/google/Google_Client.php';
		require_once dirname( __FILE__ ) . '/google/contrib/Google_Oauth2Service.php';
		// linkedin
		require_once dirname( __FILE__ ) . '/linkedin/linkedin_3.2.0.class.php';
		
		$this->appId = get_option('afo_fb_app_id');
		$this->appSecret = get_option('afo_fb_app_secret');
		add_action( 'wp_enqueue_scripts', array( $this, 'register_plugin_styles' ) );
		add_action( 'wp_head', array( $this, 'register_login_scripts' ) );
		add_action( 'wp_head', array( $this, 'custom_styles_afo' ) );
		parent::__construct(
	 		'fb_login_wid',
			'FB Login Widget AFO (PRO)',
			array( 'description' => __( 'This is a simple login form in the widget.', 'text_domain' ), )
		);
	 }
	 

	public function widget( $args, $instance ) {
		extract( $args );

		$wid_title = apply_filters( 'widget_title', $instance['wid_title'] );

		echo $args['before_widget'];
		if ( ! empty( $wid_title ) )
			echo $args['before_title'] . $wid_title . $args['after_title'];
			$this->loginForm();
		echo $args['after_widget'];
	}

	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['wid_title'] = strip_tags( $new_instance['wid_title'] );
		return $instance;
	}

	public function form( $instance ) {
		$wid_title = $instance[ 'wid_title' ];
		?>
		<p><label for="<?php echo $this->get_field_id('wid_title'); ?>"><?php _e('Title:'); ?> </label>
		<input class="widefat" id="<?php echo $this->get_field_id('wid_title'); ?>" name="<?php echo $this->get_field_name('wid_title'); ?>" type="text" value="<?php echo $wid_title; ?>" />
		</p>
		<?php 
	}
	
	public function add_extra_links(){
		$login_afo_forgot_pass_link = get_option('login_afo_forgot_pass_link');
		$login_afo_register_link = get_option('login_afo_register_link');
		if($login_afo_forgot_pass_link or $login_afo_register_link){
			echo '<li class="extra-links">';
		}
		if($login_afo_forgot_pass_link){
			echo '<a href="'.get_permalink($login_afo_forgot_pass_link).'">'.__('Lost Password?','flp').'</a>';
		}
		if($login_afo_register_link){
			echo ' <a href="'.get_permalink($login_afo_register_link).'">'.__('Register','flp').'</a>';
		}
		if($login_afo_forgot_pass_link or $login_afo_register_link){
			echo '</li>';
		}
	}

	public function social_logins(){ 
	$enable_facebook_login = get_option('enable_facebook_login');
	$enable_google_login = get_option('enable_google_login');
	$enable_twitter_login = get_option('enable_twitter_login');
	$enable_linkedin_login = get_option('enable_linkedin_login');
	?>
		<?php if($enable_facebook_login == "Yes" || $enable_google_login == "Yes" || $enable_twitter_login == "Yes"){ ?>
	 	<font size="+1" style="vertical-align:top;"><?php _e('Login with','flp');?> </font>
		<?php } ?>
		<?php if($enable_facebook_login == "Yes"){?>
		<a href="javascript:void(0);" onClick="FBLogin();"><img src="<?php echo plugins_url( 'images/facebook.png' , __FILE__ );?>" alt="Fb Connect" title="Login with Facebook" /></a>&nbsp;
		<?php } ?>
		<?php if($enable_google_login == "Yes"){?>
		<a href="javascript:void(0);" onclick="GoogleLogin();"><img src="<?php echo plugins_url( 'images/google.png' , __FILE__ );?>" alt="Google Connect" title="Login with Google" /></a>&nbsp;
		<?php } ?>
		<?php if($enable_twitter_login == "Yes"){?>
		<a href="javascript:void(0);" onclick="TwitterLogin();"><img src="<?php echo plugins_url( 'images/twitter.png' , __FILE__ );?>" alt="Twitter Connect" title="Login with Twitter" /></a>
		<?php } ?>
		<?php if($enable_linkedin_login == "Yes"){?>
		<a href="javascript:void(0);" onclick="LinkedInLogin();"><img src="<?php echo plugins_url( 'images/linkedin.png' , __FILE__ );?>" alt="LinkedIn Connect" title="Login with LinkedIn" /></a>
		<?php } ?>
	<?php
	}

	public function get_email_form(){ ?>
		<form name="login" id="login" method="post" action="">
		<input type="hidden" name="option" value="afo_twitter_login_enter_email" />
			<ul class="login_wid">
			<li><?php _e('Email','flp');?></li>
			<li><input type="text" name="user_email" required="required"/></li>
			<li><input name="login" type="submit" value="<?php _e('Login','flp');?>" /></li>
			<li class="afo_social_login"><?php $this->social_logins();?></li>
			</ul>
		</form>
	<?php
	}

	public function get_login_form(){ ?>
		<form name="login" id="login" method="post" action="">
		<input type="hidden" name="option" value="afo_user_login" />
			<ul class="login_wid">
			<li><?php _e('Username','flp');?></li>
			<li><input type="text" name="user_username" required="required"/></li>
			<li><?php _e('Password','flp');?></li>
			<li><input type="password" name="user_password" required="required"/></li>
			<?php $this->add_remember_me();?>
			<li><input name="login" type="submit" value="<?php _e('Login','flp');?>" /></li>
			<?php $this->add_extra_links();?>
			<li class="afo_social_login"><?php $this->social_logins();?></li>
			</ul>
		</form>
	<?php 
	} 
	
	public function add_remember_me(){
		$add_remember_me = get_option('add_remember_me');
		if($add_remember_me == "Yes"){
			echo '<li><input type="checkbox" name="user_rem" value="Yes" /><label class="user_rem">'.__('Remember Me','flp').'</label></li>';
		}
	}
	
	public function loginForm(){
		if(!session_id()){
			@session_start();
		}
		global $post;
		$this->error_message();
		if(!is_user_logged_in()){
			if($_SESSION['afo_twitter_id']){ 
				$this->get_email_form();
			}else { 
				$this->get_login_form();
			} 
		} else {
			global $current_user;
     		get_currentuserinfo();
			$login_pro_logout_redirect_page = (get_option('login_pro_logout_redirect_page') == ''?site_url():get_permalink(get_option('login_pro_logout_redirect_page')));
			$login_pro_link_in_username = (get_option('login_pro_link_in_username') == ''?__('Howdy,','flp').$current_user->display_name:'<a href="'.get_permalink(get_option('login_pro_link_in_username')).'">'.__('Howdy,','flp').$current_user->display_name.'</a>');
			?>
			<ul style="list-style-type:none;">
				<li><?php echo $login_pro_link_in_username;?> | <a href="<?php echo wp_logout_url( $login_pro_logout_redirect_page ); ?>" title="<?php _e('Logout','flp');?>"><?php _e('Logout','flp');?></a></li>
			</ul>
			<?php 
		}
	}

	public function register_login_scripts(){
	?>
<script language="javascript" type="text/javascript">
if (typeof(jQuery) == 'undefined') {
	document.write('<scr' + 'ipt type="text/javascript" src="//code.jquery.com/jquery-1.11.0.min.js"></scr' + 'ipt>');
}
function LinkedInLogin(){
	jQuery.ajax({
	type: "POST",
	data: { option: "initiate_linkedin" }
	})
	.done(function( data ) {
		
		if(data != 0){
			window.open(data, "LinkedInLogin", "width=800,height=200");
		} else {
			alert('Error in token request. Please try again.');
		}
	});
	return true;
}
function TwitterLogin(){
	jQuery.ajax({
	type: "POST",
	data: { option: "generate_token" }
	})
	.done(function( data ) {
		if(data != 0){
			window.open(data, "TwitterLogin", "width=800,height=200");
		} else {
			alert('Error in token request. Please try again.');
		}
	});
	return true;
}
function GoogleLogin(){
	jQuery.ajax({
	type: "POST",
	data: { option: "generate_token_google" }
	})

	.done(function( data ) {
		if(data != 0){
			window.open(data, "GoogleLogin", "width=800,height=600");
		} else {
			alert('Error in token request. Please try again.');
		}
	});
	return true;
}
window.fbAsyncInit = function() {
	FB.init({
	appId      : "<?php echo $this->appId?>", // replace your app id here
	status     : true, 
	cookie     : true, 
	xfbml      : true  
	});
};
(function(d){
	var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];
	if (d.getElementById(id)) {return;}
	js = d.createElement('script'); js.id = id; js.async = true;
	js.src = "//connect.facebook.net/en_US/all.js";
	ref.parentNode.insertBefore(js, ref);
}(document));
function FBLogin(){
	FB.login(function(response){
		if(response.authResponse){
			window.location.href = "<?php echo site_url();?>?option=fblogin";
		}
	}, {scope: 'email,user_likes'});
}
function closeMessage(){
	jQuery('.error_wid_login, .success_wid_login').hide();
}
</script>
	<?php
	}
	
	public function message_close_button(){
		$cb = '<a href="javascript:void(0);" onclick="closeMessage();" class="close_button_afo">x</a>';
		return $cb;
	}
	
	public function custom_styles_afo(){
		echo '<style>';
			echo stripslashes(get_option('custom_style_afo'));
		echo '</style>';
	}

	public function error_message(){
		if($_SESSION['msg']){
			echo '<div class="'.$_SESSION['msg_class'].'">'.$_SESSION['msg'].$this->message_close_button().'</div>';
			unset($_SESSION['msg']);
			unset($_SESSION['msg_class']);
		}
	}
	
	public function register_plugin_styles() {
		wp_enqueue_style( 'style_login_widget', plugins_url( 'fb-login-widget-pro/style_login_widget.css' ) );
	}

} 

add_action( 'widgets_init', create_function( '', 'register_widget( "fb_login_wid" );' ) );