<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Approval extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('Approval_model');
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
        // Ambil data sesuai filter awal
        $pmmonthly = $this->Approval_model->get_all_pmmonthly();
        $lini = $this->Approval_model->get_lini();
        
        $data = [
            'pmmonthly' => $pmmonthly,
            'lini' => $lini
        ];
    
        $this->load->view('approvalFRView', $data);
    }

    public function index2() {
        // Ambil data sesuai filter awal
        $pmmonthly = $this->Approval_model->get_all_pmmonthly2();
        $lini = $this->Approval_model->get_lini();
        
        $data = [
            'pmmonthly' => $pmmonthly,
            'lini' => $lini
        ];
    
        $this->load->view('approvalSPVView', $data);
    }

    public function detail2() {    
        $id_mesin = $this->input->post('id_mesin');
        $tanggal = $this->input->post('tanggal');
        $id_pmm = $this->input->post('id_pmm');

        $singlechecksheet = $this->Approval_model->get_singlecheckseet($id_mesin); 
        $checksheet = $this->Approval_model->get_checkseet($id_mesin); 
        $wi = $this->Approval_model->get_wi($id_mesin); 
    
        $data = [
            'singleChecksheet' => $singlechecksheet,
            'checksheet' => $checksheet,
            'tanggal' => $tanggal,
            'wi' => $wi,
            'id_pmm' => $id_pmm
        ];
    
        $this->load->view('approvalSPVDetail', $data);
    }

    public function detail() {    
        $id_mesin = $this->input->post('id_mesin');
        $tanggal = $this->input->post('tanggal');
        $id_pmm = $this->input->post('id_pmm');

        $singlechecksheet = $this->Approval_model->get_singlecheckseet($id_mesin); 
        $checksheet = $this->Approval_model->get_checkseet($id_mesin); 
        $wi = $this->Approval_model->get_wi($id_mesin); 
    
        $data = [
            'singleChecksheet' => $singlechecksheet,
            'checksheet' => $checksheet,
            'tanggal' => $tanggal,
            'wi' => $wi,
            'id_pmm' => $id_pmm
        ];
    
        $this->load->view('approvalFRDetail', $data);
    }

    public function approveFr($id_pmm) {
        $user_id = $this->session->userdata('user_id');

        if (empty($id_pmm)) {
            echo json_encode(['status' => 'error', 'message' => 'ID PMM tidak boleh kosong']);
            return;
        }

        $update = $this->Approval_model->approveFr($id_pmm, $user_id);

        if ($update) {
            echo json_encode(['status' => 'success', 'message' => 'Data berhasil disimpan']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Gagal menyimpan data']);
        }
    }
    
    public function rejectFr($id_pmm) {
        $user_id = $this->session->userdata('user_id');

        // Validasi ID PMM tidak boleh kosong
        if (empty($id_pmm)) {
            echo json_encode(['status' => 'error', 'message' => 'ID PMM tidak boleh kosong']);
            return;
        }
    
        // Update status di model
        $update = $this->Approval_model->rejectFr($id_pmm, $user_id);
    
        if ($update) {
            echo json_encode(['status' => 'success', 'message' => 'Data berhasil disimpan']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Gagal menyimpan data']);
        }
    }

    public function approveSpv($id_pmm) {
        $user_id = $this->session->userdata('user_id');

        if (empty($id_pmm)) {
            echo json_encode(['status' => 'error', 'message' => 'ID PMM tidak boleh kosong']);
            return;
        }

        $update = $this->Approval_model->approveSpv($id_pmm, $user_id);

        if ($update) {
            echo json_encode(['status' => 'success', 'message' => 'Data berhasil disimpan']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Gagal menyimpan data']);
        }
    }

    
    public function rejectSpv($id_pmm) {
        $user_id = $this->session->userdata('user_id');

        // Validasi ID PMM tidak boleh kosong
        if (empty($id_pmm)) {
            echo json_encode(['status' => 'error', 'message' => 'ID PMM tidak boleh kosong']);
            return;
        }
    
        // Update status di model
        $update = $this->Approval_model->rejectSpv($id_pmm, $user_id);
    
        if ($update) {
            echo json_encode(['status' => 'success', 'message' => 'Data berhasil disimpan']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Gagal menyimpan data']);
        }
    }
}
?>
