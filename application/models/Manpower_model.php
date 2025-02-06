<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Manpower_Model extends CI_Model {
    
    public function get_all_manpower() {
        return $this->db->get('manpower')->result_array();
    }    

    public function insert_manpower($data) {
        return $this->db->insert('manpower', $data);
    }

    public function get_manpower_by_id($id) {
        return $this->db->get_where('manpower', ['id_manpower' => $id])->row_array();
    }

    public function update_manpower($id, $data) {
        $this->db->where('id_manpower', $id);
        return $this->db->update('manpower', $data);
    }

    public function delete_manpower($id) {
        $this->db->where('id_manpower', $id);
        return $this->db->update('manpower', ['status' => 0]); // Soft delete
    }
}
?>
