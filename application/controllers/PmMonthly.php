<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PmMonthly extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('PmMonthly_model');
    }

    public function index() {
        // Ambil data sesuai filter awal
        $pmmonthly = $this->PmMonthly_model->get_all_pmmonthly();
        $manpower = $this->PmMonthly_model->get_manpower();
        
        $data = [
            'pmmonthly' => $pmmonthly,
            'manpower' => $manpower
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
}
?>
