<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lini_model extends CI_Model {
    
    public function get_all_lini() {
        return $this->db->get('lini')->result_array();
    }    

    public function insert_lini($data) {
        return $this->db->insert('lini', $data);
    }

    public function get_lini_by_id($id) {
        return $this->db->get_where('lini', ['id_lini' => $id])->row_array();
    }

    public function update_lini($id, $data) {
        $this->db->where('id_lini', $id);
        return $this->db->update('lini', $data);
    }

    public function delete_lini($id) {
        $this->db->where('id_lini', $id);
        return $this->db->update('lini', ['status' => 0]); // Soft delete
    }
}
?>
