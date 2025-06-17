<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->model('User_model'); // Ganti Users_Model menjadi User_model
    }
    
    private function check_session_timeout() {
        $timeout = 8 * 60 * 60; // 8 jam dalam detik
        
        if ($this->session->userdata('logged_in')) {
            $last_login_time = $this->session->userdata('last_login_time');

            if ((time() - $last_login_time) > $timeout) {
                $this->session->sess_destroy(); // Hapus sesi
                redirect('login'); // Redirect ke halaman login
                exit();
            } else {
                // Perbarui waktu login agar tidak logout saat masih aktif
                $this->session->set_userdata('last_login_time', time());
            }
        } else {
            redirect('login'); // Jika belum login, redirect ke halaman login
            exit();
        }
    }

    public function index() {
         if (!$this->session->userdata('logged_in') || $this->session->userdata('level') != 1) {
            show_404(); // Tampilkan halaman 404
        }
        $data['users'] = $this->User_model->get_all_userz();
        $data['departemen'] = $this->User_model->get_all_dept();
       // $data['users'] = $this->User_model->get_all_users();
        $this->load->view('user', $data);
    }

     public function add() {
        $username = $this->input->post('username');
        
        // Validasi untuk CREATE: username harus unik
        if ($this->User_model->check_existing_data($username)) {
            echo json_encode(['status' => 'error', 'message' => 'Username sudah terdaftar']);
            return;
        }

        $data = [
            'username' => $username,
            'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
            'dipname' => $this->input->post('dipname'),
            'level' => $this->input->post('level'),
            'id' => $this->input->post('id'),
            'plant' => $this->input->post('plant'),
            'status' => 1,
            'active' => 1,
            'sysdate'  => date('Y-m-d H:i:s')
        ];

        $this->User_model->insert_user($data);
        echo json_encode(['status' => 'success']);
    }

    public function update() {
        $id = $this->input->post('id_users');
        $username = $this->input->post('username');
        $current_user = $this->User_model->get_user_by_id($id);

        // Validasi untuk UPDATE: username unik hanya jika berubah/bukan milik user lain
        if ($username != $current_user['username'] && $this->User_model->check_existing_data($username)) {
            echo json_encode(['status' => 'error', 'message' => 'Username sudah terdaftar']);
            return;
        }

        $data = [
            'username' => $username,
            'dipname' => $this->input->post('dipname'),
            'level' => $this->input->post('level'),
            'id' => $this->input->post('id'),
            'plant' => $this->input->post('plant'),
            'status' => 1,
            'active' => 1,
            'sysdate'  => date('Y-m-d H:i:s')
        ];

        // Update password hanya jika diisi
        if (!empty($this->input->post('password'))) {
            $data['password'] = password_hash($this->input->post('password'), PASSWORD_DEFAULT);
        }

        $this->User_model->update_user($id, $data);
        echo json_encode(['status' => 'success']);
    }

    public function edit($id) {
        $user = $this->User_model->get_user_by_id($id);
        echo json_encode($user);
    }

    

    public function delete($id) {
        if ($id) {
            $this->User_model->delete_user($id);
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'ID tidak valid']);
        }
    }
}
?>
