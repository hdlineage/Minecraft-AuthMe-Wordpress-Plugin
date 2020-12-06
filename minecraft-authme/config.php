<?php

function minecraft_authme_add_settings_page() {
    add_options_page( 'Minecraft AuthMe Settings Page', 'Minecraft AuthMe', 'manage_options', 'minecraft-authme', 'minecraft_authme_render_settings_page' );
}
add_action( 'admin_menu', 'minecraft_authme_add_settings_page' );

function minecraft_authme_render_settings_page() {
    ?>
    <h2>Minecraft AuthMe Settings</h2>
    <form action="options.php" method="post">
        <?php 
        settings_fields( 'minecraft_authme_options' );
        do_settings_sections( 'minecraft_authme_fields' ); ?>
        <input name="submit" class="button button-primary" type="submit" value="<?php esc_attr_e( 'Save' ); ?>" />
    </form>
    <?php
}

function minecraft_authme_register_settings() {
    register_setting( 'minecraft_authme_options', 'minecraft_authme_options', 'minecraft_authme_options_validate' );
    add_settings_section( 'db_settings', 'Database Settings', 'minecraft_authme_section_text', 'minecraft_authme_fields' );

	add_settings_field( 'minecraft_authme_host', 'Host', 'minecraft_authme_host', 'minecraft_authme_fields', 'db_settings' );
	add_settings_field( 'minecraft_authme_user', 'Username', 'minecraft_authme_user', 'minecraft_authme_fields', 'db_settings' );
	add_settings_field( 'minecraft_authme_pass', 'Password', 'minecraft_authme_pass', 'minecraft_authme_fields', 'db_settings' );
    add_settings_field( 'minecraft_authme_db', 'Database', 'minecraft_authme_db', 'minecraft_authme_fields', 'db_settings' );
    add_settings_field( 'minecraft_authme_table', 'Table', 'minecraft_authme_table', 'minecraft_authme_fields', 'db_settings' );    
	add_settings_field( 'minecraft_authme_invite', 'Invitation Code', 'minecraft_authme_invite', 'minecraft_authme_fields', 'db_settings' );    
	add_settings_field( 'minecraft_authme_email_notification', 'Email Notification', 'minecraft_authme_email_notification', 'minecraft_authme_fields', 'db_settings' );
	add_settings_field( 'minecraft_authme_captcha', 'Invisible ReCaptcha Integration', 'minecraft_authme_captcha', 'minecraft_authme_fields', 'db_settings' );
	add_settings_field( 'minecraft_authme_welcome', 'Welcome Message', 'minecraft_authme_welcome', 'minecraft_authme_fields', 'db_settings' );
	add_settings_field( 'minecraft_authme_form_title', 'Form Title', 'minecraft_authme_form_title', 'minecraft_authme_fields', 'db_settings' );
	
	$options = get_option( 'minecraft_authme_options' );
	if(!array_key_exists ('host', $options))		
		$options['host'] = '';
	if(!array_key_exists ('user', $options))		
		$options['user'] = '';
	if(!array_key_exists ('pass', $options))		
		$options['pass'] = '';
	if(!array_key_exists ('db', $options))		
		$options['db'] = '';
	if(!array_key_exists ('table', $options))		
		$options['table'] = '';
	if(!array_key_exists ('invite', $options))		
		$options['invite'] = '';
	if(!array_key_exists ('email', $options))		
		$options['email'] = '';
	if(!array_key_exists ('captcha', $options))		
		$options['captcha'] = 0;
	if(!array_key_exists ('welcome', $options))		
		$options['welcome'] = 'You must have a valid invite code to register.';
	if(!array_key_exists ('form-title', $options))		
		$options['form-title'] = 'New Account Registration Form';
	
	update_option('minecraft_authme_options', $options);
}
add_action( 'admin_init', 'minecraft_authme_register_settings' );

function minecraft_authme_options_validate( $input ) {    
    return $input;
}


function minecraft_authme_section_text() {
    echo '<p>Here you can set all the options for connecting to AuthMe database</p>';
}

function minecraft_authme_host() {
    $options = get_option( 'minecraft_authme_options' );		
	$value = $options['host'];	
    echo "<input id='minecraft_authme_host' name='minecraft_authme_options[host]' type='text' value='$value' />";
}

function minecraft_authme_user() {
    $options = get_option( 'minecraft_authme_options' );
	$value = $options['user'];
    echo "<input id='minecraft_authme_user' name='minecraft_authme_options[user]' type='text' value='$value' />";
}

function minecraft_authme_pass() {
    $options = get_option( 'minecraft_authme_options' );
	$value = $options['pass'];	
    echo "<input id='minecraft_authme_pass' name='minecraft_authme_options[pass]' type='password' value='$value' />";
}

function minecraft_authme_db() {
    $options = get_option( 'minecraft_authme_options' );
	$value = $options['db'];
    echo "<input id='minecraft_authme_db' name='minecraft_authme_options[db]' type='text' value='$value' />";
}

function minecraft_authme_table() {
    $options = get_option( 'minecraft_authme_options' );
	$value = $options['table'];
    echo "<input id='minecraft_authme_table' name='minecraft_authme_options[table]' type='text' value='$value' />";
}

function minecraft_authme_invite() {
    $options = get_option( 'minecraft_authme_options' );
	$value = $options['invite'];
    echo "<input id='minecraft_authme_invite' name='minecraft_authme_options[invite]' type='text' value='$value' />";
}

function minecraft_authme_email_notification() {
    $options = get_option( 'minecraft_authme_options' );
	$value = $options['email'];
    echo "<input id='minecraft_authme_email_notification' name='minecraft_authme_options[email]' type='email' value='$value' />";
}

function minecraft_authme_captcha() {
    $options = get_option( 'minecraft_authme_options' );
	$value = $options['captcha'];
	if(is_plugin_active('invisible-recaptcha/invisible-recaptcha.php')){
		$html = "<input id='minecraft_authme_captcha' name='minecraft_authme_options[captcha]' type='checkbox' value='1'".checked( $value,1,false)." />";
	}		
	else{
		$html = "You must first make sure the <a href='https://wordpress.org/plugins/invisible-recaptcha/'>Invisible ReCaptcha Plugin</a> is installed";
	}	
	echo $html;
}

function minecraft_authme_welcome() {
    $options = get_option( 'minecraft_authme_options' );
	$value = $options['welcome'];
    echo "<input id='minecraft_authme_welcome' name='minecraft_authme_options[welcome]' size='50' type='text' value='$value' />";
}

function minecraft_authme_form_title() {
    $options = get_option( 'minecraft_authme_options' );
	$value = $options['form-title'];
    echo "<input id='minecraft_authme_form_title' name='minecraft_authme_options[form-title]' size='50' type='text' value='$value' />";
}


$options = get_option( 'minecraft_authme_options' );
//Authme Database Setup
define('Authme_DB_NAME', $options['db']);
define('Authme_TABLE_NAME', $options['table']);
/** MySQL database username */
define('Authme_DB_USER', $options['user']);
/** MySQL database password */
define('Authme_DB_PASSWORD', $options['pass']);
/** MySQL hostname */
define('Authme_DB_HOST', $options['host']);
//Custom Invitation Code
define('Authme_INV_CODE', $options['invite']);