<?php
function fb_login_validate(){
	
	// default 
	if($_POST['option'] == "afo_user_login"){
		if(!session_id()){
			session_start();
		}
		global $post;
		if($_POST['user_username'] != "" and $_POST['user_password'] != ""){
			$creds = array();
			$creds['user_login'] = $_POST['user_username'];
			$creds['user_password'] = $_POST['user_password'];
			if($_POST['user_rem'] == "Yes"){
				$creds['remember'] = true;
			} else {
				$creds['remember'] = false;
			}
			$user = wp_signon( $creds, true );
			if($user->ID == ""){
				$_SESSION['msg_class'] = 'error_wid_login';
				$_SESSION['msg'] = __('Error in login!','flp');
			} else{
				wp_set_auth_cookie($user->ID);
				$login_pro_redirect_page = (get_option('login_pro_redirect_page') == ''?site_url():get_permalink(get_option('login_pro_redirect_page')));
				wp_redirect( $login_pro_redirect_page );
				exit;
			}
		} else {
			$_SESSION['msg_class'] = 'error_wid_login';
			$_SESSION['msg'] = __('Username or password is empty!','flp');
		}
		
	}
	// default 
	
	// facebook 
	if($_REQUEST['option'] == "fblogin"){
		global $wpdb;
		$appid 		= get_option('afo_fb_app_id');
		$appsecret  = get_option('afo_fb_app_secret');
		$facebook   = new Facebook(array(
			'appId' => $appid,
			'secret' => $appsecret,
			'cookie' => TRUE,
		));
		$fbuser = $facebook->getUser();
		if ($fbuser) {
			try {
				$user_profile = $facebook->api('/me');
			}
			catch (Exception $e) {
				echo $e->getMessage();
				exit();
			}
			$user_fbid	= $fbuser;
			$user_email = $user_profile["email"];
			$user_fnmae = $user_profile["first_name"];
  
		  if( email_exists( $user_email )) { // user is a member 
			  $user = get_user_by('email', $user_email );
			  $user_id = $user->ID;
			  wp_set_auth_cookie( $user_id, true );
		   } else { // this user is a guest
			  $random_password = wp_generate_password( 10, false );
			  $user_id = wp_create_user( $user_email, $random_password, $user_email );
			  wp_set_auth_cookie( $user_id, true );
		   }
		   
		    $login_pro_redirect_page = (get_option('login_pro_redirect_page') == ''?site_url():get_permalink(get_option('login_pro_redirect_page')));
   			wp_redirect( $login_pro_redirect_page );
			exit;
		}		
	}
	// facebook 
	
	// google 
	if (isset($_GET['code'])) {
		if(!session_id()){
			session_start();
		}
			
		$google_client_id 		= get_option('afo_google_client_id');
		$google_client_secret 	= get_option('afo_google_client_secret');
		$google_redirect_url 	= site_url('/');
		$google_developer_key 	= get_option('afo_google_developer_key');
	
		$gClient = new Google_Client();
		
		$gClient->setApplicationName('Google Login');
		$gClient->setClientId($google_client_id);
		$gClient->setClientSecret($google_client_secret);
		$gClient->setRedirectUri($google_redirect_url);
		$gClient->setDeveloperKey($google_developer_key);
		
		$google_oauthV2 = new Google_Oauth2Service($gClient);
		$gClient->authenticate($_GET['code']);
		
		$_SESSION['token'] = $gClient->getAccessToken();
		
		if ($gClient->getAccessToken()) {
		
			
			  //For logged in user, get details from google using access token
			  $user 				= $google_oauthV2->userinfo->get();
			  $user_id 				= $user['id'];
			  $user_name 			= filter_var($user['name'], FILTER_SANITIZE_SPECIAL_CHARS);
			  $user_email 			= filter_var($user['email'], FILTER_SANITIZE_EMAIL);
			  $_SESSION['token'] 	= $gClient->getAccessToken();
			  
			
			 if( email_exists( $user_email )) { // user is a member 
				  $user = get_user_by('email', $user_email );
				  $user_id = $user->ID;
				  wp_set_auth_cookie( $user_id, true );
			   } else { // this user is a guest
				  $random_password = wp_generate_password( 10, false );
				  $user_id = wp_create_user( $user_email, $random_password, $user_email );
				  wp_set_auth_cookie( $user_id, true );
			   }
			   
			   ?>
				<script type="text/javascript">
				function closeWindow(){
					window.close();
					window.opener.location.href = '<?php echo $login_pro_redirect_page = (get_option('login_pro_redirect_page') == ''?site_url():get_permalink(get_option('login_pro_redirect_page')));?>';
				}
				closeWindow();
				</script>
			   <?php
			   exit;
		}
		
		wp_redirect( $google_redirect_url );
		exit;
	}

	if($_REQUEST['option'] == "generate_token_google"){
		
		$google_client_id 		= get_option('afo_google_client_id');
		$google_client_secret 	= get_option('afo_google_client_secret');
		$google_redirect_url 	= site_url('/');
		$google_developer_key 	= get_option('afo_google_developer_key');
		
		$gClient = new Google_Client();
		$gClient->setApplicationName('Google Login');
		$gClient->setClientId($google_client_id);
		$gClient->setClientSecret($google_client_secret);
		$gClient->setRedirectUri($google_redirect_url);
		$gClient->setDeveloperKey($google_developer_key);
		
		$google_oauthV2 = new Google_Oauth2Service($gClient);
		
		$authUrl = $gClient->createAuthUrl();
		echo $authUrl;
		exit;

	}
	// google 
	
	// twitter 
	if($_REQUEST['option'] == "generate_token"){
		if(!session_id()){
			session_start();
		}
		
		$CONSUMER_KEY = get_option('afo_twitter_consumer_key');
		$CONSUMER_SECRET = get_option('afo_twitter_consumer_secret');
		$OAUTH_CALLBACK = site_url()."?option=twitterlogin";
	
		$connection = new TwitterOAuth($CONSUMER_KEY, $CONSUMER_SECRET);
		$request_token = $connection->getRequestToken($OAUTH_CALLBACK); //get Request Token
	
		if(	$request_token){
			$token = $request_token['oauth_token'];
			
			$_SESSION['afo_request_token'] = $token ;
			$_SESSION['afo_request_token_secret'] = $request_token['oauth_token_secret'];
			
			switch ($connection->http_code) {
				case 200:
					$url = $connection->getAuthorizeURL($token);
					echo $url;
					break;
				default:
					echo 0;
					break;
			}
		} else {
			echo 0;
		}
		exit;
	}
	
	if($_REQUEST['option'] == "afo_twitter_login_enter_email"){
		if(!session_id()){
			session_start();
		}
		global $wpdb;
		
          $user_email = $_REQUEST['user_email'];
		  $user_name = $_SESSION['afo_twitter_id'];
		  
		  if($user_email == ""){
		  	$msg = __("Please enter your email address!","flp");
		  }
		  if( email_exists( $user_email )) {
			 $msg = __("Email address already exist!","flp");
		  }
		  if( username_exists( $user_name )) {
			 $msg = __("Username already exist!","flp");
		  }
		   
		   if($msg == ""){
			  $random_password = wp_generate_password( 10, false );
			  $user_id = wp_create_user( $user_name, $random_password, $user_email );
			  wp_set_auth_cookie( $user_id, true );
			  
			  $login_pro_redirect_page = (get_option('login_pro_redirect_page') == ''?site_url():get_permalink(get_option('login_pro_redirect_page')));
			  unset($_SESSION['afo_twitter_id']);
			  wp_redirect( $login_pro_redirect_page );
			  exit;
				
		   }  else {
		   	  $_SESSION['msg_class'] = 'error_wid_login';
			  $_SESSION['msg'] = $msg;
		   }
			
	}		
	
	if($_REQUEST['option'] == "twitterlogin"){
	if(!session_id()){
		session_start();
	}
	global $wpdb;
	$CONSUMER_KEY = get_option('afo_twitter_consumer_key');
	$CONSUMER_SECRET = get_option('afo_twitter_consumer_secret');
	
	$connection = new TwitterOAuth($CONSUMER_KEY, $CONSUMER_SECRET, $_SESSION['afo_request_token'], $_SESSION['afo_request_token_secret']);
	$access_token = $connection->getAccessToken($_REQUEST['oauth_verifier']);
	
		if($access_token){
				$connection = new TwitterOAuth($CONSUMER_KEY, $CONSUMER_SECRET, $access_token['oauth_token'], $access_token['oauth_token_secret']);
				$params = array();
				$params['include_entities']='false';
				$content = $connection->get('account/verify_credentials',$params);
				
				if($content && isset($content->screen_name) && isset($content->name)){
					
					$_SESSION['afo_twitter_id'] = $content->screen_name;
					
					// now check if use is already exist.
					 $user = get_user_by('login', $_SESSION['afo_twitter_id'] );
					 $user_id = $user->ID;
					 if($user_id){
					 	unset($_SESSION['afo_twitter_id']);
						wp_set_auth_cookie( $user_id, true );
					 } 
					?>
					<script>
					function closeWindow(){
						window.close();
						<?php if($user_id){ ?>
						window.opener.location.href = '<?php echo $login_pro_redirect_page = (get_option('login_pro_redirect_page') == ''?site_url():get_permalink(get_option('login_pro_redirect_page')));?>';
						<?php } else { ?>
						window.opener.location.reload();
						<?php } ?>
					}
					closeWindow();
					</script>
					<?php
					exit;
				}else{
					echo "<h4> Login Error 1</h4>";
					exit;
				}
		}else{
			echo "<h4> Login Error 2</h4>";
			exit;
		}
		
	}
	// twitter 
	
	// linkedin
	
	if($_REQUEST['lType'] == 'initiate'){
	if(!session_id()){
		session_start();
	}
	
	if($_REQUEST['oauth_problem'] == "user_refused"){
	?>
		<script>
			function closeWindow(){
				window.close();
			}
			closeWindow();
		</script>
	<?php
	exit;
	} 
	
	define('PORT_HTTP', '80');
	define('PORT_HTTP_SSL', '443');

	  $API_CONFIG = array(
		'appKey'       => get_option('afo_linkedin_app_key'),
		  'appSecret'    => get_option('afo_linkedin_app_secret'),
		  'callbackUrl'  => NULL 
	  );
	
	   /**
       * Handle user initiated LinkedIn connection, create the LinkedIn object.
       */
        
      // check for the correct http protocol (i.e. is this script being served via http or https)
      if($_SERVER['HTTPS'] == 'on') {
        $protocol = 'https';
      } else {
        $protocol = 'http';
      }
      
      // set the callback url
      $API_CONFIG['callbackUrl'] = $protocol . '://' . $_SERVER['SERVER_NAME'] . ((($_SERVER['SERVER_PORT'] != PORT_HTTP) || ($_SERVER['SERVER_PORT'] != PORT_HTTP_SSL)) ? ':' . $_SERVER['SERVER_PORT'] : '') . $_SERVER['PHP_SELF'] . '?' . LINKEDIN::_GET_TYPE . '=initiate&' . LINKEDIN::_GET_RESPONSE . '=1';
      $OBJ_linkedin = new LinkedIn($API_CONFIG);
	  
	  
	 $response = $OBJ_linkedin->retrieveTokenAccess($_SESSION['oauth']['linkedin']['request']['oauth_token'], $_SESSION['oauth']['linkedin']['request']['oauth_token_secret'], $_GET['oauth_verifier']);
	
	if($response['success'] === TRUE) {
	  // the request went through without an error, gather user's 'access' tokens
	  $_SESSION['oauth']['linkedin']['access'] = $response['linkedin'];
	  
	  // set the user as authorized for future quick reference
	  $_SESSION['oauth']['linkedin']['authorized'] = TRUE;
		
	} 
		  
	 $_SESSION['oauth']['linkedin']['authorized'] = (isset($_SESSION['oauth']['linkedin']['authorized'])) ? $_SESSION['oauth']['linkedin']['authorized'] : FALSE;
	
		if($_SESSION['oauth']['linkedin']['authorized'] === TRUE) {
		
		 $OBJ_linkedin = new LinkedIn($API_CONFIG);
         $OBJ_linkedin->setTokenAccess($_SESSION['oauth']['linkedin']['access']);
         $OBJ_linkedin->setResponseFormat(LINKEDIN::_RESPONSE_XML);
			
			
		// user is already connected
		$response = $OBJ_linkedin->profile('~:(id,first-name,last-name,picture-url,email-address)');
		if($response['success'] === TRUE) {
		  $response['linkedin'] = new SimpleXMLElement($response['linkedin']);
			
		  $user_email = $response['linkedin']->{'email-address'};
		
			if( email_exists( $user_email )) { // user is a member 
			  $user = get_user_by('email', $user_email );
			  $user_id = $user->ID;
			  wp_set_auth_cookie( $user_id, true );
		   } else { // this user is a guest
			  $random_password = wp_generate_password( 10, false );
			  $user_id = wp_create_user( $user_email, $random_password, $user_email );
			  wp_set_auth_cookie( $user_id, true );
		   }
		   ?>
			<script>
				function closeWindow(){
					window.close();
					window.opener.location.href = '<?php echo $login_pro_redirect_page = (get_option('login_pro_redirect_page') == ''?site_url():get_permalink(get_option('login_pro_redirect_page')));?>';
				}
				closeWindow();
			</script>
		   <?php
		   exit;
		} else {
		  // request failed
		   wp_die('Error retrieving profile information!');
		} 
	  }
	  exit;
	}	  
	
	
	if($_REQUEST['option'] == "initiate_linkedin"){
		if(!session_id()){
			session_start();
		}
		
		  define('PORT_HTTP', '80');
		  define('PORT_HTTP_SSL', '443');
  
		 $API_CONFIG = array(
			'appKey'       => get_option('afo_linkedin_app_key'),
			  'appSecret'    => get_option('afo_linkedin_app_secret'),
			  'callbackUrl'  => NULL 
		  );
		
	  if($_SERVER['HTTPS'] == 'on') {
        $protocol = 'https';
      } else {
        $protocol = 'http';
      }
      
      // set the callback url
      $API_CONFIG['callbackUrl'] = $protocol . '://' . $_SERVER['SERVER_NAME'] . ((($_SERVER['SERVER_PORT'] != PORT_HTTP) || ($_SERVER['SERVER_PORT'] != PORT_HTTP_SSL)) ? ':' . $_SERVER['SERVER_PORT'] : '') . $_SERVER['PHP_SELF'] . '?' . LINKEDIN::_GET_TYPE . '=initiate&' . LINKEDIN::_GET_RESPONSE . '=1';
      $OBJ_linkedin = new LinkedIn($API_CONFIG);
      
      // check for response from LinkedIn
      $_GET[LINKEDIN::_GET_RESPONSE] = (isset($_GET[LINKEDIN::_GET_RESPONSE])) ? $_GET[LINKEDIN::_GET_RESPONSE] : '';
      if(!$_GET[LINKEDIN::_GET_RESPONSE]) {
        // LinkedIn hasn't sent us a response, the user is initiating the connection
        
        // send a request for a LinkedIn access token
        $response = $OBJ_linkedin->retrieveTokenRequest();
        if($response['success'] === TRUE) {
          // store the request token
          $_SESSION['oauth']['linkedin']['request'] = $response['linkedin'];
          
          // redirect the user to the LinkedIn authentication/authorisation page to initiate validation.
          echo LINKEDIN::_URL_AUTH . $response['linkedin']['oauth_token'];
        } else {
          // bad token request
		  echo 0;
        }
      }
	exit;	
	}
}

function afo_logout_hook() {
	if(!session_id()){
		session_start();
	}
	unset($_SESSION['afo_request_token']);
	unset($_SESSION['afo_twitter_id']);
	unset($_SESSION['afo_request_token_secret']);
	unset($_SESSION['token']);
}

add_action( 'init', 'fb_login_validate' );
add_action('wp_logout', 'afo_logout_hook');