<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Merchants extends AdminController
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
        if (!has_permission('merchants', '', 'view')) {
            access_denied('merchants');
        }
        $this->ci = &get_instance();
        $this->load->model('merchants_model');
    }

    /* No access on this url */
    public function index()
    {
        redirect(admin_url());
    }

	public function revenue_report(){
		$this->load->model("mod_common");
		$data['cities'] = $this->mod_common->get_all_records("tblorders", "DISTINCT(city)", 0, 0, array(), "city", "ASC");
		$today = array("from_date" => date('Y-m-d'));
		$data["revenue"] = $this->merchants_model->revenue_report($today);
		$data["title"] = "Merchants Revenue Report";
		$this->load->view("admin/merchants/revenue", $data);
	}
	
	public function revenue_report_ajax(){
		$this->load->model("mod_common");
		$data['cities'] = $this->mod_common->get_all_records("tblorders", "DISTINCT(city)", 0, 0, array(), "city", "ASC");
		$data["revenue"] = $this->merchants_model->revenue_report($this->input->post());
		$data["city"] = $this->input->post("city");
		$data["title"] = "Merchants Revenue Report";
		$this->load->view("admin/merchants/revenue_ajax", $data);
	} 

    public function report($id){
		$this->load->model("mod_common");
		$data["restaurant_id"] = $id;
		$today = array("from_date" => date('Y-m-d'));
		$data["total_customers"] = $this->merchants_model->get_total_customers($id, $today);
		$data["total_sales_revenue"] = $this->merchants_model->get_total_sales_revenues($id, $today);
		$data["total_comission_earned"] = $this->merchants_model->get_total_commission_earned($id, $today);
		$data["total_weekly_sales_revenue"] = $this->merchants_model->get_total_weekly_sales_revenue($id, $today);
		$data["last_30_days_sales_revenue"] = $this->merchants_model->get_last_30_days_sales_revenue($id, $today);
		$data["average_revenue_per_order"] = $this->merchants_model->average_revenue_per_order($id, $today);
		$data["average_orders_per_day_data"] = $this->merchants_model->average_orders_per_day_data($id, $today);
		$data["average_orders_per_day"] = $this->merchants_model->average_orders_per_day($id, $today);
		$data["prime_busy_days"] = $this->merchants_model->prime_busy_days($id, $today);
		$data["prime_busy_days_data"] = $this->merchants_model->prime_busy_days_data($id, $today);
		$data["prime_busy_times"] = $this->merchants_model->prime_busy_times($id, $today);
		$data["prime_busy_times_data"] = $this->merchants_model->prime_busy_times_data($id, $today);
		$data["title"] = "Merchant Report";
		$this->load->view("admin/merchants/report", $data);
	}	
	
	public function report_ajax($id){
		$this->load->model("mod_common");
		$data["restaurant_id"] = $id;
		$data["total_customers"] = $this->merchants_model->get_total_customers($id, $this->input->post());
		$data["total_sales_revenue"] = $this->merchants_model->get_total_sales_revenues($id, $this->input->post());
		$data["total_comission_earned"] = $this->merchants_model->get_total_commission_earned($id, $this->input->post());
		$data["total_weekly_sales_revenue"] = $this->merchants_model->get_total_weekly_sales_revenue($id, $this->input->post());
		$data["last_30_days_sales_revenue"] = $this->merchants_model->get_last_30_days_sales_revenue($id, $this->input->post());
		$data["average_revenue_per_order"] = $this->merchants_model->average_revenue_per_order($id, $this->input->post());
		$data["average_orders_per_day_data"] = $this->merchants_model->average_orders_per_day_data($id, $this->input->post());
		$data["average_orders_per_day"] = $this->merchants_model->average_orders_per_day($id, $this->input->post());
		$data["prime_busy_days"] = $this->merchants_model->prime_busy_days($id, $this->input->post());
		$data["prime_busy_days_data"] = $this->merchants_model->prime_busy_days_data($id, $this->input->post());
		$data["prime_busy_times"] = $this->merchants_model->prime_busy_times($id, $this->input->post());
		$data["prime_busy_times_data"] = $this->merchants_model->prime_busy_times_data($id, $this->input->post());
		$data["title"] = "Merchant Report";
		$this->load->view("admin/merchants/report_ajax", $data);
	}	

    public function top_meals_report(){
		$data["title"] = "Merchant Top Meals Report";
		$this->load->model("mod_common");
		$data['restaurants'] = $this->mod_common->get_all_records("tblclients", "*", 0, 0, array(), "company", "ASC");
		$this->load->view("admin/merchants/top_meals", $data);
	}	
	
	public function top_meals_report_ajax(){
		$id = $this->input->post("restaurant_id");
		$data["total_sales"] = $this->merchants_model->get_total_sales_revenues($id, $this->input->post());
		$data["meals"] = $this->merchants_model->get_top_meals($this->input->post());
		$data["daily_sales"] = $this->merchants_model->get_sales_daywise($id, $this->input->post());
		$data["order_stats"] = $this->merchants_model->get_total_orders_stats($id, $this->input->post());
		$data["title"] = "Merchant Top Meals Report";
		$this->load->view("admin/merchants/top_meals_ajax", $data);
	}	
	
	public function export_top_meals_report(){
		$id = $this->input->post("restaurant_id");
		$data["total_sales"] = $this->merchants_model->get_total_sales_revenues($id, $this->input->post());
		$data["meals"] = $this->merchants_model->get_top_meals($this->input->post());
		$data["daily_sales"] = $this->merchants_model->get_sales_daywise($id, $this->input->post());
		$data["order_stats"] = $this->merchants_model->get_total_orders_stats($id, $this->input->post());
		$data["title"] = "Merchant Top Meals Report";
		$html = $this->load->view("admin/merchants/top_meals_pdf", $data, true);
		//load mPDF library
        $this->load->library('M_pdf');

       //generate the PDF from the given html
        $this->m_pdf->pdf->WriteHTML($html);
 
        //download it.
        $this->m_pdf->pdf->Output("Merchant_Top_Meals_Report.pdf", "D");  
	}	

}
