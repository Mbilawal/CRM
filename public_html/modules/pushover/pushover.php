<?php
defined('BASEPATH') or exit('No direct script access allowed');

/*
Module Name: Pushover
Description: Used to send instant Pushover Notifications
Version: 1.0.1
Author: Granulr Ltd
Author URI: https://granulr.uk
Requires at least: 2.3.*
*/

define('PUSHOVER', 'pushover');

// Setup our hooks
hooks()->add_action('admin_init', 'pushover_setup_init_menu_items');
hooks()->add_action('ticket_created', 'pushover_signal_new_ticket');
hooks()->add_action('after_ticket_reply_added', 'pushover_signal_new_ticket_reply');

/**
* Register activation module hook
*/
register_activation_hook(PUSHOVER, 'pushover_module_activation_hook');

function pushover_module_activation_hook()
{
    $CI = &get_instance();
    require_once(__DIR__ . '/install.php');
}

/**
* Register language files, must be registered if the module is using languages
*/
register_language_files(PUSHOVER, [PUSHOVER]);

/**
 * Init menu setup module menu items in setup in admin_init hook
 * @return null
 */
function pushover_setup_init_menu_items()
{
  /**
  * If the logged in user is administrator, add custom menu in Setup
  */
  if (is_admin()) {
    $CI = &get_instance();
    $CI->app_tabs->add_settings_tab('pushover', [
        'name'     => _l('settings_group_pushover'),
        'view'     => PUSHOVER.'/admin/settings/pushover_settings',
        'position' => 90,
    ]);
  }
}

/**
* Load the Pushover Class into the system
*/
if (!class_exists('Pushover')) {
  require(__DIR__ . '/vendor/Pushover.php');
}

/**
* Ran when a new ticket is created
*/
function pushover_signal_new_ticket( $id )
{
  $CI = &get_instance();
  $CI->load->library(PUSHOVER . '/' . 'pushover_module');
  $CI->pushover_module->send_new_ticket_alert($id);
}

/**
* Ran when there is a reply to a ticket
*/
function pushover_signal_new_ticket_reply( $data )
{
  $CI = &get_instance();
  $CI->load->library(PUSHOVER . '/' . 'pushover_module');
  $CI->pushover_module->send_update_ticket_alert($data);
}
