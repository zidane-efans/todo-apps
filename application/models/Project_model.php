<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Project_model extends CI_Model {

    public function get_all_projects($user_id) {
        // Here we could restrict by user, but let's assume we fetch all or based on role
        return $this->db->get('projects')->result();
    }

    public function get_all_projects_with_progress($user_id) {
        $projects = $this->db->get('projects')->result();
        foreach($projects as $p) {
            $total_tasks = $this->db->where('project_id', $p->id)->count_all_results('tasks');
            $completed_tasks = $this->db->where('project_id', $p->id)->where('status', 'Completed')->count_all_results('tasks');
            $p->progress = $total_tasks > 0 ? round(($completed_tasks / $total_tasks) * 100) : 0;
        }
        return $projects;
    }

    public function get_project($id) {
        return $this->db->get_where('projects', ['id' => $id])->row();
    }

    public function create_project($data) {
        return $this->db->insert('projects', $data);
    }

    public function update_project($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('projects', $data);
    }

    public function delete_project($id) {
        $this->db->where('id', $id);
        return $this->db->delete('projects');
    }
}
