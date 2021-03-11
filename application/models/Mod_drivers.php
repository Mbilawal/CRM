<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mod_drivers extends App_Model
{
    private $contact_columns;

    public function __construct()
    {
        parent::__construct();

    }

    public function get_franchise_drivers($data=array())
    {   
			$this->db->dbprefix('franchise');
			if($this->session->userdata('franchise')==1){
				$this->db->where('franchise_id', $this->session->userdata('staff_user_id'));
			}
			$get_cms_page = $this->db->get('franchise');
            $array =  $get_cms_page->row_array();
			return $array;
    }

	public function count_drivers($data=array())
    {   
        extract($data);
		
		if($this->session->userdata('franchise')==1){
			$this->db->dbprefix('franchise');
			$this->db->where('franchise_id', $this->session->userdata('staff_user_id'));
			$get_cms_page = $this->db->get('franchise');
            $array =  $get_cms_page->result_array();
			return $array;
		}
		
		
        if($driver_status != ""){
            $this->db->where('active', $driver_status);
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
		
		if($tip_first != '' && $tip_second > 0){
            $where = "driver_id IN (SELECT driver_id FROM tblorders GROUP BY driver_id HAVING SUM(tips_amount) BETWEEN ".$tip_first." AND ".$tip_second.")";
            $this->db->where($where, NULL, false);
        }
		
		if($delivery_fee_first != '' && $delivery_fee_second > 0){
            $where = "driver_id IN (SELECT driver_id FROM tblorders GROUP BY driver_id HAVING SUM(delivery_fee) BETWEEN ".$delivery_fee_first." AND ".$delivery_fee_second.")";
            $this->db->where($where, NULL, false);
        }
		
		if($estimate_distance_first != '' && $estimate_distance_second > 0){
            $where = "driver_id IN (SELECT driver_id FROM tblorder_delivery GROUP BY driver_id HAVING SUM(est_distance) BETWEEN ".$estimate_distance_first." AND ".$estimate_distance_second.")";
            $this->db->where($where, NULL, false);
        }
		
		if($drop_distance_first != '' && $drop_distance_second > 0){
            $where = "driver_id IN (SELECT driver_id FROM tblorder_delivery GROUP BY driver_id HAVING SUM(drop_distance) BETWEEN ".$drop_distance_first." AND ".$drop_distance_second.")";
            $this->db->where($where, NULL, false);
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
		
		if($this->session->userdata('franchise')==1){
		   	$driverid  =  $array['driver_ids'];
			$ids = array($driverid);
			
			//echo "<pre>";  print_r($ids); exit;
            //$this->db->where_in('driver_id', $driverid);
			$this->db->where("driver_id in ($driverid)");
			//$this->db->where("driver_id",$driverid);//use this 
		}
		
		$this->db->where('type', 3);

        if($orderby !=''){
            $this->db->order_by('id', $orderby);
        }else{
          $this->db->order_by('id', 'DESC'); 
        }
		
		
		
        
        $get_data = $this->db->get(db_prefix(). 'contacts');

        $data_arr = $get_data->num_rows();
        return $data_arr;
		
    }

	public function count_drivers_statuses($driver_type, $data=array())
    {   

        extract($data);
		
		if($this->session->userdata('franchise')==1){
		  $this->db->dbprefix('franchise');
		  $this->db->where('franchise_id', $this->session->userdata('staff_user_id'));
		  //$this->db->where('user_status',1);
		  $get_cms_page = $this->db->get('franchise');
          $array =  $get_cms_page->row_array();
		}
		
        if($driver_type != ""){
            $this->db->where('active', $driver_type);
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
		
		if($tip_first != '' && $tip_second > 0){
            $where = "driver_id IN (SELECT driver_id FROM tblorders GROUP BY driver_id HAVING SUM(tips_amount) BETWEEN ".$tip_first." AND ".$tip_second.")";
            $this->db->where($where, NULL, false);
        }
		
		if($delivery_fee_first != '' && $delivery_fee_second > 0){
            $where = "driver_id IN (SELECT driver_id FROM tblorders GROUP BY driver_id HAVING SUM(delivery_fee) BETWEEN ".$delivery_fee_first." AND ".$delivery_fee_second.")";
            $this->db->where($where, NULL, false);
        }
		
		if($estimate_distance_first != '' && $estimate_distance_second > 0){
            $where = "driver_id IN (SELECT driver_id FROM tblorder_delivery GROUP BY driver_id HAVING SUM(est_distance) BETWEEN ".$estimate_distance_first." AND ".$estimate_distance_second.")";
            $this->db->where($where, NULL, false);
        }
		
		if($drop_distance_first != '' && $drop_distance_second > 0){
            $where = "driver_id IN (SELECT driver_id FROM tblorder_delivery GROUP BY driver_id HAVING SUM(drop_distance) BETWEEN ".$drop_distance_first." AND ".$drop_distance_second.")";
            $this->db->where($where, NULL, false);
        }

        if ($month != '') {
            $date1 = date('Y').'-'.$month.'-01';
            $d=cal_days_in_month(CAL_GREGORIAN,$month,date('Y'));
            if($d < 10 ){$d = '0'.$d;}
            $date2 = date('Y').'-'.$month.'-'.$d;
            
            $this->db->where('email_verified_at >=', $date1);
            $this->db->where('email_verified_at <=', $date2);
            
        }
		
		if($this->session->userdata('franchise')==1){
		   	$driverid  =  $array['driver_ids'];
			//$this->db->where("driver_id",$driverid);//use this 
			$this->db->where("driver_id in ($driverid)");
		}
		$this->db->where("type", 3);
        $this->db->from('tblcontacts');
		
        $get_data = $this->db->get();
        $data_arr = $get_data->result_array();
		
		$sql = $this->db->last_query();
		
        return count($data_arr);
    }
	
	
    public function get_drivers($data=array(),$start,$limit)
    {   
        
        extract($data);
		
		
		
		if($this->session->userdata('franchise')==1){
			
			
			$this->db->dbprefix('franchise');
			$this->db->where('franchise_id', $this->session->userdata('staff_user_id'));
			//$this->db->where('user_status',1);
			$get_cms_page = $this->db->get('franchise');
			$array =  $get_cms_page->row_array();
			
			
		}
		
		if($driver_status != ""){
            $this->db->where('active', $driver_status);
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
		
		if($tip_first != '' && $tip_second > 0){
            $where = "driver_id IN (SELECT driver_id FROM tblorders GROUP BY driver_id HAVING SUM(tips_amount) BETWEEN ".$tip_first." AND ".$tip_second.")";
            $this->db->where($where, NULL, false);
        }
		
		if($delivery_fee_first != '' && $delivery_fee_second > 0){
            $where = "driver_id IN (SELECT driver_id FROM tblorders GROUP BY driver_id HAVING SUM(delivery_fee) BETWEEN ".$delivery_fee_first." AND ".$delivery_fee_second.")";
            $this->db->where($where, NULL, false);
        }
		
		if($estimate_distance_first != '' && $estimate_distance_second > 0){
            $where = "driver_id IN (SELECT driver_id FROM tblorder_delivery GROUP BY driver_id HAVING SUM(est_distance) BETWEEN ".$estimate_distance_first." AND ".$estimate_distance_second.")";
            $this->db->where($where, NULL, false);
        }
		
		if($drop_distance_first != '' && $drop_distance_second > 0){
            $where = "driver_id IN (SELECT driver_id FROM tblorder_delivery GROUP BY driver_id HAVING SUM(drop_distance) BETWEEN ".$drop_distance_first." AND ".$drop_distance_second.")";
            $this->db->where($where, NULL, false);
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
		
		if($this->session->userdata('franchise')==1){
		   $driverid  =  $array['driver_ids'];
			$ids = array($driverid);
			
			//echo "<pre>";  print_r($ids); exit;
            //$this->db->where_in('driver_id', $driverid);
			$this->db->where("driver_id in ($driverid)");
			//$this->db->where("driver_id",$driverid);//use this 
		}
		
        $this->db->where("type", 3);
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
            $this->db->where('driver_id', $value['driver_id']);
			$this->db->offset(0);
            $this->db->limit(1);
			$this->db->order_by('id', 'DESC'); 
            $get_order = $this->db->get(db_prefix(). 'orders');
            $order_arr =  $get_order->row_array();
            
            $return_arr[$key]['last_order'] = $order_arr['dryvarfoods_id'];

            // Total Orders
            $this->db->where('driver_id', $value['driver_id']); 
            $get_order = $this->db->get(db_prefix(). 'orders');
            $total_orders =  $get_order->num_rows();
            
            $return_arr[$key]['total_orders'] = $total_orders;
			
			//Orders last 30 days
			
			$query = $this->db->query("SELECT count(*) as total FROM tblorders WHERE created_at < DATE_ADD(NOW(), INTERVAL -1 MONTH) AND driver_id=".$value['driver_id']);
			$order_arr =  $query->row_array();
			$return_arr[$key]['orders_last_30_days'] = $order_arr["total"];
			
			//Total Tips Amount
			$this->db->select('SUM(tips_amount) as total');
			$this->db->where('driver_id', $value['driver_id']); 
            $get_order = $this->db->get(db_prefix(). 'orders');
            $order_arr =  $get_order->row_array();
            
            $return_arr[$key]['total_tip'] = ($order_arr["total"]==""?0:$order_arr["total"]);
			
			//Total Delivery Fee
			$this->db->select('SUM(delivery_fee) as total_delivery_fee');
			$this->db->where('driver_id', $value['driver_id']); 
            $get_order = $this->db->get(db_prefix(). 'orders');
            $order_arr =  $get_order->row_array();
		
            $return_arr[$key]['total_delivery_fee'] = ($order_arr["total_delivery_fee"]==""?0:$order_arr["total_delivery_fee"]);
			
			//Total Estimate Distance
			$this->db->select('SUM(est_distance) as total_estimate_distance');
			$this->db->where('driver_id', $value['driver_id']); 
            $get_order = $this->db->get(db_prefix(). 'order_delivery');
            $order_arr =  $get_order->row_array();
			
            $return_arr[$key]['total_estimate_distance'] = ($order_arr["total_estimate_distance"]==""?0:$order_arr["total_estimate_distance"]);
			
			//Total Drop Distance
			$this->db->select('SUM(drop_distance) as total_drop_distance');
			$this->db->where('driver_id', $value['driver_id']); 
            $get_order = $this->db->get(db_prefix(). 'order_delivery');
            $order_arr =  $get_order->row_array();
			$return_arr[$key]['total_drop_distance'] = ($order_arr["total_drop_distance"]==""?0:$order_arr["total_drop_distance"]);
			
			$return_arr[$key]['firstname'] = $value['firstname'];
			$return_arr[$key]['email'] = $value['email'];
			$return_arr[$key]['phonenumber'] = $value['phonenumber'];
            $return_arr[$key]['city'] = $value['city'];
			$return_arr[$key]['email_verified_at'] = $value['email_verified_at'];
            $return_arr[$key]['active'] = $value['active'];
            $return_arr[$key]['id'] = $value['driver_id'];


        }
        
        //echo "<pre>";  print_r($return_arr); exit;
        

        return $return_arr;
    }

    
    public function get_driver_detail($driver_id)
    {   
        $this->db->where('driver_id',$driver_id);
		$this->db->where('type', 3);
        $get_data = $this->db->get(db_prefix(). 'contacts');

        $return_arr = $get_data->row_array();

        //Last Order
            $this->db->where('driver_id', $return_arr['driver_id']);
			$this->db->offset(0);
            $this->db->limit(1);
			$this->db->order_by('id', 'DESC'); 
            $get_order = $this->db->get(db_prefix(). 'orders');
            $order_arr =  $get_order->row_array();
            
            $return_arr['last_order'] = $order_arr['dryvarfoods_id'];

            // Total Orders
            $this->db->where('driver_id', $return_arr['driver_id']); 
            $get_order = $this->db->get(db_prefix(). 'orders');
            $total_orders =  $get_order->num_rows();
            
            $return_arr['total_orders'] = $total_orders;
			
			//Orders last 30 days
			
			$query = $this->db->query("SELECT count(*) as total FROM tblorders WHERE created_at < DATE_ADD(NOW(), INTERVAL -1 MONTH) AND driver_id=".$return_arr['driver_id']);
			$order_arr =  $query->row_array();
			$return_arr['orders_last_30_days'] = $order_arr["total"];
			
			//Total Tips Amount
			$this->db->select('SUM(tips_amount) as total');
			$this->db->where('driver_id', $return_arr['driver_id']); 
            $get_order = $this->db->get(db_prefix(). 'orders');
            $order_arr =  $get_order->row_array();
			
            $return_arr['total_tip'] = ($order_arr["total"]==""?0:$order_arr["total"]);
			
			//Total Delivery Fee
			$this->db->select('SUM(delivery_fee) as total_delivery_fee');
			$this->db->where('driver_id', $return_arr['driver_id']); 
            $get_order = $this->db->get(db_prefix(). 'orders');
            $order_arr =  $get_order->row_array();
		
            $return_arr['total_delivery_fee'] = ($order_arr["total_delivery_fee"]==""?0:$order_arr["total_delivery_fee"]);
			
			//Total Estimate Distance
			$this->db->select('SUM(est_distance) as total_estimate_distance');
			$this->db->where('driver_id', $return_arr['driver_id']); 
            $get_order = $this->db->get(db_prefix(). 'order_delivery');
            $order_arr =  $get_order->row_array();
            $return_arr['total_estimate_distance'] = ($order_arr["total_estimate_distance"]==""?0:$order_arr["total_estimate_distance"]);
			
			//Total Drop Distance
			$this->db->select('SUM(drop_distance) as total_drop_distance');
			$this->db->where('driver_id', $return_arr['driver_id']); 
            $get_order = $this->db->get(db_prefix(). 'order_delivery');
            $order_arr =  $get_order->row_array();
            $return_arr['total_drop_distance'] = ($order_arr["total_drop_distance"]==""?0:$order_arr["total_drop_distance"]);
            
			$return_arr['firstname'] = $return_arr['firstname'];
			$return_arr['email'] = $return_arr['email'];
			$return_arr['phonenumber'] = $return_arr['phonenumber'];
            $return_arr['city'] = $return_arr['city'];
			$return_arr['email_verified_at'] = $return_arr['email_verified_at'];
            $return_arr['active'] = $return_arr['active'];
            $return_arr['id'] = $return_arr['driver_id'];

        return $return_arr;
    }


    public function get_drivers_csv($data=array())
    {   
 
        extract($data);
		
        $this->db->where('type', 3);
        $this->db->order_by('id', 'DESC');
        $get_data = $this->db->get('tblcontacts');

        $data_arr = $get_data->result_array();

        $return_arr = array();
        
		foreach ($data_arr as $key => $value) {
            
			$return_arr[$key]['id'] = $value['driver_id'];
			$return_arr[$key]['firstname'] = $value['firstname'];
			$return_arr[$key]['email'] = $value['email'];
			$return_arr[$key]['phonenumber'] = $value['phonenumber'];
			$return_arr[$key]['city'] = $value['city'];
			
            //Last Order
            $this->db->where('driver_id', $value['driver_id']);
			$this->db->offset(0);
            $this->db->limit(1);
			$this->db->order_by('id', 'DESC'); 
            $get_order = $this->db->get(db_prefix(). 'orders');
            $order_arr =  $get_order->row_array();
            
            $return_arr[$key]['last_order'] = $order_arr['dryvarfoods_id'];
			
			//Orders last 30 days
			
			$query = $this->db->query("SELECT count(*) as total FROM tblorders WHERE created_at < DATE_ADD(NOW(), INTERVAL -1 MONTH) AND driver_id=".$value['driver_id']);
			$order_arr =  $query->row_array();
			$return_arr[$key]['orders_last_30_days'] = $order_arr["total"];

            // Total Orders
            $this->db->where('driver_id', $value['driver_id']); 
            $get_order = $this->db->get(db_prefix(). 'orders');
            $total_orders =  $get_order->num_rows();
            
            $return_arr[$key]['total_orders'] = $total_orders;
			
			
			
			//Total Tips Amount
			$this->db->select('SUM(tips_amount) as total');
			$this->db->where('driver_id', $value['driver_id']); 
            $get_order = $this->db->get(db_prefix(). 'orders');
            $order_arr =  $get_order->row_array();
            
            $return_arr[$key]['total_tip'] = ($order_arr["total"]==""?0:$order_arr["total"]);
			
			//Total Delivery Fee
			$this->db->select('SUM(delivery_fee) as total_delivery_fee');
			$this->db->where('driver_id', $return_arr['driver_id']); 
            $get_order = $this->db->get(db_prefix(). 'orders');
            $order_arr =  $get_order->row_array();
		
            $return_arr[$key]['total_delivery_fee'] = ($order_arr["total_delivery_fee"]==""?0:$order_arr["total_delivery_fee"]);
			
			//Total Estimate Distance
			$this->db->select('SUM(est_distance) as total_estimate_distance');
			$this->db->where('driver_id', $return_arr['driver_id']); 
            $get_order = $this->db->get(db_prefix(). 'order_delivery');
            $order_arr =  $get_order->row_array();
			
            $return_arr[$key]['total_estimate_distance'] = ($order_arr["total_estimate_distance"]==""?0:$order_arr["total_estimate_distance"]);
			
			//Total Drop Distance
			$this->db->select('SUM(drop_distance) as total_drop_distance');
			$this->db->where('driver_id', $return_arr['driver_id']); 
            $get_order = $this->db->get(db_prefix(). 'order_delivery');
            $order_arr =  $get_order->row_array();
			$return_arr[$key]['total_drop_distance'] = ($order_arr["total_drop_distance"]==""?0:$order_arr["total_drop_distance"]);
			
			$return_arr[$key]['active'] = ($value['active']==1)?"Active":"Inactive";
			$return_arr[$key]['email_verified_at'] = $value['email_verified_at'];


        }
        
        return $return_arr;
    }
	
	public function count_requests($driver_id, $data=array())
    {   
        extract($data);
        if($request_status != ""){
            $this->db->where('status', $request_status);
        }
		
		if($order_id != ""){
            $this->db->where('order_id', $order_id);
        }
		
		if ($pickup_location != '') {

            $this->db->like('pickup_location', $pickup_location, 'after');
        }
		
		if ($drop_location != '') {

            $this->db->like('drop_location', $drop_location, 'after');
        }
		
		if($date_from != '' && $date_too !=''){

            $this->db->where('created_at >=', $date_from.' 00:00:00');
            $this->db->where('created_at <=', $date_too.' 23:59:00');

        }else if($date_from != '' && $date_too ==''){

            $this->db->where('created_at >=', $date_from.' 00:00:00');
            $this->db->where('created_at <=', $date_from.' 23:59:00');

        }else if($date_from == '' && $date_too !=''){

            $this->db->where('created_at >=', $date_too.' 00:00:00');
            $this->db->where('created_at <=', $date_too.' 23:59:00');

        }

        if ($month != '') {
            $date1 = date('Y').'-'.$month.'-01';
            $d=cal_days_in_month(CAL_GREGORIAN,$month,date('Y'));
            if($d < 10 ){$d = '0'.$d;}
            $date2 = date('Y').'-'.$month.'-'.$d;
            
            $this->db->where('created_at >=', $date1);
            $this->db->where('created_at <=', $date2);
            
        }
		
		$this->db->where('driver_id', $driver_id);

        if($orderby !=''){
            $this->db->order_by('id', $orderby);
        }else{
          $this->db->order_by('id', 'DESC'); 
        }
        
        $get_data = $this->db->get(db_prefix(). 'order_delivery');

        $data_arr = $get_data->num_rows();
        return $data_arr;
		
    }

	public function count_requests_statuses($request_type, $data=array(), $driver_id)
    {   

        extract($data);
        if($request_type != "" && $request_status==""){
            $this->db->where('status', $request_type);
        }
		else{
			 $this->db->where('status', $request_status);
		}
		
		if($order_id != ""){
            $this->db->where('order_id', $order_id);
        }
		
		if ($pickup_location != '') {

            $this->db->like('pickup_location', $pickup_location, 'after');
        }
		
		if ($drop_location != '') {

            $this->db->like('drop_location', $drop_location, 'after');
        }
		
		if($date_from != '' && $date_too !=''){

            $this->db->where('created_at >=', $date_from.' 00:00:00');
            $this->db->where('created_at <=', $date_too.' 23:59:00');

        }else if($date_from != '' && $date_too ==''){

            $this->db->where('created_at >=', $date_from.' 00:00:00');
            $this->db->where('created_at <=', $date_from.' 23:59:00');

        }else if($date_from == '' && $date_too !=''){

            $this->db->where('created_at >=', $date_too.' 00:00:00');
            $this->db->where('created_at <=', $date_too.' 23:59:00');

        }

        if ($month != '') {
            $date1 = date('Y').'-'.$month.'-01';
            $d=cal_days_in_month(CAL_GREGORIAN,$month,date('Y'));
            if($d < 10 ){$d = '0'.$d;}
            $date2 = date('Y').'-'.$month.'-'.$d;
            
            $this->db->where('created_at >=', $date1);
            $this->db->where('created_at <=', $date2);
            
        }
		
		$this->db->where('driver_id', $driver_id);

        if($orderby !=''){
            $this->db->order_by('id', $orderby);
        }else{
          $this->db->order_by('id', 'DESC'); 
        }
        $this->db->from('tblorder_delivery');
		
        $get_data = $this->db->get();
        $data_arr = $get_data->result_array();
		if($request_status != "" && $request_status == $request_type){
        return count($data_arr);
		}
		else if($request_status == ""){
        return count($data_arr);
		}
		else{
			return 0;
		}
    }
	
	
    public function get_requests($data=array(),$start,$limit,$driver_id)
    {   
        
        extract($data);
		
		if($request_status != ""){
            $this->db->where('status', $request_status);
        }
		
		if($order_id != ""){
            $this->db->where('order_id', $order_id);
        }
		
		if ($pickup_location != '') {

            $this->db->like('pickup_location', $pickup_location, 'after');
        }
		
		if ($drop_location != '') {

            $this->db->like('drop_location', $drop_location, 'after');
        }
		
		if($date_from != '' && $date_too !=''){

            $this->db->where('created_at >=', $date_from.' 00:00:00');
            $this->db->where('created_at <=', $date_too.' 23:59:00');

        }else if($date_from != '' && $date_too ==''){

            $this->db->where('created_at >=', $date_from.' 00:00:00');
            $this->db->where('created_at <=', $date_from.' 23:59:00');

        }else if($date_from == '' && $date_too !=''){

            $this->db->where('created_at >=', $date_too.' 00:00:00');
            $this->db->where('created_at <=', $date_too.' 23:59:00');

        }

        if ($month != '') {
            $date1 = date('Y').'-'.$month.'-01';
            $d=cal_days_in_month(CAL_GREGORIAN,$month,date('Y'));
            if($d < 10 ){$d = '0'.$d;}
            $date2 = date('Y').'-'.$month.'-'.$d;
            
            $this->db->where('created_at >=', $date1);
            $this->db->where('created_at <=', $date2);
            
        }
		
		$this->db->where('driver_id', $driver_id);

        if($orderby !=''){
            $this->db->order_by('id', $orderby);
        }else{
          $this->db->order_by('id', 'DESC'); 
        }
        $this->db->offset($start);
        $this->db->limit($limit);
        
        $get_data = $this->db->get(db_prefix(). 'order_delivery');
		

        $data_arr = $get_data->result_array();

        return $data_arr;
    }


     public function get_requests_csv($driver_id)
    {   
		
		$this->db->where('driver_id', $driver_id);
		$this->db->order_by('id', 'DESC'); 

        $get_data = $this->db->get(db_prefix(). 'order_delivery');
		

        $data_arr = $get_data->result_array();
		
		$return_arr = array();
        
		foreach ($data_arr as $key => $value) {
            
			$return_arr[$key]['id'] = $value['id'];
			$return_arr[$key]['order_id'] = $value['order_id'];
			$return_arr[$key]['pickup_location'] = $value['pickup_location'];
			$return_arr[$key]['drop_location'] = $value['drop_location'];
			$return_arr[$key]['duration'] = $value['duration'];
			$return_arr[$key]['est_distance'] = $value['est_distance']."KM";
			$return_arr[$key]['drop_distance'] = $value['drop_distance']."KM";
			if($value['status']==6){ 
			 $newstatus = 'Completed';
		  }
		  else if($value['status']==5){ 
			 $newstatus = 'Delivered';
		  }
		  else if($value['status']==4){ 
			 $newstatus = 'Cancelled';
		  }
		  else if($value['status']==2){ 
			 $newstatus = 'Declined';
		  }
		  else if($value['status']==3){ 
			 $newstatus = 'Accepted';
		  }
		  else{ 
			 $newstatus = '';
		  }
            
			$return_arr[$key]['status'] = $newstatus;
			$return_arr[$key]['created_at'] = date("d-m-Y h:i A", strtotime($value['created_at']));


        }
        
        return $return_arr;
    }
	

   //Driver Checklist
   
   public function count_checklist($data=array())
    {   
        extract($data);
		if ($firstname != '') {

            $this->db->like('tblcontacts.firstname', $firstname, 'after');
        }
		
		if ($phonenumber != '') {

            $this->db->like('tblcontacts.phonenumber', $phonenumber, 'after');
        }
     
		if($date_from != '' && $date_too !=''){

            $this->db->where('tblchecklist.created_at >=', $date_from.' 00:00:00');
            $this->db->where('tblchecklist.created_at <=', $date_too.' 23:59:00');

        }else if($date_from != '' && $date_too ==''){

            $this->db->where('tblchecklist.created_at >=', $date_from.' 00:00:00');
            $this->db->where('tblchecklist.created_at <=', $date_from.' 23:59:00');

        }else if($date_from == '' && $date_too !=''){

            $this->db->where('tblchecklist.created_at >=', $date_too.' 00:00:00');
            $this->db->where('tblchecklist.created_at <=', $date_too.' 23:59:00');

        }

        if ($month != '') {
            $date1 = date('Y').'-'.$month.'-01';
            $d=cal_days_in_month(CAL_GREGORIAN,$month,date('Y'));
            if($d < 10 ){$d = '0'.$d;}
            $date2 = date('Y').'-'.$month.'-'.$d;
            
            $this->db->where('tblchecklist.created_at >=', $date1);
            $this->db->where('tblchecklist.created_at <=', $date2);
            
        }

        if($orderby !=''){
            $this->db->order_by('tblchecklist.id', $orderby);
        }else{
          $this->db->order_by('tblchecklist.id', 'DESC'); 
        }
        $this->db->from('tblchecklist');
		$this->db->join("tblcontacts","tblcontacts.driver_id = tblchecklist.driver_id","inner");
        $get_data = $this->db->get();

        $data_arr = $get_data->num_rows();
        return $data_arr;
		
    }

    public function get_checklist($data=array(),$start,$limit)
    {   
        $this->db->select("tblchecklist.*, tblcontacts.firstname as driver_name, tblcontacts.phonenumber as mobile_number");
         extract($data);
		if ($firstname != '') {

            $this->db->like('tblcontacts.firstname', $firstname, 'after');
        }
		
		if ($phonenumber != '') {

            $this->db->like('tblcontacts.phonenumber', $phonenumber, 'after');
        }
     
		if($date_from != '' && $date_too !=''){

            $this->db->where('tblchecklist.created_at >=', $date_from.' 00:00:00');
            $this->db->where('tblchecklist.created_at <=', $date_too.' 23:59:00');

        }else if($date_from != '' && $date_too ==''){

            $this->db->where('tblchecklist.created_at >=', $date_from.' 00:00:00');
            $this->db->where('tblchecklist.created_at <=', $date_from.' 23:59:00');

        }else if($date_from == '' && $date_too !=''){

            $this->db->where('tblchecklist.created_at >=', $date_too.' 00:00:00');
            $this->db->where('tblchecklist.created_at <=', $date_too.' 23:59:00');

        }

        if ($month != '') {
            $date1 = date('Y').'-'.$month.'-01';
            $d=cal_days_in_month(CAL_GREGORIAN,$month,date('Y'));
            if($d < 10 ){$d = '0'.$d;}
            $date2 = date('Y').'-'.$month.'-'.$d;
            
            $this->db->where('tblchecklist.created_at >=', $date1);
            $this->db->where('tblchecklist.created_at <=', $date2);
            
        }
		
		$this->db->offset($start);
        $this->db->limit($limit);

        if($orderby !=''){
            $this->db->order_by('tblchecklist.id', $orderby);
        }else{
          $this->db->order_by('tblchecklist.id', 'DESC'); 
        }
		
		$this->db->join("tblcontacts","tblcontacts.driver_id = tblchecklist.driver_id","inner");
		
        $get_data = $this->db->get(db_prefix(). 'checklist');
        
        $data_arr = $get_data->result_array();
		
        return $data_arr;
    }

    
	 public function get_checklist_csv()
    {   
		$this->db->select("tblcontacts.firstname as driver_name, tblcontacts.phonenumber as mobile_number, tblchecklist.*");
		
		$this->db->join("tblcontacts","tblcontacts.driver_id = tblchecklist.driver_id","inner");
		
		$this->db->order_by('checklist.id', 'DESC'); 

        $get_data = $this->db->get(db_prefix(). 'checklist');
		

        $data_arr = $get_data->result_array();
        
		return $data_arr;
    }
	
	//Driver Reports
	
	public function count_drivers_report($data=array())
    {   
        extract($data);

		if($this->session->userdata('franchise')==1){
    		$this->db->dbprefix('franchise');
    		$this->db->where('franchise_id', $this->session->userdata('staff_user_id'));
    		//$this->db->where('user_status',1);
    		$get_cms_page = $this->db->get('franchise');
            $array =  $get_cms_page->row_array();
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
		
		if($this->session->userdata('franchise')==1){
		   	$driverid  =  $array['driver_ids'];
			$this->db->where("driver_id",$driverid);//use this 
		}
		
		$this->db->where('type', 3);
		if($online!=''  && $online==1){
		  $this->db->where('user_status', 1);
		}
		if($offline!=''  && $offline==0){
		  $this->db->where('user_status', 0);
		}
        $this->db->order_by('id', 'DESC'); 
        
        $get_data = $this->db->get(db_prefix(). 'contacts');
        $data_arr = $get_data->num_rows();

        return $data_arr;
		
    }

    public function get_drivers_report($data=array(),$start,$limit)
    {   
        
        extract($data);
		
		if($this->session->userdata('franchise')==1){
			
			
		$this->db->dbprefix('franchise');
		$this->db->where('franchise_id', $this->session->userdata('staff_user_id'));
		//$this->db->where('user_status',1);
		$get_cms_page = $this->db->get('franchise');
         $array =  $get_cms_page->row_array();
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

            $this->db->where('driver_status_modified_date >=', $date_from.' 00:00:00');
            $this->db->where('driver_status_modified_date <=', $date_too.' 23:59:00');

        }else if($date_from != '' && $date_too ==''){

            $this->db->where('driver_status_modified_date >=', $date_from.' 00:00:00');
            $this->db->where('driver_status_modified_date <=', $date_from.' 23:59:00');

        }else if($date_from == '' && $date_too !=''){

            $this->db->where('driver_status_modified_date >=', $date_too.' 00:00:00');
            $this->db->where('driver_status_modified_date <=', $date_too.' 23:59:00');

        }

        if ($month != '') {
            $date1 = date('Y').'-'.$month.'-01';
            $d=cal_days_in_month(CAL_GREGORIAN,$month,date('Y'));
            if($d < 10 ){$d = '0'.$d;}
            $date2 = date('Y').'-'.$month.'-'.$d;
            
            $this->db->where('driver_status_modified_date >=', $date1);
            $this->db->where('driver_status_modified_date <=', $date2);
            
        }
		
		if($this->session->userdata('franchise')==1){
		   	$driverid  =  $array['driver_ids'];
			
			
			//$this->db->where("driver_id",$driverid);//use this 
			$this->db->where("driver_id in ($driverid)");
		}
		
        $this->db->where("type", 3);
		if($online!=''  && $online==1 && $offline==''){
		  $this->db->where('user_status', 1);
		}
		if($offline!=''  && $offline==0 && $online==''){
		  $this->db->where('user_status', 0);
		} 
		if($offline!='' && $online!=''){
		  //$this->db->where('user_status', 0);
		}
        $this->db->offset($start);
        $this->db->limit($limit);

        
        $this->db->order_by('id', 'DESC'); 
        
        
        $get_data = $this->db->get(db_prefix(). 'contacts');
		

        $data_arr = $get_data->result_array();
		
		$str = $this->db->last_query();
		
		//echo "<pre>";  print_r($data_arr); exit; 

        $return_arr = array();
        foreach ($data_arr as $key => $value) {
       
			//Total Earnings
			$this->db->select('SUM(total_amount) as total');
			$this->db->where('driver_id', $value['driver_id']); 
            $get_order = $this->db->get(db_prefix(). 'orders');
            $order_arr =  $get_order->row_array();
            
            $return_arr[$key]['total_earnings'] = ($order_arr["total"]==""?0.00:$order_arr["total"]);
			
			//Total Paid
			$this->db->select('SUM(driver_commision_fee) as total');
			$this->db->where('driver_id', $value['driver_id']); 
            $get_order = $this->db->get(db_prefix(). 'orders');
            $order_arr =  $get_order->row_array();
			$return_arr[$key]['total_paid'] = ($order_arr["total"]==""?0.00:$order_arr["total"]);
			
			$return_arr[$key]['firstname'] = $value['firstname'];
			$return_arr[$key]['email'] = $value['email'];
			$return_arr[$key]['phonenumber'] = $value['phonenumber'];
            $return_arr[$key]['city'] = $value['city'];
            $return_arr[$key]['active'] = $value['active'];
            $return_arr[$key]['id'] = $value['driver_id'];
			$return_arr[$key]['user_status'] = $value['user_status'];


        }
       
        return $return_arr;
    }
	
	
	public function count_drivers_trip($data=array())
    {   
        extract($data);
		
		// if($this->session->userdata('franchise')==1){
			
  //   		$this->db->dbprefix('franchise');
  //   		$this->db->where('franchise_id', $this->session->userdata('staff_user_id'));
  //   		//$this->db->where('user_status',1);
  //   		$get_cms_page = $this->db->get('franchise');
  //           $array =  $get_cms_page->row_array();
		// }
  
		// if ($firstname != '') {

  //           $this->db->like('firstname', $firstname, 'after');
  //       }
		
		// if ($email != '') {

  //           $this->db->like('email', $email, 'after');
  //       }
		
		// if ($phonenumber != '') {

  //           $this->db->like('phonenumber', $phonenumber, 'after');
  //       }
     
  //       if ($city != '') {

  //           $this->db->like('city', $city, 'after');
  //       }
		
		
		// if($date_from != '' && $date_too !=''){

  //           $this->db->where('driver_status_modified_date >=', $date_from.' 00:00:00');
  //           $this->db->where('driver_status_modified_date <=', $date_too.' 23:59:00');

  //       }else if($date_from != '' && $date_too ==''){

  //           $this->db->where('driver_status_modified_date >=', $date_from.' 00:00:00');
  //           $this->db->where('driver_status_modified_date <=', $date_from.' 23:59:00');

  //       }else if($date_from == '' && $date_too !=''){

  //           $this->db->where('driver_status_modified_date >=', $date_too.' 00:00:00');
  //           $this->db->where('driver_status_modified_date <=', $date_too.' 23:59:00');

  //       }

  //       if ($month != '') {
  //           $date1 = date('Y').'-'.$month.'-01';
  //           $d=cal_days_in_month(CAL_GREGORIAN,$month,date('Y'));
  //           if($d < 10 ){$d = '0'.$d;}
  //           $date2 = date('Y').'-'.$month.'-'.$d;
            
  //           $this->db->where('driver_status_modified_date >=', $date1);
  //           $this->db->where('driver_status_modified_date <=', $date2);
            
  //       }
		
		// if($this->session->userdata('franchise')==1){
		//    	$driverid  =  $array['driver_ids'];
		// 	$ids = array($driverid);
			
		// 	//echo "<pre>";  print_r($ids); exit;
  //           //$this->db->where_in('driver_id', $driverid);
		// 	$this->db->where("driver_id in ($driverid)");
		// 	//$this->db->where("driver_id",$driverid);//use this 
		// }
		
		
		// $this->db->where('type', 3);
  //       $this->db->order_by('id', 'DESC');
  //        $get_data = $this->db->get(db_prefix(). 'contacts');
  //       $data_arr = $get_data->num_rows();

        if($this->session->userdata('franchise')==1){
            
            $this->db->dbprefix('franchise');
            $this->db->where('franchise_id', $this->session->userdata('staff_user_id'));
            //$this->db->where('user_status',1);
            $get_cms_page = $this->db->get('franchise');
            $array =  $get_cms_page->row_array();
        }
        
        if($firstname != ''){
            $this->db->like('firstname', $firstname, 'after');
        }
        
        if($email != ''){
            $this->db->like('email', $email, 'after');
        }
        
        if($phonenumber != ''){
            $this->db->like('phonenumber', $phonenumber, 'after');
        }
     
        if ($city != '') {
            $this->db->like('city', $city, 'after');
        }
        
        if($date_from != '' && $date_too !=''){
            $this->db->where('order_date >=', $date_from.' 00:00:00');
            $this->db->where('order_date <=', $date_too.' 23:59:00');

        }else if($date_from != '' && $date_too ==''){
            $this->db->where('order_date >=', $date_from.' 00:00:00');
            $this->db->where('order_date <=', $date_from.' 23:59:00');

        }else if($date_from == '' && $date_too !=''){
            $this->db->where('order_date >=', $date_too.' 00:00:00');
            $this->db->where('order_date <=', $date_too.' 23:59:00');
        }

        if ($month != '') {
            $date1 = date('Y').'-'.$month.'-01';
            $d=cal_days_in_month(CAL_GREGORIAN,$month,date('Y'));
            if($d < 10 ){$d = '0'.$d;}
            $date2 = date('Y').'-'.$month.'-'.$d;
            $this->db->where('order_date >=', $date1);
            $this->db->where('order_date <=', $date2);
        }
        
        if($this->session->userdata('franchise')==1){
            $driverid  =  $array['driver_ids'];
            $ids = array($driverid);
            
            //echo "<pre>";  print_r($ids);
            //$this->db->where_in('driver_id', $driverid);
            $this->db->where("driver_id in ($driverid)");
            //$this->db->where("driver_id",$driverid);//use this 
        }
        
        
        $this->db->where("status", 6);

        $get_data = $this->db->get(db_prefix(). 'orders');
        $data_arr = $get_data->num_rows();

        return $data_arr;
		
    }

    public function get_drivers_trip($data=array(),$start,$limit)
    {   
        extract($data);
		
		if($this->session->userdata('franchise')==1){
			
    		$this->db->dbprefix('franchise');
    		$this->db->where('franchise_id', $this->session->userdata('staff_user_id'));
    		//$this->db->where('user_status',1);
    		$get_cms_page = $this->db->get('franchise');
            $array =  $get_cms_page->row_array();
		}
		
		if($firstname != ''){
            $this->db->like('firstname', $firstname, 'after');
        }
		
		if($email != ''){
            $this->db->like('email', $email, 'after');
        }
		
		if($phonenumber != ''){
            $this->db->like('phonenumber', $phonenumber, 'after');
        }
     
        if ($city != '') {
            $this->db->like('city', $city, 'after');
        }
		
		if($date_from != '' && $date_too !=''){
            $this->db->where('order_date >=', $date_from.' 00:00:00');
            $this->db->where('order_date <=', $date_too.' 23:59:00');

        }else if($date_from != '' && $date_too ==''){
            $this->db->where('order_date >=', $date_from.' 00:00:00');
            $this->db->where('order_date <=', $date_from.' 23:59:00');

        }else if($date_from == '' && $date_too !=''){
            $this->db->where('order_date >=', $date_too.' 00:00:00');
            $this->db->where('order_date <=', $date_too.' 23:59:00');
        }

        if ($month != '') {
            $date1 = date('Y').'-'.$month.'-01';
            $d=cal_days_in_month(CAL_GREGORIAN,$month,date('Y'));
            if($d < 10 ){$d = '0'.$d;}
            $date2 = date('Y').'-'.$month.'-'.$d;
            $this->db->where('order_date >=', $date1);
            $this->db->where('order_date <=', $date2);
        }
		
		if($this->session->userdata('franchise')==1){
		   	$driverid  =  $array['driver_ids'];
			$ids = array($driverid);
			
			//echo "<pre>";  print_r($ids);
            //$this->db->where_in('driver_id', $driverid);
			$this->db->where("driver_id in ($driverid)");
			//$this->db->where("driver_id",$driverid);//use this 
		}
		
        $this->db->where("status", 6);
        $this->db->offset($start);
        $this->db->limit($limit);
        $this->db->order_by('id', 'DESC'); 
        $get_data = $this->db->get(db_prefix(). 'orders');
        $data_arr_order = $get_data->result_array();
		
        // echo "<pre>";
        // print_r($data_arr_order);
        // exit;

        $return_arr = array();
        foreach ($data_arr_order as $key => $value) {
			
			$this->db->select("*");
			$this->db->where("order_id", $value['dryvarfoods_id']);
			$this->db->order_by('id', 'DESC');
             
			$get_data = $this->db->get(db_prefix(). 'order_delivery');
			$data_arr = $get_data->row_array();
			
			//Total Earnings
			$this->db->select('*');
			$this->db->where('driver_id', $value['driver_id']); 
			
            $get_order = $this->db->get(db_prefix(). 'contacts');
            $user_arr  = $get_order->row_array();
			
			$return_arr[$key]['order_arr']          = $value;
			$return_arr[$key]['order_delivery']     = $data_arr;
			$return_arr[$key]['firstname_driver']   = $user_arr['firstname'];
			$return_arr[$key]['email_driver']       = $user_arr['email'];
			$return_arr[$key]['phonenumber_driver'] = $user_arr['phonenumber'];
            $return_arr[$key]['city_driver']        = $user_arr['city'];
            $return_arr[$key]['active_driver']      = $user_arr['active'];
            $return_arr[$key]['id_driver']          = $user_arr['driver_id'];
			$return_arr[$key]['user_status_driver'] = $user_arr['user_status'];
			//echo "<pre>";  print_r($data_arr); exit;
        }
        return $return_arr;
    }



    public function get_report_csv($data=array())
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

            $this->db->where('driver_status_modified_date >=', $date_from.' 00:00:00');
            $this->db->where('driver_status_modified_date <=', $date_too.' 23:59:00');

        }else if($date_from != '' && $date_too ==''){

            $this->db->where('driver_status_modified_date >=', $date_from.' 00:00:00');
            $this->db->where('driver_status_modified_date <=', $date_from.' 23:59:00');

        }else if($date_from == '' && $date_too !=''){

            $this->db->where('driver_status_modified_date >=', $date_too.' 00:00:00');
            $this->db->where('driver_status_modified_date <=', $date_too.' 23:59:00');

        }

        if ($month != '') {
            $date1 = date('Y').'-'.$month.'-01';
            $d=cal_days_in_month(CAL_GREGORIAN,$month,date('Y'));
            if($d < 10 ){$d = '0'.$d;}
            $date2 = date('Y').'-'.$month.'-'.$d;
            
            $this->db->where('driver_status_modified_date >=', $date1);
            $this->db->where('driver_status_modified_date <=', $date2);
            
        }
        $this->db->where("type", 3);
        $this->db->offset($start);
        $this->db->limit($limit);

        
        $this->db->order_by('id', 'DESC'); 
        
        
        $get_data = $this->db->get(db_prefix(). 'contacts');
		

        $data_arr = $get_data->result_array();

        $return_arr = array();
        foreach ($data_arr as $key => $value) {
       
            $return_arr[$key]['id'] = $value['driver_id'];
			$return_arr[$key]['firstname'] = $value['firstname'];
			$return_arr[$key]['email'] = $value['email'];
			$return_arr[$key]['phonenumber'] = $value['phonenumber'];
            $return_arr[$key]['city'] = $value['city'];
			
			//Total Earnings
			$this->db->select('SUM(total_amount) as total');
			$this->db->where('driver_id', $value['driver_id']); 
            $get_order = $this->db->get(db_prefix(). 'orders');
            $order_arr =  $get_order->row_array();
            
            $return_arr[$key]['total_earnings'] = ($order_arr["total"]==""?0.00:$order_arr["total"]);
			
			//Total Paid
			$this->db->select('SUM(driver_commision_fee) as total');
			$this->db->where('driver_id', $value['driver_id']); 
            $get_order = $this->db->get(db_prefix(). 'orders');
            $order_arr =  $get_order->row_array();
			$return_arr[$key]['total_paid'] = ($order_arr["total"]==""?0.00:$order_arr["total"]);
            $return_arr[$key]['active'] = $value['active'];


        }
       
        return $return_arr;
    }
	
	public function get_total_earnings($driver_id, $data = array()){
		    
		    //Total Earnings
		    extract($data);
			$this->db->select('SUM(total_amount) as total');
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
			$this->db->where('driver_id', $driver_id);
            $this->db->where("status", 6);			
            $get_order = $this->db->get(db_prefix(). 'orders');
            $order_arr =  $get_order->row_array();
			return ($order_arr["total"]==""?0.00:$order_arr["total"]);
	}
	
	public function get_total_paid($driver_id, $data = array()){
		    
		    //Total Paid
			extract($data);
			$this->db->select('SUM(driver_commision_fee) as total');
			$this->db->where('driver_id', $driver_id);
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
            $get_order = $this->db->get(db_prefix(). 'orders');
            $order_arr =  $get_order->row_array();
			return ($order_arr["total"]==""?0.00:$order_arr["total"]);
	}
	
	public function get_driver_orders($driver_id, $data=array())
    {   

	    extract($data);
		
		//echo "<pre>";  print_r(); exit;
		$this->db->select("tblorder_delivery.order_id, tblorder_delivery.pickup_location, tblorder_delivery.drop_location, tblorder_delivery.drop_distance,tblorders.order_type, tblorders.restaurant_commision_fee as payout, tblorders.tips_amount, tblorders.total_amount");
		$this->db->join("tblorders","tblorders.dryvarfoods_id = tblorder_delivery.order_id");
		if($from_date!="" || $to_date!=""){
			$date_from = strtotime($from_date.' 00:00:00');
			if($to_date!=""){
			  $date_to = strtotime($to_date.' 23:59:00');
			}else{
				$date_to = strtotime($from_date.' 23:59:00');
			}
				
			$this->db->where('tblorders.created_at >=', $date_from);
			$this->db->where('tblorders.created_at <=', $date_to);
			}
		$this->db->where('tblorders.driver_id', $driver_id);
		$this->db->where("tblorders.status", 6);
		$this->db->order_by('tblorders.id', 'DESC'); 

        $get_data = $this->db->get(db_prefix(). 'order_delivery');
        $data_arr = $get_data->result_array();

        // echo "<pre>";
        // print_r($data_arr);
        // exit;

		return $data_arr;
    }
	
	public function get_driver_weekly_payout($driver_id){
		return array();
	}
	
	public function get_driver_account_activity($driver_id, $data=array())
    {   
	    extract($data);
		if($from_date!="" || $to_date!=""){
			$date_from = date("Y-m-d H:i:s", strtotime($from_date.' 00:00:00'));
			if($to_date!=""){
			  $date_to = date("Y-m-d H:i:s", strtotime($to_date.' 23:59:00'));
			}
			else{
				$date_to = date("Y-m-d H:i:s", strtotime($from_date.' 23:59:00'));
			}
				
			$this->db->where('tbldrivers_account_activity.created_at >=', $date_from);
			$this->db->where('tbldrivers_account_activity.created_at <=', $date_to);
			}
		$this->db->where('tbldrivers_account_activity.driver_id', $driver_id);
		$this->db->order_by('tbldrivers_account_activity.created_at', 'DESC'); 

        $get_data = $this->db->get(db_prefix(). 'drivers_account_activity');
		
        $data_arr = $get_data->result_array();
	    
		$return_arr = array();
        foreach ($data_arr as $key => $value) {
			$return_arr[$key]['latitude'] = $value['latitude'];
			$return_arr[$key]['longitude'] = $value['longitude'];
			$return_arr[$key]['location_updated_at'] = ($value['location_updated_at']!="0000-00-00 00:00:00")?date("Y-m-d h:i A", strtotime($value["location_updated_at"])):"";
            $return_arr[$key]['status'] = ($value['status']==1)?"Online":"Offline";
			 $return_arr[$key]['vehicle_name'] = $value['vehicle_name'];
			$return_arr[$key]['created_at'] = date("Y-m-d h:i A", strtotime($value['created_at']));
        }

        return $return_arr;
    }
	
	
	public function get_account_activity_status($driver_id, $data=array())
    {    extract($data);
		$this->db->select("DATE_FORMAT(created_at, '%Y-%m-%d') as date, COUNT( if(status = 1, 1, NULL)) as online_hours, COUNT( if(status = 0, 1, NULL)) as offline_hours");
		if($from_date!="" || $to_date!=""){
			$date_from = date("Y-m-d H:i:s", strtotime($from_date.' 00:00:00'));
			if($to_date!=""){
			  $date_to = date("Y-m-d H:i:s", strtotime($to_date.' 23:59:00'));
			}
			else{
				$date_to = date("Y-m-d H:i:s", strtotime($from_date.' 23:59:00'));
			}
				
			$this->db->where('tbldrivers_account_activity.created_at >=', $date_from);
			$this->db->where('tbldrivers_account_activity.created_at <=', $date_to);
			}
		$this->db->where('tbldrivers_account_activity.driver_id', $driver_id); 
		$this->db->group_by('date'); 

        $get_data = $this->db->get(db_prefix(). 'drivers_account_activity');
        $data_arr = $get_data->result_array();

        return $data_arr;
    }
	
	//Franchise Drivers Revenue Reports
	public function drivers_revenue_report($data=array()){
		
        extract($data);
		
        $this->db->select("driver_id, SUM(delivery_fee) as total_comission_earned, SUM(tips_amount) as total_tips_paid");
		$this->db->where("status", 6);
		
		if($from_date!="" || $to_date!=""){
		      
            $date_from = strtotime($from_date.' 00:00:00');
    		
            if($to_date!=""){
                $date_to = strtotime($to_date.' 23:59:00');
    		}else{
    			$date_to = strtotime($from_date.' 23:59:00');
    		}
			
    		$this->db->where('created_at >=', $date_from);
            $this->db->where('created_at <=', $date_to);
		
		}

		if($driver!=""){
			if($driver!="all"){
			   $this->db->where('driver_id', $driver);
			}else{
			  $this->db->where("driver_id in ($driverid)");	
			}
		}

		$this->db->group_by("driver_id");
		$get_data = $this->db->get(db_prefix(). 'orders');
		//echo $this->db->last_query();exit;
		$data_arr = $get_data->result_array(); 
		
        return $data_arr;

	}
    

    //Franchise Drivers Revenue Reports
    public function drivers_revenue_report_ajax($data=array()){
        
        extract($data);
        
        $this->db->select("order_type,dryvarfoods_id,driver_id, delivery_fee as total_comission_earned,tips_amount as total_tips_paid");
        $this->db->where("status", 6);
        
        if($from_date!="" || $to_date!=""){
              
            $date_from = strtotime($from_date.' 00:00:00');
            
            if($to_date!=""){
                $date_to = strtotime($to_date.' 23:59:00');
            }else{
                $date_to = strtotime($from_date.' 23:59:00');
            }
            
            $this->db->where('created_at >=', $date_from);
            $this->db->where('created_at <=', $date_to);
        
        }

        if($driver!=""){
            if($driver!="all"){
               $this->db->where('driver_id', $driver);
            }else{
              $this->db->where("driver_id in ($driverid)"); 
            }
        }

        // $this->db->group_by("driver_id");
        $get_data = $this->db->get(db_prefix(). 'orders');
        //echo $this->db->last_query();exit;
        $data_arr = $get_data->result_array(); 
        
        return $data_arr;

    }


	public function get_daily_payout($driver_id, $data = array()){
		    
	    //Total Paid
		extract($data);
		
        $this->db->select("WEEKDAY(from_unixtime(created_at)) as 'Day_name', SUM(delivery_fee) as total_amount");
		$this->db->where('driver_id', $driver_id);
        $this->db->where("status", 6);				
		
        if($from_date!="" || $to_date!=""){
    	
        	$date_from = strtotime($from_date.' 00:00:00');
    		
            if($to_date!=""){
    		  $date_to = strtotime($to_date.' 23:59:00');
    		}else{
    		  $date_to = strtotime($from_date.' 23:59:00');
    		}
    			
    		$this->db->where('created_at >=', $date_from);
    		$this->db->where('created_at <=', $date_to);
		}

		$this->db->group_by('Day_name');
        
        $get_order = $this->db->get(db_prefix(). 'orders');
        $order_arr =  $get_order->result_array();

		return $order_arr;
	}


    //get_daily_payout_detail
    public function get_daily_payout_detail($driver_id,$day,$data){

        extract($data);

        // $get_record = $this->db->query("SELECT * FROM tblorders WHERE driver_id=".$driver_id." AND DAYNAME(created_at) ='".$day."'");
        // $order_arr = $get_record->result_array();
        
        $this->db->select("DAYNAME(created_at) as day_name,order_type,dryvarfoods_id,delivery_fee,subtotal");
        
        $this->db->where('driver_id', $driver_id);
        $this->db->where("status", 6);
        // $this->db->where("day_name", $day_filter);              
        
        // if($from_date!="" || $to_date!=""){
        
        //     $date_from = strtotime($from_date.' 00:00:00');
            
        //     if($to_date!=""){
        //       $date_to = strtotime($to_date.' 23:59:00');
        //     }else{
        //       $date_to = strtotime($from_date.' 23:59:00');
        //     }
                
        //     $this->db->where('created_at >=', $date_from);
        //     $this->db->where('created_at <=', $date_to);
        // }

        // $this->db->group_by('day_name');
        
        $get_order = $this->db->get(db_prefix(). 'orders');
        $order_arr =  $get_order->result_array();

        return $order_arr;

    }//End get_daily_payout_detail
		
}
