<?php

defined('BASEPATH') or exit('No direct script access allowed'); 

class Orders extends AdminController
{
	
	public function __construct() {
             parent::__construct();
			 $this->load->model("clients_model");
             //$this->mod_common->verify_is_admin_login();
    }
	
	public function index($filtertype='',$data_id='')
    {   

        $data['filtertype']   = $filtertype;
        $data['data_id']      = $data_id;

        if( $filtertype !=''){
            $input_arr = array( $filtertype => $data_id);
        }else{ 
		    $input_arr = array();
		}

        $count_total_leads = $this->clients_model->count_orders_manual('',$input_arr);
        $data['total_count'] = $count_total_leads;
        //Pagination
        $this->load->library('pagination');
        $config['base_url'] = base_url().'admin/orders';
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
        $data['orders']     = $this->clients_model->get_orders_manual($input_arr,$page,$config["per_page"]);
		
		$data['orders_count'] = $this->clients_model->count_orders_manual();
		
		$data['orders_count_completed'] = $this->clients_model->count_orders_statuses_manual('completed');
		$data['orders_count_pending'] = $this->clients_model->count_orders_statuses_manual('pending');
		$data['orders_count_declined'] = $this->clients_model->count_orders_statuses_manual('declined');

        $data['title'] = _l('Manual Orders');
        $this->load->view('admin/orders/all_orders', $data);
    }

    
	
