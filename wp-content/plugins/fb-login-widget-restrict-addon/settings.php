<?php
class afo_restrict_settings{

	function __construct() {
		$this->load_settings();
	}

	function load_settings(){
		add_action('admin_menu', array( $this, 'restrict_afo_plugin_menu' ) );
		add_action( 'admin_init', array( $this, 'restrict_afo_post_data' ) );
		register_activation_hook(__FILE__, array( $this, 'plug_install_restrict_afo' ) );
		register_deactivation_hook(__FILE__, array( $this, 'plug_unins_restrict_afo' ) );
	}

	function restrict_afo_post_data(){
	
		if($_POST['option'] == "save_afo_restrict_settings"){
			update_option( 'saved_post_types_for_restrict', sanitize_text_field($_POST['restrict_post_types']) );
			update_option( 'saved_displayes_for_restrict', sanitize_text_field($_POST['restrict_displayes']) );
			update_option( 'restrict_message_afo', sanitize_text_field($_POST['restrict_message_afo']) );
		}
	}
	
	function post_types_selected($saved_types=''){
		$args = array(
		'public'   => true,
		);
		$post_types = get_post_types( $args, 'names' ); 
		$post_types = array_diff($post_types, array('attachment'));
		foreach ( $post_types as $post_type ) {
			if(is_array($saved_types) and in_array($post_type,$saved_types)){
				echo '<p><input type="checkbox" name="restrict_post_types[]" value="'.$post_type.'" checked="checked" />&nbsp;'.ucfirst($post_type).'</p>';
			} else{
				echo '<p><input type="checkbox" name="restrict_post_types[]" value="'.$post_type.'" />&nbsp;'.ucfirst($post_type).'</p>';
			}
		}
	}

	function restriction_for($saved_types=''){
		$display_functions = array( 'All (Content & Excerpt)' => 'the_content', 'Excerpt' => 'the_excerpt' ); 
		foreach ( $display_functions as $key => $display ) {
			if(is_array($saved_types) and in_array($display,$saved_types)){
				echo '<p><input type="checkbox" name="restrict_displayes[]" value="'.$display.'" checked="checked"/>&nbsp;'.$key.'</p>';
			} else{
				echo '<p><input type="checkbox" name="restrict_displayes[]" value="'.$display.'"/>&nbsp;'.$key.'</p>';
			}
		}
	}
	
	
	function restrict_content_help(){?>
		<table width="100%" border="0">
		<tr>
			<td><h3 style="color:#FF0000;">Note</h3></td>
		  </tr>
		  <tr>
			<td>The restriction can be applied to <strong>the_content()</strong> and <strong>the_excerpt()</strong> functions, where ever these are used in your theme template. The restriction will not be applied to <strong>get_the_content()</strong> or <strong>get_the_excerpt()</strong> functions.<br /><br /></td>
		  </tr>
		  <tr>
			<td><img src="<?php echo plugins_url( 'images/r1.png' , __FILE__ );?>" width="80%" style="border:1px dashed #333333;" /></td>
		  </tr>
		  <tr>
			<td>Select this checkbox in your Post edit page to restrict that page content.</td>
		  </tr>
		</table>
	<?php }
	
	function  restrict_afo_options () {
		global $wpdb;
		
		if ( !is_plugin_active( 'fb-login-widget-pro/login.php' ) ) {
		  echo '<div style="clear:both;"><br>Please install Facebook Login Widget (PRO)</div>';
		} else {
			$log = new afo_fb_login;
			$log->restrict_afo_admin_options();
		}
	}
	
	function restrict_afo_plugin_menu () {
		add_options_page( 'Restrict Content', 'Restrict Content', 10, 'restrict_content',  array( $this,'restrict_afo_options' ) );
	}
	
	
	
	function plug_install_restrict_afo(){
		update_option( 'restrict_message_afo', 'Please login to view this page.' );
	}
	
	function plug_unins_restrict_afo(){}
	
}
new afo_restrict_settings;