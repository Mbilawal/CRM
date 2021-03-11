<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Facebook_leads extends AdminController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('dashboard_model');
    }

    /* This is admin dashboard view */
    public function index()
    {

      echo '123';
    }

}
