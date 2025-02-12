<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mesin_model extends CI_Model {
    public function get_all_mesin_with_area() {
        $this->db->select('mesin.*, area.nama_area, lini.nama_lini');  // Tambahkan lini
        $this->db->from('mesin');
        $this->db->join('area', 'mesin.id_area = area.id_area', 'left');  // Join area
        $this->db->join('lini', 'area.id_lini = lini.id_lini', 'left');  // Join lini melalui area
        $this->db->order_by('lini.nama_lini', 'ASC');  // Urutkan berdasarkan lini
        $this->db->order_by('area.nama_area', 'ASC');  // Urutkan berdasarkan area
        return $this->db->get()->result_array();  // Kembalikan hasil query dalam bentuk array
    }
    
    public function get_all_mesin() {
        return $this->db->get('mesin')->result_array();
    }

    public function get_mesin_by_id($id) {
        return $this->db->get_where('mesin', ['id_mesin' => $id])->row_array();
    }

    public function insert_mesin($data) {
        return $this->db->insert('mesin', $data);
    }

    public function update_mesin($id, $data) {
        $this->db->where('id_mesin', $id);
        return $this->db->update('mesin', $data);
    }

    public function delete_mesin($id) {
        $this->db->where('id_mesin', $id);
        return $this->db->update('mesin', ['status' => 0]); // Soft delete
    }

    public function get_active_areas() {
        return $this->db->get_where('area', ['status' => 1])->result_array();
    }
    public function get_areas_by_lini($nama_lini) {
        $this->db->select('id_area, nama_area');
        $this->db->from('area');
        $this->db->join('lini', 'area.id_lini = lini.id_lini');
        $this->db->where('lini.nama_lini', $nama_lini);
        return $this->db->get()->result_array();
    }
    
}
?>
