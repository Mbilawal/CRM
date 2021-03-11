<?php

defined('BASEPATH') or exit('No direct script access allowed'); 

class Drivers extends AdminController
{
	public function __construct() {
             parent::__construct();

             $this->load->model("mod_common");
			 $this->load->model("mod_drivers");
			 $this->load->library("form_validation");

             //$this->mod_common->verify_is_admin_login();
    }
	   

    public function test(){

        echo "<pre>";
        print_r($this->session->userdata());

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
		
        $count_total_drivers = $this->mod_drivers->count_drivers($input_arr);
	
        $data['total_count'] = $count_total_drivers;
        //Pagination
        $this->load->library('pagination');
        $config['base_url'] = base_url().'admin/drivers';
        $config['total_rows'] = $count_total_drivers;
    
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

        //$data['page_links'] = $this->pagination->create_links();
		
		 
        
        $data['drivers'] = $this->mod_drivers->get_drivers($input_arr,$page,10);
		
		$data['drivers_count'] = $this->mod_drivers->count_drivers();
		
		$data['drivers_count_active'] = $this->mod_drivers->count_drivers_statuses(1);
		$data['drivers_count_inactive'] = $this->mod_drivers->count_drivers_statuses(0);
		
        $data['title'] = _l('Drivers');
		
		
        $this->load->view('admin/drivers/manage_drivers', $data);
    }
	
	public function drivers_revenue($data_id='')
    {   
	    $drivers = $this->mod_drivers->get_franchise_drivers();
		$franchise_drivers = array();
		if(count($drivers)>0){
			if($drivers["driver_ids"]!=""){
				$drivers_list = explode(",", $drivers["driver_ids"]);
				for($i=0;$i<count($drivers_list);$i++){
					$driver_query = $this->db->query("SELECT * FROM tblcontacts WHERE driver_id = ".$drivers_list[$i]." AND type=3");
					$driver_details = $driver_query->row_array();
					$franchise_drivers[$i]["driver_id"] =  $driver_details["driver_id"];
					$franchise_drivers[$i]["driver_name"] =  $driver_details["firstname"];
			    }
		  }
		}
		$data['franchise_drivers'] = $franchise_drivers;
		
		$data_array = array("from_date" => date('Y-m-d'), "driverid" => $drivers["driver_ids"], "driver" => "all");
		$data["revenue"] = $this->mod_drivers->drivers_revenue_report($data_array);
		
		//echo "<pre>"; print_r($data["revenue"]); exit;
		
        $data['title'] = _l('Drivers Revenue');
        $this->load->view('admin/drivers/drivers_revenue', $data);
    }
    
	public function drivers_revenue_ajax()
    {
		
	    $drivers = $this->mod_drivers->get_franchise_drivers();
		$data['franchise_drivers'] = $franchise_drivers;
		
		$data_array = array(
						"from_date" => $this->input->post("from_date"), 
						"to_date" => $this->input->post("to_date"),
						"driverid" => $drivers["driver_ids"],
						"driver" => $this->input->post("driver")
					);

		$data["revenue"] = $this->mod_drivers->drivers_revenue_report($data_array);
		
		if($this->input->post("driver")!="all"){
		  $driver_query = $this->db->query("SELECT * FROM tblcontacts WHERE driver_id = ".$this->input->post("driver")." AND type=3");
		  $driver_details = $driver_query->row_array();
		  $data["driver"] = $driver_details["driver_name"];
		}
		else{
			$data["driver"] = $this->input->post("driver");
		}
		
        $this->load->view('admin/drivers/drivers_revenue_ajax', $data);
    }
    
    public function drivers_ajax($page)
    {   

        $count_total_drivers = $this->mod_drivers->count_drivers($this->input->post());
		
        $total_count = $count_total_drivers;
        //Pagination
        $this->load->library('pagination');

        $config['base_url'] = base_url().'admin/drivers/drivers_ajax';
        $config['total_rows'] = $count_total_drivers;
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
        // $page_links = $this->pagination->create_links();
		$page_links = '';
        $drivers = $this->mod_drivers->get_drivers($this->input->post(),$page,$config["per_page"]);
		
		if(count($drivers)>0){ 

            $response = '';
    		$activecount   = 0;
    		$inactivecount = 0;
    		
    		$activecount = $this->mod_drivers->count_drivers_statuses(1, $this->input->post());
    		$inactivecount = $this->mod_drivers->count_drivers_statuses(0, $this->input->post());
    		
            foreach ($drivers as $key => $value) {
    			
    		  if($value['active']==1){ 
    			 $newstatus = '<span class="label label-success">Active</span>';
    		  }else{ 
    			 $newstatus = '<span class="label label-danger">Inactive</span>';
    		  }

              $city  = $value['city'];
              if( $city == "" || $city == " " ) $city ="N/A";

              $newkey = $key+1;
    		  $lin  = '<a href="'.AURL.'drivers/detail/'.$value['id'].'">'.$value['id'].'</a>';
    		  $last_order_link  = '<a target="_Blank" href="'.AURL.'orders/orders_detail/'.$value['last_order'].'">#'.$value['last_order'].'</a>';
    		  $order_last_30_days = $value['order_last_30_days'];
    		  $total_orders = $value['total_orders'];
    		  $total_tip = number_format($value['total_tip'], 2, ".", ",");
    		  $total_delivery_fee = number_format($value['total_delivery_fee'], 2, ".", ",");
    		  $total_estimate_distance = $value['total_estimate_distance'];
    		  $total_drop_distance = $value['total_drop_distance'];
    		  $requests_link ='<a href="'.AURL.'drivers/requests/'.$value["driver_id"].'"><i class="fa fa-cab"></i></a>';
    		  $bank_details_link ='<a href="'.AURL.'drivers/bank_details/'.$value["driver_id"].'"><i class="fa fa-credit-card"></i></a>';
    		  
    		  $response .='<tr role="row">
               
    		     <td>'.$newkey.'</td>
    		    <td>'.$lin.'</td>
                <td>'.$value["firstname"].'</td>
                <td>'.$value["email"].'</td>
                <td>'.$value["phonenumber"].'</td>
    			<td>'.$value["city"].'</td>
                <td>'.$last_order_link.'</td>
    			<td>'.$order_last_30_days.'</td>
                <td>'.$total_orders.'</td>
    			<td>'.$total_tip.'</td>
    			<td>'.$total_delivery_fee.'</td>
    			<td>'.$total_estimate_distance.'</td>
    			<td>'.$total_drop_distance.'</td>
    			<td>'.$newstatus.'</td>
                <td>'.date("d-m-Y h:i A", strtotime($value['email_verified_at'])).'</td>
    			<td>'.$requests_link.'&nbsp;&nbsp;&nbsp;'.$bank_details_link.'</td>
              </tr>';
            } 

            echo $response.'***||***'.$total_count.'***||***'.$page_links.'***||***'.$activecount.'***||***'.$inactivecount;

	    }else{

		  echo "nordrivers"; exit;	
		
        }
    }
	


