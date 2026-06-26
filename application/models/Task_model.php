<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Task_model extends CI_Model {

    public function get_tasks_by_project($project_id) {
        return $this->db->get_where('tasks', ['project_id' => $project_id])->result();
    }

    public function get_all_tasks() {
        $this->db->select('tasks.*, projects.name as project_name');
        $this->db->from('tasks');
        $this->db->join('projects', 'projects.id = tasks.project_id', 'left');
        return $this->db->get()->result();
    }

    public function get_task($id) {
        return $this->db->get_where('tasks', ['id' => $id])->row();
    }

    public function create_task($data) {
        return $this->db->insert('tasks', $data);
    }

    public function update_task($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('tasks', $data);
    }

    public function delete_task($id) {
        $this->db->where('id', $id);
        return $this->db->delete('tasks');
    }

    public function get_tasks_stats() {
        $total = $this->db->count_all('tasks');
        $this->db->where('status', 'Completed');
        $completed = $this->db->count_all_results('tasks');
        $this->db->where('status !=', 'Completed');
        $pending = $this->db->count_all_results('tasks');
        
        return [
            'total' => $total,
            'completed' => $completed,
            'pending' => $pending
        ];
    }

    public function get_tasks_by_status() {
        $this->db->select('status, COUNT(id) as count');
        $this->db->group_by('status');
        $query = $this->db->get('tasks');
        return $query->result();
    }

    public function get_tasks_by_priority() {
        $this->db->select('priority, COUNT(id) as count');
        $this->db->group_by('priority');
        $query = $this->db->get('tasks');
        return $query->result();
    }
}
