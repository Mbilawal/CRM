<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once('recombee/autoload.php');
use Recombee\RecommApi\Client;
use Recombee\RecommApi\Requests as Reqs;
use Recombee\RecommApi\Exceptions as Ex;

class Recombee extends CI_Controller {

	public function __construct(){

		error_reporting(E_ALL);
		ini_set('display_errors', E_ALL);

		parent::__construct();
	}

	public function index(){

		$client_id 		= $this->config->item('recombee_id2');
		$client_secret 	= $this->config->item('recombee_secret2');

		$client = new Client($client_id, $client_secret);
		
		//Add Item and value
		$add_item = new Reqs\SetItemValues("20",
		    // values
		    [
		      "title" => "Television TV2305"
		    ],
		    //optional parameters
		    [
		      "cascadeCreate" => true
		    ]
		);


		//Add user and value
		$add_user = new Reqs\SetUserValues('20', 			
			[ //optional parameters:
			  'name' => 'Testing'
			],

			[ //optional parameters:
			  'cascadeCreate' => true
			]
		);


		//add detail item to user
		$add_user_item = new Reqs\AddDetailView("20", "11", 
				[
					'timestamp' => "2014-07-20T02:49:45+02:00",
					'cascadeCreate' => true
				]
			);

		//add purchases for user to an item
		$add_purchase = new Reqs\AddPurchase('10108', '3865', 
				[ //optional parameters:
				  'timestamp' => '2020-11-20T02:49:45+02:00',
				  'cascadeCreate' => true,
				  'recommId' => '766c383448da900c22e3d420ccfbb08c'
				]
			);


		$recommended_scenario = new Reqs\RecommendItemsToUser('10108', '5', ['scenario' => 'cross_sale_item']);
		$recommended_scenario2 = new Reqs\RecommendItemsToUser('10108', '5', ['scenario' => 'future_item_recommends']);
		$recommended_scenario3 = new Reqs\RecommendItemsToUser('10108', '5', ['scenario' => 'item_recommended']);
		$response = $client->send($recommended_scenario);

		echo "<pre>";
		print_r($response);
		exit;
	
	}

	public function upload_user_purchase(){

        $query = $this->db->query("SELECT tblcontacts.firstname,tblorders.dryvarfoods_id as order_id,tblorders.user_id,COUNT(tblorders.user_id) as total_orders FROM tblorders LEFT JOIN tblcontacts ON tblorders.user_id = tblcontacts.dryvarfoods_id GROUP BY tblorders.user_id ORDER BY user_id desc");
        $data_arr = $query->result_array();

        echo "<pre>";
        print_r($data_arr);
        exit;

        $item_arr = array();
        $user_arr = array();

        for ($i=0; $i < count($data_arr); $i++) { 
			
        	if($data_arr[$i]['total_orders'] > 0){

        		$user_id = $data_arr[$i]['user_id'];

				$this->db->where(array('user_id' => $user_id));
				$get_order_arr = $this->db->get('tblorders');
				$order_arr = $get_order_arr->result_array();

				for ($j=0; $j < count($order_arr); $j++) { 
					
		        	$get_menu = $this->db->query("SELECT * FROM tblorder_item where order_id='".$order_arr[$j]['dryvarfoods_id']."'");
		            $order_item = $get_menu->row_array();

		            $get_item = $this->db->query("SELECT * FROM tblmenu_item where id='".$order_item['menu_item_id']."'");
		            $item_arr = $get_item->row_array();
		            
		            if($item_arr['dryvarfoods_id'] != ""){

		            	// $created_date = gmdate("Y/m/d H:i:s",$order_arr[$j]['datecreated']);
		            	$created_date = date("M d,Y H:i:s", $order_arr[$j]['created_at']);

			      		$request = new Reqs\AddPurchase($user_id, $item_arr['dryvarfoods_id'], 
							[ 
								//optional parameters:
								'cascadeCreate' => true,
								'price' => $item_arr['price'],
								'recommId' => '7e7f144bd287d61aba949fedcdde5616',
								'timestamp' => $created_date
							]
						);
			      		array_push($user_arr, $request);

		            }
				}
        	}
        }

        $client_id 		= $this->config->item('recombee_id2');
		$client_secret 	= $this->config->item('recombee_secret2');

		$client = new Client($client_id, $client_secret);
        $res = $client->send(new Reqs\Batch($user_arr)); //Use Batch for faster processing of larger data

        echo "<pre>";
        print_r($res);
        exit;

	}

