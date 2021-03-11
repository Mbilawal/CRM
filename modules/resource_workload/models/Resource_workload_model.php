<?php

defined('BASEPATH') or exit('No direct script access allowed');
/**
 * This class describes a resource workload model.
 */
class Resource_workload_model extends App_Model {
	public function __construct() {
		parent::__construct();
	}
	/**
	 * Gets the data workload.
	 *
	 * @param      object  $data_fill  The data fill
	 *
	 * @return     array   The data workload.
	 */
	public function get_data_workload($data_fill) {

		$from_date = $data_fill['from_date'];
		$to_date = $data_fill['to_date'];
		$staffs = $this->get_staff_workload($data_fill);
		$data = [];
		$data_tooltip = [];
		foreach ($staffs as $key => $value) {
			$row = [];
			$row['staff_id'] = $value['staffid'];
			$row['staff_name'] = $value['full_name'];
			$row['staff_role'] = $value['role_name'];
			$department = $this->departments_model->get_staff_departments($value['staffid']);
			if (isset($department[0])) {
				$row['staff_department'] = $department[0]['name'];
			} else {
				$row['staff_department'] = '';
			}

			$row = $this->create_array_data_workload($from_date, $to_date, $row);
			$data_tooltip_2 = $this->create_array_data_tooltip_workload($value['staffid'], $from_date, $to_date, []);
			$staff_task = $this->tasks_model->get_tasks_by_staff_id($value['staffid']);
			foreach ($staff_task as $key_task => $task) {
				$note = [];
				$note['total_time'] = seconds_to_time_format($this->tasks_model->calc_task_total_time($task['id'], ' AND staff_id=' . $value['staffid']));
				$note['estimate_hour'] = $this->get_estimate_hour($task['id']);

				$row['staff_time'][] = $note;

				$number_day = (strtotime($task['duedate']) - strtotime($task['startdate'])) / (60 * 60 * 24);
				if ($number_day >= 0) {
					$note['total_time'] = round((float) $note['total_time'] / ($number_day + 1), 1);
					$note['estimate_hour'] = round((float) $note['estimate_hour'] / ($number_day + 1), 1);
				}

				if ($number_day >= 0) {
					$f_date = $task['startdate'];
					$t_date = $task['duedate'];
					while (strtotime($f_date) <= strtotime($t_date)) {
						if (isset($row[date('d_m', strtotime($f_date)) . '_e'])) {
							$row[date('d_m', strtotime($f_date)) . '_e'] += $note['estimate_hour'];
							$data_tooltip_2[$value['staffid'] . '_' . date('d_m', strtotime($f_date)) . '_e'] .= $task['name'] . ': ' . $note['estimate_hour'] . ' ' . _l('hours') . "\n";
						}
						if (isset($row[date('d_m', strtotime($f_date)) . '_s'])) {
							$row[date('d_m', strtotime($f_date)) . '_s'] += $note['total_time'];
							$data_tooltip_2[$value['staffid'] . '_' . date('d_m', strtotime($f_date)) . '_s'] .= $task['name'] . ': ' . $note['total_time'] . ' ' . _l('hours') . "\n";
						}

						$f_date = date('Y-m-d', strtotime('+1 day', strtotime($f_date)));
					}
				} else {
					if (isset($row[date('d_m', strtotime($task['startdate'])) . '_e'])) {
						$row[date('d_m', strtotime($task['startdate'])) . '_e'] += $note['estimate_hour'];
						$data_tooltip_2[$value['staffid'] . '_' . date('d_m', strtotime($task['startdate'])) . '_e'] .= $task['name'] . ': ' . $note['estimate_hour'] . ' ' . _l('hours') . "\n";
					}
					if (isset($row[date('d_m', strtotime($task['startdate'])) . '_s'])) {
						$row[date('d_m', strtotime($task['startdate'])) . '_s'] += $note['total_time'];
						$data_tooltip_2[$value['staffid'] . '_' . date('d_m', strtotime($task['startdate'])) . '_s'] .= $task['name'] . ': ' . $note['total_time'] . ' ' . _l('hours') . "\n";
					}
				}
			}
			$int = 4;
			foreach ($data_tooltip_2 as $key_tooltip => $tooltip) {
				$n = [];
				$n['row'] = $key;
				$n['col'] = $int;
				$n['comment'] = ['value' => $tooltip];
				array_push($data_tooltip, $n);
				$int++;
			}
			$data[] = $row;
		}
		$data_return = [];
		$data_return['data'] = $data;
		$data_return['data_tooltip'] = $data_tooltip;
		//var_dump($data_return);die;
		return $data_return;
	}

