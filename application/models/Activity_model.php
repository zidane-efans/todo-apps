<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Activity_model extends CI_Model {

    public function log_activity($user_id, $activity) {
        $data = [
            'user_id' => $user_id,
            'activity' => $activity
        ];
        return $this->db->insert('activity_logs', $data);
    }

    public function get_activities($limit = 50) {
        $this->db->select('activity_logs.*, users.name as user_name');
        $this->db->from('activity_logs');
        $this->db->join('users', 'users.id = activity_logs.user_id', 'left');
        $this->db->order_by('created_at', 'DESC');
        $this->db->limit($limit);
        return $this->db->get()->result();
    }
}
