<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Platform_revenue_model extends App_Model
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
   
	public function platform_revenue_report($data=array()){
		extract($data);
		$this->db->select("MONTHNAME(from_unixtime(created_at)) as month, YEAR(from_unixtime(created_at)) as year, SUM(total_amount) as total_sales, SUM(restaurant_commision_fee) as total_comission_earned, SUM(CASE WHEN order_type = 'manual' THEN delivery_fee ELSE 0 END) AS total_manual_delivery_fee, SUM(CASE WHEN order_type != 'manual' THEN delivery_fee ELSE 0 END) AS total_auto_delivery_fee, COUNT( if(order_type = 'manual', 1, NULL)) as total_manual_orders");
		$this->db->where("status", 6);
		if(isset($restaurant_id) && $restaurant_id!="all"){
		$this->db->where("restaurant_id", $restaurant_id);
		}
		if(isset($city) && $city!="all"){
		$this->db->where("city", $city);
		}
		if(isset($year) && $year!=""){
		$this->db->where("year(from_unixtime(created_at))", $year);
		}
		$this->db->group_by("month");
		$this->db->order_by("MONTH(from_unixtime(created_at))", "ASC");
		$get_data = $this->db->get(db_prefix(). 'orders');
		//echo $this->db->last_query();
		$data_arr = $get_data->result_array(); 
		return $data_arr;
	}
	
	public function get_merchant_orders($data=array(), $status="", $type=""){
		extract($data);
		$this->db->select("count(*) as total_orders");
		if($status!=""){
		if($status=="incart"){
			$status = 0;
		}
		$this->db->where("status", $status);
		}
		if($type!=""){
		$this->db->where("order_type", $type);
		}
		if(isset($city) && $city!="all"){
		$this->db->where("city", $city);
		}
		if(isset($restaurant_id) && $restaurant_id!="all"){
		   $this->db->where("restaurant_id", $restaurant_id);
		}
		if(isset($year) && $year!=""){
		  $this->db->where("year(from_unixtime(created_at))", $year);
		}
		$get_data = $this->db->get(db_prefix(). 'orders');
		$data_arr = $get_data->row_array(); 
		return $data_arr["total_orders"];
	}
	
	
}
