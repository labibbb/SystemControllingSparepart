<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Area extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('Area_model');
    }

    public function index() {
        $data['area'] = $this->Area_model->get_all_area();
        $data['lini'] = $this->Area_model->get_all_lini();
        $this->load->view('area', $data);
    }

    public function add() {
        $data = [
            'id_lini'   => $this->input->post('id_lini'),
            'nama_area' => $this->input->post('nama_area'),
            'status'    => 1
        ];
        $this->Area_model->insert_area($data);
        echo json_encode(['status' => 'success']);
    }

    public function edit($id) {
        echo json_encode($this->Area_model->get_area_by_id($id));
    }

    public function update() {
        $id = $this->input->post('id_area');
        $data = [
            'id_lini'   => $this->input->post('id_lini'),
            'nama_area' => $this->input->post('nama_area')
        ];
        $this->Area_model->update_area($id, $data);
        echo json_encode(['status' => 'success']);
    }

    public function delete($id) {
        $this->Area_model->delete_area($id);
        echo json_encode(['status' => 'deleted']);
    }
}
?>
