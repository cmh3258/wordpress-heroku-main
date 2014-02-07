<?php

if ( !defined('LEADIN_PLUGIN_VERSION') ) 
{
    header('HTTP/1.0 403 Forbidden');
    die;
}

//=============================================
// Include Needed Files
//=============================================

if ( !class_exists('LI_List_Table') )
    require_once LEADIN_PLUGIN_DIR . '/admin/inc/class-leadin-list-table.php';

if ( !class_exists('LI_Contact') )
    require_once LEADIN_PLUGIN_DIR . '/admin/inc/class-leadin-contact.php';

if ( !class_exists('LI_Pointers') )
    require_once LEADIN_PLUGIN_DIR . '/admin/inc/class-leadin-pointers.php';

include_once(ABSPATH . 'wp-admin/includes/plugin.php');

//=============================================
// WPLeadInAdmin Class
//=============================================
class WPLeadinAdmin {
    
    /**
     * Class constructor
     */
    function __construct ()
    {
        //=============================================
        // Hooks & Filters
        //=============================================

        if( is_admin() )
        {
            add_action('admin_menu', array(&$this, 'leadin_add_menu_items'));
            add_action('admin_init', array(&$this, 'leadin_build_settings_page'));
            add_action('admin_print_styles', array(&$this, 'add_leadin_admin_styles'));
            add_action('admin_print_scripts', array(&$this, 'add_leadin_admin_scripts'));
        }
    }
    
    //=============================================
    // Menus
    //=============================================

    /**
     * Adds LeadIn menu to /wp-admin sidebar
     */
    function leadin_add_menu_items ()
    {
        global $submenu;

        add_menu_page('LeadIn', 'LeadIn', 'activate_plugins', 'leadin_leads', array(&$this, 'leadin_contacts_page'), LEADIN_PATH . '/images/leadin-icon-32x32.png');
        add_submenu_page('leadin_leads', 'Settings', 'Settings', 'activate_plugins', 'leadin_menu', array(&$this, 'leadin_plugin_options'));
        
        $submenu['leadin_leads'][0][0] = 'Contacts';       
    }

    //=============================================
    // Settings Page
    //=============================================

    /**
     * Adds setting link for LeadIn to plugins management page 
     *
     * @param   array $links
     * @return  array
     */
    function leadin_plugin_settings_link ( $links )
    {
       $url = get_admin_url() . 'admin.php?page=leadin_menu';
       $settings_link = '<a href="' . $url . '">Settings</a>';
       array_unshift($links, $settings_link);
       return $links;
    }

    /**
     * Creates settings options
     */
    function leadin_build_settings_page ()
    {
        // Show the settings popup on all pages except the settings page
        if ( !isset ($_GET['page']) || $_GET['page'] != 'leadin_menu' )
        {
            $options = get_option('leadin_options');
            if ( !isset($options['ignore_settings_popup']) )
                $li_pointers = new LI_Pointers();
        }

        add_settings_section('main_section', '', '', __FILE__);
        add_settings_field('li_email', 'Email', array(&$this, 'leadin_setting_email_fn'), __FILE__, 'main_section');
        register_setting('leadin_settings_options', 'leadin_options', array(&$this, 'validate_leadin_plugin_options'));
    }

