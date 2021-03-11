<?php

defined('BASEPATH') or exit('No direct script access allowed');

require_once('recombee/autoload.php');
use Recombee\RecommApi\Client;
use Recombee\RecommApi\Requests as Reqs;
use Recombee\RecommApi\Exceptions as Ex;


class Clients_model extends App_Model
{
    private $contact_columns;

    public function __construct()
    {
        parent::__construct();

        $this->contact_columns = hooks()->apply_filters('contact_columns', ['firstname', 'lastname', 'email', 'phonenumber', 'title', 'password', 'send_set_password_email', 'donotsendwelcomeemail', 'permissions', 'direction', 'invoice_emails', 'estimate_emails', 'credit_note_emails', 'contract_emails', 'task_emails', 'project_emails', 'ticket_emails', 'is_primary']);

        $this->load->model(['client_vault_entries_model', 'client_groups_model', 'statement_model']);
    }

    /**
     * Get client object based on passed clientid if not passed clientid return array of all clients
     * @param  mixed $id    client id
     * @param  array  $where
     * @return mixed
     */
    public function get($id = '', $where = [])
    {
        $this->db->select(implode(',', prefixed_table_fields_array(db_prefix() . 'clients')) . ',' . get_sql_select_client_company());

        $this->db->join(db_prefix() . 'countries', '' . db_prefix() . 'countries.country_id = ' . db_prefix() . 'clients.country', 'left');
        $this->db->join(db_prefix() . 'contacts', '' . db_prefix() . 'contacts.userid = ' . db_prefix() . 'clients.userid AND is_primary = 1', 'left');

        if ((is_array($where) && count($where) > 0) || (is_string($where) && $where != '')) {
            $this->db->where($where);
        }

        if (is_numeric($id)) {
            $this->db->where(db_prefix() . 'clients.userid', $id);
            $client = $this->db->get(db_prefix() . 'clients')->row();

            if ($client && get_option('company_requires_vat_number_field') == 0) {
                $client->vat = null;
            }

            $GLOBALS['client'] = $client;

            return $client;
        }

        $this->db->order_by('company', 'asc');

        return $this->db->get(db_prefix() . 'clients')->result_array();
    }

    /**
     * Get customers contacts
     * @param  mixed $customer_id
     * @param  array  $where       perform where in query
     * @return array
     */
    public function get_contacts($customer_id = '', $where = ['active' => 1])
    {   
        
        $this->db->where($where);
        if ($customer_id != '') {
            $this->db->where('userid', $customer_id);
        }
        $this->db->where('type', 0);
        $this->db->order_by('is_primary', 'DESC');
        return $this->db->get(db_prefix() . 'contacts')->result_array();
    }
	
	 public function get_driver()
    {   
        
        
		$this->db->where('type', 3);// Fpr franshise
        $this->db->order_by('is_primary', 'DESC');
        return $this->db->get(db_prefix() . 'contacts')->result_array();
    }
	
	 public function get_all_used_driver()
    {   
		//$this->db->where('type', 3);// Fpr franshise
        //$this->db->order_by('is_primary', 'DESC');
        $alldirvier  =  $this->db->get(db_prefix() . 'franchise')->result_array();
		$ids = array();
		foreach($alldirvier as $driver){
			if($driver['driver_ids']!=""){
			  $driver_ids = explode(",",$driver['driver_ids']);
			  //echo "<pre>";  print_r($driver_ids); exit;
			  foreach($driver_ids as $id){
			    $ids[]=$id;
			  }
			}
		}
		return $ids;
    }
	 public function get_all_franchise($data)
    {   
	    
		if($data){
		  extract($data);
		  if($firstname!=""){
			 $this->db->where('(firstname LIKE "%' . $firstname . '%" OR lastname LIKE "%' .  $firstname . '%")'); 
		  }
		  if($email!=""){
			  $this->db->where('(email LIKE "%' . $email . '%")'); 
		  }	
		}
        
        $this->db->where('role', 11);// Fpr franshise
        $this->db->order_by('staffid', 'DESC');
        return $this->db->get(db_prefix() . 'staff')->result_array();
    }
	
	 public function get_general_customers()
    {   
        
        $this->db->where('type', 10);// General customers
        $this->db->order_by('is_primary', 'DESC');
        return $this->db->get(db_prefix() . 'contacts')->result_array();
    }
	
	 public function edit_frachise($id)
    {   
        
        $this->db->where('staffid', $id);// General customers
        $this->db->order_by('staffid', 'DESC');
        return $this->db->get(db_prefix() . 'staff')->row_array();
    }
	
	 public function get_frachise_driver($id)
    {   
        
        $this->db->where('franchise_id', $id);// General customers
        //$this->db->order_by('staffid', 'DESC');
        return $this->db->get(db_prefix() . 'franchise')->row_array();
    }
	
	 public function get_invoices()
    {   
        
        //$this->db->where('type', 10);// General customers
        $this->db->order_by('id', 'DESC');
        return $this->db->get(db_prefix() . 'general_invoice')->result_array();
    }
	
	 public function get_invoice($id)
    {   
        
        $this->db->where('id', $id);// General customers
        //$this->db->order_by('id', 'DESC');
        return $this->db->get(db_prefix() . 'general_invoice')->row_array();
    }

	
	
	
	   public function get_latest_customer()
    {   
        
         $this->db->limit(5);
        $this->db->where('type', 0);
        $this->db->order_by('is_primary', 'DESC');
        return $this->db->get(db_prefix() . 'contacts')->result_array();
    }

    /**
     * Get single contacts
     * @param  mixed $id contact id
     * @return object
     */
    public function get_contact($id)
    {
        $this->db->where('id', $id);

        return $this->db->get(db_prefix() . 'contacts')->row();
    }

    /**
     * @param array $_POST data
     * @param client_request is this request from the customer area
     * @return integer Insert ID
     * Add new client to database
     */
    public function add($data, $client_or_lead_convert_request = false)
    {
        $contact_data = [];
        foreach ($this->contact_columns as $field) {
            if (isset($data[$field])) {
                $contact_data[$field] = $data[$field];
                // Phonenumber is also used for the company profile
                if ($field != 'phonenumber') {
                    unset($data[$field]);
                }
            }
        }

        // From customer profile register
        if (isset($data['contact_phonenumber'])) {
            $contact_data['phonenumber'] = $data['contact_phonenumber'];
            unset($data['contact_phonenumber']);
        }

        if (isset($data['custom_fields'])) {
            $custom_fields = $data['custom_fields'];
            unset($data['custom_fields']);
        }

        if (isset($data['groups_in'])) {
            $groups_in = $data['groups_in'];
            unset($data['groups_in']);
        }

        $data = $this->check_zero_columns($data);

        $data['datecreated'] = date('Y-m-d H:i:s');

        if (is_staff_logged_in()) {
            $data['addedfrom'] = get_staff_user_id();
        }

        // New filter action
        $data = hooks()->apply_filters('before_client_added', $data);
        $data['crm_record'] = 1;
        $this->db->insert(db_prefix() . 'clients', $data);

        $userid = $this->db->insert_id();
        if ($userid) {
            if (isset($custom_fields)) {
                $_custom_fields = $custom_fields;
                // Possible request from the register area with 2 types of custom fields for contact and for comapny/customer
                if (count($custom_fields) == 2) {
                    unset($custom_fields);
                    $custom_fields['customers']                = $_custom_fields['customers'];
                    $contact_data['custom_fields']['contacts'] = $_custom_fields['contacts'];
                } elseif (count($custom_fields) == 1) {
                    if (isset($_custom_fields['contacts'])) {
                        $contact_data['custom_fields']['contacts'] = $_custom_fields['contacts'];
                        unset($custom_fields);
                    }
                }
                handle_custom_fields_post($userid, $custom_fields);
            }
            /**
             * Used in Import, Lead Convert, Register
             */
            if ($client_or_lead_convert_request == true) {
                $contact_id = $this->add_contact($contact_data, $userid, $client_or_lead_convert_request);
            }
            if (isset($groups_in)) {
                foreach ($groups_in as $group) {
                    $this->db->insert(db_prefix() . 'customer_groups', [
                        'customer_id' => $userid,
                        'groupid'     => $group,
                    ]);
                }
            }

            $log = 'ID: ' . $userid;

            if ($log == '' && isset($contact_id)) {
                $log = get_contact_full_name($contact_id);
            }

            $isStaff = null;
            if (!is_client_logged_in() && is_staff_logged_in()) {
                $log .= ', From Staff: ' . get_staff_user_id();
                $isStaff = get_staff_user_id();
            }

            hooks()->do_action('after_client_added', $userid);

            log_activity('New Client Created [' . $log . ']', $isStaff);
        }

        return $userid;
    }

    /**
     * @param  array $_POST data
     * @param  integer ID
     * @return boolean
     * Update client informations
     */
    public function update($data, $id, $client_request = false)
    {
		
		/*echo "<pre>";  print_r($data); 
		echo "<pre>";  print_r($id);
		echo "<pre>";  print_r($client_request); 
		
		exit;*/
        if (isset($data['update_all_other_transactions'])) {
            $update_all_other_transactions = true;
            unset($data['update_all_other_transactions']);
        }

        if (isset($data['update_credit_notes'])) {
            $update_credit_notes = true;
            unset($data['update_credit_notes']);
        }

        $affectedRows = 0;
        if (isset($data['custom_fields'])) {
            $custom_fields = $data['custom_fields'];
            if (handle_custom_fields_post($id, $custom_fields)) {
                $affectedRows++;
            }
            unset($data['custom_fields']);
        }

        if (isset($data['groups_in'])) {
            $groups_in = $data['groups_in'];
            unset($data['groups_in']);
        }

        $data = $this->check_zero_columns($data);

        $data = hooks()->apply_filters('before_client_updated', $data, $id);
        $this->db->where('userid', $id);
        $this->db->update(db_prefix() . 'clients', $data);
		$userid = $id; 
		
		for ($x = 1; $x <= 7; $x++) {
			
            $k = 7;
            $firstday  = $k * $x;
            $secondday = $k * ($x-1);
			
			 if(date("l")=='Monday'){
               $start     = date('Y-m-d 00:00:00',strtotime(' -'.$firstday.' days'));
               $endDate   = date('Y-m-d 00:00:00',strtotime(' -'.$secondday.' days'));	
			 }else{
			   $start     = date('Y-m-d 00:00:00',strtotime('last Monday -'.$firstday.' days'));
               $endDate   = date('Y-m-d 00:00:00',strtotime('last Monday -'.$secondday.' days'));		 
			 }

            $begin = new DateTime( $start);
            $end = new DateTime( $endDate );
            $end = $end->modify( '+7 day' );


            // Update all the invoice when commsion updaete in clients table 
            // $begin = new DateTime( '2020-09-14 00:00:00' );
            // $end = new DateTime( '2020-09-21 00:00:00' );
            // $end = $end->modify( '+7 day' );

            $interval = new DateInterval('P7D');
            $daterange = new DatePeriod($begin, $interval ,$end);

            $date_arr = array();
            foreach($daterange as $date){
                $date_arr[] = strtotime($date->format("Y-m-d 00:00:00") );       
            }
            if($userid != '' ){
              $this->db->where('userid', $userid );
            }
            $get_merchant = $this->db->get('tblclients');
            $merchant_arr = $get_merchant->row_array();
            $restaurant_id = $merchant_arr['dryvarfoods_id'];
			 

        for ($i=1; $i < count($date_arr); $i++) { 
            
            $date_filter = '';
            $d1 = $date_arr[$i-1];
            $d2 = $date_arr[$i];
            $date_filter = " AND created_at >= '".$d1."' ";
            $date_filter .= " AND created_at <= '".$d2."' ";

            $get_data = $this->db->query("SELECT SUM(total_amount) as total_sales, COUNT(id) as total_orders,restaurant_id from tblorders where restaurant_id='".$restaurant_id."' AND completed_at > 0 AND total_amount > 0  ".$date_filter." ");
            $sales_arr = $get_data->row_array();

            $get_data = $this->db->query("SELECT * from tblorders where restaurant_id='".$restaurant_id."' AND completed_at > 0 AND total_amount > 0 ".$date_filter." ");
            $orders_arr = $get_data->result_array();

            if($merchant_arr['commission'] > 0 && $sales_arr['total_orders'] > 0 ){
				
			

                $total_sales_amount = 0;
                $total_commision = 0;
                $total_payout = 0;

                $updatet_arr = array(

                    'sent'                              => 1, 
                    'datesend'                          => date('Y-m-d 00:00:00',$d2),
                    'clientid'                          => $merchant_arr['userid'],
                    'deleted_customer_name'             => NULL,
                    'number'                            => intval($merchant_arr['userid'].'00000'.$i),
                    'prefix'                            => 'MER',
                    'number_format'                     => '0',
                    'datecreated'                       => date('Y-m-d 00:00:00',$d2),
                    'date'                              => date('Y-m-d 00:00:00',$d2),
                    'duedate'                           => date('Y-m-d 00:00:00',$d2),
                    'currency'                          => '1',
                    'subtotal'                          => $total_payout,
                    'total_tax'                         => '0',
                    'total'                             => $total_payout,
                    'total_sales_amount'                => $total_sales_amount,
                    'commision'                         => $merchant_arr['commission'],
                    'total_orders'                      => $sales_arr['total_orders'],
                    'status'                            => '2'
                );
				
				
				$this->db->where('datesend', date('Y-m-d 00:00:00',$d2));
				$this->db->where('clientid', $merchant_arr['userid']);
                $update =  $this->db->update('tblinvoices', $updatet_arr);
				
				
				
				//echo 'update tblinvoices :::: '.$update;	  
                 $get_invoice = $this->db->query("SELECT * from tblinvoices where datesend='".date('Y-m-d 00:00:00',$d2)."' AND clientid = '".$merchant_arr['userid']."'");
				 $invoice = $get_invoice->row_array();
				 $last_id = $invoice['id'];
				 
				 
			if($last_id!='' && $last_id!=0 && $last_id!='0'){
				
				
				
                foreach ($orders_arr as $key => $value) {
                    
                    $total_amount     = round($value['total_amount'],2);
					$subtotal         = round($value['subtotal'],2);
                    $commision_amount = ( $subtotal * $merchant_arr['commission'] ) / 100;
                    $commision_amount = round($commision_amount,2);

                    $payout = $subtotal - $commision_amount;
					
					
					
					
					$updatw = '';
                    $updatw = $this->db->query("UPDATE `tblinvoice_items` SET `order_id`=".$value['dryvarfoods_id'].",`date`='".date('Y-m-d',$value['created_at'])."',`sales_amount`=".$subtotal.",`commission_amount`=".$payout.",`invoice_id`=".$last_id." WHERE order_id=".$value['dryvarfoods_id']."");  
					
					
					//echo 'update tblinvoice_items :::: '.$updatw;
			
					
					
					 

                    $total_sales_amount = $total_sales_amount + $subtotal;
                    $total_commision = $total_commision + $commision_amount;
                    $total_payout = $total_payout + $payout;
                }
                $updatetblinvoicepayments_arr = array(
                    'id' => NULL,
                    'invoiceid' => $last_id,
                    'amount' => $total_payout,
                    'paymentmode' => 'manual',
                    'paymentmethod' => 'cash',
                    'date' => date('Y-m-d 00:00:00',$d2),
                    'daterecorded' => date('Y-m-d 00:00:00',$d2),
                    'note' => 'invoice payed',
                    'transactionid' => NULL
                );
                //$this->db->insert('tblinvoicepaymentrecords',$updatetblinvoicepayments_arr);
				//echo 'last_id  '.$last_id;
				$this->db->where('invoiceid', $last_id);
                $update =  $this->db->update('tblinvoicepaymentrecords', $updatetblinvoicepayments_arr);
				//echo $sql = $this->db->last_query();
				//echo "<br />";
				//echo 'update tblinvoicepaymentrecords '.$update; 
				
				

                $this->db->where('id',$last_id);
                $this->db->set(array('subtotal' => $total_payout,'total' => $total_payout, 'total_sales_amount' => $total_sales_amount));
                $createt =  $this->db->update('tblinvoices');
				//echo "<pre>";  print_r($createt); 
                //echo $createt.'tblinvoices<br />'; 
			  }// END of if($last_id!='' && $last_id!=0 && && $last_id!='0')
			}
                
            }
		}
			
		// Update the invoice when commision update in cleints table 

        if ($this->db->affected_rows() > 0) {
            $affectedRows++;
        }
		
		/*echo 'update update_all_other_transactions '.$update_all_other_transactions; 
				echo 'update update_credit_notes '.$update_credit_notes; 
				
		*/		
				

        //if (isset($update_all_other_transactions) || isset($update_credit_notes)) {
            $transactions_update = [
                    'billing_street'        => $data['billing_street'],
                    'billing_city'          => $data['billing_city'],
                    'billing_state'         => $data['billing_state'],
                    'billing_zip'           => $data['billing_zip'],
                    'billing_country'       => $data['billing_country'],
                    'shipping_street'       => $data['shipping_street'],
                    'shipping_city'         => $data['shipping_city'],
                    'shipping_state'        => $data['shipping_state'],
                    'shipping_zip'          => $data['shipping_zip'],
                    'shipping_country'      => $data['shipping_country'],
                    'account_title'         => $data['account_title'],
                    'account_no'            => $data['account_no'],
                    'account_description'   => $data['account_description'],
                    'dryvarfoods_id'        => $data['dryvarfoods_id'],
                    'commission'            => $data['commission'],
                ];
				
            //if (isset($update_all_other_transactions)) { // Commendted by 11-8-2020

                // Update all invoices except paid ones.
                $this->db->where('clientid', $id);
                $this->db->where('status !=', 2);
                $transactions_update111  =  $this->db->update(db_prefix() . 'invoices', $transactions_update);
				
			
				
                if ($this->db->affected_rows() > 0) {
                    $affectedRows++;
                }

                // Update all estimates
                $this->db->where('clientid', $id);
                $this->db->update(db_prefix() . 'estimates', $transactions_update);
                if ($this->db->affected_rows() > 0) {
                    $affectedRows++;
                }
            //}// Commendted by 11-8-2020
            if (isset($update_credit_notes)) {
                $this->db->where('clientid', $id);
                $this->db->where('status !=', 2);
                $this->db->update(db_prefix() . 'creditnotes', $transactions_update);
                if ($this->db->affected_rows() > 0) {
                    $affectedRows++;
                }
            }
        //} // Commendted by 11-8-2020

        if (!isset($groups_in)) {
            $groups_in = false;
        }

        if ($this->client_groups_model->sync_customer_groups($id, $groups_in)) {
            $affectedRows++;
        }

        if ($affectedRows > 0) {
            hooks()->do_action('after_client_updated', $id);

            log_activity('Customer Info Updated [ID: ' . $id . ']');

            return true;
        }

        return false;
		
    }
	