	/**
	 * Gets the data timeline.
	 *
	 * @param      object  $data_fill  The data fill
	 *
	 * @return     array   The data timeline.
	 */
	public function get_data_timeline($data_fill) {

		$from_date = $data_fill['from_date'];
		$to_date = $data_fill['to_date'];
		$staffs = $this->get_staff_workload($data_fill);

		$data = [];
		$data_tooltip = [];
		$data_color = [];
		$data_check = [];
		foreach ($staffs as $key => $value) {
			$row = [];
			$row['id'] = 'staff_' . $value['staffid'];
			$row['start'] = $from_date;
			$row['end'] = $to_date;
			$row['name'] = $value['full_name'];
			$data[] = $row;

			$staff_task = $this->tasks_model->get_tasks_by_staff_id($value['staffid']);
			foreach ($staff_task as $key_task => $task) {
				if (strtotime($to_date) < strtotime($task['startdate'])) {
					continue;
				} elseif (strtotime($from_date) > strtotime($task['duedate']) && $task['duedate'] != null) {
					continue;
				} elseif (strtotime($from_date) > strtotime($task['duedate']) && strtotime($from_date) > strtotime($task['startdate']) && $task['duedate'] != null) {
					continue;
				}
				$note = [];
				$note['start'] = $task['startdate'];
				$note['progress'] = 100;
				$status = get_task_status_by_id($task['status']);
				$note['name'] = $task['name'] . ' - ' . $status['name'];
				$note['id'] = $task['id'];
				$note['dependencies'] = 'staff_' . $value['staffid'];
				if ($task['duedate'] != null) {
					$note['end'] = $task['duedate'];
				} else {
					$note['end'] = $to_date;
				}
				$note['total_time'] = seconds_to_time_format($this->tasks_model->calc_task_total_time($task['id'], ' AND staff_id=' . $value['staffid']));
				$note['estimate_hour'] = $this->get_estimate_hour($task['id']);

				switch ($task['rel_type']) {
				case 'project':
					$note['custom_class'] = 'br_project';
					break;
				case 'ticket':
					$note['custom_class'] = 'br_ticket';
					break;
				case 'lead':
					$note['custom_class'] = 'br_lead';
					break;
				case 'customer':
					$note['custom_class'] = 'br_customer';
					break;
				case 'contract':
					$note['custom_class'] = 'br_contract';
					break;
				case 'invoice':
					$note['custom_class'] = 'br_invoice';
					break;
				case 'estimate':
					$note['custom_class'] = 'br_estimate';
					break;
				case 'proposal':
					$note['custom_class'] = 'br_proposal';
					break;
				}
				$data[] = $note;
			}
			$int = 4;
		}
		if ($data == []) {
			$data[][] = [];
		}
		return $data;
	}

	/**
	 * Creates an array data workload.
	 *
	 * @param      String  $from_date  The from date format dd/mm/YYYY
	 * @param      String  $to_date    To date format dd/mm/YYYY
	 * @param      array   $array      The array
	 *
	 * @return     array
	 */
	public function create_array_data_workload($from_date, $to_date, $array) {
		$from_date = to_sql_date($from_date);
		$to_date = to_sql_date($to_date);
		while (strtotime($from_date) <= strtotime($to_date)) {

			$array[date('d_m', strtotime($from_date)) . '_e'] = 0;
			$array[date('d_m', strtotime($from_date)) . '_s'] = 0;
			$from_date = date('Y-m-d', strtotime('+1 day', strtotime($from_date)));
		}
		return $array;
	}

	/**
	 * Creates an array data timeline.
	 *
	 * @param      String  $from_date  The from date format dd/mm/YYYY
	 * @param      String  $to_date    To date format dd/mm/YYYY
	 * @param      array   $array      The array
	 *
	 * @return     array
	 */
	public function create_array_data_timeline($from_date, $to_date, $array) {
		$from_date = to_sql_date($from_date);
		$to_date = to_sql_date($to_date);
		while (strtotime($from_date) <= strtotime($to_date)) {
			$array[date('d_m', strtotime($from_date))] = [];
			$from_date = date('Y-m-d', strtotime('+1 day', strtotime($from_date)));
		}
		return $array;
	}