    /**
     * Creates settings page
     */
    function leadin_plugin_options ()
    {
        global  $wp_version;
        
        if ( !current_user_can( 'manage_options' ) )
        {
            wp_die(__('You do not have sufficient permissions to access this page.'));
        }

        // Update the settings popup flag when the settings page is visited for the first time
        $options = get_option('leadin_options');
        if ( !isset($options['ignore_settings_popup']) )
            leadin_update_option('ignore_settings_popup', 1);

        ?>
        
        <?php echo '<div id="leadin" class="wrap '. ( $wp_version < 3.8 && !is_plugin_active('mp6/mp6.php') ? 'pre-mp6' : ''). '">'; ?>
            <div class="dashboard-widgets-wrap">
                <?php $this->leadin_header('LeadIn Settings'); ?>

                <div id="dashboard-widgets" class="metabox-holder">
                    <div class="postbox-container" style="width:100%;">
                        <div class="meta-box-sortables ui-sortable" style="margin-left: 0px;">
                            <?php 
                            $postbox_title = 'Setup';
                            $faq_content = 
                                "The plugin is <span style='color: #090; font-weight: bold;'>installed and enabled</span>.
                                <p>LeadIn automatically hooks into your contact forms and doesn't require any setup.</p>
                                <p>Whenever a visitor fills out a form on your WordPress site with an email address, LeadIn sends you an email with the contact's referral source, page view history and social media avatar.</p>
                                <p>All of your visitor's form submissions are stored in your <a href='/wp-admin/admin.php?page=leadin_leads'>LeadIn Contacts</a>.</p>";
                            ?>

                            <?php echo $this->leadin_postbox('leadin-settings-faq', $postbox_title, $faq_content, FALSE); ?>
                        </div>
                    </div>
                    <div class="postbox-container" style="width:100%;">
                        <div class="postbox-container" style="width:100%;">
                            <form method="post" action="options.php">
                                <?php settings_fields('leadin_settings_options'); ?>
                                <?php do_settings_sections(__FILE__); ?>
                                <p class="submit">
                                    <input type="submit" name="submit" id="submit" class="button button-primary" value="<?php esc_attr_e('Save Settings'); ?>">
                                </p>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php
    }

    /**
     * Validates settings inputs
     * @param callback
     */
    function validate_leadin_plugin_options ( $input )
    {
        // Check our textbox option field contains no HTML tags - if so strip them out
        $input['li_email'] =  wp_filter_nohtml_kses($input['li_email']);    
        return $input; // return validated input
    }

    /**
     * Prints email input for settings page
     */
    function leadin_setting_email_fn ()
    {
        $options = get_option('leadin_options');
        $li_email = ( $options['li_email'] ? $options['li_email'] : get_bloginfo('admin_email') ); // Get email from plugin settings, if none set, use admin email
        
        echo "<input id='li_email' placeholder='Email address' name='leadin_options[li_email]' size='40' type='text' value='" . $li_email . "'/>";
        echo "<br/><span class='description'>Separate multiple emails with commas</span>";
    }

    //=============================================
    // Contacts Page
    //=============================================

    /**
     * Shared functionality between contact views 
     */
    function leadin_contacts_page ()
    {
        global  $wp_version;

        $options = get_option('leadin_options');
        if ( !isset($options['ignore_settings_popup']) )
            $li_pointers = new LI_Pointers();

        $action = $this->leadin_current_action();
        if ( $action == 'delete' )
        {
            $lead_id = ( isset($_GET['lead']) ? absint($_GET['lead']) : FALSE );
            $this->delete_lead($lead_id);
        }

        echo '<div id="leadin" class="wrap '. ( $wp_version < 3.8 && !is_plugin_active('mp6/mp6.php')  ? 'pre-mp6' : ''). '">';

            if ( $action != 'view' )
                $this->leadin_render_list_page();
            else
                $this->leadin_render_contact_detail($_GET['lead']);

        echo '</div>';
    }

    /**
     * GET and set url actions into readable strings
     * @return string if actions are set,   bool if no actions set
     */
    function leadin_current_action ()
    {
        if ( isset($_REQUEST['action']) && -1 != $_REQUEST['action'] )
            return $_REQUEST['action'];

        if ( isset($_REQUEST['action2']) && -1 != $_REQUEST['action2'] )
            return $_REQUEST['action2'];

        return FALSE;
    }

