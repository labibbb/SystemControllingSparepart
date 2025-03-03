<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Checkseet extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('Checkseet_model');
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
        $checkseet = $this->Checkseet_model->get_all_checkseet();
        
        $data = [
            'checkseet' => $checkseet
        ];
    
        $this->load->view('checkseet', $data);
    }

    public function indexInsertNew() {
        $lini = $this->Checkseet_model->get_lini();
        $departemen = $this->Checkseet_model->get_departement();
        $id_mesin = $this->input->post('id_mesin');

        $data = [
            'lini' => $lini,
            'departemen' => $departemen,
            'id_mesin' => $id_mesin
        ];
    
        $this->load->view('checksheetAdd', $data);
    }

    public function getData() {
        $id_mesin = $this->input->post('id_mesin');
        
        if ($id_mesin) {
            $checkseet = $this->Checkseet_model->get_checkseet($id_mesin);
            
            $data = [
                'status' => 'success',
                'message' => 'Data berhasil diambil',
                'checkseet' => $checkseet
            ];
    
            echo json_encode($data);
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'Data tidak valid'
            ]);
        }
    }

    public function edit() {
        $lini = $this->Checkseet_model->get_lini();
        $departemen = $this->Checkseet_model->get_departement();
        
        $data = [
            'lini' => $lini,
            'departemen' => $departemen
        ];

        $this->load->view('checksheetEdit', $data);
    }

    public function indexInsert() {
        $id_mesin = $this->input->post('id_mesin');
        $checkseet = $this->Checkseet_model->get_checkseet($id_mesin);
        $lini = $this->Checkseet_model->get_lini();
        
        $data = [
            'checkseet' => $checkseet,
            'lini' => $lini
        ];
    
        $this->load->view('checksheetAdd', $data);
    }

    public function insertChecksheet() {
        $dataList = $this->input->post('data'); // Menerima data sebagai array
    
        if (!empty($dataList) && is_array($dataList)) {
            foreach ($dataList as $data) {
                $insertData = [
                    'id_lini'    => $data['id_lini'],
                    'id_area'    => $data['id_area'],
                    'id_mesin'   => $data['id_mesin'],
                    'item_cek'   => $data['item_cek'],
                    'point_cek'  => $data['point_cek'],
                    'metode_cek' => $data['metode_cek'],
                    'standard'   => $data['standard'],
                    'status'     => 1,
                    'no_form'    => $data['no_form'],
                    'no_doc'     => $data['no_doc'],
                    'id_departemen'     => $data['id_departemen'],
                ];

                $this->db->insert('data_checksheet', $insertData);
            }
    
            echo json_encode(['status' => 'success', 'message' => 'Data berhasil disimpan']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Data tidak valid']);
        }
    }    
}
?>
