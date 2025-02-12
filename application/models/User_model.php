<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function check_login($username, $password) {
        // Query untuk memeriksa username, password, status, dan active
        $this->db->where('username', $username);
   //     $this->db->where('password', md5($password)); // Bisa diganti dengan password_hash
        $this->db->where('status', 1);
        $this->db->where('active', 1);
        $query = $this->db->get('users');

        // Jika ada hasil, return data pengguna
        if ($query->num_rows() > 0) {
            return $query->row(); // Mengembalikan satu baris data user
        }
        return false;
    }

    public function get_all_users() {
        return $this->db->get('users')->result_array();
    }    

    public function insert_user($data) {
        return $this->db->insert('users', $data);
    }

    public function get_user_by_id($id) {
        return $this->db->get_where('users', ['id_users' => $id])->row_array();
    }

    public function update_user($id, $data) {
        $this->db->where('id_users', $id);
        return $this->db->update('users', $data);
    }

    public function delete_user($id) {
        $this->db->where('id_users', $id);
        return $this->db->update('users', ['active' => 0]); // Soft delete
    }
}
?>
