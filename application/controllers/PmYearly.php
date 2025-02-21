<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PmYearly extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('PmYearly_model');
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
        $tahun_now = date('Y');
        $bulan_now = date('n'); // Bulan tanpa leading zero (1-12)
    
        // Ambil daftar lini
        $lini = $this->PmYearly_model->get_lini();
    
        // Ambil daftar area dan tentukan area default (ID terkecil)
        $areas = $this->PmYearly_model->getAreas();
        $areas2 = $this->PmYearly_model->getAreas2();
        $id_area_default = !empty($areas) ? $areas[0]['id_area'] : null;
        
        $id_area_default2 = !empty($areas2) ? $areas2[0]['id_area'] : null;
    
        // Ambil data sesuai filter awal
        $pmyearly = $this->PmYearly_model->getFilteredData($tahun_now, $bulan_now, $id_area_default);
        $pmyearly2 = $this->PmYearly_model->getFilteredData2($tahun_now, $bulan_now, $id_area_default2);
    
        $data = [
            'pmyearly' => $pmyearly,
            'pmyearly2' => $pmyearly2,
            'lini' => $lini,
            'areas' => $areas,
            'areas2' => $areas2,
            'tahun_selected' => $tahun_now,
            'bulan_selected' => $bulan_now,
            'area_selected' => $id_area_default
        ];
    
        $this->load->view('pmyearly', $data);
    }

    public function filterData() {
        $tahun = $this->input->post('tahun');
        $bulan = $this->input->post('bulan');
        $id_area = $this->input->post('area');

        $filteredData = $this->PmYearly_model->getFilteredData($tahun, $bulan, $id_area);
        echo json_encode($filteredData);
    }

    public function filterData2() {
        $tahun = $this->input->post('tahun');
        $bulan = $this->input->post('bulan');
        $id_area = $this->input->post('area');

        $filteredData = $this->PmYearly_model->getFilteredData2($tahun, $bulan, $id_area);
        echo json_encode($filteredData);
    }

    public function get_area() {
        $id_lini = $this->input->post('id_lini');
        echo json_encode($this->PmYearly_model->get_area_by_lini($id_lini));
    }

    public function get_mesin() {
        $id_area = $this->input->post('id_area');
        echo json_encode($this->PmYearly_model->get_mesin_by_area($id_area));
    }

    public function add() {
        $data = [
            'id_lini' => $this->input->post('id_lini'),
            'id_area' => $this->input->post('id_area'),
            'id_mesin' => $this->input->post('id_mesin'),
            'tahun' => $this->input->post('tahun'),
            'bulan' => $this->input->post('bulan'),
            'status' => 1,
            'sysdate' => date('Y-m-d H:i:s')
        ];

        if ($this->PmYearly_model->insert_pmyearly($data)) {
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error']);
        }
    }
}
?>
