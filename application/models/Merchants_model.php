<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Merchants_model extends App_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     *  Leads conversions monthly report
     * @param   mixed $month  which month / chart
     * @return  array          chart data
     */
	public function revenue_report($data=array()){
		extract($data);
		if($city!=""){
			if($city!="all"){
		$restaurant_list = $this->db->query("SELECT dryvarfoods_id FROM tblclients WHERE city='".$city."'");
		$restaurant_data = $restaurant_list->result_array();
		$restaurant_ids = array();
		foreach($restaurant_data as $val){
			$restaurant_ids[] = $val["dryvarfoods_id"];
		}
			}
		}
		
		$this->db->select("tblorders.restaurant_id, count(*) as total_no_of_orders, MAX(total_amount) as based_revenue, COUNT( if(tblorders.status = 6, 1, NULL)) as total_no_of_completed_orders, COUNT( if(tblorders.status = 0, 1, NULL)) as total_no_of_cart_orders, SUM(CASE 
    WHEN status = 6 
    THEN total_amount 
    ELSE 0 
END) AS total_completed_revenue, SUM(CASE 
    WHEN status = 0 
    THEN total_amount 
    ELSE 0 
END) AS total_cart_revenue");
		if($from_date!="" || $to_date!=""){
		$date_from = strtotime($from_date.' 00:00:00');
		if($to_date!=""){
          $date_to = strtotime($to_date.' 23:59:00');
		}
		else{
			$date_to = strtotime($from_date.' 23:59:00');
		}
			
		$this->db->where('tblorders.created_at >=', $date_from);
        $this->db->where('tblorders.created_at <=', $date_to);
		
		}
		if($city!=""){
			if($city!="all"){
			$this->db->where_in('tblorders.restaurant_id', $restaurant_ids);
			}
		}
		$this->db->group_by("tblorders.restaurant_id");
		$this->db->order_by("total_no_of_completed_orders", "DESC");
		$get_data = $this->db->get(db_prefix(). 'orders');
		$data_arr = $get_data->result_array(); 
		return $data_arr;
	}
	
	public function get_total_customers($id, $data=array()){
		
		extract($data);
		
		$this->db->select("count(distinct(user_id)) as total_customers");
		$this->db->where('restaurant_id', $id);
		$this->db->where('status', 6);
		
		if($from_date!="" || $to_date!=""){
		$date_from = strtotime($from_date.' 00:00:00');
		if($to_date!=""){
          $date_to = strtotime($to_date.' 23:59:00');
		}
		else{
			$date_to = strtotime($from_date.' 23:59:00');
		}
			
		$this->db->where('tblorders.completed_at >=', $date_from);
        $this->db->where('tblorders.completed_at <=', $date_to);
		
		}
		$get_data = $this->db->get(db_prefix(). 'orders');
		$data_arr = $get_data->row_array(); 
		return $data_arr["total_customers"];
	}
	
	public function get_total_sales_revenues($id, $data=array()){
		
		extract($data);
		
		$this->db->select("SUM(total_amount) as total_sales_revenues");
		$this->db->where('restaurant_id', $id);
		$this->db->where('status', 6);
		
		if($from_date!="" || $to_date!=""){
		$date_from = strtotime($from_date.' 00:00:00');
		if($to_date!=""){
          $date_to = strtotime($to_date.' 23:59:00');
		}
		else{
			$date_to = strtotime($from_date.' 23:59:00');
		}
			
		$this->db->where('tblorders.completed_at >=', $date_from);
        $this->db->where('tblorders.completed_at <=', $date_to);
		
		}
		
		$get_data = $this->db->get(db_prefix(). 'orders');
		$data_arr = $get_data->row_array(); 
		return $data_arr["total_sales_revenues"];
	}
	
	public function get_total_commission_earned($id, $data=array()){
		
		extract($data);
		
		$this->db->select("SUM(restaurant_commision_fee) as total_commission_earned");
		$this->db->where('restaurant_id', $id);
		$this->db->where('status', 6);
		
		if($from_date!="" || $to_date!=""){
		$date_from = strtotime($from_date.' 00:00:00');
		if($to_date!=""){
          $date_to = strtotime($to_date.' 23:59:00');
		}
		else{
			$date_to = strtotime($from_date.' 23:59:00');
		}
			
		$this->db->where('tblorders.completed_at >=', $date_from);
        $this->db->where('tblorders.completed_at <=', $date_to);
		
		}
		
		$get_data = $this->db->get(db_prefix(). 'orders');
		$data_arr = $get_data->row_array(); 
		return $data_arr["total_commission_earned"];
	}
	
	public function get_total_weekly_sales_revenue($id, $data=array()){
		
		extract($data);
		
		$this->db->select("week(from_unixtime(completed_at)) as 'Week', AVG(total_amount) as 'total_weekly_sales_revenue'");
		$this->db->where('restaurant_id', $id);
		$this->db->where('status', 6);
		
		if($from_date!="" || $to_date!=""){
		$date_from = strtotime($from_date.' 00:00:00');
		if($to_date!=""){
          $date_to = strtotime($to_date.' 23:59:00');
		}
		else{
			$date_to = strtotime($from_date.' 23:59:00');
		}
			
		$this->db->where('tblorders.completed_at >=', $date_from);
        $this->db->where('tblorders.completed_at <=', $date_to);
		
		}
		
		$this->db->group_by('Week');
		$get_data = $this->db->get(db_prefix(). 'orders');
		
		//echo $this->db->last_query();
		
		$data_arr = $get_data->result_array(); 
		return $data_arr;
	}
	
	public function get_last_30_days_sales_revenue($id){
		$this->db->select("SUM(total_amount) as total");
		$this->db->where('restaurant_id', $id);
		$this->db->where('status', 6);
		
		$from_date = date('Y-m-d', strtotime('-30 days'));;
		$to_date = date("Y-m-d");
		
		$date_from = strtotime($from_date.' 00:00:00');
		$date_to = strtotime($to_date.' 23:59:00');
		
		$this->db->where('tblorders.completed_at >=', $date_from);
        $this->db->where('tblorders.completed_at <=', $date_to);
		$get_data = $this->db->get(db_prefix(). 'orders');
		$data_arr = $get_data->row_array(); 
		return $data_arr["total"];
	}
	
	public function average_revenue_per_order($id, $data=array()){
		
		extract($data);
		
		$this->db->select("AVG(total_amount) as average_revenue");
		$this->db->where('restaurant_id', $id);
		$this->db->where('status', 6);
		
		if($from_date!="" || $to_date!=""){
		$date_from = strtotime($from_date.' 00:00:00');
		if($to_date!=""){
          $date_to = strtotime($to_date.' 23:59:00');
		}
		else{
			$date_to = strtotime($from_date.' 23:59:00');
		}
			
		$this->db->where('tblorders.completed_at >=', $date_from);
        $this->db->where('tblorders.completed_at <=', $date_to);
		
		}
		
		$get_data = $this->db->get(db_prefix(). 'orders');
		$data_arr = $get_data->row_array(); 
		return $data_arr["average_revenue"];
	}
	
	public function average_orders_per_day($id, $data=array()){
		
		extract($data);
		
		$this->db->select("DAYNAME(from_unixtime(completed_at)) as 'Day_name', COUNT(*) as no_of_orders");
		$this->db->where('restaurant_id', $id);
		$this->db->where('status', 6);
		
		if($from_date!="" || $to_date!=""){
		$date_from = strtotime($from_date.' 00:00:00');
		if($to_date!=""){
          $date_to = strtotime($to_date.' 23:59:00');
		}
		else{
			$date_to = strtotime($from_date.' 23:59:00');
		}
			
		$this->db->where('tblorders.completed_at >=', $date_from);
        $this->db->where('tblorders.completed_at <=', $date_to);
		
		}
		
		$this->db->group_by('Day_name');
		$get_data = $this->db->get(db_prefix(). 'orders');
		$data_arr = $get_data->result_array(); 
		$total_no_of_orders = 0;
		foreach($data_arr as $val){
			if($val["Day_name"]!=""){
				$total_no_of_orders += $val["no_of_orders"]/7;
			}
		}
		return $total_no_of_orders;
	}
	
	public function average_orders_per_day_data($id, $data=array()){
		
		extract($data);
		
		$this->db->select("WEEKDAY(from_unixtime(completed_at)) as 'week_day', COUNT(*) as no_of_orders");
		$this->db->where('restaurant_id', $id);
		$this->db->where('status', 6);
		
		if($from_date!="" || $to_date!=""){
		$date_from = strtotime($from_date.' 00:00:00');
		if($to_date!=""){
          $date_to = strtotime($to_date.' 23:59:00');
		}
		else{
			$date_to = strtotime($from_date.' 23:59:00');
		}
			
		$this->db->where('tblorders.completed_at >=', $date_from);
        $this->db->where('tblorders.completed_at <=', $date_to);
		
		}
		
		$this->db->group_by('week_day');
		$get_data = $this->db->get(db_prefix(). 'orders');
		$data_arr = $get_data->result_array(); 
		return $data_arr;
	}
	
	public function prime_busy_days($id, $data=array()){
		
		extract($data);
		
		$this->db->select("WEEKDAY(from_unixtime(completed_at)) as 'week_day', COUNT(*) as no_of_orders");
		$this->db->where('restaurant_id', $id);
		$this->db->where('status', 6);
		
		if($from_date!="" || $to_date!=""){
		$date_from = strtotime($from_date.' 00:00:00');
		if($to_date!=""){
          $date_to = strtotime($to_date.' 23:59:00');
		}
		else{
			$date_to = strtotime($from_date.' 23:59:00');
		}
			
		$this->db->where('tblorders.completed_at >=', $date_from);
        $this->db->where('tblorders.completed_at <=', $date_to);
		
		}
		
		$this->db->group_by('week_day');
		$this->db->order_by('no_of_orders', 'DESC');
		$this->db->limit(2);
		$get_data = $this->db->get(db_prefix(). 'orders');
		$data_arr = $get_data->result_array();
        $days = "";
        	foreach($data_arr as $val){ 
				if($val["week_day"]==0){
		$day_name = "Monday";
	 }
	 else if($val["week_day"]==1){
		$day_name = "Tuesday";
	 }
	 else if($val["week_day"]==2){
		$day_name = "Wednesday";
	 }
	 else if($val["week_day"]==3){
		$day_name = "Thursday";
	 }
	 else if($val["week_day"]==4){
		$day_name = "Friday";
	 }
	 else if($val["week_day"]==5){
		$day_name = "Saturday";
	 }
	 else{
		$day_name = "Sunday";
	 }
				if($val["week_day"]!=""){
				if(count($data_arr)>1){
				$days .= $day_name." , ";
				}
				else{
				 $days .= $day_name;	
				}
				}
			}
				
		return rtrim($days, " , ");
	}
	public function prime_busy_times($id, $data=array()){
		
		extract($data);
		
		$this->db->select("DATE_FORMAT(from_unixtime(completed_at),'%H') as hours, count(*) as no_of_orders");
		$this->db->where('restaurant_id', $id);
		$this->db->where('status', 6);
		
		if($from_date!="" || $to_date!=""){
		$date_from = strtotime($from_date.' 00:00:00');
		if($to_date!=""){
          $date_to = strtotime($to_date.' 23:59:00');
		}
		else{
			$date_to = strtotime($from_date.' 23:59:00');
		}
			
		$this->db->where('tblorders.completed_at >=', $date_from);
        $this->db->where('tblorders.completed_at <=', $date_to);
		
		}
		
		$this->db->group_by('hours');
		$this->db->order_by('no_of_orders', 'DESC');
		$this->db->offset(0);
		$this->db->limit(2);
		$get_data = $this->db->get(db_prefix(). 'orders');
		$data_arr = $get_data->result_array(); 
		$times = "";
		
		foreach($data_arr as $val){
			if($val["hours"]!=""){
				if(count($data_arr)>1){
				$times .= date("h:i A", strtotime($val["hours"].":00"))." , ";
				}
				else{
				 $times .= date("h:i A", strtotime($val["hours"].":00"));	
				}
			}
			}
		return rtrim($times, " , ");
	}
	
	public function prime_busy_days_data($id, $data=array()){
		
		extract($data);
		
		$this->db->select("WEEKDAY(from_unixtime(completed_at)) as 'Day_name', COUNT(*) as no_of_orders");
		$this->db->where('restaurant_id', $id);
		$this->db->where('status', 6);
		
		if($from_date!="" || $to_date!=""){
		$date_from = strtotime($from_date.' 00:00:00');
		if($to_date!=""){
          $date_to = strtotime($to_date.' 23:59:00');
		}
		else{
			$date_to = strtotime($from_date.' 23:59:00');
		}
			
		$this->db->where('tblorders.completed_at >=', $date_from);
        $this->db->where('tblorders.completed_at <=', $date_to);
		
		}
		
		$this->db->group_by('Day_name');
		$this->db->order_by('no_of_orders', 'DESC');
		$get_data = $this->db->get(db_prefix(). 'orders');
		$data_arr = $get_data->result_array();
        return $data_arr;
	}
	public function prime_busy_times_data($id, $data=array()){
		
		extract($data);
		
		$this->db->select("DATE_FORMAT(from_unixtime(completed_at),'%H') as hours, count(*) as no_of_orders");
		$this->db->where('restaurant_id', $id);
		$this->db->where('status', 6);
		
		if($from_date!="" || $to_date!=""){
		$date_from = strtotime($from_date.' 00:00:00');
		if($to_date!=""){
          $date_to = strtotime($to_date.' 23:59:00');
		}
		else{
			$date_to = strtotime($from_date.' 23:59:00');
		}
			
		$this->db->where('tblorders.completed_at >=', $date_from);
        $this->db->where('tblorders.completed_at <=', $date_to);
		
		}
		
		$this->db->group_by('hours');
		$this->db->order_by('no_of_orders', 'DESC');
		$get_data = $this->db->get(db_prefix(). 'orders');
		$data_arr = $get_data->result_array(); 
		
		return $data_arr;
	}
	
	public function get_top_5_meals_total_sales($id, $data=array()){
		
		extract($data);
		
		$this->db->select("SUM(total_amount) as total_sales_revenues");
		$this->db->where('restaurant_id', $id);
		$this->db->where('status', 6);
		
		if($from_date!="" || $to_date!=""){
		$date_from = strtotime($from_date.' 00:00:00');
		if($to_date!=""){
          $date_to = strtotime($to_date.' 23:59:00');
		}
		else{
			$date_to = strtotime($from_date.' 23:59:00');
		}
			
		$this->db->where('tblorders.completed_at >=', $date_from);
        $this->db->where('tblorders.completed_at <=', $date_to);
		
		}
		
		$get_data = $this->db->get(db_prefix(). 'orders');
		$data_arr = $get_data->row_array(); 
		return $data_arr["total_sales_revenues"];
	}
	
	public function get_top_meals($data=array()){
	extract($data);
	$query = $this->db->query("SELECT m.name, o.menu_item_id, count(o.menu_item_id) as total_count FROM `tblorder_item` o INNER JOIN tblmenu_item m ON m.dryvarfoods_id = o.menu_item_id WHERE o.order_id IN (select dryvarfoods_id from tblorders where restaurant_id = ".$restaurant_id." AND completed_at >= ".strtotime($from_date.' 00:00:00')." AND completed_at <= ".strtotime($to_date.' 23:59:00')." AND status=6) group by o.menu_item_id ORDER BY total_count DESC LIMIT 10");
	//echo $this->db->last_query();exit;
	if($query->num_rows()>0){
	$result = $query->result_array();
	}
	else{
		$result = array();
	}
	return $result;
	}
	
	public function get_sales_daywise($id, $data=array()){
		
		extract($data);
		
		$this->db->select("date(from_unixtime(completed_at)) as 'Day', SUM(total_amount) as 'total_daily_sales_revenue'");
		$this->db->where('restaurant_id', $id);
		$this->db->where('status', 6);
		
		if($from_date!="" || $to_date!=""){
		$date_from = strtotime($from_date.' 00:00:00');
		if($to_date!=""){
          $date_to = strtotime($to_date.' 23:59:00');
		}
		else{
			$date_to = strtotime($from_date.' 23:59:00');
		}
			
		$this->db->where('tblorders.completed_at >=', $date_from);
        $this->db->where('tblorders.completed_at <=', $date_to);
		
		}
		
		$this->db->group_by('Day');
		$get_data = $this->db->get(db_prefix(). 'orders');
		
		//echo $this->db->last_query();
		
		$data_arr = $get_data->result_array(); 
		return $data_arr;
	}
	
	
	public function get_total_orders_stats($id, $data=array()){
		
		extract($data);
		
		$this->db->select("COUNT(*) as total_orders, COUNT( if(accepted_at>0, 1, NULL)) as total_accept_orders , COUNT( if(tblorders.cancelled_at>0 OR declined_at>0, 1, NULL)) as total_cancel_orders");
		$this->db->where('restaurant_id', $id);
		
		if($from_date!="" || $to_date!=""){
		$date_from = strtotime($from_date.' 00:00:00');
		if($to_date!=""){
          $date_to = strtotime($to_date.' 23:59:00');
		}
		else{
			$date_to = strtotime($from_date.' 23:59:00');
		}
			
		$this->db->where('tblorders.created_at >=', $date_from);
        $this->db->where('tblorders.created_at <=', $date_to);
		
		}
		
		$get_data = $this->db->get(db_prefix(). 'orders');
		
		//echo $this->db->last_query();
		
		$data_arr = $get_data->row_array(); 
		return $data_arr;
	}
	
	
	
}
