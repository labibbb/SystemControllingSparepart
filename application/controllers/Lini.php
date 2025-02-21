<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lini extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('Lini_model');
        $this->load->library('session');
        $this->check_session_timeout();
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
        $data['lini'] = $this->Lini_model->get_all_lini();
        $this->load->view('lini', $data);
    }

    public function add() {
        $nama_lini = $this->input->post('nama_lini', true);
        
        if ($nama_lini) {
            $data = ['nama_lini' => $nama_lini, 'status' => 1];
            $this->Lini_model->insert_lini($data);
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Nama lini harus diisi']);
        }
    }

    public function edit($id) {
        $lini = $this->Lini_model->get_lini_by_id($id);
        echo json_encode($lini);
    }

    public function update() {
        $id_lini = $this->input->post('id_lini', true);
        $nama_lini = $this->input->post('nama_lini', true);
        
        if ($id_lini && $nama_lini) {
            $data = ['nama_lini' => $nama_lini];
            $this->Lini_model->update_lini($id_lini, $data);
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Data tidak valid']);
        }
    }

    public function delete($id) {
        if ($id) {
            $this->Lini_model->delete_lini($id);
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'ID tidak valid']);
        }
    }
}
