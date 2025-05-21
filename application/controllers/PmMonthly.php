<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PmMonthly extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('PmMonthly_model');
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
         if (!$this->session->userdata('logged_in') || $this->session->userdata('level') != 2) {
            show_404(); // Tampilkan halaman 404
        }
        // Ambil data sesuai filter awal
        $pmmonthly = $this->PmMonthly_model->get_all_pmmonthly();
        $manpower = $this->PmMonthly_model->get_manpower();
        $lini = $this->PmMonthly_model->get_lini();
        
        $data = [
            'pmmonthly' => $pmmonthly,
            'manpower' => $manpower,
            'lini' => $lini
        ];
    
        $this->load->view('pmmonthly', $data);
    }

    public function update_tanggal() {
        $id_pmm = $this->input->post('id_pmm');
        $data = [
            'tanggal' => $this->input->post('tanggal'),
            'catatan' => $this->input->post('catatan'),
            'status' => 2
        ];
        $this->PmMonthly_model->update_tanggal_catatan($id_pmm, $data);
        redirect('PmMonthly');
    }

    public function update_tanggal2() {
        $id_pmm = $this->input->post('id_pmm');
        $data = [
            'tanggal' => $this->input->post('tanggal'),
            'catatan' => $this->input->post('catatan')
        ];
        $this->PmMonthly_model->update_tanggal_catatan($id_pmm, $data);
        redirect('PmMonthly');
    }

    public function update_tanggal3() {
    $id_pmm = $this->input->post('id_pmm');
    $tanggal_baru = $this->input->post('tanggal');

    $pmmonthly = $this->PmMonthly_model->get_pmm($id_pmm);

    if ($pmmonthly) {
        // Update status record lama menjadi 10 (atau status khusus untuk "telah direschedule")
        $this->db->where('id_pmm', $id_pmm)->update('pm_monthly', ['statusresc' => 10]);
        
        // Insert data baru
        $data = [
            'id_pmy'   => $pmmonthly->id_pmy,
            'id_lini'   => $pmmonthly->id_lini,
            'id_area'   => $pmmonthly->id_area,
            'id_mesin'  => $pmmonthly->id_mesin,
            'bulan'     => $pmmonthly->bulan,
            'tahun'     => $pmmonthly->tahun,
            'id_users'  => $pmmonthly->id_users,
            'tanggal'   => $tanggal_baru,
            'status'    => 3,
            'pmBefore'  => $id_pmm
        ];

        $this->db->insert('pm_monthly', $data);
    }

    redirect('PmMonthly');
}

    public function update_mp() {
        $id_pmm = $this->input->post('id_pmm');
        $data = [
            'id_users' => $this->input->post('id_users'),
            'catatan' => $this->input->post('catatan'),
            'status' => 3
        ];
        $this->PmMonthly_model->update_mp($id_pmm, $data);
        redirect('PmMonthly');
    }

    public function filterData() {
        $id_lini = $this->input->post('lini');

        $filteredData = $this->PmMonthly_model->getFilteredData($id_lini);
        foreach ($filteredData  as &$row) {
        if ($row['statusresc'] == 10) {
            $rescheduled = $this->PmMonthly_model->get_rescheduled_date($row['id_pmm']);
            $row['rescheduled_date'] = $rescheduled;
        }
    }
        echo json_encode($filteredData);
    }
}
?>
