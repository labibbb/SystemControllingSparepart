<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Departemen_Model extends CI_Model {
    
    public function get_all_departemen() {
        return $this->db->get('departemen')->result_array();
    }    

    public function insert_departemen($data) {
        return $this->db->insert('departemen', $data);
    }

    public function get_departemen_by_id($id) {
        return $this->db->get_where('departemen', ['id' => $id])->row_array();
    }

    public function update_departemen($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('departemen', $data);
    }

    public function delete_departemen($id) {
        $this->db->where('id', $id);
        return $this->db->update('departemen', ['status' => 0]); // Soft delete
    }
}
?>
