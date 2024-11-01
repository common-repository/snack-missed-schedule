<?php
/*
Plugin Name: Snack Missed Schedule
Description: Efficiently handles missed schedules.
Version: 1.1.0
Author: Petr Paboucek -aka- BoUk
Author URI: https://wpadvisor.co.uk
Text Domain: snack-missed-schedule
*/

if ( ! defined( 'ABSPATH' ) ) 
    exit;

define( 'SNACK_MS_PLUGIN_PATH', 	plugin_dir_path( __FILE__ ) );
define( 'SNACK_MS_PLUGIN_URL', 		plugin_dir_url( __FILE__ ) );

/**
 * Load required files
 */
require SNACK_MS_PLUGIN_PATH . "vendor/autoload.php";

$model 			= new \Snack\MissedSchedule\Models\wpModel();
$controller 	= new \Snack\MissedSchedule\Controllers\wpController( $model );

/**
 * Introduce custom schedule time interval
 */
add_filter( 'cron_schedules', [ 
				$model, 
				'addCronSchedules' 
			]);

/**
 * Making sure reccuring cron event is set
 */
add_action( 'init',	[ 
				$controller, 
				'scheduleCronEvent' 
			]);

/**
 * 
 */
add_action( $model::RECCURING_EVENT_NAME, [ 
				$controller, 
				'checkMissedSchedules' 
			]);

/**
 * Clean up after deactivation
 */
register_deactivation_hook( __FILE__, [ 
				$controller, 
				'deactivate' 
			]);

/**
 * Remove re-occuring cron event
 */
add_action( 'snack_missed_plugin_deactivate', [
				$controller, 
				'removeCronEvents' 
			]);


     