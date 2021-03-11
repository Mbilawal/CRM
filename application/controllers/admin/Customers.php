<?php

defined('BASEPATH') or exit('No direct script access allowed'); 

class Customers extends AdminController
{
	public function __construct() {
             parent::__construct();

             $this->load->model("mod_common");
			 $this->load->model("mod_customers");
             $this->load->model("clients_model");
             //$this->mod_common->verify_is_admin_login();
    }
		
	public function index($data_id='')
    {   
        $data['filtertype']   = $filtertype;
        $data['data_id']      = $data_id;

        if( $filtertype !=''){
            $input_arr = array( $filtertype => $data_id);
        }else{ 
		    $input_arr = array();
		}

        $count_total_customers = $this->mod_customers->count_customers($input_arr);
        $data['total_count'] = $count_total_customers;
        //Pagination
        $this->load->library('pagination');
        $config['base_url'] = base_url().'admin/customers';
        $config['total_rows'] = $count_total_customers;
    
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
        
        $config['full_tag_open'] = '<ul class="pagination driver_filter_pagination">';
        $config['full_tag_close'] = '</ul>';
        
        $config['cur_tag_open'] = '<li class="active"><a href="#"><b>';
        $config['cur_tag_close'] = '</b></a></li>';
        
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        if($page !=0) $page = ($page-1) * $config['per_page'];

        $data['page_links'] = $this->pagination->create_links();
        
        $data['customers'] = $this->mod_customers->get_customers($input_arr,$page,$config["per_page"]);
		
		$data['customers_count'] = $this->mod_customers->count_customers();
		
		$data['customers_count_active'] = $this->mod_customers->count_customers_statuses(1);
		$data['customers_count_inactive'] = $this->mod_customers->count_customers_statuses(0);
		
        $data['title'] = _l('customers');
        $this->load->view('admin/customers/manage_customers', $data);
    }

    public function customers_ajax($page)
    {   

        $count_total_customers = $this->mod_customers->count_customers($this->input->post());
		

        $total_count = $count_total_customers;
        //Pagination
        $this->load->library('pagination');
        $config['base_url'] = base_url().'admin/customers/customers_ajax';
        $config['total_rows'] = $count_total_customers;
    
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
        
        $config['full_tag_open'] = '<ul class="pagination driver_filter_pagination">';
        $config['full_tag_close'] = '</ul>';
        
        $config['cur_tag_open'] = '<li class="active"><a href="#"><b>';
        $config['cur_tag_close'] = '</b></a></li>';
        
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
        if($page !=0) $page = ($page-1) * $config['per_page'];

        $page_links = $this->pagination->create_links();
		
        $customers = $this->mod_customers->get_customers($this->input->post(),$page,$config["per_page"]);
		
		if(count($customers)>0){ 


        $response = '';
		$activecount   = 0;
		$inactivecount = 0;
		
		$activecount = $this->mod_customers->count_customers_statuses(1, $this->input->post());
		$inactivecount = $this->mod_customers->count_customers_statuses(0, $this->input->post());
		
        foreach ($customers as $key => $value) {
			
		  if($value['active']==1){ 
			 $newstatus = '<span class="label label-success">Active</span>';
		  }else{ 
			 $newstatus = '<span class="label label-danger">Inactive</span>';
		  }

          $city  = $value['city'];
          if( $city == "" || $city == " " ) $city ="N/A";

          $newkey = $key+1;
		  $lin  = '<img src="'.base_url().'assets/images/user-placeholder.jpg" class="client-profile-image-small mright5"><a href="'.AURL.'clients/customer_details/'.$value['id'].'">'.$value["firstname"].'</a><div class="row-options"><a href="#" class="contact_modal" onclick="contact(0,'.$value['id'].');return false;">Edit </a> | <a href="'.AURL.'clients/delete_contact/0/'.$value['id'].'" class="text-danger _delete">Delete </a></div>';
		  if($value['last_order']!=""){	
		  $last_order_link  = '<a target="_Blank" href="'.AURL.'orders/orders_detail/'.$value['last_order'].'">#'.$value['last_order'].'</a>';
		  }
		  else{
			$last_order_link  = '<span class="label label-danger">Never Purchased</span>';  
		  }
		  if($value['order_last_30_days']!="" && $value['order_last_30_days']>0){
		  $order_last_30_days = "<span class='label label-success'>".$value["orders_last_30_days"]."</span>";
		  }
		  else{
			$order_last_30_days = '<span class="label label-primary">No Orders</span>';  
		  }
		  if($value["total_orders"]!=""){
		  $total_orders = "<span class='label label-success'>".$value["total_orders"]."</span>";
		  }
		  else{
			$total_orders = '<span class="label label-danger">Never Purchased</span>';
		  }
		  
		  if($value["preferred_restaurant"]!=""){
			 $preferred_restaurant = "<span class='label label-success'>".$value["preferred_restaurant"]."</span>";
		  }
		  else{
			$preferred_restaurant = '<span class="label label-primary">Never Purchased</span>';
			  
		  }
		  
		  $response .='<tr role="row">
           
		     <td>'.$newkey.'</td>
		    <td>'.$lin.'</td>
            <td>'.$value["email"].'</td>
            <td>'.$value["phonenumber"].'</td>
			<td>'.$value["city"].'</td>
            <td>'.$last_order_link.'</td>
			<td>'.$order_last_30_days.'</td>
            <td>'.$total_orders.'</td>
			<td>'.$preferred_restaurant.'</td>
			<td>'.$newstatus.'</td>
            <td>'.date("d-m-Y h:i A", strtotime($value['email_verified_at'])).'</td>
          </tr>';
        } 

        echo $response.'***||***'.$total_count.'***||***'.$page_links.'***||***'.$activecount.'***||***'.$inactivecount;
	    }else{
		 echo "norcustomers"; exit;	
		}
    }
	

    public function customer_details($userid)
    {   
        $timeline = $this->clients_model->get_orders_timeline($userid);

       
	   //echo "<pre>";  print_r($timeline); exit;
	   
	   
        $customer = $this->clients_model->get_customer($userid);

        $data['title']      = _l('Customer Details');
        $data['userid']     = $userid;
        $data['timeline']   = $timeline;
		
		
		$data['customer']   = $customer;
		
		
		
        $this->load->view('admin/clients/customer_order_details', $data);
    }



	public function export_csv()
     {
		 
        $file_name = 'customers_'.date('Ymd').'.csv'; 
         header("Content-Description: File Transfer"); 
         header("Content-Disposition: attachment; filename=$file_name"); 
         header("Content-Type: application/csv;");
       
         // get data 
         $customers = $this->mod_customers->get_customers_csv($this->input->post());
  
         // file creation 
         $file = fopen('php://output', 'w');
     
         $header = array("Customer ID","Name","Email","Phone Number","Last Order","Orders Last 30 Days","Total Orders","Preferred Restaurants","Status","Verified Email At"); 
         fputcsv($file, $header);
         foreach ($customers as $key => $value)
         { 
           fputcsv($file, $value); 
         }
         fclose($file); 
         exit; 
     }
		

}
