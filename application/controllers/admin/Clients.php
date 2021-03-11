<?php

defined('BASEPATH') or exit('No direct script access allowed'); 


class Clients extends AdminController
{
	public function __construct() {
             parent::__construct();

             $this->load->model("mod_common");
			 $this->load->model("clients_model");
			 $this->load->library("form_validation");

             //$this->mod_common->verify_is_admin_login();
    }


    public function test(){

        echo 'imhere';
        exit;

        $this->load->view('admin/clients/data', array());
        exit;

    	$this->db->where(array('user_id' => '10103'));
        $get_data = $this->db->get('tblrewards')->result_array();

        for ($i=500; $i < count($get_data); $i++) { 
            
            $id = $get_data[$i]['rewards_id'];

            $update = date("Y-m-d H:i:s", strtotime('2020-09-17 00:00:00'));

            $this->db->where(array('id' => $id));
            $update =  $this->db->update('tblrewards', $update);

        }


    }


    /* List all clients */
    public function index()
    {
        if (!has_permission('customers', '', 'view')) {
            if (!have_assigned_customers() && !has_permission('customers', '', 'create')) {
                access_denied('customers');
            }
        }

        $this->load->model('contracts_model');
        $data['contract_types'] = $this->contracts_model->get_contract_types();
        $data['groups']         = $this->clients_model->get_groups();
        $data['title']          = _l('clients');

        $this->load->model('proposals_model');
        $data['proposal_statuses'] = $this->proposals_model->get_statuses();

        $this->load->model('invoices_model');
        $data['invoice_statuses'] = $this->invoices_model->get_statuses();

        $this->load->model('estimates_model');
        $data['estimate_statuses'] = $this->estimates_model->get_statuses();

        $this->load->model('projects_model');
        $data['project_statuses'] = $this->projects_model->get_project_statuses();

        $data['customer_admins'] = $this->clients_model->get_customers_admin_unique_ids();

        $whereContactsLoggedIn = '';
        if (!has_permission('customers', '', 'view')) {
            $whereContactsLoggedIn = ' AND userid IN (SELECT customer_id FROM ' . db_prefix() . 'customer_admins WHERE staff_id=' . get_staff_user_id() . ')';
        }

        $data['contacts_logged_in_today'] = $this->clients_model->get_contacts('', 'last_login LIKE "' . date('Y-m-d') . '%"' . $whereContactsLoggedIn);

        $data['countries'] = $this->clients_model->get_clients_distinct_countries();

        $this->load->view('admin/clients/manage', $data);
    }

    public function table()
    {
        if (!has_permission('customers', '', 'view')) {
            if (!have_assigned_customers() && !has_permission('customers', '', 'create')) {
                ajax_access_denied();
            }
        }

        $this->app->get_table_data('clients');
    }

    public function all_contacts()
    {
        if ($this->input->is_ajax_request()) {
            $this->app->get_table_data('all_contacts');
        }

        if (is_gdpr() && get_option('gdpr_enable_consent_for_contacts') == '1') {
            $this->load->model('gdpr_model');
            $data['consent_purposes'] = $this->gdpr_model->get_consent_purposes();
        }

        $data['title'] = _l('customer_contacts');
        $this->load->view('admin/clients/all_contacts', $data);
    }

    public function all_referal_contacts()
    {
        if ($this->input->is_ajax_request()) {
            $this->app->get_table_data('all_contacts');
        }

        if (is_gdpr() && get_option('gdpr_enable_consent_for_contacts') == '1') {
            $this->load->model('gdpr_model');
            $data['consent_purposes'] = $this->gdpr_model->get_consent_purposes();
        }

        $data['title'] = _l('customer_contacts');
        $this->load->view('admin/clients/all_contacts', $data);
    }

    public function drivers()
    {
        if ($this->input->is_ajax_request()) {
            $this->app->get_table_data('all_drivers');
        }

        if (is_gdpr() && get_option('gdpr_enable_consent_for_contacts') == '1') {
            $this->load->model('gdpr_model');
            $data['consent_purposes'] = $this->gdpr_model->get_consent_purposes();
        }

        $data['title'] = _l('customer_contacts');
        $this->load->view('admin/clients/all_contacts', $data);
    }


    public function orders_detail($order_id)
    {   

        $data['order_arr'] =  $this->clients_model->get_orders_detail($order_id);
		$data['order_id']  =  $order_id;
		
		//echo "<pre>";  print_r($data['order_arr']); exit;
		
        $data['title'] = _l('customer_orders');
        $this->load->view('admin/clients/orders_detail', $data);
    }


    public function orders_2($user_id=0)
    {
        $count_total_leads = $this->clients_model->count_orders($user_id);

        //Pagination
        $this->load->library('pagination');
        $config['base_url'] = base_url().'admin/clients/orders_2/'.$user_id.'/';
        $config['total_rows'] = $count_total_leads;
    
        $config['per_page'] = 25;
        $config['num_links'] = 10;
        $config['use_page_numbers'] = TRUE;
        $config['uri_segment'] = 5;
        $config['reuse_query_string'] = TRUE;

        $config["first_tag_open"] = '<li>';
        $config["first_tag_close"] = '</li>';

        $config["last_tag_open"] = '<li>';
        $config["last_tag_close"] = '</li>';
        
        $config['next_link'] = '&raquo;';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        
        $config['prev_link'] = '&laquo;';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';
        
        $config['first_link'] = 'First';
        $config['last_link'] = 'Last';
        
        $config['full_tag_open'] = '<ul class="pagination contact_filter_pagination">';
        $config['full_tag_close'] = '</ul>';
        
        $config['cur_tag_open'] = '<li class="active"><a href="#"><b>';
        $config['cur_tag_close'] = '</b></a></li>';
        
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(5)) ? $this->uri->segment(5) : 0;
        if($page !=0) $page = ($page-1) * $config['per_page'];

        $data['page_links'] = $this->pagination->create_links();
        
        $data['orders'] = $this->clients_model->get_orders('',$page,$config["per_page"]);