    /**
     * Creates view a contact's deteails + timeline history
     *
     * @param   int
     */
    function leadin_render_contact_detail ( $lead_id )
    {
        $li_contact = new LI_Contact();
        $li_contact->set_hashkey_by_id($lead_id);
        $li_contact->get_contact_history();
        
        $lead_email = $li_contact->history->lead->lead_email;

        echo '<a href="/wp-admin/admin.php?page=leadin_leads">&larr; All Contacts</a>';

        echo '<div class="header-wrap">';
            echo '<img height="40px" width="40px" src="https://app.getsignals.com/avatar/image/?emails=' . $lead_email . '" />';
            echo '<h1 class="contact-name">' . $lead_email . '</h1>';
        echo '</div>';
        
        echo '<div id="col-container">';
            
            echo '<div id="col-right">';
            echo '<div class="col-wrap">';
                echo '<h2>Recent Activity</h2>';
                echo '<ul class="contact-history">';
                $sessions = array_reverse($li_contact->history->sessions);
                foreach ( $sessions as &$session )
                {
                    $first_event = array_values($session['events']);
                    $first_event_date = $first_event[0]['activities'][0]['event_date'];
                    $session_date = date('M j', strtotime($first_event_date));
                    $session_start_time = date('g:i a', strtotime($first_event_date));

                    $last_event = end($session['events']);
                    $last_activity = end($last_event['activities']);
                    $session_end_time = date('g:i a', strtotime($last_activity['event_date']));

                    if ( $session_end_time != $session_start_time )
                        $session_time_range = $session_start_time . ' - ' . $session_end_time;
                    else
                        $session_time_range = $session_start_time;

                    echo '<li class="session">';
                    echo '<p class="session-date">' . $session_date . '<span class="event-time-range">' . $session_time_range . '</span></p>';

                    echo '<ul class="events">';

                    $events = $session['events'];
                    foreach ( $events as &$event )
                    {
                        if ( $event['event_type'] == 'visit' )
                        {
                            $num_pageviews = count($event['activities']);
                            
                            $event_start_time = date('g:i a', strtotime($event['event_date']));
                            $last_event = end($event['activities']);
                            $event_end_time = date('g:i a', strtotime($last_event['event_date']));

                            if ( $event_start_time != $event_end_time )
                                $event_time_range = $event_start_time . ' - ' . $event_end_time;
                            else
                                $event_time_range = $event_start_time;

                            $activities = array_reverse($event['activities']);

                            echo '<li class="event visit">';
                                echo '<h3 class="event-title">Visited ' . $num_pageviews . ( $num_pageviews != 1 ? ' website pages' : ' website page' ) . '<span class="event-time-range">' . $event_time_range . '</span></h3>';
                                echo '<ul class="event-detail pageviews">';

                                echo '<li class="visit-source">';
                                echo '<p><strong>Source:</strong> ' . ( $activities[0]['pageview_source'] ? $activities[0]['pageview_source'] : 'Direct' ) . '</p>';
                                echo '</li>'; 
                               
                                foreach ( $activities as $pageview )
                                {
                                    echo '<li class="pageview">';
                                        echo '<a href="' . $pageview['pageview_url'] . '">' . $pageview['pageview_title'] . '</a>';
                                        echo '<p class="pageview-url">' . $pageview['pageview_url'] . '</p>';
                                    echo '</li>'; 
                                }
                                echo '</ul>';
                            echo '</li>';
                        }
                        else if ( $event['event_type'] == 'form' )
                        {
                            $submission = $event['activities'][0];

                            $form_fields = json_decode(stripslashes($submission['form_fields']));
                            $num_form_fieds = count($form_fields);
                            
                            echo '<li class="event form-submission">';
                                echo '<h3 class="event-title">Filled out form on page <a href="' . $submission['form_page_url'] . '">' . $submission['form_page_title']  . '</a> <small>with ' . $num_form_fieds . ( $num_form_fieds != 1 ? ' form fields' : ' form field') . '</small><span class="event-time-range">' . date('g:ia', strtotime($submission['event_date'])) . '</span></h3>';
                                echo '<ul class="event-detail fields">';
                                foreach ( $form_fields as $field )
                                {
                                    echo '<li class="field">';
                                        echo '<label class="field-label">' . $field->label . ':</label>';
                                        echo '<p class="field-value">' . $field->value . '</p>';
                                    echo '</li>';
                                }
                                echo '</ul>';
                            echo '</li>';
                        }
                    }
                    echo '</ul>';
                    echo '</li>';
                }
                echo '</ul>';
            echo '</div>';
            echo '</div>';

            echo '<div id="col-left" class="metabox-holder">';
            echo '<div class="col-wrap">';
                echo '<div class="contact-info postbox">';
                    echo '<h3>Contact Information</h3>';
                    echo '<div class="inside">';
                        echo '<p><label>Email:</label> <a href="mailto:' . $lead_email . '">' . $lead_email . '</a></p>';
                        echo '<p><label>Status:</label> ' . $li_contact->history->lead->lead_status . '</p>';
                        echo '<p><label>Original referrer:</label> <a href="' . $li_contact->history->lead->lead_source . '">' . $li_contact->history->lead->lead_source . '</a></p>';
                    echo '</div>';
                echo '</div>';
            echo '</div>';
            echo '</div>';

        echo '</div>';
    }


