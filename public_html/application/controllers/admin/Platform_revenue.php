<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Platform_revenue extends AdminController
{
    /**
     * Codeigniter Instance
     * Expenses detailed report filters use $ci
     * @var object
     */
    private $ci;

    public function __construct()
    {
        parent::__construct();
        if (!has_permission('platform_revenue', '', 'view')) {
            access_denied('platform_revenue');
        }
        $this->ci = &get_instance();
        $this->load->model('platform_revenue_model');
    }

    /* No access on this url */
    public function index()
    {
		$this->load->model("mod_common");
		$data['cities'] = $this->mod_common->get_all_records("tblorders", "DISTINCT(city)", 0, 0, array(), "city", "ASC");
		$data['merchants'] = $this->mod_common->get_all_records("tblclients", "*", 0, 0, array(), "company", "ASC");
		$input = array();
		$data["platform_revenue"] = $this->platform_revenue_model->platform_revenue_report($input);
		$data["total_orders"] = $this->platform_revenue_model->get_merchant_orders($input);
		
		$data["completed_orders"] = $this->platform_revenue_model->get_merchant_orders($input, 6);
		$data["completed_manual_orders"] = $this->platform_revenue_model->get_merchant_orders($input, 6, "manual");
		$data["completed_regular_orders"] = $this->platform_revenue_model->get_merchant_orders($input, 6, "auto");
		
		$data["declined_orders"] = $this->platform_revenue_model->get_merchant_orders($input, 2);
		$data["declined_manual_orders"] = $this->platform_revenue_model->get_merchant_orders($input, 2, "manual");
		$data["declined_regular_orders"] = $this->platform_revenue_model->get_merchant_orders($input, 2, "auto");
		
		$data["incart_orders"] = $this->platform_revenue_model->get_merchant_orders($input, "incart");
		$data["incart_manual_orders"] = $this->platform_revenue_model->get_merchant_orders($input, "incart", "manual");
		$data["incart_regular_orders"] = $this->platform_revenue_model->get_merchant_orders($input, "incart", "auto");
		
		$data["cancelled_orders"] = $this->platform_revenue_model->get_merchant_orders($input, 4);
		$data["cancelled_manual_orders"] = $this->platform_revenue_model->get_merchant_orders($input, 4, "manual");
		$data["cancelled_regular_orders"] = $this->platform_revenue_model->get_merchant_orders($input, 4, "auto");
		$data["title"] = "Platform Revenue";
		$this->load->view("admin/platform_revenue/platform_revenue_report", $data);
    }
	
	 public function platform_revenue_ajax()
    {
		$data = array("year" => $this->input->post("year"), "restaurant_id" => $this->input->post("restaurant_id"), "city" => $this->input->post("city"));
        $data["platform_revenue"] = $this->platform_revenue_model->platform_revenue_report($data);
		$data["total_orders"] = $this->platform_revenue_model->get_merchant_orders($data);
		
		$data["completed_orders"] = $this->platform_revenue_model->get_merchant_orders($data, 6);
		$data["completed_manual_orders"] = $this->platform_revenue_model->get_merchant_orders($data, 6, "manual");
		$data["completed_regular_orders"] = $this->platform_revenue_model->get_merchant_orders($data, 6, "auto");
		
		$data["declined_orders"] = $this->platform_revenue_model->get_merchant_orders($data, 2);
		$data["declined_manual_orders"] = $this->platform_revenue_model->get_merchant_orders($data, 2, "manual");
		$data["declined_regular_orders"] = $this->platform_revenue_model->get_merchant_orders($data, 2, "auto");
		
		$data["incart_orders"] = $this->platform_revenue_model->get_merchant_orders($data, "incart");
		$data["incart_manual_orders"] = $this->platform_revenue_model->get_merchant_orders($data, "incart", "manual");
		$data["incart_regular_orders"] = $this->platform_revenue_model->get_merchant_orders($data, "incart", "auto");
		
		$data["cancelled_orders"] = $this->platform_revenue_model->get_merchant_orders($data, 4);
		$data["cancelled_manual_orders"] = $this->platform_revenue_model->get_merchant_orders($data, 4, "manual");
		$data["cancelled_regular_orders"] = $this->platform_revenue_model->get_merchant_orders($data, 4, "auto");
		
		$data["title"] = "Platform Revenue";
		$this->load->view("admin/platform_revenue/platform_revenue_report_ajax", $data);
    }
	
	public function export_platform_revenue()
     {
         $file_name = 'Platform_Revenue_Report_'.date('Ymd').'.csv'; 
         header("Content-Description: File Transfer"); 
         header("Content-Disposition: attachment; filename=$file_name"); 
         header("Content-Type: application/csv;");
		 
         // get data 
        $data = array("year" => $this->input->post("year"), "restaurant_id" => $this->input->post("restaurant_id"));
        $data["platform_revenue"] = $this->platform_revenue_model->platform_revenue_report($data);
		$platform_revenue_array = array();
		foreach ($data["platform_revenue"] as $key => $value){
			$total_manual_platform_fee = $value["total_manual_orders"]*20;
			$platform_revenue_array[$key]["month"] = $value["month"];
			$platform_revenue_array[$key]["total_sales"] = "R".number_format($value["total_sales"], 2, ".", ",");
			$platform_revenue_array[$key]["total_commission_earned"] = "R".number_format($value["total_comission_earned"], 2, ".", ",");
			$platform_revenue_array[$key]["total_auto_delivery_fee"] = "R".number_format($value["total_auto_delivery_fee"], 2, ".", ",");
			$platform_revenue_array[$key]["total_manual_platform_fee"] = "R".number_format($total_manual_platform_fee, 2, ".", ",");
			$platform_revenue_array[$key]["total_manual_delivery_fee"] = "R".number_format($value["total_manual_delivery_fee"], 2, ".", ",");
		}
  
         // file creation 
         $file = fopen('php://output', 'w');
     
         $header = array("Month","Total Completed Sales","Total Commission Earned","Total Regular Delivery Fee","Total Manual Delivery Platform Fee","Total Manual Delivery Fee"); 
         fputcsv($file, $header);
         foreach ($platform_revenue_array as $key => $value)
         { 
		   
		   
              fputcsv($file, $value); 
			
		   }
         
         fclose($file); 
         exit; 
     }
	 
	public function get_merchants_by_city(){
		$this->load->model("mod_common");
		$city = $this->input->post("city");
		if($city=="all"){
		$data['merchants'] = $this->mod_common->get_all_records("tblclients", "*", 0, 0, array(), "company", "ASC");
        }
        else{
        $data['merchants'] = $this->mod_common->get_all_records("tblclients", "*", 0, 0, array("city" => $city), "company", "ASC");
		
        }			
		$this->load->view("admin/platform_revenue/merchants_ajax", $data);
	}	 

}
