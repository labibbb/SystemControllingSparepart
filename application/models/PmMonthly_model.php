<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PmMonthly_model extends CI_Model {
    public function get_all_pmmonthly() {
        $this->db->select('
            pm_monthly.*, 
            lini.nama_lini, 
            area.nama_area, 
            mesin.nama_mesin, 
            u1.dipname AS user_name, 
            u2.dipname AS foreman_name, 
            u3.dipname AS supervisor_name
        ');
        $this->db->from('pm_monthly');
        $this->db->join('lini', 'pm_monthly.id_lini = lini.id_lini');
        $this->db->join('area', 'pm_monthly.id_area = area.id_area');
        $this->db->join('mesin', 'pm_monthly.id_mesin = mesin.id_mesin');
        $this->db->join('users AS u1', 'pm_monthly.id_users = u1.id_users', 'left'); // User Pembuat
        $this->db->join('users AS u2', 'pm_monthly.fr = u2.id_users', 'left'); // Foreman
        $this->db->join('users AS u3', 'pm_monthly.spv = u3.id_users', 'left'); // Supervisor
        $this->db->where('pm_monthly.id_lini', 1);
        
        return $this->db->get()->result_array();
    }    
    
    public function getFilteredData($id_lini) {
        $this->db->select('
            pm_monthly.*, 
            lini.nama_lini, 
            area.nama_area, 
            mesin.nama_mesin, 
            u1.dipname AS user_name, 
            u2.dipname AS foreman_name, 
            u3.dipname AS supervisor_name
        ');
        $this->db->from('pm_monthly');
        $this->db->join('lini', 'pm_monthly.id_lini = lini.id_lini');
        $this->db->join('area', 'pm_monthly.id_area = area.id_area');
        $this->db->join('mesin', 'pm_monthly.id_mesin = mesin.id_mesin');
        $this->db->join('users AS u1', 'pm_monthly.id_users = u1.id_users', 'left'); // User Pembuat
        $this->db->join('users AS u2', 'pm_monthly.fr = u2.id_users', 'left'); // Foreman
        $this->db->join('users AS u3', 'pm_monthly.spv = u3.id_users', 'left'); // Supervisor
    
        $this->db->where('pm_monthly.id_lini', $id_lini);
    
        return $this->db->get()->result_array();
    }    

    public function get_lini() {
        return $this->db->get_where('lini', ['status' => 1])->result_array();
    }

    public function get_manpower() {
        return $this->db->get_where('users', ['status' => 1, 'level' => 3])->result_array();
    }
    
    public function update_tanggal_catatan($id_pmm, $data) {
        return $this->db->where('id_pmm', $id_pmm)->update('pm_monthly', $data);
    }

    public function update_mp($id_pmm, $data) {
        return $this->db->where('id_pmm', $id_pmm)->update('pm_monthly', $data);
    }
}
?>
