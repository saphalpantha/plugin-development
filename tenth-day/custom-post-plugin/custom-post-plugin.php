<?php




function reg_custom_post_type()
{
    $labels = array(
        'name' =>'Course',
        'singular_name' => 'Course',
        'add_new' =>          __('Add New Course', 'add new'),
        'add_new_item' => __('Add New Course'),
    );

    $supports = array(
        'title',
        'editor',
        'custom-fields',

    );

    $args = array(
        'label'                 => __('Course', 'text_domain'),
        'description'           => 'Course Description',
        'labels'                => $labels,
        'supports'              => $supports,
        'taxonomies'            => array('category', 'post_tag'),
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 5,
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => true,
        'has_archive' => false,
        'rewrite' => array('slug' => 'course'),

    );
    register_post_type('course', $args);
}



add_action('init', 'reg_custom_post_type', 0);


