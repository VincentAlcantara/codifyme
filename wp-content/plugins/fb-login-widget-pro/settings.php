<?php
class afo_fb_login {

	private $default_style = '
	.login_wid{
		list-style-type:none;
		border: 1px dashed #999999;
		width:95%;
		float:left;
		padding:2%;
	}
	.login_wid li{
		width:45%;
		float:left;
		margin:2px;
	}
	.afo_social_login{
		padding:5px 0px 0px 0px;
		clear:both;
		width:100% !important;
	}';
	
	function __construct() {
		add_action( 'admin_menu', array( $this, 'facebook_login_widget_afo_menu' ) );
		add_action( 'admin_init',  array( $this, 'facebook_login_widget_afo_save_settings' ) );
		add_action( 'plugins_loaded',  array( $this, 'facebook_login_widget_afo_text_domain' ) );
	}
	
	function facebook_login_widget_afo_text_domain(){
		load_plugin_textdomain('flp', FALSE, basename( dirname( __FILE__ ) ) .'/languages');
	}
	
	function facebook_login_widget_afo_menu () {
		add_options_page( 'FB Login Widget (PRO)', 'FB Login Widget (PRO)', 10, 'fb_login_widget_afo', array( $this, 'fb_login_widget_afo_options' ));
	}
	
