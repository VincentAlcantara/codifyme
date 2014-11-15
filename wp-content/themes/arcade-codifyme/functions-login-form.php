<?php


function custom_login_form_bottom (){
	echo "<div>This works custom login form bottom</div>";
}
add_filter( 'login_form_bottom', 'custom_login_form_bottom' );

function custom_login_form_top (){
	echo "This works custom login form top";
}
add_filter( 'login_form_top', 'custom_login_form_top' );

function custom_login_form_middle (){
	echo "<div>This works custom login form middle</div>";
}
add_filter( 'login_form_middle', 'custom_login_form_middle' );



?>

<?php

add_action('login_form','login_extra_note');

function login_extra_note() {

    //Adding the text
    
    ?>
    <p>You can type a little note to those logging in here.</p>

    <?php
}


<?php

add_filter( 'login_form_bottom', 'custom_login_form_bottom' );

function custom_login_form_bottom () {

    //Adding the text
    
    ?>
    <p>You can type a little note to those logging in here.</p>

    <?php
}


