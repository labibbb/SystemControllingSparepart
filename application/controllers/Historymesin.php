<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Historymesin extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('Historymesin_model');
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
        // Ambil data mesin
        $data['mesin'] = $this->Historymesin_model->get_all_mesin_with_area();  // Ambil mesin dengan nama area
   
        // Load view dengan data
        $this->load->view('historymesin', $data);
    }

   
    public function detail($id_mesin) {
        $start_date = $this->input->get('start_date');
        $end_date = $this->input->get('end_date');
        
        $data['mesin_info'] = $this->Historymesin_model->get_mesin_info($id_mesin);
        
        // Apply date filter if provided
        if($start_date && $end_date) {
            $checksheets = $this->Historymesin_model->get_checksheet_by_mesin_with_date($id_mesin, $start_date, $end_date);
        } else {
            $checksheets = $this->Historymesin_model->get_checksheet_by_mesin($id_mesin);
        }
        
        // Tambahkan gambar untuk setiap checksheet
        if(!empty($checksheets)) {
            foreach($checksheets as &$sheet) {
                if(isset($sheet['id_pmm'])) {
                    $gambar = $this->Historymesin_model->get_gambarPm($sheet['id_pmm']);
                    $sheet['gambarPm'] = $gambar['gambarPm'] ?? null;
                } else {
                    $sheet['gambarPm'] = null;
                }
            }
        }
        
        $data['checksheet'] = $checksheets;
        
        // Load view detail
        $this->load->view('historymesin_detail', $data);
    }
    
}
?>