	public function upload_user(){

		// $query = $this->db->query("SET GLOBAL sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''))");

        $query = $this->db->query("SELECT tblcontacts.firstname,tblcontacts.zip,tblcontacts.datecreated,tblorders.dryvarfoods_id as order_id,tblorders.user_id,COUNT(tblorders.user_id) as quantity FROM tblorders LEFT JOIN tblcontacts ON tblorders.user_id = tblcontacts.dryvarfoods_id GROUP BY tblorders.user_id ORDER BY user_id desc");
        $data_arr = $query->result_array();

        // echo "<pre>";
        // print_r($data_arr);
        // exit;

        $user_arr = array();
        for ($i=0; $i < count($data_arr); $i++) { 
	      	
        	// $created_date = gmdate("Y/m/d H:i:s",$item_data[$i]['datecreated']);
        	$created_date = date("M d,Y H:i:s", strtotime($data_arr[$i]['datecreated']));

			$add_user = new Reqs\SetUserValues($data_arr[$i]['user_id'], 
				
				[ //optional parameters:
				  'name' 		=> $data_arr[$i]['firstname'],
				  'timestamp' 	=> $created_date,
				  'zip_code' 	=> $data_arr[$i]['zip'],
				],

				[ //optional parameters:
				  'cascadeCreate' => true
				]
			);		            

      		array_push($user_arr, $add_user);
        }
           
        $client_id 		= $this->config->item('recombee_id2');
		$client_secret 	= $this->config->item('recombee_secret2');

		$client = new Client($client_id, $client_secret);
        $res = $client->send(new Reqs\Batch($user_arr)); //Use Batch for faster processing of larger data

        echo "<pre>";
        print_r($res);
        exit;

	}

	public function upload_item($start){

		// $the_date = strtotime("2010-01-19 00:00:00");
		// echo(date_default_timezone_get() . "<br />");
		// echo(date("Y-d-mTG:i:sz",$the_date) . "<br />");
		// echo(date_default_timezone_set("UTC") . "<br />");
		// echo(date("Y-d-mTG:i:sz", $the_date) . "<br />");
		// exit;

        $get_item = $this->db->query("SELECT * FROM tblmenu_item LIMIT ".$start.", 2000");
        $item_data = $get_item->result_array();

        echo "<pre>";
        print_r($item_data);
        exit;

        $item_arr = array();
        for ($i=0; $i < count($item_data); $i++) { 
      		
        	if($item_data[$i]['status'] == 1){
        		$availability = True;
        	}else{
        		$availability = False;
        	}

        	// $deal_date = gmdate("Y/M/d H:i:s",$item_data[$i]['deal_date']);
        	$deal_date = date("M d,Y H:i:s", strtotime($item_data[$i]['deal_date']));
			
			//Add Item and value
			$add_item = new Reqs\SetItemValues($item_data[$i]['dryvarfoods_id'],
			    // values
			    [
			      "title" 		=> $item_data[$i]['name'],
			      "categories"  => $item_data[$i]['menu_category_id'],
			      "menu_id" 	=> $item_data[$i]['menu_id'],
			      "description" => $item_data[$i]['description'],
			      "Price" 		=> $item_data[$i]['price'],
			      "availability" => $availability,
			      "date"        => $deal_date,
			    ],
			    //optional parameters
			    [
			      "cascadeCreate" => true
			    ]
			);            

      		array_push($item_arr, $add_item);
        }
   
        $client_id 		= $this->config->item('recombee_id2');
		$client_secret 	= $this->config->item('recombee_secret2');

		$client = new Client($client_id, $client_secret);
        $res = $client->send(new Reqs\Batch($item_arr)); //Use Batch for faster processing of larger data

        echo "<pre>";
        print_r($res);
        exit;

	}

