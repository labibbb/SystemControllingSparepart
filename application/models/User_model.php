<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function check_login($username, $password) {
    // Ambil user berdasarkan username
    $user = $this->db->where('username', $username)
                     ->where('status', 1)
                     ->where('active', 1)
                     ->get('users')
                     ->row();
    
    if (!$user) {
        return false;
    }
    
    // Verifikasi password dengan dua metode
    if (password_verify($password, $user->password)) {
        // Jika password cocok dengan hash modern
        return $user;
    } elseif (md5($password) === $user->password) {
        // Jika password cocok dengan MD5 (legacy)
        // Optionally: update ke hash modern
        $this->db->where('id_users', $user->id_users)
                 ->update('users', ['password' => password_hash($password, PASSWORD_DEFAULT)]);
        return $user;
    }
    
    return false;
}

    public function get_all_users() {
        return $this->db->get('users')->result_array();
    }
    
    public function get_all_userz() {
        $this->db->select('users.*, departemen.dept');
        $this->db->from('users');
        $this->db->join('departemen', 'departemen.id = users.id');
        $this->db->order_by('users.status', 'DESC');
        return $this->db->get()->result_array();
    }

    public function get_all_dept() {
        return $this->db->get('departemen')->result_array();
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
