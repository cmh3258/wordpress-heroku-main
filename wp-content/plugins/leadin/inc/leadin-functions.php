<?php

if ( !defined('LEADIN_PLUGIN_VERSION') ) 
{
	header('HTTP/1.0 403 Forbidden');
	die;
}

/**
 * Looks for a GET/POST value and echos if present. If nothing is set, echos blank
 *
 * @param	string
 * @return	null
 */
function print_submission_val ( $url_param ) 
{
	if ( isset($_GET[$url_param]) ) 
	{
		echo $_GET[$url_param];
		return;
	}

	if ( isset($_POST[$url_param]) )
	{
		echo $_POST[$url_param];
		return;
	}
}

/**
 * Updates an option in the li_plugin_options array
 *
 * @param	string
 * @param	string
 * @return	bool 			True if option value has changed, false if not or if update failed.
 */
function leadin_update_option ( $option_key, $new_value ) 
{
	//Get entire options array
	$li_options = get_option('leadin_options');

	//Alter the options array appropriately
	$li_options[$option_key] = $new_value;

	//Update entire array
	return update_option('leadin_options', $li_options);
}

/**
 * Prints a number with a singular or plural label depending on number
 *
 * @param	int
 * @param	string
 * @param	string
 * @return	string 
 */
function leadin_single_plural_label ( $number, $singular_label, $plural_label ) 
{
	//Set number = 0 when the variable is blank
	$number = ( !is_numeric($number) ? 0 : $number );

	return ( $number != 1 ? $number . " $plural_label" : $number . " $singular_label" );
}

/**
 * Send email to LeadIn team when plugin is activated/deactivated
 *
 * @param	bool
 *
 * @return 	array
 */
function leadin_track_plugin_registration_hook ( $activated )
{
	global $wp_version;
	global $current_user;
	get_currentuserinfo();

    $response = wp_remote_post( 'http://leadin.com/stats/track.php', array(
		'method' => 'POST',
		'timeout' => 45,
		'redirection' => 5,
		'httpversion' => '1.0',
		'blocking' => true,
		'body' => array( 
			'access_token' => 'HlVAZezhMWN715H7WLdG', 
			'api_key' => md5(get_bloginfo('wpurl')),
			'action' => ( $activated ? 'activation' : 'deactivation' ),
			'wpurl' => get_bloginfo('wpurl'),
			'leadin_version' => LEADIN_PLUGIN_VERSION,
			'wp_version' => $wp_version,
			'user_email' => $current_user->user_email,
			'user_fullname' => $current_user->user_firstname,
			'user_display' => $current_user->display_name
		)
	));

	return $response;
}

/**
 * Track plugin activity metrics
 *
 * @param	string
 *
 * @return 	array
 */
function leadin_track_plugin_activity ( $activity_desc )
{
	global $wp_version;
	global $current_user;
	get_currentuserinfo();

    $response = wp_remote_post( 'http://leadin.com/stats/track.php', array(
		'method' => 'POST',
		'timeout' => 45,
		'redirection' => 5,
		'httpversion' => '1.0',
		'blocking' => true,
		'body' => array( 
			'access_token' => 'HlVAZezhMWN715H7WLdG', 
			'api_key' => md5(get_bloginfo('wpurl')),
			'action' => 'log_activity',
			'wpurl' => get_bloginfo('wpurl'),
			'leadin_version' => LEADIN_PLUGIN_VERSION,
			'wp_version' => $wp_version,
			'activity_desc' => $activity_desc
		)
	));

    return $response;
}

/**
 * Logs a debug statement to /wp-content/debug.log
 *
 * @param	string
 */
function leadin_log_debug ( $message )
{
	if ( WP_DEBUG === TRUE )
	{
		if ( is_array($message) || is_object($message) )
			error_log(print_r($message, TRUE));
		else 
			error_log($message);
	}
}

/**
 * Deletes an element or elements from an array
 *
 * @param	array
 * @param	wildcard
 * @return	array
 */
function leadin_array_delete ( $array, $element )
{
	if ( !is_array($element) )
		$element = array($element);

    return array_diff($array, $element);
}

/**
 * Deletes an element or elements from an array
 *
 * @param	array
 * @param	wildcard
 * @return	array
 */
function leadin_get_value_by_key ( $key_value, $array )
{
    foreach ( $array as $key => $value )
    {
        if ( is_array($value) && $value['label'] == $key_value )
        	return $value['value'];
    }

    return null;
}
?>