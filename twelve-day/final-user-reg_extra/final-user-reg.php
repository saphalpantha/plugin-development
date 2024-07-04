<?php

/**
 * Plugin Name: Final User Registraiton
 * Author: Saphal
 * Version: 1.0.0
 * Text-Domain: final-user-registration
 */



require_once dirname(__FILE__). '/vendor/autoload.php';


use Test\Test1\Admin\User;


class FinalUserRegistration{
    /**
     * Initializtion hooks and shortcode
     * @since 1.0.0
     */

    public function __construct() {
                        $admin = new User();
                        $admin->test();
        
        add_shortcode("final_user_reg_ui", array($this, 'final_display_form'));
        add_shortcode("final_login_form_ui", array($this, 'final_display_login_form'));

        add_action('wp_enqueue_scripts', array($this, 'add_scripts'));

        add_action('wp_ajax_nopriv_handle_login_form_submission', array($this, 'handle_login_form_submission'));
        add_action('wp_ajax_nopriv_handle_form_submission', array($this, 'handle_form_submission'));

        add_action('wp_ajax_handle_login_form_submission', array($this, 'handle_login_form_submission'));
        add_action('wp_ajax_handle_form_submission', array($this, 'handle_form_submission'));
    }

    /**
     * Display form for User Registraiton
     
     * @since  1.0.0
     
     * @param array $atts Shortcode attributes
     * @param string|null $content The inside shortcode tags(if any)
     *
     * @return string The html content to display
     */

    public function final_display_form($atts, $content, $tag)
    {

        if (is_user_logged_in()) {
            return __("You are logged", 'final-user-registration');
        }

        ob_start();
        include_once 'form.php';

        $html = ob_get_clean();
        
        return $html;
    }

    /**
     * Display form for User Login
     * @since 1.0.0
     * @param  array $atts Shortcode attributes
     * @return string|null $content The content inside shortcode tags
     */

    public function final_display_login_form($atts, $content, $tag)
    {

        if (is_user_logged_in()) {
            return __("You are logged", 'final-user-registration');
        }

        ob_start();
        include_once 'login-form.php';

        $html = ob_get_clean();
        return $html;
    }

    /**
     * @since 1.0.0
     * @global WP_Post $post The global post object
     */
    public function add_scripts() {
        global $post;

        if ($post && isset($post->post_content) && (has_shortcode($post->post_content, 'final_user_reg_ui') || has_shortcode($post->post_content, 'final_login_form_ui'))) {
            wp_enqueue_script('form_handler_js', plugins_url('js/script.js', __FILE__), array('jquery'), '1.0.0', true);

            wp_localize_script(
                'form_handler_js',
                'ajax_object',
                array(
                    'ajax_url' => admin_url('admin-ajax.php'),
                ),
            );
        }
    }