    public function dashboard()
    {
       echo "Coming Soon";  
    }

    
    public function detail($driver_id)
    {   

        $data['driver_arr'] =  $this->mod_drivers->get_driver_detail($driver_id);
		$data['driver_id']  =  $driver_id;

        $data['title'] = _l('Driver Details');
        $this->load->view('admin/drivers/driver_details', $data);
    }


	public function export_csv()
     {
		 
        $file_name = 'Drivers_'.date('Ymd').'.csv'; 
         header("Content-Description: File Transfer"); 
         header("Content-Disposition: attachment; filename=$file_name"); 
         header("Content-Type: application/csv;");
       
         // get data 
         $drivers = $this->mod_drivers->get_drivers_csv($this->input->post());
  
         // file creation 
         $file = fopen('php://output', 'w');
     
         $header = array("Driver ID","Name","Email","Phone Number","City","Last Order","Orders Last 30 Days","Total Orders","Total Tip","Total Delivery Fee","Total Estimate Distance","Total Drop Distance","Status","Verified At"); 
         fputcsv($file, $header);
         foreach ($drivers as $key => $value)
         { 
           fputcsv($file, $value); 
         }
         fclose($file); 
         exit; 
     }
	 
	public function bank_details($driver_id)
    {   
        $table ="tblcontacts";
		$where = array("driver_id" => $driver_id);
        $data['bank_details_arr'] =  $this->mod_common->select_single_records($table, $where);
		if(count($data['bank_details_arr']) > 0){
			$data['title'] = _l('Bank Details');
			$this->load->view('admin/drivers/bank_details', $data);
		}
		else{
			$this->session->set_flashdata('err_message', 'Record does not exists. Something went wrong, please try again.');
			redirect(AURL."drivers");
		}
    }
	
	public function requests($driver_id, $page=0)
    {   

        $count_total_requests = $this->mod_drivers->count_requests($driver_id, $this->input->post());
        $data['total_count'] = $count_total_requests;
        //Pagination
        $this->load->library('pagination');
        $config['base_url'] = base_url().'admin/drivers/requests/'.$driver_id;
        $config['total_rows'] = $count_total_requests;
    
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
        
        $config['full_tag_open'] = '<ul class="pagination requests_filter_pagination">';
        $config['full_tag_close'] = '</ul>';
        
        $config['cur_tag_open'] = '<li class="active"><a href="#"><b>';
        $config['cur_tag_close'] = '</b></a></li>';
        
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(5)) ? $this->uri->segment(5) : 0;
        if($page !=0) $page = ($page-1) * $config['per_page'];

        $data['page_links'] = $this->pagination->create_links();
        
        $data['requests'] = $this->mod_drivers->get_requests($this->input->post(),$page,$config["per_page"],$driver_id);
		
		$data['requests_count'] = $this->mod_drivers->count_requests($driver_id);
		
		$data['requests_count_accepted'] = $this->mod_drivers->count_requests_statuses(3, array(), $driver_id);
		$data['requests_count_declined'] = $this->mod_drivers->count_requests_statuses(2, array(), $driver_id);
		$data['requests_count_cancelled'] = $this->mod_drivers->count_requests_statuses(4, array(), $driver_id);
		$data['requests_count_delivered'] = $this->mod_drivers->count_requests_statuses(5, array(), $driver_id);
		$data['requests_count_completed'] = $this->mod_drivers->count_requests_statuses(6, array(), $driver_id);
		