	public function get_recommended_item_to_user($user_id){

		$client_id 		= $this->config->item('recombee_id2');
		$client_secret 	= $this->config->item('recombee_secret2');

		$client = new Client($client_id, $client_secret);
		
		$recommended_scenario = new Reqs\RecommendItemsToUser($user_id, '8', ['scenario' => 'item_recommended']);
		$response = $client->send($recommended_scenario);
		$push_arr = array();

		if(!empty($response['recomms'])){
			for ($i=0; $i < count($response['recomms']); $i++) { 
				
	            $get_item = $this->db->query("SELECT * FROM tblmenu_item  where dryvarfoods_id='".$response['recomms'][$i]['id']."'");
	            $item_arr = $get_item->row_array();
	            array_push($push_arr, $item_arr['name']);
			}
		}

		$recomm_str = "";
		if(!empty($push_arr)){
			$recomm_str = implode($push_arr, ',');
		}

		echo $recomm_str;
		exit;

		return $recomm_str;
	
	}

	public function get_recommended_cross_sale_item($user_id){

		$client_id 		= $this->config->item('recombee_id');
		$client_secret 	= $this->config->item('recombee_secret');

		$client = new Client($client_id, $client_secret);
		
		$recommended_scenario = new Reqs\RecommendItemsToUser($user_id, '8', ['scenario' => 'item_recommended']);
		$response = $client->send($recommended_scenario);
		$push_arr = array();

		if(!empty($response['recomms'])){
			for ($i=0; $i < count($response['recomms']); $i++) { 
				
	            $get_item = $this->db->query("SELECT * FROM tblmenu_item  where dryvarfoods_id='".$response['recomms'][$i]['id']."' ");
	            $item_arr = $get_item->row_array();
	            array_push($push_arr, $item_arr['name']);
			}
		}

		$recomm_str = "";
		if(!empty($push_arr)){
			$recomm_str = implode($push_arr, ',');
		}

		echo "<pre>";
		print_r($recomm_str);
		exit;
		return $recomm_str;
	
	}

	public function upload_user_view_detail(){

        $query = $this->db->query("SELECT tblcontacts.firstname,tblorders.dryvarfoods_id as order_id,tblorders.user_id,COUNT(tblorders.user_id) as total_orders FROM tblorders LEFT JOIN tblcontacts ON tblorders.user_id = tblcontacts.dryvarfoods_id GROUP BY tblorders.user_id ORDER BY user_id desc");
        $data_arr = $query->result_array();

        $item_arr = array();
        $user_arr = array();

        for ($i=0; $i < count($data_arr); $i++) { 
			
        	if($data_arr[$i]['total_orders'] > 0){

        		$user_id = $data_arr[$i]['user_id'];

				$this->db->where(array('user_id' => $user_id));
				$get_order_arr = $this->db->get('tblorders');
				$order_arr = $get_order_arr->result_array();

				for ($j=0; $j < count($order_arr); $j++) { 
					
		        	$get_menu = $this->db->query("SELECT * FROM tblorder_item where order_id='".$order_arr[$j]['dryvarfoods_id']."'");
		            $order_item = $get_menu->row_array();

		            $get_item = $this->db->query("SELECT * FROM tblmenu_item where id='".$order_item['menu_item_id']."'");
		            $item_arr = $get_item->row_array();
		            
		            if($item_arr['dryvarfoods_id'] != ""){

		            	$created_date = date("M d,Y H:i:s", $order_arr[$j]['created_at']);

		            	$request = new Reqs\AddDetailView($user_id, $item_arr['dryvarfoods_id'], [ 
		            		//optional parameters:
		            		'recommId' => '7e7f144bd287d61aba949fedcdde5616',
						  	'cascadeCreate' => true,
						  	'timestamp' => $created_date
						]);

			      		array_push($user_arr, $request);
			      		
		            }

				}
        	}
        }

        $client_id 		= $this->config->item('recombee_id2');
		$client_secret 	= $this->config->item('recombee_secret2');

		$client = new Client($client_id, $client_secret);
        $res = $client->send(new Reqs\Batch($user_arr)); //Use Batch for faster processing of larger data

        echo "<pre>";
        print_r($res);
        exit;

	}


