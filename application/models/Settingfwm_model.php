<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Settingfwm_model extends CI_Model {

    public function get_all_settings() {
        $this->db->select('s.*, l.nama_lini, a.nama_area, m.nama_mesin, w.nama_wi');
        $this->db->from('trs_settingfwm s');
        $this->db->join('lini l', 's.id_lini = l.id_lini');
        $this->db->join('area a', 's.id_area = a.id_area');
        $this->db->join('mesin m', 's.id_mesin = m.id_mesin');
        $this->db->join('data_wi w', 's.instruksi_kerja = w.id_wi', 'left');
        return $this->db->get()->result_array();
    }

    public function get_wi() {
        return $this->db->get_where('data_wi', ['status' => 1])->result_array();
    }
    public function get_lini() {
        return $this->db->get_where('lini', ['status' => 1])->result_array();
    }

    public function get_area_by_lini($id_lini) {
        return $this->db->get_where('area', ['id_lini' => $id_lini, 'status' => 1])->result_array();
    }

    public function get_mesin_by_area($id_area) {
        return $this->db->get_where('mesin', ['id_area' => $id_area, 'status' => 1])->result_array();
    }

    public function insert_setting($data) {
        return $this->db->insert('trs_settingfwm', $data);
    }

    public function update_frekuensi($id, $frekuensi) {
        return $this->db->update('trs_settingfwm', ['frekuensi' => $frekuensi], ['id_fwp' => $id]);
    }

    public function update_instruksi($id, $instruksi) {
        return $this->db->update('trs_settingfwm', ['instruksi_kerja' => $instruksi], ['id_fwp' => $id]);
    }
}
?>
