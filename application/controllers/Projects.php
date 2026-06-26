<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Projects extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata('user_id')) {
            redirect('auth');
        }
        $this->load->model('Project_model');
        $this->load->model('Task_model');
        $this->load->model('Activity_model');
    }

    public function index() {
        $data['title'] = 'Projects';
        $data['projects'] = $this->Project_model->get_all_projects_with_progress($this->session->userdata('user_id'));
        
        $this->load->view('layouts/main', [
            'view' => 'projects/index',
            'data' => $data
        ]);
    }

    public function view($id) {
        $data['project'] = $this->Project_model->get_project($id);
        if (!$data['project']) {
            show_404();
        }
        
        $data['title'] = $data['project']->name;
        $data['tasks'] = $this->Task_model->get_tasks_by_project($id);
        $data['projects'] = $this->Project_model->get_all_projects($this->session->userdata('user_id'));
        
        // Calculate progress just for this project
        $total_tasks = count($data['tasks']);
        $completed_tasks = count(array_filter($data['tasks'], function($t) { return $t->status == 'Completed'; }));
        $data['project']->progress = $total_tasks > 0 ? round(($completed_tasks / $total_tasks) * 100) : 0;
        
        $this->load->view('layouts/main', [
            'view' => 'projects/view',
            'data' => $data
        ]);
    }

    public function create() {
        $data = [
            'name' => $this->input->post('name'),
            'description' => $this->input->post('description'),
            'start_date' => $this->input->post('start_date'),
            'end_date' => $this->input->post('end_date'),
            'status' => $this->input->post('status'),
            'user_id' => $this->session->userdata('user_id')
        ];
        $this->Project_model->create_project($data);
        $this->Activity_model->log_activity($this->session->userdata('user_id'), 'Created project: ' . $data['name']);
        $referer = $this->input->server('HTTP_REFERER');
        redirect($referer ? $referer : 'projects');
    }

    public function update() {
        $id = $this->input->post('id');
        if ($id) {
            $data = [
                'name' => $this->input->post('name'),
                'description' => $this->input->post('description'),
                'start_date' => $this->input->post('start_date'),
                'end_date' => $this->input->post('end_date'),
                'status' => $this->input->post('status')
            ];
            $this->Project_model->update_project($id, $data);
            $this->Activity_model->log_activity($this->session->userdata('user_id'), 'Updated project: ' . $data['name']);
        }
        $referer = $this->input->server('HTTP_REFERER');
        redirect($referer ? $referer : 'projects');
    }

    public function delete($id) {
        $this->Project_model->delete_project($id);
        $this->Activity_model->log_activity($this->session->userdata('user_id'), 'Deleted project ID: ' . $id);
        $referer = $this->input->server('HTTP_REFERER');
        redirect($referer ? $referer : 'projects');
    }
}
