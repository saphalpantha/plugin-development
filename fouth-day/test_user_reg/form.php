
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Document</title>
</head>
<body>
    
<form class="main_form" method="POST" action="">
    <input placeholder="Email" type="email" name="email"/>
    <input placeholder="Password" type="password" name="password"/>
    <input placeholder="username" type="text" name="username"/>
    <textarea rows="3" cols="10"  placeholder="Bio..." type="text" name="bio"></textarea>
    <select name="role">
        <option value="Administrator">Administrator</option>
        <option value="Subscriber" >Subscriber</option>
        <option value="Contributor" >Contributor</option>
        <option value="Author" >Author</option>
        <option value="Editor" >Editor</option>
    </select>
    <button name="user_submit_button">Add New User</button>
</form>
</body>
</html>



<?php

if(isset($_POST['user_submit_button'])){
    if(empty($_POST['email'])){
        echo 'email is required';
        exit;
    }
    if(empty($_POST['password'])){
        echo 'password is not valid';
        exit;
    }
    if(empty($_POST['username'])){
        echo 'username cannot be empty required';
        exit;
    }
    if(empty($_POST['role'])){
        echo 'role must provide';
        exit;
    }
    if(empty($_POST['bio'])){
        echo 'please provide bio';
        exit;
    }


    $user_email = $_POST['email'];
    $user_password = $_POST['password'];
    $username = $_POST['username'];
    $role = $_POST['role'];
    $bio = $_POST['bio'];


    $user_input = apply_filters("my_ur_user_data", array(
        "user_email"=>$user_email,
        "user_pass" => $user_password,
        "user_login" => $username,
        "role" => $role,
        "description"=> $bio
    ));





    do_action("create_user_after_submit", $user_input);
}



?>