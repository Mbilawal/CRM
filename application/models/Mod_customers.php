<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mod_customers extends App_Model
{
    private $contact_columns;

    public function __construct()
    {
        parent::__construct();

    }

	public function count_customers($data=array())
    {   
        extract($data);
		
		
        if($customer_status != ""){
            $this->db->where('active', $customer_status);
        }
		
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

	public function count_customers_statuses($customer_type, $data=array())
    {   

        extract($data);
		
		
        if($customer_type != ""){
            $this->db->where('active', $customer_type);
        }
		else{
			$this->db->where('active', 0);
		}
		
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
        $this->db->from('tblcontacts');
		
        $get_data = $this->db->get();
        $data_arr = $get_data->result_array();
		
		$sql = $this->db->last_query();
		
        return count($data_arr);
    }
	
	
    public function get_customers($data=array(),$start,$limit)
    {   
        
        extract($data);
		
		
		if($customer_status != ""){
            $this->db->where('active', $customer_status);
        }
		
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
			
			//Preferred Restaurant
			
			$query = $this->db->query("SELECT o.restaurant_id, count(o.restaurant_id) as no_of_restaurants, c.company as restaurant FROM tblorders o INNER JOIN tblclients c on c.dryvarfoods_id = o.restaurant_id WHERE user_id=".$value['dryvarfoods_id']." GROUP BY restaurant_id order by no_of_restaurants DESC LIMIT 1");
			$order_arr =  $query->row_array();
			$return_arr[$key]['preferred_restaurant'] = $order_arr["restaurant"];
			
			
			$return_arr[$key]['firstname'] = $value['firstname'];
			$return_arr[$key]['email'] = $value['email'];
			$return_arr[$key]['phonenumber'] = $value['phonenumber'];
            $return_arr[$key]['city'] = $value['city'];
			$return_arr[$key]['email_verified_at'] = $value['email_verified_at'];
            $return_arr[$key]['active'] = $value['active'];
            $return_arr[$key]['id'] = $value['dryvarfoods_id'];


        }
        
        //echo "<pre>";  print_r($return_arr); exit;
        

        return $return_arr;
    }

    

    public function get_customers_csv($data=array())
    {   
 
        extract($data);
		
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
			
			//Preferred Restaurant
			
			$query = $this->db->query("SELECT o.restaurant_id, count(o.restaurant_id) as no_of_restaurants, c.company as restaurant FROM tblorders o INNER JOIN tblclients c on c.dryvarfoods_id = o.restaurant_id WHERE user_id=".$value['dryvarfoods_id']." GROUP BY restaurant_id order by no_of_restaurants DESC LIMIT 1");
			$order_arr =  $query->row_array();
			$return_arr[$key]['preferred_restaurant'] = $order_arr["restaurant"];
			
			
			$return_arr[$key]['active'] = ($value['active']==1)?"Active":"Inactive";
			$return_arr[$key]['email_verified_at'] = $value['email_verified_at'];


        }
        
        return $return_arr;
    }
	
}
