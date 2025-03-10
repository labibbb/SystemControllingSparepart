<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pengerjaan extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('Pengerjaan_model');
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
        $pmmonthly = $this->Pengerjaan_model->getFilteredData();
        $pmmonthly2 = $this->Pengerjaan_model->getFilteredData2();
    
        $data = [
            'pmmonthly' => $pmmonthly,
            'pmmonthly2' => $pmmonthly2
        ];
    
        $this->load->view('pengerjaanView', $data);
    }

    public function detail() {    
        $id_mesin = $this->input->post('id_mesin');
        $tanggal = $this->input->post('tanggal');
        $id_pmm = $this->input->post('id_pmm');

        $singlechecksheet = $this->Pengerjaan_model->get_singlecheckseet($id_mesin); 
        $checksheet = $this->Pengerjaan_model->get_checkseet($id_mesin); 
        $wi = $this->Pengerjaan_model->get_wi($id_mesin); 
    
        $data = [
            'singleChecksheet' => $singlechecksheet,
            'checksheet' => $checksheet,
            'tanggal' => $tanggal,
            'wi' => $wi,
            'id_pmm' => $id_pmm
        ];
    
        $this->load->view('pengerjaanDetail', $data);
    }
}
?>