	public function upload_user_bookmart_detail(){

        $query = $this->db->query("SELECT tblcontacts.firstname,tblorders.dryvarfoods_id as order_id,tblorders.user_id,COUNT(tblorders.user_id) as total_orders FROM tblorders LEFT JOIN tblcontacts ON tblorders.user_id = tblcontacts.dryvarfoods_id GROUP BY tblorders.user_id ORDER BY user_id desc");
        $data_arr = $query->result_array();

        $item_arr = array();
        $user_arr = array();

        for ($i=0; $i < count($data_arr); $i++) { 
			
        	if($data_arr[$i]['total_orders'] > 0){

        		$user_id = $data_arr[$i]['user_id'];

				$this->db->where(array('user_id' => $user_id));
				$get_order_arr = $this->db->get('tblorders');
				$order_arr = $get_order_arr->result_array();

				for ($j=0; $j < count($order_arr); $j++) { 
					
		        	$get_menu = $this->db->query("SELECT * FROM tblorder_item where order_id='".$order_arr[$j]['dryvarfoods_id']."'");
		            $order_item = $get_menu->row_array();

		            $get_item = $this->db->query("SELECT * FROM tblmenu_item where id='".$order_item['menu_item_id']."'");
		            $item_arr = $get_item->row_array();
		            
		            if($item_arr['dryvarfoods_id'] != ""){

		            	$created_date = date("M d,Y H:i:s", $order_arr[$j]['created_at']);

		            	$request = new Reqs\AddBookmark($user_id, $item_arr['dryvarfoods_id'], [ //optional parameters:
						  'recommId' => '7e7f144bd287d61aba949fedcdde5616',
						  	'cascadeCreate' => true,
						  	'timestamp' => $created_date
						]);

			      		array_push($user_arr, $request);
			      		
		            }

				}
        	}
        }

        $client_id 		= $this->config->item('recombee_id2');
		$client_secret 	= $this->config->item('recombee_secret2');

		$client = new Client($client_id, $client_secret);
        $res = $client->send(new Reqs\Batch($user_arr)); //Use Batch for faster processing of larger data

        echo "<pre>";
        print_r($res);
        exit;

	}


	public function upload_user_cart_detail(){

        $query = $this->db->query("SELECT tblcontacts.firstname,tblorders.dryvarfoods_id as order_id,tblorders.user_id,COUNT(tblorders.user_id) as total_orders FROM tblorders LEFT JOIN tblcontacts ON tblorders.user_id = tblcontacts.dryvarfoods_id GROUP BY tblorders.user_id ORDER BY user_id desc");
        $data_arr = $query->result_array();

        $item_arr = array();
        $user_arr = array();

        for ($i=0; $i < count($data_arr); $i++) { 
			
        	if($data_arr[$i]['total_orders'] > 0){

        		$user_id = $data_arr[$i]['user_id'];

				$this->db->where(array('user_id' => $user_id));
				$get_order_arr = $this->db->get('tblorders');
				$order_arr = $get_order_arr->result_array();

				for ($j=0; $j < count($order_arr); $j++) { 
					
		        	$get_menu = $this->db->query("SELECT * FROM tblorder_item where order_id='".$order_arr[$j]['dryvarfoods_id']."'");
		            $order_item = $get_menu->row_array();

		            $get_item = $this->db->query("SELECT * FROM tblmenu_item where id='".$order_item['menu_item_id']."'");
		            $item_arr = $get_item->row_array();
		            
		            if($item_arr['dryvarfoods_id'] != ""){

		            	$created_date = date("M d,Y H:i:s", $order_arr[$j]['created_at']);

						$request = new Reqs\AddCartAddition($user_id, $item_arr['dryvarfoods_id'], [ //optional parameters:
						  'recommId' => '7e7f144bd287d61aba949fedcdde5616',
						  	'cascadeCreate' => true,
						  	'timestamp' => $created_date
						]);


			      		array_push($user_arr, $request);
			      		
		            }

				}
        	}
        }

        $client_id 		= $this->config->item('recombee_id2');
		$client_secret 	= $this->config->item('recombee_secret2');

		$client = new Client($client_id, $client_secret);
        $res = $client->send(new Reqs\Batch($user_arr)); //Use Batch for faster processing of larger data

        echo "<pre>";
        print_r($res);
        exit;

	}


