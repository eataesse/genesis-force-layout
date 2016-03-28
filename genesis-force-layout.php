<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://rdejong.nl
 * @since             1.0.0
 * @package           Genesis_Force_Layout
 *
 * @wordpress-plugin
 * Plugin Name:       Genesis Force Layout
 * Plugin URI:        https://github.com/eataesse/genesis-force-layout
 * Description:       Force another layout if a sidebar is empty
 * Version:           1.0.0
 * Author:            Richard de Jong
 * Author URI:        http://rdejong.nl
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       genesis-force-layout
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-genesis-force-layout-activator.php
 */
function activate_genesis_force_layout() {
	if( basename(TEMPLATEPATH) != 'genesis' ) {
		deactivate_plugins(plugin_basename(__FILE__)); // Deactivate ourself
		wp_die('Sorry, you can\'t activate unless you have installed <a href="http://www.studiopress.com/themes/genesis">Genesis</a>');
	}
    
    require_once plugin_dir_path( __FILE__ ) . 'includes/class-genesis-force-layout-activator.php';
	Genesis_Force_Layout_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-genesis-force-layout-deactivator.php
 */
function deactivate_genesis_force_layout() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-genesis-force-layout-deactivator.php';
	Genesis_Force_Layout_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_genesis_force_layout' );
register_deactivation_hook( __FILE__, 'deactivate_genesis_force_layout' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-genesis-force-layout.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_genesis_force_layout() {

	$plugin = new Genesis_Force_Layout();
	$plugin->run();

}
run_genesis_force_layout();
