<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Orders_dashboard extends AdminController
{
    /* List all clients */
    public function index(){
        
    	$data['title']  = _l('Orders Dashboard');
    	$data['cities'] = $this->clients_model->get_all_cities();

		$data['orders_count']           = $this->clients_model->count_orders('',$_GET);
		$data['orders_count_completed'] = $this->clients_model->count_orders(6,$_GET);
		$data['orders_count_pending']   = $this->clients_model->count_orders(1,$_GET);
		$data['orders_count_declined']  = $this->clients_model->count_orders(2,$_GET);
		$data['orders_count_cancelled'] = $this->clients_model->count_orders(4,$_GET);
		$data['order_status_graph']     = $this->clients_model->order_status_graph($_GET);
		$data['pie_chart']              = $this->clients_model->get_area_order_stats($_GET);
		
        $this->load->view('admin/clients/orders_dashboard', $data);
    }
	
	public function orders_report_ajax(){
		$this->load->model("mod_common");
		$data["title"]                  = "Order Report";
		$data['orders_count']           = $this->clients_model->count_orders_ajax('',$_POST);
		$data['orders_count_completed'] = $this->clients_model->count_orders_ajax(6,$_POST);
		$data['orders_count_pending']   = $this->clients_model->count_orders_ajax(1,$_POST);
		$data['orders_count_declined']  = $this->clients_model->count_orders_ajax(2,$_POST);
		$data['orders_count_cancelled'] = $this->clients_model->count_orders_ajax(4,$_POST);
		
		$this->load->view("admin/clients/orders_report_ajax", $data);
	}// orders_report_ajax

}