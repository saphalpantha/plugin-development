<form method="POST" action="admin.php?page=send-mail">
    <input type="text" name="subject" placeholder="Email Subject" />
    <input type="text" name="content" placeholder="Email Content" />
    <input type="email" name="send_to" placeholder="Send To" />
    <button type="submit" name="test_mail_submit">Send</button>
</form>


<?php



if(isset($_POST['test_mail_submit'])){
    if(!isset($_POST['subject'])){
        echo 'Subject is required field';
        exit;
    }

    if(! isset($_POST['content'])){
        echo 'Content is Required !';
        exit;
    }

    if(! isset($_POST['send_to'])){
        echo 'Send to Field Must Valid';
        exit;
    }

 $description = $_POST['content'];
    
$description = apply_filters("test_mail_message", $description);


    $post_id = wp_insert_post(array(
        'post_title' => $_POST['subject'],
        'post_content' => $description,
        'post_status' => 'publish',
        'post_type' => 'post',
    ));



    if (!$post_id || is_wp_error($post_id)) {
        error_log('Post creation failed: ' . print_r($post_id, true));
    } else {
        add_post_meta($post_id, 'send_to', $_POST['send_to']);

        error_log('Test mail created successfully.');

        do_action("after_test_mail_post_save",  $post_id);
    }

}

/*


    $subject = $_POST['subject'];

    $sendt_to = $_POST['subject'];
    $content = $_POST['subject'];


    $content = apply_filter('mail_message', $content);

    // save this data in post.

    // post_title => subj
    // const =desc


    $post_id = wp_insert_post();

*/