        $data['title'] = _l('customer_orders');
        $this->load->view('admin/clients/all_orders', $data);
    }

    /* Edit client or add new client*/
    public function client($id = '')
    {

        if (!has_permission('customers', '', 'view')) {
            if ($id != '' && !is_customer_admin($id)) {
                access_denied('customers');
            }
        }

        if ($this->input->post() && !$this->input->is_ajax_request()) {
            if ($id == '') {
                if (!has_permission('customers', '', 'create')) {
                    access_denied('customers');
                }

                $data = $this->input->post();

                $save_and_add_contact = false;
                if (isset($data['save_and_add_contact'])) {
                    unset($data['save_and_add_contact']);
                    $save_and_add_contact = true;
                }
                $id = $this->clients_model->add($data);
                if (!has_permission('customers', '', 'view')) {
                    $assign['customer_admins']   = [];
                    $assign['customer_admins'][] = get_staff_user_id();
                    $this->clients_model->assign_admins($assign, $id);
                }
                if ($id) {
                    set_alert('success', _l('added_successfully', _l('client')));
                    if ($save_and_add_contact == false) {
                        redirect(admin_url('clients/client/' . $id));
                    } else {
                        redirect(admin_url('clients/client/' . $id . '?group=contacts&new_contact=true'));
                    }
                }
            } else {
                if (!has_permission('customers', '', 'edit')) {
                    if (!is_customer_admin($id)) {
                        access_denied('customers');
                    }
                }
				
                $success = $this->clients_model->update($this->input->post(), $id);
                if ($success == true) {
                    set_alert('success', _l('updated_successfully', _l('client')));
                }
                redirect(admin_url('clients/client/' . $id));
            }
        }

        $group  = !$this->input->get('group') ? 'profile' : $this->input->get('group');
        $data['group'] = $group;

        if($group != 'contacts' && $contact_id = $this->input->get('contactid')){
            redirect(admin_url('clients/client/' . $id . '?group=contacts&contactid=' . $contact_id));
        }

        // Customer groups
        $data['groups'] = $this->clients_model->get_groups();

        if($id == ''){
            
            $title = _l('add_new', _l('client_lowercase'));
        
        }else{
            $client                = $this->clients_model->get($id);
            $data['customer_tabs'] = get_customer_profile_tabs();

            if (!$client) {
                show_404();
            }

            $data['contacts'] = $this->clients_model->get_contacts($id);
            $data['tab']      = isset($data['customer_tabs'][$group]) ? $data['customer_tabs'][$group] : null;

            if (!$data['tab']) {
                show_404();
            }

            // Fetch data based on groups
            if ($group == 'profile') {
                $data['customer_groups'] = $this->clients_model->get_customer_groups($id);
                $data['customer_admins'] = $this->clients_model->get_admins($id);
            } elseif ($group == 'attachments') {
                $data['attachments'] = get_all_customer_attachments($id);
            } elseif ($group == 'vault') {
                $data['vault_entries'] = hooks()->apply_filters('check_vault_entries_visibility', $this->clients_model->get_vault_entries($id));

                if ($data['vault_entries'] === -1) {
                    $data['vault_entries'] = [];
                }
            } elseif ($group == 'estimates') {
                $this->load->model('estimates_model');
                $data['estimate_statuses'] = $this->estimates_model->get_statuses();
            } elseif ($group == 'invoices') {
                $this->load->model('invoices_model');
                $data['invoice_statuses'] = $this->invoices_model->get_statuses();
            } elseif ($group == 'credit_notes') {
                $this->load->model('credit_notes_model');
                $data['credit_notes_statuses'] = $this->credit_notes_model->get_statuses();
                $data['credits_available']     = $this->credit_notes_model->total_remaining_credits_by_customer($id);
            } elseif ($group == 'payments') {
                $this->load->model('payment_modes_model');
                $data['payment_modes'] = $this->payment_modes_model->get();
            } elseif ($group == 'notes') {
                $data['user_notes'] = $this->misc_model->get_notes($id, 'customer');
            } elseif ($group == 'projects') {
                $this->load->model('projects_model');
                $data['project_statuses'] = $this->projects_model->get_project_statuses();
            } elseif ($group == 'statement') {
                if (!has_permission('invoices', '', 'view') && !has_permission('payments', '', 'view')) {
                    set_alert('danger', _l('access_denied'));
                    redirect(admin_url('clients/client/' . $id));
                }

                $data = array_merge($data, prepare_mail_preview_data('customer_statement', $id));
                // echo '<pre>';
                // print_r($data);
                // exit;
            } elseif ($group == 'map') {
                if (get_option('google_api_key') != '' && !empty($client->latitude) && !empty($client->longitude)) {
                    $this->app_scripts->add('map-js', base_url($this->app_scripts->core_file('assets/js', 'map.js')) . '?v=' . $this->app_css->core_version());

                    $this->app_scripts->add('google-maps-api-js', [
                        'path'       => 'https://maps.googleapis.com/maps/api/js?key=' . get_option('google_api_key') . '&callback=initMap',
                        'attributes' => [
                            'async',
                            'defer',
                            'latitude'       => "$client->latitude",
                            'longitude'      => "$client->longitude",
                            'mapMarkerTitle' => "$client->company",
                        ],
                        ]);
                }
            }

            $data['staff'] = $this->staff_model->get('', ['active' => 1]);

            $data['client'] = $client;
            $title          = $client->company;

            // Get all active staff members (used to add reminder)
            $data['members'] = $data['staff'];

            if (!empty($data['client']->company)) {
                // Check if is realy empty client company so we can set this field to empty
                // The query where fetch the client auto populate firstname and lastname if company is empty
                if (is_empty_customer_company($data['client']->userid)) {
                    $data['client']->company = '';
                }
            }
        
        }

        $this->load->model('currencies_model');
        $data['currencies'] = $this->currencies_model->get();

        if($id != ''){
            
            $customer_currency = $data['client']->default_currency;

            foreach ($data['currencies'] as $currency) {
                
                if ($customer_currency != 0) {
                    if ($currency['id'] == $customer_currency) {
                        $customer_currency = $currency;

                        break;
                    }
                } else {
                    if ($currency['isdefault'] == 1) {
                        $customer_currency = $currency;

                        break;
                    }
                }
            }

            if(is_array($customer_currency)){
                $customer_currency = (object) $customer_currency;
            }

            $data['customer_currency'] = $customer_currency;

            $slug_zip_folder = (
                $client->company != ''
                ? $client->company
                : get_contact_full_name(get_primary_contact_user_id($client->userid))
            );

            $data['zip_in_folder'] = slug_it($slug_zip_folder);
        }

        $data['bodyclass'] = 'customer-profile dynamic-create-groups';
        $data['title']     = $title;

        $this->load->view('admin/clients/client', $data);
    
    }

    public function export($contact_id)
    {
        if (is_admin()) {
            $this->load->library('gdpr/gdpr_contact');
            $this->gdpr_contact->export($contact_id);
        }
    }

    // Used to give a tip to the user if the company exists when new company is created
    public function check_duplicate_customer_name()
    {
        if (has_permission('customers', '', 'create')) {
            $companyName = trim($this->input->post('company'));
            $response    = [
                'exists'  => (bool) total_rows(db_prefix() . 'clients', ['company' => $companyName]) > 0,
                'message' => _l('company_exists_info', '<b>' . $companyName . '</b>'),
            ];
            echo json_encode($response);
        }
    }

    public function save_longitude_and_latitude($client_id)
    {
        if (!has_permission('customers', '', 'edit')) {
            if (!is_customer_admin($client_id)) {
                ajax_access_denied();
            }
        }

        $this->db->where('userid', $client_id);
        $this->db->update(db_prefix() . 'clients', [
            'longitude' => $this->input->post('longitude'),
            'latitude'  => $this->input->post('latitude'),
        ]);
        if ($this->db->affected_rows() > 0) {
            echo 'success';
        } else {
            echo 'false';
        }
    }

    public function form_contact($customer_id, $contact_id = '')
    {
        if (!has_permission('customers', '', 'view')) {
            if (!is_customer_admin($customer_id)) {
                echo _l('access_denied');
                die;
            }
        }
        $data['customer_id'] = $customer_id;
        $data['contactid']   = $contact_id;
        if ($this->input->post()) {
            $data             = $this->input->post();
            $data['password'] = $this->input->post('password', false);

            unset($data['contactid']);
            if ($contact_id == '') {
                if (!has_permission('customers', '', 'create')) {
                    if (!is_customer_admin($customer_id)) {
                        header($_SERVER['SERVER_PROTOCOL'] . ' 400 Bad error');
                        echo json_encode([
                            'success' => false,
                            'message' => _l('access_denied'),
                        ]);
                        die;
                    }
                }
                $id      = $this->clients_model->add_contact($data, $customer_id);
                $message = '';
                $success = false;
                if ($id) {
                    handle_contact_profile_image_upload($id);
                    $success = true;
                    $message = _l('added_successfully', _l('contact'));
                }
                echo json_encode([
                    'success'             => $success,
                    'message'             => $message,
                    'has_primary_contact' => (total_rows(db_prefix() . 'contacts', ['userid' => $customer_id, 'is_primary' => 1]) > 0 ? true : false),
                    'is_individual'       => is_empty_customer_company($customer_id) && total_rows(db_prefix() . 'contacts', ['userid' => $customer_id]) == 1,
                ]);
                die;
            }
            if (!has_permission('customers', '', 'edit')) {
                if (!is_customer_admin($customer_id)) {
                    header($_SERVER['SERVER_PROTOCOL'] . ' 400 Bad error');
                    echo json_encode([
                            'success' => false,
                            'message' => _l('access_denied'),
                        ]);
                    die;
                }
            }
            $original_contact = $this->clients_model->get_contact($contact_id);
            $success          = $this->clients_model->update_contact($data, $contact_id);
            $message          = '';
            $proposal_warning = false;
            $original_email   = '';
            $updated          = false;
            if (is_array($success)) {
                if (isset($success['set_password_email_sent'])) {
                    $message = _l('set_password_email_sent_to_client');
                } elseif (isset($success['set_password_email_sent_and_profile_updated'])) {
                    $updated = true;
                    $message = _l('set_password_email_sent_to_client_and_profile_updated');
                }
            } else {
                if ($success == true) {
                    $updated = true;
                    $message = _l('updated_successfully', _l('contact'));
                }
            }
            if (handle_contact_profile_image_upload($contact_id) && !$updated) {
                $message = _l('updated_successfully', _l('contact'));
                $success = true;
            }
            if ($updated == true) {
                $contact = $this->clients_model->get_contact($contact_id);
                if (total_rows(db_prefix() . 'proposals', [
                        'rel_type' => 'customer',
                        'rel_id' => $contact->userid,
                        'email' => $original_contact->email,
                    ]) > 0 && ($original_contact->email != $contact->email)) {
                    $proposal_warning = true;
                    $original_email   = $original_contact->email;
                }
            }
            echo json_encode([
                    'success'             => $success,
                    'proposal_warning'    => $proposal_warning,
                    'message'             => $message,
                    'original_email'      => $original_email,
                    'has_primary_contact' => (total_rows(db_prefix() . 'contacts', ['userid' => $customer_id, 'is_primary' => 1]) > 0 ? true : false),
                ]);
            die;
        }
        if ($contact_id == '') {
            $title = _l('add_new', _l('contact_lowercase'));
        } else {
            $data['contact'] = $this->clients_model->get_contact($contact_id);

            if (!$data['contact']) {
                header($_SERVER['SERVER_PROTOCOL'] . ' 400 Bad error');
                echo json_encode([
                    'success' => false,
                    'message' => 'Contact Not Found',
                ]);
                die;
            }
            $title = $data['contact']->firstname . ' ' . $data['contact']->lastname;
        }

        $data['customer_permissions'] = get_contact_permissions();
        $data['title']                = $title;
        $this->load->view('admin/clients/modals/contact', $data);
    }

    public function confirm_registration($client_id)
    {
        if (!is_admin()) {
            access_denied('Customer Confirm Registration, ID: ' . $client_id);
        }
        $this->clients_model->confirm_registration($client_id);
        set_alert('success', _l('customer_registration_successfully_confirmed'));
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function update_file_share_visibility()
    {
        if ($this->input->post()) {
            $file_id           = $this->input->post('file_id');
            $share_contacts_id = [];

            if ($this->input->post('share_contacts_id')) {
                $share_contacts_id = $this->input->post('share_contacts_id');
            }

            $this->db->where('file_id', $file_id);
            $this->db->delete(db_prefix() . 'shared_customer_files');

            foreach ($share_contacts_id as $share_contact_id) {
                $this->db->insert(db_prefix() . 'shared_customer_files', [
                    'file_id'    => $file_id,
                    'contact_id' => $share_contact_id,
                ]);
            }
        }
    }

    public function delete_contact_profile_image($contact_id)
    {
        hooks()->do_action('before_remove_contact_profile_image');
        if (file_exists(get_upload_path_by_type('contact_profile_images') . $contact_id)) {
            delete_dir(get_upload_path_by_type('contact_profile_images') . $contact_id);
        }
        $this->db->where('id', $contact_id);
        $this->db->update(db_prefix() . 'contacts', [
            'profile_image' => null,
        ]);
    }

    public function mark_as_active($id)
    {
        $this->db->where('userid', $id);
        $this->db->update(db_prefix() . 'clients', [
            'active' => 1,
        ]);
        redirect(admin_url('clients/client/' . $id));
    }

    public function consents($id)
    {
        if (!has_permission('customers', '', 'view')) {
            if (!is_customer_admin(get_user_id_by_contact_id($id))) {
                echo _l('access_denied');
                die;
            }
        }

        $this->load->model('gdpr_model');
        $data['purposes']   = $this->gdpr_model->get_consent_purposes($id, 'contact');
        $data['consents']   = $this->gdpr_model->get_consents(['contact_id' => $id]);
        $data['contact_id'] = $id;
        $this->load->view('admin/gdpr/contact_consent', $data);
    }

    public function update_all_proposal_emails_linked_to_customer($contact_id)
    {
        $success = false;
        $email   = '';
        if ($this->input->post('update')) {
            $this->load->model('proposals_model');

            $this->db->select('email,userid');
            $this->db->where('id', $contact_id);
            $contact = $this->db->get(db_prefix() . 'contacts')->row();

            $proposals = $this->proposals_model->get('', [
                'rel_type' => 'customer',
                'rel_id'   => $contact->userid,
                'email'    => $this->input->post('original_email'),
            ]);
            $affected_rows = 0;

            foreach ($proposals as $proposal) {
                $this->db->where('id', $proposal['id']);
                $this->db->update(db_prefix() . 'proposals', [
                    'email' => $contact->email,
                ]);
                if ($this->db->affected_rows() > 0) {
                    $affected_rows++;
                }
            }

            if ($affected_rows > 0) {
                $success = true;
            }
        }
        echo json_encode([
            'success' => $success,
            'message' => _l('proposals_emails_updated', [
                _l('contact_lowercase'),
                $contact->email,
            ]),
        ]);
    }

     public function export_csv()
     {
        $file_name = 'Orders_'.date('Ymd').'.csv'; 
         header("Content-Description: File Transfer"); 
         header("Content-Disposition: attachment; filename=$file_name"); 
         header("Content-Type: application/csv;");
       
         // get data 
         $orders = $this->clients_model->get_orders_csv($this->input->post());
    
         // file creation 
         $file = fopen('php://output', 'w');
     
         $header = array("Order ID","Customer","Resturant","Status","Total Amout","Driver","Created Date"); 
         fputcsv($file, $header);
         foreach ($orders as $key => $value)
         { 
           fputcsv($file, $value); 
         }
         fclose($file); 
         exit; 
     }

    public function assign_admins($id)
    {
        if (!has_permission('customers', '', 'create') && !has_permission('customers', '', 'edit')) {
            access_denied('customers');
        }
        $success = $this->clients_model->assign_admins($this->input->post(), $id);
        if ($success == true) {
            set_alert('success', _l('updated_successfully', _l('client')));
        }

        redirect(admin_url('clients/client/' . $id . '?tab=customer_admins'));
    }

    public function delete_customer_admin($customer_id, $staff_id)
    {
        if (!has_permission('customers', '', 'create') && !has_permission('customers', '', 'edit')) {
            access_denied('customers');
        }

        $this->db->where('customer_id', $customer_id);
        $this->db->where('staff_id', $staff_id);
        $this->db->delete(db_prefix() . 'customer_admins');
        redirect(admin_url('clients/client/' . $customer_id) . '?tab=customer_admins');
    }

    public function delete_contact($customer_id, $id)
    {
        if (!has_permission('customers', '', 'delete')) {
            if (!is_customer_admin($customer_id)) {
                access_denied('customers');
            }
        }
        $contact      = $this->clients_model->get_contact($id);
        $hasProposals = false;
        if ($contact && is_gdpr()) {
            if (total_rows(db_prefix() . 'proposals', ['email' => $contact->email]) > 0) {
                $hasProposals = true;
            }
        }

        $this->clients_model->delete_contact($id);
        if ($hasProposals) {
            $this->session->set_flashdata('gdpr_delete_warning', true);
        }
        redirect(admin_url('clients/client/' . $customer_id . '?group=contacts'));
    }

    public function contacts($client_id)
    {
        $this->app->get_table_data('contacts', [
            'client_id' => $client_id,
        ]);
    }

    public function upload_attachment($id)
    {
        handle_client_attachments_upload($id);
    }

    public function add_external_attachment()
    {
        if ($this->input->post()) {
            $this->misc_model->add_attachment_to_database($this->input->post('clientid'), 'customer', $this->input->post('files'), $this->input->post('external'));
        }
    }

    public function delete_attachment($customer_id, $id)
    {
        if (has_permission('customers', '', 'delete') || is_customer_admin($customer_id)) {
            $this->clients_model->delete_attachment($id);
        }
        redirect($_SERVER['HTTP_REFERER']);
    }

    /* Delete client */
    public function delete($id)
    {
        if (!has_permission('customers', '', 'delete')) {
            access_denied('customers');
        }
        if (!$id) {
            redirect(admin_url('clients'));
        }
        $response = $this->clients_model->delete($id);
        if (is_array($response) && isset($response['referenced'])) {
            set_alert('warning', _l('customer_delete_transactions_warning', _l('invoices') . ', ' . _l('estimates') . ', ' . _l('credit_notes')));
        } elseif ($response == true) {
            set_alert('success', _l('deleted', _l('client')));
        } else {
            set_alert('warning', _l('problem_deleting', _l('client_lowercase')));
        }
        redirect(admin_url('clients'));
    }
	
	/* Archive Client */
	public function archive($id)
    {
        if (!$id) {
            redirect(admin_url('clients'));
        }
        $response = $this->clients_model->archive($id);
        if (is_array($response) && isset($response['referenced'])) {
            set_alert('warning', _l('customer_delete_transactions_warning', _l('invoices') . ', ' . _l('estimates') . ', ' . _l('credit_notes')));
        } elseif ($response == true) {
            set_alert('success', _l('Archived', _l('client')));
        } else {
            set_alert('warning', _l('problem_archiving', _l('client_lowercase')));
        }
        redirect(admin_url('clients'));
    }

    /* Staff can login as client */
    public function login_as_client($id)
    {
        if (is_admin()) {
            login_as_client($id);
        }
        hooks()->do_action('after_contact_login');
        redirect(site_url());
    }

    public function get_customer_billing_and_shipping_details($id)
    {
        echo json_encode($this->clients_model->get_customer_billing_and_shipping_details($id));
    }

    /* Change client status / active / inactive */
    public function change_contact_status($id, $status)
    {
        if (has_permission('customers', '', 'edit') || is_customer_admin(get_user_id_by_contact_id($id))) {
            if ($this->input->is_ajax_request()) {
                $this->clients_model->change_contact_status($id, $status);
            }
        }
    }

    /* Change client status / active / inactive */
    public function change_client_status($id, $status)
    {
        if ($this->input->is_ajax_request()) {
            $this->clients_model->change_client_status($id, $status);
        }
    }

    /* Zip function for credit notes */
    public function zip_credit_notes($id)
    {
        $has_permission_view = has_permission('credit_notes', '', 'view');

        if (!$has_permission_view && !has_permission('credit_notes', '', 'view_own')) {
            access_denied('Zip Customer Credit Notes');
        }

        if ($this->input->post()) {
            $this->load->library('app_bulk_pdf_export', [
                'export_type'       => 'credit_notes',
                'status'            => $this->input->post('credit_note_zip_status'),
                'date_from'         => $this->input->post('zip-from'),
                'date_to'           => $this->input->post('zip-to'),
                'redirect_on_error' => admin_url('clients/client/' . $id . '?group=credit_notes'),
            ]);

            $this->app_bulk_pdf_export->set_client_id($id);
            $this->app_bulk_pdf_export->in_folder($this->input->post('file_name'));
            $this->app_bulk_pdf_export->export();
        }
    }

    public function zip_invoices($id)
    {
        $has_permission_view = has_permission('invoices', '', 'view');
        if (!$has_permission_view && !has_permission('invoices', '', 'view_own')
            && get_option('allow_staff_view_invoices_assigned') == '0') {
            access_denied('Zip Customer Invoices');
        }

        if ($this->input->post()) {
            $this->load->library('app_bulk_pdf_export', [
                'export_type'       => 'invoices',
                'status'            => $this->input->post('invoice_zip_status'),
                'date_from'         => $this->input->post('zip-from'),
                'date_to'           => $this->input->post('zip-to'),
                'redirect_on_error' => admin_url('clients/client/' . $id . '?group=invoices'),
            ]);

            $this->app_bulk_pdf_export->set_client_id($id);
            $this->app_bulk_pdf_export->in_folder($this->input->post('file_name'));
            $this->app_bulk_pdf_export->export();
        }
    }

    /* Since version 1.0.2 zip client estimates */
    public function zip_estimates($id)
    {
        $has_permission_view = has_permission('estimates', '', 'view');
        if (!$has_permission_view && !has_permission('estimates', '', 'view_own')
            && get_option('allow_staff_view_estimates_assigned') == '0') {
            access_denied('Zip Customer Estimates');
        }

        if ($this->input->post()) {
            $this->load->library('app_bulk_pdf_export', [
                'export_type'       => 'estimates',
                'status'            => $this->input->post('estimate_zip_status'),
                'date_from'         => $this->input->post('zip-from'),
                'date_to'           => $this->input->post('zip-to'),
                'redirect_on_error' => admin_url('clients/client/' . $id . '?group=estimates'),
            ]);

            $this->app_bulk_pdf_export->set_client_id($id);
            $this->app_bulk_pdf_export->in_folder($this->input->post('file_name'));
            $this->app_bulk_pdf_export->export();
        }
    }

    public function zip_payments($id)
    {
        $has_permission_view = has_permission('payments', '', 'view');

        if (!$has_permission_view && !has_permission('invoices', '', 'view_own')
            && get_option('allow_staff_view_invoices_assigned') == '0') {
            access_denied('Zip Customer Payments');
        }

        $this->load->library('app_bulk_pdf_export', [
                'export_type'       => 'payments',
                'payment_mode'      => $this->input->post('paymentmode'),
                'date_from'         => $this->input->post('zip-from'),
                'date_to'           => $this->input->post('zip-to'),
                'redirect_on_error' => admin_url('clients/client/' . $id . '?group=payments'),
            ]);

        $this->app_bulk_pdf_export->set_client_id($id);
        $this->app_bulk_pdf_export->set_client_id_column(db_prefix() . 'clients.userid');
        $this->app_bulk_pdf_export->in_folder($this->input->post('file_name'));
        $this->app_bulk_pdf_export->export();
    }

    public function import()
    {
        if (!has_permission('customers', '', 'create')) {
            access_denied('customers');
        }

        $dbFields = $this->db->list_fields(db_prefix() . 'contacts');
        foreach ($dbFields as $key => $contactField) {
            if ($contactField == 'phonenumber') {
                $dbFields[$key] = 'contact_phonenumber';
            }
        }

        $dbFields = array_merge($dbFields, $this->db->list_fields(db_prefix() . 'clients'));

        $this->load->library('import/import_customers', [], 'import');

        $this->import->setDatabaseFields($dbFields)
                     ->setCustomFields(get_custom_fields('customers'));

        if ($this->input->post('download_sample') === 'true') {
            $this->import->downloadSample();
        }

        if ($this->input->post()
            && isset($_FILES['file_csv']['name']) && $_FILES['file_csv']['name'] != '') {
            $this->import->setSimulation($this->input->post('simulate'))
                          ->setTemporaryFileLocation($_FILES['file_csv']['tmp_name'])
                          ->setFilename($_FILES['file_csv']['name'])
                          ->perform();


            $data['total_rows_post'] = $this->import->totalRows();

            if (!$this->import->isSimulation()) {
                set_alert('success', _l('import_total_imported', $this->import->totalImported()));
            }
        }

        $data['groups']    = $this->clients_model->get_groups();
        $data['title']     = _l('import');
        $data['bodyclass'] = 'dynamic-create-groups';
        $this->load->view('admin/clients/import', $data);
    }

    public function groups()
    {
        if (!is_admin()) {
            access_denied('Customer Groups');
        }
        if ($this->input->is_ajax_request()) {
            $this->app->get_table_data('customers_groups');
        }
        $data['title'] = _l('customer_groups');
        $this->load->view('admin/clients/groups_manage', $data);
    }

    public function group()
    {
        if (!is_admin() && get_option('staff_members_create_inline_customer_groups') == '0') {
            access_denied('Customer Groups');
        }

        if ($this->input->is_ajax_request()) {
            $data = $this->input->post();
            if ($data['id'] == '') {
                $id      = $this->clients_model->add_group($data);
                $message = $id ? _l('added_successfully', _l('customer_group')) : '';
                echo json_encode([
                    'success' => $id ? true : false,
                    'message' => $message,
                    'id'      => $id,
                    'name'    => $data['name'],
                ]);
            } else {
                $success = $this->clients_model->edit_group($data);
                $message = '';
                if ($success == true) {
                    $message = _l('updated_successfully', _l('customer_group'));
                }
                echo json_encode([
                    'success' => $success,
                    'message' => $message,
                ]);
            }
        }
    }

    public function delete_group($id)
    {
        if (!is_admin()) {
            access_denied('Delete Customer Group');
        }
        if (!$id) {
            redirect(admin_url('clients/groups'));
        }
        $response = $this->clients_model->delete_group($id);
        if ($response == true) {
            set_alert('success', _l('deleted', _l('customer_group')));
        } else {
            set_alert('warning', _l('problem_deleting', _l('customer_group_lowercase')));
        }
        redirect(admin_url('clients/groups'));
    }

    public function bulk_action()
    {
        hooks()->do_action('before_do_bulk_action_for_customers');
        $total_deleted = 0;
        if ($this->input->post()) {
            $ids    = $this->input->post('ids');
            $groups = $this->input->post('groups');

            if (is_array($ids)) {
                foreach ($ids as $id) {
                    if ($this->input->post('mass_delete')) {
                        if ($this->clients_model->delete($id)) {
                            $total_deleted++;
                        }
                    } else {
                        if (!is_array($groups)) {
                            $groups = false;
                        }
                        $this->client_groups_model->sync_customer_groups($id, $groups);
                    }
                }
            }
        }

        if ($this->input->post('mass_delete')) {
            set_alert('success', _l('total_clients_deleted', $total_deleted));
        }
    }

    public function vault_entry_create($customer_id)
    {
        $data = $this->input->post();

        if (isset($data['fakeusernameremembered'])) {
            unset($data['fakeusernameremembered']);
        }

        if (isset($data['fakepasswordremembered'])) {
            unset($data['fakepasswordremembered']);
        }

        unset($data['id']);
        $data['creator']      = get_staff_user_id();
        $data['creator_name'] = get_staff_full_name($data['creator']);
        $data['description']  = nl2br($data['description']);
        $data['password']     = $this->encryption->encrypt($this->input->post('password', false));

        if (empty($data['port'])) {
            unset($data['port']);
        }

        $this->clients_model->vault_entry_create($data, $customer_id);
        set_alert('success', _l('added_successfully', _l('vault_entry')));
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function vault_entry_update($entry_id)
    {
        $entry = $this->clients_model->get_vault_entry($entry_id);

        if ($entry->creator == get_staff_user_id() || is_admin()) {
            $data = $this->input->post();

            if (isset($data['fakeusernameremembered'])) {
                unset($data['fakeusernameremembered']);
            }
            if (isset($data['fakepasswordremembered'])) {
                unset($data['fakepasswordremembered']);
            }

            $data['last_updated_from'] = get_staff_full_name(get_staff_user_id());
            $data['description']       = nl2br($data['description']);

            if (!empty($data['password'])) {
                $data['password'] = $this->encryption->encrypt($this->input->post('password', false));
            } else {
                unset($data['password']);
            }

            if (empty($data['port'])) {
                unset($data['port']);
            }

            $this->clients_model->vault_entry_update($entry_id, $data);
            set_alert('success', _l('updated_successfully', _l('vault_entry')));
        }
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function vault_entry_delete($id)
    {
        $entry = $this->clients_model->get_vault_entry($id);
        if ($entry->creator == get_staff_user_id() || is_admin()) {
            $this->clients_model->vault_entry_delete($id);
        }
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function vault_encrypt_password()
    {
        $id            = $this->input->post('id');
        $user_password = $this->input->post('user_password', false);
        $user          = $this->staff_model->get(get_staff_user_id());

        if (!app_hasher()->CheckPassword($user_password, $user->password)) {
            header('HTTP/1.1 401 Unauthorized');
            echo json_encode(['error_msg' => _l('vault_password_user_not_correct')]);
            die;
        }

        $vault    = $this->clients_model->get_vault_entry($id);
        $password = $this->encryption->decrypt($vault->password);

        $password = html_escape($password);

        // Failed to decrypt
        if (!$password) {
            header($_SERVER['SERVER_PROTOCOL'] . ' 400 Bad error');
            echo json_encode(['error_msg' => _l('failed_to_decrypt_password')]);
            die;
        }

        echo json_encode(['password' => $password]);
    }

    public function get_vault_entry($id)
    {
        $entry = $this->clients_model->get_vault_entry($id);
        unset($entry->password);
        $entry->description = clear_textarea_breaks($entry->description);
        echo json_encode($entry);
    }

    public function statement_pdf()
    {
        $customer_id = $this->input->get('customer_id');

        if (!has_permission('invoices', '', 'view') && !has_permission('payments', '', 'view')) {
            set_alert('danger', _l('access_denied'));
            redirect(admin_url('clients/client/' . $customer_id));
        }

        $from = $this->input->get('from');
        $to   = $this->input->get('to');

        $data['statement'] = $this->clients_model->get_statement($customer_id, to_sql_date($from), to_sql_date($to));

        try {
            $pdf = statement_pdf($data['statement']);
        } catch (Exception $e) {
            $message = $e->getMessage();
            echo $message;
            if (strpos($message, 'Unable to get the size of the image') !== false) {
                show_pdf_unable_to_get_image_size_error();
            }
            die;
        }

        $type = 'D';
        if ($this->input->get('print')) {
            $type = 'I';
        }

        $pdf->Output(slug_it(_l('customer_statement') . '-' . $data['statement']['client']->company) . '.pdf', $type);
    }

    public function send_statement()
    {
        $customer_id = $this->input->get('customer_id');

        if (!has_permission('invoices', '', 'view') && !has_permission('payments', '', 'view')) {
            set_alert('danger', _l('access_denied'));
            redirect(admin_url('clients/client/' . $customer_id));
        }

        $from = $this->input->get('from');
        $to   = $this->input->get('to');

        $send_to = $this->input->post('send_to');
        $cc      = $this->input->post('cc');

        $success = $this->clients_model->send_statement_to_email($customer_id, $send_to, $from, $to, $cc);
        // In case client use another language
        load_admin_language();
        if ($success) {
            set_alert('success', _l('statement_sent_to_client_success'));
        } else {
            set_alert('danger', _l('statement_sent_to_client_fail'));
        }

        redirect(admin_url('clients/client/' . $customer_id . '?group=statement'));
    }

    public function statement()
    {
        if (!has_permission('invoices', '', 'view') && !has_permission('payments', '', 'view')) {
            header($_SERVER['SERVER_PROTOCOL'] . ' 400 Bad error');
            echo _l('access_denied');
            die;
        }

        $customer_id = $this->input->get('customer_id');
        $from        = $this->input->get('from');
        $to          = $this->input->get('to');

        $data['statement'] = $this->clients_model->get_statement($customer_id, to_sql_date($from), to_sql_date($to));

        $data['from'] = $from;
        $data['to']   = $to;

        $viewData['html'] = $this->load->view('admin/clients/groups/_statement', $data, true);

        echo json_encode($viewData);
    }
	
	// New Report //
   
   
     public function orders_report($filtertype='',$data_id='')
    {   

        $data['filtertype']   = $filterclient;
        $data['data_id']      = $client_id;

        if( $filtertype !=''){

            $input_arr = array( $filtertype => $data_id);
        }else{ $input_arr = array();}

        $count_total_leads = $this->clients_model->count_orders($input_arr);

        $data['total_count'] = $count_total_leads;
        //Pagination
        $this->load->library('pagination');
        $config['base_url'] = base_url().'admin/clients/orders';
        $config['total_rows'] = $count_total_leads;
    
        $config['per_page'] = 25;
        $config['num_links'] = 10;
        $config['use_page_numbers'] = TRUE;
        $config['uri_segment'] = 4;
        $config['reuse_query_string'] = TRUE;

        $config["first_tag_open"] = '<li>';
        $config["first_tag_close"] = '</li>';

        $config["last_tag_open"] = '<li>';
        $config["last_tag_close"] = '</li>';
        
        $config['next_link'] = '&raquo;';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        
        $config['prev_link'] = '&laquo;';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';
        
        $config['first_link'] = 'First';
        $config['last_link'] = 'Last';
        
        $config['full_tag_open'] = '<ul class="pagination order_filter_pagination">';
        $config['full_tag_close'] = '</ul>';
        
        $config['cur_tag_open'] = '<li class="active"><a href="#"><b>';
        $config['cur_tag_close'] = '</b></a></li>';
        
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
        if($page !=0) $page = ($page-1) * $config['per_page'];

        $data['page_links'] = $this->pagination->create_links();
        
        $data['orders'] = $this->clients_model->get_orders($input_arr,$page,$config["per_page"]);
		
		$data['orders_count'] = $this->clients_model->count_orders();
		
		$data['orders_count_completed'] = $this->clients_model->count_orders_statuses('Completed');
		$data['orders_count_pending'] = $this->clients_model->count_orders_statuses('Pending');
		$data['orders_count_declined'] = $this->clients_model->count_orders_statuses('Declined');
		
		


        $data['title'] = _l('customer_orders');
        $this->load->view('admin/clients/orders_report', $data);
    }

    public function orders_report_ajax($page)
    {   

        $count_total_leads = $this->clients_model->count_orders($this->input->post());

        $total_count = $count_total_leads;
        //Pagination
        $this->load->library('pagination');
        $config['base_url'] = base_url().'admin/clients/orders_ajax';
        $config['total_rows'] = $count_total_leads;
    
        $config['per_page'] = 25;
        $config['num_links'] = 10;
        $config['use_page_numbers'] = TRUE;
        $config['uri_segment'] = 4;
        $config['reuse_query_string'] = TRUE;

        $config["first_tag_open"] = '<li>';
        $config["first_tag_close"] = '</li>';

        $config["last_tag_open"] = '<li>';
        $config["last_tag_close"] = '</li>';
        
        $config['next_link'] = '&raquo;';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        
        $config['prev_link'] = '&laquo;';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';
        
        $config['first_link'] = 'First';
        $config['last_link'] = 'Last';
        
        $config['full_tag_open'] = '<ul class="pagination order_filter_pagination">';
        $config['full_tag_close'] = '</ul>';
        
        $config['cur_tag_open'] = '<li class="active"><a href="#"><b>';
        $config['cur_tag_close'] = '</b></a></li>';
        
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
        if($page !=0) $page = ($page-1) * $config['per_page'];

        $page_links = $this->pagination->create_links();
        
        $orders = $this->clients_model->get_orders($this->input->post(),$page,$config["per_page"]);


        $response = '';
        foreach ($orders as $key => $value) {
			
		  if($value['status']=='Pending'){ 
			 $newstatus = '<span class="label label-primary">Pending</span>';
		  }else if($value['status']=='Completed'){ 
			 $newstatus = '<span class="label label-success">Completed</span>';
		  }else if($value['status']=='Declined'){ 
			 $newstatus = '<span class="label label-danger">Declined</span>';
		  }
		  
		  $customer_name  =  ($value['customer_name']==" ") ? $value['customer_name'] : "N/A";
		  $company_name   =  ($value['company_name']==" ") ? $value['company_name'] : "N/A";	
		  $driver_name    =  ($value['driver_name']==" ") ? $value['driver_name'] : "N/A";

          $city    =  ($value['city']==" ") ? $value['city'] : "N/A";

          $newkey = $key+1;
		  $lin  = '<a href="https://crm.dryvarfoods.com/admin/clients/orders_detail/'.$value['ID'].'">'.$value['ID'].'</a>';
		  
		  
		  $response .='<tr role="row">
           
		     <td>'.$newkey.'</td>
		    <td>'.$lin.'</td>
            <td>'.$customer_name.'</td>
            <td>'.$company_name.'</td>
            <td>'.$city.'</td>
            <td>'.$newstatus.'</td>
			<td>'.$value['time_ago'].'</td>
            <td>'.$value['total_amont'].'</td>
            <td>'.$driver_name.'</td>
            <td>'.$value['dated'].'</td>
          </tr>';
        } 

        echo $response.'***||***'.$total_count.'***||***'.$page_links;
    }

    public function orders($filtertype='',$data_id='')
    {   

        $data['filtertype']   = $filtertype;
        $data['data_id']      = $data_id;

        if( $filtertype !=''){
            $input_arr = array( $filtertype => $data_id);
        }else{ 
		    $input_arr = array();
		}

        $count_total_leads = $this->clients_model->count_orders('',$input_arr);
        $data['total_count'] = $count_total_leads;
        //Pagination
        $this->load->library('pagination');
        $config['base_url'] = base_url().'admin/clients/orders';
        $config['total_rows'] = $count_total_leads;
        $config['per_page'] = 25;
        $config['num_links'] = 10;
        $config['use_page_numbers'] = TRUE;
        $config['uri_segment'] = 4;
        $config['reuse_query_string'] = TRUE;
        $config["first_tag_open"] = '<li>';
        $config["first_tag_close"] = '</li>';
        $config["last_tag_open"] = '<li>';
        $config["last_tag_close"] = '</li>';
        $config['next_link'] = '&raquo;';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['prev_link'] = '&laquo;';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';
        $config['first_link'] = 'First';
        $config['last_link'] = 'Last';
        $config['full_tag_open'] = '<ul class="pagination order_filter_pagination">';
        $config['full_tag_close'] = '</ul>';
        $config['cur_tag_open'] = '<li class="active"><a href="#"><b>';
        $config['cur_tag_close'] = '</b></a></li>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
        if($page !=0) $page = ($page-1) * $config['per_page'];

        $data['page_links'] = $this->pagination->create_links();
        
        $data['orders'] = $this->clients_model->get_orders($input_arr,$page,200);
		
		$data['orders_count']             = $this->clients_model->count_orders();
		$data['orders_count_completed']   = $this->clients_model->count_orders_statuses('completed');
		$data['orders_count_pending']     = $this->clients_model->count_orders_statuses('pending');
		$data['orders_count_declined']    = $this->clients_model->count_orders_statuses('declined');
		
        $data['title'] = _l('customer_orders');
        $this->load->view('admin/clients/all_orders', $data);
    }

    public function orders_ajax($page)
    {   

        $count_total_leads = $this->clients_model->count_orders('',$this->input->post());

        $total_count = $count_total_leads;
        //Pagination
        $this->load->library('pagination');
        $config['base_url'] = base_url().'admin/clients/orders_ajax';
        $config['total_rows'] = $count_total_leads;
    
        $config['per_page'] = 25;
        $config['num_links'] = 10;
        $config['use_page_numbers'] = TRUE;
        $config['uri_segment'] = 4;
        $config['reuse_query_string'] = TRUE;

        $config["first_tag_open"] = '<li>';
        $config["first_tag_close"] = '</li>';

        $config["last_tag_open"] = '<li>';
        $config["last_tag_close"] = '</li>';
        
        $config['next_link'] = '&raquo;';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        
        $config['prev_link'] = '&laquo;';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';
        
        $config['first_link'] = 'First';
        $config['last_link'] = 'Last';
        
        $config['full_tag_open'] = '<ul class="pagination order_filter_pagination">';
        $config['full_tag_close'] = '</ul>';
        
        $config['cur_tag_open'] = '<li class="active"><a href="#"><b>';
        $config['cur_tag_close'] = '</b></a></li>';
        
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
        if($page !=0) $page = ($page-1) * $config['per_page'];

        $page_links = $this->pagination->create_links();
        $orders = $this->clients_model->get_orders($this->input->post(),$page,$config["per_page"]);
		//echo "<prE>";  print_r($orders ); exit;

		if(count($orders)>0){ 

            $response = '';
    		$pendingcount   = 0;
    		$completedcount = 0;
    		$declinecount   = 0;
            foreach ($orders as $key => $value) {
    				
    		  if($value['status']=="InCart"){ 
    			 $newstatus = '<span class="label label-default">In Cart</span>';
    			 $pendingcount  +=  $value['total_amont'];
    		  }else if($value['status']=="Pending"){ 
    			 $newstatus = '<span class="label label-info">Pending</span>';
    			 $completedcount  +=  $value['total_amont'];
    		  }else if($value['status']=="Declined"){ 
    			 $newstatus = '<span class="label label-danger">Declined</span>';
    			 $declinecount  +=  $value['total_amont'];
              }else if($value['status']=="Accepted"){ 
    			 $newstatus = '<span class="label label-primary">Accepted</span>';
    			 $declinecount  +=  $value['total_amont'];
              }else if($value['status']=="Cancelled"){ 
    			 $newstatus = '<span class="label label-danger">Cancelled</span>';
    			 $declinecount  +=  $value['total_amont'];
              }else if($value['status']=="Delivery"){ 
    			 $newstatus = '<span class="label label-warning">Delivery</span>';
    			 $declinecount  +=  $value['total_amont'];
              }else if($value['status']=="Completed"){ 
    			 $newstatus = '<span class="label label-success">Completed</span>';
    			 $declinecount  +=  $value['total_amont'];
               }else if($value['status']=="Expired"){ 
    			 $newstatus = '<span class="label label-danger">Expired</span>';
    			 $declinecount  +=  $value['total_amont'];  
    		  }
    		  
    		  $customer_name  = $value['customer_name'];
              if( $customer_name == "" || $customer_name == " " ) $customer_name ="N/A";

              $driver_name  = $value['driver_name'];
              if( $driver_name == "" || $driver_name == " " ) $driver_name ="N/A";

              $company_name  = $value['company_name'];
              if( $company_name == "" || $company_name == " " ) $company_name ="N/A";

              $city  = $value['city'];
              if( $city == "" || $city == " " ) $city ="N/A";

              $newkey = $key+1;
    		  $lin  = '<a href="https://crm.dryvarfoods.com/admin/clients/orders_detail/'.$value['ID'].'">'.$value['ID'].'</a>';
    		  
    		  
    		  $response .='<tr role="row">
               
    		      <td>'.$newkey.'</td>
    		    <td>'.$lin.'</td>
                <td>'.$customer_name.'</td>
                <td>'.$company_name.'</td>
                <td>'.$city.'</td>
                <td>'.$newstatus.'</td>

                <td>'.$value['reward_points'].'</td>
                <td>'.$value['loyalty_points'].'</td>

    			<!--<td>'.$value['time_ago'].'</td>-->
                <td>'.$value['total_amont'].'</td>
                <td>'.$driver_name.'</td>
                <td>'.$value['dated'].'</td>
              </tr>';
            } 

            echo $response.'***||***'.$total_count.'***||***'.$page_links.'***||***'.$pendingcount.'***||***'.$completedcount.'***||***'.$declinecount;
	    }else{
		 echo "nororders"; exit;	
		}
    }
	
	
	public function payout_ajax($page)
    {   

		$previous_week = strtotime("-1 week +1 day");

		$start_week = strtotime("last sunday midnight",$previous_week);
		$end_week = strtotime("next saturday",$start_week);
		
		$start_week = date("Y-m-d",$this->input->post('date_from'));
		$end_week   = date("Y-m-d",$this->input->post('date_too'));
		
				
		$get_data = $this->db->query("Select user_id,name,SUM(amount) as total_revenue, count(id) as total_orders from tblpayout 
		WHERE created_at >= '$start_week' AND created_at <= '$end_week' AND amount > 0 AND   group by user_id,name");
		$data_arr = $get_data->result_array();
		echo "<prE>";  print_r($data_arr ); exit;
		
		if(count($data_arr)>0){ 


        $response = '';
		$pendingcount   = 0;
		$completedcount = 0;
		$declinecount   = 0;
        foreach ($data_arr as $key => $value) {
			
		 
          $newkey = $key+1;
		   
		  
		  $response .='<tr role="row">
           
		     <td>'.$newkey.'</td>
		    <td>'.$value['user_id'].'</td>
            <td>'.($value['name']==" " || $value['name']=="") ? "<span>N/A</span>" : $value['name'].'</td>
            <td>'.$value['total_orders'].'</td>
            <td>'.number_format((float)$value['total_revenue'], 2, '.', '').'</td>
            <td>'.number_format((float)$value['total_revenue'], 2, '.', '').'</td>
			<td><span class="label label-success">Paid</span></td>
            
          </tr>';
        } 

        echo $response.'***||***'.$total_count.'***||***'.$page_links.'***||***'.$pendingcount.'***||***'.$completedcount.'***||***'.$declinecount;
	    }else{
		 echo "nororders"; exit;	
		}
    }

    public function clients_ajax_select($client_id=''){

        $results = $this->clients_model->get_ajax_clients($this->input->post(),$client_id);

        echo json_encode($results);
        exit;
    }
	
	
	  public function payouts_ajax_select($client_id=''){

        $results = $this->clients_model->get_ajax_clients($this->input->post(),$client_id);

        echo json_encode($results);
        exit;
    }

    public function contacts_ajax_select($user_id=''){

        $results = $this->clients_model->get_ajax_contacts($this->input->post(),$user_id);

        echo json_encode($results);
        exit;
    }

    public function get_orders_graph(){

        $results = $this->clients_model->get_orders_graph($this->input->post());
        echo json_encode($results);
        exit;
    }

 

    public function get_sales_graph(){

        $results = $this->clients_model->get_sales_graph($this->input->post());
        echo json_encode($results);
        exit;
    }

    public function get_orders_stats(){

        $results = $this->clients_model->get_orders_stats($this->input->post());

        echo json_encode($results);
        exit;
    }

    public function user_detail()
    {
        
        $data['title'] = _l('user details');
        $this->load->view('admin/clients/user_detail', $data);
    }
	
	public function customer_dashboard()
    {   
	    ini_set("memory_limit","-1");
    	$data['cities'] = $this->clients_model->get_all_cities();
        $data['stats'] = $this->clients_model->customer_dashboard_stats($_GET);
        $data['never_purchased'] = $this->clients_model->customer_never_purchased('',$_GET);
		$data['never_purchased_7_days'] = $this->clients_model->customer_never_purchased(7,$_GET);
		$data['never_purchased_14_days'] = $this->clients_model->customer_never_purchased(14,$_GET);
		$data['never_purchased_30_days'] = $this->clients_model->customer_never_purchased(30,$_GET);
		$data['never_purchased_60_days'] = $this->clients_model->customer_never_purchased(60,$_GET);
		$data['never_purchased_90_days'] = $this->clients_model->customer_never_purchased(90,$_GET);
        $data['first_purchased'] = $this->clients_model->customer_first_purchased($_GET);
        $data['purchased_10'] = $this->clients_model->customer_not_purchased(10,$_GET);
        $data['top_10_restaurants'] = $this->clients_model->top_10_restaurants($_GET);

        $data['new_signups'] = $this->clients_model->new_signups($_GET);

        $data['top_10_contacts'] = $this->clients_model->top_10_contacts($_GET);
        $data['title'] = _l('Customer Dashboard');
        $this->load->view('admin/clients/customer_dashboard', $data);
    }

    public function customer_never_purchased_ajax()
    {   
        $range = $this->input->post('range');
        $never_purchased = $this->clients_model->customer_never_purchased($range,$this->input->post());
        foreach($never_purchased as $key => $value){ ?>
                                    
            <tr >
                <td class="wd-lg-25p"><?php echo $key+1; ?></td>
                <td class="wd-lg-25p pull-left"><a href="<?php echo admin_url()?>clients/customer_details/<?php echo $value['dryvarfoods_id'] ?>" target="_blank" ><?php echo ucfirst($value['firstname'])?> </a></td>
                <td class="wd-lg-25p"><?php echo date('jS \of F',strtotime($value['datecreated']))?></td>
            </tr>
        <?php }
        exit;
    }

    public function customer_insights()
    {
        $results = $this->clients_model->customer_not_purchased(10);
        echo '<pre>';
        print_r($results);
        exit;
    }
	
	public function get_customer_order_details($user_id){
		$this->clients_model->get_customer_order_details($user_id); 
	}
	
	public function get_area_order_stats(){
		
		$get_data = $this->db->query("SELECT COUNT(*) as y FROM tblorder_delivery WHERE drop_location like '%Addington%' OR 
		drop_location like '%Berea%' OR drop_location like '%Bluff%' OR drop_location like '%Chatsworth%' OR 
		drop_location like '%Clairwood%' OR drop_location like '%Durban Central%' OR 
		drop_location like '%Durban North%' OR drop_location like '%Durban Point%' OR drop_location like '%Emachobeni%' OR
		drop_location like '%Inanda%' OR drop_location like '%Iqadi%' OR drop_location like '%kwaMashu%' OR 
		drop_location like '%Mathabetule%' OR drop_location like '%Mawothi%' OR drop_location like '%Newlands East%' OR 
		drop_location like '%Newlands West%' OR drop_location like '%North Beach%' OR drop_location like '%Phoenix%' OR 
		drop_location like '%Senzokuhle%' OR drop_location like '%South Beach%' OR drop_location like '%Stamford Hill%' OR drop_location like '%Umlazi%'");
		$data_arr = $get_data->row_array();
		$data[] = array('Central',intval($data_arr['y']),false);
		


		$get_data = $this->db->query("SELECT COUNT(*) as y FROM tblorder_delivery WHERE drop_location like '%Clermont%' OR 
		drop_location like '%Klaarwater%' OR drop_location like '%kwaDabeka%' OR drop_location like '%kwaNdengezi%' OR 
		drop_location like '%New Germany%' OR drop_location like '%Luganda%' OR 
		drop_location like '%Mpolo%' OR drop_location like '%Pinetown%' OR drop_location like '%Queensburgh%' OR
		drop_location like '%Reservoir Hills%' OR drop_location like '%Tshelimnyama%' OR drop_location like '%Westville%'");
		$data_arr = $get_data->row_array();
		$data[] = array('Inner West',intval($data_arr['y']),false); 
		
		
		$get_data = $this->db->query("SELECT COUNT(*) as y FROM tblorder_delivery WHERE drop_location like '%Amaotana%' OR drop_location like '%Blackburn%' OR drop_location like '%Desanaiger%' OR drop_location like '%Emona%' OR drop_location like '%Genazzano%' OR drop_location like '%Hambanathi%' OR drop_location like '%La Mercy%' OR drop_location like '%Mount Edgecombe%' OR drop_location like '%Mount Moreland%' OR drop_location like '%Redcliffe%' OR drop_location like '%Tongaat%' OR drop_location like '%Tongaat Beach%' OR drop_location like '%Umdloti%' OR drop_location like '%Umhlanga%' OR drop_location like '%Verulam%' OR drop_location like '%Westbrook%'");
		$data_arr = $get_data->row_array();
		$data[] = array('North',intval($data_arr['y']),false);
		
		$get_data = $this->db->query("SELECT COUNT(*) as y FROM tblorder_delivery WHERE drop_location like '%Assagay%' OR drop_location like '%Bothas Hill%' OR drop_location like '%Cato Ridge%' OR drop_location like '%Cliffdale%' OR drop_location like '%Clifton Canyon%' OR drop_location like '%Emalangeni%' OR drop_location like '%Gillitts%' OR drop_location like '%Hammarsdale%' OR drop_location like '%Hillcrest%' OR drop_location like '%Inchanga%' OR drop_location like '%Kloof%' OR drop_location like '%Maphepheta%' OR drop_location like '%Molweni%' OR drop_location like '%Mpumalanga%' OR drop_location like '%Ngcolosi%' OR drop_location like '%Ngqungqulu%' OR drop_location like '%Peacevale%' OR drop_location like '%Shongweni%' OR drop_location like '%Ximba%'");
		$data_arr = $get_data->row_array();
		$data[] = array('Outer West',intval($data_arr['y']),false);
		
		
		$get_data = $this->db->query("SELECT COUNT(*) as y FROM tblorder_delivery WHERE drop_location like '%Adams Rural%' OR drop_location like '%Amanzimtoti%' OR drop_location like '%Cele%' OR drop_location like '%Folweni%' OR drop_location like '%Illovo North%' OR drop_location like '%Illovo South%' OR drop_location like '%Isipingo%' OR drop_location like '%Kingsburgh%' OR drop_location like '%Nkomokazi%' OR drop_location like '%Umbumbulu%' OR drop_location like '%Umgababa%' OR drop_location like '%Umkomaas%'");
		$data_arr = $get_data->row_array();
		$data[] = array('South',intval($data_arr['y']),false); 
		
		echo json_encode($data);
	
    }

    public function customer_details($userid)
    {   
        // $timeline = $this->clients_model->get_orders_timeline($userid);
	   //echo "<pre>";  print_r($timeline); exit;
	   
	    $filter_array = array("customer_id" => $userid);
        $customer = $this->clients_model->get_customer($filter_array);
		
		$data["favourite_store"] = $this->clients_model->get_customer_fav_store($filter_array);
		$data["favourite_meal_item"] = $this->clients_model->get_customer_fav_meal_item($filter_array);
        $data["completed_orders_revenue"] = 	$this->clients_model->get_orders_revenue($filter_array, 'completed');	
		$data["declined_orders_revenue"] = 	$this->clients_model->get_orders_revenue($filter_array, 'declined');	
		$data["order_frequency"] = $this->clients_model->get_customer_order_frequency($userid);
		//$data["meal_preference"] = $this->clients_model->get_customer_meal_preference($userid);

        $data['title']      = _l('Customer Details');
        $data['userid']     = $userid;
        $data['timeline']   = array();
		$data['customer']   = $customer;
		
        $this->load->view('admin/clients/customer_order_details', $data);
    }

    public function customer_details_ajax()
    {   
        // $timeline = $this->clients_model->get_orders_timeline($userid);
	   //echo "<pre>";  print_r($timeline); exit;
	    $customer_id = $this->input->post("customer_id");
		$from_date = $this->input->post("date_from");
		$to_date = $this->input->post("date_to");
		
		$filter_array = array("customer_id" => $customer_id, "from_date" => $from_date, "to_date" => $to_date);
		
		$customer = $this->clients_model->get_customer($filter_array);
		
		$data["favourite_store"] = $this->clients_model->get_customer_fav_store($filter_array);
		$data["favourite_meal_item"] = $this->clients_model->get_customer_fav_meal_item($filter_array);
        $data["completed_orders_revenue"] = 	$this->clients_model->get_orders_revenue($filter_array, 'completed');	
		$data["declined_orders_revenue"] = 	$this->clients_model->get_orders_revenue($filter_array, 'declined');	
		$data["order_frequency"] = $this->clients_model->get_customer_order_frequency($customer_id);
		//$data["meal_preference"] = $this->clients_model->get_customer_meal_preference($userid);

        $data['title']      = _l('Customer Details');
        $data['userid']     = $customer_id;
        $data['timeline']   = array();
		$data['customer']   = $customer;
		
        $this->load->view('admin/clients/customer_order_details_ajax', $data);
    }


    public function get_timeline_graph_data($userid){

        $timeline = $this->clients_model->get_orders_timeline($userid);

        echo json_encode($timeline,true);
        exit;
    }

    public function referral_customer_details($userid)
    {   
        // $timeline = $this->clients_model->get_orders_timeline($userid);
       //echo "<pre>";  print_r($timeline); exit;
       
        $customer = $this->clients_model->get_customer($userid);

        $reward_arr   = $this->clients_model->get_user_reward_available($userid);
        $loyality_arr = $this->clients_model->get_user_loyality_used($userid);
       
        $data['reward_available']   = $reward_arr['total_available_points'];
        $data['reward_used']        = $reward_arr['total_used_points'];
        $data['loyality_available'] = $loyality_arr['total_available_points'];
        $data['loyality_used']      = $loyality_arr['total_used_points'];

        $data['title']      = _l('Customer Details');
        $data['userid']     = $userid;
        $data['timeline']   = array();
        $data['customer']   = $customer;
        
        $this->load->view('admin/clients/referral_customer_order_details', $data);
    }

    public function orders_reward_history_ajax($userid){  	

        $get_rewards_data = $this->clients_model->get_rewards_point_reporting($userid);

		exit;

    }

    public function insert_cities_script(){

    	$durban_cities = array(
			'Addington',
			'Berea',
		    'Bluff',
		    'Chatswth',
		    'Clairwood',
		    'Durban Central',
		    'Durban Nth',
		    'Durban Point',
		    'Emachobeni',
		    'Inanda',
		    'Iqadi',
		    'kwaMashu',
		    'Mathabetule',
		    'Mawothi',
		    'Newlands East',
		    'Newlands West',
		    'Nth Beach',
		    'Phoenix',
			'Senzokuhle',
		    'South Beach',
		    'Stamfd Hill',
		    'Umlazi',
		  	'Clermont',
			'Klaarwater',
		    'kwaDabeka',
		    'kwaNdengezi',
			'New Germany',
		    'Luganda',
			'Mpolo',
		    'Pinetown',
		    'Queensburgh',
		  	'Reservoir Hills',
		    'Tshelimnyama',
		    'Westville',
		  	'Amaotana',
		    'Blackburn',
		    'Desanaiger',
		    'Emona',
		    'Genazzano',
		    'Hambanathi',
		    'La Mercy',
		    'Mount Edgecombe',
		    'Mount Meland',
		    'Redcliffe',
		    'Tongaat',
		    'Tongaat Beach',
		    'Umdloti',
		    'Umhlanga',
		    'Verulam',
		    'Westbrook',
		  	'Assagay',
		    'Bothas Hill',
		    'Cato Ridge',
		    'Cliffdale',
		    'Clifton Canyon',
		    'Emalangeni',
		    'Gillitts',
		    'Hammarsdale',
		    'Hillcrest',
		    'Inchanga',
		    'Kloof',
		    'Maphepheta',
		    'Molweni',
		    'Mpumalanga',
		    'Ngcolosi',
		    'Ngqungqulu',
		    'Peacevale',
		    'Shongweni',
		    'Ximba',
		  	'Adams Rural',
		    'Amanzimtoti',
		    'Cele',
		    'Folweni',
		    'Illovo Nth',
		    'Illovo South',
		    'Isipingo',
		    'Kingsburgh',
		    'Nkomokazi',
		    'Umbumbulu',
		    'Umgababa',
		    'Umkomaas'
		);

		foreach ($durban_cities as $key => $value) {
			$this->db->insert('tblcities',array('city_name' => $value,'state_name' => 'Durban'));
		}
    }
	
	public function commission(){

		$data['commission'] = $this->clients_model->commission($_GET);
		$this->load->view('admin/clients/commission', $data);
	}



	public function resturant_payout(){
		
		$data['commission'] = $this->clients_model->commission();
		$this->load->view('admin/clients/resturant_payout', $data);
	}

   
    public function weekly_payout($name){
		
		$data['weekly_payout'] = $this->clients_model->weekly_payout($name);
		$data['name']          =  $name;
		$this->load->view('admin/clients/weekly_payout', $data);
	}

    public function sales_commission(){
        
        $commission_arr = $this->clients_model->sales_commission($_GET);
        $total_s_amt = 0 ; $total_c_amt = 0; $total_o = 0 ; $total_p_amt = 0;
        foreach ($commission_arr as $key => $value) { 

        	$sales_amount = $value['sales_data']['total_sales'];
          	$percent      = $value['commission'];
          	$commission   = ( $percent * $sales_amount ) / 100 ;

          	$payout = $sales_amount - $commission;

          	$total_s_amt = $total_s_amt + $sales_amount;
          	$total_c_amt = $total_c_amt + $commission;
          	$total_o = $total_o + $value['sales_data']['total_orders'];
          	$total_p_amt = $total_p_amt + $payout;


        }

        $data['total_s_amt'] = $total_s_amt;

        $data['total_c_amt'] = $total_c_amt;

        $data['total_o'] = $total_o;

        $data['total_p_amt'] = $total_p_amt;

        $data['commission'] = $commission_arr;

        $data['cities'] = $this->clients_model->get_all_cities();
        $this->load->view('admin/clients/sales_commission', $data);
    }
	
	public function delete_notification($id){
		 
		
		$delte = $this->db->query("DELETE FROM `notifications` WHERE `id` =  ".$id."");
		$sql = $this->db->last_query();
		if($delte){
		    $this->session->set_flashdata('ok_message', ' Notification deleted successfully.');
			redirect(base_url().'admin/clients/notifications');		
		}
    }
	
	 public function schedule_message(){
		$this->load->model('mod_common');
        $data['cities'] = $this->mod_common->get_all_records("tblcontacts", "DISTINCT(city)", 0, 0, array("device_id !=" => ""), "city", "ASC");
		$data['restaurants'] = $this->mod_common->get_all_records("tblcontacts", "*", 0, 0, array("device_id !=" => ""));
        $this->load->view('admin/clients/schedule_message', $data);
    }
	
	public function submit_message(){
		
		        $this->load->model('mod_common');
				$this->load->library('form_validation');
                $this->form_validation->set_rules('title', 'Title', 'required');
		        $this->form_validation->set_rules('message', 'Message', 'required');
				$this->form_validation->set_rules('date', 'Date', 'required');
				
			    if ($this->form_validation->run() == FALSE)
				{
          
				   echo "<p class='text-danger'>All Fields are required</p>";
				}
				else{

					$table = "notifications";
					
					$title = $this->input->post('title');
					$message_type = $this->input->post('message_type');
					$notification_type = $this->input->post('notification_type');
					$user_type = $this->input->post('user_type');
					$user_id = $this->input->post('clients_select');
					$to_type = $this->input->post('user');
					$user_type = $this->input->post('user_type');
					$message = $this->input->post('message');
					$date = date("Y-m-d", strtotime($this->input->post('date')));
					$created_date = date("Y-m-d h:i A");
					$hours = $this->input->post('hours');
					$minutes = $this->input->post("minutes");
					$city = $this->input->post("city_select");
					$fromdate = date("Y-m-d", strtotime($this->input->post("fromdate")));
					$todate = date("Y-m-d", strtotime($this->input->post("todate")));
					$insight_select = $this->input->post("insight_select");
					
					$filename = "";
					if (isset($_FILES['attachment']['name']) && $_FILES['attachment']['name'] != "") {
						
						$projects_folder_path = './assets/uploads/';
						$projects_folder_path_main = './assets/uploads/';

						$thumb = $projects_folder_path_main . 'thumb';

						$config['upload_path'] = $projects_folder_path;
						$config['allowed_types'] = 'jpg|jpeg|gif|tiff|tif|png|JPG|JPEG|GIF|TIFF|TIF|PNG';
						$config['overwrite'] = false;
						$config['encrypt_name'] = TRUE;
						

						$this->load->library('upload', $config);
						$this->upload->initialize($config);

						if (!$this->upload->do_upload('attachment')) {
							$error_file_arr = array('error' => $this->upload->display_errors());
							print_r($error_file_arr);exit;
							
						} else {

							$data_image_upload = array('upload_image_data' => $this->upload->data());
							$filename = $data_image_upload['upload_image_data']['file_name'];
							$full_path = $data_image_upload['upload_image_data']['full_path'];
							
							create_optimize($filename, $full_path, $projects_folder_path_main);
                            create_fixed_thumbnail($filename, $full_path, $thumb);
                            
							
						}
					}

                    
					 
					 $city    = ($to_type == "city")?$city:"";
					 $user_id = ($to_type == "all")?"":$user_id;
					 $user_id = implode("***",$user_id);
					 $city    = implode("***",$city);
			
					$ins_array = array(
					    "message_type" => $message_type,
						"notification_type" => $notification_type,
						"user_type" => $user_type,
                        "to_type" => $to_type,
						"user_id" => $user_id,
						"title" => $title,
                        "message" => $message,
                        "date" => $date,
						"city" => $city,
                        "hours" => $hours,
						"minutes" => $minutes,
						"image_url" => $filename,
						"insight_select" => $insight_select,
						"customer_from_date" => $fromdate,
						"customer_to_date"   => $todate,
						"created_date"       => $created_date,
						
					);
					
					//echo "<pre>";  print_r($ins_array); exit;
					
					$timestampinmiliseconds = strtotime($date." ".$hours.":".$minutes);
		            $add_notification = $this->mod_common->insert_into_table($table, $ins_array);
					//$add_notification = $this->db->insert('notifications', $ins_array);
					
					/*$query  = "INSERT INTO `notifications`(`id`, `message_type`, `notification_type`, `user_type`, `to_type`, `user_id`, `title`, `message`, `date`, `hours`, `minutes`, `image_url`, `city`, `status`, `count_notification`, `failure_notification`, `created_date`) VALUES ('','".$message_type."','".$notification_type."','".$user_type."','".$to_type."','".$user_id."','".$title."','".$message."','".$date."','".$hours."','".$minutes."','". $filename."','".$city."',0,0,0,'".$created_date."')";*/
					  
				
					//$add_notification = $this->db->query($query);
					//$str = $this->db->last_query();
					
                    if($to_type == "all"){
						$restaurants = $this->mod_common->get_all_records("tblcontacts", "*", 0, 0, array("device_id !=" => ""));				
					}
					else{
						$restaurants = $this->mod_common->get_all_records("tblcontacts", "*", 0, 0, array("device_id !=" => "", "city" => $city));
					}
					
						
					
					if($add_notification){
						$bigPicture = "";
						if($filename!=""){ 
							$bigPicture = AURL."assets/uploads".$filename;
						}
						/*echo date("Y-m-d H:i");
						echo "<br>";*/
						$date1 = strtotime(date("Y-m-d H:i"));
						//echo "<br>";
			            $date2 = strtotime($date." ".$hours.":".$minutes);
						//echo "<br>";
						/*echo $date." ".$hours.":".$minutes;*/
						if($notification_type == 1 && $message_type == 2){
							
								// require_once('/var/www/html/dryvar.com/public_html/wonderpush-php-lib/init.php');
								
								// $wonderpush = new \WonderPush\WonderPush("NzY4ZWYzMDNhMjRlZWJlZTU3MjQ3MmFmZDJlNDBhZWIzYmVkNGYxODhlMGZkMjhhOWFiM2U3YzE3NjZlYjc1Mg", "01ehekuj745fi602");
								// if($to_type=="all"){
								// 	$response = $wonderpush->deliveries()->create(
								// 		\WonderPush\Params\DeliveriesCreateParams::_new()
								// 			->setTargetSegmentIds('@ALL')
								// 				->setNotification(\WonderPush\Obj\Notification::_new()
								// 					->setAlert(\WonderPush\Obj\NotificationAlert::_new()
								// 						->setAndroid(\WonderPush\Obj\NotificationAlertAndroid::_new()
								// 							->setBigTitle($title)
								// 							->setBigText($message)
								// 							->setBigPicture($bigPicture)
								// 							->setWhen($timestampinmiliseconds)
								// 				)))
								// 	);
								// }
								// else{
								// 	if($to_type == "city"){
								// 		foreach($restaurants as $val){
								// 			$response = $wonderpush->deliveries()->create(
								// 			\WonderPush\Params\DeliveriesCreateParams::_new()
								// 				->setTargetPushTokens($val["device_id"])
								// 				->setNotification(\WonderPush\Obj\Notification::_new()
								// 					->setAlert(\WonderPush\Obj\NotificationAlert::_new()
								// 						->setAndroid(\WonderPush\Obj\NotificationAlertAndroid::_new()
								// 							->setBigTitle($title)
								// 							->setBigText($message)
								// 							->setBigPicture($bigPicture)
								// 							->setWhen($timestampinmiliseconds)
															
								// 					)))
								// 		);
								// 		}
								// 	}
								// 	else{
										
										
								// 		$response = $wonderpush->deliveries()->create(
								// 			\WonderPush\Params\DeliveriesCreateParams::_new()
								// 				->setTargetPushTokens("Android:".$user_id)
								// 				->setNotification(\WonderPush\Obj\Notification::_new()
								// 					->setAlert(\WonderPush\Obj\NotificationAlert::_new()
								// 						->setAndroid(\WonderPush\Obj\NotificationAlertAndroid::_new()
								// 							->setBigTitle($title)
								// 							->setBigText($message)
								// 							->setBigPicture($bigPicture)
								// 							->setWhen($timestampinmiliseconds)
															
								// 					)))
								// 		);
								// 		/////d9rGRonMTVGxd46PZYA30m:APA91bE7mAvGZjWXXZWFsq0iP2XUR0Vnd8XJqUqPwNda5bx2UbdVm6pRtMp0ZpODttmiy56_EFMXB2FhQimGSOsFuYpAduCCodin8CFUqksga_qD0Poh82RVL85c4pCdov9ZBjkQewQ4
										
								// 		$response = $wonderpush->deliveries()->create(
								// 			\WonderPush\Params\DeliveriesCreateParams::_new()
								// 				->setTargetPushTokens("Android:".'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjEwMDA0LCJpc3MiOiJodHRwczovL2Rldi5kcnl2YXJmb29kcy5jb20vYXBpL2xvZ2luIiwiaWF0IjoxNjAwOTMyNDM3LCJleHAiOjE2MjY4NTI0MzcsIm5iZiI6MTYwMDkzMjQzNywianRpIjoiYVFZTjBRVlJiWGV3YlBzTyJ9.tk_xW-Ua6pLEhqSUtZ1-qQpIaiQTN3eJ7brsWVn7C_E')
								// 				->setNotification(\WonderPush\Obj\Notification::_new()
								// 					->setAlert(\WonderPush\Obj\NotificationAlert::_new()
								// 						->setAndroid(\WonderPush\Obj\NotificationAlertAndroid::_new()
								// 							->setBigTitle($title)
								// 							->setBigText($message)
								// 							->setBigPicture($bigPicture)
								// 							->setWhen($timestampinmiliseconds)
															
								// 					)))
								// 		);
										
								// 		//////
										
										
										
								// 	}
								// }
						}
						else if($notification_type == 2 && $message_type == 2 && ($date1 > $date2 || $date1 == $date2)){
							
							$registatoin_ids = array();
							
                            if($to_type == "specific"){
								
								$registatoin_ids[] = $user_id;
							}
							else{
							    foreach($restaurants as $val){
									$registatoin_ids[] = $val["device_id"];
								}
							}
			
							//$this->sendPush($registatoin_ids, $title, $message, $add_notification);
							 
                        }
                        else{
                           // Send SMS Code Section
              			}				
							echo "sent";
					}
        }
	} 

    public function notifications($filtertype='',$data_id='')
    {   

        $data['filtertype']   = $filtertype;
        $data['data_id']      = $data_id;

        if( $filtertype !=''){
            $input_arr = array( $filtertype => $data_id);
        }else{ 
		    $input_arr = array();
		}

        $count_total_leads = $this->clients_model->count_notifications('',$input_arr);
        $data['total_count'] = $count_total_leads;
        //Pagination
        $this->load->library('pagination');
        $config['base_url'] = base_url().'admin/clients/notifications';
        $config['total_rows'] = $count_total_leads;
    
        $config['per_page'] = 25;
        $config['num_links'] = 10;
        $config['use_page_numbers'] = TRUE;
        $config['uri_segment'] = 4;
        $config['reuse_query_string'] = TRUE;

        $config["first_tag_open"] = '<li>';
        $config["first_tag_close"] = '</li>';

        $config["last_tag_open"] = '<li>';
        $config["last_tag_close"] = '</li>';
        
        $config['next_link'] = '&raquo;';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        
        $config['prev_link'] = '&laquo;';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';
        
        $config['first_link'] = 'First';
        $config['last_link'] = 'Last';
        
        $config['full_tag_open'] = '<ul class="pagination notification_filter_pagination">';
        $config['full_tag_close'] = '</ul>';
        
        $config['cur_tag_open'] = '<li class="active"><a href="#"><b>';
        $config['cur_tag_close'] = '</b></a></li>';
        
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
        if($page !=0) $page = ($page-1) * $config['per_page'];

        $data['page_links'] = $this->pagination->create_links();
        
        $data['notifications'] = $this->clients_model->get_notifications($input_arr,$page,$config["per_page"]);
		
		$data['notifications_count'] = $this->clients_model->count_notifications();
		
		$data['notifications_count_completed'] = $this->clients_model->count_notifications_statuses(2);
		$data['notifications_count_pending'] = $this->clients_model->count_notifications_statuses(0);
		$data['notifications_count_inprogress'] = $this->clients_model->count_notifications_statuses(1);
		
		


        $data['title'] = "Customer Notifications";
        $this->load->view('admin/clients/all_notifications', $data);
    }


     public function notifications_ajax($page)
    {   

        $count_total_leads = $this->clients_model->count_notifications('',$this->input->post());
		
		$pendingcount   = 0;
		$completedcount = 0;
		$inprogresscount   = 0;
		
		$completedcount = $this->clients_model->count_notifications_statuses(2, $this->input->post());
		$pendingcount = $this->clients_model->count_notifications_statuses(0, $this->input->post());
		$inprogresscount = $this->clients_model->count_notifications_statuses(1, $this->input->post());

        $total_count = $count_total_leads;
        //Pagination
        $this->load->library('pagination');
        $config['base_url'] = base_url().'admin/clients/notifications_ajax';
        $config['total_rows'] = $count_total_leads;
    
        $config['per_page'] = 25;
        $config['num_links'] = 10;
        $config['use_page_numbers'] = TRUE;
        $config['uri_segment'] = 4;
        $config['reuse_query_string'] = TRUE;

        $config["first_tag_open"] = '<li>';
        $config["first_tag_close"] = '</li>';

        $config["last_tag_open"] = '<li>';
        $config["last_tag_close"] = '</li>';
        
        $config['next_link'] = '&raquo;';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        
        $config['prev_link'] = '&laquo;';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';
        
        $config['first_link'] = 'First';
        $config['last_link'] = 'Last';
        
        $config['full_tag_open'] = '<ul class="pagination notification_filter_pagination">';
        $config['full_tag_close'] = '</ul>';
        
        $config['cur_tag_open'] = '<li class="active"><a href="#"><b>';
        $config['cur_tag_close'] = '</b></a></li>';
        
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
        if($page !=0) $page = ($page-1) * $config['per_page'];

        $page_links = $this->pagination->create_links();
        $notifications = $this->clients_model->get_notifications($this->input->post(),$page,$config["per_page"]);
		
		if(count($notifications)>0){ 


        $response = '';
		
        foreach ($notifications as $key => $value) {
			
		  if($value['status']==0){ 
			 $newstatus = '<span class="label label-warning">Pending</span>';
			 
		  }else if($value['status']==2){ 
			 $newstatus = '<span class="label label-success">Completed</span>';
			 
		  }else if($value['status']==1){ 
			 $newstatus = '<span class="label label-primary">In Progress</span>';
			 
		  }
		  

          $newkey = $key+1;
		  $lin  = '<a href="'.AURL.'clients/notification_detail/'.$value['id'].'">'.$value['id'].'</a>';
		  $to_type = "";
		   if($value['to_type'] == "city"){
						           $to_type = "Specific City";
								   $name = $value['city'];
								}
								else if($value['to_type'] == "specific"){
									$to_type = "Specific User";
									$name = get_user_name($value['user_id']);
								}
								else{
									$to_type = "All";
									$name = "";
								}
		$message_type = ($value['message_type'] == 1)?"SMS":"Push Notification";
		$notification_type = ($value['notification_type'] == 1)?"WonderPush":"FireBase Notification";
		$image = "";
		if($value['image_url']!=""){
		    $image = '<img class="notification-image" src="'.base_url().'assets/uploads/'.$value['image_url'].'">';
		}
		  
		  $response .='<tr role="row">
           
		    <td>'.$newkey.'</td>
		    <td>'.$lin.'</td>
            <td>'.$message_type.'</td>
			<td>'.$notification_type.'</td>
            <td>'.$to_type.'</td>
			<td>'.$name.'</td>
			<td>'.ucfirst($value['user_type']).'</td>
			<td>'.$image.'</td>
            <td>'.$value['title'].'</td>
            <td>'.$value['message'].'</td>
			<td>'.date("d-m-Y h:i A", strtotime($value['date']." ".$value['hours'].":".$value['minutes'])).'</td>
            <td>'.$newstatus.'</td>
          </tr>';
        } 

        echo $response.'***||***'.$total_count.'***||***'.$page_links.'***||***'.$pendingcount.'***||***'.$completedcount.'***||***'.$inprogresscount;
	    }else{
		 echo "nornotifications"; exit;	
		}
    }
	
	public function notification_detail($notification_id)
    {   

        $data['notification_arr'] =  $this->clients_model->get_notification_detail($notification_id);
		$data['notification_id']  =  $notification_id;

        $data['title'] = "Customer Notification";
        $this->load->view('admin/clients/notification_detail', $data);
    }
	
	public function export_notifications_csv()
     {
         $file_name = 'Notifications_'.date('Ymd').'.csv'; 
         header("Content-Description: File Transfer"); 
         header("Content-Disposition: attachment; filename=$file_name"); 
         header("Content-Type: application/csv;");
       
         // get data 
         $notifications = $this->clients_model->get_notifications_csv($this->input->post());
  
         // file creation 
         $file = fopen('php://output', 'w');
     
         $header = array("Notification ID","Message Type","Notification Type","To","User/City","User Type","Image","Title","Message","Status","Schedule At"); 
         fputcsv($file, $header);
         foreach ($notifications as $key => $value)
         { 
           fputcsv($file, $value); 
         }
         fclose($file); 
         exit; 
     }

public function sendPush($registatoin_ids, $title, $message, $add_notification)
{
	        $this->load->model('mod_common');
			
			$google_server_key = "AAAALqdoQl0:APA91bEdmUDByAYz9k0wQbiPhEdVDsRCmxw6tAYXXP4ZiGh8ENfhlB0vAvh75uidWj-PpU7-TTcdIJtVjzVR7S94glKAcWgzF-mbvi3hWL6DJ2cyxWrbvGn0tarC98UB_h2eEBxbdOw4"; // <-- Insert your Google API Key
			
			$url = 'https://fcm.googleapis.com/fcm/send';
		
			$headers = array(
			'Authorization:key =' . $google_server_key,
			'Content-Type: application/json'
			);
			
			$fields = array(
			'registration_ids' => $registatoin_ids,
			'notification' => array('title' => $title,
			'body' => $message,
			'click_action' => "OPEN_MAIN_1",
			'icon' => 'ic_launcher',
			'sound' => 'default'),
			'data' => array('link' => "")
			);
			
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
			$result = curl_exec($ch);
			
			if($result===FALSE){
			die("Curl failed: ".curl_error($ch));
			}
			else{
				$upd_array = array("status" => 2);
                $where = array("id" => $add_notification);
                $this->load->mod_common->update_table("notifications", $where, $upd_array); 	
			}
			curl_close($ch);
    }	

    //Referrals & Comissions

    public function referrals($data_id='')
    { 
        $data['filtertype']   = $filtertype;
        $data['data_id']      = $data_id;

        if( $filtertype !=''){
            $input_arr = array( $filtertype => $data_id);
        }else{ 
		    $input_arr = array();
		}

        $count_total_clients = $this->clients_model->count_clients($input_arr);
        $data['total_count'] = $count_total_clients;
        //Pagination
        $this->load->library('pagination');
        $config['base_url'] = base_url().'admin/clients/referrals';
        $config['total_rows'] = $count_total_clients;
    
        $config['per_page'] = 25;
        $config['num_links'] = 10;
        $config['use_page_numbers'] = TRUE;
        $config['uri_segment'] = 3;
        $config['reuse_query_string'] = TRUE;

        $config["first_tag_open"] = '<li>';
        $config["first_tag_close"] = '</li>';

        $config["last_tag_open"] = '<li>';
        $config["last_tag_close"] = '</li>';
        
        $config['next_link'] = '&raquo;';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        
        $config['prev_link'] = '&laquo;';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';
        
        $config['first_link'] = 'First';
        $config['last_link'] = 'Last';
        
        $config['full_tag_open'] = '<ul class="pagination client_filter_pagination">';
        $config['full_tag_close'] = '</ul>';
        
        $config['cur_tag_open'] = '<li class="active"><a href="#"><b>';
        $config['cur_tag_close'] = '</b></a></li>';
        
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        if($page !=0) $page = ($page-1) * $config['per_page'];

        $data['page_links'] = $this->pagination->create_links();

        $data['clients'] = $this->clients_model->get_clients($input_arr,$page,$config["per_page"]);
		
        $data['title'] = _l('Referrals & Comissions');
        $this->load->view('admin/clients/all_referrals', $data);
    }

	
	public function referrals_ajax($page)
    {   

        $count_total_clients = $this->clients_model->count_clients($this->input->post());
		
        $total_count = $count_total_clients;
        //Pagination
        $this->load->library('pagination');
        $config['base_url'] = base_url().'admin/clients/referrals_ajax';
        $config['total_rows'] = $count_total_clients;
    
        $config['per_page'] = 25;
        $config['num_links'] = 10;
        $config['use_page_numbers'] = TRUE;
        $config['uri_segment'] = 4;
        $config['reuse_query_string'] = TRUE;

        $config["first_tag_open"] = '<li>';
        $config["first_tag_close"] = '</li>';

        $config["last_tag_open"] = '<li>';
        $config["last_tag_close"] = '</li>';
        
        $config['next_link'] = '&raquo;';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        
        $config['prev_link'] = '&laquo;';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';
        
        $config['first_link'] = 'First';
        $config['last_link'] = 'Last';
        
        $config['full_tag_open'] = '<ul class="pagination client_filter_pagination">';
        $config['full_tag_close'] = '</ul>';
        
        $config['cur_tag_open'] = '<li class="active"><a href="#"><b>';
        $config['cur_tag_close'] = '</b></a></li>';
        
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
        if($page !=0) $page = ($page-1) * $config['per_page'];

        $page_links = $this->pagination->create_links();
		
        $clients = $this->clients_model->get_clients($this->input->post(),$page,$config["per_page"]);
		
		if(count($clients)>0){ 


        $response = '';
		
        foreach ($clients as $key => $value) {
			
          $newkey = $key+1;
		  $lin  = '<a href="'.AURL.'clients/customer_details/'.$value['dryvarfoods_id'].'">'.$value['dryvarfoods_id'].'</a>';
		  if($value['last_order']!=""){
		  $last_order_link  = '<a target="_Blank" href="'.AURL.'orders/orders_detail/'.$value['last_order'].'">#'.$value['last_order'].'</a>';
		  }
		  else{
			$last_order_link = "<span class='label label-danger'>Never Purchased</span>"; 
		  }
		  $order_last_30_days = ($value["orders_last_30_days"]==0)?"<span class='label label-primary'>No Orders</span>":"<span class='label label-success'>".$value["orders_last_30_days"]."</span>";
		  $total_orders = ($value["total_orders"]=="")?"<span class='label label-danger'>Never Purchased</span>":"<span class='label label-success'>".$value["total_orders"]."</span>";
		  
		  $response .='<tr role="row">
		    <td>'.$newkey.'</td>
		    <td>'.$lin.'</td>
            <td>'.$value["firstname"].'</td>
            <td>'.$value["email"].'</td>
            <td>'.$value["phonenumber"].'</td>
			<td>'.$value["city"].'</td>
            <td><span class="label label-success">0</span></td>
            <td><span class="label label-success">0</span></td>
            <td>'.$last_order_link.'</td>
			<td>'.$order_last_30_days.'</td>
            <td>'.$total_orders.'</td>
			<td>'.$value["email_verified_at"].'</td>
          </tr>';
        } 

        echo $response.'***||***'.$total_count.'***||***'.$page_links;
	    }else{
		 echo "norclients"; exit;	
		}
    }


	public function export_referrals()
     {
			 $file_name = 'Referrals_'.date('Ymd').'.csv'; 
			 header("Content-Description: File Transfer"); 
			 header("Content-Disposition: attachment; filename=$file_name"); 
			 header("Content-Type: application/csv;");
		   
			 // get data 
			 $clients = $this->clients_model->get_referrals_csv($this->input->post());
	  
			 // file creation 
			 $file = fopen('php://output', 'w');
		 
			 $header = array("Customer ID","Name","Email","Phone Number","City","Last Order","Orders Last 30 Days","Total Orders","Verified Email At"); 
             fputcsv($file, $header);
			 foreach ($clients as $key => $value)
			 { 
			   fputcsv($file, $value); 
			 }
			 fclose($file); 
    }
	 

    public function referrals_dashboard(){

        ini_set("memory_limit","-1");
        
        $data['cities'] = $this->clients_model->get_all_cities();
        $data['stats'] = $this->clients_model->customer_dashboard_stats($_GET);
        $data['never_purchased'] = $this->clients_model->customer_never_purchased(7,$_GET);
        $data['first_purchased'] = $this->clients_model->customer_first_purchased($_GET);
        $data['purchased_10'] = $this->clients_model->customer_not_purchased(10,$_GET);
        $data['top_10_restaurants'] = $this->clients_model->top_10_restaurants($_GET);

        $data['new_signups'] = $this->clients_model->new_signups($_GET);

        $data['top_10_contacts'] = $this->clients_model->top_10_contacts($_GET);
        $data['title'] = _l('Referral Customer Dashboard');
        $this->load->view('admin/clients/referral_customer_dashboard', $data);

    }


    public function recommended_customers_food(){

        $data['data_id']      = $data_id;

        if( $filtertype !=''){
            $input_arr = array( $filtertype => $data_id);
        }else{ 
            $input_arr = array();
        }

        $count_total_clients = $this->clients_model->count_recommended_food_user();
        $data['total_count'] = $count_total_clients;
        //Pagination
        $this->load->library('pagination');
        $config['base_url'] = base_url().'admin/clients/recommended_customers_food';
        $config['total_rows'] = $count_total_clients;
        $config['per_page']         = 25;
        $config['num_links']        = 10;
        $config['use_page_numbers'] = TRUE;
        $config['uri_segment']      = 3;
        $config['reuse_query_string'] = TRUE;
        $config["first_tag_open"]   = '<li>';
        $config["first_tag_close"]  = '</li>';
        $config["last_tag_open"]    = '<li>';
        $config["last_tag_close"]   = '</li>';
        $config['next_link']        = '&raquo;';
        $config['next_tag_open']    = '<li>';
        $config['next_tag_close']   = '</li>';
        $config['prev_link']        = '&laquo;';
        $config['prev_tag_open']    = '<li>';
        $config['prev_tag_close']   = '</li>';
        $config['first_link']       = 'First';
        $config['last_link']        = 'Last';
        $config['full_tag_open']    = '<ul class="pagination client_filter_pagination">';
        $config['full_tag_close']   = '</ul>';
        $config['cur_tag_open']     = '<li class="active"><a href="#"><b>';
        $config['cur_tag_close']    = '</b></a></li>';
        $config['num_tag_open']     = '<li>';
        $config['num_tag_close']    = '</li>';
        
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        if($page !=0) $page = ($page-1) * $config['per_page'];
        $page = 0;
        $data['page_links'] = $this->pagination->create_links();

        $data['clients'] = $this->clients_model->get_recommended_food_user($input_arr,$page,$config["per_page"]);
        
        $data['title'] = _l('Customer Recommended Food');
        $this->load->view('admin/clients/recommended_customer_food', $data);

    }

    public function recommended_customers_food_ajax($page){

        if( $filtertype !=''){
            $input_arr = array( $filtertype => $data_id);
        }else{ 
            $input_arr = array();
        }

        $count_total_clients = $this->clients_model->count_recommended_food_user();
        
        //Pagination
        $this->load->library('pagination');
        $config['base_url'] = base_url().'admin/clients/recommended_customers_food';
        $config['total_rows'] = $count_total_clients;
        $config['per_page']         = 25;
        $config['num_links']        = 10;
        $config['use_page_numbers'] = TRUE;
        $config['uri_segment']      = 4;
        $config['reuse_query_string'] = TRUE;
        $config["first_tag_open"]   = '<li>';
        $config["first_tag_close"]  = '</li>';
        $config["last_tag_open"]    = '<li>';
        $config["last_tag_close"]   = '</li>';
        $config['next_link']        = '&raquo;';
        $config['next_tag_open']    = '<li>';
        $config['next_tag_close']   = '</li>';
        $config['prev_link']        = '&laquo;';
        $config['prev_tag_open']    = '<li>';
        $config['prev_tag_close']   = '</li>';
        $config['first_link']       = 'First';
        $config['last_link']        = 'Last';
        $config['full_tag_open']    = '<ul class="pagination client_filter_pagination">';
        $config['full_tag_close']   = '</ul>';
        $config['cur_tag_open']     = '<li class="active"><a href="#"><b>';
        $config['cur_tag_close']    = '</b></a></li>';
        $config['num_tag_open']     = '<li>';
        $config['num_tag_close']    = '</li>';
        
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
        if($page !=0) $page = ($page-1) * $config['per_page'];

        $page_links = $this->pagination->create_links();

        $clients = $this->clients_model->get_recommended_food_user($input_arr,$page,$config["per_page"]);
        	

        if(count($clients)>0){ 


	        $response = '';
			
	        foreach ($clients as $key => $value) {
				
	          $newkey = $key+1;
			  $lin  = '<a href="'.AURL.'clients/customer_details/'.$value['dryvarfoods_id'].'">'.$value['dryvarfoods_id'].'</a>';
			  
			  $response .='
			 	<tr role="row"> 
				    <td>'.$newkey.'</td>
				    <td>'.$lin.'</td>
		            <td>'.$value["firstname"].'</td>
		            <td>'.$value["email"].'</td>
		            <td >'.get_recommended_item_to_user($value['dryvarfoods_id']).'</td>
	          	</tr>';
	        } 

	        echo $response.'***||***'.$count_total_clients.'***||***'.$page_links;
		
		}else{

			echo "norclients"; exit;	
		
		}

    }



    public function recommended_cross_customers_food(){

        $data['data_id']      = $data_id;

        if( $filtertype !=''){
            $input_arr = array( $filtertype => $data_id);
        }else{ 
            $input_arr = array();
        }

        $count_total_clients = $this->clients_model->count_recommended_food_user();
        $data['total_count'] = $count_total_clients;
        //Pagination
        $this->load->library('pagination');
        $config['base_url'] = base_url().'admin/clients/recommended_cross_customers_food';
        $config['total_rows'] = $count_total_clients;
        $config['per_page']         = 25;
        $config['num_links']        = 10;
        $config['use_page_numbers'] = TRUE;
        $config['uri_segment']      = 3;
        $config['reuse_query_string'] = TRUE;
        $config["first_tag_open"]   = '<li>';
        $config["first_tag_close"]  = '</li>';
        $config["last_tag_open"]    = '<li>';
        $config["last_tag_close"]   = '</li>';
        $config['next_link']        = '&raquo;';
        $config['next_tag_open']    = '<li>';
        $config['next_tag_close']   = '</li>';
        $config['prev_link']        = '&laquo;';
        $config['prev_tag_open']    = '<li>';
        $config['prev_tag_close']   = '</li>';
        $config['first_link']       = 'First';
        $config['last_link']        = 'Last';
        $config['full_tag_open']    = '<ul class="pagination client_filter_pagination">';
        $config['full_tag_close']   = '</ul>';
        $config['cur_tag_open']     = '<li class="active"><a href="#"><b>';
        $config['cur_tag_close']    = '</b></a></li>';
        $config['num_tag_open']     = '<li>';
        $config['num_tag_close']    = '</li>';
        
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        if($page !=0) $page = ($page-1) * $config['per_page'];
        $page = 0;
        $data['page_links'] = $this->pagination->create_links();

        $data['clients'] = $this->clients_model->get_recommended_food_user($input_arr,$page,$config["per_page"]);
        
        $data['title'] = _l('Customer Recommended Food');
        $this->load->view('admin/clients/recommended_customer_food_cross_item', $data);

    }

    public function recommended_cross_customers_food_ajax($page){

        if( $filtertype !=''){
            $input_arr = array( $filtertype => $data_id);
        }else{ 
            $input_arr = array();
        }

        $count_total_clients = $this->clients_model->count_recommended_food_user();
        
        //Pagination
        $this->load->library('pagination');
        $config['base_url'] = base_url().'admin/clients/recommended_cross_customers_food';
        $config['total_rows'] = $count_total_clients;
        $config['per_page']         = 25;
        $config['num_links']        = 10;
        $config['use_page_numbers'] = TRUE;
        $config['uri_segment']      = 4;
        $config['reuse_query_string'] = TRUE;
        $config["first_tag_open"]   = '<li>';
        $config["first_tag_close"]  = '</li>';
        $config["last_tag_open"]    = '<li>';
        $config["last_tag_close"]   = '</li>';
        $config['next_link']        = '&raquo;';
        $config['next_tag_open']    = '<li>';
        $config['next_tag_close']   = '</li>';
        $config['prev_link']        = '&laquo;';
        $config['prev_tag_open']    = '<li>';
        $config['prev_tag_close']   = '</li>';
        $config['first_link']       = 'First';
        $config['last_link']        = 'Last';
        $config['full_tag_open']    = '<ul class="pagination client_filter_pagination">';
        $config['full_tag_close']   = '</ul>';
        $config['cur_tag_open']     = '<li class="active"><a href="#"><b>';
        $config['cur_tag_close']    = '</b></a></li>';
        $config['num_tag_open']     = '<li>';
        $config['num_tag_close']    = '</li>';
        
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
        if($page !=0) $page = ($page-1) * $config['per_page'];

        $page_links = $this->pagination->create_links();

        $clients = $this->clients_model->get_recommended_food_user($input_arr,$page,$config["per_page"]);
            

        if(count($clients)>0){ 


            $response = '';
            
            foreach ($clients as $key => $value) {
                
              $newkey = $key+1;
              $lin  = '<a href="'.AURL.'clients/customer_details/'.$value['dryvarfoods_id'].'">'.$value['dryvarfoods_id'].'</a>';
              
              $response .='
                <tr role="row"> 
                    <td>'.$newkey.'</td>
                    <td>'.$lin.'</td>
                    <td>'.$value["firstname"].'</td>
                    <td>'.$value["email"].'</td>
                    <td>'.get_recommended_cross_item_to_user($value['dryvarfoods_id']).'</td>
                </tr>';
            } 

            echo $response.'***||***'.$count_total_clients.'***||***'.$page_links;
        
        }else{

            echo "norclients"; exit;    
        
        }

    }


     public function future_recommended_item(){

        $data['data_id']      = $data_id;

        if( $filtertype !=''){
            $input_arr = array( $filtertype => $data_id);
        }else{ 
            $input_arr = array();
        }

        $count_total_clients = $this->clients_model->count_recommended_food_user();
        $data['total_count'] = $count_total_clients;
        //Pagination
        $this->load->library('pagination');
        $config['base_url'] = base_url().'admin/clients/future_recommended_item';
        $config['total_rows'] = $count_total_clients;
        $config['per_page']         = 25;
        $config['num_links']        = 10;
        $config['use_page_numbers'] = TRUE;
        $config['uri_segment']      = 3;
        $config['reuse_query_string'] = TRUE;
        $config["first_tag_open"]   = '<li>';
        $config["first_tag_close"]  = '</li>';
        $config["last_tag_open"]    = '<li>';
        $config["last_tag_close"]   = '</li>';
        $config['next_link']        = '&raquo;';
        $config['next_tag_open']    = '<li>';
        $config['next_tag_close']   = '</li>';
        $config['prev_link']        = '&laquo;';
        $config['prev_tag_open']    = '<li>';
        $config['prev_tag_close']   = '</li>';
        $config['first_link']       = 'First';
        $config['last_link']        = 'Last';
        $config['full_tag_open']    = '<ul class="pagination client_filter_pagination">';
        $config['full_tag_close']   = '</ul>';
        $config['cur_tag_open']     = '<li class="active"><a href="#"><b>';
        $config['cur_tag_close']    = '</b></a></li>';
        $config['num_tag_open']     = '<li>';
        $config['num_tag_close']    = '</li>';
        
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        if($page !=0) $page = ($page-1) * $config['per_page'];
        $page = 0;
        $data['page_links'] = $this->pagination->create_links();

        $data['clients'] = $this->clients_model->get_recommended_food_user($input_arr,$page,$config["per_page"]);
        
        $data['title'] = _l('Customer Recommended Food');
        $this->load->view('admin/clients/future_recommended_item', $data);

    }


    public function future_recommended_item_ajax($page){

        if( $filtertype !=''){
            $input_arr = array( $filtertype => $data_id);
        }else{ 
            $input_arr = array();
        }

        $count_total_clients = $this->clients_model->count_recommended_food_user();
        
        //Pagination
        $this->load->library('pagination');
        
        $config['base_url'] 			= base_url().'admin/clients/future_recommended_item';
        $config['total_rows'] 			= $count_total_clients;
        $config['per_page']         	= 25;
        $config['num_links']        	= 10;
        $config['use_page_numbers'] 	= TRUE;
        $config['uri_segment']      	= 4;
        $config['reuse_query_string'] 	= TRUE;
        $config["first_tag_open"]   	= '<li>';
        $config["first_tag_close"]  	= '</li>';
        $config["last_tag_open"]    	= '<li>';
        $config["last_tag_close"]   	= '</li>';
        $config['next_link']        	= '&raquo;';
        $config['next_tag_open']    	= '<li>';
        $config['next_tag_close']   	= '</li>';
        $config['prev_link']        	= '&laquo;';
        $config['prev_tag_open']    	= '<li>';
        $config['prev_tag_close']   	= '</li>';
        $config['first_link']       	= 'First';
        $config['last_link']        	= 'Last';
        $config['full_tag_open']    	= '<ul class="pagination client_filter_pagination">';
        $config['full_tag_close']   	= '</ul>';
        $config['cur_tag_open']     	= '<li class="active"><a href="#"><b>';
        $config['cur_tag_close']    	= '</b></a></li>';
        $config['num_tag_open']     	= '<li>';
        $config['num_tag_close']    	= '</li>';
        
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
        if($page != 0) $page = ($page-1) * $config['per_page'];

        $page_links = $this->pagination->create_links();
        $clients = $this->clients_model->get_recommended_food_user($input_arr,$page,$config["per_page"]);
            
        if(count($clients)>0){ 

            $response = '';
            
            foreach ($clients as $key => $value) {
                
              	$newkey = $key+1;
              	$lin  = '<a href="'.AURL.'clients/customer_details/'.$value['dryvarfoods_id'].'">'.$value['dryvarfoods_id'].'</a>';
              
              	$response .='
                <tr role="row"> 
                    <td>'.$newkey.'</td>
                    <td>'.$lin.'</td>
                    <td>'.$value["firstname"].'</td>
                    <td>'.$value["email"].'</td>
                    <td>'.get_recommended_future_item_user($value['dryvarfoods_id']).'</td>
                </tr>';

            } 

            echo $response.'***||***'.$count_total_clients.'***||***'.$page_links;
        
        }else{
            echo "norclients"; exit;    
        }

    }


}
