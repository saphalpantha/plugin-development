<?php
if(isset($_POST['user_submit_button'])){
    if(empty($_POST['email'])){
        echo 'email is required';
        exit;
    }
    if(empty($_POST['first_name'])){
        echo 'first name is required';
        exit;
    }
    if(empty($_POST['last_name'])){
        echo 'last name is required';
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
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];

    $redirect_to = $_POST['redirect_to'];
    
    $user_input = array(
        "user_email"=>$user_email,
        "user_pass" => $user_password,
        "user_login" => $username,
        "role" => $role,
        "description"=> $bio,
        "first_name" => $first_name,
        "last_name" => $last_name
    );


    $res =  wp_insert_user($user_input);

    if($res && !is_wp_error($res)){
    error_log(print_r($redirect_to, true));

    if(!empty($redirect_to)){
        wp_redirect($redirect_to);
        exit;
    }
    }
    else{
        echo "failed to create user";
        exit;
    }
} 
?>
<form class="main_form" method="POST" action="">
    <input placeholder="Email" type="email" name="email"/>
    <input placeholder="Password" type="password" name="password"/>
    <input placeholder="username" type="text" name="username"/>
    <input placeholder="Display Name" type="text" name="display_name"/>
    <input placeholder="First Name" type="text" name="first_name"/>
    <input placeholder="Last Name" type="text" name="last_name"/>
    <textarea rows="3" cols="10"  placeholder="Bio..." type="text" name="bio"></textarea>
    <select name="role">
        <option value="Administrator">Administrator</option>
        <option value="Subscriber" >Subscriber</option>
        <option value="Editor" >Editor</option>
    </select>
    <input type="hidden" name="redirect_to" value="<?php echo $redirect_to; ?>" />
    <button name="user_submit_button">Add New User</button>
</form>