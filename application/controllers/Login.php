<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('User_model');
        $this->load->library('session');
    }

    public function index() {
        $this->load->view('login');
    }

    public function process_login() {
        // Validasi input
        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');
    
        if ($this->form_validation->run() == FALSE) {
            echo json_encode(['status' => 'error', 'message' => validation_errors()]);
        } else {
            $username = $this->input->post('username');
            $password = $this->input->post('password');
    
            // Cek login dengan model
            $user = $this->User_model->check_login($username, $password);
    
            if ($user) {
                // Set session dengan waktu kedaluwarsa 8 jam
                $this->session->set_userdata([
                    'user_id'  => $user->id_users,
                    'username' => $user->username,
                    'role' => $user->role,
                    'logged_in' => true,
                    'last_login_time' => time() // Simpan waktu login
                ]);
    
                echo json_encode(['status' => 'success', 'message' => 'Login berhasil', 'redirect' => site_url('dashboard')]);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Username atau Password salah!']);
            }
        }
    }
}
?>