    /**
     * Creates list table for Contacts page
     *
     */
    function leadin_render_list_page ()
    {
        global $wp_version;

        //Create an instance of our package class...
        $leadinListTable = new LI_List_table();
        
        //Fetch, prepare, sort, and filter our data...
        $leadinListTable->data = $leadinListTable->get_leads();
        $leadinListTable->prepare_items();

        ?>
       <div id="leadin" class="wrap <?php echo ( $wp_version < 3.8 && !is_plugin_active('mp6/mp6.php') ? 'pre-mp6' : ''); ?>">
            
            <?php 
                $this->leadin_header('Contacts');

                $current_view = $leadinListTable->get_view();

                if ( $current_view == 'lead' )
                    $view_label = 'Leads';
                else if ( $current_view == 'comment' )
                    $view_label = 'Commenters';
                else if ( $current_view == 'subscribe' )
                    $view_label = 'Subscribers';
                else
                    $view_label = 'Contacts';
            ?>

            <!-- Forms are NOT created automatically, so you need to wrap the table in one to use features like bulk actions -->
            <form id="leadin-contacts" method="GET">
                <?php $leadinListTable->views(); ?>
                
                <!-- For plugins, we also need to ensure that the form posts back to our current page -->
                <input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>" />
                
                <!-- Now we can render the completed list table -->
                <?php $leadinListTable->display() ?>
            </form>

            <form id="export-form" name="export-form" method="POST">
                <p class="submit">
                    <?php if ( !isset($_GET['contact_type']) ) : ?>
                        <input type="submit" value="<?php esc_attr_e('Export All Contacts'); ?>" name="export-all" id="leadin-export-leads" class="button button-primary">
                    <?php endif; ?>
                    <input type="submit" value="<?php esc_attr_e('Export Selected ' . $view_label ); ?>" name="export-selected" id="leadin-export-selected-leads" class="button button-primary" disabled>
                    <input type="hidden" id="leadin-selected-contacts" name="leadin-selected-contacts" value=""/>
                </p>
            </form>
        </div>
        <?php
    }

    /**
     * Deletes all rows from li_leads, li_pageviews and li_submissions for a given lead
     *
     * @param   int
     * @return  bool
     */
    function delete_lead ( $lead_id )
    {
        global $wpdb;

        $q = $wpdb->prepare("SELECT hashkey FROM li_leads WHERE lead_id = %d", $lead_id);
        $lead_hash = $wpdb->get_var($q);

        $q = $wpdb->prepare("DELETE FROM li_pageviews WHERE lead_hashkey = %s", $lead_hash);
        $delete_pageviews = $wpdb->query($q);

        $q = $wpdb->prepare("DELETE FROM li_submissions WHERE lead_hashkey = %s", $lead_hash);
        $delete_submissions = $wpdb->query($q);

        $q = $wpdb->prepare("DELETE FROM li_leads WHERE lead_id = %d", $lead_id);
        $delete_lead = $wpdb->query($q);

        return $delete_lead;
    }

    //=============================================
    // Admin Styles & Scripts
    //=============================================

    /**
     * Adds admin style sheets
     */
    function add_leadin_admin_styles ()
    {
        wp_register_style('leadin-admin-css', LEADIN_PATH . '/admin/css/leadin-admin.css');
        wp_enqueue_style('leadin-admin-css');
    }

    /**
     * Adds admin javascript
     */
    function add_leadin_admin_scripts ()
    {
        global $pagenow;

        if ( $pagenow == 'admin.php' && isset($_GET['page']) && strstr($_GET['page'], "leadin") ) 
        {
            wp_register_script('leadin-admin-js', LEADIN_PATH . '/admin/js/leadin-admin.js', array ( 'jquery' ), FALSE, TRUE);
            wp_enqueue_script('leadin-admin-js');
        }
    }

    //=============================================
    // Internal Class Functions
    //=============================================

