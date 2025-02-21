<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Jobdeskripsi extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('Jobdeskripsi_model');
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
        $data['job_deskripsi'] = $this->Jobdeskripsi_model->get_all_jobdeskripsi();
        $this->load->view('jobdeskripsi', $data);
    }

    public function add() {
        $data = [
            'job_deskripsi' => $this->input->post('job_deskripsi'),
            'periode' => $this->input->post('periode'),
            'cycle_time' => $this->input->post('cycle_time'),
            'status' => 1
        ];
        $this->Jobdeskripsi_model->insert_jobdeskripsi($data);
        echo json_encode(['status' => 'success']);
    }

    public function edit($id) {
        $jobdeskripsi = $this->Jobdeskripsi_model->get_jobdeskripsi_by_id($id);
        echo json_encode($jobdeskripsi);
    }

    public function update() {
        $id = $this->input->post('id_job');
        $data = [
            'job_deskripsi' => $this->input->post('job_deskripsi'),
            'periode' => $this->input->post('periode'),
            'cycle_time' => $this->input->post('cycle_time')
        ];
        $this->Jobdeskripsi_model->update_jobdeskripsi($id, $data);
        echo json_encode(['status' => 'success']);
    }

    public function delete($id) {
        if ($id) {
            $this->Jobdeskripsi_model->delete_jobdeskripsi($id);
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'ID tidak valid']);
        }
    }
}
?>
