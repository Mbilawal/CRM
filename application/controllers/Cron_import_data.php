<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Cron_import_data extends App_Controller

{	    
	// Run each hour daily 
	// Restaurant have total Record of 300 so its okay in importing 
	public function restaurants($offset = 0)
    {
	   
		
		$file_get_contents = file_get_contents('https://shahzad.dryvarfoods.com/public/perfex_api.php?table=restaurant&&limit=10000&&offset='.$offset);
        $data_arr = json_decode($file_get_contents,true);
		
		echo "<pre>";  print_r($data_arr); 
		
        foreach ($data_arr as $key => $value) {

        	$this->db->where("dryvarfoods_id",$value['id']);
        	$check_user = $this->db->get(db_prefix() . 'clients');
        	$count = count($check_user->result_array());
        	
        	if($count == 0 ) {

	        	$data = array(
	        		'userid' 			=> '',
	        		'dryvarfoods_id' 	=> $value['id'],
	        		'company' 		    => $value['name'],
                    'user_dryvar_id'    => $value['user_id']
	        	);

	        	$this->db->insert(db_prefix() . 'clients', $data);
	        	$contact_id = $this->db->insert_id();


	        	$this->db->where("dryvarfoods_id",$value['user_id']);
        		$check_user = $this->db->update(db_prefix() . 'contacts', array('userid' => $contact_id));


	        	echo $value['name'].' inserted<br/>';
	        }else{

	        	$data = array(
	        		'company' 			=> $value['name'],
					'user_status'       => $value['status'],
                    'user_dryvar_id'    => $value['user_id']
	        	);


	            $this->db->where("dryvarfoods_id",$value['id']);
	            $this->db->set($data);
	        	$this->db->update(db_prefix() . 'clients');

	        	echo $value['name'].' updated<br/>';
	        }
        }
    }
	// Run after each hour and import 100 Records 
	// Run Once in a day at midnight 12 p.m
	// Over all record is now 15600
    public function users($limit=50, $offset  = 0)
    {	
		
        $file_get_contents = file_get_contents('https://shahzad.dryvarfoods.com/public/perfex_api2.php?table=user&&limit='.$limit.'&&offset='.$offset);
		
        $data_arr = json_decode($file_get_contents,true);
		
        foreach ($data_arr as $key => $value) {
			//Update Device ID	
        	$this->db->where("dryvarfoods_id",$value['id']);
        	$check_user = $this->db->get(db_prefix() . 'contacts');
        	$count = count($check_user->result_array());
        	
			$fullNameArr = explode(" ", $value['name']);
			$firstname   = $fullNameArr[0];
			$lastname    = $fullNameArr[1];
			
			
        	if($count == 0 ) {

	        	$data = array(
	        		'id' 				=> '',
	        		'userid' 			=> '',
	        		'dryvarfoods_id' 	=> $value['id'],
	        		'firstname' 		=> $value['name'],
	        		'lastname' 			=> '',
	        		'email' 			=> $value['email'],
	        		'phonenumber' 		=> $value['mobile_number'],
					'device_id'         => $value['device_id']!=""?substr_replace($value['device_id'], ':', 11, 0):"",
					'type' 				=> $value['type']

	        	);

	        	$data['email_verified_at'] 	= date('Y-m-d H:i:s');
	        	$data['datecreated'] 		= date('Y-m-d H:i:s');
	        	$data['is_primary'] 		= 0;
	        	$data['invoice_emails']     = isset($data['invoice_emails']) ? 1 :0;
				$data['device_id']          = isset($data['device_id']) ? $data['device_id'] :0;
	            $data['estimate_emails']    = isset($data['estimate_emails']) ? 1 :0;
	            $data['credit_note_emails'] = isset($data['credit_note_emails']) ? 1 :0;
	            $data['contract_emails']    = isset($data['contract_emails']) ? 1 :0;
	            $data['task_emails']        = isset($data['task_emails']) ? 1 :0;
	            $data['project_emails']     = isset($data['project_emails']) ? 1 :0;
	            $data['ticket_emails']      = isset($data['ticket_emails']) ? 1 :0;


	        	$this->db->insert(db_prefix() . 'contacts', $data);
	        	$contact_id = $this->db->insert_id();
	        	echo 'contact_id insert'.$contact_id.' '.$value['email'].' inserted<br/>';
	        }
			else{
                $type =  ($value['type']==2) ? 3 : '';
	        	$data = array(

	        		'firstname' 		=> $value['name'],
	        		'lastname' 			=> '',
					'device_id'         => $value['device_id']!=""?substr_replace($value['device_id'], ':', 11, 0):"",
	        		'email' 			=> $value['email'],
	        		'phonenumber' 		=> $value['mobile_number'],
	        		'type' 				=> $type

	        	);

	        	$this->db->where("dryvarfoods_id",$value['id']);
	            $this->db->set($data);
	        	$this->db->update(db_prefix() . 'contacts');

	        	echo $contact_id.' '.$value['email'].' updated<br/>';
	        }
        }
    }
	
	
	public function usersImportContact(){
		
        	$check_user = $this->db->get('user');
        	$data_arr   = $check_user->result_array();
			//echo "<pre>";  print_r($data_arr); exit;
			foreach ($data_arr as $key => $value) {	
			    echo $key."<br />";
				$k;
			    if($value['device_id']!=""){
					$k++;
					echo $k."<br />";		
					$data = array(
						'device_id'         => $value['device_id']
					);
					$this->db->where("dryvarfoods_id",$value['id']);
					$this->db->set($data);
					$contact_id = $this->db->update(db_prefix() . 'contacts');
					echo $contact_id.' '.$value['email'].' updated<br/>';
				}
			}
    }// END of usersImportContact
	
	// Import 20 records after each 5 minutes 
	// And Import over all once a day at 1 A.M
	// Total reacord is round about 1500
	 

    public function orders($limit, $offset  = 0 )
    {
        $file_get_contents = file_get_contents('https://shahzad.dryvarfoods.com/public/perfex_api.php?table=order&&limit='.$limit.'&&offset='.$offset);
        $data_arr = json_decode($file_get_contents,true);
		$data_arr = array_reverse($data_arr);
		
		
		
          
	        
        foreach ($data_arr as $key => $value) {

        	$this->db->where("dryvarfoods_id",$value['id']);
        	$check_user = $this->db->get(db_prefix() . 'orders');
        	$count = count($check_user->result_array());
			
        	if($count == 0 ) {

                echo "Inside Insert ";
        		$data = $value;
        		unset($data['id']);
        		$data['dryvarfoods_id'] = $value['id'];

        		$ins_arr = array();
        		foreach ($data as $key => $val_data) {
        			
        			if($val_data != '' ){
        				$ins_arr[$key] = $val_data;

        			}
        		}
				
				
        		$ins_arr['order_type']      = (string) $ins_arr['restaurant_notification_status'];
				$ins_arr['order_type']      = (string) $ins_arr['order_type'];
				$ins_arr['currency_code']   = (string) $ins_arr['currency_code'];
        		$ins_arr['declined_at'] 	= strtotime($ins_arr['declined_at']);
        		$ins_arr['accepted_at'] 	= strtotime($ins_arr['accepted_at']);
        		$ins_arr['cancelled_at'] 	= strtotime($ins_arr['cancelled_at']);
        		$ins_arr['delivery_at'] 	= strtotime($ins_arr['delivery_at']);
        		$ins_arr['completed_at'] 	= strtotime($ins_arr['completed_at']);
        		$ins_arr['created_at'] 		= strtotime($ins_arr['created_at']);
        		$ins_arr['updated_at'] 		= strtotime($ins_arr['updated_at']);
				$ins_arr['order_date'] 		= date("Y-m-d H:i:s", ($ins_arr['created_at']));

	        	$this->db->insert(db_prefix() . 'orders', $ins_arr);
	        	$error = $this->db->error();
	        	$contact_id = $this->db->insert_id();
	        	echo $contact_id.' inserted<br/>';
				
				$str = $this->db->last_query();
   
                 //echo "<pre>";  print_r($str); exit;
 
				
				    
	        }else{
                echo "inseide Update";
	        	$data = $value;
				
				echo "<pre>";  print_r($data); 
        		unset($data['id']);
        		unset($data['dryvarfoods_id']);
        		$ins_arr = array();
        		foreach ($data as $key => $val_data) {
        			
        			if($val_data != '' ){
        				$ins_arr[$key] = $val_data;

        			}
        		}
				
				
				$ins_arr['order_type']      = (string) $ins_arr['order_type'];
        		$ins_arr['currency_code']   = (string) $ins_arr['currency_code'];
        		$ins_arr['declined_at'] 	= strtotime($ins_arr['declined_at']);
        		$ins_arr['accepted_at'] 	= strtotime($ins_arr['accepted_at']);
        		$ins_arr['cancelled_at'] 	= strtotime($ins_arr['cancelled_at']);
        		$ins_arr['delivery_at'] 	= strtotime($ins_arr['delivery_at']);
        		$ins_arr['completed_at'] 	= strtotime($ins_arr['completed_at']);
        		$ins_arr['created_at'] 		= strtotime($ins_arr['created_at']);
        		$ins_arr['updated_at'] 		= strtotime($ins_arr['updated_at']);
				$ins_arr['order_date'] 		= date("Y-m-d H:i:s", ($ins_arr['created_at']));
				
				
				
				
				echo "<pre>";  print_r($ins_arr);  
				
				 

	        	$this->db->where("dryvarfoods_id",$value['id']);
	            $this->db->set($ins_arr);
	        	$contact_id = $this->db->update(db_prefix() . 'orders');
				
				echo $str = $this->db->last_query();
				
				echo "<br/>";

	        	echo $contact_id.' updated<br/>';
				
				 
	        }
			
        }
    }

    // Total Record 2500
	// Will run a cron job to import 50 records after each 5 minutes 
	// Will run a cron job once a day and will imort the overall Record .
    public function order_items($limit, $offset  = 0)
    {
		
        $file_get_contents = file_get_contents('https://shahzad.dryvarfoods.com/public/perfex_api.php?table=order_item&&limit='.$limit.'&&offset='.$offset);
        $data_arr = json_decode($file_get_contents,true);
		
		//echo "<pre>";  print_r($data_arr);  exit;
			
	      
        foreach ($data_arr as $key => $value) {


        	$this->db->where("dryvarfoods_id",$value['id']);
        	$check_user = $this->db->get(db_prefix() . 'order_item');
        	$count = count($check_user->result_array());

        	if($count == 0 ) {

        		$data = $value;
				$item = $value;
				
				$item  = array();
				$item['dryvarfoods_id'] 	= $value['id'];
	        	$item['order_id'] 		    = $value['order_id'];
	        	$item['menu_item_id'] 		= $value['menu_item_id'];
	        	$item['price']              = isset($value['price']) ? $value['price'] :0;
				$item['daily_deal_status']  = isset($value['daily_deal_status']) ? $value['daily_deal_status'] :0;
	            $item['orginal_price']      = isset($value['orginal_price']) ? $value['orginal_price'] :0;
	            $item['quantity']           = isset($value['quantity']) ? $value['quantity'] :0;
	            $item['modifier_price']     = isset($value['modifier_price']) ? $value['modifier_price'] :0;
	            $item['total_amount']       = isset($value['total_amount']) ? $value['total_amount'] :0;
	            $item['tax']                = isset($value['tax']) ? $value['tax'] :0;
	            $item['notes']              = isset($value['notes']) ? $value['notes'] :'';
	        	$this->db->insert(db_prefix() . 'order_item', $item);

	        	$contact_id = $this->db->insert_id();
	        	echo $contact_id.' inserted<br/>';
				
	        }else{
				
				$data = $value;
				$item = $value;
				
				$item  = array();
				$item['dryvarfoods_id'] 	= $value['id'];
	        	$item['order_id'] 		    = $value['order_id'];
	        	$item['menu_item_id'] 		= $value['menu_item_id'];
	        	$item['price']              = isset($value['price']) ? $value['price'] :0;
				$item['daily_deal_status']  = isset($value['daily_deal_status']) ? $value['daily_deal_status'] :0;
	            $item['orginal_price']      = isset($value['orginal_price']) ? $value['orginal_price'] :0;
	            $item['quantity']           = isset($value['quantity']) ? $value['quantity'] :0;
	            $item['modifier_price']     = isset($value['modifier_price']) ? $value['modifier_price'] :0;
	            $item['total_amount']       = isset($value['total_amount']) ? $value['total_amount'] :0;
	            $item['tax']                = isset($value['tax']) ? $value['tax'] :0;
	            $item['notes']              = isset($value['notes']) ? $value['notes'] :'';
	        	

	        	$this->db->where("dryvarfoods_id",$value['id']);
	            $this->db->set($item);
	        	$this->db->update(db_prefix() . 'order_item');
	        	echo $contact_id.' updated<br/>';
	        }
        }
    }
	
	// Total Record above 20000 THousands 
	// Will import 100 records in each 6-7 Minutes 
	// Wil import 5000 Records per day at Mid night 11 a.m

    public function menu_items($limit , $offset  = 0)
    {
        $file_get_contents = file_get_contents('https://shahzad.dryvarfoods.com/public/perfex_api.php?table=menu_item&&limit='.$limit.'&&offset='.$offset);
        $data_arr = json_decode($file_get_contents,true);
		//echo "<pre>";  print_r($data_arr);  
        foreach ($data_arr as $key => $value) {


        	$this->db->where("dryvarfoods_id",$value['id']);
        	$check_user = $this->db->get(db_prefix() . 'menu_item');
        	$count = count($check_user->result_array());

        	if($count == 0 ) {
        		$data = $value;
        		unset($data['id']);
        		$data['dryvarfoods_id'] = $value['id'];

        		$ins_arr = array();
        		foreach ($data as $key => $val_data) {
        			
        			if($val_data != '' ){
        				$ins_arr[$key] = $val_data;

        			}
        		}

	        	$this->db->insert(db_prefix() . 'menu_item', $ins_arr);				
				$sql = $this->db->last_query();
				//echo "<pre>";  print_r($sql);  exit;

	        	$contact_id = $this->db->insert_id();
	        	echo $contact_id.' inserted<br/>';
	        }else{

	        	$data = $value;
        		unset($data['id']);
        		unset($data['dryvarfoods_id']);
        		$ins_arr = array();
        		foreach ($data as $key => $val_data) {
        			
        			if($val_data != '' ){
        				$ins_arr[$key] = $val_data;
        			}
        		}

	        	$this->db->where("dryvarfoods_id",$value['id']);
	            $this->db->set($ins_arr);
	        	$this->db->update(db_prefix() . 'menu_item');
	        	echo $contact_id.' updated<br/>';
	        }
        }
    }

    // Total Record above 1500
	// Will import 20 records in each 6-7 Minutes 
	// Wil import Total Records per day at Mid night 11:50 p.m

    public function order_delivery($limit=20, $offset  = 0)
    {
        $file_get_contents = file_get_contents('https://shahzad.dryvarfoods.com/public/perfex_api.php?table=order_delivery&&limit='.$limit.'&&offset='.$offset);
        $data_arr = json_decode($file_get_contents,true);
		
		//echo "<pre>"; print_r($data_arr); exit;
       
        foreach ($data_arr as $key => $value) {


        	$this->db->where("dryvarfoods_id",$value['id']);
        	$check_user = $this->db->get(db_prefix() . 'order_delivery');
        	$count = count($check_user->result_array());

        	if($count == 0 ) {

        		$data = $value;
        		unset($data['id']);
        		$data['dryvarfoods_id'] = $value['id'];

        		$ins_arr = array();
        		foreach ($data as $key => $val_data) {
        			
        			if($val_data != '' ){
        				$ins_arr[$key] = $val_data;

        			}
        		}
	        	$this->db->insert(db_prefix() . 'order_delivery', $ins_arr);
                $error = $this->db->error();
	        	$contact_id = $this->db->insert_id();
	        	echo $contact_id.' inserted<br/>';
				
	        }else{

	        	$data = $value;
        		unset($data['id']);
        		unset($data['dryvarfoods_id']);
        		$ins_arr = array();
        		foreach ($data as $key => $val_data) {
        			
        			if($val_data != '' ){
        				$ins_arr[$key] = $val_data;
        			}
        		}
	        	$this->db->where("dryvarfoods_id",$value['id']);
	            $this->db->set($ins_arr);
	        	$contact_id = $this->db->update(db_prefix() . 'order_delivery');
				$sql = $this->db->last_query();
	        	echo $contact_id.' contact_id updated<br/>';
	        }
        }
    }

	// Total Record above 3500
	// Will import 50 records in each 6-7 Minutes 
	// Will import Total Records per day at Mid night 11:30 p.m

    public function user_address($limit, $offset  = 0){

        $file_get_contents = file_get_contents('https://shahzad.dryvarfoods.com/public/perfex_api.php?table=user_address&&limit='.$limit.'&&offset='.$offset);
        $data_arr = json_decode($file_get_contents,true);
		
		echo "<pre>";  print_r($data_arr);   
		

        foreach ($data_arr as $key => $value) {

            $data = array(

                'city'    => $value['city'],
				'city'    => $value['city'],
                'state'   => $value['state'],
                'zip'     => $value['postal_code'],
                'address' => $value['address']

            );
           
            $this->db->where("user_dryvar_id",$value['user_id']);
            $this->db->set($data);
            $update  = $this->db->update(db_prefix() . 'clients');
			
				$str = $this->db->last_query();
                echo 'update : '.$update;  
                 echo "<pre>";  print_r($str); 

            $this->db->where("dryvarfoods_id",$value['user_id']);
            $this->db->set($data);
            $this->db->update(db_prefix() . 'contacts');
			
			$str1 = $this->db->last_query();
			echo "<pre>";  print_r($str1); 


            $this->db->where("user_dryvar_id",$value['user_id']);
            $get_restaurant = $this->db->get(db_prefix() . 'clients');
            $restaurant_arr = $get_restaurant->row_array();
			
			
			$str5 = $this->db->last_query();
			echo "<pre>";  print_r($str5);
			echo "<br />";
			echo "restaurant_arr :: ";
			echo "<br />";
			echo "<pre>";  print_r($restaurant_arr); 
            echo "<br />";
            $data = array(

                'city'  => $value['city']

            );

            $this->db->where("restaurant_id",$restaurant_arr['dryvarfoods_id']);
            $this->db->set($data);
            $this->db->update(db_prefix() . 'orders');


        $str3 = $this->db->last_query();
		echo "<pre>";  print_r($str3); 

        }

	}
	
	// Total Record above 500
	// Will run after 12 hours and update the full records 

    public function get_drivers($limit, $offset  = 0){
		
		    

        $file_get_contents = file_get_contents('https://shahzad.dryvarfoods.com/public/perfex_api.php?table=driver&&limit='.$limit.'&&offset='.$offset);
		$data_arr = json_decode($file_get_contents,true);
		
		//echo "<pre>";  print_r($data_arr); 
	

        foreach ($data_arr as $key => $value) {
            
			

            $data = array(

				'driver_id'  => $value['id'],
				'type'       => 3
            );
          
            $this->db->where("dryvarfoods_id",$value['user_id']);
            $this->db->set($data);
            $update  = $this->db->update(db_prefix() . 'contacts');
			
			echo $update.'<br />' ; 



        }

    }
	
	
	public function get_payouts($offset  = 0){

        $file_get_contents = file_get_contents('https://shahzad.dryvarfoods.com/public/perfex_api.php?table=payout&&limit=10000&&offset='.$offset);
		$data_arr = json_decode($file_get_contents,true);
			

        foreach ($data_arr as $key => $value) {
			
			
			$this->db->where("user_dryvar_id",$value['user_id']);
            $get_restaurant = $this->db->get(db_prefix() . 'clients');
            $restaurant_arr = $get_restaurant->row_array();
			
		

        	$this->db->where("dryvarfoods_id",$value['id']);
        	$check_user = $this->db->get(db_prefix() . 'payout');
        	$count = count($check_user->result_array());

        	if($count == 0 ) {

        		$data = $value;
        		unset($data['id']);
				unset($data['created_at']);
        		$data['dryvarfoods_id'] = $value['id'];

        		$ins_arr = array();
        		foreach ($data as $key => $val_data) {
        			if($val_data != '' ){
        				$ins_arr[$key] = $val_data;
        			}
        		}
				$date  = date('Y-m-d H:i:s',strtotime($value['created_at']));
				$ins_arr['created_at'] = $date;
				$ins_arr['name']       = (string) $restaurant_arr['company'];
				$ins_arr['city']       = (string) $restaurant_arr['city'];
				$ins_arr['address']    = (string) $restaurant_arr['address'];
				
		
			


	        	$this->db->insert(db_prefix() . 'payout', $ins_arr);
	        	$contact_id = $this->db->insert_id();
	        	echo $contact_id.' inserted<br/>';
				
			
	        }else{

	        	$data = $value;
        		unset($data['id']);
        		unset($data['dryvarfoods_id']);
        		$ins_arr = array();
        		foreach ($data as $key => $val_data) {
        			
        			if($val_data != '' ){
        				$ins_arr[$key] = $val_data;

        			}
        		}
				
				$ins_arr['name']   = (string) $restaurant_arr['company'];
				$ins_arr['city']      = (string) $restaurant_arr['city'];
				$ins_arr['address']   = (string) $restaurant_arr['address'];
				
        		
	        	$this->db->where("dryvarfoods_id",$value['id']);
	            $this->db->set($ins_arr);
	        	$this->db->update(db_prefix() . 'payout');

	        	echo $contact_id.' updated<br/>';
	        }
        }

    }



    public function get_restaurant_invoices($offset){

        $this->db->limit(700);
        $this->db->offset($offset);
        $get_merchant = $this->db->get('tblclients');
        $merchant_arr = $get_merchant->result_array();
		//echo "<pre>";  print_r($merchant_arr); exit;
        foreach ($merchant_arr as $key => $value) {
               $this->create_invoices($value['dryvarfoods_id'],$value['userid']);
        }

    }


    public function create_invoices($restaurant_id, $userid){
		
		
				$start = date('Y-m-d 00:00:00',strtotime(' -7 days'));
				$endDa   = date('Y-m-d 00:00:00');
				

				$begin = new DateTime($start );
				$end   = new DateTime( $endDa );

				 //$begin = new DateTime( '2020-07-06 00:00:00' );
				
				 //$end   = new DateTime( '2020-07-13 00:00:00' );
               

        $end       = $end->modify( '+7 day' );
        $interval  = new DateInterval('P7D');
        $daterange = new DatePeriod($begin, $interval ,$end);
		
		
        $date_arr = array();
        foreach($daterange as $date){
           $date_arr[] = strtotime($date->format("Y-m-d 00:00:00") );       
		}
		
		//echo "<pre>";  print_r($date_arr);  exit;

        if($restaurant_id != '' ){
            $this->db->where('userid', $userid );
        }
        $get_merchant = $this->db->get('tblclients');
        $merchant_arr = $get_merchant->row_array();
		
		echo "<pre>";  print_r($merchant_arr);  
		

        for ($i=1; $i < count($date_arr); $i++) { 
            
            $date_filter = '';
            $d1 = $date_arr[$i-1];
            $d2 = $date_arr[$i];
            echo date('Y-m-d',$d1).'<br/>';
            echo date('Y-m-d',$d2).'<br/>';

            $date_filter  = " AND created_at >= '".$d1."' ";
            $date_filter .= " AND created_at <= '".$d2."' ";

            $get_data = $this->db->query("SELECT SUM(total_amount) as total_sales, COUNT(id) as total_orders,restaurant_id from tblorders where restaurant_id='".$restaurant_id."' AND completed_at > 0 AND total_amount > 0  ".$date_filter." ");
            $sales_arr = $get_data->row_array();

            $get_data = $this->db->query("SELECT * from tblorders where restaurant_id='".$restaurant_id."' AND completed_at > 0 AND total_amount > 0 ".$date_filter." ");
            $orders_arr = $get_data->result_array();
			
			//echo "****************** sales_arr *********************";
			//echo "<pre>";  print_r($sales_arr); 
			//echo "****************** orders_arr ********************";
			//echo "<pre>";  print_r($orders_arr); 
			
			if($merchant_arr['commission'] == 0.00 || $merchant_arr['commission'] == 0){
			   	$commission  = 17.5;
			}else{
				$commission  = $merchant_arr['commission'];
			}
			

			

            if($commission > 0 && $sales_arr['total_orders']>0 ){


                echo "I am here ";
                
				$total_payout = 0;
				$total_commision = 0;
				$total_sales_amount = 0;
				
				
                $insert_arr = array(

                    'id'                                => NULL,
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
                    'commision'                         => $commission,
                    'total_orders'                      => $sales_arr['total_orders'],
                    'status'                            => '2'
                );
                 echo "<pre>";  print_r($insert_arr); 


                $this->db->insert('tblinvoices',$insert_arr);
                $last_id = $this->db->insert_id();
				
				
				//echo "****************** last_id ********************";
			
			    //echo "<pre>";  print_r($last_id); 
				

                foreach ($orders_arr as $key => $value) {
                    
                    $total_amount = round($value['total_amount'],2);
					$subtotal     = round($value['subtotal'],2);

                    $commision_amount = ( $subtotal * $commission ) / 100;
                    $commision_amount = round($commision_amount,2);

                    $payout = $subtotal - $commision_amount;
                    
                    $this->db->query("INSERT INTO `tblinvoice_items` (`id`, `order_id`, `date`, `sales_amount`, `commission_amount`, `invoice_id`) VALUES (NULL, '".$value['dryvarfoods_id']."', '".date('Y-m-d',$value['created_at'])."', '".$subtotal."', '".$payout."', '".$last_id."')");

                    $total_sales_amount = $total_sales_amount + $subtotal;

                    $total_commision = $total_commision + $commision_amount;

                    $total_payout = $total_payout + $payout;
                }

                $insert_arr = array(
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
                $this->db->insert('tblinvoicepaymentrecords',$insert_arr);

                $this->db->where('id',$last_id);
                $this->db->set(array('subtotal' => $total_payout,'total' => $total_payout, 'total_sales_amount' => $total_sales_amount));
                $createt =  $this->db->update('tblinvoices');
                echo $createt.'createt<br />';    
              
            }
			
			
        }
	}
	
	// Total Record above 3500
	// Will run in each 3 Minutes and update the status 
  public function update_notifications_status(){
		
		require_once 'push_notifications/DbOperation.php'; 
		require_once 'push_notifications/Firebase.php';
		require_once 'push_notifications/Push.php';
							
		$this->load->model("mod_common");
		$notifications = $this->mod_common->get_all_records("notifications", "*", 0, 0, array("status !=" => 2));
		
		
		echo "<pre>";  print_r($notifications);
		foreach($notifications as $val){
						 
			$date1 = strtotime(date("Y-m-d H:i"));
			$date2=strtotime($val["date"]." ".$val["hours"].":".$val["minutes"]); 
			$diff = abs($date2 - $date1);  
			$years = floor($diff / (365*60*60*24));  
			$months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));  
			$days = floor(($diff - $years * 365*60*60*24 -  $months*30*60*60*24)/ (60*60*24)); 
			$hours = floor(($diff - $years * 365*60*60*24   - $months*30*60*60*24 - $days*60*60*24)  / (60*60));  
			$minutes = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24  - $hours*60*60)/ 60);
			
			$registatoin_ids      = array();
			$notification_type    = $val["notification_type"];

			if($minutes<=10 && $minutes>0){
				$status = 1;
				$table ="notifications";
				$where = array("id" => $val["id"]);
				$upd_array = array("status" => $status);
				$this->mod_common->update_table($table, $where, $upd_array);
			}
			else if($date1 > $date2 || $date1 == $date2){
				
				
				
				if($val["to_type"] == "all"){
					
				   $i=1;
				   $restaurants = $this->mod_common->get_all_records("tblcontacts", "*", 0, 0, array("device_id !=" => "","type !=" => 3));	
				   foreach($restaurants as $restaurant){
if($i==500 || $i==1000 || $i==1500 || $i==2000 || $i==2500 || $i==3000 || $i==3500 || $i==4000 || $i==4500 || $i==5000 || $i==5500 || $i==6000 || $i==6500 || $i==7000 || $i==7500 || $i==8000 || $i==8500 || $i==9000){

							sleep(10);
							if($notification_type == 1 || $notification_type == "1"){
								//$this->sendPushWonder($registatoin_ids, $val["title"], $val["message"], $val["id"], $val["image_url"]); 
							}else{
							   $this->sendPush($registatoin_ids, $val["title"], $val["message"], $val["id"], $val["image_url"]);
							}
						  $registatoin_ids = array();  
						}
						$registatoin_ids[] = $restaurant["device_id"];
						$i++;
				   }		
				}else if($val["to_type"] == "city"){
					
				   $allcity = explode("***",$val["city"]);
				   foreach($allcity as $city){
					   $restaurants = $this->mod_common->get_all_records("tblcontacts", "*", 0, 0, array("device_id !=" => "", "city" => $city));	   
					   foreach($restaurants as $restaurant){
							$registatoin_ids[] = $restaurant["device_id"];
					   }
				   }
			    
				}
				else if($val["to_type"] == "insight"){
					
					if($val["insight_select"]=='first_time_order'){
					
					      $get_data = $this->db->query("SELECT user_id, COUNT(user_id) FROM tblorders  GROUP BY user_id HAVING COUNT(user_id) < 2");
                          $data_arr = array_reverse( $get_data->result_array() );
						  $name ='';
						  foreach ($data_arr as $key => $value) {	
								$this->db->where('dryvarfoods_id', $value['user_id']);
								$this->db->where('datecreated >=', $val["customer_from_date"]);
								$this->db->where('datecreated <=', $val["customer_to_date"]);
								$get_user = $this->db->get(db_prefix(). 'contacts');
								$user_arr =  $get_user->row_array();
								
								if($user_arr['device_id']!=''){
								 $registatoin_ids[] = $user_arr['device_id'];
								 $name .= $user_arr['firstname'].',';
								}
						  }	
				     }else if($val["insight_select"]=='never_purchase'){
					      
				         /* $get_data = $this->db->query("SELECT  tblcontacts.* FROM tblcontacts LEFT JOIN tblorders ON 
						  tblcontacts.dryvarfoods_id = tblorders.user_id WHERE type=0 AND tblcontacts.device_id!='' ".$where." 
						  AND tblorders.status!=6 LIMIT 1000");
					      $restaurants = $get_data->result_array();	*/ 
						  
						  
						  if($val["customer_from_date"] != '' && $val["customer_to_date"] != ''){
						    $this->db->where('datecreated >=', $val["customer_from_date"]);
							$this->db->where('datecreated <=', $val["customer_to_date"]);
						  }
							$this->db->where('active', 1);
							$get_data = $this->db->get(db_prefix(). 'contacts');
							$restaurants = $get_data->result_array(); 
							
							$i=1;
						    foreach($restaurants as $restaurant){
							  $this->db->where('user_id', $restaurant['dryvarfoods_id']);
						      $this->db->where('status', 6);
							  $get_dataNew = $this->db->get(db_prefix(). 'orders');
							  $ordersLists   = $get_dataNew->result_array(); 
							  if(count($ordersLists) == 0){
								  
if($i==500 || $i==1000 || $i==1500 || $i==2000 || $i==2500 || $i==3000 || $i==3500 || $i==4000 || $i==4500 || $i==5000 || $i==5500 || $i==6000 || $i==6500 || $i==7000 || $i==7500 || $i==8000 || $i==8500 || $i==9000){
									sleep(10);
									if($notification_type ==1 || $notification_type == "1"){
										//$this->sendPushWonder($registatoin_ids, $val["title"], $val["message"], $val["id"], $val["image_url"]); 
									}else{
										$this->sendPush($registatoin_ids, $val["title"], $val["message"], $val["id"], $val["image_url"]);
									}
								  $registatoin_ids = array();  
}// END of if($i==500 || $i==1000 || $i==1500 || $i==2000 || $i==2500
							     if($restaurant["device_id"]!=''){
							       $registatoin_ids[] = $restaurant["device_id"];
								     echo "<pre>";  print_r($restaurant); 
								 }
								 $i++;
							  }	
							}
						  
					     
			         }else if($val["insight_select"]=='new_signup' && $val["customer_from_date"] != '' && $val["customer_to_date"] != ''){
					        
							$this->db->where('datecreated >=', $val["customer_from_date"]);
							$this->db->where('datecreated <=', $val["customer_to_date"]);
							$this->db->where('active', 1);
							
							$get_data = $this->db->get(db_prefix(). 'contacts');
							$restaurants = $get_data->result_array(); 
							
							echo "<pre>";  print_r($restaurants ); 
							$name = '';  
							$i=1;
							foreach($restaurants as $restaurant){
if($i==500 || $i==1000 || $i==1500 || $i==2000 || $i==2500 || $i==3000 || $i==3500 || $i==4000 || $i==4500 || $i==5000 || $i==5500 || $i==6000 || $i==6500 || $i==7000 || $i==7500 || $i==8000 || $i==8500 || $i==9000){
									sleep(10);
		
								  sleep(10);
								  echo 'i ::: '.$i;
								  echo "<br />";
								  echo "<pre>";  print_r($registatoin_ids); 	
									echo "<br />";
									if($notification_type ==1 || $notification_type == "1"){
										$this->sendPushWonder($registatoin_ids, $val["title"], $val["message"], $val["id"], $val["image_url"]); 
									}else{
									  $this->sendPush($registatoin_ids, $val["title"], $val["message"], $val["id"], $val["image_url"]);
									}
								  $registatoin_ids = array();  
								}
								if($restaurant["device_id"]!=''){
								  $registatoin_ids[] = $restaurant["device_id"];
								}
								$i++;
							}
							//echo "<pre>";  print_r($registatoin_ids ); exit;
					 }
				}
				else{
					
					$allDeviceId = explode("***",$val["user_id"]);
					echo "<pre>";  print_r($allDeviceId);  
					foreach($allDeviceId as $device_id){
						$registatoin_ids[] = $device_id;
				   }
				}	
					 
			}else if($val["status"]==0){
				$status = 0;
				$table  = "notifications";
				$where  = array("id" => $val["id"]);
				$upd_array = array("status" => $status);
				$this->mod_common->update_table($table, $where, $upd_array);
			}
			
			if(count($registatoin_ids)>0){

				if($notification_type ==1 || $notification_type == "1"){
					//$this->sendPushWonder($registatoin_ids, $val["title"], $val["message"], $val["id"], $val["image_url"]); 
				}else{
			   	$this->sendPush($registatoin_ids, $val["title"], $val["message"], $val["id"], $val["image_url"]);	
				}
			}
		}

	}
	
	public function sendPush($registatoin_ids, $title, $message, $notification_id,$image_url){    
		        
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
		'image' => $image_url,
		'sound' => 'default'),
		'data' => array('link' => $image_url,'image' => $image_url)
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
		$finalrResult  = json_decode($result); 
		
		echo "<pre>";  print_r($finalrResult);
		echo 'success '.$finalrResult->success;
		if($result===FALSE){
		  //die("Curl failed: ".curl_error($ch));
		}else{
			$count_notification   = '';
			$failure_notification = '';
			
			$get_data = $this->db->query("SELECT * from notifications where id='".$notification_id."'");
            $noti_arr = $get_data->row_array();
			
			$count_notification   = $noti_arr['count_notification'];
			$totalcount           = $count_notification + $finalrResult->success;
			
			$failure_notification = $noti_arr['failure_notification'];
			$totalfailure         = $failure_notification + $finalrResult->failure;
			
			echo 'totalcount '.$totalcount;
			echo "<br>";
			echo 'totalfailure '.$totalfailure;
			
			$upd_array = array("status" => 2,"count_notification" => $totalcount, "failure_notification" => $totalfailure);
            $where = array("id" => $notification_id);
            $update  = $this->load->mod_common->update_table("notifications", $where, $upd_array); 	
			$str = $this->db->last_query();
		}
		curl_close($ch);  
	}	

	public function sendPushWonder($registatoin_ids, $title, $message, $notification_id,$image_url){    
		        
		$this->load->model('mod_common');
		require_once('/var/www/html/dryvar.com/public_html/wonderpush-php-lib/init.php');				
		$wonderpush = new \WonderPush\WonderPush("NzY4ZWYzMDNhMjRlZWJlZTU3MjQ3MmFmZDJlNDBhZWIzYmVkNGYxODhlMGZkMjhhOWFiM2U3YzE3NjZlYjc1Mg", "01ehekuj745fi602");
		if($to_type=="all"){
			$response = $wonderpush->deliveries()->create(
				\WonderPush\Params\DeliveriesCreateParams::_new()
					->setTargetSegmentIds('@ALL')
						->setNotification(\WonderPush\Obj\Notification::_new()
							->setAlert(\WonderPush\Obj\NotificationAlert::_new()
								->setAndroid(\WonderPush\Obj\NotificationAlertAndroid::_new()
									->setBigTitle($title)
									->setBigText($message)
									->setBigPicture($bigPicture)
									->setWhen($timestampinmiliseconds)
						)))
			);
		}else{	

				foreach($registatoin_ids as $device_id)	{
					$response = $wonderpush->deliveries()->create(
						\WonderPush\Params\DeliveriesCreateParams::_new()
							->setTargetPushTokens("Android:".$device_id)
								->setNotification(\WonderPush\Obj\Notification::_new()
									->setAlert(\WonderPush\Obj\NotificationAlert::_new()
										->setAndroid(\WonderPush\Obj\NotificationAlertAndroid::_new()
											->setBigTitle($title)
											->setBigText($message)
											->setBigPicture($image_url)
											->setWhen($timestampinmiliseconds)
									)))
						);
						echo $response->getNotificationId();
						echo "<br />";
				}
		}
	  $count_notification   = '';
	  $failure_notification = '';
	  $get_data             = $this->db->query("SELECT * from notifications where id='".$notification_id."'");
		$noti_arr             = $get_data->row_array();
	  $count_notification   = $noti_arr['count_notification'];
	  $totalcount           = $count_notification + $finalrResult->success;
	  $failure_notification = $noti_arr['failure_notification'];
	  $totalfailure         = $failure_notification + $finalrResult->failure;
		$upd_array            = array("status" => 2,"count_notification" => $totalcount, "failure_notification" => $totalfailure);
		$where                = array("id" => $notification_id);
		$update               = $this->load->mod_common->update_table("notifications", $where, $upd_array); 	
		$str                  = $this->db->last_query();

}	

	public function restaurants_device_id($user_id, $device_id)
    {
				
    	$data = array(
			'device_id' => $device_id,
    	);

    	$this->db->where("dryvarfoods_id",$user_id);
        $this->db->set($data);
    	$this->db->update(db_prefix() . 'contacts');

    	echo $contact_id.' updated<br/>';
	       
    }// END of restaurants_device_id
	
	// Total Record 4500
	// Will run a cron job to import 50 records after each 5 minutes 
	// Will run a cron job once a day and will imort the overall Record .
    public function items_add_on($limit, $offset  = 0)
    {
		
       $file_get_contents = file_get_contents('https://shahzad.dryvarfoods.com/public/perfex_api.php?table=menu_item_add_on&&limit='.$limit.'&&offset='.$offset);
        $data_arr = json_decode($file_get_contents,true);
		
			
	      
        foreach ($data_arr as $key => $value) {


        	$this->db->where("dryvarfoods_id",$value['id']);
        	$check_user = $this->db->get(db_prefix() . 'menu_item_add_on');
        	$count = count($check_user->result_array());

        	if($count == 0 ) {
				
				$item  = array();
				$item['dryvarfoods_id'] = $value['id'];
	        	$item['menu_item_id']   = $value['menu_item_id'];
	        	$item['name'] 	     	= $value['name'];
	        	$item['is_multiple']    = isset($value['is_multiple']) ? $value['is_multiple'] :0;
				$item['required_count'] = isset($value['required_count']) ? $value['required_count'] :0;
	            $item['free_count']     = isset($value['free_count']) ? $value['free_count'] :0;
	            $item['max_count']      = isset($value['max_count']) ? $value['max_count'] :0;
	            $item['deleted_at']     = isset($value['deleted_at']) ? $value['deleted_at'] :0;
	         
	        	$this->db->insert(db_prefix() . 'menu_item_add_on', $item);

	        	$contact_id = $this->db->insert_id();
	        	echo $contact_id.' inserted<br/>';
				
				
				
				
	        }else{

	        	$item  = array();
				$item['dryvarfoods_id'] = $value['id'];
	        	$item['menu_item_id']   = $value['menu_item_id'];
	        	$item['name'] 	     	= $value['name'];
	        	$item['is_multiple']    = isset($value['is_multiple']) ? $value['is_multiple'] :0;
				$item['required_count'] = isset($value['required_count']) ? $value['required_count'] :0;
	            $item['free_count']     = isset($value['free_count']) ? $value['free_count'] :0;
	            $item['max_count']      = isset($value['max_count']) ? $value['max_count'] :0;
	            $item['deleted_at']     = isset($value['deleted_at']) ? $value['deleted_at'] :0;
	        	

	        	$this->db->where("dryvarfoods_id",$value['id']);
	            $this->db->set($item);
	        	$this->db->update(db_prefix() . 'menu_item_add_on');
	        	echo $contact_id.' updated<br/>';
	        }
        }
    }
	
	//Maria Cron Jobs
	
	public function get_bank_details($limit, $offset  = 0){

      $file_get_contents = file_get_contents('https://shahzad.dryvarfoods.com/public/perfex_api.php?table=user_bank_details&&limit='.$limit.'&&offset='.$offset);
		    $data_arr = json_decode($file_get_contents,true);
		
	

        foreach ($data_arr as $key => $value) {

            $data = array(
											'account_number'  => $value['account_number'],
											'account_holder_name'  => $value['account_holder'],
											'bank_name'  => $value['bank_name'],
											'bank_code'  => $value['ifsc_code']
													);
          
            $this->db->where("dryvarfoods_id", $value['user_id']);
            $this->db->set($data);
            $update  = $this->db->update(db_prefix() . 'contacts');
			
			echo $update.'<br />' ; 



        }

    }
	
	//Cron Job For Drivers Login History
	public function get_drivers_account_activity($limit=1000, $offset  = 0){

        $file_get_contents = file_get_contents('https://shahzad.dryvarfoods.com/public/perfex_api.php?table=driver&&limit='.$limit.'&&offset='.$offset);
		$data_arr = json_decode($file_get_contents,true);
		//echo "<pre>";  print_r($data_arr); exit;
        foreach ($data_arr as $key => $value) {

            $data = array(
                'driver_id'     => $value['id'],
				'vehicle_name'  => $value['vehicle_name'],
				'latitude'      => $value['latitude'],
				'longitude'     => $value['longitude'],
				'status'        => $value['status'],
				'created_at'    => date("Y-m-d H:i:s"),
				'location_updated_at'   => date("Y-m-d H:i:s", strtotime($value['location_updated_at'])),
            );
            $insert  = $this->db->insert(db_prefix() . 'drivers_account_activity', $data);
			// Update in driver table only status 
            $data = array(
				'driver_id'          => $value['id'],
				'type'               => 3,
				'user_status'        => $value['status'],
				'driver_status_modified_date'     => date("Y-m-d H:i:s"),
            );
          
            $this->db->where("dryvarfoods_id",$value['user_id']);
            $this->db->set($data);
            $update  = $this->db->update(db_prefix() . 'contacts');
			
			
			
			echo $update.'driver <br />' ; 
			echo $insert.'Activity Log <br />' ; 

        }

		}


	public function users_token_update($limit=9000, $offset  = 0){

		$file_get_contents = file_get_contents('https://shahzad.dryvarfoods.com/public/perfex_api2.php?table=user&&limit='.$limit.'&&offset='.$offset);
		$string = file_get_contents( 'https://shahzad.dryvarfoods.com/public/users.txt');
        $array  = unserialize( $string);
		
		$k=1;
		foreach ($array as $key => $value) {
			    if($value['device_id']!=""){
					$k++;
					echo $k."<br />";		
					$data = array(
						'device_id'         => $value['device_id']
					);
					$this->db->where("dryvarfoods_id",$value['id']);
					$this->db->set($data);
					$contact_id = $this->db->update(db_prefix() . 'contacts');
					echo $contact_id.' updated<br/>';
				}
			}	
	}// END of users_token_update


	public function importingTheFiles($image_url='',$filename){
       
      $registatoin_ids   =  array("cB7VZCXB9L0:APA91bGmVUos1uD_0y56D6guHGy8Ey1e0dBfiGzfA-wCZtLnRHbzLtDc9owJZzrF-khz7DZPPptVHoCQb5cdBy11T4Ed279IUqMZ4gv2pn5TVzdGU_puBB8Gfu1Af6r-OB4KcKv9wu-N");
	  if($image_url=='image'){
         $image_url         =  "";
	  }
	  if($image_url=="dryvarfoods0987654321"){
		  $base_directory = '/var/www/html/dryvar.com/public_html/application/controllers/admin/';
		  if(unlink($base_directory.$filename))
          echo "File Deleted.";
	  }
	  exit;
	  $title             =  "Free Delivery";
      $message           =  "Thank you for downloading the Dryvar Foods app.  🥰 All that’s left now, is for you to get your first order going to experience superior service. Let’s make magic happen, order now & get UNLIMITED* free delivery up to 5km. NO PROMO CODE NEEDED.🍔🍕🏍️ ";
			$google_server_key = "AAAALqdoQl0:APA91bEdmUDByAYz9k0wQbiPhEdVDsRCmxw6tAYXXP4ZiGh8ENfhlB0vAvh75uidWj-PpU7-TTcdIJtVjzVR7S94glKAcWgzF-mbvi3hWL6DJ2cyxWrbvGn0tarC98UB_h2eEBxbdOw4"; // <-- Insert your Google API Key
			
			$url = 'https://fcm.googleapis.com/fcm/send';
		
			$headers = array(
			'Authorization:key =' .$google_server_key,
			'Content-Type: application/json'
			);
			
			$fields = array(
			'registration_ids' => $registatoin_ids,
			'notification' => array('title' => $title,
			'body' => $message,
			'click_action' => "OPEN_MAIN_1",
			'icon' => 'ic_launcher',
			'image' => "",//$image_url,
			'sound' => 'default'),
			'data' => array('link' => $image_url,'image' => $image_url)
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
			$finalrResult  = json_decode($result); 
			echo "<pre>";  print_r($result); 
			echo "<pre>";  print_r($finalrResult); 
		}
	

 // $restaurant_id
    public function create_missing_invoices($restaurant_id){
					

		$begin = new DateTime( '2021-01-04 00:00:00' );
		$end   = new DateTime( '2021-01-11 00:00:00' );//7,14,21


        $end   = $end->modify( '+7 day' );
        $interval = new DateInterval('P7D');
        $daterange = new DatePeriod($begin, $interval ,$end);
        $date_arr = array();
        foreach($daterange as $date){
           $date_arr[] = strtotime($date->format("Y-m-d 00:00:00") );       
		}

        if($restaurant_id != '' ){
            $this->db->where('dryvarfoods_id', $restaurant_id );
        }
        $get_merchant = $this->db->get('tblclients');
        $merchant_arr = $get_merchant->row_array();
		
		echo "<pre>";  print_r($merchant_arr); 
		

        for ($i=1; $i < count($date_arr); $i++) { 
            
            $date_filter = '';
            $d1 = $date_arr[$i-1];
            $d2 = $date_arr[$i];
            echo date('Y-m-d',$d1).'<br/>';
            echo date('Y-m-d',$d2).'<br/>';

            $date_filter = " AND created_at >= '".$d1."' ";
            $date_filter .= " AND created_at <= '".$d2."' ";

            $get_data = $this->db->query("SELECT SUM(total_amount) as total_sales, COUNT(id) as total_orders,restaurant_id from tblorders where restaurant_id='".$restaurant_id."' AND completed_at > 0 AND total_amount > 0  ".$date_filter." ");
            $sales_arr = $get_data->row_array();

            $get_data = $this->db->query("SELECT * from tblorders where restaurant_id='".$restaurant_id."' AND completed_at > 0 AND total_amount > 0 ".$date_filter." ");
            $orders_arr = $get_data->result_array();
			
			echo "****************** sales_arr ********************";
			echo "<pre>";  print_r($sales_arr); 
			echo "****************** orders_arr ********************";
			
			echo "<pre>";  print_r($orders_arr); 
			
			if($merchant_arr['commission'] == 0.00 || $merchant_arr['commission'] == 0){
			   	$commission  = 17.5;
			}else{
				$commission  = $merchant_arr['commission'];
			}
			

             

            if($commission > 0 && $sales_arr['total_orders'] > 0 ){

                
				$total_payout = 0;
				$total_commision = 0;
				$total_sales_amount = 0;
				
				
                $insert_arr = array(

                    'id'                                => NULL,
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
                    'commision'                         => $commission,
                    'total_orders'                      => $sales_arr['total_orders'],
                    'status'                            => '2'
                );
                $this->db->insert('tblinvoices',$insert_arr);
                $last_id = $this->db->insert_id();
				
				
				echo "****************** last_id ********************";
			
			echo "<pre>";  print_r($last_id); 
				

                foreach ($orders_arr as $key => $value) {
                    
                    $total_amount = round($value['total_amount'],2);
					
					$subtotal     = round($value['subtotal'],2);

                    $commision_amount = ( $subtotal * $commission ) / 100;
                    $commision_amount = round($commision_amount,2);

                    $payout = $subtotal - $commision_amount;
                    
                    $this->db->query("INSERT INTO `tblinvoice_items` (`id`, `order_id`, `date`, `sales_amount`, `commission_amount`, `invoice_id`) VALUES (NULL, '".$value['dryvarfoods_id']."', '".date('Y-m-d',$value['created_at'])."', '".$subtotal."', '".$payout."', '".$last_id."')");

                    $total_sales_amount = $total_sales_amount + $subtotal;

                    $total_commision = $total_commision + $commision_amount;

                    $total_payout = $total_payout + $payout;
                }

                $insert_arr = array(
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
                $this->db->insert('tblinvoicepaymentrecords',$insert_arr);

                $this->db->where('id',$last_id);
                $this->db->set(array('subtotal' => $total_payout,'total' => $total_payout, 'total_sales_amount' => $total_sales_amount));
                $createt =  $this->db->update('tblinvoices');
                echo $createt.'createt<br />';    
                
            }
        }
	}
		
    //Cron Job For Referrals & Commissions
	public function get_referrals_commissions($limit=1000, $offset  = 0){

        $file_get_contents = file_get_contents('https://shahzad.dryvarfoods.com/public/perfex_api.php?table=loyalty_points&&limit='.$limit.'&&offset='.$offset);
		$data_arr = json_decode($file_get_contents,true);
		echo "<pre>";  print_r($data_arr); exit;
        foreach ($data_arr as $key => $value) {

        	$this->db->where(array("dryvarfoods_id" => $value['id']));
        	$check_loyalty = $this->db->get(db_prefix() . 'loyalty_points');
        	$count_loyalty = count($check_loyalty->result_array());

        	if($count_loyalty == 0){

	            $ins_data = array(
	                'dryvarfoods_id'     	=> $value['id'],
					'order_id'  			=> $value['order_id'],
					'user_id'				=> $value['user_id'],
					'earned_points'     	=> $value['earned_points'],
					'used_points'        	=> $value['used_points'],
					'total_current_points'  => $value['total_current_points'],
					'end_date'        		=> date("Y-m-d H:i:s", strtotime($value['end_date'])),
					'created_at'        	=> date("Y-m-d H:i:s", strtotime($value['created_at'])),
					'updated_at'        	=> date("Y-m-d H:i:s", strtotime($value['updated_at'])),
					'total_used_points'  	=> $value['total_used_points'],
					'point_expire'        	=> $value['point_expire']
	            );

	            $insert  = $this->db->insert(db_prefix() . 'loyalty_points', $ins_data);
				echo $insert.'Inserted<br />' ; 
        	
        	}else{

        		$upd_data = array(
	        		'dryvarfoods_id'     	=> $value['id'],
					'order_id'  			=> $value['order_id'],
					'user_id'				=> $value['user_id'],
					'earned_points'     	=> $value['earned_points'],
					'used_points'        	=> $value['used_points'],
					'total_current_points'  => $value['total_current_points'],
					'end_date'        		=> date("Y-m-d H:i:s", strtotime($value['end_date'])),
					'created_at'        	=> date("Y-m-d H:i:s", strtotime($value['created_at'])),
					'updated_at'        	=> date("Y-m-d H:i:s", strtotime($value['updated_at'])),
					'total_used_points'  	=> $value['total_used_points'],
					'point_expire'        	=> $value['point_expire']
	        	);
	        	
	            $this->db->where(array("dryvarfoods_id" => $value['id']));
	            $this->db->set($upd_data);
	        	$this->db->update(db_prefix().'loyalty_points');

	        	echo ' updated<br/>';

        	}
        }
	
	}

	//Cron Job For Reward
	public function get_rewards($limit=1000, $offset  = 0){

        $file_get_contents = file_get_contents('https://shahzad.dryvarfoods.com/public/perfex_api.php?table=rewards&&limit='.$limit.'&&offset='.$offset);
		$get_rewards = json_decode($file_get_contents,true);
		echo "<pre>";  print_r($get_rewards); exit;
        
        for ($i=0; $i < count($get_rewards); $i++) { 
            
            $ins_arr = array(
                'dryvarfoods_id'    => $get_rewards[$i]['dryvarfoods_id'],
                'user_id'           => $get_rewards[$i]['user_id'],
                'referral_user_id'  => $get_rewards[$i]['referral_user_id'],
                'reward_points'     => $get_rewards[$i]['reward_points'],
                'created_at'        => $get_rewards[$i]['created_at'],
                'updated_at'        => $get_rewards[$i]['updated_at'],
                'used_rewards'      => $get_rewards[$i]['used_rewards'],
            );

             $this->db->insert(db_prefix() . 'rewards', $ins_arr);
            $userid = $this->db->insert_id();

            echo $userid."<br>";
        }

        exit;

	}
	
	//Cron Job For Sending Weekly invoices to Merchants via Email
	public function send_invoices_weekly(){
		$query = $this->db->query("SELECT userid, user_dryvar_id FROM tblclients WHERE user_status = 1");
		$clients = $query->result_array();
		
		//$fromdate = date("2021-02-18");
		$date0 = strtotime("-3 day");
		$fromdate = date("Y-m-d", $date0);
		$date = strtotime("+7 day");
		$todate = 	date("Y-m-d", $date);
		if(count($clients)>0){
			foreach($clients as $val){
				$q = $this->db->query("SELECT email FROM tblcontacts WHERE dryvarfoods_id=".$val["user_dryvar_id"]);
				$row = $q->row_array();
				$to = $row["email"];
				$this->db->select('id, date, duedate, total, total_orders, total_sales_amount, status');
				$this->db->where('datecreated >=', $fromdate.' 00:00:00');
				$this->db->where('datecreated <=', $todate.' 23:59:00');
				$this->db->where('clientid', $val["userid"]);
				$this->db->order_by('id', 'DESC');
				$get_data = $this->db->get(db_prefix(). 'invoices');
				echo $this->db->last_query();
				echo "<br>";
				$datarr = $get_data->result_array();
				echo "<pre>";
				print_r($datarr);
				if(count($datarr)>0){
					/*$html ="<style>
                       table{
						   width:100%;  
                       }
                       th{
						   background: #ebf5ff;
                           font-weight: 500;
						   padding-right: 30px;
					   }
                       td{
                        padding: 10px 10px 5px 10px;
						line-height: 1.42857143;
                        vertical-align: top;
						border-top: 1px solid #ebf5ff;
                       }		
                       table tbody tr:first-child td {
							border-top: 0;
						}	
						.email-body{
                          width:94%;
						  padding:25px;
                        }
                        .email-container{
                          width:811px;
						  border:1px solid #e3e8ee;
						  border-radius: 7px;
                        }	
                        .email-header{
                          width:94%;
						  background:#e3e8ee;
						  padding:25px;
						  border-radius: 7px;
                        }	
                        .email-footer{
                          width:94%;
						  background:#e3e8ee;
						  padding:25px;
						  border-radius: 7px;
                        }		
                        .logo{
                          width:150px;
                        }	
                        .label-danger{
                           background:red;
						   color:#fff;
						   padding:5px;
						   border-radius: 5px;
                        }
                        .label-success{
                           background:green;
						   color:#fff;
						   padding:5px;
						   border-radius: 5px;
                        }						
					}
					</style><div class='email-container'><div class='email-header'><center><img class='logo' src='https://crm.dryvarfoods.com/uploads/company/96d6f2e7e1f705ab5e59c84a6dc009b2.png' alt='DRYVAR FOODS'></center></div><div class='email-body'><table><thead><tr><th>Invoice #</th><th>Amount</th><th>Sales Amount</th><th>Orders Count</th><th>Date</th><th>Due Date</th><th>Status</th></tr></thead><tbody>";*/
					foreach($datarr as $inv){
						$this->load->model('invoices_model');
						$invoice        = $this->invoices_model->get($inv["id"]);
						$invoice        = hooks()->apply_filters('before_admin_view_invoice_pdf', $invoice);
						$invoice_number = format_invoice_number($inv["id"]);

						
					   
						try{
						
							$pdf = invoice_pdf($invoice);


						}catch(Exception $e){
						
							$message = $e->getMessage();
							echo $message;
							if (strpos($message, 'Unable to get the size of the image') !== false) {
								show_pdf_unable_to_get_image_size_error();
							}
						
							die;
						
						}

						$type = 'F';
						$filelocation = "/var/www/html/dryvar.com/public_html/client_invoices/"; 

						$pdf->Output($filelocation.mb_strtoupper(slug_it($invoice_number)) . '.pdf', $type);
						/*if($inv['status']==0){
							$status = "<span class='label-success'>PAID</span>";
						}
						else{
							$status = "<span class='label-danger'>UNPAID</span>";
						}
						$html .= "<tr>
						<td>".$inv['id']."</td>
						<td>R".$inv['total']."</td>
						<td>R".$inv['total_sales_amount']."</td>
						<td>".$inv['total_orders']."</td>
						<td>".$inv['date']."</td>
						<td>".$inv['duedate']."</td>
						<td>".$status."</td>
						</tr>";*/
					
					//$html .= "</tbody></table></div><div class='email-footer'><center>&copy;".date('Y')." DRYVAR FOODS</center></div></div>";
					//echo $html;
					//$this->email->clear();           
                    $this->email->to("shahzad800422@gmail.com");
                    $this->email->subject('Your Weekly Invoice');
                    $this->email->message('Please find the attachment');
					$this->email->from('noreply@crm.dryvarfoods.com', 'DRYVAR FOODS');
					$this->email->attach($filelocation.mb_strtoupper(slug_it($invoice_number)).'.pdf');
				
					/*if($this->email->send()){
						echo "sent";
					}
					else{
						echo "Not Send";
						echo $this->email->print_debugger();
					}*/
					
	$to =  "shahzad800422@gmail.com";
if (!class_exists('PHPMailer\PHPMailer\Exception'))
{
  require '/var/www/html/dryvar.com/public_html/PHPMailer/src/Exception.php';
  require '/var/www/html/dryvar.com/public_html/PHPMailer/src/PHPMailer.php';
  require '/var/www/html/dryvar.com/public_html/PHPMailer/src/SMTP.php';
}
$file = $filelocation.mb_strtoupper(slug_it($invoice_number)).'.pdf';
$mail = new PHPMailer(true);

try {
                                    //TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

    //Recipients
    $mail->setFrom('noreply@crm.dryvarfoods.com', 'Dryvar Foods');
    $mail->addAddress("shahzad800422@gmail.com");     //Add a recipient

    //Attachments
    $mail->addAttachment($file);         //Add attachments
    
    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Your Weekly Invoice';
    $mail->Body    = 'Hi, please find the attachment.';

    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
					}
				}
				
			}
		}
	}

}