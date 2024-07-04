<form class="main_form">

    <?php 
        $nonce = wp_create_nonce('login_user');
    ?>
    <input placeholder="<?php echo esc_attr__("Email or Username", "final-user-registration") ?>" type="text"
        name="email" />
    <input placeholder="<?php echo esc_attr__("Password", "final-user-registration"); ?>" type="password"
        name="password" />
    <input type="hidden" name="_wpnonce" value="<?php echo esc_attr($nonce); ?>" />
    <button type="button" onclick="loginHandler(event)">Login in</button>
</form>