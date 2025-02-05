<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

    public function __construct() {
        parent::__construct();
        // Memuat library form_validation
        $this->load->library('form_validation');
    }

    public function index() {
        $this->load->view('login');
    }

    public function process_login() {
        // Validasi input
        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if ($this->form_validation->run() == FALSE) {
            // Jika validasi gagal, tampilkan kembali halaman login dengan pesan error
            $this->load->view('login');
        } else {
            // Ambil data dari form
            $username = $this->input->post('username');
            $password = $this->input->post('password');

            // Validasi username dan password
            if ($username == 'admin' && $password == '123') {
                // Jika login berhasil, redirect ke dashboard
                redirect('dashboard');
            } else {
                // Jika login gagal, tampilkan alert dan kembali ke halaman login
                echo "<script>alert('Username atau Password salah!');</script>";
                $this->load->view('login');
            }
        }
    }
}