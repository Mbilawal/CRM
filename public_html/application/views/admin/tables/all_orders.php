<?php

defined('BASEPATH') or exit('No direct script access allowed');

$this->ci->load->model('gdpr_model');



$aColumns = array_merge($aColumns, [
    'email',
    'company',
    db_prefix() . 'contacts.phonenumber as phonenumber'
]);

$sIndexColumn = 'id';
$sTable       = db_prefix() . 'contacts';
$join         = ['JOIN ' . db_prefix() . 'clients ON ' . db_prefix() . 'clients.userid=' . db_prefix() . 'contacts.userid'];


$where = [];

array_push($where, 'AND ' . db_prefix() . 'contacts.type =0 ');





// Fix for big queries. Some hosting have max_join_limit
if (count($custom_fields) > 4) {
    @$this->ci->db->query('SET SQL_BIG_SELECTS=1');
}

$result = data_tables_init($aColumns, $sIndexColumn, $sTable, $join, $where, [db_prefix() . 'contacts.id as id', db_prefix() . 'contacts.userid as userid', 'is_primary', '(SELECT count(*) FROM ' . db_prefix() . 'contacts c WHERE  c.userid=' . db_prefix() . 'contacts.userid) as total_contacts']);

$output  = $result['output'];
$rResult = $result['rResult'];

foreach ($rResult as $aRow) {
    $row = [];

    $row[] = '<a href="mailto:' . $aRow['email'] . '">' . $aRow['email'] . '</a>';

    if (!empty($aRow['company'])) {
        $row[] = '<a href="' . admin_url('clients/client/' . $aRow['userid']) . '">' . $aRow['company'] . '</a>';
    } else {
        $row[] = '';
    }

    $row[] = '<a href="tel:' . $aRow['phonenumber'] . '">' . $aRow['phonenumber'] . '</a>';

    

    
    
    $output['aaData'][] = $row;
}
