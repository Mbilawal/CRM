<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Franchise extends AdminController {
	
	public function __construct(){
		
	  parent::__construct();
	    $this->load->model('clients_model');
		
		if($this->session->userdata('franchise')==1){
			redirect(base_url("admin"));
		}
		
	}
	
	
	public function index(){
		
		
		
		if($this->input->post()!=''){
			$data = $this->input->post(); 
		}else{
			$data = ""; 
		}
		$data["arr_all_franchise"] = $this->clients_model->get_all_franchise($data);
		$data['title'] = _l('Franchise');
        $this->load->view('admin/franchise/franchise_list', $data);
	}// END of index
	
	
	public function customer_invoices(){
		
		$data["arr_invoices"]= $this->clients_model->get_invoices();
		
		//echo "<pre>";  print_r($data["arr_general_customers"]); exit;
		$data['title'] = _l("Customers Invoices");
        $this->load->view('admin/customers/customer_invoices', $data);
		 
		
	}
	
	public function view_invoice($id){
		
		$data["arr_invoice"]= $this->clients_model->get_invoice($id);
		
		//echo "<pre>";  print_r($data["arr_invoice"]); exit;
		$data['title'] = _l("View Invoice");
        $this->load->view('admin/customers/view_invoice', $data);
		 
		
	}
	
	public function new_franchise(){
		
		
		$data["drivers_ids"]= $this->clients_model->get_all_used_driver($id);
		
		
		$data["arr_drivers"]= $this->clients_model->get_driver($id);
		$data['title'] = _l('New Franchise');
        $this->load->view('admin/franchise/add_franchise', $data);
		
	}
	
	public function edit_franchise($id){
		
		$data["arr_drivers"]= $this->clients_model->get_driver($id);
		$data["arr_general_customers"]= $this->clients_model->edit_frachise($id);
		
		
		$get_driver_id = $this->clients_model->get_frachise_driver($id);
		$data["franchise_driver"] = $get_driver_id['driver_ids'];
		
		
		//echo "<pre>";  print_r($data["arr_general_customers"]); exit;
		$data['title'] = _l('Edit Franchise Profile');
        $this->load->view('admin/franchise/edit_franchise', $data);
		
	}
	
	public function signup_process(){
		
		$data = $this->input->post();
		$username = trim($this->input->post('username'));
		$password = trim($this->input->post('password'));
		$first_name = trim($this->input->post('first_name'));
		$last_name = trim($this->input->post('last_name'));
		$email_address = trim($this->input->post('email_address'));
		$address = trim($this->input->post('address'));
		$address2 = trim($this->input->post('address2'));
		$phone_number = trim($this->input->post('phone_number'));
		$country = trim($this->input->post('country'));
		$city = trim($this->input->post('city'));
		$postal_code = trim($this->input->post('zip'));
		$payment_method = trim($this->input->post('payment')); 
		$payment_description = trim($this->input->post('payment_description'));
		$captcha_code = trim($this->input->post('captcha_code'));
			
		$contact_process = $this->clients_model->contact_process($this->input->post());
			
		if($contact_process ){
			$this->session->set_flashdata('ok_message', 'Customer added successfully . please check your inbox for account activation');
			redirect(base_url().'admin/general_customers');
		}else{
			$this->session->set_flashdata('err_message', ' Something went wrong, please try again.');
			redirect(base_url().'admin/register');
		}//end if($add_cms_page)

	}//end signup_process
	
	public function edit_franchise_process(){
		
		$data = $this->input->post();
		extract($data);
		$created_date = date('Y-m-d G:i:s');
		$created_by_ip = $this->input->ip_address();
		$created_by = $this->session->userdata('id');
		$signup_date = date('Y-m-d');
	
		//Record insert into database
		$ins_data = array(
		   'firstname' => $this->db->escape_str(trim($first_name)),
		   'lastname' => $this->db->escape_str(trim($last_name)),
		   //'company' => $this->db->escape_str(trim($company)),
		   'phonenumber' => $this->db->escape_str(trim($phone_number)),
		   'address' => $this->db->escape_str(trim($address)),
		   'email' => $this->db->escape_str(trim($email)),
		   'user_status' => $this->db->escape_str(1),
		   'state' => $this->db->escape_str(trim($state)),
		   'city' => $this->db->escape_str(trim($city)),
		   'type' => $this->db->escape_str(trim(11)),
		   'zip' => $this->db->escape_str(trim($zip)),
		   //'created_by' => $this->db->escape_str(trim($created_by)),
		   'datecreated' => $this->db->escape_str(trim($created_date)),
		   //'created_by_ip' => $this->db->escape_str(trim($created_by_ip)),
		);
		
		//Record insert into database
		$ins_data_staff = array(
		   'firstname' => $this->db->escape_str(trim($first_name)),
		   'lastname' => $this->db->escape_str(trim($last_name)),
		   'phonenumber' => $this->db->escape_str(trim($phonenumber)),
		   'home_town' => $this->db->escape_str(trim($city)),
		   'current_address' => $this->db->escape_str(trim($address)),
		   'email' => $this->db->escape_str(trim($email)),
		   
		   'role' => $this->db->escape_str(11),
		   'last_ip' => $this->db->escape_str($country),
		   'last_login' => $this->db->escape_str($created_date),
		   'nation' => $this->db->escape_str($country),
		   'Personal_tax_code' => $this->db->escape_str($zip),
		   'active' => $this->db->escape_str(trim(1)),
		   'datecreated' => $this->db->escape_str(trim($created_date))
		);
		
		/*$this->db->dbprefix('contacts');
		 $this->db->where('id', $id);// 
		$ins_into_db = $this->db->update('contacts', $ins_data);
		$new_user_id = $this->db->insert_id();
		*/
		
		$this->db->dbprefix('staff');
		$this->db->where('staffid', $staffid);// 
		$ins_into_db = $this->db->update('staff', $ins_data_staff);
		//echo $sql = $this->db->last_query();  exit;
		$drierids  = implode(",",$driver_select);
		
		
		//Record insert into database
		$ins_data = array(
		   'franchise_id' => $this->db->escape_str(trim($staffid)),
		   'driver_ids' => $this->db->escape_str(trim($drierids)),
		   'created_date' => $this->db->escape_str(trim($signup_date))
		);
		
		//echo "<pre>";  print_r($ins_data); exit;
		
		$this->db->dbprefix('franchise');
		$this->db->where('franchise_id', $staffid);// General customers
		$ins_into_db = $this->db->update('franchise', $ins_data);
		$new_user_id = $this->db->insert_id();
			
			
		if($ins_into_db ){
			$this->session->set_flashdata('ok_message', 'Franchise Updates successfully . please check your inbox for account activation');
			redirect(base_url().'admin/franchise');
		}else{
			$this->session->set_flashdata('err_message', ' Something went wrong, please try again.');
			redirect(base_url().'admin/franchise');
		}//end if($add_cms_page)

	}//end signup_process
	
	
	public function add_franchise_process(){
		
		$data = $this->input->post();
		
		extract($data);
		
		$created_date = date('Y-m-d G:i:s');
		$created_by_ip = $this->input->ip_address();
		$created_by = $this->session->userdata('id');
		$signup_date = date('Y-m-d');
	
		//Record insert into database
		$ins_data = array(
		   'firstname' => $this->db->escape_str(trim($first_name)),
		   'lastname' => $this->db->escape_str(trim($last_name)),
		   //'company' => $this->db->escape_str(trim($company)),
		   'phonenumber' => $this->db->escape_str(trim($phone_number)),
		   'address' => $this->db->escape_str(trim($address)),
		   'email' => $this->db->escape_str(trim($email)),
		   'user_status' => $this->db->escape_str(1),
		   'state' => $this->db->escape_str(trim($state)),
		   'city' => $this->db->escape_str(trim($city)),
		   'type' => $this->db->escape_str(trim(11)),
		   'zip' => $this->db->escape_str(trim($zip)),
		   //'created_by' => $this->db->escape_str(trim($created_by)),
		   'datecreated' => $this->db->escape_str(trim($created_date)),
		   //'created_by_ip' => $this->db->escape_str(trim($created_by_ip)),
		);
		
			 
		//Record insert into database
		$ins_data_staff = array(
		   'firstname' => $this->db->escape_str(trim($first_name)),
		   'lastname' => $this->db->escape_str(trim($last_name)),
		   'phonenumber' => $this->db->escape_str(trim($phonenumber)),
		   'home_town' => $this->db->escape_str(trim($city)),
		   'current_address' => $this->db->escape_str(trim($address)),
		   'email' => $this->db->escape_str(trim($email)),
		   'password' => app_hash_password($password),
		   'role' => $this->db->escape_str(11),
		   'last_ip' => $this->db->escape_str($country),
		   'last_login' => $this->db->escape_str($created_date),
		   'nation' => $this->db->escape_str($country),
		   'Personal_tax_code' => $this->db->escape_str($zip),
		   'active' => $this->db->escape_str(trim(1)),
		   'datecreated' => $this->db->escape_str(trim($created_date))
		);
		
		//echo "<pre>";  print_r($ins_data); 
		$this->db->dbprefix('contacts');
		$ins_into_db = $this->db->insert('contacts', $ins_data);
		$new_user_id = $this->db->insert_id();
		
		//echo "<pre>";  print_r($ins_data); 
		$this->db->dbprefix('staff');
		$ins_into_db = $this->db->insert('staff', $ins_data_staff);
		$new_user_id = $this->db->insert_id();
		
		$drierids  = implode(",",$driver_select);
		
		
		
		
		//Record insert into database
		$ins_data = array(
		   'franchise_id' => $this->db->escape_str(trim($new_user_id)),
		   'driver_ids' => $this->db->escape_str(trim($drierids)),
		   'created_date' => $this->db->escape_str(trim($signup_date))
		);
		
		$this->db->dbprefix('franchise');
		$ins_into_db = $this->db->insert('franchise', $ins_data);
		$new_user_id = $this->db->insert_id();
			
		if($ins_into_db ){
			$this->session->set_flashdata('ok_message', 'Franchise created successfully ');
			redirect(base_url().'admin/franchise/');
		}else{
			$this->session->set_flashdata('err_message', ' Something went wrong, please try again.');
			redirect(base_url().'admin/franchise/');
		}//end if($add_cms_page)

	}//end add_franchise_process
	
	
	public function invoice_process(){
		
		$data = $this->input->post();
		$customer = trim($this->input->post('customer'));
		$country = trim($this->input->post('country'));
		$number = trim($this->input->post('number'));
		$terms = trim($this->input->post('terms'));
		$duedate = trim($this->input->post('duedate'));
		$currency = trim($this->input->post('currency'));
		$adminnote = trim($this->input->post('adminnote'));
		$sales_amount = trim($this->input->post('sales_amount'));
		$commission_amount = trim($this->input->post('commission_amount'));
		$payout_amount = trim($this->input->post('payout_amount'));
		$payout_amount_field = trim($this->input->post('payout_amount_field'));
		$amount_paid_field = trim($this->input->post('amount_paid_field'));
		$total_amount_field = trim($this->input->post('total_amount_field'));
		$clientnote = trim($this->input->post('clientnote')); 
		$quantity = trim($this->input->post('quantity')); 
		$bill_to = trim($this->input->post('bill_to')); 
		$ship_to = trim($this->input->post('ship_to')); 
		$date =  date('Y-m-d 00:00:00');
		 
			
		//Record insert into database
		$ins_data = array(
		   'customer' => $this->db->escape_str(trim($customer)),
		   'country' => $this->db->escape_str(trim($country)),
		   'quantity' => $this->db->escape_str(trim($quantity)),
		   'invoice_number' => $this->db->escape_str(trim($number)),
		   'bill_to' => $this->db->escape_str(trim($bill_to)),
		   'ship_to' => $this->db->escape_str(trim($ship_to)),
		   'terms' => $this->db->escape_str(trim($terms)),
		   'duedate' => $this->db->escape_str(trim($duedate)),
		   'currency' => $this->db->escape_str(trim($currency)),
		   'adminnote' => $this->db->escape_str(trim($adminnote)),
		   'sales_amount' => $this->db->escape_str(trim($sales_amount)),
		   'commission_amount' => $this->db->escape_str(trim($commission_amount)),
		   'payout_amount' => $this->db->escape_str(trim($payout_amount)),
		   'amount_paid' => $this->db->escape_str($amount_paid_field),
		   'total' => $this->db->escape_str($total_amount_field),
		   'clientnote' => $this->db->escape_str($clientnote),
		   'created_date' => $this->db->escape_str($date)
		);
		
		
		
		$this->db->dbprefix('general_invoice');
		$ins_into_db = $this->db->insert('general_invoice', $ins_data);
		$new_user_id = $this->db->insert_id();
			
		if($ins_into_db ){
			$this->session->set_flashdata('ok_message', 'Invoice created successfully ');
			redirect(base_url().'admin/general_customers/customer_invoices');
		}else{
			$this->session->set_flashdata('err_message', ' Something went wrong, please try again.');
			redirect(base_url().'admin/general_customers/customer_invoices');
		}//end if($add_cms_page)

	}//end invoice_process
	
	public function account_activation(){
	
		$this->load->model('register/mod_signup');
		$verify_account = $this->mod_signup->verify_account($this->input->get());
		if($verify_account==1){
			$this->session->set_flashdata('ok_message', "Your Account has been Activated, Please login your account");
			redirect(base_url().'register');
		}else{
			$this->session->set_flashdata('err_message', "Sorry, Your account not activated");
			redirect(base_url().'signup');
		}
	}//end account_activation

}

/* End of file */
