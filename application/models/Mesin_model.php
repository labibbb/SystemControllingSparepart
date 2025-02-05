<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mesin_model extends CI_Model {
    public function get_all_mesin_with_area() {
        $this->db->select('mesin.*, area.nama_area');  // Pilih kolom mesin dan nama area
        $this->db->from('mesin');
        $this->db->join('area', 'mesin.id_area = area.id_area', 'left');  // Join dengan tabel area
        return $this->db->get()->result_array();  // Mengambil hasilnya dalam bentuk array
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
}
?>
