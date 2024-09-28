<?php

  add_action( 'wp_ajax_wqnew_entry', 'email_new_entry_callback_function' );
  add_action( 'wp_ajax_nopriv_wqnew_entry', 'email_new_entry_callback_function' );
  add_action( 'wp_ajax_wpedit_entry', 'email_edit_entry_callback_function' );
  add_action( 'wp_ajax_nopriv_wpedit_entry', 'email_edit_entry_callback_function' );
  add_action( 'wp_ajax_wpdelete_entry', 'email_delete_entry_callback_function' );
  add_action( 'wp_ajax_nopriv_wpdelete_entry', 'email_delete_entry_callback_function' );

  function email_new_entry_callback_function() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'email_custom_table';
    $wpdb->get_row( "SELECT * FROM $table_name WHERE `name` = '".$_POST['sender_name']."' AND `email` = '".$_POST['sender_email']."' AND `current_user_id` = '".get_current_user_id()."' ORDER BY `id` DESC" );
    if($wpdb->num_rows < 1) {
      $wpdb->insert($table_name, array(
        "name" => $_POST['sender_name'],
        "email" => $_POST['sender_email'],
        "current_user_id" => get_current_user_id()
      ));
  
      $response = array('message'=>'Data Has Inserted Successfully', 'rescode'=>200);
    } else {
      $response = array('message'=>'Data Has Already Exist', 'rescode'=>404);
    }
    echo json_encode($response);
    exit();
    wp_die();
  }
    
  function email_edit_entry_callback_function() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'email_custom_table';
    $wpdb->get_row( "SELECT * FROM $table_name WHERE `name` = '".$_POST['sender_name']."' AND `email` = '".$_POST['sender_email']."'AND `current_user_id` = '".get_current_user_id()."' AND `id`!='".$_POST['wqentryid']."' ORDER BY `id` DESC" );
    if($wpdb->num_rows < 1) {
      $wpdb->update( $table_name, array(
        "name" => $_POST['sender_name'],
        "email" => $_POST['sender_email'],
        "current_user_id" => get_current_user_id(),
      ), array('id' => $_POST['wqentryid']) );

      $response = array('message'=>'Data Has Updated Successfully', 'rescode'=>200);
    } else {
      $response = array('message'=>'Data Has Already Exist', 'rescode'=>404);
    }
    echo json_encode($response);
    exit();
    wp_die();
  }