	function facebook_login_widget_afo_save_settings(){
		if($_POST['option'] == "login_widget_afo_save_settings"){
			update_option( 'enable_facebook_login', sanitize_text_field($_POST['enable_facebook_login']) );
			update_option( 'afo_fb_app_id', sanitize_text_field($_POST['afo_fb_app_id']) );
			update_option( 'afo_fb_app_secret', sanitize_text_field($_POST['afo_fb_app_secret']) );
			
			update_option( 'enable_google_login', sanitize_text_field($_POST['enable_google_login']) );
			update_option( 'afo_google_client_id', sanitize_text_field($_POST['afo_google_client_id']) );
			update_option( 'afo_google_client_secret', sanitize_text_field($_POST['afo_google_client_secret']) );
			update_option( 'afo_google_developer_key', sanitize_text_field($_POST['afo_google_developer_key']) );

			update_option( 'enable_twitter_login', sanitize_text_field($_POST['enable_twitter_login']) );
			update_option( 'afo_twitter_consumer_key', sanitize_text_field($_POST['afo_twitter_consumer_key']) );
			update_option( 'afo_twitter_consumer_secret', sanitize_text_field($_POST['afo_twitter_consumer_secret']) );
			
			update_option( 'enable_linkedin_login', sanitize_text_field($_POST['enable_linkedin_login']) );
			update_option( 'afo_linkedin_app_key', sanitize_text_field($_POST['afo_linkedin_app_key']) );
			update_option( 'afo_linkedin_app_secret', sanitize_text_field($_POST['afo_linkedin_app_secret']) );
			
			if($_POST['lead_default_style'] == "Yes"){
				update_option( 'custom_style_afo', sanitize_text_field($this->default_style) );
			} else {
				update_option( 'custom_style_afo', sanitize_text_field($_POST['custom_style_afo']) );
			}
			
			update_option( 'login_pro_redirect_page', sanitize_text_field($_POST['login_pro_redirect_page']) );
			update_option( 'login_pro_logout_redirect_page', sanitize_text_field($_POST['login_pro_logout_redirect_page']) );
			update_option( 'login_pro_link_in_username', sanitize_text_field($_POST['login_pro_link_in_username']) );
			update_option( 'login_afo_forgot_pass_link',  sanitize_text_field($_POST['login_afo_forgot_pass_link']) );
			update_option( 'login_afo_register_link',  sanitize_text_field($_POST['login_afo_register_link']) );
			
			if($_POST['add_remember_me'] == "Yes"){
				update_option( 'add_remember_me', "Yes" );
			} else {
				update_option( 'add_remember_me', "No" );
			}
			
			update_option( 'forgot_password_link_mail_subject', sanitize_text_field($_POST['forgot_password_link_mail_subject']) );
			update_option( 'forgot_password_link_mail_body', esc_html($_POST['forgot_password_link_mail_body']) );
			update_option( 'new_password_mail_subject',sanitize_text_field($_POST['new_password_mail_subject']) );
			update_option( 'new_password_mail_body', esc_html($_POST['new_password_mail_body']) );
			
		}
	}

	
	function fb_comment_plugin_addon_options(){
	global $wpdb;
	$fb_comment_addon = new afo_fb_comment_settings;
	$fb_comments_color_scheme = get_option('fb_comments_color_scheme');
	$fb_comments_width = get_option('fb_comments_width');
	$fb_comments_no = get_option('fb_comments_no');
	?>
	<form name="f" method="post" action="">
	<input type="hidden" name="option" value="save_afo_fb_comment_settings" />
	<table width="100%" border="0" style="background-color:#FFFFFF; margin-top:20px; width:98%; padding:5px; border:1px solid #999999; ">
	  <tr>
		<td colspan="2"><h1>Social Comments Settings</h1></td>
	  </tr>
	  <?php do_action('fb_comments_settings_top');?>
	   <tr>
		<td><h3>Facebook Comments</h3></td>
		<td></td>
	  </tr>
	   <tr>
		<td><strong>Language</strong></td>
		<td><select name="fb_comments_language">
			<option value=""> -- </option>
			<?php echo $fb_comment_addon->language_selected($fb_comments_language);?>
		</select>
		</td>
	  </tr>
	 <tr>
		<td><strong>Color Scheme</strong></td>
		<td><select name="fb_comments_color_scheme">
			<?php echo $fb_comment_addon->get_color_scheme_selected($fb_comments_color_scheme);?>
		</select>
		</td>
	  </tr>
	   <tr>
		<td><strong>Width</strong></td>
		<td><input type="text" name="fb_comments_width" value="<?php echo $fb_comments_width;?>"/> In Percent (%)</td>
	  </tr>
	   <tr>
		<td><strong>No of Comments</strong></td>
		<td><input type="text" name="fb_comments_no" value="<?php echo $fb_comments_no;?>"/> Default is 10</td>
	  </tr>
	  <?php do_action('fb_comments_settings_bottom');?>
	  <tr>
		<td>&nbsp;</td>
		<td><input type="submit" name="submit" value="Save" class="button button-primary button-large" /></td>
	  </tr>
	  <tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	  </tr>
	  <tr>
		<td colspan="2">Use <span style="color:#000066;">[social_comments]</span> shortcode to display Facebook / Disqus Comments in post or page.<br />
		 Example: <span style="color:#000066;">[social_comments title="Comments"]</span>
		 <br /> <br />
		 Or else<br /> <br />
		 You can use this function <span style="color:#000066;">social_comments()</span> in your template to display the Facebook Comments. <br />
		 Example: <span style="color:#000066;">&lt;?php social_comments("Comments");?&gt;</span>
		 </td>
	  </tr>
	</table>
	</form>
	<?php 
	}
	
	function restrict_afo_admin_options(){
		global $wpdb;
		$restrict_addon = new afo_restrict_settings;
		$saved_types = get_option('saved_post_types_for_restrict');
		$saved_display_types = get_option('saved_displayes_for_restrict');
		$restrict_message_afo = get_option('restrict_message_afo');
		?>
		<form name="f" method="post" action="">
		<input type="hidden" name="option" value="save_afo_restrict_settings" />
		<table width="100%" border="0">
		  <tr>
			<td><h1>Settings</h1></td>
		  </tr>
		  <tr>
			<td><h3>Post Types Where You Want The Restrict Functionality</h3></td>
		  </tr>
		  <tr>
			<td><?php $restrict_addon->post_types_selected($saved_types); ?></td>
		  </tr>
		   <tr>
			<td><h3>Restrict Contents For</h3></td>
		  </tr>
		   <tr>
			<td><?php $restrict_addon->restriction_for($saved_display_types); ?></td>
		  </tr>
		  <tr>
			<td><h3>Restrict Message</h3></td>
		  </tr>
		  <tr>
			<td><input type="text" name="restrict_message_afo" value="<?php echo $restrict_message_afo;?>" style="width:50%;"/></td>
		  </tr>
		  <tr>
			<td><?php $restrict_addon->restrict_content_help();?></td>
		  </tr>
		  <tr>
			<td><input type="submit" name="submit" value="Save" class="button button-primary button-large" /></td>
		  </tr>
		</table>
		</form>
		<?php 
	}

