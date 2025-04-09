<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Pengerjaan_model');
        $this->load->library('session');
        $this->check_session_timeout(); // Panggil pengecekan session
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
    
        $today = date('Y-m-d');
    
        // Filter hanya data dengan tanggal hari ini
        $pmmonthly_today = array_filter($pmmonthly, function ($row) use ($today) {
            return isset($row['tanggal']) && substr($row['tanggal'], 0, 10) === $today;
        });
    
        $pmmonthly2_today = array_filter($pmmonthly2, function ($row) use ($today) {
            return isset($row['tanggal']) && substr($row['tanggal'], 0, 10) === $today;
        });
    
        // Status count
        $this->db->where('status', 4);
        $inProcess = $this->db->count_all_results('pm_monthly');
    
        $this->db->where('status', 6);
        $waitingApproval = $this->db->count_all_results('pm_monthly');
    
        $this->db->where('status', 7);
        $rejected = $this->db->count_all_results('pm_monthly');
    
        $this->db->where('status', 8);
        $completeAll = $this->db->count_all_results('pm_monthly');
    
        $total = $inProcess + $waitingApproval + $rejected + $completeAll;
    
        $data = [
            'pmmonthly' => $pmmonthly_today,
            'pmmonthly2' => $pmmonthly2_today,
            'inProcess' => $inProcess,
            'waitingApproval' => $waitingApproval,
            'rejected' => $rejected,
            'completeAll' => $completeAll,
            'total' => $total
        ];
    
        $this->load->view('dashboard', $data);
    }        
}
