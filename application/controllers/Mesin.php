<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mesin extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('Mesin_model');
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
        $data['mesin'] = $this->Mesin_model->get_all_mesin_with_area();  // Ambil mesin dengan nama area
        $data['areas'] = $this->Mesin_model->get_active_areas();  // Ambil daftar area aktif
        $data['areas_painting1'] = $this->Mesin_model->get_areas_by_lini('Painting 1');
        $data['areas_painting2'] = $this->Mesin_model->get_areas_by_lini('Painting 2');
    
        // Load view dengan data
        $this->load->view('mesin', $data);
    }
    

    public function add() {
        $data = [
            'id_area' => $this->input->post('id_area'),
            'nama_mesin' => $this->input->post('nama_mesin'),
            'tipe_mesin' => $this->input->post('tipe_mesin'),
            'kapasitas' => $this->input->post('kapasitas'),
            'status' => 1
        ];
        $this->Mesin_model->insert_mesin($data);
        echo json_encode(['status' => 'success']);
    }

    public function edit($id) {
        echo json_encode($this->Mesin_model->get_mesin_by_id($id));
    }

    public function update() {
        $id = $this->input->post('id_mesin');
        $data = [
            'id_area' => $this->input->post('id_area'),
            'nama_mesin' => $this->input->post('nama_mesin'),
            'tipe_mesin' => $this->input->post('tipe_mesin'),
            'kapasitas' => $this->input->post('kapasitas')
        ];
        $this->Mesin_model->update_mesin($id, $data);
        echo json_encode(['status' => 'success']);
    }

    public function delete($id) {
        $this->Mesin_model->delete_mesin($id);
        echo json_encode(['status' => 'deleted']);
    }
}
?>
