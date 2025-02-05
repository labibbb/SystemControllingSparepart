<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Area_model extends CI_Model {
    
    public function get_all_area() {
        $this->db->select('area.*, lini.nama_lini');
        $this->db->from('area');
        $this->db->join('lini', 'lini.id_lini = area.id_lini');
        $this->db->order_by('area.status', 'DESC');
        return $this->db->get()->result_array();
    }

    public function get_all_lini() {
        return $this->db->get('lini')->result_array();
    }

    public function insert_area($data) {
        return $this->db->insert('area', $data);
    }

    public function get_area_by_id($id) {
        return $this->db->get_where('area', ['id_area' => $id])->row_array();
    }

    public function update_area($id, $data) {
        $this->db->where('id_area', $id);
        return $this->db->update('area', $data);
    }

    public function delete_area($id) {
        $this->db->where('id_area', $id);
        return $this->db->update('area', ['status' => 0]); // Soft delete
    }
}
?>