    /**
     * Update contact data
     * @param  array  $data           $_POST data
     * @param  mixed  $id             contact id
     * @param  boolean $client_request is request from customers area
     * @return mixed
     */
    public function update_contact($data, $id, $client_request = false)
    {
        $affectedRows = 0;
        $contact      = $this->get_contact($id);
        if (empty($data['password'])) {
            unset($data['password']);
        } else {
            $data['password']             = app_hash_password($data['password']);
            $data['last_password_change'] = date('Y-m-d H:i:s');
        }

        $send_set_password_email = isset($data['send_set_password_email']) ? true : false;
        $set_password_email_sent = false;

        $permissions        = isset($data['permissions']) ? $data['permissions'] : [];
        $data['is_primary'] = isset($data['is_primary']) ? 1 : 0;

        // Contact cant change if is primary or not
        if ($client_request == true) {
            unset($data['is_primary']);
        }

        if (isset($data['custom_fields'])) {
            $custom_fields = $data['custom_fields'];
            if (handle_custom_fields_post($id, $custom_fields)) {
                $affectedRows++;
            }
            unset($data['custom_fields']);
        }

        if ($client_request == false) {
            $data['invoice_emails']     = isset($data['invoice_emails']) ? 1 :0;
            $data['estimate_emails']    = isset($data['estimate_emails']) ? 1 :0;
            $data['credit_note_emails'] = isset($data['credit_note_emails']) ? 1 :0;
            $data['contract_emails']    = isset($data['contract_emails']) ? 1 :0;
            $data['task_emails']        = isset($data['task_emails']) ? 1 :0;
            $data['project_emails']     = isset($data['project_emails']) ? 1 :0;
            $data['ticket_emails']      = isset($data['ticket_emails']) ? 1 :0;
        }

        $data = hooks()->apply_filters('before_update_contact', $data, $id);

        $this->db->where('id', $id);
        $this->db->update(db_prefix() . 'contacts', $data);

        if ($this->db->affected_rows() > 0) {
            $affectedRows++;
            if (isset($data['is_primary']) && $data['is_primary'] == 1) {
                $this->db->where('userid', $contact->userid);
                $this->db->where('id !=', $id);
                $this->db->update(db_prefix() . 'contacts', [
                    'is_primary' => 0,
                ]);
            }
        }

        if ($client_request == false) {
            $customer_permissions = $this->roles_model->get_contact_permissions($id);
            if (sizeof($customer_permissions) > 0) {
                foreach ($customer_permissions as $customer_permission) {
                    if (!in_array($customer_permission['permission_id'], $permissions)) {
                        $this->db->where('userid', $id);
                        $this->db->where('permission_id', $customer_permission['permission_id']);
                        $this->db->delete(db_prefix() . 'contact_permissions');
                        if ($this->db->affected_rows() > 0) {
                            $affectedRows++;
                        }
                    }
                }
                foreach ($permissions as $permission) {
                    $this->db->where('userid', $id);
                    $this->db->where('permission_id', $permission);
                    $_exists = $this->db->get(db_prefix() . 'contact_permissions')->row();
                    if (!$_exists) {
                        $this->db->insert(db_prefix() . 'contact_permissions', [
                            'userid'        => $id,
                            'permission_id' => $permission,
                        ]);
                        if ($this->db->affected_rows() > 0) {
                            $affectedRows++;
                        }
                    }
                }
            } else {
                foreach ($permissions as $permission) {
                    $this->db->insert(db_prefix() . 'contact_permissions', [
                        'userid'        => $id,
                        'permission_id' => $permission,
                    ]);
                    if ($this->db->affected_rows() > 0) {
                        $affectedRows++;
                    }
                }
            }
            if ($send_set_password_email) {
                $set_password_email_sent = $this->authentication_model->set_password_email($data['email'], 0);
            }
        }

        if ($affectedRows > 0) {
            hooks()->do_action('contact_updated', $id, $data);
        }

        if ($affectedRows > 0 && !$set_password_email_sent) {
            log_activity('Contact Updated [ID: ' . $id . ']');

            return true;
        } elseif ($affectedRows > 0 && $set_password_email_sent) {
            return [
                'set_password_email_sent_and_profile_updated' => true,
            ];
        } elseif ($affectedRows == 0 && $set_password_email_sent) {
            return [
                'set_password_email_sent' => true,
            ];
        }

        return false;
    }

    /**
     * Add new contact
     * @param array  $data               $_POST data
     * @param mixed  $customer_id        customer id
     * @param boolean $not_manual_request is manual from admin area customer profile or register, convert to lead
     */
    public function add_contact($data, $customer_id, $not_manual_request = false)
    {
        $send_set_password_email = isset($data['send_set_password_email']) ? true : false;

        if (isset($data['custom_fields'])) {
            $custom_fields = $data['custom_fields'];
            unset($data['custom_fields']);
        }

        if (isset($data['permissions'])) {
            $permissions = $data['permissions'];
            unset($data['permissions']);
        }

        $data['email_verified_at'] = date('Y-m-d H:i:s');

        $send_welcome_email = true;

        if (isset($data['donotsendwelcomeemail'])) {
            $send_welcome_email = false;
        }

        if (defined('CONTACT_REGISTERING')) {
            $send_welcome_email = true;

            // Do not send welcome email if confirmation for registration is enabled
            if (get_option('customers_register_require_confirmation') == '1') {
                $send_welcome_email = false;
            }

            // If client register set this contact as primary
            $data['is_primary'] = 1;
            if (is_email_verification_enabled() && !empty($data['email'])) {
                // Verification is required on register
                $data['email_verified_at']      = null;
                $data['email_verification_key'] = app_generate_hash();
            }
        }

        if (isset($data['is_primary'])) {
            $data['is_primary'] = 1;
            $this->db->where('userid', $customer_id);
            $this->db->update(db_prefix() . 'contacts', [
                'is_primary' => 0,
            ]);
        } else {
            $data['is_primary'] = 0;
        }

        $password_before_hash = '';
        $data['userid']       = $customer_id;
        if (isset($data['password'])) {
            $password_before_hash = $data['password'];
            $data['password']     = app_hash_password($data['password']);
        }

        $data['datecreated'] = date('Y-m-d H:i:s');

        if (!$not_manual_request) {
            $data['invoice_emails']     = isset($data['invoice_emails']) ? 1 :0;
            $data['estimate_emails']    = isset($data['estimate_emails']) ? 1 :0;
            $data['credit_note_emails'] = isset($data['credit_note_emails']) ? 1 :0;
            $data['contract_emails']    = isset($data['contract_emails']) ? 1 :0;
            $data['task_emails']        = isset($data['task_emails']) ? 1 :0;
            $data['project_emails']     = isset($data['project_emails']) ? 1 :0;
            $data['ticket_emails']      = isset($data['ticket_emails']) ? 1 :0;
        }

        $data['email'] = trim($data['email']);

        $data = hooks()->apply_filters('before_create_contact', $data);

        $this->db->insert(db_prefix() . 'contacts', $data);
        $contact_id = $this->db->insert_id();

        if ($contact_id) {
            if (isset($custom_fields)) {
                handle_custom_fields_post($contact_id, $custom_fields);
            }
            // request from admin area
            if (!isset($permissions) && $not_manual_request == false) {
                $permissions = [];
            } elseif ($not_manual_request == true) {
                $permissions         = [];
                $_permissions        = get_contact_permissions();
                $default_permissions = @unserialize(get_option('default_contact_permissions'));
                if (is_array($default_permissions)) {
                    foreach ($_permissions as $permission) {
                        if (in_array($permission['id'], $default_permissions)) {
                            array_push($permissions, $permission['id']);
                        }
                    }
                }
            }

            if ($not_manual_request == true) {
                // update all email notifications to 0
                $this->db->where('id', $contact_id);
                $this->db->update(db_prefix() . 'contacts', [
                    'invoice_emails'     => 0,
                    'estimate_emails'    => 0,
                    'credit_note_emails' => 0,
                    'contract_emails'    => 0,
                    'task_emails'        => 0,
                    'project_emails'     => 0,
                    'ticket_emails'      => 0,
                ]);
            }
            foreach ($permissions as $permission) {
                $this->db->insert(db_prefix() . 'contact_permissions', [
                    'userid'        => $contact_id,
                    'permission_id' => $permission,
                ]);

                // Auto set email notifications based on permissions
                if ($not_manual_request == true) {
                    if ($permission == 6) {
                        $this->db->where('id', $contact_id);
                        $this->db->update(db_prefix() . 'contacts', ['project_emails' => 1, 'task_emails' => 1]);
                    } elseif ($permission == 3) {
                        $this->db->where('id', $contact_id);
                        $this->db->update(db_prefix() . 'contacts', ['contract_emails' => 1]);
                    } elseif ($permission == 2) {
                        $this->db->where('id', $contact_id);
                        $this->db->update(db_prefix() . 'contacts', ['estimate_emails' => 1]);
                    } elseif ($permission == 1) {
                        $this->db->where('id', $contact_id);
                        $this->db->update(db_prefix() . 'contacts', ['invoice_emails' => 1, 'credit_note_emails' => 1]);
                    } elseif ($permission == 5) {
                        $this->db->where('id', $contact_id);
                        $this->db->update(db_prefix() . 'contacts', ['ticket_emails' => 1]);
                    }
                }
            }

            if ($send_welcome_email == true && !empty($data['email'])) {
                send_mail_template(
                    'customer_created_welcome_mail',
                    $data['email'],
                    $data['userid'],
                    $contact_id,
                    $password_before_hash
                );
            }

            if ($send_set_password_email) {
                $this->authentication_model->set_password_email($data['email'], 0);
            }

            if (defined('CONTACT_REGISTERING')) {
                $this->send_verification_email($contact_id);
            } else {
                // User already verified because is added from admin area, try to transfer any tickets
                $this->load->model('tickets_model');
                $this->tickets_model->transfer_email_tickets_to_contact($data['email'], $contact_id);
            }

            log_activity('Contact Created [ID: ' . $contact_id . ']');

            hooks()->do_action('contact_created', $contact_id);

            return $contact_id;
        }

        return false;
    }

    /**
     * Used to update company details from customers area
     * @param  array $data $_POST data
     * @param  mixed $id
     * @return boolean
     */
    public function update_company_details($data, $id)
    {
        $affectedRows = 0;
        if (isset($data['custom_fields'])) {
            $custom_fields = $data['custom_fields'];
            if (handle_custom_fields_post($id, $custom_fields)) {
                $affectedRows++;
            }
            unset($data['custom_fields']);
        }
        if (isset($data['country']) && $data['country'] == '' || !isset($data['country'])) {
            $data['country'] = 0;
        }
        if (isset($data['billing_country']) && $data['billing_country'] == '') {
            $data['billing_country'] = 0;
        }
        if (isset($data['shipping_country']) && $data['shipping_country'] == '') {
            $data['shipping_country'] = 0;
        }

        // From v.1.9.4 these fields are textareas
        $data['address'] = trim($data['address']);
        $data['address'] = nl2br($data['address']);
        if (isset($data['billing_street'])) {
            $data['billing_street'] = trim($data['billing_street']);
            $data['billing_street'] = nl2br($data['billing_street']);
        }
        if (isset($data['shipping_street'])) {
            $data['shipping_street'] = trim($data['shipping_street']);
            $data['shipping_street'] = nl2br($data['shipping_street']);
        }

        $data = hooks()->apply_filters('customer_update_company_info', $data, $id);

        $this->db->where('userid', $id);
        $this->db->update(db_prefix() . 'clients', $data);
        if ($this->db->affected_rows() > 0) {
            $affectedRows++;
        }
        if ($affectedRows > 0) {
            hooks()->do_action('customer_updated_company_info', $id);
            log_activity('Customer Info Updated From Clients Area [ID: ' . $id . ']');

            return true;
        }

        return false;
    }

    /**
     * Get customer staff members that are added as customer admins
     * @param  mixed $id customer id
     * @return array
     */
    public function get_admins($id)
    {
        $this->db->where('customer_id', $id);

        return $this->db->get(db_prefix() . 'customer_admins')->result_array();
    }

    /**
     * Get unique staff id's of customer admins
     * @return array
     */
    public function get_customers_admin_unique_ids()
    {
        return $this->db->query('SELECT DISTINCT(staff_id) FROM ' . db_prefix() . 'customer_admins')->result_array();
    }

    /**
     * Assign staff members as admin to customers
     * @param  array $data $_POST data
     * @param  mixed $id   customer id
     * @return boolean
     */
    public function assign_admins($data, $id)
    {
        $affectedRows = 0;

        if (count($data) == 0) {
            $this->db->where('customer_id', $id);
            $this->db->delete(db_prefix() . 'customer_admins');
            if ($this->db->affected_rows() > 0) {
                $affectedRows++;
            }
        } else {
            $current_admins     = $this->get_admins($id);
            $current_admins_ids = [];
            foreach ($current_admins as $c_admin) {
                array_push($current_admins_ids, $c_admin['staff_id']);
            }
            foreach ($current_admins_ids as $c_admin_id) {
                if (!in_array($c_admin_id, $data['customer_admins'])) {
                    $this->db->where('staff_id', $c_admin_id);
                    $this->db->where('customer_id', $id);
                    $this->db->delete(db_prefix() . 'customer_admins');
                    if ($this->db->affected_rows() > 0) {
                        $affectedRows++;
                    }
                }
            }
            foreach ($data['customer_admins'] as $n_admin_id) {
                if (total_rows(db_prefix() . 'customer_admins', [
                    'customer_id' => $id,
                    'staff_id' => $n_admin_id,
                ]) == 0) {
                    $this->db->insert(db_prefix() . 'customer_admins', [
                        'customer_id'   => $id,
                        'staff_id'      => $n_admin_id,
                        'date_assigned' => date('Y-m-d H:i:s'),
                    ]);
                    if ($this->db->affected_rows() > 0) {
                        $affectedRows++;
                    }
                }
            }
        }
        if ($affectedRows > 0) {
            return true;
        }

        return false;
    }

    /**
     * @param  integer ID
     * @return boolean
     * Delete client, also deleting rows from, dismissed client announcements, ticket replies, tickets, autologin, user notes
     */
    public function delete($id)
    {
        $affectedRows = 0;

        if (!is_gdpr() && is_reference_in_table('clientid', db_prefix() . 'invoices', $id)) {
            return [
                'referenced' => true,
            ];
        }

        if (!is_gdpr() && is_reference_in_table('clientid', db_prefix() . 'estimates', $id)) {
            return [
                'referenced' => true,
            ];
        }

        if (!is_gdpr() && is_reference_in_table('clientid', db_prefix() . 'creditnotes', $id)) {
            return [
                'referenced' => true,
            ];
        }

        hooks()->do_action('before_client_deleted', $id);

        $last_activity = get_last_system_activity_id();
        $company       = get_company_name($id);

        $this->db->where('userid', $id);
        $this->db->delete(db_prefix() . 'clients');
        if ($this->db->affected_rows() > 0) {
            $affectedRows++;
            // Delete all user contacts
            $this->db->where('userid', $id);
            $contacts = $this->db->get(db_prefix() . 'contacts')->result_array();
            foreach ($contacts as $contact) {
                $this->delete_contact($contact['id']);
            }

            // Delete all tickets start here
            $this->db->where('userid', $id);
            $tickets = $this->db->get(db_prefix() . 'tickets')->result_array();
            $this->load->model('tickets_model');
            foreach ($tickets as $ticket) {
                $this->tickets_model->delete($ticket['ticketid']);
            }

            $this->db->where('rel_id', $id);
            $this->db->where('rel_type', 'customer');
            $this->db->delete(db_prefix() . 'notes');

            if (is_gdpr() && get_option('gdpr_on_forgotten_remove_invoices_credit_notes') == '1') {
                $this->load->model('invoices_model');
                $this->db->where('clientid', $id);
                $invoices = $this->db->get(db_prefix() . 'invoices')->result_array();
                foreach ($invoices as $invoice) {
                    $this->invoices_model->delete($invoice['id'], true);
                }

                $this->load->model('credit_notes_model');
                $this->db->where('clientid', $id);
                $credit_notes = $this->db->get(db_prefix() . 'creditnotes')->result_array();
                foreach ($credit_notes as $credit_note) {
                    $this->credit_notes_model->delete($credit_note['id'], true);
                }
            } elseif (is_gdpr()) {
                $this->db->where('clientid', $id);
                $this->db->update(db_prefix() . 'invoices', ['deleted_customer_name' => $company]);

                $this->db->where('clientid', $id);
                $this->db->update(db_prefix() . 'creditnotes', ['deleted_customer_name' => $company]);
            }

            $this->db->where('clientid', $id);
            $this->db->update(db_prefix() . 'creditnotes', [
                'clientid'   => 0,
                'project_id' => 0,
            ]);

            $this->db->where('clientid', $id);
            $this->db->update(db_prefix() . 'invoices', [
                'clientid'                 => 0,
                'recurring'                => 0,
                'recurring_type'           => null,
                'custom_recurring'         => 0,
                'cycles'                   => 0,
                'last_recurring_date'      => null,
                'project_id'               => 0,
                'subscription_id'          => 0,
                'cancel_overdue_reminders' => 1,
                'last_overdue_reminder'    => null,
            ]);

            if (is_gdpr() && get_option('gdpr_on_forgotten_remove_estimates') == '1') {
                $this->load->model('estimates_model');
                $this->db->where('clientid', $id);
                $estimates = $this->db->get(db_prefix() . 'estimates')->result_array();
                foreach ($estimates as $estimate) {
                    $this->estimates_model->delete($estimate['id'], true);
                }
            } elseif (is_gdpr()) {
                $this->db->where('clientid', $id);
                $this->db->update(db_prefix() . 'estimates', ['deleted_customer_name' => $company]);
            }

            $this->db->where('clientid', $id);
            $this->db->update(db_prefix() . 'estimates', [
                'clientid'           => 0,
                'project_id'         => 0,
                'is_expiry_notified' => 1,
            ]);

            $this->load->model('subscriptions_model');
            $this->db->where('clientid', $id);
            $subscriptions = $this->db->get(db_prefix() . 'subscriptions')->result_array();
            foreach ($subscriptions as $subscription) {
                $this->subscriptions_model->delete($subscription['id'], true);
            }
            // Get all client contracts
            $this->load->model('contracts_model');
            $this->db->where('client', $id);
            $contracts = $this->db->get(db_prefix() . 'contracts')->result_array();
            foreach ($contracts as $contract) {
                $this->contracts_model->delete($contract['id']);
            }
            // Delete the custom field values
            $this->db->where('relid', $id);
            $this->db->where('fieldto', 'customers');
            $this->db->delete(db_prefix() . 'customfieldsvalues');

            // Get customer related tasks
            $this->db->where('rel_type', 'customer');
            $this->db->where('rel_id', $id);
            $tasks = $this->db->get(db_prefix() . 'tasks')->result_array();

            foreach ($tasks as $task) {
                $this->tasks_model->delete_task($task['id'], false);
            }

            $this->db->where('rel_type', 'customer');
            $this->db->where('rel_id', $id);
            $this->db->delete(db_prefix() . 'reminders');

            $this->db->where('customer_id', $id);
            $this->db->delete(db_prefix() . 'customer_admins');

            $this->db->where('customer_id', $id);
            $this->db->delete(db_prefix() . 'vault');

            $this->db->where('customer_id', $id);
            $this->db->delete(db_prefix() . 'customer_groups');

            $this->load->model('proposals_model');
            $this->db->where('rel_id', $id);
            $this->db->where('rel_type', 'customer');
            $proposals = $this->db->get(db_prefix() . 'proposals')->result_array();
            foreach ($proposals as $proposal) {
                $this->proposals_model->delete($proposal['id']);
            }
            $this->db->where('rel_id', $id);
            $this->db->where('rel_type', 'customer');
            $attachments = $this->db->get(db_prefix() . 'files')->result_array();
            foreach ($attachments as $attachment) {
                $this->delete_attachment($attachment['id']);
            }

            $this->db->where('clientid', $id);
            $expenses = $this->db->get(db_prefix() . 'expenses')->result_array();

            $this->load->model('expenses_model');
            foreach ($expenses as $expense) {
                $this->expenses_model->delete($expense['id'], true);
            }

            $this->db->where('client_id', $id);
            $this->db->delete(db_prefix() . 'user_meta');

            $this->db->where('client_id', $id);
            $this->db->update(db_prefix() . 'leads', ['client_id' => 0]);

            // Delete all projects
            $this->load->model('projects_model');
            $this->db->where('clientid', $id);
            $projects = $this->db->get(db_prefix() . 'projects')->result_array();
            foreach ($projects as $project) {
                $this->projects_model->delete($project['id']);
            }
        }
        if ($affectedRows > 0) {
            hooks()->do_action('after_client_deleted', $id);

            // Delete activity log caused by delete customer function
            if ($last_activity) {
                $this->db->where('id >', $last_activity->id);
                $this->db->delete(db_prefix() . 'activity_log');
            }

            log_activity('Client Deleted [ID: ' . $id . ']');

            return true;
        }

        return false;
    }
     
	public function archive($id)
    {
		$this->db->set("is_archive", 1);
        $this->db->where('userid', $id);
        $this->db->update(db_prefix() . 'clients');
        
        log_activity('Client Archived [ID: ' . $id . ']');

        return true;
       
    }

