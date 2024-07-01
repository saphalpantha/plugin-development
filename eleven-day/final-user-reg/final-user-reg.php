<?php

/*

* Plugin Name: Final User Registraiton
*/

add_shortcode("final_user_reg_ui", "final_display_form");
add_shortcode("final_login_form_ui", "final_display_login_form");

add_action('wp_enqueue_scripts', 'add_scripts');

add_action('wp_ajax_nopriv_handle_form_submission', 'handle_form_submission');
add_action('wp_ajax_handle_login_form_submission', 'handle_login_form_submission');

add_action('wp_ajax_handle_login_form_submission', 'handle_login_form_submission');
add_action('wp_ajax_nopriv_handle_login_form_submission', 'handle_login_form_submission');


function handle_form_submission()
{
    $errors = array();
    if (!isset($_POST['email'])) {
        $errors["email_error"] = "Email is required";
    }
    if (!isset($_POST['password'])) {
        $errors["password_error"] = "Password is required";
    }
    if (!isset($_POST['username'])) {
        $errors["username_error"] = "Username is required";
    }
    if (!isset($_POST['role'])) {
        $errors["role_error"] = "Role is required";
    }
    if (!isset($_POST['bio'])) {
        $errors["bio_error"] = "Bio is required";
    }

    if (!isset($_POST['profile'])) {
        $errors["profile_error"] = "Profile is required";
    }

    if (!empty($errors)) {
        return wp_send_json_error($errors, 404);
    }

    $user_input =  array(
        "user_email" => $_POST['email'],
        "user_pass" => $_POST['password'],
        "user_login" => $_POST['username'],
        "role" => $_POST['role'],
        "description" => $_POST['bio'],
    );

    $file = $_FILES['profile'];    
    
    
    $upload_overrides = array( 'test_form' => false );
    $movefile = wp_handle_sideload( $file, $upload_overrides );

    if(!isset($movefile['url'])){
        return;
    }
    $args = array(
        'guid'           => $movefile['url'],
        'post_mime_type' => $file['type'],
        'post_title'     => $file['name'],
    );
    $res = wp_insert_attachment($args ,$movefile['file']);
    

    if($res){
        $user_input['avatar'] = $movefile['file'];
    }
    
    if(is_wp_error($res)){
        return wp_send_json_error('Failed to Insert Image', 500);
    }    
    createUser($user_input, $res);
}



function createUser($user_input, $attach_id)
{

    $res = wp_insert_user($user_input);
    if ($res && !is_wp_error($res)) {
        $result = update_user_meta($res, 'profile_avatar', $attach_id);
        error_log(print_r($result, true));
        return wp_send_json_success('Successfully created User', 202);
    } else {
        return wp_send_json_error('Failed to  created User', 500);;
    }
}



function handle_login_form_submission()
{

    if (!isset($_POST['email'])) {
        $response =  'Email is required';
        return wp_send_json_error($response, 404);
    }
    if (!isset($_POST['password'])) {
        $response =  'Password is required';
        return wp_send_json_error($response, 404);
    }

    $res = wp_signon(array("user_login" => $_POST['email'],  "user_password" => $_POST['password'], true));
    if (is_wp_error($res)) {
        return wp_send_json_error($res->get_error_message());
    }


    wp_send_json_success(array(
        "message" => "Login Success",
        "redirect_to" => "http://basiclearning.local/wp-admin/"
    ), 200);
}

function add_scripts()
{
    global $post;

    if ($post && isset($post->post_content) && (has_shortcode($post->post_content, 'final_user_reg_ui') ||   has_shortcode($post->post_content, 'final_login_form_ui'))) {
        wp_enqueue_script('form_handler_js', plugins_url('js/script.js', __FILE__), array('jquery'), '1.0.0', true);

        wp_localize_script('form_handler_js', 'ajax_object', array(
            'ajax_url' => admin_url('admin-ajax.php')
        ));
    }
}




function final_display_form($atts, $content, $tag)
{

    if (is_user_logged_in()) {
        return 'you are logged';
    }

    ob_start();
    include_once 'form.php';

    $html = ob_get_clean();
    return $html;
}


function final_display_login_form($atts, $content, $tag)
{



    if (is_user_logged_in()) {
        return 'you are logged';
    }

    ob_start();
    include_once 'login-form.php';

    $html = ob_get_clean();
    return $html;
}
