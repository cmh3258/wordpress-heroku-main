var page_title = jQuery(document).find("title").text();
var page_url = window.location.href;
var page_referrer = document.referrer;
var form_saved = false;

// Work around for caching not rendering li_ajax via wp_localize_script
if ( typeof li_ajax == 'undefined' )
	var li_ajax = {"ajax_url":"http:\/\/localhost:8888\/wp-admin\/admin-ajax.php"};

jQuery(document).ready( function ( $ ) {

	var hashkey = $.cookie("li_hash");
	var li_submission_cookie = $.cookie("li_submission");

	// The submission didn't officially finish before the page refresh, so try it again
	if ( li_submission_cookie )
	{
		var submission_data = JSON.parse(li_submission_cookie);
		leadin_insert_form_submission(submission_data.submission_hash, submission_data.hashkey, submission_data.page_title, submission_data.page_url, submission_data.json_form_fields, submission_data.lead_email, submission_data.form_submission_type, function ( data ) {
			// Form was submitted successfully before page reload. Delete cookie for this submission
			$.removeCookie('li_submission', {path: "/", domain: ""});
		});
	}

	if ( !hashkey )
	{
		hashkey = Math.random().toString(36).slice(2);
		$.cookie("li_hash", hashkey, {path: "/", domain: ""});
		leadin_insert_lead(hashkey);
	}

	leadin_log_pageview(hashkey, page_title, page_url, page_referrer, $.cookie('li_last_visit'));

	var date = new Date();
	var current_time = date.getTime();
	date.setTime(date.getTime() + (60 * 60 * 1000));
	
	// The li_last_visit has expired, so check to see if this is a stale contact that has been merged
	if ( !$.cookie('li_last_visit') )
	{
		leadin_check_merged_contact(hashkey);
	}

	$.cookie("li_last_visit", current_time, {path: "/", domain: "", expires: date});

	// Submit event for adding a new submission activity to the CRM
	$('form input[type="submit"], form button, form input[type="image"]').on('click', function ( e ) {
		var $form = $(this).closest('form');
		leadin_submit_form($form, $);
    });
});