    /**
     * Delete customer contact
     * @param  mixed $id contact id
     * @return boolean
     */
    public function delete_contact($id)
    {
        hooks()->do_action('before_delete_contact', $id);

        $this->db->where('id', $id);
        $result      = $this->db->get(db_prefix() . 'contacts')->row();
        $customer_id = $result->userid;

        $last_activity = get_last_system_activity_id();

        $this->db->where('id', $id);
        $this->db->delete(db_prefix() . 'contacts');

        if ($this->db->affected_rows() > 0) {
            if (is_dir(get_upload_path_by_type('contact_profile_images') . $id)) {
                delete_dir(get_upload_path_by_type('contact_profile_images') . $id);
            }

            $this->db->where('contact_id', $id);
            $this->db->delete(db_prefix() . 'consents');

            $this->db->where('contact_id', $id);
            $this->db->delete(db_prefix() . 'shared_customer_files');

            $this->db->where('userid', $id);
            $this->db->where('staff', 0);
            $this->db->delete(db_prefix() . 'dismissed_announcements');

            $this->db->where('relid', $id);
            $this->db->where('fieldto', 'contacts');
            $this->db->delete(db_prefix() . 'customfieldsvalues');

            $this->db->where('userid', $id);
            $this->db->delete(db_prefix() . 'contact_permissions');

            $this->db->where('user_id', $id);
            $this->db->where('staff', 0);
            $this->db->delete(db_prefix() . 'user_auto_login');

            $this->db->select('ticketid');
            $this->db->where('contactid', $id);
            $this->db->where('userid', $customer_id);
            $tickets = $this->db->get(db_prefix() . 'tickets')->result_array();

            $this->load->model('tickets_model');
            foreach ($tickets as $ticket) {
                $this->tickets_model->delete($ticket['ticketid']);
            }

            $this->load->model('tasks_model');

            $this->db->where('addedfrom', $id);
            $this->db->where('is_added_from_contact', 1);
            $tasks = $this->db->get(db_prefix() . 'tasks')->result_array();

            foreach ($tasks as $task) {
                $this->tasks_model->delete_task($task['id'], false);
            }

            // Added from contact in customer profile
            $this->db->where('contact_id', $id);
            $this->db->where('rel_type', 'customer');
            $attachments = $this->db->get(db_prefix() . 'files')->result_array();

            foreach ($attachments as $attachment) {
                $this->delete_attachment($attachment['id']);
            }

            // Remove contact files uploaded to tasks
            $this->db->where('rel_type', 'task');
            $this->db->where('contact_id', $id);
            $filesUploadedFromContactToTasks = $this->db->get(db_prefix() . 'files')->result_array();

            foreach ($filesUploadedFromContactToTasks as $file) {
                $this->tasks_model->remove_task_attachment($file['id']);
            }

            $this->db->where('contact_id', $id);
            $tasksComments = $this->db->get(db_prefix() . 'task_comments')->result_array();
            foreach ($tasksComments as $comment) {
                $this->tasks_model->remove_comment($comment['id'], true);
            }

            $this->load->model('projects_model');

            $this->db->where('contact_id', $id);
            $files = $this->db->get(db_prefix() . 'project_files')->result_array();
            foreach ($files as $file) {
                $this->projects_model->remove_file($file['id'], false);
            }

            $this->db->where('contact_id', $id);
            $discussions = $this->db->get(db_prefix() . 'projectdiscussions')->result_array();
            foreach ($discussions as $discussion) {
                $this->projects_model->delete_discussion($discussion['id'], false);
            }

            $this->db->where('contact_id', $id);
            $discussionsComments = $this->db->get(db_prefix() . 'projectdiscussioncomments')->result_array();
            foreach ($discussionsComments as $comment) {
                $this->projects_model->delete_discussion_comment($comment['id'], false);
            }

            $this->db->where('contact_id', $id);
            $this->db->delete(db_prefix() . 'user_meta');

            $this->db->where('(email="' . $result->email . '" OR bcc LIKE "%' . $result->email . '%" OR cc LIKE "%' . $result->email . '%")');
            $this->db->delete(db_prefix() . 'mail_queue');

            if (is_gdpr()) {
                $this->db->where('email', $result->email);
                $this->db->delete(db_prefix() . 'listemails');

                if (!empty($result->last_ip)) {
                    $this->db->where('ip', $result->last_ip);
                    $this->db->delete(db_prefix() . 'knowedge_base_article_feedback');
                }

                $this->db->where('email', $result->email);
                $this->db->delete(db_prefix() . 'tickets_pipe_log');

                $this->db->where('email', $result->email);
                $this->db->delete(db_prefix() . 'tracked_mails');

                $this->db->where('contact_id', $id);
                $this->db->delete(db_prefix() . 'project_activity');

                $this->db->where('(additional_data LIKE "%' . $result->email . '%" OR full_name LIKE "%' . $result->firstname . ' ' . $result->lastname . '%")');
                $this->db->where('additional_data != "" AND additional_data IS NOT NULL');
                $this->db->delete(db_prefix() . 'sales_activity');

                $contactActivityQuery = false;
                if (!empty($result->email)) {
                    $this->db->or_like('description', $result->email);
                    $contactActivityQuery = true;
                }
                if (!empty($result->firstname)) {
                    $this->db->or_like('description', $result->firstname);
                    $contactActivityQuery = true;
                }
                if (!empty($result->lastname)) {
                    $this->db->or_like('description', $result->lastname);
                    $contactActivityQuery = true;
                }

                if (!empty($result->phonenumber)) {
                    $this->db->or_like('description', $result->phonenumber);
                    $contactActivityQuery = true;
                }

                if (!empty($result->last_ip)) {
                    $this->db->or_like('description', $result->last_ip);
                    $contactActivityQuery = true;
                }

                if ($contactActivityQuery) {
                    $this->db->delete(db_prefix() . 'activity_log');
                }
            }

            // Delete activity log caused by delete contact function
            if ($last_activity) {
                $this->db->where('id >', $last_activity->id);
                $this->db->delete(db_prefix() . 'activity_log');
            }

            hooks()->do_action('contact_deleted', $id, $result);

            return true;
        }

        return false;
    }

    /**
     * Get customer default currency
     * @param  mixed $id customer id
     * @return mixed
     */
    public function get_customer_default_currency($id)
    {
        $this->db->select('default_currency');
        $this->db->where('userid', $id);
        $result = $this->db->get(db_prefix() . 'clients')->row();
        if ($result) {
            return $result->default_currency;
        }

        return false;
    }

    /**
     *  Get customer billing details
     * @param   mixed $id   customer id
     * @return  array
     */
    public function get_customer_billing_and_shipping_details($id)
    {
        $this->db->select('billing_street,billing_city,billing_state,billing_zip,billing_country,shipping_street,shipping_city,shipping_state,shipping_zip,shipping_country');
        $this->db->from(db_prefix() . 'clients');
        $this->db->where('userid', $id);

        $result = $this->db->get()->result_array();
        if (count($result) > 0) {
            $result[0]['billing_street']  = clear_textarea_breaks($result[0]['billing_street']);
            $result[0]['shipping_street'] = clear_textarea_breaks($result[0]['shipping_street']);
        }

        return $result;
    }

    /**
     * Get customer files uploaded in the customer profile
     * @param  mixed $id    customer id
     * @param  array  $where perform where
     * @return array
     */
    public function get_customer_files($id, $where = [])
    {
        $this->db->where($where);
        $this->db->where('rel_id', $id);
        $this->db->where('rel_type', 'customer');
        $this->db->order_by('dateadded', 'desc');

        return $this->db->get(db_prefix() . 'files')->result_array();
    }

    /**
     * Delete customer attachment uploaded from the customer profile
     * @param  mixed $id attachment id
     * @return boolean
     */
    public function delete_attachment($id)
    {
        $this->db->where('id', $id);
        $attachment = $this->db->get(db_prefix() . 'files')->row();
        $deleted    = false;
        if ($attachment) {
            if (empty($attachment->external)) {
                $relPath  = get_upload_path_by_type('customer') . $attachment->rel_id . '/';
                $fullPath = $relPath . $attachment->file_name;
                unlink($fullPath);
                $fname     = pathinfo($fullPath, PATHINFO_FILENAME);
                $fext      = pathinfo($fullPath, PATHINFO_EXTENSION);
                $thumbPath = $relPath . $fname . '_thumb.' . $fext;
                if (file_exists($thumbPath)) {
                    unlink($thumbPath);
                }
            }

            $this->db->where('id', $id);
            $this->db->delete(db_prefix() . 'files');
            if ($this->db->affected_rows() > 0) {
                $deleted = true;
                $this->db->where('file_id', $id);
                $this->db->delete(db_prefix() . 'shared_customer_files');
                log_activity('Customer Attachment Deleted [ID: ' . $attachment->rel_id . ']');
            }

            if (is_dir(get_upload_path_by_type('customer') . $attachment->rel_id)) {
                // Check if no attachments left, so we can delete the folder also
                $other_attachments = list_files(get_upload_path_by_type('customer') . $attachment->rel_id);
                if (count($other_attachments) == 0) {
                    delete_dir(get_upload_path_by_type('customer') . $attachment->rel_id);
                }
            }
        }

        return $deleted;
    }

    /**
     * @param  integer ID
     * @param  integer Status ID
     * @return boolean
     * Update contact status Active/Inactive
     */
    public function change_contact_status($id, $status)
    {
        $status = hooks()->apply_filters('change_contact_status', $status, $id);

        $this->db->where('id', $id);
        $this->db->update(db_prefix() . 'contacts', [
            'active' => $status,
        ]);
        if ($this->db->affected_rows() > 0) {
            hooks()->do_action('contact_status_changed', [
                'id'     => $id,
                'status' => $status,
            ]);

            log_activity('Contact Status Changed [ContactID: ' . $id . ' Status(Active/Inactive): ' . $status . ']');

            return true;
        }

        return false;
    }

    /**
     * @param  integer ID
     * @param  integer Status ID
     * @return boolean
     * Update client status Active/Inactive
     */
    public function change_client_status($id, $status)
    {
        $this->db->where('userid', $id);
        $this->db->update(db_prefix() . 'clients', [
            'active' => $status,
        ]);

        if ($this->db->affected_rows() > 0) {
            hooks()->do_action('client_status_changed', [
                'id'     => $id,
                'status' => $status,
            ]);

            log_activity('Customer Status Changed [ID: ' . $id . ' Status(Active/Inactive): ' . $status . ']');

            return true;
        }

        return false;
    }

    /**
     * Change contact password, used from client area
     * @param  mixed $id          contact id to change password
     * @param  string $oldPassword old password to verify
     * @param  string $newPassword new password
     * @return boolean
     */
    public function change_contact_password($id, $oldPassword, $newPassword)
    {
        // Get current password
        $this->db->where('id', $id);
        $client = $this->db->get(db_prefix() . 'contacts')->row();

        if (!app_hasher()->CheckPassword($oldPassword, $client->password)) {
            return [
                'old_password_not_match' => true,
            ];
        }

        $this->db->where('id', $id);
        $this->db->update(db_prefix() . 'contacts', [
            'last_password_change' => date('Y-m-d H:i:s'),
            'password'             => app_hash_password($newPassword),
        ]);

        if ($this->db->affected_rows() > 0) {
            log_activity('Contact Password Changed [ContactID: ' . $id . ']');

            return true;
        }

        return false;
    }

    /**
     * Get customer groups where customer belongs
     * @param  mixed $id customer id
     * @return array
    */
    public function get_customer_groups($id)
    {
        return $this->client_groups_model->get_customer_groups($id);
    }

    /**
     * Get all customer groups
     * @param  string $id
     * @return mixed
     */
    public function get_groups($id = '')
    {
        return $this->client_groups_model->get_groups($id);
    }

    /**
     * Delete customer groups
     * @param  mixed $id group id
     * @return boolean
     */
    public function delete_group($id)
    {
        return $this->client_groups_model->delete($id);
    }

    /**
     * Add new customer groups
     * @param array $data $_POST data
     */
    public function add_group($data)
    {
        return $this->client_groups_model->add($data);
    }

    /**
     * Edit customer group
     * @param  array $data $_POST data
     * @return boolean
     */
    public function edit_group($data)
    {
        return $this->client_groups_model->edit($data);
    }

    /**
    * Create new vault entry
    * @param  array $data        $_POST data
    * @param  mixed $customer_id customer id
    * @return boolean
    */
    public function vault_entry_create($data, $customer_id)
    {
        return $this->client_vault_entries_model->create($data, $customer_id);
    }

    /**
     * Update vault entry
     * @param  mixed $id   vault entry id
     * @param  array $data $_POST data
     * @return boolean
     */
    public function vault_entry_update($id, $data)
    {
        return $this->client_vault_entries_model->update($id, $data);
    }

    /**
     * Delete vault entry
     * @param  mixed $id entry id
     * @return boolean
     */
    public function vault_entry_delete($id)
    {
        return $this->client_vault_entries_model->delete($id);
    }

    /**
     * Get customer vault entries
     * @param  mixed $customer_id
     * @param  array  $where       additional wher
     * @return array
     */
    public function get_vault_entries($customer_id, $where = [])
    {
        return $this->client_vault_entries_model->get_by_customer_id($customer_id, $where);
    }

    /**
     * Get single vault entry
     * @param  mixed $id vault entry id
     * @return object
     */
    public function get_vault_entry($id)
    {
        return $this->client_vault_entries_model->get($id);
    }

    /**
    * Get customer statement formatted
    * @param  mixed $customer_id customer id
    * @param  string $from        date from
    * @param  string $to          date to
    * @return array
    */
    public function get_statement($customer_id, $from, $to)
    {
        return $this->statement_model->get_statement($customer_id, $from, $to);
    }

    /**
    * Send customer statement to email
    * @param  mixed $customer_id customer id
    * @param  array $send_to     array of contact emails to send
    * @param  string $from        date from
    * @param  string $to          date to
    * @param  string $cc          email CC
    * @return boolean
    */
    public function send_statement_to_email($customer_id, $send_to, $from, $to, $cc = '')
    {
        return $this->statement_model->send_statement_to_email($customer_id, $send_to, $from, $to, $cc);
    }

    /**
     * When customer register, mark the contact and the customer as inactive and set the registration_confirmed field to 0
     * @param  mixed $client_id  the customer id
     * @return boolean
     */
    public function require_confirmation($client_id)
    {
        $contact_id = get_primary_contact_user_id($client_id);
        $this->db->where('userid', $client_id);
        $this->db->update(db_prefix() . 'clients', ['active' => 0, 'registration_confirmed' => 0]);

        $this->db->where('id', $contact_id);
        $this->db->update(db_prefix() . 'contacts', ['active' => 0]);

        return true;
    }

    public function confirm_registration($client_id)
    {
        $contact_id = get_primary_contact_user_id($client_id);
        $this->db->where('userid', $client_id);
        $this->db->update(db_prefix() . 'clients', ['active' => 1, 'registration_confirmed' => 1]);

        $this->db->where('id', $contact_id);
        $this->db->update(db_prefix() . 'contacts', ['active' => 1]);

        $contact = $this->get_contact($contact_id);

        if ($contact) {
            send_mail_template('customer_registration_confirmed', $contact);

            return true;
        }

        return false;
    }

    public function send_verification_email($id)
    {
        $contact = $this->get_contact($id);

        if (empty($contact->email)) {
            return false;
        }

        $success = send_mail_template('customer_contact_verification', $contact);

        if ($success) {
            $this->db->where('id', $id);
            $this->db->update(db_prefix() . 'contacts', ['email_verification_sent_at' => date('Y-m-d H:i:s')]);
        }

        return $success;
    }

    public function mark_email_as_verified($id)
    {
        $contact = $this->get_contact($id);

        $this->db->where('id', $id);
        $this->db->update(db_prefix() . 'contacts', [
            'email_verified_at'          => date('Y-m-d H:i:s'),
            'email_verification_key'     => null,
            'email_verification_sent_at' => null,
        ]);

        if ($this->db->affected_rows() > 0) {

            // Check for previous tickets opened by this email/contact and link to the contact
            $this->load->model('tickets_model');
            $this->tickets_model->transfer_email_tickets_to_contact($contact->email, $contact->id);

            return true;
        }

        return false;
    }

    public function get_clients_distinct_countries()
    {
        return $this->db->query('SELECT DISTINCT(country_id), short_name FROM ' . db_prefix() . 'clients JOIN ' . db_prefix() . 'countries ON ' . db_prefix() . 'countries.country_id=' . db_prefix() . 'clients.country')->result_array();
    }

    public function send_notification_customer_profile_file_uploaded_to_responsible_staff($contact_id, $customer_id)
    {
        $staff         = $this->get_staff_members_that_can_access_customer($customer_id);
        $merge_fields  = $this->app_merge_fields->format_feature('client_merge_fields', $customer_id, $contact_id);
        $notifiedUsers = [];


        foreach ($staff as $member) {
            mail_template('customer_profile_uploaded_file_to_staff', $member['email'], $member['staffid'])
            ->set_merge_fields($merge_fields)
            ->send();

            if (add_notification([
                    'touserid' => $member['staffid'],
                    'description' => 'not_customer_uploaded_file',
                    'link' => 'clients/client/' . $customer_id . '?group=attachments',
                ])) {
                array_push($notifiedUsers, $member['staffid']);
            }
        }
        pusher_trigger_notification($notifiedUsers);
    }

