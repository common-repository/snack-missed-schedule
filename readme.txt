=== Snack Missed Schedule ===
Contributors: bouk
Donate link: 
Tags: missed schedule, cron, scheduled posts
Requires at least: 5.3
Tested up to: 6.6
Requires PHP: 7.0
Stable tag: 1.1.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Uses separate recurring cron task to check for missed schedules. 
 
== Description ==
 
Unlike other plugins, where check for missed schedules is hooked into init action, which in return means, there's an extra database call created anytime the site is loaded, this plugin creates separate recurring cron task to check for missed schedules. 

Checks are happening every 5 minutes and in case there are found posts missing its schedule, they are automatically published. From the principle this solution requires a functional WordPress cron subsystem.

== Installation ==
 
1. Upload the contents of this .zip file into '/wp-content/plugins/snack-missed-schedule' on your WordPress installation, or via the 'Plugins->Add New' option in the Wordpress dashboard.
1. Activate the plugin via the 'Plugins' option in the WordPress dashboard.
1. In case you want to be notified via email about missed schedules published by this plugin, just open your wp-config.php and define SNACK_MS_NOTIFY_ADMIN constant - e.g. `define( 'SNACK_MS_NOTIFY_ADMIN', true );`
 
== Frequently Asked Questions ==
 
== Screenshots ==

== Changelog ==

= 1.1.0 =
* Check missed schedules for other post types defined

= 1.0.1 =
* Updating tested up to version

= 1.0.0 =
* First stable release of the plugin