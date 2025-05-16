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
        $id_mesin = $this->input->post('id_mesin');
        
        $area = $this->Checkseet_model->get_area();
        $mesin = $this->Checkseet_model->get_mesin();
        $lini = $this->Checkseet_model->get_lini();
        $departemen = $this->Checkseet_model->get_departement();
        $singlechecksheet = $this->Checkseet_model->get_singlecheckseet($id_mesin); 
        $checksheet = $this->Checkseet_model->get_checkseet($id_mesin); 

        $data = [
            'lini' => $lini,
            'area' => $area,
            'mesin' => $mesin,
            'departemen' => $departemen,
            'singleChecksheet' => $singlechecksheet,
            'checksheet' => $checksheet
        ];

        $this->load->view('checksheetEdit', $data);
    }

    public function view() {
        $id_mesin = $this->input->post('id_mesin');
        
        $area = $this->Checkseet_model->get_area();
        $mesin = $this->Checkseet_model->get_mesin();
        $lini = $this->Checkseet_model->get_lini();
        $departemen = $this->Checkseet_model->get_departement();
        $singlechecksheet = $this->Checkseet_model->get_singlecheckseet($id_mesin); 
        $checksheet = $this->Checkseet_model->get_checkseet($id_mesin); 

        $data = [
            'lini' => $lini,
            'area' => $area,
            'mesin' => $mesin,
            'departemen' => $departemen,
            'singleChecksheet' => $singlechecksheet,
            'checksheet' => $checksheet
        ];

        $this->load->view('checksheetView', $data);
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

    public function editChecksheet() {
    $jsonData = json_decode($this->input->raw_input_stream, true);
    
    if (!$jsonData || !isset($jsonData['data'])) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid data']);
        return;
    }

    $this->db->trans_start();
    
    try {
        $id_mesin = $jsonData['data'][0]['id_mesin'] ?? null;
        
        if (!$id_mesin) {
            throw new Exception('ID Mesin tidak valid');
        }

        // 1. Ambil semua data checksheet yang ada untuk mesin ini
        $existingChecks = $this->db->select('id_ck, item_cek, point_cek')
                                 ->from('data_checksheet')
                                 ->where('id_mesin', $id_mesin)
                                 ->get()
                                 ->result_array();

        // 2. Proses update atau insert data baru
        foreach ($jsonData['data'] as $data) {
            $checkData = [
                'id_lini' => $data['id_lini'],
                'id_area' => $data['id_area'],
                'id_mesin' => $data['id_mesin'],
                'item_cek' => $data['item_cek'],
                'point_cek' => $data['point_cek'],
                'metode_cek' => $data['metode_cek'],
                'standard' => $data['standard'],
                'status' => 1,
                'no_form' => $data['no_form'],
                'no_doc' => $data['no_doc'],
                'nama_doc' => $data['nama_doc'],
                'tanggal_doc' => $data['tanggal_doc'],
                'departemen' => $data['id_departemen']
            ];

            // Cek apakah data sudah ada (berdasarkan item_cek dan point_cek)
            $existing = array_filter($existingChecks, function($item) use ($data) {
                return $item['item_cek'] == $data['item_cek'] && $item['point_cek'] == $data['point_cek'];
            });

            if (!empty($existing)) {
                $existing = array_shift($existing);
                // Update data yang sudah ada
                $this->db->where('id_ck', $existing['id_ck'])
                         ->update('data_checksheet', $checkData);
            } else {
                // Insert data baru
                $this->db->insert('data_checksheet', $checkData);
            }
        }

        // 3. Non-aktifkan data yang tidak ada di input baru (soft delete)
        $newItems = array_map(function($item) {
            return $item['item_cek'].'|'.$item['point_cek'];
        }, $jsonData['data']);

        foreach ($existingChecks as $existing) {
            $key = $existing['item_cek'].'|'.$existing['point_cek'];
            if (!in_array($key, $newItems)) {
                $this->db->where('id_ck', $existing['id_ck'])
                         ->update('data_checksheet', ['status' => 0]);
            }
        }

        $this->db->trans_complete();
        
        echo json_encode(['status' => 'success', 'message' => 'Data berhasil diupdate']);
    } catch (Exception $e) {
        $this->db->trans_rollback();
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    }
}
    public function insertChecksheet() {
        // Menerima data dalam format JSON
        $jsonData = json_decode($this->input->raw_input_stream, true);
        
        if (!isset($jsonData['data']) || !is_array($jsonData['data'])) {
            echo json_encode(['status' => 'error', 'message' => 'Data tidak valid']);
            return;
        }
    
        $dataList = $jsonData['data'];
        $user_id = $this->session->userdata('user_id');
        
        $firstData = $dataList[0];
        $id_mesin = isset($firstData['id_mesin']) ? (int)$firstData['id_mesin'] : null;
        $existing = $this->Checkseet_model->check_existing_data($id_mesin);

        if ($existing) {
            echo json_encode([
                'status' => 'error'
            ]);
            return;
        }

        foreach ($dataList as $data) {
            $insertData = [
                'id_lini'        => isset($data['id_lini']) ? (int)$data['id_lini'] : null, 
                'id_area'        => isset($data['id_area']) ? (int)$data['id_area'] : null,
                'id_mesin'       => isset($data['id_mesin']) ? (int)$data['id_mesin'] : null, 
                'item_cek'       => isset($data['item_cek']) ? trim($data['item_cek']) : null, 
                'point_cek'      => isset($data['point_cek']) ? trim($data['point_cek']) : null, 
                'metode_cek'     => isset($data['metode_cek']) ? trim($data['metode_cek']) : null, 
                'standard'       => isset($data['standard']) ? trim($data['standard']) : null, 
                'status'         => isset($data['status']) ? (int)$data['status'] : 1, 
                'no_form'        => isset($data['no_form']) ? trim($data['no_form']) : null, 
                'no_doc'         => isset($data['no_doc']) ? trim($data['no_doc']) : null, 
                'nama_doc'       => isset($data['nama_doc']) ? trim($data['nama_doc']) : null, 
                'tanggal_doc'    => isset($data['tanggal_doc']) ? trim($data['tanggal_doc']) : null, 
                'departemen'     => isset($data['id_departemen']) ? trim($data['id_departemen']) : null,
            ];
    
            log_message('debug', 'Insert Data: ' . print_r($insertData, true));
    
            if (!$this->db->insert('data_checksheet', $insertData)) {
                log_message('error', 'Failed to insert data');
            }
        }
    
        echo json_encode(['status' => 'success', 'message' => 'Data berhasil disimpan']);
    }            
}
?>
