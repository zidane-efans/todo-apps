<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata('user_id')) {
            redirect('auth');
        }
        $this->load->model('Project_model');
        $this->load->model('Task_model');
    }

    public function index() {
        $data['title'] = 'Dashboard';
        $data['stats'] = $this->Task_model->get_tasks_stats();
        $data['stats']['total_projects'] = count($this->Project_model->get_all_projects($this->session->userdata('user_id')));
        
        // Fetch tasks and projects for the Kanban board and modals
        $data['tasks'] = $this->Task_model->get_all_tasks();
        $data['projects'] = $this->Project_model->get_all_projects($this->session->userdata('user_id'));
        
        $this->load->view('layouts/main', [
            'view' => 'dashboard/index',
            'data' => $data
        ]);
    }
}
