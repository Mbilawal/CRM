<?php

defined('BASEPATH') or exit('No direct script access allowed');
set_time_limit(0);

class Feedback extends AdminController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('feedback_model');
    }

   
    public function index()
    {
        $data['title']='Customer Feedback';
        $this->load->view('feedback', $data);
		
		 
        if ($this->input->post()) {
            
			$data= $this->input->post();
			$data['customerid']   = html_purify($this->input->post('clientid', false));
			$data['projectid']   = html_purify($this->input->post('project_id', false));
			$id=$this->feedback_model->add($data);
			
                if ($id) {
                    set_alert('success', _l('added_successfully', _l('Feedback')));
                    redirect(admin_url('feedback'));
                }else{
					
				    set_alert('warning', _l('Feedback request already exist'));	
					redirect(admin_url('feedback'));
				}	
		}	
    }
	
	
	
	    public function feedback_received()
    {
		$data['feedback_array']=$this->feedback_model->get_feedback();
        $data['title']='Feedback Received';
        $this->load->view('feedback_received', $data);
    }
	
	
	
	
	
}
