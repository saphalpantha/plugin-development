
<?php
/*
* Plugin Name: CRUD POST
*/

function get_all_posts()
{
    $all_posts = get_posts();
    if (!$all_posts instanceof WP_Post) {
        new WP_Error('fetch_post_failed', 'Failed to retrive posts');
    }
    return rest_ensure_response($all_posts);
}



function get_post_by_id($request)
{

    $id = $request['id'];
    $single_post = get_post($id);

    if (!$single_post instanceof WP_Post) {
        return new WP_Error('fetch_post_failed', "No Post found for id $id");
    }
    return rest_ensure_response($single_post);
}

/** 
 * @param  WP_REST_Request $request 
 */
function create_post($request)
{

    $user_post = $request->get_params();
    error_log(print_r($user_post, true));
    $user_post["post_status"] = "Publish";
    if (!empty($user_post)) {

        if (!isset($user_post['post_author'])) {
            return new WP_Error('create_post_failed', 'post author is required');
        }
        if (!isset($user_post['post_content'])) {
            return new WP_Error('create_post_failed', ' content is not provided');
        }
        if (!isset($user_post['post_title'])) {
            return new WP_Error('create_post_failed', 'post title is required');
        }
        if (!isset($user_post['post_type'])) {
            return new WP_Error('create_post_failed', 'type for post is required');
        }

        $id = wp_insert_post($user_post);
        error_log($id);
        if(is_wp_error($id)){
            return new WP_Error('create_post_failed', 'please try again.');
        }
        return rest_ensure_response('Succesfully created post');
    }
    return rest_ensure_response("failed to create post");
}


function delete_post_by_id($request)
{

    $id = $request['id'];
    $res = wp_delete_post($id);
    if(!$res){
        return new WP_Error("delete_post_failed", "failed to delete post $id");
    }
    return rest_ensure_response("successfully deleted post $id");
}


/** 
 * @param  WP_REST_Request $request 
 */


function update_post($request)
{
    $id = $request['id'];
    $user_post = $request->get_params();
    $user_post["ID"] = $id;
    $user_post["post_status"] = "Publish";
    error_log(print_r($user_post, true));
    if (!empty($user_post)) {
        if (!isset($user_post['post_author'])) {
            return new WP_Error('create_post_failed', 'post author is required');
        }
        if (!isset($user_post['post_content'])) {
            return new WP_Error('create_post_failed', ' content is not provided');
        }
        if (!isset($user_post['post_title'])) {
            return new WP_Error('create_post_failed', 'post title is required');
        }
        if (!isset($user_post['post_type'])) {
            return new WP_Error('create_post_failed', 'type for post is required');
        }
        
        $res = wp_insert_post($user_post);
        error_log(print_r($res, true));
        if(!$res){
            return new WP_Error('update_post_failed', "Failed to update post");
        }
        return rest_ensure_response('Succesfully Updated Post');
    }
    return rest_ensure_response("failed to update post");
}






function crud_post_init()
{
    register_rest_route(
        'crud-post/v1',
        '/post',
        array(
            array('methods' => 'GET', 'callback' => 'get_all_posts', 'permission_callback' => function () {
                return true;
            }),
            array('methods' => 'POST', 'callback' => 'create_post', 'permission_callback' => function () {
                return true;
            }),

        )

    );
    register_rest_route(
        'crud-post/v1',
        '/post/(?P<id>\d+)',
        array(
            array('methods' => 'GET', 'callback' => 'get_post_by_id', 'permission_callback' => function () {
                return true;
            }),
            array('methods' => 'DELETE', 'callback' => 'delete_post_by_id', 'permission_callback' => function () {
                return true;
            }),
            array('methods' => 'PUT', 'callback' => 'update_post', 'permission_callback' => function () {
                return true;
            }),
        )

    );
}



add_action("rest_api_init", "crud_post_init");

