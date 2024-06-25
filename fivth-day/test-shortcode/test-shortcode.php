<?php

/*
* Plugin Name: User ShortCode
* Description: This shortcode displays the users.
* Version: 1.0.0
* Author: saphal
*/



//add_shortcode('show_all_users', 'get_all_users');

function get_all_users(){

    $users =  get_users();

    ob_start();

   foreach($users as $key => $user){
    echo $html =  "<h1>$user->user_login</h1>";
   }    

   $html = ob_get_clean();

   return $html;
}


function display_form($atts, $content, $tag){



    $redirect_to = isset( $atts['redirect_to']) ? $atts['redirect_to'] : '';
    
    ob_start();

    include_once 'form.php';
    
    $html = ob_get_clean();

    return $html;
}   

add_shortcode("my_test_show_create_form", "display_form");