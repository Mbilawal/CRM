<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pushover_module
{
    private $ci;
    private $pushover_token = '';
    private $pushover_key = '';
    private $pushover_admin_reply = '';

    public function __construct()
    {
        $this->ci = &get_instance();
        $this->ci->load->model('tickets_model');
        $this->pushover_token = get_option('pushover_token');
        $this->pushover_key = get_option('pushover_key');
        $this->pushover_admin_reply = get_option('pushover_admin_reply');
    }

    public function send_new_ticket_alert( $id = '' )
    {
        if( !isset($this->pushover_token) && $this->pushover_token != '' || !isset($this->pushover_key) && $this->pushover_key != '' ){
            log_activity(_l('pushover_key_not_set'));
            die();
        }else{
            $ticket = $this->ci->tickets_model->get_ticket_by_id($id);
            $this->send_pushover($ticket->subject, $ticket->ticketid, $ticket->message); // Send the notification
        }
    }

    public function send_update_ticket_alert( $data = [] )
    {
        if( !isset($this->pushover_token) && $this->pushover_token != '' || !isset($this->pushover_key) && $this->pushover_key != '' ){
            log_activity(_l('pushover_key_not_set'));
            die();
        }else{

            if( $this->pushover_admin_reply == 'client_only' && $data['data']['admin'] != 1 ){
              // Notification Set To Only Alert On Client Resonse
              $ticket = $this->ci->tickets_model->get_ticket_by_id( $data['data']['ticketid'] );
              $this->send_pushover($ticket->subject, $ticket->ticketid, $data['data']['message']); // Send the notification

            }else if( $this->pushover_admin_reply == 'client_admin' ){
              // Notify of both client and admin responses
              $ticket = $this->ci->tickets_model->get_ticket_by_id( $data['data']['ticketid'] );
              $this->send_pushover($ticket->subject, $ticket->ticketid, $data['data']['message']); // Send the notification

            }
        }
    }

    public function send_pushover($subject = '', $ticketid = '', $message = '')
    {
        $push = new Pushover();
        $push->setToken($this->pushover_token);
        $push->setUser($this->pushover_key);
        $push->setTitle(_l('pushover_new_ticket_reply').': '.$ticketid);
        $push->setHtml(1);
        $push->setMessage($message);
        $push->setUrl(admin_url('tickets/ticket/' . $ticketid ));
        $push->setUrlTitle(get_option('companyname'));
        $push->setPriority(str_replace('p','',get_option('pushover_priority'))); // workaround for bug in select2 where zero wont set
        $push->setTimestamp(time());
        $push->setSound(get_option('pushover_sound'));
        $go = $push->send();

        log_activity(_l('pushover_log_activity').$this->pushover_key);
    }
}
