<?php
/*
Plugin Name: LeadIn
Plugin URI: http://leadin.com
Description: LeadIn is an easy-to-use CRM for WordPress that tracks each visitors referral source and page view history. 
Version: 0.4.5
Author: Andy Cook, Nelson Joyce
Author URI: http://leadin.com
License: GPL2
*/

//=============================================
// Define Constants
//=============================================

if ( !defined('LEADIN_PATH') )
    define('LEADIN_PATH', untrailingslashit(plugins_url('', __FILE__ )));

if ( !defined('LEADIN_PLUGIN_DIR') )
	define('LEADIN_PLUGIN_DIR', untrailingslashit(dirname( __FILE__ )));

if ( !defined('LEADIN_PLUGIN_SLUG') )
	define('LEADIN_PLUGIN_SLUG', basename(dirname(__FILE__)));

if ( !defined('LEADIN_DB_VERSION') )
	define('LEADIN_DB_VERSION', '0.4.3');

if ( !defined('LEADIN_PLUGIN_VERSION') )
	define('LEADIN_PLUGIN_VERSION', '0.4.5');

//=============================================
// Include Needed Files
//=============================================

require_once(LEADIN_PLUGIN_DIR . '/admin/leadin-admin.php');
require_once(LEADIN_PLUGIN_DIR . '/inc/class-emailer.php');
require_once(LEADIN_PLUGIN_DIR . '/inc/class-leadin-updater.php');
require_once(LEADIN_PLUGIN_DIR . '/inc/leadin-ajax-functions.php');
require_once(LEADIN_PLUGIN_DIR . '/inc/leadin-functions.php');

//=============================================
// WPLeadIn Class
//=============================================
class WPLeadIn {
	
	var $li_wp_admin;
	
	/**
	 * Class constructor
	 */
	function __construct ()
	{
		//=============================================
		// Hooks & Filters
		//=============================================

		add_action('plugins_loaded', array($this, 'leadin_update_check'));
		add_filter('init', array($this, 'add_leadin_frontend_scripts'));

		$this->li_wp_admin 	= new WPLeadInAdmin();
		$li_wp_updater 	= new WPLeadInUpdater();

		add_filter('plugin_action_links_' . plugin_basename(__FILE__), array(&$this->li_wp_admin, 'leadin_plugin_settings_link'));
	}

	/**
	 * Activate the plugin
	 */
	function add_leadin_defaults ()
	{
		$li_options = get_option('leadin_options');

		if ( ($li_options['li_installed'] != 1) || (!is_array($li_options)) )
		{
			$opt = array(
				'li_installed'	=> '1',
				'li_db_version'	=> "",
				'li_email' 		=> get_bloginfo('admin_email')
			);

			update_option('leadin_options', $opt);
			$this->leadin_db_install();
		}

		// 0.4.0 upgrade - Delete legacy db option version 0.4.0 (remove after beta testers upgrade)
        if ( get_option('leadin_db_version') )
            delete_option('leadin_db_version');

		// 0.4.0 upgrade - Delete legacy options version 0.4.0 (remove after beta testers upgrade)
        if ( $li_legacy_options = get_option('leadin_plugin_options') )
        {
        	leadin_update_option('li_email', $li_legacy_options['li_email']);
            delete_option('leadin_plugin_options');
        }

        leadin_track_plugin_registration_hook(TRUE);
	}

	/**
	 * Deactivate LeadIn plugin hook
	 */
	function deactivate_leadin ()
	{
		// Override the update plugin cache because updates don't work when plugin is disabled
		$plugin_info = get_site_transient('update_plugins');
		unset($plugin_info->checked['leadin/leadin.php']);
		set_site_transient('update_plugins', '');

		leadin_track_plugin_registration_hook(FALSE);
	}

	//=============================================
	// Database update
	//=============================================

