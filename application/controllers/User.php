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
        date_default_timezone_set('Asia/Jakarta');

        $data = [
            'username' => $this->input->post('username'),
            'password' => password_hash($this->input->post('password'), PASSWORD_BCRYPT),
            'dipname'  => $this->input->post('dipname'),
            'level'    => $this->input->post('level'),
            'id'     => $this->input->post('id'),
            'plant'    => $this->input->post('plant'),
            'status' => 1,
            'active' => 1,
            'sysdate'  => date('Y-m-d H:i:s')
        ];
        $this->User_model->insert_user($data);
        echo json_encode(['status' => 'success']);
    }

    public function edit($id) {
        $user = $this->User_model->get_user_by_id($id);
        echo json_encode($user);
    }

    public function update() {
        $id = $this->input->post('id_users');
        date_default_timezone_set('Asia/Jakarta');

        $data = [
            'username' => $this->input->post('username'),
            'dipname'  => $this->input->post('dipname'),
            'level'    => $this->input->post('level'),
            'id'     => $this->input->post('id'),
            'plant'    => $this->input->post('plant'),
            'status' => 1,
            'active' => 1,
            'sysdate'  => date('Y-m-d H:i:s')
        ];
        
        if ($this->input->post('password')) {
            $data['password'] = password_hash($this->input->post('password'), PASSWORD_BCRYPT);
        }
        
        $this->User_model->update_user($id, $data); // Perbaiki dari User_Model ke User_model
        echo json_encode(['status' => 'success']);
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
