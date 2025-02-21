<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Wi_model extends CI_Model {
    
    public function get_all_wi() {
        $this->db->select('data_wi.*, users.dipname');
        $this->db->from('data_wi');
        $this->db->join('users', 'users.id_users = data_wi.id_users');
        $this->db->order_by('data_wi.status', 'DESC');
        return $this->db->get()->result_array();
    }

    public function insert_wi($data) {
        return $this->db->insert('data_wi', $data);
    }

    public function get_wi_by_id($id) {
        return $this->db->get_where('data_wi', ['id_wi' => $id])->row_array();
    }

    public function update_wi($id, $data) {
        $this->db->where('id_wi', $id);
        return $this->db->update('data_wi', $data);
    }

    public function delete_wi($id) {
        $this->db->where('id_area', $id);
        return $this->db->update('area', ['status' => 0]); // Soft delete
    }
}
?>