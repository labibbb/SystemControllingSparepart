<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Manpower extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('Manpower_model');
    }
    
    public function index() {
        $data['manpower'] = $this->Manpower_model->get_all_manpower();
        $this->load->view('manpower', $data);
    }

    public function add() {
        $data = [
            'nama' => $this->input->post('nama'),
            'posisi' => $this->input->post('posisi'),
            'shift' => $this->input->post('shift'),
            'status' => 1
        ];
        $this->Manpower_model->insert_manpower($data);
        echo json_encode(['status' => 'success']);
    }

    public function edit($id) {
        $manpower = $this->Manpower_model->get_manpower_by_id($id);
        echo json_encode($manpower);
    }

    public function update() {
        $id = $this->input->post('id_manpower');
        $data = [
            'nama' => $this->input->post('nama'),
            'posisi' => $this->input->post('posisi'),
            'shift' => $this->input->post('shift')
        ];
        $this->Manpower_model->update_manpower($id, $data);
        echo json_encode(['status' => 'success']);
    }

    public function delete($id) {
        if ($id) {
            $this->Manpower_model->delete_manpower($id);
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'ID tidak valid']);
        }
    }
}
