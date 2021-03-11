<?php

class Mod_common extends App_Model {
    
    function __construct() {

        parent::__construct();

    }
	
	//Verify If User is Login on the authorized Pages.
    public function verify_is_admin_login() {

        if (!$this->session->userdata('client_user_id')) {
            $this->session->set_flashdata('err_message', '- You have to login to access this page.');
            redirect(AURL);
        }
    }

    function insert_into_table($table, $data) {
		$this->db->set_dbprefix('');
        $insert = $this->db->insert($table, $data);
        $insert_id = $this->db->insert_id();
        if ($insert) {
            return $insert_id;
        } else {
            return false;
        }
    }

    function update_table($table = "", $where = "", $data = "") {
		$this->db->set_dbprefix('');
        $this->db->where($where);
        $update = $this->db->update($table, $data);
        if ($update) {
            return true;
        } else {
            return false;
        }
    }
    function get_all_records_nums($table = "", $fields = "*", $where = array()) {
        $this->db->set_dbprefix('');
        $this->db->select($fields);
        if(count($where)>0){
            $this->db->where($where);
        }
        $get = $this->db->get($table);
		//echo $this->db->last_query(); 
        return $get->num_rows();
    }

    function get_all_records($table = "", $fields = "*",$llimit=0,$ulimit=0,$where = array(), $column_name = "id", $order_by = "DESC") {
        $this->db->set_dbprefix('');
        $this->db->select($fields);
		$this->db->order_by($column_name, $order_by);
		
        if ($ulimit > 0) {
            $this->db->limit($ulimit, $llimit);
        }
         if(count($where)>0){
            $this->db->where($where);
        }
        $get = $this->db->get($table);
        //echo $this->db->last_query(); 
		return $get->result_array();
    }

    function select_single_records($table = "", $where = "", $fields = "*") {
        $this->db->set_dbprefix('');
        $this->db->select($fields);
        if ($where != "") {
            $this->db->where($where);
        }
        $get = $this->db->get($table);
        return $get->row_array();
    }

    function select_array_records($table = "", $where = "", $fields = "*") {
        $this->db->set_dbprefix('');
        $this->db->select($fields);
        if ($where != "") {
            $this->db->where($where);
        }
        $get = $this->db->get($table);
        //echo $this->db->last_query(); 
        return $get->result_array();
    }

    function delete_record($table = "", $where = "") {
        $this->db->set_dbprefix('');
        $this->db->where($where);
        $delete = $this->db->delete($table);
        if ($delete)
            return true;
        else
            return false;
    }
}

?>