	function  fb_login_widget_afo_options () {

		global $wpdb;
		$enable_facebook_login = get_option('enable_facebook_login');
		$afo_fb_app_id = get_option('afo_fb_app_id');
		$afo_fb_app_secret = get_option('afo_fb_app_secret');

		$enable_google_login = get_option('enable_google_login');
		$afo_google_client_id = get_option('afo_google_client_id');
		$afo_google_client_secret = get_option('afo_google_client_secret');
		$afo_google_developer_key = get_option('afo_google_developer_key');

		$enable_twitter_login = get_option('enable_twitter_login');
		$afo_twitter_consumer_key = get_option('afo_twitter_consumer_key');
		$afo_twitter_consumer_secret = get_option('afo_twitter_consumer_secret');
		
		$enable_linkedin_login = get_option('enable_linkedin_login');
		$afo_linkedin_app_key = get_option('afo_linkedin_app_key');
		$afo_linkedin_app_secret = get_option('afo_linkedin_app_secret');
		
		$custom_style_afo = stripslashes(get_option('custom_style_afo'));
		
		$login_pro_redirect_page = get_option('login_pro_redirect_page');
		$login_pro_logout_redirect_page = get_option('login_pro_logout_redirect_page');
		$login_pro_link_in_username = get_option('login_pro_link_in_username');
		$login_afo_forgot_pass_link = get_option('login_afo_forgot_pass_link');
		$login_afo_register_link = get_option('login_afo_register_link');
		$add_remember_me = get_option('add_remember_me');
		
		$forgot_password_link_mail_subject = get_option('forgot_password_link_mail_subject');
		$forgot_password_link_mail_body = get_option('forgot_password_link_mail_body');
		$new_password_mail_subject = get_option('new_password_mail_subject');
		$new_password_mail_body = get_option('new_password_mail_body');
		?>
		<form name="f" method="post" action="">
		<input type="hidden" name="option" value="login_widget_afo_save_settings" />
		<table width="100%" border="0" style="width:98%; background-color:#FFFFFF; border:1px solid #999999; padding: 5px; margin-top:20px;">
		 
		 <tr>
			<td colspan="2">
			<div style="border:1px solid #AEAE00; width:95%; background-color:#FFFFBB; margin:5px; padding:10px;">
			<p>Use this <strong>[fb_login_pro]</strong> shortcode in your post or pages if you don't want to use this plugin as widget.</p>
<p>Use this <strong>[forgot_password]</strong> shortcode to include forgot password form in your post or page.</p>
			</div></td>
		  </tr>
		 <!-- facebook settings -->
		  <tr>
			<td width="45%"><h1>Facebook Settings</h1></td>
			<td width="55%">&nbsp;</td>
		  </tr>
		  <tr>
			<td><strong>Enable:</strong></td>
			<td><input type="checkbox" name="enable_facebook_login" value="Yes" <?php echo $enable_facebook_login=="Yes"?'checked="checked"':'';?> /></td>
		  </tr>
		  <tr>
			<td><strong>App ID:</strong></td>

			<td><input type="text" name="afo_fb_app_id" value="<?php echo $afo_fb_app_id;?>" /></td>
		  </tr>
		  <tr>
			<td><strong>App Secret:</strong></td>
			 <td><input type="text" name="afo_fb_app_secret" value="<?php echo $afo_fb_app_secret;?>" /></td>
		  </tr>
		  <tr>
			<td colspan="2" style="cursor:pointer; color:#0000CC; font-size:14px;" onclick="jQuery('#facebook_how_to').toggle();">How to get facebook settings</td>
		  </tr>
		  <tr id="facebook_how_to" style="display:none;">
			<td colspan="2" style="border:1px dashed #CCCCCC; padding:5px;">
				<p>1. To start with, navigate your browser to the <a href="https://developers.facebook.com/apps" target="_blank">Facebook Developers</a> page. You'll be asked to login to your Facebook account.</p>
				<p>Once logged in, you'll see a screen similar to this:</p>
				<p><img src="<?php echo plugins_url( 'images/app-id-screen-one.png' , __FILE__ );?>" alt="app-id-screen-one" width="80%" /></p>
				<p>2. To begin, click "Create New App" under "Apps" in the menu bar.</p>
				<p>After you click "Create New App", you'll be taken to a screen that looks like this:</p>
				<p><img src="<?php echo plugins_url( 'images/app-id-screen-two.png' , __FILE__ );?>" alt="app-id-screen-two" width="80%" /></p>
				<p>You will be prompted to enter the name of your app - whatever you choose will be fine, so just pick something relevant to the website or application it will be used for. For the category of the App, again just pick something relevant ("Apps for Pages" is a good choice).
You can leave the Namespace field blank (its not needed for our purposes). And do not change the status of the "Is this a test version.." field.</p>
				</p>3. After you complete the form to register your application, you'll be taken to a screen that looks like this:</p>
				<p><img src="<?php echo plugins_url( 'images/app-id-screen-four.png' , __FILE__ );?>" alt="app-id-screen-four" width="80%" /></p>
				<p>4. Your App ID will be visible, but your App Secret will be obfuscated. To reveal your App Secret, simply click the "Show" button. Be sure to copy down the App ID and App Secret - you'll need to enter these settings to use the plugin.</p>
			</td>
		  </tr>
		 <!-- facebook settings -->

		  <!-- google settings -->
		  <tr>
			<td width="45%"><h1>Google Settings</h1></td>
			<td width="55%">&nbsp;</td>
		  </tr>
		   <tr>
			<td><strong>Enable:</strong></td>
			<td><input type="checkbox" name="enable_google_login" value="Yes" <?php echo $enable_google_login=="Yes"?'checked="checked"':'';?>/></td>
		  </tr>
		  <tr>
			<td><strong>Google Client ID:</strong></td>
			<td><input type="text" name="afo_google_client_id" value="<?php echo $afo_google_client_id;?>" /></td>
		  </tr>
		  <tr>
			<td><strong>Google Client Secret:</strong></td>
			 <td><input type="text" name="afo_google_client_secret" value="<?php echo $afo_google_client_secret;?>" /></td>
		  </tr>
		  <tr>
			<td><strong>Google Developer Key:</strong></td>
			 <td><input type="text" name="afo_google_developer_key" value="<?php echo $afo_google_developer_key;?>" /></td>
		  </tr>
		   <tr>
			<td colspan="2" style="cursor:pointer; color:#0000CC; font-size:14px;" onclick="jQuery('#google_how_to').toggle();">How to get google settings</td>
		  </tr>
		  <tr id="google_how_to" style="display:none;">
			<td colspan="2" style="border:1px dashed #CCCCCC; padding:5px;">
		     <p>1. Sign-in to Google and go to <a href="https://code.google.com/apis/console/" target="_blank">Google API console</a>, If you are looging in for the first time a page will open like this. Click on the Create Project Button. (If you have created projects before then you can create new Project form the Projects menu of left navigation.) A box should pop-up, enter your Project name, click Create.
			</p>
			  <p><center><img src="<?php echo plugins_url( 'images/google-step-1.png' , __FILE__ );?>" alt="google_api_1" width="100%" /></center></p>
			  <p>2. Now a new Product needs to be created for that click on the Consent Screen tab under <strong> APIs & auth</strong> from the left navigation, a new page will open. Enter product name and click Save button.</p>			  
			  <p><center><img src="<?php echo plugins_url( 'images/google-step-2.png' , __FILE__ );?>" alt="google_api_2" width="80%" /></center></p>
			  <p>3. Next we you need to create your Client ID, for that click on the credentials tab, a new page will open like this.</p>
			  <p><center><img src="<?php echo plugins_url( 'images/google-step-3.png' , __FILE__ );?>" alt="google_api_3" width="80%" /></center></p>
			  <p>4. Now Click on the Create new Client ID button, a popup window should open like this. Leave the Javascript Origins field blank and enter your site url in the Redirect URI field. Click on Create Client ID button.</p>
			  <p><center><img src="<?php echo plugins_url( 'images/google-step-4.png' , __FILE__ );?>" alt="google_api_3" width="80%" /></center></p>
			  <p>5. You will be redirected to a page where you will see your Credentials. The page looks similer to this.</p>
			  <p><center><img src="<?php echo plugins_url( 'images/google-step-5.png' , __FILE__ );?>" alt="google_api_3" width="80%" /></center></p>
			  <p>6. Next click on the APIs tab and Enable any one from the listed APIs.</p>
			  <p><center><img src="<?php echo plugins_url( 'images/google-step-9.png' , __FILE__ );?>" alt="google_api_3" width="80%" /></center></p>
			  <p>7. Now you to get a Punlic Key you have to click on the Create New Key button.</p>
			  <br />
			  <p><center><img src="<?php echo plugins_url( 'images/google-step-6.png' , __FILE__ );?>" alt="google_api_3" width="80%" /></center></p>
			  <p>8. A popup should open like this. Click on the Server Key button and a new window will open leave the IP Address field blank and click Create.</p>
			  <p><center><img src="<?php echo plugins_url( 'images/google-step-7.png' , __FILE__ );?>" alt="google_api_3" width="80%" /></center></p>
			  <p>9. Your Public Access Key will be generated. The API KEY is your Developer Key.</p>
			  <p><img src="<?php echo plugins_url( 'images/google-step-8.png' , __FILE__ );?>" alt="google_api_3" width="80%" /></p>
			  </td>
		  </tr>
		   <!-- google settings -->

		  <!-- twitter settings -->
		   <tr>
			<td width="45%"><h1>Twitter Settings</h1></td>
			<td width="55%">&nbsp;</td>
		  </tr>
		  <tr>
			<td><strong>Enable:</strong></td>
			<td><input type="checkbox" name="enable_twitter_login" value="Yes" <?php echo $enable_twitter_login=="Yes"?'checked="checked"':'';?> /></td>
		  </tr>
		  <tr>
			<td><strong>API key:</strong></td>
			<td><input type="text" name="afo_twitter_consumer_key" value="<?php echo $afo_twitter_consumer_key;?>" /></td>
		  </tr>
		  <tr>
			<td><strong>API secret:</strong></td>
			 <td><input type="text" name="afo_twitter_consumer_secret" value="<?php echo $afo_twitter_consumer_secret;?>" /></td>
		  </tr>
		    <tr>
			<td colspan="2" style="cursor:pointer; color:#0000CC; font-size:14px;" onclick="jQuery('#twitter_how_to').toggle();">How to get twitter settings</td>
		  </tr>
		  <tr id="twitter_how_to" style="display:none;">
			<td colspan="2" style="border:1px dashed #CCCCCC; padding:5px;">
				<p>1. Go to URL - <a href="http://twitter.com/apps" target="_blank">http://twitter.com/apps</a> and fill username and password. Create account if you don't have one.</p>
				<p>2. You will see Create Application page. Press Create Application and you will then see this page.</p>
				<p><img src="<?php echo plugins_url( 'images/twitterappform.png' , __FILE__ );?>" alt="twitterappform" width="80%" /></p>
				<p>
				3. Fill your application name, app description and callback url. The callback url should be your full site url. Write a valid url as callback url. This url is important, use addcallback method to provide the url in the code.You will then see this page. 
				</p>
				<p><img src="<?php echo plugins_url( 'images/twitterdetails.png' , __FILE__ );?>" alt="twitterdetails" width="80%" /></p>
				<p>4. The settings page contains info about your app and website url, callback url. Enter your site address here. Use callback url same as your site address.</p>
				<p><img src="<?php echo plugins_url( 'images/twittersettings.png' , __FILE__ );?>" alt="twittersettings" width="80%" /></p>
				<p>5. The Api Keys page contains all your Application settings. API key, API Secret, Your access token. The API Keys page looks like this.</p>
				<p><img src="<?php echo plugins_url( 'images/twittersapikeys.png' , __FILE__ );?>" alt="twittersettings" width="80%" /></p>
				<p>6. Note down key and secret.</p>
		      </td>
		  </tr>
	   	<!-- twitter settings -->
		
		 <!-- linkedin settings -->
		  <tr>
			<td width="45%"><h1>LinkedIn Settings</h1></td>
			<td width="55%">&nbsp;</td>
		  </tr>
		  <tr>
			<td><strong>Enable:</strong></td>
			<td><input type="checkbox" name="enable_linkedin_login" value="Yes" <?php echo $enable_linkedin_login=="Yes"?'checked="checked"':'';?> /></td>
		  </tr>
		  <tr>
			<td><strong>App Key:</strong></td>
			<td><input type="text" name="afo_linkedin_app_key" value="<?php echo $afo_linkedin_app_key;?>" /></td>
		  </tr>
		  <tr>
			<td><strong>App Secret:</strong></td>
			 <td><input type="text" name="afo_linkedin_app_secret" value="<?php echo $afo_linkedin_app_secret;?>" /></td>
		  </tr>
		  <tr>
			<td colspan="2" style="cursor:pointer; color:#0000CC; font-size:14px;" onclick="jQuery('#linkedin_how_to').toggle();">How to get linkedIn settings</td>
		  </tr>
		  <tr id="linkedin_how_to" style="display:none;">
			<td colspan="2" style="border:1px dashed #CCCCCC; padding:5px;">
				<p>1. To start with, navigate your browser to the <a href="https://www.linkedin.com/secure/developer" target="_blank">Linked Developers</a> page. You'll be asked to login to your LinkedIn account.</p>
				<p>Once logged in, you'll see a screen similar to this:</p>
				<p><img src="<?php echo plugins_url( 'images/ln1.png' , __FILE__ );?>" alt="app-id-screen-one" width="80%" /></p>
				<p>2. To begin, click "Add New Application".</p>
				<p>After you click "Add New Application", you'll be taken to a screen that looks like this:</p>
				<p><img src="<?php echo plugins_url( 'images/ln2.png' , __FILE__ );?>" alt="app-id-screen-two" width="80%" /></p>
				<p>You will be prompted to enter the name of your  Application Name - whatever you choose will be fine, so just pick something relevant to the website or application it will be used for, Description, Website URL, Application Use Etc. Enter your site url in the Website URL field.</p>
				</p>3. After you complete the form to register your application, you'll be taken to a screen that looks like this:</p>
				<p><img src="<?php echo plugins_url( 'images/ln3.png' , __FILE__ );?>" alt="app-id-screen-four" width="80%" /></p>
				<p>4. Your API Key, Secret Key will be visible. Be sure to copy down the API Key and Secret Key - you'll need to enter these settings to use the plugin.</p>
			</td>
		  </tr>
		 <!-- linkedin settings -->
		  
		  <tr>
			<td width="45%"><h1>Styling</h1></td>
			<td width="55%">&nbsp;</td>
		  </tr>
		  <tr>
			<td valign="top"><input type="checkbox" name="lead_default_style" value="Yes" /><strong>Load Default Styles</strong><br />
			Check this and hit the save button to go back to default styling.
			</td>
			<td><textarea name="custom_style_afo" style="width:100%; height:200px;"><?php echo $custom_style_afo;?></textarea></td>
		  </tr>
		  
		   <tr>
			<td width="45%"><h1>Other</h1></td>
			<td width="55%">&nbsp;</td>
		  </tr>
		  
		  <tr>
			<td><strong>Login Redirect Page:</strong></td>
			<td><?php
					$args = array(
					'depth'            => 0,
					'selected'         => $login_pro_redirect_page,
					'echo'             => 1,
					'show_option_none' => '-',
					'id' 			   => 'login_pro_redirect_page',
					'name'             => 'login_pro_redirect_page'
					);
					wp_dropdown_pages( $args ); 
				?></td>
		  </tr>
	  
	 	 <tr>
			<td><strong>Logout Redirect Page:</strong></td>
			 <td><?php
					$args1 = array(
					'depth'            => 0,
					'selected'         => $login_pro_logout_redirect_page,
					'echo'             => 1,
					'show_option_none' => '-',
					'id' 			   => 'login_pro_logout_redirect_page',
					'name'             => 'login_pro_logout_redirect_page'
					);
					wp_dropdown_pages( $args1 ); 
				?></td>
		  </tr>
	   
	 	 <tr>
			<td><strong>Link in Username</strong></td>
			<td><?php
					$args2 = array(
					'depth'            => 0,
					'selected'         => $login_pro_link_in_username,
					'echo'             => 1,
					'show_option_none' => '-',
					'id' 			   => 'login_pro_link_in_username',
					'name'             => 'login_pro_link_in_username'
					);
					wp_dropdown_pages( $args2 ); 
				?></td>
		  </tr>
		  <tr>
			<td valign="top"><input type="checkbox" name="add_remember_me" value="Yes" <?php echo $add_remember_me == 'Yes'?'checked="checked"':'';?> /><strong>Add Remember me</strong></td>
			<td>&nbsp;</td>
		  </tr>
		 <tr>
		<td><strong>Forgot Password Link</strong></td>
		<td>
			<?php
				$args3 = array(
				'depth'            => 0,
				'selected'         => $login_afo_forgot_pass_link,
				'echo'             => 1,
				'show_option_none' => '-',
				'id' 			   => 'login_afo_forgot_pass_link',
				'name'             => 'login_afo_forgot_pass_link'
				);
				wp_dropdown_pages( $args3 ); 
			?>
			<i>Leave blank to not include the link</i>
			</td>
	  </tr>
	 	 <tr>
		<td><strong>Register Link</strong></td>
		<td>
			<?php
				$args4 = array(
				'depth'            => 0,
				'selected'         => $login_afo_register_link,
				'echo'             => 1,
				'show_option_none' => '-',
				'id' 			   => 'login_afo_register_link',
				'name'             => 'login_afo_register_link'
				);
				wp_dropdown_pages( $args4 ); 
			?>
			<i>Leave blank to not include the link</i>
			</td>
	  </tr>
	  	 <tr>
			<td width="45%"><h1>Email Settings</h1></td>
			<td width="55%">&nbsp;</td>
		  </tr>
		  <tr>
		<td><strong>Reset Password Link Mail Subject</strong></td>
		<td><input type="text" name="forgot_password_link_mail_subject" value="<?php echo $forgot_password_link_mail_subject;?>" />
		</td>
	  </tr>
	 	  <tr>
		<td valign="top"><strong>Reset Password Link Mail Body</strong>
		<p>This mail will fire when a user request for a new password.</p>
		</td>
		<td><textarea name="forgot_password_link_mail_body" style="height:200px; width:100%;"><?php echo $forgot_password_link_mail_body;?></textarea>
		<p>Shortcodes: #siteurl#, #username#, #password#</p>
		</td>
	  </tr>
	 	  <tr>
		<td><strong>New Password Mail Subject</strong></td>
		<td><input type="text" name="new_password_mail_subject" value="<?php echo $new_password_mail_subject;?>" /></td>
	  </tr>
		  <tr>
		<td valign="top"><strong>New Password Mail Subject Body</strong>
		<p>This mail will fire when a user clicks on the password reset link provided in the above mail.</p>
		</td>
		<td><textarea name="new_password_mail_body" style="height:200px; width:100%;"><?php echo $new_password_mail_body;?></textarea>
		<p>Shortcodes: #siteurl#, #username#, #resetlink#</p>
		</td>
	  </tr>
		  <tr>
			<td>&nbsp;</td>
			<td><input type="submit" name="submit" value="Save" class="button button-primary button-large" /></td>
		  </tr>
		</table>
		</form>
		<?php 
	}
}