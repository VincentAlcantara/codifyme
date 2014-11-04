<?php
class restrict_afo {
 	public $msg;

	function __construct() {
		$this->msg = get_option('restrict_message_afo');
		$this->restrict_as_per_user_settings();
	}
	
	function afo_restrict($content = null){
	
		global $post;
		$is_protected = get_post_meta( $post->ID, '_restrict_afo_key', true );
		if(is_user_logged_in()){
			return $content;
		} else {
			if($is_protected == 'Yes'){
				return $this->msg;
			} else {
				return $content;
			}
		}
	}
	
	function restrict_as_per_user_settings(){
	
		$saved_display_types = get_option('saved_displayes_for_restrict');
		if(is_array($saved_display_types)){
			foreach($saved_display_types as $key => $value){
				add_filter($value, array($this,'afo_restrict'));
			}
		}
	}
	
}

function load_restriction(){
	new restrict_afo;
}
add_action('init','load_restriction');