   /**
   * Handle Form Submission for User Input.
   *
   * @return WP_REST_Response | void Json Resposne with error or success message
   */
    public function handle_form_submission()
    {
        $errors = array();

        if (!isset($_POST['_wpnonce'])) {
            $errors["nonce"] = "Nonce is required";
        }

        if (!wp_verify_nonce($_POST['_wpnonce'], 'register_user')) {
            die(__('Invalid nonce', 'final-user-registration'));
        }

        if (!isset($_POST['email'])) {
            $errors["email_error"] = __("Email is required", '');
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

        if (!empty($errors)) {
            return wp_send_json_error($errors, 404);
        }

        $user_input = array(
            "user_email"  => $_POST['email'],
            "user_pass"   => $_POST['password'],
            "user_login"  => $_POST['username'],
            "role"        => $_POST['role'],
            "description" => $_POST['bio'],
        );

        $validate_errors = $this->validate_user_input($user_input);

        if ( ! empty( $validate_errors ) ) {
            return rest_ensure_response(array("message" => "Failed to Validate", "errors" => $validate_errors));
        }

        $user_input = $this->sanitize_user_input( $user_input );

        $file = $_FILES['profile'];

        $upload_overrides = array( 'test_form' => false );
        $movefile         = wp_handle_sideload($file, $upload_overrides);

        if (isset($movefile['url'])) {
            $args = array(
                'guid' => $movefile['url'],
                'post_mime_type' => $file['type'],
                'post_title' => $file['name'],
            );

            $res = wp_insert_attachment($args, $movefile['file']);

            if ($res) {
                $user_input['avatar'] = $movefile['file'];
            }
        }

        if (is_wp_error($res)) {
            return wp_send_json_error('Failed to Insert Image', 500);
        }

        return $this->createUser($user_input, $res);
    }



    /**
    * Validate User Input.
    * @param  array $user_input Input Fields.
    * @return array Return errors of associative array
    */
    public function validate_login_input($user_login, $password)
    {
        $validate_errors = array();

        if (!is_email($user_login) || !empty($user_login)) {
            $validate_errors["user_login"] = "User Login should be email or username";
        }

        if (empty($password)) {
            $validate_errors["password"] = "User Password cannot be empty";
        }

        return $validate_errors;
    }

    /**
    * Sanitize User Input.
    * @since 1.0.0
    * @param  array $user_input  Input Fields.
    * @return array Sanitize Fields
    */
    public function sanitize_user_input($user_input)
    {
        $user_input["user_email"] = sanitize_email($user_input["user_email"]);
        $user_input["user_pass"] = sanitize_text_field($user_input["user_pass"]);
        $user_input["description"] = sanitize_textarea_field($user_input["description"]);
        $user_input["role"] = sanitize_text_field($user_input["role"]);

        return $user_input;
    }

    /**
    * Validate User Input.
    * @since 1.0.0
    * @param  array $user_input Input Fields.
    * @return array returns errors for validation failed
    */
    
    public function validate_user_input($user_input){
        $roles_enum = ["administrator", "subscriber", "author", "contributor", "editor"];
        $validate_errors = array();

        if (!is_email($user_input["user_email"])) {
            $validate_errors["email_error"] = "Email is not Valid";
        }

        $exist_in_array = in_array($user_input['role'], $roles_enum);

        if (!$exist_in_array) {
            $validate_errors["role_error"] = "Role is not Valid";
        }

        return $validate_errors;
    }
    
    /**
    * Create new User.
    * @since 1.0.0
    * @param  array User Input Fields.
    * @param  int  Attachemnt Id.
    * @return \WP_REST_SERVER
    */
    public function createUser($user_input, $attach_id){

        $res = wp_insert_user($user_input);

        if ($res && !is_wp_error($res)) {
            $result = update_user_meta($res, 'profile_avatar', $attach_id);

            return wp_send_json_success('Successfully created User', 202);
        } else {
            return wp_send_json_error('Failed to  created User', 500);
        }
    }
    
    

    
    /**
    * Sanitize User Input For Login.
    * @since 1.0.0
    * @param  array Input Fields.
    * @return array Return Sanitize Fields
    */
    public function sanitize_login_input($user_login, $password){
        $user_input               = array();
        $user_input["user_login"] = sanitize_email($user_login);
        $user_input["password"]   = sanitize_text_field($password);
        
        return $user_input;
    }

    /**
    * Handle Form Submission for Login User.
    * @since 1.0.0
    * @return WP_REST_Server
    */
    public function handle_login_form_submission()
    {
        if (!isset($_POST['email'])) {
            $response = 'Email is required';
            return wp_send_json_error($response, 404);
        }
        if (!isset($_POST['password'])) {
            $response = 'Password is required';
            return wp_send_json_error($response, 404);
        }

        if (!isset($_POST['_wpnonce'])) {
            return wp_send_json_error('Nonce is required');
        }

        if (!wp_verify_nonce($_POST['_wpnonce'], 'login_user')) {
            die(__('Invalid nonce', 'final-user-registration'));
        }

        $validate_errors = validate_login_input($_POST["email"], $_POST["password"]);

        if (!empty($validate_errors)) {
            return wp_send_json_error(array("message" => "Validation Failed", "error" => $validate_errors), 404);
        }

        $sanitize_input = sanitize_login_input($_POST["email"], $_POST["password"]);
        $res = wp_signon(array("user_login" => $sanitize_input['user_login'], "user_password" => $sanitize_input['password'], true));
        if (is_wp_error($res)) {
            return wp_send_json_error($res->get_error_message());
        }

        wp_send_json_success(
            array(
                "message" => "Login Success",
                "redirect_to" => "http://basiclearning.local/wp-admin/",
            ),
            200,
        );
    }

}


new FinalUserRegistration();