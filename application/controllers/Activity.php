<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Activity extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if(!$this->session->userdata('user_id')) {
            redirect('auth');
        }
        $this->load->model('Activity_model');
    }

    public function index() {
        $data['title'] = 'Activity Reports';
        $data['activities'] = $this->Activity_model->get_activities(100);

        $this->load->view('layouts/main', [
            'view' => 'activity/index',
            'title' => $data['title'],
            'data' => $data
        ]);
    }
}
