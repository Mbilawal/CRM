<?php
defined('BASEPATH') or exit('No direct script access allowed');
add_option('standard_workload', 8);
$i = count($CI->db->query('Select * from ' . db_prefix() . 'customfields where fieldto = "tasks" and slug = "tasks_estimate_hour"')->result_array());
if ($i == 0) {
	$CI->db->query("INSERT INTO `" . db_prefix() . "customfields` (`fieldto`, `name`, `slug`, `required`, `type`, `options`, `display_inline`, `field_order`, `active`, `show_on_pdf`, `show_on_ticket_form`, `only_admin`, `show_on_table`, `show_on_client_portal`, `disalow_client_to_edit`, `bs_column`) VALUES ('tasks', 'Estimate hour', 'tasks_estimate_hour', '0', 'number', '', '0', '0', '1', '0', '0', '0', '0', '0', '0', '12');");
	return 0;
}