	/**
	 * Creates an array data tooltip workload.
	 *
	 * @param      string  $staffid    The staffid
	 * @param      string  $from_date  The from date format dd/mm/YYYY
	 * @param      string  $to_date    To date format dd/mm/YYYY
	 * @param      array   $array      The array
	 *
	 * @return     array
	 */
	public function create_array_data_tooltip_workload($staffid, $from_date, $to_date, $array) {
		$from_date = to_sql_date($from_date);
		$to_date = to_sql_date($to_date);
		while (strtotime($from_date) <= strtotime($to_date)) {
			$array[$staffid . '_' . date('d_m', strtotime($from_date)) . '_e'] = '';
			$array[$staffid . '_' . date('d_m', strtotime($from_date)) . '_s'] = '';
			$from_date = date('Y-m-d', strtotime('+1 day', strtotime($from_date)));
		}
		return $array;
	}

	/**
	 * Creates an array data tooltip timeline.
	 *
	 * @param      string  $staffid    The staffid
	 * @param      string  $from_date  The from date format dd/mm/YYYY
	 * @param      string  $to_date    To date format dd/mm/YYYY
	 * @param      array   $array      The array
	 *
	 * @return     array
	 */
	public function create_array_data_tooltip_timeline($staffid, $from_date, $to_date, $array) {
		$from_date = to_sql_date($from_date);
		$to_date = to_sql_date($to_date);
		while (strtotime($from_date) <= strtotime($to_date)) {
			$array[$staffid . '_' . date('d_m', strtotime($from_date))] = '';
			$from_date = date('Y-m-d', strtotime('+1 day', strtotime($from_date)));
		}
		return $array;
	}

	/**
	 * Gets the nestedheaders workload.
	 *
	 * @param      string  $from_date  The from date format dd/mm/YYYY
	 * @param      string  $to_date    To date format dd/mm/YYYY
	 *
	 * @return     array   The nestedheaders workload.
	 */
	public function get_nestedheaders_workload($from_date, $to_date) {
		$from_date = to_sql_date($from_date);
		$to_date = to_sql_date($to_date);
		$nestedheaders = [];
		$nestedheaders[0] = [['label' => _l('staff'), 'colspan' => 4]];
		$nestedheaders[1] = [_l('name'), '', _l('department'), _l('role')];
		while (strtotime($from_date) <= strtotime($to_date)) {

			array_push($nestedheaders[0], ['label' => date('l d/m', strtotime($from_date)), 'colspan' => 2]);
			array_push($nestedheaders[1], 'E');
			array_push($nestedheaders[1], 'S');
			$from_date = date('Y-m-d', strtotime('+1 day', strtotime($from_date)));
		}
		return $nestedheaders;
	}

	/**
	 * Gets the nestedheaders timeline.
	 *
	 * @param      string  $from_date  The from date format dd/mm/YYYY
	 * @param      string  $to_date    To date format dd/mm/YYYY
	 *
	 * @return     array   The nestedheaders timeline.
	 */
	public function get_nestedheaders_timeline($from_date, $to_date) {

		$from_date = to_sql_date($from_date);
		$to_date = to_sql_date($to_date);
		$nestedheaders = [];
		$nestedheaders[0] = [['label' => _l('staff'), 'colspan' => 4]];
		$nestedheaders[1] = [_l('name'), '', _l('department'), _l('role')];
		while (strtotime($from_date) <= strtotime($to_date)) {

			array_push($nestedheaders[1], date('l d/m', strtotime($from_date)));
			$from_date = date('Y-m-d', strtotime('+1 day', strtotime($from_date)));
		}
		return $nestedheaders;
	}

