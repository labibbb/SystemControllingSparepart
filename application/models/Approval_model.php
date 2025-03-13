<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Approval_model extends CI_Model {
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
        $this->db->where_in('pm_monthly.status', [4, 5, 6, 7, 8, 9]); // Menggunakan where_in untuk banyak nilai
        
        return $this->db->get()->result_array();
    }
    
    public function get_all_pmmonthly2() {
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
        $this->db->where_in('pm_monthly.status', [6, 8, 9]); // Menggunakan where_in untuk banyak nilai
        
        return $this->db->get()->result_array();
    }
    
    public function getFilteredData($id_lini) {
        $this->db->select('pm_monthly.*, lini.nama_lini, area.nama_area, mesin.nama_mesin, users.dipname');
        $this->db->from('pm_monthly');
        $this->db->join('lini', 'pm_monthly.id_lini = lini.id_lini');
        $this->db->join('area', 'pm_monthly.id_area = area.id_area');
        $this->db->join('mesin', 'pm_monthly.id_mesin = mesin.id_mesin');
        $this->db->join('users', 'pm_monthly.id_users = users.id_users', 'left');

        $this->db->where('pm_monthly.id_lini', $id_lini);

        return $this->db->get()->result_array();
    }

    public function get_lini() {
        return $this->db->get_where('lini', ['status' => 1])->result_array();
    }

    public function get_checkseet($id_mesin) {
        $this->db->select('trs_pengerjaan_checksheet.*, data_checksheet.item_cek, data_checksheet.point_cek, data_checksheet.metode_cek, data_checksheet.standard');
        $this->db->from('trs_pengerjaan_checksheet');
        $this->db->join('data_checksheet', 'trs_pengerjaan_checksheet.id_ck = data_checksheet.id_ck');
        
        $this->db->where('data_checksheet.id_mesin', $id_mesin);
        
        return $this->db->get()->result_array();
    } 

    public function get_singlecheckseet($id_mesin) {
        $this->db->select('data_checksheet.*, lini.nama_lini, area.nama_area, mesin.nama_mesin');
        $this->db->from('data_checksheet');
        $this->db->join('lini', 'data_checksheet.id_lini = lini.id_lini');
        $this->db->join('area', 'data_checksheet.id_area = area.id_area');
        $this->db->join('mesin', 'data_checksheet.id_mesin = mesin.id_mesin');
        
        $this->db->where('data_checksheet.id_mesin', $id_mesin);
        
        return $this->db->get()->row_array();
    }
    
    public function get_wi($id_mesin) {
        $this->db->select('trs_settingfwm.*, data_wi.nama_wi, data_wi.nama_file');
        $this->db->from('trs_settingfwm');
        $this->db->join('data_wi', 'trs_settingfwm.instruksi_kerja = data_wi.id_wi');
        
        $this->db->where('trs_settingfwm.id_mesin', $id_mesin);
        
        return $this->db->get()->row_array();
    }

    public function approveFr($id_pmm, $id_user) {
        $data = [
            'status' => 6,
            'fr' => $id_user,
        ];        
    
        return $this->db->where('id_pmm', $id_pmm)->update('pm_monthly', $data);
    }

    public function rejectFr($id_pmm, $id_user) {
        $data = [
            'status' => 7,
            'fr' => $id_user
        ];
    
        return $this->db->where('id_pmm', $id_pmm)
                        ->update('pm_monthly', $data);
    }

    public function approveSpv($id_pmm, $id_user) {
        $data = [
            'status' => 8,
            'spv' => $id_user
        ];
    
        return $this->db->where('id_pmm', $id_pmm)
                        ->update('pm_monthly', $data);
    }

    public function rejectSpv($id_pmm, $id_user) {
        $data = [
            'status' => 9,
            'spv' => $id_user
        ];
    
        return $this->db->where('id_pmm', $id_pmm)
                        ->update('pm_monthly', $data);
    }

    public function update($id_pmm, $data) {
        return $this->db->where('id_pmm', $id_pmm)->update('pm_monthly', $data);
    }
}
?>
