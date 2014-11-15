<?php
/**
 * Template Name: LoginForm Page
 *
 */
?>
<style type="text/css">

        #loginform, .custom_loginform {
                width: 300px;
                margin: 80 auto 0 auto;
                font-family: 'Open Sans';
                font-size: 14px;
                
        }

        .button-primary, input[type=submit] {

                background-color: #37a447;
                border: 1px solid #37a447;
                color: #fff;
                background-image: -webkit-gradient(linear,left top,left bottom,
                        from(#37a447),to(#37a447));
                background-image: -webkit-linear-gradient(top,#37a447,#37a447);
                background-image: -moz-linear-gradient(top,#37a447,#37a447);
                background-image: -ms-linear-gradient(top,#37a447,#37a447);
                background-image: -o-linear-gradient(top,#37a447,#37a447);
                background-image: linear-gradient(top,#37a447,#37a447);
                font-weight: normal;
                text-shadow: none;
                width: 190px;
                height: 40px;
                font-size: 14px;
                padding:10px;
        }

        .button-primary:hover, input[type=submit]:hover {

                background-color: #8BE25F;
                border: 1px solid #8BE25F;
                color: #fff;
                background-image: -webkit-gradient(linear,left top,left bottom,from(#8BE25F),to(#8BE25F));
                background-image: -webkit-linear-gradient(top,#8BE25F,#8BE25F);
                background-image: -moz-linear-gradient(top,#8BE25F,#8BE25F);
                background-image: -ms-linear-gradient(top,#8BE25F,#8BE25F);
                background-image: -o-linear-gradient(top,#8BE25F,#8BE25F);
                background-image: linear-gradient(top,#8BE25F,#8BE25F);
                font-weight: normal;
                text-shadow: none;
        }

        ul, li {
                text-decoration: none;
                list-style-type: none;
                padding:0;
                margin: 10px 0;
        }

        a {
                padding: 5px;

        }

        #register {
                font-weight: bold;
                margin: 20px 0;
        }
        .gfield_label {
                float: left;
                margin-right: 10px;
                display: inline;
        }
        iframe {
                margin: 0 auto;
        
        }
</style>

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
/*
add_action( 'login_form_top', 'custom_login_form_top' );

function custom_login_form_top (){
        return '<p>This works custom login form top</p>';
}

add_action( 'login_form_middle', 'custom_login_form_middle' );

function custom_login_form_middle (){
        return '<p>This works custom login form middle</p>';
}
*/
add_action( 'login_form_bottom', 'custom_login_form_bottom' );

function custom_login_form_bottom (){
        $html = '<a href="#register">New User?</a><a href="/wp-login.php?action=lostpassword">Lost Password?</a><i class="fa fa-pencil-square-o"></i>';
       
	return $html;
}

	wp_login_form( $args );
?>


