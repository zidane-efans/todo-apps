<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if(!$this->session->userdata('user_id')) {
            redirect('auth');
        }
        $this->load->model('User_model');
        $this->load->model('Activity_model');
    }

    public function index() {
        $data['title'] = 'My Profile';
        $data['user'] = $this->User_model->get_user_by_id($this->session->userdata('user_id'));

        $this->load->view('layouts/main', [
            'view' => 'profile/index',
            'title' => $data['title'],
            'data' => $data
        ]);
    }

    public function update() {
        $user_id = $this->session->userdata('user_id');
        $name = $this->input->post('name');
        $email = $this->input->post('email');

        // Check if email belongs to someone else
        $existing = $this->User_model->get_user_by_email($email);
        if($existing && $existing->id != $user_id) {
            $this->session->set_flashdata('error', 'Email is already taken by another account.');
            redirect('profile');
            return;
        }

        $this->User_model->update_user($user_id, [
            'name' => $name,
            'email' => $email
        ]);

        // Update session
        $this->session->set_userdata('name', $name);
        $this->session->set_userdata('email', $email);

        $this->Activity_model->log_activity($user_id, 'Updated profile information');
        $this->session->set_flashdata('success', 'Profile updated successfully.');
        redirect('profile');
    }

    public function update_password() {
        $user_id = $this->session->userdata('user_id');
        $current_password = $this->input->post('current_password');
        $new_password = $this->input->post('new_password');
        $confirm_password = $this->input->post('confirm_password');

        $user = $this->User_model->get_user_by_id($user_id);

        if(!password_verify($current_password, $user->password)) {
            $this->session->set_flashdata('error_security', 'Current password is incorrect.');
            redirect('profile');
            return;
        }

        if($new_password !== $confirm_password) {
            $this->session->set_flashdata('error_security', 'New passwords do not match.');
            redirect('profile');
            return;
        }

        $this->User_model->update_user($user_id, [
            'password' => $new_password
        ]);

        $this->Activity_model->log_activity($user_id, 'Updated account password');
        $this->session->set_flashdata('success_security', 'Password updated successfully.');
        redirect('profile');
    }
}
