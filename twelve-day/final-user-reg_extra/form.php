<form class="<?php echo esc_attr("main_form") ?>" id="user-reg-form" enctype="multipart/form-data">
    <?php $nonce = wp_create_nonce('register_user'); ?>
    <input placeholder="<?php esc_attr_e("Email", "final-user-registration") ?>" type="email" name="<?php echo esc_attr("email") ?>" />
    <input placeholder="<?php echo esc_attr__("Password", "final-user-registration") ?>" type="<?php echo esc_attr("password") ?>" name="<?php echo esc_attr("password") ?>" />
    <input placeholder="<?php echo esc_attr__("Username", "final-user-registration") ?>" type="<?php echo esc_attr("text") ?>" name="<?php echo esc_attr("username") ?>" />
    <textarea rows="3" cols="10" placeholder="Bio..." name="bio" placeholder="<?php echo esc_attr__("Bio ...", "final-user-registration") ?>" name="<?php echo esc_attr("bio") ?>"> </textarea>
    <select name="role">
        <option value="<?php echo esc_attr__("administrator", "final-user-registration") ?>"><?php echo esc_html__("Administrator", "final-user-registration"); ?></option>
        <option value="<?php echo esc_attr__("subscriber", "final-user-registration") ?>"><?php echo esc_html__("Subscriber", "final-user-registration"); ?></option>
        <option value="<?php echo esc_attr__("contributor", "final-user-registration") ?>"><?php echo esc_html__("Contributor", "final-user-registration"); ?></option>
        <option value="<?php echo esc_attr__("author", "final-user-registration") ?>"><?php echo esc_html__("Author", "final-user-registration"); ?></option>
        <option value="<?php echo esc_attr__("editor", "final-user-registration") ?>"><?php echo esc_html__("Editor", "final-user-registration"); ?></option>
    </select>
    <input type="file" id="profile" name="<?php echo esc_attr("profile"); ?>" />
    <input type="hidden"  name="_wpnonce" value="<?php echo $nonce ?>"  />
    <button type="submit">Add New User</button>
</form>