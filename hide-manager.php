<?php
/*
Plugin Name: Hide Manager
Plugin URI: http://www.themebuffer.com/
Author:  Theme Buffer
Text Domain: hide-manager
Description: This plugin provides an easy way to Hide Comment from Pages & Posts, Hide Featured Image and Hide Title from Posts & Pages.
Version: 1.0.0
Author URI: http://www.themebuffer.com
*/

define('HM_PLUGIN_DIR', plugin_dir_path( __FILE__ ));

require_once('inc/hide-manager-class.php');

// instance baseclass
$objHM = new HideManager();

register_activation_hook( __FILE__, array( $objHM, 'HM_plugin_activation' ) );
register_deactivation_hook( __FILE__, array( $objHM, 'HM_plugin_deactivation' ) );

?>