    /**
     * Creates postbox for admin
     * @param string
     * @param string
     * @param string
     * @param bool
     * @return string   HTML for postbox
     */
    function leadin_postbox ( $id, $title, $content, $handle = TRUE )
    {
        $postbox_wrap = "";
        $postbox_wrap .= '<div id="' . $id . '" class="postbox leadin-admin-postbox">';
        $postbox_wrap .= ( $handle ? '<div class="handlediv" title="Click to toggle"><br /></div>' : '' );
        $postbox_wrap .= '<h3><span>' . $title . '</span></h3>';
        $postbox_wrap .= '<div class="inside">' . $content . '</div>';
        $postbox_wrap .= '</div>';
        return $postbox_wrap;
    }

    /**
     * Prints the admin page title, icon and help notification
     * @param string
     */
    function leadin_header ( $page_title = '' )
    {
        ?>
        <?php screen_icon('leadin'); ?>
        <h2><?php echo $page_title; ?></h2>
        <p class="notification help-notification">If you have any questions, feedback or issues with LeadIn, please contact us anytime - <a href="mailto:support@leadin.com">support@leadin.com</a></p>

        <?php if ( isset($_GET['settings-updated']) ) : ?>
            <div id="message" class="updated">
                <p><strong><?php _e('Settings saved.') ?></strong></p>
            </div>
        <?php endif;
    }
}

/** Export functionality for the contacts list */
if ( isset($_POST['export-all']) || isset($_POST['export-selected']) )
{
    global $wpdb;

    $sitename = sanitize_key(get_bloginfo('name'));
    
    if ( ! empty($sitename) )
        $sitename .= '.';
    
    $filename = $sitename . '.contacts.' . date('Y-m-d-H-i-s') . '.csv';

    header('Content-Description: File Transfer');
    header('Content-Disposition: attachment; filename=' . $filename);
    header('Content-Type: text/csv; charset=' . get_option('blog_charset'), TRUE);

    $column_headers = array(
        'Email', 'Original source', 'Status', 'Visits', 'Page views', 'Forms',  'Last visit', 'Created on'
    );

    $fields = array(
        'lead_email', 'lead_source', 'lead_status', 'lead_visits', 'lead_pageviews', 'lead_form_submissions', 'last_visit', 'lead_date'
    );

    $headers = array();
    foreach ( $column_headers as $key => $field )
    {
            $headers[] = '"' . $field . '"';
    }
    echo implode(',', $headers) . "\n";

    $q = $wpdb->prepare("
        SELECT 
            l.lead_id, LOWER(DATE_FORMAT(l.lead_date, %s)) AS lead_date, l.lead_ip, l.lead_source, l.lead_email, l.lead_status,
            COUNT(DISTINCT s.form_id) AS lead_form_submissions,
            COUNT(DISTINCT p.pageview_id) AS lead_pageviews,
            (SELECT COUNT(DISTINCT p.pageview_id) FROM li_pageviews p WHERE l.hashkey = p.lead_hashkey AND p.pageview_session_start = 1) AS lead_visits,
            LOWER(DATE_FORMAT(MAX(p.pageview_date), %s)) AS last_visit
        FROM li_leads l
        LEFT JOIN li_submissions s ON l.hashkey = s.lead_hashkey
        LEFT JOIN li_pageviews p ON l.hashkey = p.lead_hashkey 
        WHERE l.lead_email != '' " .
        ( isset ($_POST['export-selected']) ? " AND l.lead_id IN ( " . $_POST['leadin-selected-contacts'] . " ) " : "" ) .
        "GROUP BY l.lead_email ORDER BY l.lead_date DESC", '%Y/%m/%d %l:%i%p', '%Y/%m/%d %l:%i%p');

    $leads = $wpdb->get_results($q);

    foreach ( $leads as $contacts )
    {
        $data = array();
        foreach ( $fields as $field )
        {
            $value = ( isset($contacts->{$field}) ? $contacts->{$field} : '' );
            $value = ( is_array($value) ? serialize($value) : $value );
            $data[] = '"' . str_replace('"', '""', $value) . '"';
        }
        echo implode(',', $data) . "\n";
    }

    exit;
}

?>