	/**
	 * Gets the columns workload.
	 *
	 * @param      string  $from_date  The from date format dd/mm/YYYY
	 * @param      string  $to_date    To date format dd/mm/YYYY
	 *
	 * @return     array   The columns workload.
	 */
	public function get_columns_workload($from_date, $to_date) {
		$from_date = to_sql_date($from_date);
		$to_date = to_sql_date($to_date);
		$columns = [['data' => 'staff_name', 'type' => 'text', 'readOnly' => true],
			['data' => 'staff_id', 'type' => 'text', 'readOnly' => true],
			['data' => 'staff_department', 'type' => 'text', 'readOnly' => true],
			['data' => 'staff_role', 'type' => 'text', 'readOnly' => true]];
		while (strtotime($from_date) <= strtotime($to_date)) {

			array_push($columns, ['data' => date('d_m', strtotime($from_date)) . '_e', 'type' => 'numeric', 'readOnly' => true, 'numericFormat' => [
				'pattern' => '0.0',
			]]);
			array_push($columns, ['data' => date('d_m', strtotime($from_date)) . '_s', 'type' => 'numeric', 'readOnly' => true, 'numericFormat' => [
				'pattern' => '0.0',
			]]);
			$from_date = date('Y-m-d', strtotime('+1 day', strtotime($from_date)));
		}
		return $columns;
	}

	/**
	 * Gets the columns timeline.
	 *
	 * @param      string  $from_date  The from date format dd/mm/YYYY
	 * @param      string  $to_date    To date format dd/mm/YYYY
	 *
	 * @return     array   The columns timeline.
	 */
	public function get_columns_timeline($from_date, $to_date) {
		$from_date = to_sql_date($from_date);
		$to_date = to_sql_date($to_date);
		$columns = [['data' => 'staff_name', 'type' => 'text', 'readOnly' => true],
			['data' => 'staff_id', 'type' => 'text', 'readOnly' => true],
			['data' => 'staff_department', 'type' => 'text', 'readOnly' => true],
			['data' => 'staff_role', 'type' => 'text', 'readOnly' => true]];
		while (strtotime($from_date) <= strtotime($to_date)) {
			array_push($columns, ['data' => date('d_m', strtotime($from_date)), 'type' => 'numeric', 'readOnly' => true, 'numericFormat' => [
				'pattern' => '0.0',
			]]);
			$from_date = date('Y-m-d', strtotime('+1 day', strtotime($from_date)));
		}
		return $columns;
	}

	/**
	 * Gets the staff workload.
	 *
	 * @param      object  $data   The data
	 *
	 * @return     array   The staff workload.
	 */
	public function get_staff_workload($data) {
		$where_project = '';
		if (!empty($data['project'])) {
			foreach ($data['project'] as $key => $value) {
				if ($where_project == '') {
					$where_project .= '(project_members.project_id = ' . $value;
				} else {
					$where_project .= ' or project_members.project_id = ' . $value;
				}
			}
			$where_project .= ')';
		}
		$where_department = '';
		if (!empty($data['department'])) {
			foreach ($data['department'] as $key => $value) {
				if ($where_department == '') {
					$where_department .= '(staff_departments.departmentid = ' . $value;
				} else {
					$where_department .= ' or staff_departments.departmentid = ' . $value;
				}
			}
			$where_department .= ')';
		}
		$where_role = '';
		if (!empty($data['role'])) {
			foreach ($data['role'] as $key => $value) {
				if ($where_role == '') {
					$where_role .= '(staff.role = ' . $value;
				} else {
					$where_role .= ' or staff.role = ' . $value;
				}
			}
			$where_role .= ')';
		}
		$where_staff = '';
		if (!empty($data['staff'])) {
			foreach ($data['staff'] as $key => $value) {
				if ($where_staff == '') {
					$where_staff .= '(staff.staffid = ' . $value;
				} else {
					$where_staff .= ' or staff.staffid = ' . $value;
				}
			}
			$where_staff .= ')';
		}

		$this->db->select('*, CONCAT(firstname, \' \', lastname) as full_name,' . db_prefix() . 'staff.staffid as staffid, ' . db_prefix() . 'roles.name as role_name');
		$this->db->join(db_prefix() . 'roles', db_prefix() . 'staff.role=' . db_prefix() . 'roles.roleid', 'left');
		$this->db->join(db_prefix() . 'project_members', db_prefix() . 'staff.staffid=' . db_prefix() . 'project_members.staff_id', 'left');
		$this->db->join(db_prefix() . 'staff_departments', db_prefix() . 'staff.staffid=' . db_prefix() . 'staff_departments.staffid', 'left');

		if ($where_role !== '') {
			$this->db->where($where_role);
		}
		if ($where_department !== '') {
			$this->db->where($where_department);
		}
		if ($where_project !== '') {
			$this->db->where($where_project);
		}
		if ($where_staff !== '') {
			$this->db->where($where_staff);
		}

		$list_staffs = $this->db->get(db_prefix() . 'staff')->result_array();
		$list = [];
		$list_return = [];
		foreach ($list_staffs as $key => $value) {
			if (!in_array($value['staffid'], $list)) {
				$list_return[] = $value;
				$list[] = $value['staffid'];
			}
		}
		return $list_return;
	}

