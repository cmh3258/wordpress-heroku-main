<?php
//=============================================
// LI_Contact Class
//=============================================
class LI_Contact {
	
	/**
	 * Variables
	 */
	var $hashkey;
	var $history;

	/**
	 * Class constructor
	 */
	function LI_Contact () {

	}

	/**
	 * Gets hashkey from lead id
	 *
	 * @param	int
	 * @return	string
	 */
	function set_hashkey_by_id ( $lead_id ) {
		global $wpdb;
		$q = $wpdb->prepare("SELECT hashkey FROM li_leads WHERE lead_id = %d", $lead_id);
		$this->hashkey = $wpdb->get_var($q);
		
		return $this->hashkey;
	}

	/**
	 * Gets contact history from the database (pageviews, form submissions, and lead details)
	 *
	 * @param	string
	 * @return	object 	$history (pageviews_by_session, submission, lead)
	 */
	function get_contact_history () {
		global $wpdb;

		// Get all page views
		$q = $wpdb->prepare("
			SELECT 
				pageview_id,
				pageview_date AS event_date,
				DATE_FORMAT(pageview_date, %s) AS pageview_day, 
				DATE_FORMAT(pageview_date, %s) AS pageview_date, 
				lead_hashkey, pageview_title, pageview_url, pageview_source, pageview_session_start 
			FROM 
				li_pageviews 
			WHERE 
				lead_hashkey LIKE %s ORDER BY event_date DESC", '%b %D', '%b %D %l:%i%p', $this->hashkey);

		$pageviews = $wpdb->get_results($q, ARRAY_A);

		// Get all submissions
		$q = $wpdb->prepare("
			SELECT 
				form_date AS event_date, 
				DATE_FORMAT(form_date, %s) AS form_date, 
				form_page_title, 
				form_page_url, 
				form_fields, 
				form_type 
			FROM 
				li_submissions 
			WHERE 
				lead_hashkey = '%s' ORDER BY event_date DESC", '%b %D %l:%i%p', $this->hashkey);
		
		$submissions = $wpdb->get_results($q, ARRAY_A);

		$events_array = array_merge($pageviews, $submissions); 
		
		usort($events_array, array('LI_Contact','sort_by_event_date'));
		
		$sessions = array();
		$cur_array = '0';
		$first_iteration = TRUE;
		$count = 0;
		$cur_event = 0;
		$prev_form_event = FALSE;

		foreach ( $events_array as $event_name => $event )
		{
			// Create a new session array if pageview started a new session
			if ( (isset($event['pageview_session_start']) && $event['pageview_session_start'] ) || $first_iteration )
			{
				$cur_array = $count;
				$sessions['session_' . $cur_array] = array();
				$sessions['session_' . $cur_array]['session_date'] = $event['event_date']; 
				$sessions['session_' . $cur_array]['events'] = array();

				if ( $first_iteration )
					$first_iteration = FALSE;

				$cur_event = $count;
				$sessions['session_' . $cur_array]['events']['event_' . $cur_event] = array();
				$sessions['session_' . $cur_array]['events']['event_' . $cur_event]['event_type'] = 'visit';
				$sessions['session_' . $cur_array]['events']['event_' . $cur_event]['event_date'] = $event['event_date'];
			}

			// Pageview activity
			if ( !isset($event['form_fields']) )
			{
				if ( $prev_form_event && !$event['pageview_session_start'] )
				{
					$prev_form_event = FALSE;
					$cur_event = $count;
					$sessions['session_' . $cur_array]['events']['event_' . $cur_event] = array();
					$sessions['session_' . $cur_array]['events']['event_' . $cur_event]['event_type'] = 'visit';
					$sessions['session_' . $cur_array]['events']['event_' . $cur_event]['event_date'] = $event['event_date'];
				}

				$sessions['session_' . $cur_array]['events']['event_' . $cur_event]['activities'][] = $event;
			}
			else
			{
				$cur_event = $count;
				$sessions['session_' . $cur_array]['events']['event_' . $cur_event] = array();
				$sessions['session_' . $cur_array]['events']['event_' . $cur_event]['event_type'] = 'form';
				$sessions['session_' . $cur_array]['events']['event_' . $cur_event]['event_date'] = $event['event_date'];
				$sessions['session_' . $cur_array]['events']['event_' . $cur_event]['activities'][] = $event;
				$prev_form_event = TRUE;
			}

			$count++;
		}

		// Get the lead details
		$q = $wpdb->prepare("
			SELECT 
				DATE_FORMAT(lead_date, %s) AS lead_date, 
				lead_ip, 
				lead_source, 
				lead_email, 
				lead_status 
			FROM 
				li_leads 
			WHERE hashkey LIKE %s", '%b %D %l:%i%p', $this->hashkey);
		
		$lead = $wpdb->get_row($q);
		$lead->lead_status = $this->frontend_lead_status($lead->lead_status);

		$this->history = (object)NULL;
		$this->history->sessions = $sessions;
		//$this->history->submissions = $submissions;
		//$this->history->events = $events;
		$this->history->lead = $lead;

		return $this->history;
	}

	/**
	 * usort helper function to sort array by event date
	 *
	 * @param	string
	 * @return	array
	 */
	function sort_by_event_date ( $a, $b ) {
		return $a['event_date'] > $b['event_date'];
	}

	/**
	 * Normalizes li_leads.lead_status for front end display
	 *
	 * @param	string
	 * @return	string
	 */
	function frontend_lead_status ( $lead_status = 'lead' ) {
		if ( $lead_status == 'lead' )
			return 'Lead';
		else if ( $lead_status == 'comment' )
			return 'Commenter';
		else
			return 'Subscriber';
	}
}
?>