	/**
	 * Creates or updates the LeadIn tables
	 */
	function leadin_db_install ()
	{
		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
		
		$sql = "
			CREATE TABLE li_pageviews (
			  pageview_id int(11) unsigned NOT NULL AUTO_INCREMENT,
			  pageview_date timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
			  lead_hashkey varchar(16) NOT NULL,
			  pageview_title varchar(255) NOT NULL,
			  pageview_url text NOT NULL,
			  pageview_source text NOT NULL,
			  pageview_session_start int(1) NOT NULL,
			  PRIMARY KEY  (pageview_id)
			) CHARACTER SET utf8 COLLATE utf8_general_ci;

			CREATE TABLE li_leads (
			  lead_id int(11) unsigned NOT NULL AUTO_INCREMENT,
			  lead_date timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
			  hashkey varchar(16) NOT NULL,
			  lead_ip varchar(40) NOT NULL,
			  lead_source text NOT NULL,
			  lead_email varchar(255) NOT NULL,
			  lead_status SET( 'lead', 'comment', 'subscribe' ) NOT NULL DEFAULT 'lead',
			  merged_hashkeys text NOT NULL,
			  PRIMARY KEY  (lead_id)
			) CHARACTER SET utf8 COLLATE utf8_general_ci;

			CREATE TABLE li_submissions (
			  form_id int(11) unsigned NOT NULL AUTO_INCREMENT,
			  form_date timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
			  form_hashkey varchar(16) NOT NULL,
			  lead_hashkey varchar(16) NOT NULL,
			  form_page_title varchar(255) NOT NULL,
			  form_page_url text NOT NULL,
			  form_fields text NOT NULL,
			  form_type SET( 'lead', 'comment', 'subscribe' ) NOT NULL DEFAULT 'lead',
			  PRIMARY KEY  (form_id)
			) CHARACTER SET utf8 COLLATE utf8_general_ci;";

		dbDelta($sql);

	    leadin_update_option("li_db_version", LEADIN_DB_VERSION);
	}

	/**
	 * Checks the stored database version against the current data version + updates if needed
	 */
	function leadin_update_check ()
	{
	    global $wpdb;
	    $li_options = get_option('leadin_options');

	    // 0.4.0 upgrade - Delete legacy db option version 0.4.0 (remove after beta is launched)
        if ( get_option('leadin_db_version') )
            delete_option('leadin_db_version');

		// 0.4.0 upgrade - Delete legacy options version 0.4.0 (remove after beta is launched)
        if ( $li_legacy_options = get_option('leadin_plugin_options') )
        {
        	leadin_update_option('li_email', $li_legacy_options['li_email']);
            delete_option('leadin_plugin_options');
        }

	    if ( $li_options['li_db_version'] != LEADIN_DB_VERSION )
	    {
	        $this->leadin_db_install();
	    }

	    // 0.4.2 upgrade - After the DB installation converts the set structure from contact to lead, update all the blank contacts = leads
    	$q = $wpdb->prepare("UPDATE li_leads SET lead_status = 'lead' WHERE lead_status = 'contact' OR lead_status = ''", "");
    	$wpdb->query($q);

    	// 0.4.2 upgrade - After the DB installation converts the set structure from contact to lead, update all the blank form_type = leads
    	$q = $wpdb->prepare("UPDATE li_submissions SET form_type = 'lead' WHERE form_type = 'contact' OR form_type = ''", "");
    	$wpdb->query($q);
	}

	//=============================================
	// Scripts & Styles
	//=============================================

	/**
	 * Adds front end javascript + initializes ajax object
	 */
	function add_leadin_frontend_scripts ()
	{
		if ( !is_admin() )
		{
			wp_register_script('leadin', LEADIN_PATH . '/frontend/js/leadin.js', array ('jquery'), false, true);
			wp_register_script('jquery.cookie', LEADIN_PATH . '/frontend/js/jquery.cookie.js', array ('jquery'), false, true);
			
			wp_enqueue_script('leadin');
			wp_enqueue_script('jquery.cookie');
			
			wp_localize_script('leadin', 'li_ajax', array('ajax_url' => admin_url('admin-ajax.php')));
		}
	}
}

//=============================================
// LeadIn Init
//=============================================

global $leadin_wp;
$leadin_wp = new WPLeadIn();

// Activate + install LeadIn
register_activation_hook( __FILE__, array(&$leadin_wp, 'add_leadin_defaults'));

// Deactivate LeadIn
register_deactivation_hook( __FILE__, array(&$leadin_wp, 'deactivate_leadin'));
?>