function leadin_submit_form ( $form, $, form_type )
{
	var $this = $form;

	var form_fields = [];
	var lead_email = '';
	var form_submission_type = ( form_type ? form_type : 'lead' );

	// Excludes hidden input fields + submit inputs
	$this.find('input[type!="submit"], textarea').not('input[type="hidden"], input[type="radio"], input[type="password"]').each( function ( index ) { 
		var $element = $(this);
		var $value = $element.val();

		if ( !$element.is(':visible' ) )
			return true; 

		// Check if input has an attached lable using for= tag
		var $label = $("label[for='" + $element.attr('id') + "']").text();
		
		// Check for label in same container immediately before input
		if ($label.length == 0) 
		{
			$label = $element.prev('label').not('.li_used').addClass('li_used').first().text();

			if ( !$label.length ) 
			{
				$label = $element.prevAll('b, strong, span').text(); // Find previous closest string
			}
		}

		// Check for label in same container immediately after input
		if ($label.length == 0) 
		{
			$label = $element.next('label').not('.li_used').addClass('li_used').first().text();

			if ( !$label.length ) 
			{
				$label = $element.nextAll('b, strong, span').text(); // Find next closest string
			}
		}

		// Checks the parent for a label or bold text
		if ($label.length == 0) 
		{
			$label = $element.parent().find('label, b, strong').not('.li_used').first().text();
		}

		// Checks the parent's parent for a label or bold text
		if ($label.length == 0) 
		{
			if ( $.contains($this, $element.parent().parent()) )
			{
				$label = $element.parent().parent().find('label, b, strong').first().text();
			}
		}

		// Looks for closests p tag parent, and looks for label inside
		if ( $label.length == 0 ) 
		{
			$p = $element.closest('p').not('.li_used').addClass('li_used');
			
			// This gets the text from the p tag parent if it exists
			if ( $p.length )
			{
				$label = $p.text();
				$label = $.trim($label.replace($value, "")); // Hack to exclude the textarea text from the label text
			}
		}

		// Check for placeholder attribute
		if ( $label.length == 0 )
		{
			if ( $element.attr('placeholder') !== undefined )
			{
				$label = $element.attr('placeholder').toString();
			}
		}

		if ( $label.length == 0 ) 
		{
			if ( $element.attr('name') !== undefined )
			{
				$label = $element.attr('name').toString();
			}
		}

		if ( $element.is(':checkbox') )
		{
			if ( $element.is(':checked')) 
			{
				$value = 'Checked';
			}
			else
			{
				$value = 'Not checked';
			}
		}

		var $label_text = $.trim($label.replaceArray(["(", ")", "required", "Required", "*", ":"], [""]));

		push_form_field($label_text, $value, form_fields);

		if ( $value.indexOf('@') != -1 && $value.indexOf('.') != -1 && !lead_email )
			lead_email = $value;
	});

	var radio_groups = [];
	var rbg_label_values = [];
	$this.find(":radio").each(function(){
		if ( $.inArray(this.name, radio_groups) == -1 )
	   		radio_groups.push(this.name);
	   		rbg_label_values.push($(this).val());
	});

	for ( var i = 0; i < radio_groups.length; i++ )
	{
		var $rbg = $("input:radio[name='" + radio_groups[i] + "']");
		var $rbg_value = $("input:radio[name='" + radio_groups[i] + "']:checked").val();

		if ( $this.find('.gfield').length ) // Hack for gravity forms
			$p = $rbg.closest('.gfield').not('.li_used').addClass('li_used');
		else if ( $this.find('.frm_form_field').length ) // Hack for Formidable
			$p = $rbg.closest('.frm_form_field').not('.li_used').addClass('li_used');
		else
			$p = $rbg.closest('div, p').not('.li_used').addClass('li_used');
		
		// This gets the text from the p tag parent if it exists
		if ( $p.length )
		{
			//$p.find('label, strong, span, b').html();
			$rbg_label = $p.text();
			$rbg_label = $.trim($rbg_label.replaceArray(rbg_label_values, [""]).replace($p.find('.gfield_description').text(), ''));
			// Remove .gfield_description from gravity forms
		}

		var rgb_selected = ( !$("input:radio[name='" + radio_groups[i] + "']:checked").val() ) ? 'not selected' : $("input:radio[name='" + radio_groups[i] + "']:checked").val();

		push_form_field($rbg_label, rgb_selected, form_fields);
	}

	$this.find('select').each( function ( ) {
		var $select = $(this);
		var $select_label = $("label[for='" + $select.attr('id') + "']").text();

		if ( !$select_label.length )
		{
			var select_values = [];
			$select.find("option").each(function(){
				if ( $.inArray($(this).val(), select_values) == -1 )
			   		select_values.push($(this).val());
			});

			$p = $select.closest('div, p').not('.li_used').addClass('li_used');

			if ( $this.find('.gfield').length ) // Hack for gravity forms
				$p = $select.closest('.gfield').not('.li_used').addClass('li_used');
			else
			{	
				$p = $select.closest('div, p').addClass('li_used');
			}

			if ( $p.length )
			{
				$select_label = $p.text();
				$select_label = $.trim($select_label.replaceArray(select_values, [""]).replace($p.find('.gfield_description').text(), ''));
			}
		}

		push_form_field($select_label, $select.val(), form_fields);
	});

	$this.find('.li_used').removeClass('li_used'); // Clean up added classes

	if ( $this.find('#comment_post_ID').length )
	{
		form_submission_type = 'comment';
	}

	// Save submission into database, send LeadIn email, and submit form as usual
	if ( lead_email )
	{		
		var submission_hash = Math.random().toString(36).slice(2);
		var hashkey = $.cookie("li_hash");
		var json_form_fields = JSON.stringify(form_fields);

		var form_submission = {};
		form_submission = {
			"submission_hash": submission_hash,
			"hashkey": hashkey,
			"lead_email": lead_email,
			"page_title": page_title,
			"page_url": page_url,
			"json_form_fields": json_form_fields,
			"form_submission_type": form_submission_type,
		};

		$.cookie("li_submission", JSON.stringify(form_submission), {path: "/", domain: ""});

		leadin_insert_form_submission(submission_hash, hashkey, page_title, page_url, json_form_fields, lead_email, form_submission_type, function ( data ) {
			// Form was executed 100% successfully before page reload. Delete cookie for this submission
			$.removeCookie('li_submission', {path: "/", domain: ""});
		});
	}
	else // No lead - submit form as usual
	{
		form_saved = true;
	}
}

