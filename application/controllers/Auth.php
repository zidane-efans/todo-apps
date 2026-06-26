<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('User_model');
        $this->load->library('session');
        $this->load->helper('url');
    }

    public function index() {
        if ($this->session->userdata('user_id')) {
            redirect('dashboard');
        }
        $this->load->view('auth/login');
    }

    public function login() {
        $email = $this->input->post('email');
        $password = $this->input->post('password');

        $user = $this->User_model->login($email, $password);

        if ($user) {
            $this->session->set_userdata([
                'user_id' => $user->id,
                'name' => $user->name,
                'role' => $user->role,
                'email' => $user->email
            ]);
            $this->load->model('Activity_model');
            $this->Activity_model->log_activity($user->id, 'Logged in');
            
            redirect('dashboard');
        } else {
            $this->session->set_flashdata('error', 'Invalid email or password');
            redirect('auth');
        }
    }

    public function logout() {
        if ($this->session->userdata('user_id')) {
            $this->load->model('Activity_model');
            $this->Activity_model->log_activity($this->session->userdata('user_id'), 'Logged out');
        }
        $this->session->sess_destroy();
        redirect('auth');
    }

    public function register() {
        if ($this->session->userdata('user_id')) {
            redirect('dashboard');
        }

        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            $name = $this->input->post('name');
            $email = $this->input->post('email');
            $password = $this->input->post('password');
            $confirm_password = $this->input->post('confirm_password');

            if ($password !== $confirm_password) {
                $this->session->set_flashdata('error', 'Passwords do not match');
                redirect('auth/register');
                return;
            }

            if ($this->User_model->get_user_by_email($email)) {
                $this->session->set_flashdata('error', 'Email is already registered');
                redirect('auth/register');
                return;
            }

            $data = [
                'name' => $name,
                'email' => $email,
                'password' => $password, // Hashed in model
                'role' => 'User'
            ];

            $this->User_model->create_user($data);
            $this->session->set_flashdata('success', 'Account created successfully. Please log in.');
            redirect('auth');
        } else {
            $this->load->view('auth/register');
        }
    }
}
