<?php
/**
 * Plugin Name:       Enable WebP
 * Plugin URI:        https://github.com/tanujpatra228/Enable-WebP
 * Description:       Just Enable it and you are good to go. Start using WebP
 * Version:           1.0.1
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            ITs. Web Space
 * Author URI:        https://www.itswebspace.in/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Update URI:        https://github.com/tanujpatra228/Enable-WebP
 * Text Domain:       iws-enable-webp
 */

if(!defined('ABSPATH')){
    die();
}

define('IWS_CAN_UPLODE_WEBP', 'iws-can-upload-webp');

function iws_enable_webp_activate(){
    $roles = array(
        'administrator' => 0,
        'editor' => 0,
        'author' => 0,
        'contributor' => 0,
        'subscriber' => 0,
    );
    $roles = json_encode($roles);
    add_option(IWS_CAN_UPLODE_WEBP, $roles);   // User roles who are allowed to upload WebP
}
register_activation_hook( __FILE__, 'iws_enable_webp_activate' );

function iws_enable_webp_deactivate(){
    delete_option(IWS_CAN_UPLODE_WEBP);
    remove_filter('mime_types', 'iws_webp_upload_mimes');
    remove_filter('file_is_displayable_image', 'iws_webp_is_displayable', 10, 2);
}
register_deactivation_hook( __FILE__, 'iws_enable_webp_deactivate' );

function iws_current_user_can_upload_webp(){
    $user = wp_get_current_user();
    $current_user_role = array_shift($user->roles);

    $permited_to = json_decode(get_option(IWS_CAN_UPLODE_WEBP));
    // print_r($permited_to);
    $iws_permission = 0;
    switch($current_user_role){
        case 'administrator':
            $iws_permission =  $permited_to->administrator;
            break;
        case 'editor':
            $iws_permission = $permited_to->editor;
            break;
        case 'author':
            $iws_permission = $permited_to->author;
            break;
        case 'contributor':
            $iws_permission = $permited_to->contributor;
            break;
        case 'subscriber':
            $iws_permission = $permited_to->subscriber;
            break;
        default:
            $iws_permission = 0;
    }
    return $iws_permission;
}

/** 
 * Enable upload for webp image files.
 */
function iws_webp_upload_mimes($existing_mimes) {
    $existing_mimes['webp'] = 'image/webp';
    return $existing_mimes;
}

/** 
 * Enable preview / thumbnail for webp image files.
 */
function iws_webp_is_displayable($result, $path) {
    if ($result === false) {
        $displayable_image_types = array( IMAGETYPE_WEBP );
        $info = @getimagesize( $path );

        if (empty($info)) {
            $result = false;
        } elseif (!in_array($info[2], $displayable_image_types)) {
            $result = false;
        } else {
            $result = true;
        }
    }
    return $result;
}

function iws_enable_webp(){
    if(is_user_logged_in()==1 && iws_current_user_can_upload_webp()==1){
        add_filter('mime_types', 'iws_webp_upload_mimes');
        add_filter('file_is_displayable_image', 'iws_webp_is_displayable', 10, 2);
    }
}
add_action('init', 'iws_enable_webp');

function iws_enable_webp_admin_page(){
    include 'iws_enable_webp_settings.php';
}

function iws_admin_menu(){
    add_submenu_page('options-general.php', 'Enable WebP', 'Enable WebP', 'manage_options', 'iws-enable-webp', 'iws_enable_webp_admin_page');
}
add_action('admin_menu', 'iws_admin_menu');

?>