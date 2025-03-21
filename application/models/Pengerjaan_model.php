<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pengerjaan_model extends CI_Model {
    public function getFilteredData() {
        $this->db->select('pm_monthly.*, area.nama_area, mesin.nama_mesin');
        $this->db->from('pm_monthly');
        $this->db->join('area', 'pm_monthly.id_area = area.id_area');
        $this->db->join('mesin', 'pm_monthly.id_mesin = mesin.id_mesin');
    
        // Filter ID Lini = 1 (Untuk Painting 1)
        $this->db->where('pm_monthly.id_lini', 1);
        $this->db->where_in('pm_monthly.status', [3, 4, 5, 6, 7, 8, 9]); // Menggunakan where_in untuk banyak nilai
        
        // Filter hanya untuk tanggal hari ini
        $this->db->where('DATE(pm_monthly.tanggal)', date('Y-m-d'));
    
        return $this->db->get()->result_array();
    }
    
    public function getFilteredData2() {
        $this->db->select('pm_monthly.*, area.nama_area, mesin.nama_mesin');
        $this->db->from('pm_monthly');
        $this->db->join('area', 'pm_monthly.id_area = area.id_area');
        $this->db->join('mesin', 'pm_monthly.id_mesin = mesin.id_mesin');
    
        // Filter ID Lini = 1 (Untuk Painting 2)
        $this->db->where('pm_monthly.id_lini', 2);
        $this->db->where_in('pm_monthly.status', [3, 4, 5, 6, 7, 8, 9]); // Menggunakan where_in untuk banyak nilai
        
        // Filter hanya untuk tanggal hari ini
        $this->db->where('DATE(pm_monthly.tanggal)', date('Y-m-d'));
    
        return $this->db->get()->result_array();
    }

    public function get_checkseet($id_mesin) {
        return $this->db->get_where('data_checksheet', ['id_mesin' => $id_mesin, 'status' => 1])->result_array();
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

    public function updateStatus($id_pmm) {
        $data = [
            'status' => 4
        ];
    
        return $this->db->where('id_pmm', $id_pmm)
                        ->update('pm_monthly', $data);
    }
}
?>
