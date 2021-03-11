<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Cron_import_data extends App_Controller
{	
	public function restaurants($offset = 0)
    {
        $file_get_contents = file_get_contents('https://shahzad.dryvarfoods.com/public/perfex_api.php?table=restaurant&&limit=1000&&offset='.$offset);

        $data_arr = json_decode($file_get_contents,true);
		
		
		
			

        foreach ($data_arr as $key => $value) {

        	$this->db->where("dryvarfoods_id",$value['id']);
        	$check_user = $this->db->get(db_prefix() . 'clients');
        	$count = count($check_user->result_array());
        	
        	if($count == 0 ) {

	        	$data = array(
	        		'userid' 			=> '',
	        		'dryvarfoods_id' 	=> $value['id'],
	        		'company' 		     => $value['name'],
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
                    'user_dryvar_id'    => $value['user_id']
	        	);


	            $this->db->where("dryvarfoods_id",$value['id']);
	            $this->db->set($data);
	        	$this->db->update(db_prefix() . 'clients');

	        	echo $value['name'].' updated<br/>';
	        }
        }
    }
    public function users($offset  = 0)
    {
        $file_get_contents = file_get_contents('https://shahzad.dryvarfoods.com/public/perfex_api.php?table=user&&limit=1000&&offset='.$offset);
        $data_arr = json_decode($file_get_contents,true);
		
	   
		

        foreach ($data_arr as $key => $value) {

        	$this->db->where("dryvarfoods_id",$value['id']);
        	$check_user = $this->db->get(db_prefix() . 'contacts');
        	$count = count($check_user->result_array());
        	
        	if($count == 0 ) {

	        	$data = array(
	        		'id' 				=> '',
	        		'userid' 			=> '',
	        		'dryvarfoods_id' 	=> $value['id'],
	        		'firstname' 		=> $value['name'],
	        		'lastname' 			=> '',
	        		'email' 			=> $value['email'],
	        		'phonenumber' 		=> $value['mobile_number'],

	        	);

	        	$data['email_verified_at'] 	= date('Y-m-d H:i:s');
	        	$data['datecreated'] 		= date('Y-m-d H:i:s');
	        	$data['is_primary'] 		= 0;
	        	$data['invoice_emails']     = isset($data['invoice_emails']) ? 1 :0;
	            $data['estimate_emails']    = isset($data['estimate_emails']) ? 1 :0;
	            $data['credit_note_emails'] = isset($data['credit_note_emails']) ? 1 :0;
	            $data['contract_emails']    = isset($data['contract_emails']) ? 1 :0;
	            $data['task_emails']        = isset($data['task_emails']) ? 1 :0;
	            $data['project_emails']     = isset($data['project_emails']) ? 1 :0;
	            $data['ticket_emails']      = isset($data['ticket_emails']) ? 1 :0;

	            echo '<pre>';
	            print_r($data);

	        	$this->db->insert(db_prefix() . 'contacts', $data);
	        	$contact_id = $this->db->insert_id();
	        	echo $contact_id.' '.$value['email'].' inserted<br/>';
	        }else{

	        	$data = array(

	        		'firstname' 		=> $value['name'],
	        		'lastname' 			=> '',
	        		'email' 			=> $value['email'],
	        		'phonenumber' 		=> $value['mobile_number'],
	        		'type' 				=> $value['type']

	        	);

	        	$this->db->where("dryvarfoods_id",$value['id']);
	            $this->db->set($data);
	        	$this->db->update(db_prefix() . 'contacts');

	        	echo $contact_id.' '.$value['email'].' updated<br/>';
	        }
        }
    }

    public function orders($offset  = 0 )
    {
        $file_get_contents = file_get_contents('https://shahzad.dryvarfoods.com/public/perfex_api.php?table=order&&limit=1000&&offset='.$offset);
        $data_arr = json_decode($file_get_contents,true);
          //echo "<pre>";  print_r($data_arr); exit;
	        
        foreach ($data_arr as $key => $value) {

        	$this->db->where("dryvarfoods_id",$value['id']);
        	$check_user = $this->db->get(db_prefix() . 'orders');
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
        		$ins_arr['currency_code']   = (string) $ins_arr['currency_code'];
        		$ins_arr['declined_at'] 	= strtotime($ins_arr['declined_at']);
        		$ins_arr['accepted_at'] 	= strtotime($ins_arr['accepted_at']);
        		$ins_arr['cancelled_at'] 	= strtotime($ins_arr['cancelled_at']);
        		$ins_arr['delivery_at'] 	= strtotime($ins_arr['delivery_at']);
        		$ins_arr['completed_at'] 	= strtotime($ins_arr['completed_at']);
        		$ins_arr['created_at'] 		= strtotime($ins_arr['created_at']);
        		$ins_arr['updated_at'] 		= strtotime($ins_arr['updated_at']);

	        	$this->db->insert(db_prefix() . 'orders', $ins_arr);
	        	 $error = $this->db->error();
				 echo "sadfsdf";
				 //echo "<pre>";  print_r($error);
	        	$contact_id = $this->db->insert_id();
				
				 //echo "<pre>";  print_r($contact_id); exit;
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
        		$ins_arr['currency_code']   = (string) $ins_arr['currency_code'];
        		$ins_arr['declined_at'] 	= strtotime($ins_arr['declined_at']);
        		$ins_arr['accepted_at'] 	= strtotime($ins_arr['accepted_at']);
        		$ins_arr['cancelled_at'] 	= strtotime($ins_arr['cancelled_at']);
        		$ins_arr['delivery_at'] 	= strtotime($ins_arr['delivery_at']);
        		$ins_arr['completed_at'] 	= strtotime($ins_arr['completed_at']);
        		$ins_arr['created_at'] 		= strtotime($ins_arr['created_at']);
        		$ins_arr['updated_at'] 		= strtotime($ins_arr['updated_at']);

	        	$this->db->where("dryvarfoods_id",$value['id']);
	            $this->db->set($ins_arr);
	        	$this->db->update(db_prefix() . 'orders');

	        	echo $contact_id.' updated<br/>';
	        }
        }
    }

    public function order_items($offset  = 0)
    {
        $file_get_contents = file_get_contents('https://shahzad.dryvarfoods.com/public/perfex_api.php?table=order_item&&limit=1000&&offset='.$offset);
        $data_arr = json_decode($file_get_contents,true);
		
	      
        foreach ($data_arr as $key => $value) {


        	$this->db->where("dryvarfoods_id",$value['id']);
        	$check_user = $this->db->get(db_prefix() . 'order_item');
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
        		
         

	        	$this->db->insert(db_prefix() . 'order_item', $ins_arr);

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
	        	$this->db->update(db_prefix() . 'order_item');

	        	echo $contact_id.' updated<br/>';
	        }
        }
    }

    public function menu_items($offset  = 0)
    {
        $file_get_contents = file_get_contents('https://shahzad.dryvarfoods.com/public/perfex_api.php?table=menu_item&&limit=1000&&offset='.$offset);
        $data_arr = json_decode($file_get_contents,true);
		
			
		   
		 	echo "<pre>";  print_r($data_arr); exit;	
	

 

       
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

    public function order_delivery($offset  = 0)
    {
        $file_get_contents = file_get_contents('https://shahzad.dryvarfoods.com/public/perfex_api.php?table=order_delivery&&limit=1000&&offset='.$offset);
        $data_arr = json_decode($file_get_contents,true);

       
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
	        	$this->db->update(db_prefix() . 'order_delivery');

	        	echo $contact_id.' updated<br/>';
	        }
        }
    }

    public function update_delivery_addresses(){


    	$this->db->where("updated",0);;
        $get_data = $this->db->get(db_prefix() . 'order_delivery');
        $data_arr = $get_data->result_array();

        foreach ($data_arr as $key => $value) {
        	
        	if ($value['drop_location'] != '' ) {
        		
        		echo $url = "https://maps.googleapis.com/maps/api/geocode/json?address=".$value['drop_location']."&key=AIzaSyD23KCr6R1exd3k1bj-L6yq-EEXPLOm2UA";
        		$curl = curl_init();

				curl_setopt_array($curl, array(
				  CURLOPT_URL => $url,
				  CURLOPT_RETURNTRANSFER => true,
				  CURLOPT_ENCODING => "",
				  CURLOPT_MAXREDIRS => 10,
				  CURLOPT_TIMEOUT => 0,
				  CURLOPT_FOLLOWLOCATION => true,
				  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				  CURLOPT_CUSTOMREQUEST => "GET",
				));

				$response = curl_exec($curl);

				curl_close($curl);
				echo $response;

        		//print_r(json_decode($address_data));
        		
        	}
        }

    }

    public function user_address($offset  = 0){

        $file_get_contents = file_get_contents('https://shahzad.dryvarfoods.com/public/perfex_api.php?table=user_address&&limit=1000&&offset='.$offset);


        $data_arr = json_decode($file_get_contents,true);

        foreach ($data_arr as $key => $value) {

            $data = array(

                'city'  => $value['city'],
                'state' => $value['state'],
                'zip'   => $value['postal_code'],
                'address' => $value['address']

            );
            echo $value['user_id'];
            echo '<pre>';
            print_r($data);

            $this->db->where("user_dryvar_id",$value['user_id']);
            $this->db->set($data);
            $this->db->update(db_prefix() . 'clients');


            $this->db->where("user_dryvar_id",$value['user_id']);
            $get_restaurant = $this->db->get(db_prefix() . 'clients');
            $restaurant_arr = $get_restaurant->row_array();

            $data = array(

                'city'  => $value['city']

            );

            $this->db->where("restaurant_id",$restaurant_arr['dryvarfoods_id']);
            $this->db->set($data);
            $this->db->update(db_prefix() . 'orders');



        }

    }

    
    
	
	
	public function get_payouts($offset  = 0){

        $file_get_contents = file_get_contents('https://shahzad.dryvarfoods.com/public/perfex_api.php?table=driver&&limit=1000&&offset='.$offset);


        $data_arr = json_decode($file_get_contents,true);

        foreach ($data_arr as $key => $value) {

            $data = array(

                'driver_id'  => $value['id']

            );
            echo $value['user_id'];
            echo '<pre>';



            $this->db->where("dryvarfoods_id",$value['user_id']);
            $get_restaurant = $this->db->get(db_prefix() . 'contacts');
            $restaurant_arr = $get_restaurant->row_array();



        }

    }
	
	public function driversUpdate($offset  = 0){
		
		
		echo "asdfsadf";   exit;

        $file_get_contents = file_get_contents('https://shahzad.dryvarfoods.com/public/perfex_api.php?table=driver&&limit=1000&&offset='.$offset);
        $data_arr = json_decode($file_get_contents,true);

        foreach ($data_arr as $key => $value) {

            $data = array(

                'driver_id'  => $value['id']

            );
            echo $value['user_id'];
            echo '<pre>';



            $this->db->where("dryvarfoods_id",$value['user_id']);
            $get_restaurant = $this->db->get(db_prefix() . 'contacts');
            $restaurant_arr = $get_restaurant->row_array();



        }

    }



}