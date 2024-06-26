<?php

/*
* Plugin Name: REST API Example
*/


function test_rest_api(){
    error_log('test ');
    register_rest_route(
        'server/v1',
        '/get-data',
array(
    array(
            'methods' => 'GET',
            'callback' => 'test_get_data',
            'permission_callback' => function(){
                return true;
            }
        ),
        array(
            'methods' => 'POST',
            'callback' => 'create_item',
            'permission_callback' => function(){
                if(get_current_user()){
                    new WP_Error('rest_user_not_logged_in', 'Sorry you are not logged', array('status'=>404));
                }
            
                return true;
            }
        ),
)
    );
}

/** 
 * @param  WP_REST_Request $request 
 */
function create_item($request){
    $params = $request->get_params();

    error_log(print_r($params, true));

    return rest_ensure_response($params);
}
function test_get_data() {
    // rest_ensure_response() wraps the data we want to return into a WP_REST_Response, and ensures it will be properly returned.
    return rest_ensure_response( 'Hello World, this is the WordPress REST API' );
}

add_action("rest_api_init", 'test_rest_api');
