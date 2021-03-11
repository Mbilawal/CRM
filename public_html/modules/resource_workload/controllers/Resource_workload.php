<?php

defined('BASEPATH') or exit('No direct script access allowed');
/**
 * This class describes a resource workload.
 */
class Resource_workload extends AdminController {
	public function __construct() {
		parent::__construct();
		$this->load->model('resource_workload_model');
		$this->load->model('departments_model');
		$this->load->model('roles_model');
		$this->load->model('projects_model');

	}
	/**
	 * manage resource workload
	 * @return view
	 */
	public function index() {
		$this->load->model('staff_model');
		$data_fill = [];
		$data_fill['staff'] = [];
		$data_fill['department'] = [];
		$data_fill['role'] = [];
		$data_fill['project'] = [];
		$data_fill['from_date'] = date('Y-m-d', strtotime('-7 day', strtotime(date('Y-m-d'))));
		$data_fill['to_date'] = date('Y-m-d');
		$data['data_workload'] = $this->resource_workload_model->get_data_workload($data_fill);
		$data['data_timeline'] = $this->resource_workload_model->get_data_timeline($data_fill);
		$data['nestedheaders'] = $this->resource_workload_model->get_nestedheaders_workload(date('Y-m-d', strtotime('-7 day', strtotime(date('Y-m-d')))), date('Y-m-d'));
		$data['columns'] = $this->resource_workload_model->get_columns_workload(date('Y-m-d', strtotime('-7 day', strtotime(date('Y-m-d')))), date('Y-m-d'));
		$data['staffs'] = $this->staff_model->get();
		$data['projects'] = $this->projects_model->get();
		$data['departments'] = $this->departments_model->get();
		$data['roles'] = $this->roles_model->get();
		$data['title'] = _l('resource_workload');

		$data['estimate_stats'] = json_encode($this->resource_workload_model->estimate_stats($data['data_workload']));
		$department_stats = $this->resource_workload_model->department_stats($data['data_workload']);
		$data['department_stats'] = json_encode($department_stats['department_stats']);
		$data['column_department'] = json_encode($department_stats['column_department']);
		$data['spent_stats'] = json_encode($this->resource_workload_model->spent_stats($data['data_workload']));

		$this->load->view('resource_workload', $data);
	}

	/**
	 * Gets the data workload.
	 * @return json data workload
	 */
	public function get_data_workload() {
		$data = $this->input->post();
		$data_workload = $this->resource_workload_model->get_data_workload($data);
		$nestedheaders = $this->resource_workload_model->get_nestedheaders_workload($data['from_date'], $data['to_date']);
		$columns = $this->resource_workload_model->get_columns_workload($data['from_date'], $data['to_date']);
		echo json_encode([
			'columns' => $columns,
			'nestedheaders' => $nestedheaders,
			'data_workload' => $data_workload['data'],
			'data_tooltip' => $data_workload['data_tooltip'],
		]);
		die();
	}

	/**
	 * Gets the data timeline.
	 * @return json data timeline
	 */
	public function get_data_timeline() {
		$data = $this->input->post();
		$data_timeline = $this->resource_workload_model->get_data_timeline($data);
		echo json_encode([
			'data_timeline' => $data_timeline,
		]);
		die();
	}

	/**
	 * Gets the data chart.
	 * @return json data chart
	 */
	public function get_data_chart() {
		$data = $this->input->post();
		$data_workload = $this->resource_workload_model->get_data_workload($data);
		$nestedheaders = $this->resource_workload_model->get_nestedheaders_workload($data['from_date'], $data['to_date']);
		$columns = $this->resource_workload_model->get_columns_workload($data['from_date'], $data['to_date']);
		echo json_encode([
			'columns' => $columns,
			'nestedheaders' => $nestedheaders,
			'data_workload' => $data_workload['data'],
			'data_tooltip' => $data_workload['data_tooltip'],
		]);
		die();
	}
}