        $data['title'] = _l('Driver Requests');
        $this->load->view('admin/drivers/requests', $data);
    }
	
	public function requests_ajax($driver_id, $page)
    {   

        $count_total_requests = $this->mod_drivers->count_requests($driver_id, $this->input->post());
		

        $total_count = $count_total_requests;
        //Pagination
        $this->load->library('pagination');
        $config['base_url'] = base_url().'admin/drivers/requests_ajax/'.$driver_id;
        $config['total_rows'] = $count_total_requests;
    
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
        
        $config['full_tag_open'] = '<ul class="pagination requests_filter_pagination">';
        $config['full_tag_close'] = '</ul>';
        
        $config['cur_tag_open'] = '<li class="active"><a href="#"><b>';
        $config['cur_tag_close'] = '</b></a></li>';
        
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(5)) ? $this->uri->segment(5) : 0;
        if($page !=0) $page = ($page-1) * $config['per_page'];

        $page_links = $this->pagination->create_links();
		
        $requests = $this->mod_drivers->get_requests($this->input->post(),$page,$config["per_page"], $driver_id);
		
		if(count($requests)>0){ 


        $response = '';
		$acceptedcount   = 0;
		$declinedcount = 0;
		$cancelledcount = 0;
		$completedcount = 0;
		$deliveredcount = 0;
		
		$acceptedcount = $this->mod_drivers->count_requests_statuses(3, $this->input->post(), $driver_id);
		$declinedcount = $this->mod_drivers->count_requests_statuses(2, $this->input->post(), $driver_id);
		$cancelledcount = $this->mod_drivers->count_requests_statuses(4, $this->input->post(), $driver_id);
		$deliveredcount = $this->mod_drivers->count_requests_statuses(5, $this->input->post(), $driver_id);
		$completedcount = $this->mod_drivers->count_requests_statuses(6, $this->input->post(), $driver_id);
		
        foreach ($requests as $key => $value) {
			
		  if($value['status']==6){ 
			 $newstatus = '<span class="label label-success">Completed</span>';
		  }
		  else if($value['status']==5){ 
			 $newstatus = '<span class="label label-info">Delivered</span>';
		  }
		  else if($value['status']==4){ 
			 $newstatus = '<span class="label label-danger">Cancelled</span>';
		  }
		  else if($value['status']==2){ 
			 $newstatus = '<span class="label label-danger">Declined</span>';
		  }
		  else if($value['status']==3){ 
			 $newstatus = '<span class="label label-success">Accepted</span>';
		  }
		  else{ 
			 $newstatus = '';
		  }

          $newkey = $key+1;
		  $order_link  = '<a target="_Blank" href="'.AURL.'orders/orders_detail/'.$value['order_id'].'">#'.$value['order_id'].'</a>';
		  
		  
		  $response .='<tr role="row">
           
		     <td>'.$newkey.'</td>
		    <td>'.$order_link.'</td>
            <td>'.$value["pickup_location"].'</td>
            <td>'.$value["drop_location"].'</td>
            <td>'.$value["duration"].'</td>
			<td>'.$value["est_distance"].'KM</td>
            <td>'.$value["drop_distance"].'KM</td>
			<td>'.$newstatus.'</td>
            <td>'.date("d-m-Y h:i A", strtotime($value['created_at'])).'</td>
          </tr>';
        } 

        echo $response.'***||***'.$total_count.'***||***'.$page_links.'***||***'.$acceptedcount.'***||***'.$declinedcount.'***||***'.$cancelledcount.'***||***'.$deliveredcount.'***||***'.$completedcount;
	    }else{
		 echo "norrequests"; exit;	
		}
    }
	
     public function export_csv_requests($driver_id)
     {
		 
        $file_name = 'Driver_Requests_'.date('Ymd').'.csv'; 
         header("Content-Description: File Transfer"); 
         header("Content-Disposition: attachment; filename=$file_name"); 
         header("Content-Type: application/csv;");
       
         // get data 
         $requests = $this->mod_drivers->get_requests_csv($driver_id);
  
         // file creation 
         $file = fopen('php://output', 'w');
     
         $header = array("ID","Order ID","Pickup Location","Drop Location","Duration","Estimate Distance","Drop Distance","Status","Created At"); 
         fputcsv($file, $header);
         foreach ($requests as $key => $value)
         { 
           fputcsv($file, $value); 
         }
         fclose($file); 
         exit; 
     }
     
	//Driver Checklist
	
	public function add_checklist(){
		$data["drivers"] = $this->mod_common->get_all_records("tblcontacts", "*", 0, 0, array("driver_id >" => 0, "type" => 3));
		$data['title'] = "Add Checklist";
        $this->load->view('admin/drivers/add_checklist', $data);
	}
	
	public function add_checklist_process(){
		
		$this->form_validation->set_rules('driver_id', 'Driver', 'required');
		$this->form_validation->set_rules('uniform', 'Uniform', 'required');
	    $this->form_validation->set_rules('tyres', 'Tyres', 'required');
		$this->form_validation->set_rules('front_panel', 'Front Panel', 'required');
		$this->form_validation->set_rules('right_side', 'Right Side', 'required');
	    $this->form_validation->set_rules('left_side', 'Left Side', 'required');
		$this->form_validation->set_rules('exhaust_cover', 'Exhaust Cover', 'required');
		$this->form_validation->set_rules('licence_disc', 'Licence Disc', 'required');
		$this->form_validation->set_rules('mirrors', 'Mirrors', 'required');
		$this->form_validation->set_rules('bin', 'Bin', 'required');
		
		$data["drivers"] = $this->mod_common->get_all_records("tblcontacts", "*", 0, 0, array("driver_id >=" => 0, "type" => 3));
		
		if ($this->form_validation->run() == FALSE)
				{
				   $data['title'] = "Add Checklist";
                   $this->load->view('admin/drivers/add_checklist', $data);
				}
				else{

					$table = "tblchecklist";
					
					$driver_id = $this->input->post('driver_id');
					$uniform = $this->input->post('uniform');
					$tyres = $this->input->post('tyres');
                    $front_panel = $this->input->post('front_panel');
                    $right_side = $this->input->post('right_side');
                    $left_side = $this->input->post('left_side');
					$exhaust_cover = $this->input->post('exhaust_cover');
					$licence_disc = $this->input->post('licence_disc');
					$mirrors = $this->input->post('mirrors');
					$bin = $this->input->post('bin');
	                
					$ins_array = array(
						"driver_id" => $driver_id,
						"uniform" => $uniform,
                        "tyres" => $tyres,
						"front_panel" => $front_panel,
                        "right_side" => $right_side,
                        "left_side" => $left_side,
                        "exhaust_cover" => $exhaust_cover,
						"licence_disc" => $licence_disc,
						"mirrors" => $mirrors,
						"bin" => $bin
					);
					
		            $add_checklist = $this->mod_common->insert_into_table($table, $ins_array);
					
					if ($add_checklist) {
						$this->session->set_flashdata('ok_message', 'Checklist added successfully!');
						redirect(AURL . 'drivers/checklist');
					} else {
						
						$this->session->set_flashdata('err_message', 'Error in adding Checklist please try again!');
						redirect(AURL . 'drivers/add_checklist');
					}
				}
	}
	
	public function checklist($page=0)
    {   

        $count_total_checklist = $this->mod_drivers->count_checklist($this->input->post());

        $data['total_count'] = $count_total_checklist;
        //Pagination
        $this->load->library('pagination');
        $config['base_url'] = base_url().'admin/drivers/checklist';
        $config['total_rows'] = $count_total_checklist;
    
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
        
        $config['full_tag_open'] = '<ul class="pagination checklist_filter_pagination">';
        $config['full_tag_close'] = '</ul>';
        
        $config['cur_tag_open'] = '<li class="active"><a href="#"><b>';
        $config['cur_tag_close'] = '</b></a></li>';
        
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
        if($page !=0) $page = ($page-1) * $config['per_page'];

        $data['page_links'] = $this->pagination->create_links();
        
        $data['checklist'] = $this->mod_drivers->get_checklist($this->input->post(),$page,$config["per_page"]);
		
		$data['checklist_count'] = $this->mod_drivers->count_checklist();
		
        $data['title'] = _l('Driver Checklist');
        $this->load->view('admin/drivers/checklist', $data);
    }
	
	public function checklist_ajax($page)
    {   

        $count_total_checklist = $this->mod_drivers->count_checklist($this->input->post());
		

        $total_count = $count_total_checklist;
        //Pagination
        $this->load->library('pagination');
        $config['base_url'] = base_url().'admin/drivers/checklist_ajax';
        $config['total_rows'] = $count_total_checklist;
    
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
        
        $config['full_tag_open'] = '<ul class="pagination checklist_filter_pagination">';
        $config['full_tag_close'] = '</ul>';
        
        $config['cur_tag_open'] = '<li class="active"><a href="#"><b>';
        $config['cur_tag_close'] = '</b></a></li>';
        
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
        if($page !=0) $page = ($page-1) * $config['per_page'];

        $page_links = $this->pagination->create_links();
		
        $checklist = $this->mod_drivers->get_checklist($this->input->post(),$page,$config["per_page"]);
		
		if(count($checklist)>0){ 


        $response = '';
		
        foreach ($checklist as $key => $value) {

          $newkey = $key+1;
		  $response .='<tr role="row">
           
		    <td>'.$newkey.'</td>
		    <td>'.$value["driver_name"].'</td>
            <td>'.$value["mobile_number"].'</td>
            <td>'.$value["uniform"].'</td>
            <td>'.$value["tyres"].'</td>
			<td>'.$value["front_panel"].'</td>
            <td>'.$value["right_side"].'</td>
			<td>'.$value["left_side"].'</td>
			<td>'.$value["exhaust_cover"].'</td>
			<td>'.$value["licence_disc"].'</td>
			<td>'.$value["mirrors"].'</td>
			<td>'.$value["bin"].'</td>
            <td>'.date("d-m-Y h:i A", strtotime($value['created_at'])).'</td>
          </tr>';
        } 

        echo $response.'***||***'.$total_count.'***||***'.$page_links;
	    }else{
		 echo "norchecklist"; exit;	
		}
    }
	
    public function export_checklist()
     {
		$driver_id = $this->input->post("driver_id");
		$report_type = $this->input->post("report_type");
		
		if($report_type == "csv"){
			 $file_name = 'Driver_Checklist_'.date('Ymd').'.csv'; 
			 header("Content-Description: File Transfer"); 
			 header("Content-Disposition: attachment; filename=$file_name"); 
			 header("Content-Type: application/csv;");
		   
			 // get data 
			 $checklist = $this->mod_drivers->get_checklist_csv();
	  
			 // file creation 
			 $file = fopen('php://output', 'w');
		 
			 $header = array("Driver Name","Mobile Number","Uniform","Tyres","Front Panel","Right Side","Left Side","Exhaust Cover","Licence Disc","Mirrors","Bin","Created At"); 
			 fputcsv($file, $header);
			 foreach ($checklist as $key => $value)
			 { 
			   fputcsv($file, $value); 
			 }
			 fclose($file); 
			 exit; 
		}
		else{
			"Coming Soon";
		}
     }
    
	//Driver Report
	
	public function report($data_id='')
    {   
        $data['filtertype']   = $filtertype;
        $data['data_id']      = $data_id;

        if( $filtertype !=''){
            $input_arr = array( $filtertype => $data_id);
        }else{ 
		    $input_arr = array();
		}

        $count_total_drivers = $this->mod_drivers->count_drivers_report($input_arr);
        $data['total_count'] = $count_total_drivers;
        //Pagination
        $this->load->library('pagination');
        $config['base_url'] = base_url().'admin/drivers/report';
        $config['total_rows'] = $count_total_drivers;
    
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

        $data['page_links'] = $this->pagination->create_links();
        
        $data['drivers'] = $this->mod_drivers->get_drivers_report($input_arr,$page,$config["per_page"]);
		
		$data['drivers_count'] = $this->mod_drivers->count_drivers_report();
		
        $data['title'] = _l('Driver Reports');
        $this->load->view('admin/drivers/drivers_report', $data);
    }

    public function report_ajax($page)
    {   

        $count_total_drivers = $this->mod_drivers->count_drivers_report($this->input->post());
		
        $total_count = $count_total_drivers;
        //Pagination
        $this->load->library('pagination');
        $config['base_url'] = base_url().'admin/drivers/report_ajax';
        $config['total_rows'] = $count_total_drivers;
    
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
		
        $drivers = $this->mod_drivers->get_drivers_report($this->input->post(),$page,$config["per_page"]);
		
		if(count($drivers)>0){ 


        $response = '';
        $response2 = '';
		
        foreach ($drivers as $key => $value) {
			
		  if($value['active']==1){ 
			 $newstatus = '<span class="label label-success">Active</span>';
		  }else{ 
			 $newstatus = '<span class="label label-danger">Inactive</span>';
		  }

		 if($value['user_status']==1){ 
		     $onlinetatus   = '<span class="label label-success">ONLINE</span>';
		  }else{ 
			 $onlinetatus = '<span class="label label-danger">OFFLINE</span>';
		  }

          $city  = $value['city'];
          if( $city == "" || $city == " " ) $city ="N/A";

          $newkey = $key+1;
		  $lin  = '<a target="_Blank" href="'.AURL.'drivers/detail/'.$value['id'].'">'.$value['id'].'</a>';
		  $total_earnings = "R".number_format($value['total_earnings'], 2, ".", ",");
		  $total_paid = "R".number_format($value['total_paid'], 2, ".", ",");
		  //$weekly_payout ='<a href="'.AURL.'drivers/weekly_payout/'.$value["id"].'"><i class="fa fa-bar-chart-o"></i></a>';
		  $weekly_payout = '';
		  $view ='<a href="'.AURL.'drivers/detail/'.$value['id'].'"class="fa fa-eye"></i></a>';
		  $payout ='<a href="'.AURL.'drivers/payout/'.$value["id"].'"><i class="fa fa-pie-chart"></i></a>';
		  $bank_details_link ='<a href="'.AURL.'drivers/bank_details/'.$value["id"].'"><i class="fa fa-credit-card"></i></a>';
		  $account_activity_link ='<a href="'.AURL.'drivers/account_activity/'.$value["id"].'"><i class="fa fa-history"></i></a>'; 
		  
            $response .='<tr role="row" style="height: 50px;">
    		    <td>'.$newkey.'</td>
    		    <td>'.$lin.'</td>
                <td>'.$value["firstname"].'</td>
    			<td>'.$onlinetatus.'</td>
                <td>'.$value["email"].'</td>
                <td>'.' <i class="fa fa-phone" style="font-size:20px; color:#84c529"></i> ( +27 ) '.$value["phonenumber"].'</td>
    			<!--<td>'.$value["city"].'</td>-->
                <td>'.$total_earnings.'</td>
    			<td>'.$total_paid.'</td>
    			<td>'.$newstatus.'</td>
    			<td>'.$view.'&nbsp;&nbsp;&nbsp;'.$weekly_payout.'&nbsp;&nbsp;&nbsp;'.$payout.'&nbsp;&nbsp;&nbsp;'.$bank_details_link.'&nbsp;&nbsp;&nbsp;'.$account_activity_link.'</td>
            </tr>';
        } 

        echo $response2.'***||***'.$total_count.'***||***'.$page_links.'***||***'.$response;
        exit;

	    }else{
		 echo "norreport"; exit;	
		}
    }
	
	public function export_report()
     {
		$driver_id = $this->input->post("driver_id");
		$report_type = $this->input->post("report_type");
		
		if($report_type == "csv"){
			 $file_name = 'Driver_Reports_'.date('Ymd').'.csv'; 
			 header("Content-Description: File Transfer"); 
			 header("Content-Disposition: attachment; filename=$file_name"); 
			 header("Content-Type: application/csv;");
		   
			 // get data 
			 $checklist = $this->mod_drivers->get_report_csv($this->input->post());
	  
			 // file creation 
			 $file = fopen('php://output', 'w');
		 
			 $header = array("Driver ID","Name","Email","Phone Number","City","Total Earnings","Total Paid","Status"); 
             fputcsv($file, $header);
			 foreach ($checklist as $key => $value)
			 { 
			   fputcsv($file, $value); 
			 }
			 fclose($file); 
			 exit; 
		}
		else{
			"Coming Soon";
		}
     }
	 
	 public function payout($driver_id){
		 
		$data['driver_details'] = $this->mod_common->select_single_records("tblcontacts", array("driver_id" => $driver_id));

		$endDate = new DateTime();
        $startDate = new DateTime('-30 days');
		// $endDate->format('Y-m-d');
		// $startDate->format('Y-m-d');
        $startDate = date('F d, Y', strtotime('-30 days'));
        $endDate   = date('F d, Y');

		$selected_dates = array("from_date" => $startDate, "to_date" => $endDate);

        $data['orders']         = $this->mod_drivers->get_driver_orders($driver_id, $selected_dates);
		$data['total_earnings'] = $this->mod_drivers->get_total_earnings($driver_id, $selected_dates);
		$data['total_paid']     = $this->mod_drivers->get_total_paid($driver_id, $selected_dates);
        $data['title']          = _l('Driver Payout Report');

        $this->load->view('admin/drivers/payout', $data);
	 }
	 
	 public function payout_ajax(){
		
		$driver_id = $this->input->post("driver_id");
		$data['driver_details'] = $this->mod_common->select_single_records("tblcontacts", array("driver_id" => $driver_id));
		$data['orders'] = $this->mod_drivers->get_driver_orders($driver_id, $this->input->post());
		$data['total_earnings'] = $this->mod_drivers->get_total_earnings($driver_id, $this->input->post());
		$data['total_paid'] = $this->mod_drivers->get_total_paid($driver_id, $this->input->post());
        $this->load->view('admin/drivers/payout_ajax', $data);
	 }
	 
	 public function export_payout_csv(){
		
		$driver_id = $this->input->post("driver_id");
		$orders = $this->mod_drivers->get_driver_orders($driver_id, $this->input->post());
		
		    $file_name = 'Driver_Payout_Report_'.date('Ymd').'.csv'; 
			 header("Content-Description: File Transfer"); 
			 header("Content-Disposition: attachment; filename=$file_name"); 
			 header("Content-Type: application/csv;");
			 
        // file creation 
			 $file = fopen('php://output', 'w');
		 
			 $header = array("Order ID","Pickup Point","Drop Point","Distance Covered (KM)","Payout (R)","Order Total (R)"); 
             fputcsv($file, $header);
			 foreach ($orders as $key => $value)
			 { 
			   fputcsv($file, $value); 
			 }
			 fclose($file); 
			 exit; 
	 }
	 
	 public function weekly_payout($driver_id){
		$data['driver_details'] = $this->mod_common->select_single_records("tblcontacts", array("driver_id" => $driver_id));
        $data['payout'] = $this->mod_drivers->get_driver_weekly_payout($driver_id);
        $data['title'] = _l('Driver Weekly Payout Report');
        $this->load->view('admin/drivers/weekly_payout', $data);		
	 }
	 
	 //Driver Account Activity Report
	 
	 public function account_activity($driver_id){
		 
		$data['driver_details'] = $this->mod_common->select_single_records("tblcontacts", array("driver_id" => $driver_id));
		$endDate = new DateTime();
        $startDate = new DateTime();
		$endDate->format('Y-m-d');
		$startDate->format('Y-m-d');
		$selected_dates = array("from_date" => $startDate, "to_date" => $endDate);
		$data['account_activity'] = $this->mod_drivers->get_driver_account_activity($driver_id, $selected_dates);
		$data['account_activity_status'] = $this->mod_drivers->get_account_activity_status($driver_id, $selected_dates);
        $data['title'] = _l('Driver Account Activity Report');
        $this->load->view('admin/drivers/account_activity', $data);
	 }
	  public function account_activity_ajax(){
		
		$driver_id = $this->input->post("driver_id");
		$data['driver_details'] = $this->mod_common->select_single_records("tblcontacts", array("driver_id" => $driver_id));
		$data['account_activity'] = $this->mod_drivers->get_driver_account_activity($driver_id, $this->input->post());
		$data['account_activity_status'] = $this->mod_drivers->get_account_activity_status($driver_id, $this->input->post());
        $this->load->view('admin/drivers/account_activity_ajax', $data);
	 }
	 
	 public function export_account_activity_csv(){
		
		$driver_id = $this->input->post("driver_id");
		$orders = $this->mod_drivers->get_driver_account_activity($driver_id, $this->input->post());
		
		    $file_name = 'Driver_Account_Activity_Report_'.date('Ymd').'.csv'; 
			 header("Content-Description: File Transfer"); 
			 header("Content-Disposition: attachment; filename=$file_name"); 
			 header("Content-Type: application/csv;");
			 
        // file creation 
			 $file = fopen('php://output', 'w');
		 
			 $header = array("Latitude","Longitude","Location Updated At","Status", "Created At"); 
             fputcsv($file, $header);
			 foreach ($orders as $key => $value)
			 { 
			   fputcsv($file, $value); 
			 }
			 fclose($file); 
			 exit; 
	 }// END of export_account_activity_csv
	 
	 public function trip_report($data_id='')
     {   
        $data['filtertype']   = $filtertype;
        $data['data_id']      = $data_id;

        if( $filtertype !=''){
            $input_arr = array( $filtertype => $data_id);
        }else{ 
		    $input_arr = array();
		}

        $count_total_drivers = $this->mod_drivers->count_drivers_trip($input_arr);
        $data['total_count'] = $count_total_drivers;

        //Pagination
        $this->load->library('pagination');
        $config['base_url'] = base_url().'admin/drivers/trip_report_ajax';
        $config['total_rows'] = $count_total_drivers;
    
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

        $data['page_links']    = $this->pagination->create_links();
        $data['drivers_arr']   = $this->mod_drivers->get_drivers_trip($input_arr,$page,$config["per_page"]);
		$data['drivers_count'] = $this->mod_drivers->count_drivers_trip();
        $data['title'] = _l('Driver Trip Reports');

        $this->load->view('admin/drivers/trip_report', $data);

    }
	
	public function trip_report_ajax($page)
    {   

        $count_total_drivers = $this->mod_drivers->count_drivers_trip($this->input->post());
        $total_count = $count_total_drivers;
        //Pagination
        $this->load->library('pagination');
        $config['base_url'] = base_url().'admin/drivers/trip_report_ajax';
        $config['total_rows'] = $count_total_drivers;
    
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
        $drivers = $this->mod_drivers->get_drivers_trip($this->input->post(),$page,$config["per_page"]);
		
		if(count($drivers)>0){ 


        $response = '';
        $response2 = '';
		
        foreach ($drivers as $key => $value) {
			
		  if($value['active']==1){ 
			 $newstatus = '<span class="label label-success">Active</span>';
		  }else{ 
			 $newstatus = '<span class="label label-danger">Inactive</span>';
		  }

		if($value['user_status']==1){ 
		     $onlinetatus = '<span class="label label-success">ONLINE</span>';
		}else{ 
			 $onlinetatus = '<span class="label label-danger">OFFLINE</span>';
	    }

          $city  = $value['city'];
          if( $city == "" || $city == " " ) $city ="N/A";

          $newkey = $key+1;
		  $lin  = '<a target="_Blank" href="'. AURL.'clients/orders_detail/'.$value['order_arr']['dryvarfoods_id'].'">'.$value['order_arr']['dryvarfoods_id'].'</a>';
		  $total_earnings = "R".number_format($value['total_earnings'], 2, ".", ",");
		  $total_paid = "R".number_format($value['total_paid'], 2, ".", ",");
		  //$weekly_payout ='<a href="'.AURL.'drivers/weekly_payout/'.$value["id"].'"><i class="fa fa-bar-chart-o"></i></a>';
		  $weekly_payout = '';
		  $view ='<a href="'.AURL.'clients/orders_detail/'.$value['id'].'"class="fa fa-eye"></i></a>';
		  $payout ='<a href="'.AURL.'drivers/payout/'.$value["id"].'"><i class="fa fa-pie-chart"></i></a>';
		  $bank_details_link ='<a href="'.AURL.'drivers/bank_details/'.$value["id"].'"><i class="fa fa-credit-card"></i></a>';
		  $account_activity_link ='<a href="'.AURL.'drivers/account_activity/'.$value["id"].'"><i class="fa fa-history"></i></a>'; 
		  
		    $to_time = ($value['order_arr']['created_at']);
			$from_time = ($value['order_arr']['delivery_at']);
			$fialONe =  round(abs($to_time - $from_time) / 60,2);
			;
			$to_time2 = strtotime($value['order_delivery']['started_at']);
			$from_time2 = strtotime($value['order_delivery']['delivery_at']);
			$fialTwo = round(abs($to_time2 - $from_time2) / 60,2);	
			$variana  =  $fialTwo - $fialONe  ;

    		if($variana >0){
    			$a = '<span class="label label-danger">'.$variana. " minutes";'</span>';
    		}else{
                $a = '<span class="label label-success">'.$variana. " minutes";'</span>';
            }

            if($value['order_arr']["delivery_fee"] != "" && $value['order_arr']["delivery_fee"] != 0.00){
                $order_fare = $value['order_arr']["delivery_fee"];    
            }else{
                $order_fare = '<span class="label label-danger">N/A</span>';
            } 

		  $response .='<tr role="row" style="height: 50px;">
           
		    <td>'.$newkey.'</td>
		    <td>'.$lin.'</td>
            <td>'.'<b>From : </b>'.$value['order_delivery']["pickup_location"].'   </br>   <b>To :     </b>'.$value['order_delivery']["drop_location"].'</td>
			<td>'.date("F j, Y, g:i a", strtotime($value['order_delivery']["created_at"])).'</td>
            <td>'.$order_fare.'</td>
            <td>'.number_format($value['order_delivery']["drop_distance"],  2, '.', '').'Km</td>
            <td>'.$value["firstname_driver"].'</td>
            <td>'. $fialONe. " minutes".'</td>
			<td>'.$fialTwo. " minutes".'</td>
			<td>'. $a .'</td>
            <td><a href="'.AURL.'clients/orders_detail/'.$value['order_arr']['dryvarfoods_id'].'"class="fa fa-eye"></a></td>
          </tr>';
        } 

        echo $response2.'***||***'.$total_count.'***||***'.$page_links.'***||***'.$response;
	    }else{
		 echo "norreport"; exit;	
		}
	}
		
	public function daily_payout($driver_id){
		 
		$data['driver_details'] = $this->mod_common->select_single_records("tblcontacts", array("driver_id" => $driver_id));
		
        $endDate          = new DateTime();
        $startDate        = new DateTime('-29 days');
		$eDate            = $endDate->format('Y-m-d');
		$sDate            = $startDate->format('Y-m-d');
		$selected_dates   = array("from_date" => $sDate, "to_date" => $eDate);
		
        $data['payout']   = $this->mod_drivers->get_daily_payout($driver_id, $selected_dates);
        $data['title']    = _l('Driver Payout Report');
        
        $this->load->view('admin/drivers/daily_payout', $data);
	}

    public function daily_payout_detail($driver_id,$day){
         
        $data['driver_details'] = $this->mod_common->select_single_records("tblcontacts", array("driver_id" => $driver_id));
        
        $endDate          = new DateTime();
        $startDate        = new DateTime('-29 days');
        $eDate            = $endDate->format('Y-m-d');
        $sDate            = $startDate->format('Y-m-d');
        $selected_dates   = array("from_date" => $sDate, "to_date" => $eDate);
        
        $data['payout']   = $this->mod_drivers->get_daily_payout_detail($driver_id,$day, $selected_dates);
        $data['title']    = _l('Driver Payout Report Detail');
        $data['day_detail'] = $day;

        $this->load->view('admin/drivers/daily_payout_detail', $data);

    }
	 
	 public function daily_payout_ajax(){
		
		$driver_id = $this->input->post("driver_id");
		$data['driver_details'] = $this->mod_common->select_single_records("tblcontacts", array("driver_id" => $driver_id));
		$data['payout'] = $this->mod_drivers->get_daily_payout($driver_id, $this->input->post());
        $this->load->view('admin/drivers/daily_payout_ajax', $data);
	 }
	 
	 public function export_daily_payout_csv(){
		
		$driver_id = $this->input->post("driver_id");
		$payout = $this->mod_drivers->get_daily_payout($driver_id, $this->input->post());
		
		    $file_name = 'Driver_Daily_Payout_Report_'.date('Ymd').'.csv'; 
			 header("Content-Description: File Transfer"); 
			 header("Content-Disposition: attachment; filename=$file_name"); 
			 header("Content-Type: application/csv;");
			 
        // file creation 
			 $file = fopen('php://output', 'w');
		 
			 $header = array("Day","Total Amount","Payout Amount"); 
             fputcsv($file, $header);
			 $daily_payout = array();
			 foreach ($payout as $key => $val){
				        if($val["Day_name"]==0){
							$day_name = "Monday";
						 }
						 else if($val["Day_name"]==1){
							$day_name = "Tuesday";
						 }
						 else if($val["Day_name"]==2){
							$day_name = "Wednesday";
						 }
						 else if($val["Day_name"]==3){
							$day_name = "Thursday";
						 }
						 else if($val["Day_name"]==4){
							$day_name = "Friday";
						 }
						 else if($val["Day_name"]==5){
							$day_name = "Saturday";
						 }
						 else{
							$day_name = "Sunday";
						 }
				 $daily_payout[$key]["Day_name"] = $day_name;
				 $daily_payout[$key]["total_amount"] = "R".$val["total_amount"];
				 $daily_payout[$key]["total_payout"] = "R0.00";
			 }
			 foreach ($daily_payout as $key => $value)
			 { 
			   fputcsv($file, $value); 
			 }
			 fclose($file); 
			 exit; 
	}


    public function drivers_revenue_report($data_id='')
    {   
        $drivers = $this->mod_drivers->get_franchise_drivers();
        $franchise_drivers = array();
        if(count($drivers)>0){
            if($drivers["driver_ids"]!=""){
                $drivers_list = explode(",", $drivers["driver_ids"]);
                for($i=0;$i<count($drivers_list);$i++){
                    $driver_query = $this->db->query("SELECT * FROM tblcontacts WHERE driver_id = ".$drivers_list[$i]." AND type=3");
                    $driver_details = $driver_query->row_array();
                    $franchise_drivers[$i]["driver_id"] =  $driver_details["driver_id"];
                    $franchise_drivers[$i]["driver_name"] =  $driver_details["firstname"];
                }
          }
        }
        $data['franchise_drivers'] = $franchise_drivers;
        
        $data_array = array("from_date" => date('Y-m-d'), "driverid" => $drivers["driver_ids"], "driver" => "all");
        $data["revenue"] = $this->mod_drivers->drivers_revenue_report_ajax($data_array);

        // echo "<pre>"; print_r($data["revenue"]); exit;
        
        $data['title'] = _l('Drivers Revenue Report');
        $this->load->view('admin/drivers/drivers_revenue_report', $data);
    }
    
    public function drivers_revenue_report_ajax()
    {
        
        $drivers = $this->mod_drivers->get_franchise_drivers();
        $data['franchise_drivers'] = $franchise_drivers;
        
        $data_array = array("from_date" => $this->input->post("from_date"), "to_date" => $this->input->post("to_date"), "driverid" => $drivers["driver_ids"], "driver" => $this->input->post("driver"));
        $data["revenue"] = $this->mod_drivers->drivers_revenue_report_ajax($data_array);
        
        if($this->input->post("driver")!="all"){
          
          $driver_query = $this->db->query("SELECT * FROM tblcontacts WHERE driver_id = ".$this->input->post("driver")." AND type=3");
          $driver_details = $driver_query->row_array();
          $data["driver"] = $driver_details["driver_name"];
        
        }else{
            $data["driver"] = $this->input->post("driver");
        }

        // echo "<pre>"; print_r($data["revenue"]); exit;
        
        $this->load->view('admin/drivers/drivers_revenue_report_ajax', $data);

    }
	 
}
