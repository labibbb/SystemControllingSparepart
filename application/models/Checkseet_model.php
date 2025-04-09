<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Checkseet_model extends CI_Model {

    public function get_all_checkseet() {
        $this->db->select('s.*, l.nama_lini, a.nama_area, m.nama_mesin');
        $this->db->from('data_checksheet s');
        $this->db->join('lini l', 's.id_lini = l.id_lini', 'left');
        $this->db->join('area a', 's.id_area = a.id_area', 'left');
        $this->db->join('mesin m', 's.id_mesin = m.id_mesin', 'left');
        $this->db->group_by(['s.id_lini', 's.id_area', 's.id_mesin']);
        return $this->db->get()->result_array();
    }    

    public function get_checkseet($id_mesin) {
        return $this->db->get_where('data_checksheet', ['id_mesin' => $id_mesin, 'status' => 1])->result_array();
    }

    public function get_singlecheckseet($id_mesin) {
        return $this->db->get_where('data_checksheet', ['id_mesin' => $id_mesin, 'status' => 1])->row_array();
    }    

    public function get_lini() {
        return $this->db->get_where('lini', ['status' => 1])->result_array();
    }

    public function get_area() {
        return $this->db->get_where('area', ['status' => 1])->result_array();
    }

    public function get_mesin() {
        return $this->db->get_where('mesin', ['status' => 1])->result_array();
    }

    public function get_departement() {
        return $this->db->get_where('departemen', ['status' => 1])->result_array();
    }

    public function get_area_by_lini($id_lini) {
        return $this->db->get_where('area', ['id_lini' => $id_lini, 'status' => 1])->result_array();
    }

    public function get_mesin_by_area($id_area) {
        return $this->db->get_where('mesin', ['id_area' => $id_area, 'status' => 1])->result_array();
    }

    public function insert_checkseet($data) {
        return $this->db->insert('data_checksheet', $data);
    }

    public function delete_checkseet($id_lini, $id_area, $id_mesin) {
        $this->db->where('id_lini', $id_lini);
        $this->db->where('id_area', $id_area);
        $this->db->where('id_mesin', $id_mesin);
        return $this->db->delete('data_checksheet');
    }
    
    public function check_existing_data($id_mesin) {
        $this->db->where('id_mesin', $id_mesin);
        $query = $this->db->get('data_checksheet'); // ganti dengan nama tabel yang benar jika berbeda
    
        return $query->num_rows() > 0;
    }   
}
?>
