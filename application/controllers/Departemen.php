<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Departemen extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('Departemen_Model');
    }
    
    public function index() {
        $data['departemen'] = $this->Departemen_Model->get_all_departemen();
        $this->load->view('departemen', $data);
    }

    public function add() {
        $data = [
            'init' => $this->input->post('init'),
            'dept' => $this->input->post('dept'),
            'status' => 1,
            'sysdate' => date('Y-m-d H:i:s') // Menggunakan format lengkap (YYYY-MM-DD HH:MM:SS)
        ];
        $this->Departemen_Model->insert_departemen($data);
        echo json_encode(['status' => 'success']);
    }

    public function edit($id) {
        $departemen = $this->Departemen_Model->get_departemen_by_id($id);
        echo json_encode($departemen);
    }

    public function update() {
        $id = $this->input->post('id');
        date_default_timezone_set('Asia/Jakarta'); // Pastikan timezone sesuai lokasi

        $data = [
            'init' => $this->input->post('init'),
            'dept' => $this->input->post('dept'),
            'sysdate' => date('Y-m-d H:i:s') // Menggunakan format lengkap (YYYY-MM-DD HH:MM:SS)

        ];
        $this->Departemen_Model->update_departemen($id, $data);
        echo json_encode(['status' => 'success']);
    }

    public function delete($id) {
        if ($id) {
            $this->Departemen_Model->delete_departemen($id);
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'ID tidak valid']);
        }
    }
}
?>
