<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Progress extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if(!$this->session->userdata('user_id')) {
            redirect('auth');
        }
        $this->load->model('Project_model');
        $this->load->model('Task_model');
    }

    public function index() {
        $data['title'] = 'Progress & Analytics';
        $data['view'] = 'progress/index';

        // 1. Overall Task Stats
        $data['task_stats'] = $this->Task_model->get_tasks_stats();

        // 2. Tasks by Status (For Doughnut Chart)
        $status_data = $this->Task_model->get_tasks_by_status();
        
        $chart_status = [
            'labels' => [],
            'data' => [],
            'colors' => []
        ];
        
        $color_map = [
            'To Do' => '#dfe6e9',
            'In Progress' => '#fdcb6e',
            'Review' => '#74b9ff',
            'Completed' => '#55efc4'
        ];

        foreach($status_data as $row) {
            $chart_status['labels'][] = $row->status;
            $chart_status['data'][] = $row->count;
            $chart_status['colors'][] = isset($color_map[$row->status]) ? $color_map[$row->status] : '#cccccc';
        }
        $data['chart_status'] = json_encode($chart_status);

        // 3. Tasks by Priority (For Pie Chart)
        $priority_data = $this->Task_model->get_tasks_by_priority();
        
        $chart_priority = [
            'labels' => [],
            'data' => [],
            'colors' => []
        ];

        $priority_color_map = [
            'High' => '#ff7675',
            'Medium' => '#fdcb6e',
            'Low' => '#55efc4'
        ];

        foreach($priority_data as $row) {
            $chart_priority['labels'][] = $row->priority;
            $chart_priority['data'][] = $row->count;
            $chart_priority['colors'][] = isset($priority_color_map[$row->priority]) ? $priority_color_map[$row->priority] : '#cccccc';
        }
        $data['chart_priority'] = json_encode($chart_priority);

        // 4. Projects Progress (For Bar Chart)
        $user_id = $this->session->userdata('user_id');
        $projects = $this->Project_model->get_all_projects_with_progress($user_id);
        $chart_projects = [
            'labels' => [],
            'data' => []
        ];

        foreach($projects as $p) {
            $chart_projects['labels'][] = $p->name;
            $chart_projects['data'][] = $p->progress;
        }
        $data['chart_projects'] = json_encode($chart_projects);

        $this->load->view('layouts/main', [
            'view' => 'progress/index',
            'title' => $data['title'],
            'data' => $data
        ]);
    }
}
