<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Dryvar_customers extends AdminController
{
    /* List all clients */
    public function index()
    {

    	$data['title'] = _l('Customers');
        $this->load->view('admin/clients/dryvar_customers', $data);
    }

}