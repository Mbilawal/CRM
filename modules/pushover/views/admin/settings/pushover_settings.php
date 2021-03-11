<?php
defined('BASEPATH') or exit('No direct script access allowed');

// Pushover Priorities
$priorities = [
  [ 'priorityid' => 'p0',  'name'  =>  _l('pushover_priority_default') ],
  [ 'priorityid' => 'p-2', 'name' => _l('pushover_priority_lowest') ],
  [ 'priorityid' => 'p-1', 'name' => _l('pushover_priority_low') ],
  [ 'priorityid' => 'p1',  'name'  =>  _l('pushover_priority_high') ],
];

// Pushover Sounds
$sounds = [
  [ 'soundid' => 'pushover', 'name' => 'Pushover' ],
  [ 'soundid' => 'bike', 'name' => 'Bike' ],
  [ 'soundid' => 'bugle', 'name'=> 'bugle' ],
  [ 'soundid' => 'cashregister', 'name' => 'Cash Register' ],
  [ 'soundid' => 'classical', 'name' => 'classical' ],
  [ 'soundid' => 'cosmic', 'name' => 'cosmic' ],
  [ 'soundid' => 'falling', 'name' => 'falling' ],
  [ 'soundid' => 'gamelan', 'name' => 'Gamelan' ],
  [ 'soundid' => 'incoming', 'name' => 'Incoming' ],
  [ 'soundid' => 'intermission', 'name' => 'Intermission' ],
  [ 'soundid' => 'magic', 'name' => 'Magic' ],
  [ 'soundid' => 'mechanical', 'name' => 'Mechanical' ],
  [ 'soundid' => 'pianobar', 'name' => 'Piano Bar' ],
  [ 'soundid' => 'siren', 'name' => 'Siren' ],
  [ 'soundid' => 'spacealarm', 'name' => 'Space Alarm' ],
  [ 'soundid' => 'tugboat', 'name' => 'Tug Boat' ],
  [ 'soundid' => 'alien', 'name' => 'Alien Alarm (long)' ],
  [ 'soundid' => 'climb', 'name' => 'Climb (long)' ],
  [ 'soundid' => 'persistent', 'name' => 'Persistent (long)' ],
  [ 'soundid' => 'echo', 'name' => 'Pushover Echo (long)' ],
  [ 'soundid' => 'updown', 'name' => 'Up Down (long)' ],
  [ 'soundid' => 'none', 'name' => 'None' ],
];

?>
<div class="row">
  <div class="col-md-12">
    <h4><?php echo _l('pushover'); ?> Settings</h4>
    <p>These settings are required to enable Pushover notifications - See Setup Documentation for more information</p>
    <hr />
    <?php $attrs = (get_option('pushover_token') != '' ? array() : array('autofocus'=>true)); ?>
    <?php echo render_input('settings[pushover_token]','settings_pushover_token',get_option('pushover_token'),'text',$attrs); ?>
    <hr />
    <?php echo render_input('settings[pushover_key]','settings_pushover_key',get_option('pushover_key')); ?>
    <hr />
    <?php echo render_select('settings[pushover_priority]',$priorities,array('priorityid','name'),'settings_pushover_priority',get_option('pushover_priority'),array(),array('data-toggle'=>'tooltip','data-html'=>'true','title'=>'settings_pushover_priority_tooltip')); ?>
    <p>
        <a href="https://pushover.net/api#priority" target="_blank" class="settings-textarea-merge-field" data-to="pushover_sound">More Notification Priority Information From Pushover.net</a>
    </p>
    <hr />
    <?php echo render_select('settings[pushover_sound]',$sounds,array('soundid','name'),'settings_pushover_sound',get_option('pushover_sound'),array(),array()); ?>
    <p>
        <a href="https://pushover.net/api#sounds" target="_blank" class="settings-textarea-merge-field" data-to="pushover_sound">More Notification Sound Information From Pushover.net</a>
    </p>
    <hr />
    <?php echo render_select('settings[pushover_admin_reply]',[['id'=>'client_only', 'name'=>'Client Only'],['id'=>'client_admin','name'=>'Admin & Client']],array('id','name'),'pushover_admin_reply',get_option('pushover_admin_reply'),array(),array()); ?>
    <p>Send notifications on client only replies, or notifications for both client and admin replys</p>
  </div>
</div>