function leadin_check_merged_contact ( hashkey )
{
	jQuery.ajax({
		type: 'POST',
		url: li_ajax.ajax_url,
		data: {
			"action": "leadin_check_merged_contact", 
			"li_id": hashkey
		},
		success: function(data){
			// Force override the current tracking with the merged value
			var json_data = jQuery.parseJSON(data);
			if ( json_data )
				jQuery.cookie("li_hash", json_data, {path: "/", domain: ""});
		},
		error: function ( error_data ) {
			//alert(error_data);
		}
	});
}

function leadin_check_visitor_status ( hashkey, callback )
{
	jQuery.ajax({
		type: 'POST',
		url: li_ajax.ajax_url,
		data: {
			"action": "leadin_check_visitor_status", 
			"li_id": hashkey
		},
		success: function(data){
			// Force override the current tracking with the merged value
			var json_data = jQuery.parseJSON(data);
			
			if ( callback )
				callback(json_data);
		},
		error: function ( error_data ) {
			//alert(error_data);
		}
	});
}

function leadin_log_pageview ( hashkey, page_title, page_url, page_referrer, last_visit )
{
	jQuery.ajax({
		type: 'POST',
		url: li_ajax.ajax_url,
		data: {
			"action": "leadin_log_pageview", 
			"li_id": hashkey,
			"li_title": page_title,
			"li_url": page_url,
			"li_referrer": page_referrer,
			"li_last_visit": last_visit
		},
		success: function(data){
		},
		error: function ( error_data ) {
			//alert(error_data);
		}
	});
}

function leadin_insert_lead ( hashkey ) {
	jQuery.ajax({
		type: 'POST',
		url: li_ajax.ajax_url,
		data: {
			"action": "leadin_insert_lead", 
			"li_id": hashkey
		},
		success: function(data){
		},
		error: function ( error_data ) {
			//alert(error_data);
		}
	});
}

function leadin_insert_form_submission ( submission_haskey, hashkey, page_title, page_url, json_fields, lead_email, form_submission_type, Callback )
{
	jQuery.ajax({
		type: 'POST',
		url: li_ajax.ajax_url,
		data: {
			"action": "leadin_insert_form_submission", 
			"li_submission_id": submission_haskey,
			"li_id": hashkey,
			"li_title": page_title,
			"li_url": page_url,
			"li_fields": json_fields,
			"li_email": lead_email,
			"li_submission_type": form_submission_type
		},
		success: function(data){
			if ( Callback )
				Callback(data);
		},
		error: function ( error_data ) {
			//alert(error_data);
		}
	});

}

function push_form_field ( label, value, form_fields )
{
	var field = {
	    label: label,
	    value: value
	};

	form_fields.push(field);
}

String.prototype.replaceArray = function(find, replace) {
  var replaceString = this;
  for (var i = 0; i < find.length; i++) {
  	if ( replace.length != 1 )
    	replaceString = replaceString.replace(find[i], replace[i]);	
    else
    	replaceString = replaceString.replace(find[i], replace[0]);	
  }
  return replaceString;
};