	public function dashboard()
    {
        
    	$data['title'] = _l('Manual Orders Dashboard');
    	
    	$data['cities'] = $this->clients_model->get_all_cities();

		$data['orders_count'] = $this->clients_model->count_orders_manual('',$_GET);
		$data['orders_count_completed'] = $this->clients_model->count_orders_manual('completed',$_GET);
		$data['orders_count_pending'] = $this->clients_model->count_orders_manual('pending',$_GET);
		$data['orders_count_declined'] = $this->clients_model->count_orders_manual('declined',$_GET);
		
		$data['order_status_graph']        = $this->clients_model->order_status_graph_manual($_GET);
		$data['pie_chart'] = $this->clients_model->get_area_order_stats_manual($_GET);
		
        $this->load->view('admin/orders/orders_dashboard', $data);
    }
		
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
        $config['base_url'] = base_url().'admin/orders';
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
        $this->load->view('admin/orders/orders_report', $data);
    }

    public function orders_report_ajax($page)
    {   

        $count_total_leads = $this->clients_model->count_orders($this->input->post());

        $total_count = $count_total_leads;
        //Pagination
        $this->load->library('pagination');
        $config['base_url'] = base_url().'admin/orders/orders_ajax';
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
		  $lin  = '<a href="'.AURL.'orders/orders_detail/'.$value['ID'].'">'.$value['ID'].'</a>';
		  
		  
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

    public function orders_ajax($page)
    {   

        $count_total_leads = $this->clients_model->count_orders('',$this->input->post());

        $total_count = $count_total_leads;
        //Pagination
        $this->load->library('pagination');
        $config['base_url'] = base_url().'admin/orders/orders_ajax';
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
			
		  if($value['status']=='Pending'){ 
			 $newstatus = '<span class="label label-primary">In Cart</span>';
			 $pendingcount  +=  $value['total_amont'];
		  }else if($value['status']=='Completed'){ 
			 $newstatus = '<span class="label label-success">Completed</span>';
			 $completedcount  +=  $value['total_amont'];
		  }else if($value['status']=='Declined'){ 
			 $newstatus = '<span class="label label-danger">Declined</span>';
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
		  $lin  = '<a href="'.AURL.'orders/orders_detail/'.$value['ID'].'">'.$value['ID'].'</a>';
		  
		  
		  $response .='<tr role="row">
           
		     <td>'.$newkey.'</td>
		    <td>'.$lin.'</td>
            <td>'.$customer_name.'</td>
            <td>'.$company_name.'</td>
            <td>'.$city.'</td>
            <td>'.$newstatus.'</td>
			<td>'.$value['time_ago'].'</td>
            <td>'.$value['total_amont'].'</td>
            <!--<td>'.$value['restaurant_commision_fee'].'</td>-->
            <td>'.$driver_name.'</td>
            <td>'.$value['dated'].'</td>
            <td><a href="'.AURL.'orders/orders_detail/'.$value['ID'].'" class="btn btn-default btn-icon"><i class="fa fa-eye"></i></a> </td>
          </tr>';
        } 

        echo $response.'***||***'.$total_count.'***||***'.$page_links.'***||***'.$pendingcount.'***||***'.$completedcount.'***||***'.$declinecount;
	    }else{
		 echo "nororders"; exit;	
		}
    }

    public function get_client_user_id(){

        $client = $this->input->post('client');

        $response = $this->clients_model->get_user_id_from_client($client);

        echo $response;
        exit;        

    }

    public function orders_manual_ajax($page)
    {   

        $count_total_leads = $this->clients_model->count_orders_manual('',$this->input->post());

        $total_count = $count_total_leads;
        //Pagination
        $this->load->library('pagination');
        $config['base_url'] = base_url().'admin/orders/orders_manual_ajax';
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
        $orders = $this->clients_model->get_orders_manual($this->input->post(),$page,$config["per_page"]);
        //echo "<prE>";  print_r($orders ); exit;
        
        if(count($orders)>0){ 


        $response = '';
        $pendingcount   = 0;
        $completedcount = 0;
        $declinecount   = 0;
        foreach ($orders as $key => $value) {
            
          if($value['status']=='Pending'){ 
             $newstatus = '<span class="label label-primary">In Cart</span>';
             $pendingcount  +=  $value['total_amont'];
          }else if($value['status']=='Completed'){ 
             $newstatus = '<span class="label label-success">Completed</span>';
             $completedcount  +=  $value['total_amont'];
          }else if($value['status']=='Declined'){ 
             $newstatus = '<span class="label label-danger">Declined</span>';
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
          $lin  = '<a href="'.AURL.'orders/orders_detail/'.$value['ID'].'">'.$value['ID'].'</a>';
          
          
          $response .='<tr role="row">
           
             <td>'.$newkey.'</td>
            <td>'.$lin.'</td>
            <td>'.$customer_name.'</td>
            <td>'.$company_name.'</td>
            <td>'.$city.'</td>
            <td>'.$newstatus.'</td>
            <td>'.$value['time_ago'].'</td>
            <td>'.$value['total_amont'].'</td>
            <!--<td>'.$value['restaurant_commision_fee'].'</td>-->
            <td>'.$driver_name.'</td>
            <td>'.$value['dated'].'</td>
            <td><a href="'.AURL.'orders/orders_detail/'.$value['ID'].'" class="btn btn-default btn-icon"><i class="fa fa-eye"></i></a> </td>
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
	
	public function export_csv()
     {
        $file_name = 'Manual_Orders_'.date('Ymd').'.csv'; 
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
	 
	 public function orders_detail($order_id)
    {   

        $data['order_arr'] =  $this->clients_model->get_orders_detail($order_id);
		$data['order_id']  =  $order_id;

        $data['title'] = _l('Manual Orders');
        $this->load->view('admin/orders/orders_detail', $data);
    }


    public function manual_order_revenue($filtertype='',$data_id='')
    {   

        $data['filtertype']   = $filtertype;
        $data['data_id']      = $data_id;

        if( $filtertype !=''){
            $input_arr = array( $filtertype => $data_id);
        }else{ 
            $input_arr = array();
        }

        $count_total_leads = $this->clients_model->count_orders_manual('',$input_arr);
        $data['total_count'] = $count_total_leads;
        //Pagination
        $this->load->library('pagination');
        $config['base_url'] = base_url().'admin/orders/orders_revenue_ajax';
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
        $data['orders']     = $this->clients_model->get_orders_manual($input_arr,$page,$config["per_page"]);
        
        $data['orders_count'] = $this->clients_model->count_orders_manual();
        
        $data['orders_count_completed'] = $this->clients_model->count_orders_statuses_manual('completed');
        $data['orders_count_pending'] = $this->clients_model->count_orders_statuses_manual('pending');
        $data['orders_count_declined'] = $this->clients_model->count_orders_statuses_manual('declined');

        $data['title'] = _l('Manual Orders');
        $this->load->view('admin/orders/manual_order_revenue', $data);
    }


    public function orders_revenue_ajax($page)
    {   

        $count_total_leads = $this->clients_model->count_orders('',$this->input->post());

        $total_count = $count_total_leads;
        //Pagination
        $this->load->library('pagination');
        $config['base_url'] = base_url().'admin/orders/orders_revenue_ajax';
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
			
		  if($value['status']=='Pending'){ 
			 $newstatus = '<span class="label label-primary">In Cart</span>';
			 $pendingcount  +=  $value['total_amont'];
		  }else if($value['status']=='Completed'){ 
			 $newstatus = '<span class="label label-success">Completed</span>';
			 $completedcount  +=  $value['total_amont'];
		  }else if($value['status']=='Declined'){ 
			 $newstatus = '<span class="label label-danger">Declined</span>';
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
		  $lin  = '<a href="'.AURL.'orders/orders_detail/'.$value['ID'].'">'.$value['ID'].'</a>';
		  
		  
		  $response .='<tr role="row">
           
		     <td>'.$newkey.'</td>
		    <td>'.$lin.'</td>
            <!--<td>'.$customer_name.'</td>-->
            <td>'.$company_name.'</td>
            <td>'.$city.'</td>
            <td>'.$newstatus.'</td>
			<td>'.$value['time_ago'].'</td>
            <td>'.$value['total_amont'].'</td>
            <td>'.$value['restaurant_commision_fee'].'</td>
            <td>'.$driver_name.'</td>
            <td>'.$value['dated'].'</td>
          </tr>';
        } 

        echo $response.'***||***'.$total_count.'***||***'.$page_links.'***||***'.$pendingcount.'***||***'.$completedcount.'***||***'.$declinecount;
	    }else{
		 echo "nororders"; exit;	
		}
    }


    public function manual_order_revenue_ajax($page)
    {   

        $count_total_leads = $this->clients_model->count_orders_manual('',$this->input->post());

        $total_count = $count_total_leads;
        //Pagination
        $this->load->library('pagination');
        
        $config['base_url'] = base_url().'admin/orders/orders_revenue_ajax';
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
        $orders  = $this->clients_model->get_orders_manual($this->input->post(),$page,$config["per_page"]);
        // $orders = $this->clients_model->get_orders($this->input->post(),$page,$config["per_page"]);
        //echo "<prE>";  print_r($orders ); exit;
        
        if(count($orders)>0){ 


            $response = '';
            $pendingcount   = 0;
            $completedcount = 0;
            $declinecount   = 0;
            foreach ($orders as $key => $value) {
                
              if($value['status']=='Pending'){ 
                 $newstatus = '<span class="label label-primary">In Cart</span>';
                 $pendingcount  +=  $value['total_amont'];
              }else if($value['status']=='Completed'){ 
                 $newstatus = '<span class="label label-success">Completed</span>';
                 $completedcount  +=  $value['total_amont'];
              }else if($value['status']=='Declined'){ 
                 $newstatus = '<span class="label label-danger">Declined</span>';
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
              $lin  = '<a href="'.AURL.'orders/orders_detail/'.$value['ID'].'">'.$value['ID'].'</a>';
              
              
              $response .='<tr role="row">
               
                <td>'.$newkey.'</td>
                <td>'.$lin.'</td>
                <!--<td>'.$customer_name.'</td>-->
                <td>'.$company_name.'</td>
                <td>'.$city.'</td>
                <td>'.$newstatus.'</td>
                <td>'.$value['time_ago'].'</td>
                <td>'.$value['total_amont'].'</td>
                <td>'.$value['restaurant_commision_fee'].'</td>
                <td>'.$driver_name.'</td>
                <td>'.$value['dated'].'</td>
                <td><a href="'.AURL.'orders/orders_detail/'.$value['ID'].'"><i class="fa fa-eye"></i></a></td>
              </tr>';
            } 

            echo $response.'***||***'.$total_count.'***||***'.$page_links.'***||***'.$pendingcount.'***||***'.$completedcount.'***||***'.$declinecount;
        }else{
         echo "nororders"; exit;    
        }
    }


}
