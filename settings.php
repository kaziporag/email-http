<?php 

class HTTP_API_Settings {

    private $table_name;

    /**
     * Plugin settings
     */
    public function __construct() {

        global $wpdb;
        $this->table_name = $wpdb->prefix . 'email_custom_table'; //wp_email_custom_table
        add_action( 'admin_menu', array( $this, 'add_menu_pages' ) );
        add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_styles' ) );
        
        require_once SENDER_INFO_PATH . '/ajax/ajax_action.php';

    }

    /**
     * Add menu pages
     */
    public function add_menu_pages() {
        
        add_submenu_page(
            'email-http',
            'Settings',
            'Settings',
            'manage_options',
            'http-api-settings',
            array( $this, 'http_api_settings_page' )
        );

    }

    function um_my_custom_ajax_get_members_data( $data_array, $user_id, $directory_data ) {
        $user_obj = get_userdata( $user_id );
        if ( false === $user_obj ) {
            return $data_array;
        }
        $data_array['nicename'] = $user_obj->user_nicename;
        return $data_array;
    }
    
    /**
     * Enqueue styles
     */
    public function enqueue_styles( $hook ) {
        if ( strpos( $hook, 'http-api-settings' ) !== false ) {
            wp_enqueue_style( 'email-http-style', SENDER_INFO_URL . 'css/form.css', array(), '1.0' );
            wp_enqueue_script( 'email_dps_script_a', SENDER_INFO_URL. 'js/email-custom.js' );
            wp_enqueue_script( 'email_dps_script_b', SENDER_INFO_URL. 'js/jQuery.min.js' );
            wp_localize_script( 'email_dps_script_a', 'email_dps_ajax_object', array( 'ajaxurl' => admin_url('admin-ajax.php') ));
        }
    }

    public function http_api_settings_page() {
        ?>
        <div class="wrap">
            
            <?php
                global $wpdb;
                $curr_user = get_current_user_id();
                $data = $wpdb->get_row( "SELECT * FROM $this->table_name WHERE current_user_id = '$curr_user'" );
                if(isset($data->id) && $data->id!='') { 
            ?>
            <h1>Reply-to Sender Edit Info</h1>
            <form id="sender_edit_form" name="sender_edit_form">
                <input type="hidden" name="wqentryid" id="wqentryid" value="<?=$data->id?>" />
                <p>
                    <label for="sender-name">Reply-to Name:</label>
                    <input type="text" id="sender_name" name="sender_name" placeholder="Your Name" value="<?=$data->name?>" required>
                    <div id="sender_name_message" class="wqmessage"></div>
                </p>
                <p>
                    <label for="sender-email">Reply-to Email:</label>
                    <input type="email" id="sender_email" name="sender_email" placeholder="Your Email" value="<?=$data->email?>" required>
                    <div id="sender_email_message" class="wqmessage"></div>
                </p>
                <p>
                    <input type="submit" class="wqsubmit_button button button-primary" value="Edit Info">
                    <div class="wqsubmit_message"></div>
                </p>
            </form>
            <?php
                } else {
            ?>
            <h1>Sender Add Info</h1>
            <form id="sender_info_form" name="sender_info_form">
                <input type="hidden" name="current_user_id" id="current_user_id" value="<?=$curr_user?>" />
                <p>
                    <label for="sender-name">Sender Name:</label>
                    <input type="text" id="sender_name" name="sender_name" placeholder="Your Name" required>
                    <div id="sender_name_message" class="wqmessage"></div>
                </p>
                <p>
                    <label for="sender-email">Sender Email:</label>
                    <input type="email" id="sender_email" name="sender_email" placeholder="Your Email" required>
                    <div id="sender_email_message" class="wqmessage"></div>
                </p>
                <p>
                    <input type="submit" class="wqsubmit_button button button-primary" value="Save Info">
                    <div class="wqsubmit_message"></div>
                </p>
            </form>
            <?php
                }
            ?>
        </div>
        <?php
    }
}