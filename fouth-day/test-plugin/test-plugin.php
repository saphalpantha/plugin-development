<?php

/*
* Plugin Name: Test Plugin
*/



function render_form()
{
    return include_once 'send-mail.php';
}


function createMyMenus()
{
    add_menu_page("Test Email", "Test Email", 'manage_options', "test-email", '', '', 3);
    add_submenu_page("test-email", "Send Email", "Send Email", 'manage_options', "send-mail", "render_form");
}


add_action("init", "createMyMenus");


add_filter('test_mail_message', function ($message) {

    $message .= ' This is is filtered.';

    return $message;
});

add_action('phpmailer_init', 'custom_phpmailer_init');
function custom_phpmailer_init($phpmailer) {

    if ( !is_object( $phpmailer ) ){
        $phpmailer = (object) $phpmailer;
    }


    $phpmailer->Mailer     = 'smtp';
    $phpmailer->Host = SMTP_HOST;
    $phpmailer->SMTPAuth = SMTP_AUTH;
    $phpmailer->Port = SMTP_PORT;
    $phpmailer->Username = SMTP_USER;
    $phpmailer->Password = SMTP_PASSWORD;
    $phpmailer->SMTPSecure = SMTP_SECURE;
    $phpmailer->From = SMTP_USER;
    $phpmailer->FromName = get_bloginfo('name');
}


add_action("after_test_mail_post_save", function ($post_id) {


    $post = get_post($post_id);

    if(!$post){
        return;
    }
    
    $send_to = get_post_meta($post_id, 'send_to', true);

    $subject = $post->post_title;
    $message = $post->post_content;


    $status = wp_mail( $send_to, $subject, $message );

    error_log(print_r($send_to, true));
    error_log(print_r($subject, true));
    error_log(print_r($message, true));
    error_log(print_r($status, true));

});





