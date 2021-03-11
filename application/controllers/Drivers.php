<?php

defined('BASEPATH') or exit('No direct script access allowed'); 

class Drivers extends AdminController
{
	public function __construct() {
             parent::__construct();

             $this->load->model("mod_common");
			 $this->load->model("mod_drivers");

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

        $data['page_links'] = $this->pagination->create_links();
        
        $data['drivers'] = $this->mod_drivers->get_drivers($input_arr,$page,$config["per_page"]);
		
		$data['drivers_count'] = $this->mod_drivers->count_drivers();
		
		$data['drivers_count_active'] = $this->mod_drivers->count_drivers_statuses(1);
		$data['drivers_count_inactive'] = $this->mod_drivers->count_drivers_statuses(0);
		
        $data['title'] = _l('Drivers');
        $this->load->view('admin/drivers/manage_drivers', $data);
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

        $page_links = $this->pagination->create_links();
		
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
	
	public function requests($driver_id)
    {   
        $table ="tblorder_delivery";
		$where = array("driver_id" => $driver_id);
        $data['requests_arr'] =  $this->mod_common->get_all_records($table, "*", 0, 0, $where);
		if(count($data['requests_arr']) > 0){
			$data['title'] = _l('Requests');
			$this->load->view('admin/drivers/requests', $data);
		}
		else{
			$this->session->set_flashdata('err_message', 'Record does not exists. Something went wrong, please try again.');
			redirect(AURL."drivers");
		}
    }


	
		

}