	/**
	 * Gets the name relative type.
	 *
	 * @param      int  $id        The identifier
	 * @param      string  $rel_type  The relative type
	 *
	 * @return     string  The name relative type.
	 */
	public function get_name_rel_type($id, $rel_type) {
		switch ($rel_type) {
		case 'project':
			$this->load->model('Projects_model');
			return $this->Projects_model->get($id)->name;
			break;
		case 'ticket':
			$this->load->model('Tickets_model');
			return $this->Tickets_model->get($id)->subject;
			break;
		case 'lead':
			$this->load->model('Leads_model');
			return $this->Leads_model->get($id)->name;
			break;
		case 'customer':
			$this->load->model('Clients_model');
			return $this->Clients_model->get($id)->company;
			break;
		case 'contract':
			$this->load->model('Contracts_model');
			return $this->Contracts_model->get($id)->subject;
			break;
		case 'invoice':
			return format_invoice_number($id);
			break;
		case 'estimate':
			$this->load->model('Estimates_model');
			return $this->Estimates_model->get($id)->category_name;
			break;
		case 'proposal':
			return format_proposal_number($id);
			break;
		case 'account_planning':
			$this->db->where('id', $id);
			return $this->db->get(db_prefix() . 'account_planning')->row()->subject;
			break;
		default:
			return '';
			break;
		}
	}

	/**
	 * Gets the color relative type.
	 *
	 * @param      string  $rel_type  The relative type
	 *
	 * @return     string  The color relative type.
	 */
	public function get_color_rel_type($rel_type) {
		switch ($rel_type) {
		case 'project':
			return '84C529';
			break;
		case 'ticket':
			return '8085E9';
			break;
		case 'lead':
			return 'cc66ff';
			break;
		case 'customer':
			return '03a9f4';
			break;
		case 'contract':
			return 'ff6f00';
			break;
		case 'invoice':
			return 'ff9900';
			break;
		case 'estimate':
			return 'ff5050';
			break;
		case 'proposal':
			return '3333cc';
			break;
		case 'account_planning':
			return '993333';
			break;
		case 'expense':
			return '2af509';
			break;
		default:
			return '';
			break;
		}
	}

	/**
	 * get data estimate stats
	 *
	 * @return  object
	 */
	public function estimate_stats($data) {
		$standard_workload = get_option('standard_workload');
		$total_normal = 0;
		$total_overload = 0;
		foreach ($data['data'] as $workload) {
			foreach ($workload as $key => $value) {
				if (!(strpos($key, '_e') === false)) {
					$overload = $value - $standard_workload;
					if ($overload > 0) {
						$total_overload += $overload;
						$total_normal += $standard_workload;
					} else {
						$total_normal += $value;
					}
				}
			}
		}
		$chart = [];

		$status_1 = ['name' => _l('overload'), 'color' => '#fc2d42', 'y' => 0];
		$status_2 = ['name' => _l('normal'), 'color' => '#84c529', 'y' => 0];
		$status_1['y'] = round($total_overload, 1);
		$status_2['y'] = round($total_normal, 1);
		if ($status_1['y'] > 0) {
			array_push($chart, $status_1);
		}
		if ($status_2['y'] > 0) {
			array_push($chart, $status_2);
		}
		return $chart;
	}

	/**
	 * Gets the estimate hour.
	 *
	 * @param      int   $task_id  The task identifier
	 *
	 * @return     integer  The estimate hour.
	 */
	public function get_estimate_hour($task_id) {
		$this->db->where('fieldto', 'tasks');
		$this->db->where('slug', 'tasks_estimate_hour');
		$customfield_estimate_hour = $this->db->get(db_prefix() . 'customfields')->row();
		$value = 0;
		if (isset($customfield_estimate_hour->id)) {
			$this->db->where('fieldid', $customfield_estimate_hour->id);
			$this->db->where('relid', $task_id);
			$customfieldsvalues = $this->db->get(db_prefix() . 'customfieldsvalues')->row();
			if (isset($customfieldsvalues->id)) {
				$value = $customfieldsvalues->value;
			}

		}
		return $value;

	}