	public function upload_user_rating_items(){

        $query = $this->db->query("SELECT tblcontacts.firstname,tblorders.dryvarfoods_id as order_id,tblorders.user_id,COUNT(tblorders.user_id) as total_orders FROM tblorders LEFT JOIN tblcontacts ON tblorders.user_id = tblcontacts.dryvarfoods_id GROUP BY tblorders.user_id ORDER BY user_id desc");
        $data_arr = $query->result_array();

        $item_arr = array();
        $user_arr = array();

        for ($i=0; $i < count($data_arr); $i++) { 
			
        	if($data_arr[$i]['total_orders'] > 0){

        		$user_id = $data_arr[$i]['user_id'];

				$this->db->where(array('user_id' => $user_id));
				$get_order_arr = $this->db->get('tblorders');
				$order_arr = $get_order_arr->result_array();

				for ($j=0; $j < count($order_arr); $j++) { 
					
		        	$get_menu = $this->db->query("SELECT * FROM tblorder_item where order_id='".$order_arr[$j]['dryvarfoods_id']."'");
		            $order_item = $get_menu->row_array();

		            $get_item = $this->db->query("SELECT * FROM tblmenu_item where id='".$order_item['menu_item_id']."'");
		            $item_arr = $get_item->row_array();
		            
		            if($item_arr['dryvarfoods_id'] != ""){

		            	$created_date = date("M d,Y H:i:s", $order_arr[$j]['created_at']);

						$request = new Reqs\AddRating($user_id, $item_arr['dryvarfoods_id'], 1, [ //optional parameters:
						  	//optional parameters:
						  	'recommId' => '7e7f144bd287d61aba949fedcdde5616',
						  	'cascadeCreate' => true,
						  	'timestamp' => $created_date
						]);

			      		array_push($user_arr, $request);
			      		
		            }

				}
        	}
        }

        $client_id 		= $this->config->item('recombee_id2');
		$client_secret 	= $this->config->item('recombee_secret2');

		$client = new Client($client_id, $client_secret);
        $res = $client->send(new Reqs\Batch($user_arr)); //Use Batch for faster processing of larger data

        echo "<pre>";
        print_r($res);
        exit;

	}


	public function upload_user_view_items(){

        $query = $this->db->query("SELECT tblcontacts.firstname,tblorders.dryvarfoods_id as order_id,tblorders.user_id,COUNT(tblorders.user_id) as total_orders FROM tblorders LEFT JOIN tblcontacts ON tblorders.user_id = tblcontacts.dryvarfoods_id GROUP BY tblorders.user_id ORDER BY user_id desc");
        $data_arr = $query->result_array();

        $item_arr = array();
        $user_arr = array();

        for ($i=0; $i < count($data_arr); $i++) { 
			
        	if($data_arr[$i]['total_orders'] > 0){

        		$user_id = $data_arr[$i]['user_id'];

				$this->db->where(array('user_id' => $user_id));
				$get_order_arr = $this->db->get('tblorders');
				$order_arr = $get_order_arr->result_array();

				for ($j=0; $j < count($order_arr); $j++) { 
					
		        	$get_menu = $this->db->query("SELECT * FROM tblorder_item where order_id='".$order_arr[$j]['dryvarfoods_id']."'");
		            $order_item = $get_menu->row_array();

		            $get_item = $this->db->query("SELECT * FROM tblmenu_item where id='".$order_item['menu_item_id']."'");
		            $item_arr = $get_item->row_array();
		            
		            if($item_arr['dryvarfoods_id'] != ""){

		            	$created_date = date("M d,Y H:i:s", $order_arr[$j]['created_at']);

						$request = new Reqs\SetViewPortion($user_id, $item_arr['dryvarfoods_id'], 1, [ 
							//optional parameters:
						  	'recommId' => '7e7f144bd287d61aba949fedcdde5616',
						  	'cascadeCreate' => true,
						  	'timestamp' => $created_date
						]);

			      		array_push($user_arr, $request);
			      		
		            }

				}
        	}
        }

        $client_id 		= $this->config->item('recombee_id2');
		$client_secret 	= $this->config->item('recombee_secret2');

		$client = new Client($client_id, $client_secret);
        $res = $client->send(new Reqs\Batch($user_arr)); //Use Batch for faster processing of larger data

        echo "<pre>";
        print_r($res);
        exit;

	}


	public function reset_db(){

		$client_id 		= $this->config->item('recombee_id2');
		$client_secret 	= $this->config->item('recombee_secret2');

		$client = new Client($client_id, $client_secret);
		
		$response = $client->send(new Reqs\ResetDatabase());

		echo "<pre>";
		print_r($response);
		exit;
	
	}

}
