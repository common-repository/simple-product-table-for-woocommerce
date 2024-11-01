<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              #
 * @since             1.0.0
 * @package           Sptable
 *
 * @wordpress-plugin
 * Plugin Name:       simple product table for WooCommerce
 * Plugin URI:        #
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            Bluegamediversion
 * Author URI:        bluegamediversion@gmail.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       sptable
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'SPTABLE_VERSION', '1.0.0' );

/**
 * Product table cpt label
 */
define( 'SPTABLE_CPT_PROD_TABLE', 'spt_product_table' );
/**
 * Product list cpt label
 */
define( 'SPTABLE_CPT_PROD_LIST', 'spt_product_list' );

/**
 * post meta key for cpt.
 */
define( 'SPTABLE_TABLE_CONFIG', 'spt_table_config' );

require plugin_dir_path( __FILE__ ) . 'includes/functions.php';
/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-sptable-activator.php
 */
function activate_sptable() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-sptable-activator.php';
	Sptable_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-sptable-deactivator.php
 */
function deactivate_sptable() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-sptable-deactivator.php';
	Sptable_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_sptable' );
register_deactivation_hook( __FILE__, 'deactivate_sptable' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-sptable.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_sptable() {

	$plugin = new Sptable();
	$plugin->run();

}
run_sptable();