	/**
	 * get data spent stats
	 *
	 * @return    object
	 */
	public function spent_stats($data) {
		$standard_workload = get_option('standard_workload');
		$total_normal = 0;
		$total_overload = 0;
		foreach ($data['data'] as $workload) {
			foreach ($workload as $key => $value) {
				if (!(strpos($key, '_s') === false)) {
					$overload = $value - $standard_workload;
					if ($overload > 0) {
						$total_overload += $overload;
						$total_normal += $standard_workload;
					} else {
						$total_normal += $value;
					}
				}
			}
		}

		$chart = [];

		$status_1 = ['name' => _l('overload'), 'color' => '#ff9900', 'y' => 0];
		$status_2 = ['name' => _l('normal'), 'color' => '#66ccff', 'y' => 0];
		$status_1['y'] = round($total_overload, 1);
		$status_2['y'] = round($total_normal, 1);
		if ($status_1['y'] > 0) {
			array_push($chart, $status_1);
		}
		if ($status_2['y'] > 0) {
			array_push($chart, $status_2);
		}
		return $chart;
	}

	/**
	 * get data department stats
	 *
	 * @return   object
	 */
	public function department_stats($data) {
		$standard_workload = get_option('standard_workload');
		$not_in_department = _l('not_in_department');
		$total_normal = 0;
		$total_overload = 0;
		$department = array();
		foreach ($data['data'] as $workload) {
			$dept_text = $not_in_department;
			foreach ($workload as $key => $value) {
				if (!(strpos($key, 'staff_department') === false)) {
					if (trim($value) != '') {
						$dept_text = $value;
					}
					if (!isset($department[$dept_text])) {
						$department[$dept_text] = array();
						$department[$dept_text]['estimate_overload'] = 0;
						$department[$dept_text]['estimate_normal'] = 0;
						$department[$dept_text]['spent_overload'] = 0;
						$department[$dept_text]['spent_normal'] = 0;
					}
				}
				if (!(strpos($key, '_e') === false)) {
					$overload = $value - $standard_workload;
					if ($overload > 0) {
						$department[$dept_text]['estimate_overload'] += $overload;
						$department[$dept_text]['estimate_normal'] += $standard_workload;
					} else {
						$department[$dept_text]['estimate_normal'] += $value;
					}
				}
				if (!(strpos($key, '_s') === false)) {
					$overload = $value - $standard_workload;
					if ($overload > 0) {
						$department[$dept_text]['spent_overload'] += $overload;
						$department[$dept_text]['spent_normal'] += $standard_workload;
					} else {
						$department[$dept_text]['spent_normal'] += $value;
					}
				}
			}
		}

		$chart = [];

		$status_1 = ['name' => _l('estimate_overload'), 'data' => [], 'stack' => 'male', 'color' => '#fc2d42'];
		$status_2 = ['name' => _l('estimate_normal'), 'data' => [], 'stack' => 'male', 'color' => '#84c529'];
		$status_3 = ['name' => _l('spent_normal'), 'data' => [], 'stack' => 'female', 'color' => '#66ccff'];
		$status_4 = ['name' => _l('spent_overload'), 'data' => [], 'stack' => 'female', 'color' => '#ff9900'];

		$columns = array();
		foreach ($department as $key => $dept) {
			array_push($status_1['data'], round($dept['estimate_overload'], 1));
			array_push($status_2['data'], round($dept['estimate_normal'], 1));
			array_push($status_4['data'], round($dept['spent_overload'], 1));
			array_push($status_3['data'], round($dept['spent_normal'], 1));

			array_push($columns, $key);
		}
		array_push($chart, $status_1);
		array_push($chart, $status_2);
		array_push($chart, $status_4);
		array_push($chart, $status_3);
		$result = array();
		$result['department_stats'] = $chart;
		$result['column_department'] = $columns;
		return $result;
	}

	/**
	 * Gets the column department statistics.
	 *
	 * @return     object
	 */
	public function get_column_department_stats() {
		$departments = $this->departments_model->get();
		$department = [];
		foreach ($departments as $key => $value) {
			array_push($department, $value['name']);
		}
		return $department;
	}
}