    public function get_staff_members_that_can_access_customer($id)
    {
        $id = $this->db->escape_str($id);

        return $this->db->query('SELECT * FROM ' . db_prefix() . 'staff
            WHERE (
                    admin=1
                    OR staffid IN (SELECT staff_id FROM ' . db_prefix() . "customer_admins WHERE customer_id='.$id.')
                    OR staffid IN(SELECT staff_id FROM " . db_prefix() . 'staff_permissions WHERE feature = "customers" AND capability="view")
                )
            AND active=1')->result_array();
    }

    private function check_zero_columns($data)
    {
        if (!isset($data['show_primary_contact'])) {
            $data['show_primary_contact'] = 0;
        }

        if (isset($data['default_currency']) && $data['default_currency'] == '' || !isset($data['default_currency'])) {
            $data['default_currency'] = 0;
        }

        if (isset($data['country']) && $data['country'] == '' || !isset($data['country'])) {
            $data['country'] = 0;
        }

        if (isset($data['billing_country']) && $data['billing_country'] == '' || !isset($data['billing_country'])) {
            $data['billing_country'] = 0;
        }

        if (isset($data['shipping_country']) && $data['shipping_country'] == '' || !isset($data['shipping_country'])) {
            $data['shipping_country'] = 0;
        }

        return $data;
    }

    public function count_orders_manual($order_type='',$data=array())
    {   
        extract($data);
        if($date_from != '' && $date_too !=''){

            $this->db->where('created_at >=', strtotime($date_from.' 00:00:00'));
            $this->db->where('created_at <=', strtotime($date_too.' 23:59:00'));

        }else if($date_from != '' && $date_too ==''){

            $this->db->where('created_at >=', strtotime($date_from.' 00:00:00'));
            $this->db->where('created_at <=', strtotime($date_from.' 23:59:00'));

        }else if($date_from == '' && $date_too !=''){

            $this->db->where('created_at >=', strtotime($date_too.' 00:00:00'));
            $this->db->where('created_at <=', strtotime($date_too.' 23:59:00'));

        }

        if($order_type == 'completed'){

            $this->db->where('completed_at >', 0);

        }

        if($order_type == 'declined'){

            $this->db->where('declined_at >', 0);

        }
        if($order_type == 'completed'){

            $this->db->where('completed_at >', 0);

        }

        if($order_type == 'pending'){

            $this->db->where('declined_at', 0);
            $this->db->where('completed_at', 0);
            $this->db->where('cancelled_at', 0);
            $this->db->where('delivery_at', 0);
            //$this->db->where('accepted_at > ', 0);

        }
        if ($month != '') {
            $date1 = date('Y').'-'.$month.'-01';
            $d=cal_days_in_month(CAL_GREGORIAN,$month,date('Y'));
            if($d < 10 ){$d = '0'.$d;}
            $date2 = date('Y').'-'.$month.'-'.$d;

            $this->db->where('created_at >=', strtotime($date1));
            $this->db->where('created_at <=', strtotime($date2));
            
        }
        if ($contact != '') {
            $this->db->where('user_id', $contact);
        }
        if ($driver != '') {
            $this->db->where('driver_id', $driver);
        }
        if ($client != '') {
            $this->db->where('restaurant_id', $client);
        }

        if ($city != '') {
            $this->db->where('city', $city);
        }
		// Manual order 
        $this->db->where('order_type', 'manual');

        //$this->db->where('total_amount  >', '0');
        $get_data = $this->db->get(db_prefix(). 'orders');
        $data_arr = $get_data->result_array();
        return count($data_arr);
    }
   
    public function count_orders($order_type='',$data=array())
    {   
        extract($data);
        if($date_from != '' && $date_too !=''){

            $this->db->where('created_at >=', strtotime($date_from.' 00:00:00'));
            $this->db->where('created_at <=', strtotime($date_too.' 23:59:00'));

        }else if($date_from != '' && $date_too ==''){

            $this->db->where('created_at >=', strtotime($date_from.' 00:00:00'));
            $this->db->where('created_at <=', strtotime($date_from.' 23:59:00'));

        }else if($date_from == '' && $date_too !=''){

            $this->db->where('created_at >=', strtotime($date_too.' 00:00:00'));
            $this->db->where('created_at <=', strtotime($date_too.' 23:59:00'));

        }

      /*  if($order_type == 'completed'){

            $this->db->where('completed_at >', 0);

        }

        if($order_type == 'declined'){

            $this->db->where('declined_at >', 0);

        }
        if($order_type == 'completed'){

            $this->db->where('completed_at >', 0);

        }

        if($order_type == 'pending'){

            $this->db->where('declined_at', 0);
            $this->db->where('completed_at', 0);
            $this->db->where('cancelled_at', 0);
            $this->db->where('delivery_at', 0);
            //$this->db->where('accepted_at > ', 0);

        }*/
		if($order_type){
		 $this->db->where('status', $order_type);
		}
        if ($month != '') {
            $date1 = date('Y').'-'.$month.'-01';
            $d=cal_days_in_month(CAL_GREGORIAN,$month,date('Y'));
            if($d < 10 ){$d = '0'.$d;}
            $date2 = date('Y').'-'.$month.'-'.$d;

            $this->db->where('created_at >=', strtotime($date1));
            $this->db->where('created_at <=', strtotime($date2));
            
        }
        if ($contact != '') {
            $this->db->where('user_id', $contact);
        }
        if ($driver != '') {
            $this->db->where('driver_id', $driver);
        }
        if ($client != '') {
            $this->db->where('restaurant_id', $client);
        }

        if ($city != '') {
            $this->db->where('city', $city);
        }

        $this->db->where('total_amount  >', '0');
        $get_data = $this->db->get(db_prefix(). 'orders');
        $data_arr = $get_data->result_array();
        return count($data_arr);
    }
	
	public function count_orders_ajax($order_type='',$data=array())
    {   
        extract($data);
        if($from_date != '' && $to_date !=''){

            $this->db->where('created_at >=', strtotime($from_date.' 00:00:00'));
            $this->db->where('created_at <=', strtotime($to_date.' 23:59:00'));

        }else if($from_date != '' && $to_date ==''){

             $this->db->where('created_at >=', strtotime($from_date.' 00:00:00'));
            $this->db->where('created_at <=', strtotime($to_date.' 23:59:00'));

        }else if($from_date == '' && $to_date !=''){

            $this->db->where('created_at >=', strtotime($from_date.' 00:00:00'));
            $this->db->where('created_at <=', strtotime($to_date.' 23:59:00'));

        }
		if($order_type){
		 $this->db->where('status', $order_type);
		}
        if ($month != '') {
            $date1 = date('Y').'-'.$month.'-01';
            $d=cal_days_in_month(CAL_GREGORIAN,$month,date('Y'));
            if($d < 10 ){$d = '0'.$d;}
            $date2 = date('Y').'-'.$month.'-'.$d;

            $this->db->where('created_at >=', strtotime($date1));
            $this->db->where('created_at <=', strtotime($date2));
            
        }
        $this->db->where('total_amount  >', '0');
        $get_data = $this->db->get(db_prefix(). 'orders');
        $data_arr = $get_data->result_array();
		
		//echo "<pre>";  print_r($data_arr); exit;
        return count($data_arr);
    }

    public function get_orders_count($data)
    {   
        
        //extract($data);
        echo '<pre>';
        print_r($data);
        exit;
        if($date_from != '' && $date_too !=''){

            $this->db->where('created_at >=', strtotime($date_from.' 00:00:00'));
            $this->db->where('created_at <=', strtotime($date_too.' 23:59:00'));

        }else if($date_from != '' && $date_too ==''){

            $this->db->where('created_at >=', strtotime($date_from.' 00:00:00'));
            $this->db->where('created_at <=', strtotime($date_from.' 23:59:00'));

        }else if($date_from == '' && $date_too !=''){

            $this->db->where('created_at >=', strtotime($date_too.' 00:00:00'));
            $this->db->where('created_at <=', strtotime($date_too.' 23:59:00'));

        }

        if($order_type == 'declined'){

            $this->db->where('declined_at >', 0);

        }
        if($order_type == 'completed'){

            $this->db->where('completed_at >', 0);

        }
        if($order_type == 'pending'){

            $this->db->where('declined_at', 0);
            $this->db->where('completed_at', 0);
            $this->db->where('cancelled_at', 0);
            $this->db->where('delivery_at', 0);
            //$this->db->where('accepted_at > ', 0);

        }
        if ($month != '') {
            $date1 = date('Y').'-'.$month.'-01';
            $d=cal_days_in_month(CAL_GREGORIAN,$month,date('Y'));
            if($d < 10 ){$d = '0'.$d;}
            $date2 = date('Y').'-'.$month.'-'.$d;
            
            $this->db->where('created_at >=', strtotime($date1));
            $this->db->where('created_at <=', strtotime($date2));
            
        }
        if ($contact != '') {
            $this->db->where('user_id', $contact);
        }
        if ($driver != '') {
            $this->db->where('driver_id', $driver);
        }
        if ($client != '') {
            $this->db->where('restaurant_id', $client);
        }
        $this->db->where('total_amount  >', '0');
        
        
        $get_data = $this->db->get(db_prefix(). 'orders');

        $data_arr = $get_data->result_array();

        $return_arr = array();
        foreach ($data_arr as $key => $value) {
            
            
            $this->db->where('dryvarfoods_id', $value['user_id']);
            $get_user = $this->db->get(db_prefix(). 'contacts');
            $user_arr =  $get_user->row_array();
            
            $return_arr[$key]['customer_name'] = $user_arr['firstname'].' '.$user_arr['lastname'];



            $this->db->where('dryvarfoods_id', $value['restaurant_id']);
            $get_user = $this->db->get(db_prefix(). 'clients');
            $user_arr =  $get_user->row_array();
            
            $return_arr[$key]['company_name'] = $user_arr['company'];


            if( $value['is_self_pickup'] ){

                $return_arr[$key]['driver_name'] = 'Self Pickup';

            }else{

                $this->db->where('driver_id', $value['driver_id']);
                $get_user = $this->db->get(db_prefix(). 'contacts');
                $user_arr =  $get_user->row_array();
                
                $return_arr[$key]['driver_name'] = $user_arr['firstname'].' '.$user_arr['lastname'];

            }
            

            $return_arr[$key]['total_amont'] = $value['total_amount'];
            $return_arr[$key]['city'] = $value['city'];

            $return_arr[$key]['dated'] = date('d-m-Y h:i A',$value['created_at']);

            $total_seconds = strtotime("now") - strtotime($return_arr[$key]['dated']);

            $minutes    = intval($total_seconds/60);
            $hours      = intval($minutes/60);
            $days       = intval($hours/24);
            $hours      = $days % 24;
            $minutes    = $hours % 60;
            $weeks      = intval($days/7);
            $months     = intval($weeks/4);

            if($months > 0 ){

               $time_ago = $months.' month/s ago' ;

            }elseif( $weeks > 0 ){

                $time_ago = $weeks.' week/s ago' ;

            }elseif( $weeks > 0 ){

                $time_ago = $days.'day/s ago ' ;

            }else{

                $time_ago = '';
                if( $hours > 0 ){

                    $time_ago .= $hours.'hour ' ;
                }

                $time_ago .= $minutes.'min ago ' ;
            }

            $return_arr[$key]['time_ago'] = $time_ago;

            $return_arr[$key]['status'] = 'Pending';

            if( $value['accepted_at'] > 0 ){ 

                $return_arr[$key]['status'] = 'Pending';
            }

            if( $value['cancelled_at'] > 0 ){ 

                $return_arr[$key]['status'] = 'Cancelled';
            }

            if( $value['delivery_at'] > 0 ){ 

                $return_arr[$key]['status'] = 'Delivered';
            }

            if( $value['declined_at'] > 0 ){ 

                $return_arr[$key]['status'] = 'Declined';
            }

            if( $value['completed_at'] > 0 ){ 

                $return_arr[$key]['status'] = 'Completed';
            }

            $return_arr[$key]['ID'] = $value['dryvarfoods_id'];


        }
        
        //echo "<pre>";  print_r($return_arr); exit;
        

        return count($return_arr);
    }

    public function get_orders_manual($data=array(),$start,$limit)
    {   
        
        extract($data);

        if($date_from != '' && $date_too !=''){

            $this->db->where('created_at >=', strtotime($date_from.' 00:00:00'));
            $this->db->where('created_at <=', strtotime($date_too.' 23:59:00'));

        }else if($date_from != '' && $date_too ==''){

            $this->db->where('created_at >=', strtotime($date_from.' 00:00:00'));
            $this->db->where('created_at <=', strtotime($date_from.' 23:59:00'));

        }else if($date_from == '' && $date_too !=''){

            $this->db->where('created_at >=', strtotime($date_too.' 00:00:00'));
            $this->db->where('created_at <=', strtotime($date_too.' 23:59:00'));

        }

        if($order_type == 'declined'){
            $this->db->where('declined_at >', 0);
        }
        if($order_type == 'completed'){
            $this->db->where('completed_at >', 0);
        }
        if($order_type == 'pending'){

            $this->db->where('declined_at', 0);
            $this->db->where('completed_at', 0);
            $this->db->where('cancelled_at', 0);
            $this->db->where('delivery_at', 0);
            //$this->db->where('accepted_at > ', 0);

        }
        if ($month != '') {
            $date1 = date('Y').'-'.$month.'-01';
            $d=cal_days_in_month(CAL_GREGORIAN,$month,date('Y'));
            if($d < 10 ){$d = '0'.$d;}
            $date2 = date('Y').'-'.$month.'-'.$d;
            
            $this->db->where('created_at >=', strtotime($date1));
            $this->db->where('created_at <=', strtotime($date2));
            
        }
        if ($contact != '') {
            $this->db->where('user_id', $contact);
        }
        if ($driver != '') {
            $this->db->where('driver_id', $driver);
        }
        if ($client != '') {
            $this->db->where('restaurant_id', $client);
        }
		// Manual order 
        $this->db->where('order_type', 'manual');
		//$this->db->where('total_amount  >', '0');
        $this->db->offset($start);
        $this->db->limit($limit);

        if($orderby !=''){
           $this->db->order_by('id', $orderby);
        }else{
           $this->db->order_by('id', 'DESC'); 
        }
        $get_data = $this->db->get(db_prefix(). 'orders');
        $data_arr = $get_data->result_array();
		//echo "<pre>";  print_r($data_arr); exit;

        $return_arr = array();
        foreach ($data_arr as $key => $value) {
            
            $this->db->where('dryvarfoods_id', $value['user_id']);
            $get_user = $this->db->get(db_prefix(). 'contacts');
            $user_arr =  $get_user->row_array();
            $return_arr[$key]['customer_name'] = $user_arr['firstname'].' '.$user_arr['lastname'];

            $this->db->where('dryvarfoods_id', $value['restaurant_id']);
            $get_user = $this->db->get(db_prefix(). 'clients');
            $user_arr =  $get_user->row_array();
            $return_arr[$key]['company_name'] = $user_arr['company'];

            if( $value['is_self_pickup']){
                $return_arr[$key]['driver_name'] = 'Self Pickup';
            }else{

                $this->db->where('driver_id', $value['driver_id']);
                $get_user = $this->db->get(db_prefix(). 'contacts');
                $user_arr =  $get_user->row_array();
                $return_arr[$key]['driver_name'] = $user_arr['firstname'].' '.$user_arr['lastname'];
            }
            
            if($value['restaurant_commision_fee'] == '' || $value['restaurant_commision_fee'] =='0'){
                $return_arr[$key]['restaurant_commision_fee'] = 'N/A';
            }else{
                $return_arr[$key]['restaurant_commision_fee'] = 'R'.$value['restaurant_commision_fee'];
            }

            $return_arr[$key]['total_amont'] = $value['total_amount'];
            $return_arr[$key]['city']        = $value['city'];
            $return_arr[$key]['dated']       = date('d-m-Y h:i A',$value['created_at']);

            $total_seconds = strtotime("now") - strtotime($return_arr[$key]['dated']);

            $minutes    = intval($total_seconds/60);
            $hours      = intval($minutes/60);
            $days       = intval($hours/24);
            $hours      = $days % 24;
            $minutes    = $hours % 60;
            $weeks      = intval($days/7);
            $months     = intval($weeks/4);

            if($months > 0 ){
               $time_ago = $months.' month/s ago' ;
            }elseif( $weeks > 0 ){
                $time_ago = $weeks.' week/s ago' ;
            }elseif( $weeks > 0 ){
                $time_ago = $days.'day/s ago ' ;
            }else{
                $time_ago = '';
                if( $hours > 0 ){
                    $time_ago .= $hours.'hour ' ;
                }
                $time_ago .= $minutes.'min ago ' ;
            }
            $return_arr[$key]['time_ago'] = $time_ago;
            $return_arr[$key]['status'] = 'Pending';
            if( $value['accepted_at'] > 0 ){ 
                $return_arr[$key]['status'] = 'Pending';
			}
            if( $value['cancelled_at'] > 0 ){ 

                $return_arr[$key]['status'] = 'Cancelled';
            }

            if( $value['delivery_at'] > 0 ){ 

                $return_arr[$key]['status'] = 'Delivered';
            }

            if( $value['declined_at'] > 0 ){ 

                $return_arr[$key]['status'] = 'Declined';
            }

            if( $value['completed_at'] > 0 ){ 

                $return_arr[$key]['status'] = 'Completed';
            }

            $return_arr[$key]['ID'] = $value['dryvarfoods_id'];


        }
        
       
        

        return $return_arr;
    }
	
	
	public function get_orders($data=array(),$start,$limit)
    {   
        
        extract($data);
        
        if($date_from != '' && $date_too !=''){

            $this->db->where('created_at >=', strtotime($date_from.' 00:00:00'));
            $this->db->where('created_at <=', strtotime($date_too.' 23:59:00'));

        }else if($date_from != '' && $date_too ==''){

            $this->db->where('created_at >=', strtotime($date_from.' 00:00:00'));
            $this->db->where('created_at <=', strtotime($date_from.' 23:59:00'));

        }else if($date_from == '' && $date_too !=''){

            $this->db->where('created_at >=', strtotime($date_too.' 00:00:00'));
            $this->db->where('created_at <=', strtotime($date_too.' 23:59:00'));

        }

        /*if($order_type == 'declined'){

            $this->db->where('declined_at >', 0);

        }
        if($order_type == 'completed'){

            $this->db->where('completed_at >', 0);

        }
        if($order_type == 'pending'){

            $this->db->where('declined_at', 0);
            $this->db->where('completed_at', 0);
            $this->db->where('cancelled_at', 0);
            $this->db->where('delivery_at', 0);
            //$this->db->where('accepted_at > ', 0);

        }*/
		if($order_type){
            $this->db->where('status', $order_type);
        }
        if ($month != '') {
            $date1 = date('Y').'-'.$month.'-01';
            $d=cal_days_in_month(CAL_GREGORIAN,$month,date('Y'));
            if($d < 10 ){$d = '0'.$d;}
            $date2 = date('Y').'-'.$month.'-'.$d;
            
            $this->db->where('created_at >=', strtotime($date1));
            $this->db->where('created_at <=', strtotime($date2));
            
        }
        if ($contact != '') {
            $this->db->where('user_id', $contact);
        }
        if ($driver != '') {
            $this->db->where('driver_id', $driver);
        }
        if ($client != '') {
            $this->db->where('restaurant_id', $client);
        }
		// Manual order 
        //$this->db->where('order_type', 'manual');
		$this->db->where('total_amount  >', '0');
        $this->db->offset($start);
        $this->db->limit($limit);

        if($orderby !=''){
            $this->db->order_by('id', $orderby);
        }else{
          $this->db->order_by('id', 'DESC'); 
        }
		
        $get_data = $this->db->get(db_prefix(). 'orders');
        $data_arr = $get_data->result_array();

        $return_arr = array();
        foreach ($data_arr as $key => $value) {
            
            $this->db->where('dryvarfoods_id', $value['user_id']);
            $get_user = $this->db->get(db_prefix(). 'contacts');
            $user_arr =  $get_user->row_array();
            
            $return_arr[$key]['customer_name'] = $user_arr['firstname'].' '.$user_arr['lastname'];

            $return_arr[$key]['reward_points'] = $value['reward_amount'];
            $return_arr[$key]['loyalty_points'] = $value['loyalty_amount'];

            $this->db->where('dryvarfoods_id', $value['restaurant_id']);
            $get_user = $this->db->get(db_prefix(). 'clients');
            $user_arr =  $get_user->row_array();
            
            $return_arr[$key]['company_name'] = $user_arr['company'];


            if( $value['is_self_pickup'] ){
                $return_arr[$key]['driver_name'] = 'Self Pickup';
            }else{
                $this->db->where('driver_id', $value['driver_id']);
                $get_user = $this->db->get(db_prefix(). 'contacts');
                $user_arr =  $get_user->row_array();
                
                $return_arr[$key]['driver_name'] = $user_arr['firstname'].' '.$user_arr['lastname'];
            }
            
            
            if($value['restaurant_commision_fee'] == '' || $value['restaurant_commision_fee'] =='0'){
                $return_arr[$key]['restaurant_commision_fee'] = 'N/A';
            }else{
                $return_arr[$key]['restaurant_commision_fee'] = $value['restaurant_commision_fee'];
            }

            $return_arr[$key]['total_amont'] = $value['total_amount'];
            $return_arr[$key]['city'] = $value['city'];

            $return_arr[$key]['dated'] = date('d-m-Y h:i A',$value['created_at']);
            $total_seconds = strtotime("now") - strtotime($return_arr[$key]['dated']);

            $minutes    = intval($total_seconds/60);
            $hours      = intval($minutes/60);
            $days       = intval($hours/24);
            $hours      = $days % 24;
            $minutes    = $hours % 60;
            $weeks      = intval($days/7);
            $months     = intval($weeks/4);

            if($months > 0 ){

               $time_ago = $months.' month/s ago' ;

            }elseif( $weeks > 0 ){

                $time_ago = $weeks.' week/s ago' ;

            }elseif( $weeks > 0 ){

                $time_ago = $days.'day/s ago ' ;

            }else{

                $time_ago = '';
                if( $hours > 0 ){

                    $time_ago .= $hours.'hour ' ;
                }

                $time_ago .= $minutes.'min ago ' ;
            }

            $return_arr[$key]['time_ago'] = $time_ago;

            $return_arr[$key]['status'] = 'Pending';

            if( $value['accepted_at'] > 0 && $value['status']!=3){ 

                $return_arr[$key]['status'] = 'Pending';
            }

            if( $value['cancelled_at'] > 0 ){ 

                $return_arr[$key]['status'] = 'Cancelled';
            }

            
			if( $value['delivery_at'] > 0 && $value['status']!= 5){ 

                $return_arr[$key]['status'] = 'Delivered';
            }
			

            if( $value['declined_at'] > 0 ){ 

                $return_arr[$key]['status'] = 'Declined';
            }

            if( $value['completed_at'] > 0 ){ 

                $return_arr[$key]['status'] = 'Completed';
            }
			 if( $value['status']==0 ){ 

                $return_arr[$key]['status'] = 'InCart';
            }
			if( $value['status'] ==1 ){ 

                $return_arr[$key]['status'] = 'Pending';
            }
			if( $value['status'] ==2 ){ 

                $return_arr[$key]['status'] = 'Declined';
            }
			if( $value['status'] ==3 ){ 

                $return_arr[$key]['status'] = 'Accepted';
            }
			if( $value['status'] ==4 ){ 

                $return_arr[$key]['status'] = 'Cancelled';
            }
			if( $value['status'] ==5 ){ 

                $return_arr[$key]['status'] = 'Delivery';
            }
			if( $value['status'] ==6 ){ 

                $return_arr[$key]['status'] = 'Completed';
            }
			if( $value['status'] ==7 ){ 

                $return_arr[$key]['status'] = 'Expired';
            }

            $return_arr[$key]['ID'] = $value['dryvarfoods_id'];

        }
        
        //echo "<pre>";  print_r($return_arr); exit;        

        return $return_arr;
    }

    public function get_orders_csv($data=array())
    {   
        
        extract($data);

        $this->db->where('total_amount  >', '0');
        $this->db->order_by('id', 'DESC');
        $get_data = $this->db->get(db_prefix(). 'orders');

        $data_arr = $get_data->result_array();

        $return_arr = array();
        foreach ($data_arr as $key => $value) {
            
            $return_arr[$key]['ID'] = $value['dryvarfoods_id'];
            
            $this->db->where('dryvarfoods_id', $value['user_id']);
            $get_user = $this->db->get(db_prefix(). 'contacts');
            $user_arr =  $get_user->row_array();
            
            $return_arr[$key]['customer_name'] = $user_arr['firstname'].' '.$user_arr['lastname'];



            $this->db->where('dryvarfoods_id', $value['restaurant_id']);
            $get_user = $this->db->get(db_prefix(). 'clients');
            $user_arr =  $get_user->row_array();
            
            $return_arr[$key]['company_name'] = $user_arr['company'];


            $return_arr[$key]['status'] = 'Pending';

            if( $value['accepted_at'] > 0 ){ 

                $return_arr[$key]['status'] = 'Pending';
            }

            if( $value['cancelled_at'] > 0 ){ 

                $return_arr[$key]['status'] = 'Cancelled';
            }

            if( $value['delivery_at'] > 0 ){ 

                $return_arr[$key]['status'] = 'Delivered';
            }

            if( $value['declined_at'] > 0 ){ 

                $return_arr[$key]['status'] = 'Declined';
            }

            if( $value['completed_at'] > 0 ){ 

                $return_arr[$key]['status'] = 'Completed';
            }

            $return_arr[$key]['total_amont'] = $value['total_amount'];

            if( $value['is_self_pickup'] ){

                $return_arr[$key]['driver_name'] = 'Self Pickup';

            }else{

                $this->db->where('dryvarfoods_id', $value['driver_id']);
                $get_user = $this->db->get(db_prefix(). 'contacts');
                $user_arr =  $get_user->row_array();
                
                $return_arr[$key]['driver_name'] = $user_arr['firstname'].' '.$user_arr['lastname'];
            }
            

            

            $return_arr[$key]['dated'] = date('d-m-Y',$value['created_at']);

            


        }
        
        //echo "<pre>";  print_r($return_arr); exit;
        

        return $return_arr;
    }
	
	public function get_orders_csv_manual($data=array())
    {   
        
        extract($data);

        $this->db->where('total_amount  >', '0');
        $this->db->order_by('id', 'DESC');
        $get_data = $this->db->get(db_prefix(). 'orders');

        $data_arr = $get_data->result_array();

        $return_arr = array();
        foreach ($data_arr as $key => $value) {
            
            $return_arr[$key]['ID'] = $value['dryvarfoods_id'];
            
            $this->db->where('dryvarfoods_id', $value['user_id']);
            $get_user = $this->db->get(db_prefix(). 'contacts');
            $user_arr =  $get_user->row_array();
            
            $return_arr[$key]['customer_name'] = $user_arr['firstname'].' '.$user_arr['lastname'];



            $this->db->where('dryvarfoods_id', $value['restaurant_id']);
            $get_user = $this->db->get(db_prefix(). 'clients');
            $user_arr =  $get_user->row_array();
            
            $return_arr[$key]['company_name'] = $user_arr['company'];


            $return_arr[$key]['status'] = 'Pending';

            if( $value['accepted_at'] > 0 ){ 

                $return_arr[$key]['status'] = 'Pending';
            }

            if( $value['cancelled_at'] > 0 ){ 

                $return_arr[$key]['status'] = 'Cancelled';
            }

            if( $value['delivery_at'] > 0 ){ 

                $return_arr[$key]['status'] = 'Delivered';
            }

            if( $value['declined_at'] > 0 ){ 

                $return_arr[$key]['status'] = 'Declined';
            }

            if( $value['completed_at'] > 0 ){ 

                $return_arr[$key]['status'] = 'Completed';
            }

            $return_arr[$key]['total_amont'] = $value['total_amount'];

            if( $value['is_self_pickup'] ){

                $return_arr[$key]['driver_name'] = 'Self Pickup';

            }else{

                $this->db->where('dryvarfoods_id', $value['driver_id']);
                $get_user = $this->db->get(db_prefix(). 'contacts');
                $user_arr =  $get_user->row_array();
                
                $return_arr[$key]['driver_name'] = $user_arr['firstname'].' '.$user_arr['lastname'];
            }
            

            

            $return_arr[$key]['dated'] = date('d-m-Y',$value['created_at']);

            


        }
        
        //echo "<pre>";  print_r($return_arr); exit;
        

        return $return_arr;
    }

    public function get_orders_stats($data=array())
    {   
        
        extract($data);
        
        if ($client != '') {
            $this->db->where('restaurant_id', $client);
        }
        $this->db->where('total_amount  >', '0');
        $get_data = $this->db->get(db_prefix(). 'orders');
        $data_arr = $get_data->result_array();
        $return_arr['total_orders'] = count($data_arr);

        $this->db->select_sum('total_amount');
        if ($client != '') {
            $this->db->where('restaurant_id', $client);
        }
        $this->db->where('total_amount  >', '0');
        $get_data = $this->db->get(db_prefix(). 'orders');
        $data_arr = $get_data->row_array();
        $return_arr['total_amount'] = $data_arr['total_amount'];


        if ($client != '') {
            $this->db->where('restaurant_id', $client);
        }
        $this->db->where('total_amount  >', '0');
        $this->db->where('completed_at  >', '0');
        $get_data = $this->db->get(db_prefix(). 'orders');
        $data_arr = $get_data->result_array();
        $return_arr['completed_orders'] = count($data_arr);


        if ($client != '') {
            $this->db->where('restaurant_id', $client);
        }
        $this->db->where('total_amount  >', '0');
        $this->db->where('declined_at  >', '0');
        $get_data = $this->db->get(db_prefix(). 'orders');
        $data_arr = $get_data->result_array();
        $return_arr['declined_orders'] = count($data_arr);


        $this->db->where('total_amount  >', '0');
        $this->db->where('declined_at', '0');
        $this->db->where('completed_at', '0');
        $this->db->where('cancelled_at', '0');
        //$this->db->where('accepted_at >', '0');
        $get_data = $this->db->get(db_prefix(). 'orders');
        $data_arr = $get_data->result_array();
        $return_arr['pending_orders'] = count($data_arr);
            
        

        return $return_arr;
    }
    

    public function get_orders_graph($data=array())
    {   
        
        extract($data);
        
        $firstday     = mktime(0, 0, 0, date("m"), 1, date("Y")); 
        $begin =  date("Y-m-d", $firstday-1); 
 
        $begin = new DateTime(  $begin );
        $end = date('Y-m-d');
        $end = new DateTime( $end );
        $end = $end->modify( '+1 day' );

        $interval = new DateInterval('P1D');
        $daterange = new DatePeriod($begin, $interval ,$end);

        foreach($daterange as $date_val){

            $date = $date_val->format("Y-m-d");
            $return_arr['dates'][] = $date;

            $start = strtotime( $date_val->format("Y-m-d 00:00:00") );
            $end = strtotime( $date_val->format("Y-m-d 23:59:00") );
            
            $this->db->where('created_at >=', $start);
            $this->db->where('created_at <=', $end);
            if ($client != '') {
                $this->db->where('restaurant_id', $client);
            }

            if ($city != '') {
                $this->db->where('city', $city);
            }
            $this->db->where('total_amount  >', '0');
            $get_data = $this->db->get(db_prefix(). 'orders');
            $data_arr = $get_data->result_array();
            $return_arr['total_orders'][] = count($data_arr);

            $this->db->where('created_at >=', $start);
            $this->db->where('created_at <=', $end);
            $this->db->select_sum('total_amount');
            if ($client != '') {
                $this->db->where('restaurant_id', $client);
            }

            if ($city != '') {
                $this->db->where('city', $city);
            }
            $this->db->where('total_amount  >', '0');
            $get_data = $this->db->get(db_prefix(). 'orders');
            $data_arr = $get_data->row_array();
            $return_arr['total_amount'][] = (int) $data_arr['total_amount'];


            $this->db->where('created_at >=', $start);
            $this->db->where('created_at <=', $end);
            if ($client != '') {
                $this->db->where('restaurant_id', $client);
            }

            if ($city != '') {
                $this->db->where('city', $city);
            }
            $this->db->where('total_amount  >', '0');
            $this->db->where('completed_at  >', '0');
            $get_data = $this->db->get(db_prefix(). 'orders');
            $data_arr = $get_data->result_array();
            $return_arr['completed_orders'][] = count($data_arr);


            $this->db->where('created_at >=', $start);
            $this->db->where('created_at <=', $end);
            if ($client != '') {
                $this->db->where('restaurant_id', $client);
            }

            if ($city != '') {
                $this->db->where('city', $city);
            }
            $this->db->where('total_amount  >', '0');
            $this->db->where('declined_at  >', '0');
            $get_data = $this->db->get(db_prefix(). 'orders');
            $data_arr = $get_data->result_array();
            $return_arr['declined_orders'][] = count($data_arr);

            $this->db->where('created_at >=', $start);
            $this->db->where('created_at <=', $end);
            $this->db->where('total_amount  >', '0');
            $this->db->where('declined_at', '0');
            $this->db->where('completed_at', '0');
            $this->db->where('cancelled_at', '0');
            $this->db->where('accepted_at >', '0');
            if ($client != '') {
                $this->db->where('restaurant_id', $client);
            }

            if ($city != '') {
                $this->db->where('city', $city);
            }
            $this->db->where('total_amount  >', '0');
            $get_data = $this->db->get(db_prefix(). 'orders');
            $data_arr = $get_data->result_array();
            $return_arr['pending_orders'][] = count($data_arr);
        }  
        
        return $return_arr;
    }


    public function get_sales_graph($data=array(),$city1='')
    {   
        
        extract($data);
        
        if($month != '' ){

            $n_d=cal_days_in_month(CAL_GREGORIAN,intval($month),intval($year) );

            for ($i=1; $i <= $n_d; $i++) { 

                if($i < 10 ){$index = '0'.$i;}else{ $index = $i;}

                $months[] = $index;
            }

            $return_arr['months'] =  $months;
            $i = 0;
            foreach($months as $key => $date_val){

                $i += 1;
                $return_arr['dates'][] = $date_val;

                $start = strtotime( date($year."-".$month.'-'.$i."00:00:00") );
                $end = strtotime( date($year."-".$month.'-'.$i."23:59:00") );
                
                

                $this->db->where('tblorders.created_at >=', $start);
                $this->db->where('tblorders.created_at <=', $end);
                $this->db->select_sum('tblorders.total_amount');
                if ($client != '') {
                    $this->db->where('tblorders.restaurant_id', $client);
                }
                if ($city != '') {

                    $this->db->like('tblorders.city', $city, 'both');
                }
                if ($city1 != '') {

                    $this->db->like('tblorders.city', $city1, 'both');
                }
                $this->db->where('tblorders.total_amount  >', '0');
                $this->db->from('tblorders');
                $get_data = $this->db->get();
                $data_arr = $get_data->row_array();
                $return_arr['total_amount'][] = (int) $data_arr['total_amount'];



                $this->db->where('tblorders.created_at >=', $start);
                $this->db->where('tblorders.created_at <=', $end);
                if ($client != '') {
                    $this->db->where('tblorders.restaurant_id', $client);
                }
                if ($city != '') {

                    $this->db->like('tblorders.city', $city, 'both');
                }
                if ($city1 != '') {

                    $this->db->like('tblorders.city', $city1, 'both');
                }
                $this->db->where('tblorders.total_amount  >', '0');

                $this->db->from('tblorders');

                $get_data = $this->db->get();
                $data_arr = $get_data->result_array();
                $return_arr['total_orders'][] = count($data_arr);


                
            } 

        }
		else{
            if(isset($year) && $year!=""){
				$months = array('Jan '.$year, 'Feb '.$year, 'Mar '.$year, 'Apr '.$year, 'May '.$year, 'Jun '.$year, 'Jul '.$year, 'Aug '.$year, 'Sep '.$year, 'Oct '.$year, 'Nov '.$year, 'Dec '.$year);
           
			}
			else{
               $months = array('Jan 2020', 'Feb 2020', 'Mar 2020', 'Apr 2020', 'May 2020', 'Jun 2020', 'Jul 2020', 'Aug 2020', 'Sep 2020', 'Oct 2020', 'Nov 2020', 'Dec 2020', 'Jan 2021', 'Feb 2021', 'Mar 2021', 'Apr 2021', 'May 2021', 'Jun 2021', 'Jul 2021', 'Aug 2021', 'Sep 2021', 'Oct 2021', 'Nov 2021', 'Dec 2021');
            }
			$return_arr['months'] =  $months;
            $i = 0;
            foreach($months as $key => $date_val){
                $month_name = explode(" ", $date_val);
                $i += 1;
				if($i==13){
				  $i=1;	
				}
                $return_arr['dates'][] = $date_val;
				
				if($i < 10){ $index = intval('0'.$i);}else{ $index = $i;}
            
                $d=cal_days_in_month(CAL_GREGORIAN,$i,$month_name[1]);

                $start = strtotime( date($month_name[1]."-".$index."-1 00:00:00") );
                $end = strtotime( date($month_name[1]."-".$index."-".$d." 23:59:00") );
                
                

                $this->db->where('tblorders.created_at >=', $start);
                $this->db->where('tblorders.created_at <=', $end);
                $this->db->select_sum('tblorders.total_amount');
                if ($client != '') {
                    $this->db->where('tblorders.restaurant_id', $client);
                }
                if ($city != '') {

                    $this->db->like('tblorders.city', $city, 'both');
                }
                if ($city1 != '') {

                    $this->db->like('tblorders.city', $city1, 'both');
                }
                $this->db->where('tblorders.total_amount  >', '0');
                $this->db->from('tblorders');
                $get_data = $this->db->get();
                $data_arr = $get_data->row_array();
                $return_arr['total_amount'][] = (int) $data_arr['total_amount'];



                $this->db->where('tblorders.created_at >=', $start);
                $this->db->where('tblorders.created_at <=', $end);
                if ($client != '') {
                    $this->db->where('tblorders.restaurant_id', $client);
                }
                if ($city != '') {

                    $this->db->like('tblorders.city', $city, 'both');
                }
                if ($city1 != '') {

                    $this->db->like('tblorders.city', $city1, 'both');
                }
                $this->db->where('tblorders.total_amount  >', '0');

                $this->db->from('tblorders');

                $get_data = $this->db->get();
                $data_arr = $get_data->result_array();
                $return_arr['total_orders'][] = count($data_arr);


                
            } 

        } 
		
        return $return_arr;
    }
    

	


    public function get_orders_all()
    {   
        
        extract($data);
      
        $this->db->where('total_amount  >', '0');
         $this->db->group_by('restaurant_id');
        $this->db->order_by('id', 'DESC');
		
        $get_data = $this->db->get(db_prefix(). 'orders');

        $data_arr = $get_data->result_array();
		

        $return_arr = array();
        foreach ($data_arr as $key => $value) {

            $this->db->where('dryvarfoods_id', $value['restaurant_id']);
            $get_user = $this->db->get(db_prefix(). 'clients');
            $user_arr =  $get_user->row_array();
            
            $return_arr[$key]['company_name'] = $user_arr['company'];
            $return_arr[$key]['ID'] = $value['dryvarfoods_id'];

        }
		
		//echo "<pre>";  print_r($return_arr); exit;
		

        return $return_arr;
    }

    
	
	public function count_orders_statuses($order_type,$city='')
    {   

        if($order_type == 'declined'){

            $this->db->where('tblorders.declined_at >', 0);

        }
        if($order_type == 'completed'){

            $this->db->where('tblorders.completed_at >', 0);

        }
        if($order_type == 'pending'){

            $this->db->where('tblorders.declined_at', 0);
            $this->db->where('tblorders.completed_at', 0);
            $this->db->where('tblorders.cancelled_at', 0);
            $this->db->where('tblorders.delivery_at', 0);
            //$this->db->where('accepted_at > ', 0);

        }
	    $this->db->where('tblorders.total_amount  >', '0');
        if ($city != '') {

            $this->db->like('tblorder_delivery.drop_location', $city, 'both');
        }
        $this->db->from('tblorders');
        if ($city != '') {
            $this->db->join('tblorder_delivery', 'tblorder_delivery.order_id = tblorders.dryvarfoods_id', 'left');
        }
        $get_data = $this->db->get();
        $data_arr = $get_data->result_array();
		
		$sql = $this->db->last_query();
		
		
	
		
		
        return count($data_arr);
    }
	
	
	public function count_orders_statuses_manual($order_type,$city='')
    {   

        if($order_type == 'declined'){

            $this->db->where('tblorders.declined_at >', 0);

        }
        if($order_type == 'completed'){

            $this->db->where('tblorders.completed_at >', 0);

        }
        if($order_type == 'pending'){

            $this->db->where('tblorders.declined_at', 0);
            $this->db->where('tblorders.completed_at', 0);
            $this->db->where('tblorders.cancelled_at', 0);
            $this->db->where('tblorders.delivery_at', 0);
            //$this->db->where('accepted_at > ', 0);

        }
		$this->db->where('tblorders.order_type', 'manual');
	    $this->db->where('tblorders.total_amount  >', '0');
        if ($city != '') {

            $this->db->like('tblorder_delivery.drop_location', $city, 'both');
        }
        $this->db->from('tblorders');
        if ($city != '') {
            $this->db->join('tblorder_delivery', 'tblorder_delivery.order_id = tblorders.dryvarfoods_id', 'left');
        }
        $get_data = $this->db->get();
        $data_arr = $get_data->result_array();
		
		$sql = $this->db->last_query();
		
		
	
		
		
        return count($data_arr);
    }
	
	

    public function get_ajax_clients($data,$user_id)
    {   
        extract($data);

        if($client_id !=''){

            $this->db->where('dryvarfoods_id', $client_id);
            $this->db->order_by('company', 'ASC');
            $get_data = $this->db->get(db_prefix(). 'clients');

            $data_arr = $get_data->result_array();

            $results['results']= array();
            foreach ($data_arr as $key => $value) {
                
                
                $results['results'][] = array('id' => $value['dryvarfoods_id'],'text' =>  $value['company'],'selected'=> true);
            }

        }else if($term !=''){
            $this->db->like('company', $term, 'after');
            $this->db->order_by('company', 'ASC');
            $get_data = $this->db->get(db_prefix(). 'clients');

            $data_arr = $get_data->result_array();

            $results['results']= array();
            foreach ($data_arr as $key => $value) {
                
                $results['results'][] = array('id' => $value['dryvarfoods_id'],'text' =>  $value['company']);
            }

        } else{

            $results['results'][] = array('id' =>'','text' => 'Please type in search to load options.');
        }

        return $results;
    }

    public function get_ajax_contacts($data,$user_id)
    {   
        extract($data);

        if($user_id !=''){

            $this->db->where('dryvarfoods_id', $user_id);
            $this->db->where('type', $type);
            $this->db->order_by('firstname', 'ASC');
            $get_data = $this->db->get(db_prefix(). 'contacts');

            $data_arr = $get_data->result_array();

            $results['results']= array();
            foreach ($data_arr as $key => $value) {
                
                if($type == '2'){

                   $results['results'][] = array('id' => $value['driver_id'],'text' =>  $value['company'],'selected'=> true); 
                }else{
                    $results['results'][] = array('id' => $value['dryvarfoods_id'],'text' =>  $value['company'],'selected'=> true);
                }
            }

        }else if($term !=''){
            $this->db->like('firstname', $term, 'after');
            $this->db->where('type', $type);
            $this->db->order_by('firstname', 'ASC');
            $get_data = $this->db->get(db_prefix(). 'contacts');

            $data_arr = $get_data->result_array();

            $results['results']= array();
            foreach ($data_arr as $key => $value) {

                $name = $value['firstname'].' '.$value['lastname'];

                if($type == '2'){

                   $results['results'][] = array('id' => $value['driver_id'],'text' =>  $name); 
                }else{
                    $results['results'][] = array('id' => $value['dryvarfoods_id'],'text' =>  $name);
                }
            }

        }else{

            $results['results'][] = array('id' =>'','text' => 'Please type in search to load options.');
        }

        return $results;
    }


    public function get_graph_clients($data=array())
    {   

        $this->db->order_by('userid', 'DESC');
        $this->db->limit(12);
        $get_data = $this->db->get(db_prefix(). 'clients');

        $results = $get_data->result_array();


        return $results;
    }


    public function get_orders_detail($order_id)
    {   
        $this->db->where('dryvarfoods_id',$order_id);
        $get_data = $this->db->get(db_prefix(). 'orders');
        $order_arr = $get_data->row_array();

        $this->db->where('dryvarfoods_id', $order_arr['user_id']);
        $get_user = $this->db->get(db_prefix(). 'contacts');
        $user_arr =  $get_user->row_array();
		
        $order_arr['customer_name'] = $user_arr['firstname'].' '.$user_arr['lastname'];
		$order_arr['customer_city'] = $user_arr['city'];
		$order_arr['customer_state'] = $user_arr['state'];
		$order_arr['customer_address'] = $user_arr['address'];
		$order_arr['customer_phonenumber'] = $user_arr['phonenumber'];

        $this->db->where('dryvarfoods_id', $order_arr['restaurant_id']);
        $get_user = $this->db->get(db_prefix(). 'clients');
        $user_arr =  $get_user->row_array();
		//echo "<pre>";  print_r($user_arr); exit;
		        
        $order_arr['company_name'] = $user_arr['company'];
		$order_arr['company_city'] = $user_arr['city'];
		$order_arr['company_state'] = $user_arr['state'];
		$order_arr['company_address'] = $user_arr['address'];
		$order_arr['company_phonenumber'] = $user_arr['phonenumber'];

        if( $order_arr['is_self_pickup'] ){

            $order_arr['driver_name'] = 'Self Pickup';

        }else{

            $this->db->where('driver_id', $order_arr['driver_id']);
            $get_user = $this->db->get(db_prefix(). 'contacts');
            $user_arr =  $get_user->row_array();
			//echo "<pre>";  print_r($user_arr); exit;
            
            $order_arr['driver_name'] = $user_arr['firstname'].' '.$user_arr['lastname'];
			$order_arr['driver_phonenumber'] = $user_arr['phonenumber'];
        }

        $this->db->where('order_id', $order_arr['dryvarfoods_id']);
        $get_user = $this->db->get(db_prefix(). 'order_delivery');
        $user_arr =  $get_user->row_array();

        $order_arr['delivery_details'] = $user_arr;

        $this->db->where('order_id', $order_arr['dryvarfoods_id']);
        $get_user = $this->db->get(db_prefix(). 'order_item');
        $user_arr =  $get_user->result_array();

        foreach ($user_arr as $key => $value) {
            $this->db->where('dryvarfoods_id', $value['menu_item_id']);
            $get_user = $this->db->get(db_prefix(). 'menu_item');
            $data_arr12 =  $get_user->row_array();

            $user_arr[$key]['item_name'] = $data_arr12['name'];
        }

        $order_arr['order_items'] = $user_arr;
		// Order Add On 
		
        foreach ($user_arr as $keyVal => $valueAddOn) {
                   
            $this->db->where('dryvarfoods_id', $valueAddOn['menu_item_id']);
            $get_userAddOn = $this->db->get(db_prefix(). 'menu_item_add_on');
            $data_arr12345 =  $get_userAddOn->row_array();
			
            $user_arr00[$keyVal]['item_add_on'] = $data_arr12345['name'];
			$user_arr00[$keyVal]['is_multiple'] = $data_arr12345['is_multiple'];
        }
		
		
        $order_arr['order_add_ons'] = $user_arr00;
        // $this->db->where('order_id', $order_arr['dryvarfoods_id']);
        // $get_user = $this->db->get('tblreview');
        // $user_arr =  $get_user->result_array();
        // $order_arr['review'] = $user_arr[0];
        return $order_arr;

    }

    public function customer_never_purchased($range='',$data)
    {   
        extract($data);
        $where = '';
        if($range != ''){
            $date = date('Y-m-d 00:00:00',strtotime('-'.$range.' days'));
            $where = " AND  tblcontacts.datecreated > '".$date."' ";
        }
        if($city != ''){

            $where .= " AND  tblcontacts.city = '".$city."' ";
        }
        $get_data = $this->db->query("SELECT  tblcontacts.* 
            FROM tblcontacts LEFT JOIN tblorders 
            ON tblcontacts.dryvarfoods_id = tblorders.user_id 
            WHERE type=0 ".$where." AND tblorders.user_id IS NULL  LIMIT 2000");
            return $get_data->result_array();
    }

    public function customer_not_purchased($days,$data)
    {   
        extract($data);
        $date = strtotime('-'.$days.' days');
        if($city != ''){

            $where .= " AND  tblcontacts.city = '".$city."' ";
        }
        $get_data = $this->db->query("SELECT DISTINCT tblcontacts.* 
            FROM tblcontacts join tblorders 
            ON tblcontacts.dryvarfoods_id = tblorders.user_id 
            WHERE tblcontacts.type=0 AND tblorders.created_at < $date ".$where." LIMIT 2000");

            return $get_data->result_array();
    }

    public function customer_first_purchased()
    {   
        
        $get_data = $this->db->query("SELECT user_id, COUNT(user_id) 
            FROM tblorders 
            GROUP BY user_id
            HAVING COUNT(user_id) < 2");

        $data_arr = array_reverse( $get_data->result_array() );

        foreach ($data_arr as $key => $value) {
            
            $this->db->where('dryvarfoods_id', $value['user_id']);
            $get_user = $this->db->get(db_prefix(). 'contacts');
            $user_arr =  $get_user->row_array();
            
            $data_arr[$key]['customer_name'] = $user_arr['firstname'].' '.$user_arr['lastname'];
            $data_arr[$key]['dryvarfoods_id'] = $value['user_id'];
            $data_arr[$key]['email'] = $user_arr['email'];
            $data_arr[$key]['datecreated'] = $user_arr['datecreated'];
        }

        return $data_arr;
    }

    public function top_10_restaurants($data=array())
    {   
        extract($data);
        if($city != ''){

            $where .= " AND  city = '".$city."' ";
        }
        $get_data = $this->db->query("SELECT restaurant_id, COUNT(*) as y FROM tblorders where 1=1 ".$where." GROUP BY restaurant_id ORDER BY y DESC LIMIT 10");

        $data_arr = $get_data->result_array();
        $res_arr = array();
        foreach ($data_arr as $key => $value) {
            
            $this->db->where('dryvarfoods_id', $value['restaurant_id']);
            $get_user = $this->db->get(db_prefix(). 'clients');
            $user_arr =  $get_user->row_array();

            $res_arr[] = array('name' =>$user_arr['company'],'y'=>intval($value['y']),'drilldown' =>$user_arr['company'],'id' =>$value['restaurant_id']);
        }

        return $res_arr;
    }

    public function top_10_contacts()
    {   
        if($city != ''){

            $where .= " AND  city = '".$city."' ";
        }
        $get_data = $this->db->query("SELECT user_id, COUNT(*) as y FROM tblorders where 1=1 ".$where." GROUP BY user_id ORDER BY y DESC LIMIT 10");

        $data_arr = $get_data->result_array();
        $res_arr = array();
        foreach ($data_arr as $key => $value) {
            
            $this->db->where('dryvarfoods_id', $value['user_id']);
            $get_user = $this->db->get(db_prefix(). 'contacts');
            $user_arr =  $get_user->row_array();

            $res_arr[] = array('name' =>$user_arr['firstname'],'y'=>intval($value['y']),'drilldown' =>$user_arr['firstname'],'id' => $value['user_id']);
        }

        return $res_arr;
    }
	
	public function get_customer_order_details($user_id){
		
		$data['last_order'] = '<span class="label label-danger">Never Purchased</span>'; 
    	$data['total_orders'] = '<span class="label label-danger">Never Purchased</span>';
    	$data['last_30_day_orders'] = '<span class="label label-primary">No Orders</span>'; 
    	$data['prefered'] = '<span class="label label-primary">Never Purchased</span>'; 
		
		$date = strtotime('-30 days');
		$get_data = $this->db->query("SELECT COUNT(*) as y FROM tblorders WHERE user_id='".$user_id."' AND created_at > '".$date."'");
		$data_arr = $get_data->result_array();
		foreach ($data_arr as $key => $value) {
            if($value['y'] > 0 )
            $data['last_30_day_orders'] =  '<span class="label label-success">'.$value['y'].'</span>';
        }
		
		$get_data = $this->db->query("SELECT COUNT(*) as y FROM tblorders WHERE user_id='".$user_id."' ");
		$data_arr = $get_data->result_array();
		foreach ($data_arr as $key => $value) {
            if($value['y'] > 0 )
            $data['total_orders'] =  '<span class="label label-success">'.$value['y'].'</span>'; 
        }
		
		
		$get_data = $this->db->query("SELECT * FROM tblorders WHERE user_id='".$user_id."' ORDER BY id DESC LIMIT 1 ");
		$data_arr = $get_data->result_array();
		foreach ($data_arr as $key => $value) {
            if($value['created_at'] > 0 )
            $data['last_order'] =  date( 'F j, Y' ,$value['created_at']); 
        }
		
		
		$get_data = $this->db->query("SELECT restaurant_id,COUNT(*) as y FROM tblorders WHERE user_id='".$user_id."' GROUP BY restaurant_id ORDER BY y DESC          LIMIT 1");

        $data_arr = $get_data->result_array();
        foreach ($data_arr as $key => $value) {
            
            $this->db->where('dryvarfoods_id', $value['restaurant_id']);
            $get_user = $this->db->get(db_prefix(). 'clients');
            $user_arr =  $get_user->row_array();
            $data['prefered'] =  '<span class="label label-success">'.$user_arr['company'].'</span>';
        }
			
		return $data;
	}
	
	public function get_area_order_stats(){

        $get_data = $this->db->query("SELECT city,COUNT(*) AS y FROM tblorders GROUP BY city");
        $data_arr = $get_data->result_array();

        $data = array();
        foreach ($data_arr as $key => $value) {
            
            $data[] = array($value['city'],intval($value['y']),false);
        }

        return $data; 
	}
	
	public function get_area_order_stats_manual(){

        $get_data = $this->db->query("SELECT city,COUNT(*) AS y FROM tblorders where order_type = 'manual' GROUP BY city");
        $data_arr = $get_data->result_array();

        $data = array();
        foreach ($data_arr as $key => $value) {
            
            $data[] = array($value['city'],intval($value['y']),false);
        }

        return $data; 
		
	}

    
    public function get_orders_timeline($contact){

        $this->db->where('user_id', $contact);
        $this->db->order_by('id', 'DESC'); 
        $get_data = $this->db->get(db_prefix(). 'orders');
        $data_arr = $get_data->result_array();

        $data = array();
        foreach ($data_arr as $key => $value) {
            
            $this->db->where('dryvarfoods_id', $value['restaurant_id']);
            $get_user = $this->db->get(db_prefix(). 'clients');
            $user_arr =  $get_user->row_array();
           
            $data[$key]['x']      = date('Y,m,d', $value['created_at']);
            $data[$key]['name']   =  $user_arr['company'];
            $data[$key]['label']  =  $user_arr['company'];
            $data[$key]['id']     =  $value['dryvarfoods_id'];
        }

        return $data;

    }
	
	public function get_customer($data=array()){
        
            extract($data);
            $this->db->where('dryvarfoods_id', $customer_id);
            $get_data = $this->db->get(db_prefix(). 'contacts');

            $data_arr = $get_data->row_array();

            $this->db->where('user_id', $customer_id);
            $this->db->where('total_amount  >', '0');
			if(isset($from_date) && $from_date!="" && isset($to_date) && $to_date!=""){
				$date_from = strtotime($from_date.' 00:00:00');
				if($to_date!=""){
				  $date_to = strtotime($to_date.' 23:59:00');
				}
				else{
					$date_to = strtotime($from_date.' 23:59:00');
				}
					
				$this->db->where('created_at >=', $date_from);
				$this->db->where('created_at <=', $date_to);
				
			}

            $get_orders = $this->db->get(db_prefix(). 'orders');
            $order_arr = $get_orders->result_array();

            $data_arr['total_orders'] = count($order_arr);

            $this->db->select_sum('total_amount');
            $this->db->where('user_id', $customer_id);
            $this->db->where('total_amount  >', '0');
			if(isset($from_date) && $from_date!="" && isset($to_date) && $to_date!=""){
				$date_from = strtotime($from_date.' 00:00:00');
				if($to_date!=""){
				  $date_to = strtotime($to_date.' 23:59:00');
				}
				else{
					$date_to = strtotime($from_date.' 23:59:00');
				}
					
				$this->db->where('created_at >=', $date_from);
				$this->db->where('created_at <=', $date_to);
				
			}

            $get_orders = $this->db->get(db_prefix(). 'orders');
            $order_arr = $get_orders->row_array();

            $data_arr['total_amount'] = (float) $order_arr['total_amount'];


            $this->db->where('user_id', $customer_id);
            $this->db->where('total_amount  >', '0');
            $this->db->where('completed_at  >', '0');
            $this->db->order_by('id', 'DESC');
			if(isset($from_date) && $from_date!="" && isset($to_date) && $to_date!=""){
				$date_from = strtotime($from_date.' 00:00:00');
				if($to_date!=""){
				  $date_to = strtotime($to_date.' 23:59:00');
				}
				else{
					$date_to = strtotime($from_date.' 23:59:00');
				}
					
				$this->db->where('created_at >=', $date_from);
				$this->db->where('created_at <=', $date_to);
				
			}

            $get_orders = $this->db->get(db_prefix(). 'orders');
            $order_arr = $get_orders->result_array();
            if(count($order_arr)){

                $data_arr['last_order'] = '<small style="color:#23ad00;">Last Purchase On '.date('F j, Y', $order_arr[0]['created_at']).'</small>';
            }else{
                $data_arr['last_order'] = '<small style="color:red;">Never Purchased</small>';
            }

            $this->db->where('user_id', $customer_id);
            $this->db->where('total_amount  >', '0');
			if(isset($from_date) && $from_date!="" && isset($to_date) && $to_date!=""){
				$date_from = strtotime($from_date.' 00:00:00');
				if($to_date!=""){
				  $date_to = strtotime($to_date.' 23:59:00');
				}
				else{
					$date_to = strtotime($from_date.' 23:59:00');
				}
					
				$this->db->where('created_at >=', $date_from);
				$this->db->where('created_at <=', $date_to);
				
			}

            $get_orders = $this->db->get(db_prefix(). 'orders');
            $order_arr = $get_orders->result_array();

            $data_arr['total_orders'] = count($order_arr);
            
            
            return $data_arr; 
            
            
             //echo "<pre>";  print_r($data_arr); exit;
      
    
        
    }

    public function get_all_cities(){
        
    
        $get_data = $this->db->get(db_prefix(). 'cities');

        $data_arr = $get_data->result_array();
        
        
        return $data_arr;
        
    }

    public function get_all_restuarants(){
        
    
        $get_data = $this->db->get(db_prefix(). 'clients');

        $data_arr = $get_data->result_array();
        
        
        return $data_arr;
        
    }

    public function customer_dashboard_stats($data){

        extract($data);

        $data_arr = array();
        //orders
        $this->db->where('total_amount  >', '0');
        if($city != ''){

            $this->db->where('city',$city);
        }

        $get_orders = $this->db->get(db_prefix(). 'orders');
        $order_arr = $get_orders->result_array();

        $data_arr['total_orders'] = count($order_arr);

        $this->db->select_sum('total_amount');
        $this->db->where('total_amount  >', '0');
        if($city != ''){

            $this->db->where('city',$city);
        }

        $get_orders = $this->db->get(db_prefix(). 'orders');
        $order_arr = $get_orders->row_array();

        $data_arr['total_amount'] = $order_arr['total_amount'];
		
		
		
		//Pending
		$this->db->select_sum('total_amount');
        $this->db->where('total_amount  >', '0');
		if($city != ''){

            $this->db->where('city',$city);
        }
		
		$this->db->where('declined_at', 0);
		$this->db->where('completed_at', 0);
		$this->db->where('cancelled_at', 0);
		$this->db->where('delivery_at', 0);
		
		
        $get_orders = $this->db->get(db_prefix(). 'orders');
        $order_arr = $get_orders->row_array();
        $data_arr['total_amount_p'] = $order_arr['total_amount'];
		
		
		//Completed
		$this->db->select_sum('total_amount');
        if($city != ''){

            $this->db->where('city',$city);
        }
        $this->db->where('total_amount  >', '0');
        $this->db->where('completed_at >', 0);
        $get_orders = $this->db->get(db_prefix(). 'orders');
        $order_arrc = $get_orders->row_array();
        $data_arr['total_amount_c'] = $order_arrc['total_amount'];
		
		//Declined
		$this->db->select_sum('total_amount');
        if($city != ''){

            $this->db->where('city',$city);
        }
        $this->db->where('total_amount  >', '0');
        $this->db->where('declined_at >', 0);
        $get_orders = $this->db->get(db_prefix(). 'orders');
        $order_arrd = $get_orders->row_array();
        $data_arr['total_amount_d'] = $order_arr['total_amount'];
		
		
		

        $data_arr['average_amount'] = round($data_arr['total_amount']/$data_arr['total_orders'],2);

        $this->db->where('type', '0');
        if($city != ''){

            $this->db->where('city',$city);
        }
        $get_orders = $this->db->get(db_prefix(). 'contacts');
        $order_arr = $get_orders->result_array();

        $data_arr['total_customers'] = count($order_arr);

        $this->db->where('type', '0');
        $this->db->where('active', '1');
        if($city != ''){

            $this->db->where('city',$city);
        }
        $get_orders = $this->db->get(db_prefix(). 'contacts');
        $order_arr = $get_orders->result_array();

        $data_arr['active_customers'] = count($order_arr);

        $this->db->where('type', '0');
        $this->db->where('active', '0');
        if($city != ''){

            $this->db->where('city',$city);
        }
        $get_orders = $this->db->get(db_prefix(). 'contacts');
        $order_arr = $get_orders->result_array();

        $data_arr['inactive_customers'] = count($order_arr);

        return $data_arr;

    }

    public function new_signups(){

        $date = date('Y-m-d H:i:s',strtotime('-10 days'));
        $this->db->where('datecreated >', $date);
        $this->db->where('active', '1');
        if($city != ''){

            $this->db->where('city',$city);
        }
        $get_data = $this->db->get(db_prefix(). 'contacts');
        $data_arr = $get_data->result_array();

        return $data_arr;

    }

    public function revenue_graph(){

        $query = $this->db->query("SELECT UNIX_TIMESTAMP( DATE_FORMAT(FROM_UNIXTIME(`created_at`), '%Y-%c-%e 00:00:00')) AS 'date_formatted',SUM(total_amount) as amount FROM tblorders WHERE total_amount > '0' GROUP BY date_formatted ORDER BY date_formatted ");

        $data_arr = $query->result_array();
        $data = array();
        foreach ($data_arr as $key => $value) {
            
            $data[$key][] = intval($value['date_formatted'].'000');
            $data[$key][] = intval($value['amount']);
        }

        return $data;

    }

    public function incoming_customers(){

        
        $data = array();
        for ($i=1; $i < 12; $i++) { 
            if($i < 10){ $index = intval('0'.$i);}else{ $index = $i;}
            $year = intval( date('Y') );
            $d=cal_days_in_month(CAL_GREGORIAN,$i,$year);

            $s_date = date("Y-".$index.'-1 00:00:00');
            $e_date = date("Y-".$index.'-'.$d.' 23:59:00');

            $get_data = $this->db->query("SELECT  count(*) as count FROM tblcontacts  WHERE type=0 AND datecreated > '".$s_date."' AND datecreated < '".$e_date."' ");
            $data_arr = $get_data->row_array();

            $data['new_signups'][] = intval($data_arr['count']);

            $new_signups = intval($data_arr['count']);
            $get_data = $this->db->query("SELECT DISTINCT  count(tblcontacts.id) as count 
                FROM tblcontacts LEFT JOIN tblorders 
                ON tblcontacts.dryvarfoods_id = tblorders.user_id   
                WHERE tblcontacts.type=0 AND tblcontacts.datecreated > '".$s_date."' AND tblcontacts.datecreated < '".$e_date."' AND tblorders.user_id IS NULL  ");
            $data_arr = $get_data->row_array();

            $data['never_purchased'][] = intval($data_arr['count']);


            $data['purchased'][] = $new_signups - intval($data_arr['count']);

        }

        return $data;
        

    }

    public function order_status_graph($postdata){

        extract($postdata);
        $data = array();
		if(isset($year) && $year!=""){
			$years = array($year);
			$no_of_years = 1;
		}
		else{
		$years = array(2020, 2021);
		$no_of_years = 2;
		}
		for($j=0;$j<$no_of_years;$j++){
        for ($i=1; $i < 13; $i++) { 
            if($i < 10){ $index = intval('0'.$i);}else{ $index = $i;}
            $year = intval( $years[$j] );
            $d=cal_days_in_month(CAL_GREGORIAN,$i,$year);

            $s_date = date($year."-".$index.'-1 00:00:00');
            $e_date = date($year."-".$index.'-'.$d.' 23:59:00');


           /* $this->db->where('declined_at >', 0);*/
            $this->db->where('created_at >=', strtotime($s_date));
            $this->db->where('created_at <=', strtotime($e_date));
			$this->db->where('status', 2);
            $this->db->where('total_amount  >', '0');
            if ($client != '') {
                $this->db->where('restaurant_id', $client);
            }

            if ($city != '') {
                $this->db->where('city', $city);
            }
            $get_data = $this->db->get(db_prefix(). 'orders');
            $data_arr = $get_data->result_array();
            $data['declined'][] = count($data_arr);

            /*$this->db->where('completed_at >', 0);*/
            $this->db->where('created_at >=', strtotime($s_date));
            $this->db->where('created_at <=', strtotime($e_date));
			$this->db->where('status', 6);
			
            $this->db->where('total_amount  >', '0');
            if ($client != '') {
                $this->db->where('restaurant_id', $client);
            }

            if ($city != '') {
                $this->db->where('city', $city);
            }
            $get_data = $this->db->get(db_prefix(). 'orders');
            $data_arr = $get_data->result_array();
            $data['completed'][] = count($data_arr);

            
            // Order type 
            //$this->db->where('order_type', 'manual');
           /* $this->db->where('declined_at', 0);
            $this->db->where('completed_at', 0);
            $this->db->where('cancelled_at', 0);
            $this->db->where('delivery_at', 0);*/
            $this->db->where('created_at >=', strtotime($s_date));
            $this->db->where('created_at <=', strtotime($e_date));
			$this->db->where('status', 0);
			
			
            $this->db->where('total_amount  >', '0');
            if ($client != '') {
                $this->db->where('restaurant_id', $client);
            }

            if ($city != '') {
                $this->db->where('city', $city);
            }
            $get_data = $this->db->get(db_prefix(). 'orders');
            $data_arr = $get_data->result_array();

            $data['pending'][] = count($data_arr);
			
			
            $this->db->where('datecreated >=', $s_date);
            $this->db->where('datecreated <=', $e_date);
            $this->db->where('type =', '0');
            $get_data = $this->db->get(db_prefix(). 'contacts');
            $data_arr = $get_data->result_array();

            $data['users'][] = count($data_arr);

        }

        }
		
		return $data;
        

    }
	
	
	 public function order_status_graph_manual($postdata){

        extract($postdata);
        $data = array();
        for ($i=1; $i < 12; $i++) { 
            if($i < 10){ $index = intval('0'.$i);}else{ $index = $i;}
            $year = intval( date('Y') );
            $d=cal_days_in_month(CAL_GREGORIAN,$i,$year);

            $s_date = date("Y-".$index.'-1 00:00:00');
            $e_date = date("Y-".$index.'-'.$d.' 23:59:00');

            // Order type 
            $this->db->where('order_type', 'manual');
            $this->db->where('declined_at >', 0);
            $this->db->where('created_at >=', strtotime($s_date));
            $this->db->where('created_at <=', strtotime($e_date));
            $this->db->where('total_amount  >', '0');
            if ($client != '') {
                $this->db->where('restaurant_id', $client);
            }

            if ($city != '') {
                $this->db->where('city', $city);
            }
            $get_data = $this->db->get(db_prefix(). 'orders');
            $data_arr = $get_data->result_array();
            $data['declined'][] = count($data_arr);

            
            // Order type 
            $this->db->where('order_type', 'manual');
            $this->db->where('completed_at >', 0);
            $this->db->where('created_at >=', strtotime($s_date));
            $this->db->where('created_at <=', strtotime($e_date));
            $this->db->where('total_amount  >', '0');
            if ($client != '') {
                $this->db->where('restaurant_id', $client);
            }

            if ($city != '') {
                $this->db->where('city', $city);
            }
            $get_data = $this->db->get(db_prefix(). 'orders');
            $data_arr = $get_data->result_array();
            $data['completed'][] = count($data_arr);

            
            // Order type 
            $this->db->where('order_type', 'manual');
            $this->db->where('declined_at', 0);
            $this->db->where('completed_at', 0);
            $this->db->where('cancelled_at', 0);
            $this->db->where('delivery_at', 0);
            $this->db->where('created_at >=', strtotime($s_date));
            $this->db->where('created_at <=', strtotime($e_date));
            $this->db->where('total_amount  >', '0');
            if ($client != '') {
                $this->db->where('restaurant_id', $client);
            }

            if ($city != '') {
                $this->db->where('city', $city);
            }
            $get_data = $this->db->get(db_prefix(). 'orders');
            $data_arr = $get_data->result_array();

            $data['pending'][] = count($data_arr);
            $this->db->where('datecreated >=', $s_date);
            $this->db->where('datecreated <=', $e_date);
            $this->db->where('type =', '0');
            $get_data = $this->db->get(db_prefix(). 'contacts');
            $data_arr = $get_data->result_array();

            $data['users'][] = count($data_arr);

        }

        return $data;
        

    }

    public function commission(){
		
		

		$d2 = strtotime('last monday', strtotime('tomorrow'));
		$d1 = $d2 - 604800;
        $start_week = date("Y-m-d",$d1);
        $end_week = date("Y-m-d",$d2);
        
				
		$get_data = $this->db->query("Select user_id,name,SUM(amount) as total_revenue, count(id) as total_orders from tblpayout 
		WHERE created_at >= '$start_week' AND created_at <= '$end_week' AND amount > 0  group by user_id,name");
		$data_arr = $get_data->result_array();
		
		
		
		
		
		/*foreach($data_arr as $key => $value){
			
			    $this->db->where('dryvarfoods_id', $value['driver_id']);
                $get_user = $this->db->get(db_prefix(). 'contacts');
                $user_arr =  $get_user->row_array();
                
                $data_arr[$key]['driver_name'] = $user_arr['firstname'].' '.$user_arr['lastname'];
		}*/
		
		return $data_arr;
	}
	
	public function weekly_payout($name){
		
		$previous_week = strtotime("-1 week +1 day");
		$start_week = strtotime("last sunday midnight",$previous_week);
		$end_week = strtotime("next saturday",$start_week);
		
		$start_week = date("Y-m-d",$start_week);
		$end_week = date("Y-m-d",$end_week);
		
		//$sql  = "Select * from tblpayout WHERE name = '$name'";
		
	
		$name =  urldecode($name);
	
		$get_data = $this->db->query("Select * from tblpayout WHERE name ='$name'");
		$data_arr = $get_data->result_array();
		
		
		
		return $data_arr;
	}

    public function sales_commission($data = array()){
        
        extract($data);
        if($restaurant_id != '' ){
            $this->db->where('dryvarfoods_id', $restaurant_id );
        }
        if($city != '' ){
            $this->db->where('city', $city );
        }
        $get_merchant = $this->db->get('tblclients');
        $merchants_arr = $get_merchant->result_array();

        foreach ($merchants_arr as $key => $merchant) {
            
            $date_filter = '';
            if($date_from != '' && $date_too !=''){

                $d1 = strtotime($date_from.' 00:00:00');
                $d2 = strtotime($date_too.' 23:59:00');
                $date_filter = " AND created_at >= '".$d1."' ";
                $date_filter .= " AND created_at <= '".$d2."' ";

            }else if($date_from != '' && $date_too ==''){

                $d1 = strtotime($date_from.' 00:00:00');
                $d2 = strtotime($date_from.' 23:59:00');
                $date_filter = " AND created_at >= '".$d1."' ";
                $date_filter .= " AND created_at <= '".$d2."' ";

            }else if($date_from == '' && $date_too !=''){

                $d1 = strtotime($date_too.' 00:00:00');
                $d2 = strtotime($date_too.' 23:59:00');
                $date_filter = " AND created_at >= '".$d1."' ";
                $date_filter .= " AND created_at <= '".$d2."' ";

            }

            $get_data = $this->db->query("SELECT SUM(total_amount) as total_sales, COUNT(id) as total_orders,restaurant_id from tblorders where restaurant_id='".$merchant['dryvarfoods_id']."' AND completed_at > 0 AND total_amount > 0 ".$date_filter." ");
            $data_arr = $get_data->row_array();

            $merchants_arr[$key]['sales_data'] = $data_arr;

        }

        
        return $merchants_arr;
    }

    public function top_10_menu_items($data){

        extract($data);
        $where = "";
        if($client !=''){

            $where = " AND tblorders.restaurant_id='".$client."' ";
        }
        if($city !=''){

            $where .= " AND tblorders.city='".$city."' ";
        }
        $query = $this->db->query("SELECT tblorder_item.menu_item_id,SUM(tblorder_item.quantity) as quantity,SUM(tblorder_item.price) as price FROM tblorder_item LEFT JOIN tblorders ON tblorder_item.order_id = tblorders.dryvarfoods_id where 1=1 ".$where." GROUP BY tblorder_item.menu_item_id ORDER BY quantity desc LIMIT 10");
        $data_arr = $query->result_array();

        foreach ($data_arr as $key => $value) {
            
            $get_menu = $this->db->query("SELECT * FROM tblmenu_item  where id='".$value['menu_item_id']."'  ");
            $menu_arr = $get_menu->row_array();
            $data_arr[$key]['item_name'] = $menu_arr['name'];
        }
        
        return $data_arr;

    }

    public function top_10_customers($data){

        extract($data);
        $where = "";
        if($client !=''){

            $where = " AND tblorders.restaurant_id='".$client."' ";
        }
        if($city !=''){

            $where .= " AND tblorders.city='".$city."' ";
        }
        $query = $this->db->query("SELECT user_id,SUM(total_amount) as total_amount,COUNT(id) as count FROM tblorders  where total_amount > 0  ".$where." GROUP BY user_id ORDER BY count desc LIMIT 10");
        $data_arr = $query->result_array();

        foreach ($data_arr as $key => $value) {
            
            $get_menu = $this->db->query("SELECT * FROM tblcontacts  where dryvarfoods_id='".$value['user_id']."'  ");
            $menu_arr = $get_menu->row_array();
            $data_arr[$key]['customer_name'] = $menu_arr['firstname'];
            $data_arr[$key]['customer_email'] = $menu_arr['email'];
            $data_arr[$key]['customer_phone'] = $menu_arr['phonenumber'];
        }
        
        return $data_arr;

    }

    public function last_10_sales($data){

        extract($data);
        $where = "";
        if($client !=''){

            $where = " AND restaurant_id='".$client."' ";
        }
        if($city !=''){

            $where .= " AND city='".$city."' ";
        }
        $query = $this->db->query("SELECT DATE_FORMAT(FROM_UNIXTIME(`created_at`), '%Y-%m-%d') as date,SUM(total_amount) as total_amount,COUNT(id) as count FROM tblorders where total_amount > 0 ".$where." GROUP BY date ORDER BY date desc LIMIT 10");
        $data_arr = $query->result_array();

       
        
        return $data_arr;

    }

    public function get_merchant($id){

        $this->db->where('dryvarfoods_id',$id);

        $query = $this->db->get("tblclients");
        $data_arr = $query->row_array();

        $this->db->where('dryvarfoods_id',$data_arr['user_dryvar_id']);

        $query = $this->db->get("tblcontacts");
        $user = $query->row_array();

        if($data_arr['phonenumber'] == '')
        $data_arr['phonenumber'] = $user['phonenumber'];

        $data_arr['email'] = $user['email'];

        return $data_arr;

    }
	
	public function count_notifications_statuses($notification_current_status,$data=array())
    {   
        $this->db->set_dbprefix('');
        extract($data);
		if($date_from != '' && $date_too !=''){

            $this->db->where('date >=', $date_from);
            $this->db->where('date <=', $date_too);

        }else if($date_from != '' && $date_too ==''){

            $this->db->where('date >=', $date_from);
            $this->db->where('date <=', $date_from);

        }else if($date_from == '' && $date_too !=''){

            $this->db->where('date >=', $date_too);
            $this->db->where('date <=', $date_too);

        }

        if($notification_current_status != ""){

            $this->db->where('status', $notification_current_status);

        }
 
        if ($month != '') {
            $date1 = date('Y').'-'.$month.'-01';
            $d=cal_days_in_month(CAL_GREGORIAN,$month,date('Y'));
            if($d < 10 ){$d = '0'.$d;}
            $date2 = date('Y').'-'.$month.'-'.$d;
            
            $this->db->where('date >=', $date1);
            $this->db->where('date <=', $date2);
            
        }
        if ($message_type != '') {
            $this->db->where('message_type', $message_type);
        }
        if ($notification_type != '') {
            $this->db->where('notification_type', $notification_type);
        }

        $get_data = $this->db->get('notifications');
		
        $data_arr = $get_data->result_array();
		
		$sql = $this->db->last_query();
	
        return count($data_arr);
    }
	
	public function get_notifications($data=array(),$start,$limit)
    {   
        $this->db->set_dbprefix('');
        extract($data);
        if($date_from != '' && $date_too !=''){

            $this->db->where('date >=', $date_from);
            $this->db->where('date <=', $date_too);

        }else if($date_from != '' && $date_too ==''){

            $this->db->where('date >=', $date_from);
            $this->db->where('date <=', $date_from);

        }else if($date_from == '' && $date_too !=''){

            $this->db->where('date >=', $date_too);
            $this->db->where('date <=', $date_too);

        }

        if($notification_status != ""){

            $this->db->where('status', $notification_status);

        }
 
        if ($month != '') {
            $date1 = date('Y').'-'.$month.'-01';
            $d=cal_days_in_month(CAL_GREGORIAN,$month,date('Y'));
            if($d < 10 ){$d = '0'.$d;}
            $date2 = date('Y').'-'.$month.'-'.$d;
            
            $this->db->where('date >=', $date1);
            $this->db->where('date <=', $date2);
            
        }
        if ($message_type != '') {
            $this->db->where('message_type', $message_type);
        }
        if ($notification_type != '') {
            $this->db->where('notification_type', $notification_type);
        }
        $this->db->offset($start);
        $this->db->limit($limit);

        if($orderby !=''){
            $this->db->order_by('id', $orderby);
        }else{
          $this->db->order_by('id', 'DESC'); 
        }
        
        $get_data = $this->db->get('notifications');

        $data_arr = $get_data->result_array();

        return $data_arr;
    }
	
	public function count_notifications($notification_status='',$data=array())
    {   
	    $this->db->set_dbprefix('');
        extract($data);
        if($date_from != '' && $date_too !=''){

            $this->db->where('date >=', $date_from);
            $this->db->where('date <=', $date_too);

        }else if($date_from != '' && $date_too ==''){

            $this->db->where('date >=', $date_from);
            $this->db->where('date <=', $date_from);

        }else if($date_from == '' && $date_too !=''){

            $this->db->where('date >=', $date_too);
            $this->db->where('date <=', $date_too);

        }

        if($notification_status != ""){

            $this->db->where('status', $notification_status);

        }
 
        if ($month != '') {
            $date1 = date('Y').'-'.$month.'-01';
            $d=cal_days_in_month(CAL_GREGORIAN,$month,date('Y'));
            if($d < 10 ){$d = '0'.$d;}
            $date2 = date('Y').'-'.$month.'-'.$d;
            
            $this->db->where('date >=', $date1);
            $this->db->where('date <=', $date2);
            
        }
        if ($message_type != '') {
            $this->db->where('message_type', $message_type);
        }
        if ($notification_type != '') {
            $this->db->where('notification_type', $notification_type);
        }

        $get_data = $this->db->get('notifications');
        $data_arr = $get_data->result_array();
        return count($data_arr);
    }
	
	public function get_notification_detail($notification_id)
    {   
	    $this->db->set_dbprefix('');
        $this->db->where('id',$notification_id);
        $get_data = $this->db->get('notifications');

        $notification_arr = $get_data->row_array();
		
        return $notification_arr;
    }
	
	public function get_notifications_csv($data=array())
    {   
        
		$this->db->set_dbprefix('');
        extract($data);

        $this->db->order_by('id', 'DESC');
        $get_data = $this->db->get('notifications');

        $data_arr = $get_data->result_array();

        $return_arr = array();
        foreach ($data_arr as $key => $value) {
            
            $return_arr[$key]['id'] = $value['id'];
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
		    $image = base_url().'assets/uploads/'.$value['image_url'];
		}
		
		$newstatus ="";
		
		if($value['status']==0){ 
			 $newstatus = 'Pending';
			 
		  }else if($value['status']==2){ 
			 $newstatus = 'Completed';
			 
		  }else if($value['status']==1){ 
			 $newstatus = 'In Progress';
			 
		  }
			$return_arr[$key]['message_type'] = $message_type;
			$return_arr[$key]['notification_type'] = $notification_type;
            $return_arr[$key]['notification_type'] = $notification_type;
			$return_arr[$key]['to'] = $to_type;
			$return_arr[$key]['user/city'] = $name;
			$return_arr[$key]['user_type'] = ucfirst($value['user_type']);
			$return_arr[$key]['image'] = $image;
			$return_arr[$key]['title'] = $value['title'];
			$return_arr[$key]['message'] = $value['message'];
			$return_arr[$key]['status'] = $newstatus;
			$return_arr[$key]['schedule_at'] = date("d-m-Y h:i A", strtotime($value['date']." ".$value['hours'].":".$value['minutes']));
        }
        return $return_arr;
    }
    // get orders ajax 
	public function orders_report_ajax($data=array()){
		extract($data);
		$this->db->select("city, count(*) as no_of_orders, SUM(total_amount) as total_sales, SUM(restaurant_commision_fee) as total_comission_earned, SUM(booking_fee) as total_booking_fee, SUM(delivery_fee) as total_delivery_fee, SUM(tips_amount) as total_tips_paid");
		$this->db->where("status", 6);
		
		if($from_date!="" || $to_date!=""){
		$date_from = strtotime($from_date.' 00:00:00');
		if($to_date!=""){
          $date_to = strtotime($to_date.' 23:59:00');
		}
		else{
			$date_to = strtotime($from_date.' 23:59:00');
		}
			
		$this->db->where('created_at >=', $date_from);
        $this->db->where('created_at <=', $date_to);
		
		}
		if($city!=""){
			if($city!="all"){
			$this->db->where('city', $city);
			}
		}
		$this->db->group_by("city");
		$get_data = $this->db->get(db_prefix(). 'orders');
		//echo $this->db->last_query();
		$data_arr = $get_data->result_array(); 
		return $data_arr;
	}
	
	
   
   
    //Add new Users
	public function edit_customwer($data){
		
		extract($data);
		
		$created_date = date('Y-m-d G:i:s');
		$created_by_ip = $this->input->ip_address();
		$created_by = $this->session->userdata('id');
		$signup_date = date('Y-m-d');
		
		
		//Record insert into database
		$updatet_arr = array(
		   'firstname' => $this->db->escape_str(trim($first_name)),
		   'lastname' => $this->db->escape_str(trim($last_name)),
		   'company' => $this->db->escape_str(trim($company)),
		   'phonenumber' => $this->db->escape_str(trim($phone_number)),
		   'address' => $this->db->escape_str(trim($address)),
		   'email' => $this->db->escape_str(trim($email)),
		   'user_status' => $this->db->escape_str(1),
		   'state' => $this->db->escape_str(trim($state)),
		   'city' => $this->db->escape_str(trim($city)),
		   //'country' => $this->db->escape_str(trim($country)),
		   'zip' => $this->db->escape_str(trim($zip)),
		   //'created_by' => $this->db->escape_str(trim($created_by)),
		   'datecreated' => $this->db->escape_str(trim($created_date)),
		   //'created_by_ip' => $this->db->escape_str(trim($created_by_ip)),
		   'type' => $this->db->escape_str(trim(10))// MEan general customer
		);
		$this->db->dbprefix('contacts');
		$this->db->where('id', $custoemr_id);
                $update =  $this->db->update('contacts', $updatet_arr);
				
				
				
        $sql = $this->db->last_query();
        
				
		
		
		if($update){
			return true ;
		}//end if
		
		else{
			return false;
		}//end else
		
	}//end edit_customer
   
    
    //Add new Users
	public function contact_process($data){
		
		extract($data);
		
		$created_date = date('Y-m-d G:i:s');
		$created_by_ip = $this->input->ip_address();
		$created_by = $this->session->userdata('id');
		$signup_date = date('Y-m-d');
		
		
		//Record insert into database
		$ins_data = array(
		   'firstname' => $this->db->escape_str(trim($first_name)),
		   'lastname' => $this->db->escape_str(trim($last_name)),
		   'company' => $this->db->escape_str(trim($company)),
		   'phonenumber' => $this->db->escape_str(trim($phone_number)),
		   'address' => $this->db->escape_str(trim($address)),
		   'email' => $this->db->escape_str(trim($email)),
		   'user_status' => $this->db->escape_str(1),
		   'state' => $this->db->escape_str(trim($state)),
		   'city' => $this->db->escape_str(trim($city)),
		   //'country' => $this->db->escape_str(trim($country)),
		   'zip' => $this->db->escape_str(trim($zip)),
		   //'created_by' => $this->db->escape_str(trim($created_by)),
		   'datecreated' => $this->db->escape_str(trim($created_date)),
		   //'created_by_ip' => $this->db->escape_str(trim($created_by_ip)),
		   'type' => $this->db->escape_str(trim(10))// MEan general customer
		);
		
		$this->db->dbprefix('contacts');
		$ins_into_db = $this->db->insert('contacts', $ins_data);
		$new_user_id = $this->db->insert_id();

$sql = $this->db->last_query();


	    	
		if($ins_into_db){
			return $new_user_id ;
		}//end if
		
		else{
			return false;
		}//end else
		
	}//end contact_process
	
	public function count_clients($data=array())
    {   
        extract($data);
		
		if ($firstname != '') {

            $this->db->like('firstname', $firstname, 'after');
        }
		if ($email != '') {

            $this->db->like('email', $email, 'after');
        }
		
		if ($phonenumber != '') {

            $this->db->like('phonenumber', $phonenumber, 'after');
        }
     
        if ($city != '') {

            $this->db->like('city', $city, 'after');
        }
		
		if($date_from != '' && $date_too !=''){

            $this->db->where('email_verified_at >=', $date_from.' 00:00:00');
            $this->db->where('email_verified_at <=', $date_too.' 23:59:00');

        }else if($date_from != '' && $date_too ==''){

            $this->db->where('email_verified_at >=', $date_from.' 00:00:00');
            $this->db->where('email_verified_at <=', $date_from.' 23:59:00');

        }else if($date_from == '' && $date_too !=''){

            $this->db->where('email_verified_at >=', $date_too.' 00:00:00');
            $this->db->where('email_verified_at <=', $date_too.' 23:59:00');

        }

        if ($month != '') {
            $date1 = date('Y').'-'.$month.'-01';
            $d=cal_days_in_month(CAL_GREGORIAN,$month,date('Y'));
            if($d < 10 ){$d = '0'.$d;}
            $date2 = date('Y').'-'.$month.'-'.$d;
            
            $this->db->where('email_verified_at >=', $date1);
            $this->db->where('email_verified_at <=', $date2);
            
        }
		
		$this->db->where('type', 0);

        if($orderby !=''){
            $this->db->order_by('id', $orderby);
        }else{
          $this->db->order_by('id', 'DESC'); 
        }
		
        $get_data = $this->db->get(db_prefix(). 'contacts');

        $data_arr = $get_data->num_rows();
        return $data_arr;	
    }
	
	public function get_clients($data=array(),$start,$limit)
    {   
        
        extract($data);
		
		if ($firstname != '') {

            $this->db->like('firstname', $firstname, 'after');
        }
		
		if ($email != '') {

            $this->db->like('email', $email, 'after');
        }
		
		if ($phonenumber != '') {

            $this->db->like('phonenumber', $phonenumber, 'after');
        }
     
        if ($city != '') {

            $this->db->like('city', $city, 'after');
        }
		
		if($date_from != '' && $date_too !=''){

            $this->db->where('email_verified_at >=', $date_from.' 00:00:00');
            $this->db->where('email_verified_at <=', $date_too.' 23:59:00');

        }else if($date_from != '' && $date_too ==''){

            $this->db->where('email_verified_at >=', $date_from.' 00:00:00');
            $this->db->where('email_verified_at <=', $date_from.' 23:59:00');

        }else if($date_from == '' && $date_too !=''){

            $this->db->where('email_verified_at >=', $date_too.' 00:00:00');
            $this->db->where('email_verified_at <=', $date_too.' 23:59:00');

        }

        if ($month != '') {
            $date1 = date('Y').'-'.$month.'-01';
            $d=cal_days_in_month(CAL_GREGORIAN,$month,date('Y'));
            if($d < 10 ){$d = '0'.$d;}
            $date2 = date('Y').'-'.$month.'-'.$d;
            
            $this->db->where('email_verified_at >=', $date1);
            $this->db->where('email_verified_at <=', $date2);
            
        }
		
        $this->db->where("type", 0);
        $this->db->offset($start);
        $this->db->limit($limit);

        if($orderby !=''){
            $this->db->order_by('id', $orderby);
        }else{
          $this->db->order_by('id', 'DESC'); 
        }
        
        $get_data = $this->db->get(db_prefix(). 'contacts');
		

        $data_arr = $get_data->result_array();

        $return_arr = array();
        foreach ($data_arr as $key => $value) {
			$return_arr[$key]['dryvarfoods_id']   = $value['dryvarfoods_id'];
            $return_arr[$key]['firstname']   = $value['firstname'];
			$return_arr[$key]['email']       = $value['email'];
			$return_arr[$key]['phonenumber'] = $value['phonenumber'];
            $return_arr[$key]['city']        = $value['city'];
			$return_arr[$key]['email_verified_at']   = $value['email_verified_at'];
			
            //Last Order
            $this->db->where('user_id', $value['dryvarfoods_id']);
			$this->db->offset(0);
            $this->db->limit(1);
			$this->db->order_by('id', 'DESC'); 
            $get_order = $this->db->get(db_prefix(). 'orders');
            $order_arr =  $get_order->row_array();
            
            $return_arr[$key]['last_order'] = $order_arr['dryvarfoods_id'];

            // Total Orders
            $this->db->where('user_id', $value['dryvarfoods_id']); 
            $get_order = $this->db->get(db_prefix(). 'orders');
            $total_orders =  $get_order->num_rows();
            
            $return_arr[$key]['total_orders'] = $total_orders;
			
			//Orders last 30 days
			
			$query = $this->db->query("SELECT count(*) as total FROM tblorders WHERE created_at < DATE_ADD(NOW(), INTERVAL -1 MONTH) AND user_id=".$value['dryvarfoods_id']);
			$order_arr =  $query->row_array();
			$return_arr[$key]['orders_last_30_days'] = $order_arr["total"];
		}
			

        return $return_arr;
    }
	
	public function get_referrals_csv($data=array())
    {   
 
        extract($data);
		
		if ($firstname != '') {

            $this->db->like('firstname', $firstname, 'after');
        }
		
		if ($email != '') {

            $this->db->like('email', $email, 'after');
        }
		
		if ($phonenumber != '') {

            $this->db->like('phonenumber', $phonenumber, 'after');
        }
     
        if ($city != '') {

            $this->db->like('city', $city, 'after');
        }
		
		if($date_from != '' && $date_too !=''){

            $this->db->where('email_verified_at >=', $date_from.' 00:00:00');
            $this->db->where('email_verified_at <=', $date_too.' 23:59:00');

        }else if($date_from != '' && $date_too ==''){

            $this->db->where('email_verified_at >=', $date_from.' 00:00:00');
            $this->db->where('email_verified_at <=', $date_from.' 23:59:00');

        }else if($date_from == '' && $date_too !=''){

            $this->db->where('email_verified_at >=', $date_too.' 00:00:00');
            $this->db->where('email_verified_at <=', $date_too.' 23:59:00');

        }

        if ($month != '') {
            $date1 = date('Y').'-'.$month.'-01';
            $d=cal_days_in_month(CAL_GREGORIAN,$month,date('Y'));
            if($d < 10 ){$d = '0'.$d;}
            $date2 = date('Y').'-'.$month.'-'.$d;
            
            $this->db->where('email_verified_at >=', $date1);
            $this->db->where('email_verified_at <=', $date2);
            
        }
		
        $this->db->where('type', 0);
        $this->db->order_by('id', 'DESC');
        $get_data = $this->db->get('tblcontacts');

        $data_arr = $get_data->result_array();

        $return_arr = array();
        
		foreach ($data_arr as $key => $value) {
            
			$return_arr[$key]['id'] = $value['dryvarfoods_id'];
			$return_arr[$key]['firstname'] = $value['firstname'];
			$return_arr[$key]['email'] = $value['email'];
			$return_arr[$key]['phonenumber'] = $value['phonenumber'];
			$return_arr[$key]['city'] = $value['city'];
			
            //Last Order
            $this->db->where('user_id', $value['dryvarfoods_id']);
			$this->db->offset(0);
            $this->db->limit(1);
			$this->db->order_by('id', 'DESC'); 
            $get_order = $this->db->get(db_prefix(). 'orders');
            $order_arr =  $get_order->row_array();
            
            $return_arr[$key]['last_order'] = $order_arr['dryvarfoods_id'];
			
			//Orders last 30 days
			
			$query = $this->db->query("SELECT count(*) as total FROM tblorders WHERE created_at < DATE_ADD(NOW(), INTERVAL -1 MONTH) AND user_id=".$value['dryvarfoods_id']);
			$order_arr =  $query->row_array();
			$return_arr[$key]['orders_last_30_days'] = $order_arr["total"];

            // Total Orders
            $this->db->where('user_id', $value['dryvarfoods_id']); 
            $get_order = $this->db->get(db_prefix(). 'orders');
            $total_orders =  $get_order->num_rows();
            
            $return_arr[$key]['total_orders'] = $total_orders;
			
			
			$return_arr[$key]['email_verified_at'] = $value['email_verified_at'];


        }
        
        return $return_arr;
    }
	


    public function get_rewards_point_reporting($user_id){

        $this->db->where(array('user_id' => $user_id));
        $get_rewards = $this->db->get('tblrewards')->result_array();

        $months = array();
        $highchart_data = array();

        for ($i = 0; $i < 6; $i++) {
          $months[] = date('F', strtotime("-$i month"));
        }

        $December = 0;
        $November = 0;
        $October = 0;
        $September = 0;
        $Augest = 0;
        $July = 0;
        $June = 0;
        $May = 0;
        $March = 0;
        $Febrary = 0;
        $January = 0;
        $rewards_month = '';

        for ($i=0; $i < count($get_rewards); $i++) { 

            $rewards_month = date("F", strtotime($get_rewards[$i]['created_at']));

            if($rewards_month == 'December'){
                $December ++;
            }
            if($rewards_month == 'November' && in_array('November', $months)){
                $November ++;
            }
            if($rewards_month == 'October' && in_array('October', $months)){
                $October ++;
            }
            if($rewards_month == 'September' && in_array('September', $months)){
                $September ++;
            }
            if($rewards_month == 'Augest' && in_array('Augest', $months)){
                $Augest ++;
            }
            if($rewards_month == 'July' && in_array('July', $months)){
                $July ++;
            }
            if($rewards_month == 'June' && in_array('June', $months)){
                $June ++;
            }
            if($rewards_month == 'May' && in_array('May', $months)){
                $May ++;
            }
            if($rewards_month == 'April' && in_array('April', $months)){
                $April ++;
            }
            if($rewards_month == 'March' && in_array('March', $months)){
                $March ++;
            }    

            if($rewards_month == 'Febrary' && in_array('Febrary', $months)){
                $Febrary ++;
            }    
            if($rewards_month == 'January' && in_array('January', $months)){
                $January ++;
            }

            $available_reward_point += $get_rewards[$i]['reward_points'];

        }

        for ($i = 0; $i < 6; $i++) {
          
          $pre_month = date('F', strtotime("-$i month"));

          if($pre_month == 'December'){
            $highchart_data[] = (int) $December;
          }
          if($pre_month == 'November'){
           $highchart_data[] = (int) $November; 
          }
          if($pre_month == 'October'){
            $highchart_data[] = (int) $October;
          }
          if($pre_month == 'September'){
            $highchart_data[] = (int) $September;
          }
          if($pre_month == 'Augest'){
            $highchart_data[] = (int) $Augest;
          }
          if($pre_month == 'July'){
            $highchart_data[] = $July;
          }

        }

        $get_record = array(
                        array(
                            'name' => 'Points',
                            'data' => $highchart_data
                        )
                    );

        $response = json_encode($get_record,true);
        
       
        $str_month = json_encode($months);

        echo $response.'*|*'.$str_month; 
        exit;
       
    }
    

    public function get_user_reward_available($user_id){
        
        $get_data = $this->db->query("SELECT SUM(reward_points) as total_available_points, SUM(used_rewards) as total_used_points from tblrewards where user_id='".$user_id."' ");
        $reward_point_arr = $get_data->row_array();

        return $reward_point_arr;
    }

    public function get_user_loyality_used($user_id){
        
        $get_data = $this->db->query("SELECT SUM(earned_points) as total_available_points, SUM(used_points) as total_used_points from tblloyalty_points where user_id='".$user_id."' ");
        $loyality_point_arr = $get_data->row_array();

        return $loyality_point_arr;
    }


    public function count_recommended_food_user()
    {   
        
        $query = $this->db->query("SELECT COUNT(user_id), user_id FROM tblorders GROUP BY user_id");
        $data_arr = $query->num_rows();

        return $data_arr;   
    }
    

    public function get_recommended_food_user($data=array(),$start,$limit)
    {   
        
        extract($data);
        
        /*if(is_string($start)){
            $start = 0;
        }*/
        // echo $start;
        // exit;

        $query = $this->db->query("SELECT COUNT(user_id), user_id FROM tblorders GROUP BY user_id ORDER BY user_id LIMIT ".$start.",".$limit."");
        $data_arr = $query->result_array();
        $return_arr = array();

        // echo "<pre>";
        // print_r($data_arr);
        // exit;

        foreach ($data_arr as $key => $value) {
            
            $return_arr[$key]['user_id'] = $value['user_id'];
            

            //Last Order
            $this->db->where('dryvarfoods_id', $value['user_id']);
            $this->db->order_by('id', 'DESC'); 

            $get_data = $this->db->get(db_prefix(). 'contacts');
            $contact_arr =  $get_data->row_array();
        
            $return_arr[$key]['firstname']  = $contact_arr['firstname'];
            $return_arr[$key]['dryvarfoods_id']  = $contact_arr['dryvarfoods_id'];
            $return_arr[$key]['email']      = $contact_arr['email'];
        }
            

        return $return_arr;
    }


    public function get_recommended_item_to_user($user_id){

        $client_id      = $this->config->item('recombee_id2');
        $client_secret  = $this->config->item('recombee_secret2');

        $client = new Client($client_id, $client_secret);
        
        $recommended_scenario = new Reqs\RecommendItemsToUser($user_id, '20', ['scenario' => 'item_recommended']);
        $response = $client->send($recommended_scenario);
        $push_arr = '';

        if(!empty($response['recomms'])){
            for ($i=0; $i < count($response['recomms']); $i++) { 
                
                $get_item = $this->db->query("SELECT * FROM tblmenu_item  where dryvarfoods_id='".$response['recomms'][$i]['id']."' ");
                $item_arr = $get_item->row_array();

                $push_arr .= '<span class="label label-default" style="display: flex; line-height: 18px; width: fit-content;">'.$item_arr['name'].'</span>';
            }
        }

        // $recomm_str = "";
        // if(!empty($push_arr)){
        //     $recomm_str = implode($push_arr, ',');
        // }

        return $push_arr;
    }

    
    public function get_recommended_cross_sale_item_to_user($user_id){

        $client_id      = $this->config->item('recombee_id2');
        $client_secret  = $this->config->item('recombee_secret2');

        $client = new Client($client_id, $client_secret);
        
        $recommended_scenario = new Reqs\RecommendItemsToUser($user_id, '20', ['scenario' => 'cross_sale_item']);
        $response = $client->send($recommended_scenario);
        $push_arr = '';

        if(!empty($response['recomms'])){
            for ($i=0; $i < count($response['recomms']); $i++) { 
                
                $get_item = $this->db->query("SELECT * FROM tblmenu_item  where dryvarfoods_id='".$response['recomms'][$i]['id']."' ");
                $item_arr = $get_item->row_array();

                $push_arr .= '<span class="label label-default" style="display: flex; line-height: 18px; width: fit-content;">'.$item_arr['name'].'</span>';

            }
        }

        // $recomm_str = "";
        // if(!empty($push_arr)){
        //     $recomm_str = implode($push_arr, ',');
        // }

        return $push_arr;
    
    }


    public function get_recommended_future_item_user($user_id){

        $client_id      = $this->config->item('recombee_id2');
        $client_secret  = $this->config->item('recombee_secret2');

        $client = new Client($client_id, $client_secret);
        
        $recommended_scenario = new Reqs\RecommendItemsToUser($user_id, '20', ['scenario' => 'future_item_recommends']);
        $response = $client->send($recommended_scenario);
        $push_arr = '';

        if(!empty($response['recomms'])){
            for ($i=0; $i < count($response['recomms']); $i++) { 
                
                $get_item = $this->db->query("SELECT * FROM tblmenu_item  where dryvarfoods_id='".$response['recomms'][$i]['id']."' ");
                $item_arr = $get_item->row_array();

                $push_arr .= '<span class="label label-default" style="display: flex; line-height: 18px; width: fit-content;">'.$item_arr['name'].'</span>';

            }
        }

        // $recomm_str = "";
        // if(!empty($push_arr)){
        //     $recomm_str = implode($push_arr, ',');
        // }

        return $push_arr;
    
    }


    public function get_user_id_from_client($clientid){

        if($clientid != ""){
            
            $this->db->where('dryvarfoods_id', $clientid);
            $get_user = $this->db->get('tblclients');
            $user_arr =  $get_user->row_array();

            return $user_arr['userid'];

        }

    }
	
	public function get_customer_fav_store($data = array()){
	extract($data);
	if(isset($from_date) && $from_date!="" && isset($to_date) && $to_date!=""){
			$date_from = strtotime($from_date.' 00:00:00');
			$date_to = strtotime($to_date.' 23:59:00');
				
	        $query = $this->db->query("SELECT c.company, o.restaurant_id, count(o.restaurant_id) as total_count FROM `tblorders` o INNER JOIN tblclients c ON c.dryvarfoods_id = o.restaurant_id WHERE o.user_id =".$customer_id." AND o.created_at >= ".$date_from." AND o.created_at <= ".$date_to." group by o.restaurant_id ORDER BY total_count DESC LIMIT 1");
	}
	else{
		$query = $this->db->query("SELECT c.company, o.restaurant_id, count(o.restaurant_id) as total_count FROM `tblorders` o INNER JOIN tblclients c ON c.dryvarfoods_id = o.restaurant_id WHERE o.user_id =".$customer_id." group by o.restaurant_id ORDER BY total_count DESC LIMIT 1");

	}
	//echo $this->db->last_query();
	if($query->num_rows()>0){
	$result = $query->row_array();
	}
	else{
		$result = array();
	}
	return $result;
	}
	
	public function get_customer_fav_meal_item($data = array()){
	extract($data);
	if(isset($from_date) && $from_date!="" && isset($to_date) && $to_date!=""){
			$date_from = strtotime($from_date.' 00:00:00');
			$date_to = strtotime($to_date.' 23:59:00');
	$query = $this->db->query("SELECT m.name, o.menu_item_id, count(o.menu_item_id) as total_count FROM `tblorder_item` o INNER JOIN tblmenu_item m ON m.dryvarfoods_id = o.menu_item_id WHERE o.order_id IN (select dryvarfoods_id from tblorders where user_id = ".$customer_id." AND created_at >= ".$date_from." AND created_at <= ".$date_to.") group by o.menu_item_id ORDER BY total_count DESC LIMIT 1");
	}
	else{
	$query = $this->db->query("SELECT m.name, o.menu_item_id, count(o.menu_item_id) as total_count FROM `tblorder_item` o INNER JOIN tblmenu_item m ON m.dryvarfoods_id = o.menu_item_id WHERE o.order_id IN (select dryvarfoods_id from tblorders where user_id = ".$customer_id.") group by o.menu_item_id ORDER BY total_count DESC LIMIT 1");
		
	}
	if($query->num_rows()>0){
	$result = $query->row_array();
	}
	else{
		$result = array();
	}
	return $result;
	}
	
	public function get_customer_order_frequency($id){
	$query = $this->db->query("SELECT count(*) as total_order_frequency FROM `tblorders` WHERE created_at < DATE_ADD(NOW(), INTERVAL -1 MONTH) AND user_id =".$id);
	if($query->num_rows()>0){
	$data_arr = $query->row_array();
	$result = $data_arr["total_order_frequency"];
	}
	else{
		$result = array();
	}
	return $result;
	}
	
	public function get_orders_revenue($data=array(), $status){
		extract($data);
		if($status=="completed"){
		if(isset($from_date) && $from_date!="" && isset($to_date) && $to_date!=""){
			$date_from = strtotime($from_date.' 00:00:00');
			$date_to = strtotime($to_date.' 23:59:00');
		    $query = $this->db->query("SELECT SUM(total_amount)	as total_revenue FROM tblorders WHERE user_id = ".$customer_id." AND completed_at>0 AND created_at >= ".$date_from." AND created_at<= ".$date_to);
		}
		else{  
		   $query = $this->db->query("SELECT SUM(total_amount)	as total_revenue FROM tblorders WHERE user_id = ".$customer_id." AND completed_at>0");
		
		}
		}
		else{
		if(isset($from_date) && $from_date!="" && isset($to_date) && $to_date!=""){
			$date_from = strtotime($from_date.' 00:00:00');
			$date_to = strtotime($to_date.' 23:59:00');
		    $query = $this->db->query("SELECT SUM(total_amount)	as total_revenue FROM tblorders WHERE user_id = ".$customer_id." AND declined_at>0 AND created_at >= ".$date_from." AND created_at<= ".$date_to);
		}
		else{
		    $query = $this->db->query("SELECT SUM(total_amount)	as total_revenue FROM tblorders WHERE user_id = ".$customer_id." AND declined_at>0");	
		}
		}
		//echo $this->db->last_query();exit;
		if($query->num_rows()>0){
		$result = $query->row_array();
		}
		else{
			$result = array();
		}
		return $result;
	}  
}
