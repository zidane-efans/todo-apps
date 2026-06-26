<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tasks extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata('user_id')) {
            redirect('auth');
        }
        $this->load->model('Task_model');
        $this->load->model('Project_model');
        $this->load->model('Activity_model');
    }

    public function index() {
        $data['title'] = 'Tasks';
        $data['tasks'] = $this->Task_model->get_all_tasks();
        $data['projects'] = $this->Project_model->get_all_projects($this->session->userdata('user_id'));
        
        $this->load->view('layouts/main', [
            'view' => 'tasks/index',
            'data' => $data
        ]);
    }

    public function create() {
        $data = [
            'project_id' => $this->input->post('project_id'),
            'title' => $this->input->post('title'),
            'description' => $this->input->post('description'),
            'priority' => $this->input->post('priority'),
            'deadline' => $this->input->post('deadline'),
            'status' => $this->input->post('status'),
            'progress' => $this->input->post('progress') ? $this->input->post('progress') : 0,
            'created_by' => $this->session->userdata('user_id')
        ];
        $this->Task_model->create_task($data);
        $this->Activity_model->log_activity($this->session->userdata('user_id'), 'Created task: ' . $data['title']);
        $referer = $this->input->server('HTTP_REFERER');
        redirect($referer ? $referer : 'tasks');
    }

    public function update() {
        $id = $this->input->post('id');
        if ($id) {
            $data = [
                'project_id' => $this->input->post('project_id'),
                'title' => $this->input->post('title'),
                'description' => $this->input->post('description'),
                'priority' => $this->input->post('priority'),
                'deadline' => $this->input->post('deadline'),
                'status' => $this->input->post('status')
            ];
            $this->Task_model->update_task($id, $data);
            $this->Activity_model->log_activity($this->session->userdata('user_id'), 'Updated task: ' . $data['title']);
        }
        $referer = $this->input->server('HTTP_REFERER');
        redirect($referer ? $referer : 'tasks');
    }

    public function update_status() {
        $id = $this->input->post('id');
        $status = $this->input->post('status');
        if ($id && $status) {
            $this->Task_model->update_task($id, ['status' => $status]);
            $this->Activity_model->log_activity($this->session->userdata('user_id'), 'Updated task status to ' . $status . ' for task ID: ' . $id);
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false]);
        }
    }

    public function delete($id) {
        $this->Task_model->delete_task($id);
        $this->Activity_model->log_activity($this->session->userdata('user_id'), 'Deleted task ID: ' . $id);
        $referer = $this->input->server('HTTP_REFERER');
        redirect($referer ? $referer : 'tasks');
    }
}
