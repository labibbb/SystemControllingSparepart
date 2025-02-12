<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Settingfwm extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Settingfwm_model');
    }

    public function index() {
        $data['settings'] = $this->Settingfwm_model->get_all_settings();
        $data['lini'] = $this->Settingfwm_model->get_lini();
        $this->load->view('settingfwm', $data);
    }

    public function get_area() {
        $id_lini = $this->input->post('id_lini');
        echo json_encode($this->Settingfwm_model->get_area_by_lini($id_lini));
    }

    public function get_mesin() {
        $id_area = $this->input->post('id_area');
        echo json_encode($this->Settingfwm_model->get_mesin_by_area($id_area));
    }

    public function add() {
        $data = [
            'id_lini' => $this->input->post('id_lini'),
            'id_area' => $this->input->post('id_area'),
            'id_mesin' => $this->input->post('id_mesin'),
            'frekuensi' => '-',
            'instruksi_kerja' => '-',
            'status' => 1,
            'sysdate' => date('Y-m-d H:i:s')
        ];

        if ($this->Settingfwm_model->insert_setting($data)) {
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error']);
        }
    }

    public function update_frekuensi() {
        $id = $this->input->post('id_fwp');
        $frekuensi = $this->input->post('frekuensi');
        
        if ($this->Settingfwm_model->update_frekuensi($id, $frekuensi)) {
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error']);
        }
    }

    public function update_instruksi() {
        $id = $this->input->post('id_fwp');
        $instruksi = $this->input->post('instruksi_kerja');
        
        if ($this->Settingfwm_model->update_instruksi($id, $instruksi)) {
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error']);
        }
    }
}
?>
