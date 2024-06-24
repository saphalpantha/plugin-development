<?php

/*
* Plugin Name: User Registration
* Description: This plugin allow you to register new User
* Version: 1.0.0
* Author: saphal

*/



function render_form(){
    return include_once 'form.php';
}

function create_menus(){
    add_menu_page("User Registration", "Register User", 'manage_options', 'user-reg', '', '', 0);
    add_submenu_page("user-reg","CreateUser", "CreateUser", 'manage_options','form' ,'render_form');
}


add_action('admin_menu', 'create_menus');




add_filter("filter_user_data", "filter_user_input", 10, 1);
add_filter("filter_user_data", "filter_user_input", 15, 1);
add_filter("filter_user_data", "filter_user_input", 5, 1);

function filter_user_input($val){
    foreach($val as $i => &$j){

            $j=trim($j);
    
    }
    return $val;
}


function createUser($user_input){
    $res =  wp_insert_user($user_input);
    if($res && !is_wp_error($res)){
        echo '<br>user created<br>';
    }
    else{
        echo "failed to create user";
        exit;
    }

   $res =  wp_mail($user_input['user_email'], "user created", $user_input['user_login']);
   error_log(print_r($res, true));

   if($res || !is_wp_error($res)){
        echo 'mail sent succesfully to' .$user_input['user_email'];
        exit;
   }
   echo "Failed to send mail to " .$user_input['user_email']; 
   
}


remove_actions('create_user_after_submit');
add_action("create_user_after_submit", "CreateUser");




