<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Historymesin_model extends CI_Model {    

    public function get_all_checksheet_by_mesin($id_mesin) {
        $this->db->select('
            trs_pengerjaan_checksheet.*, 
            data_checksheet.item_cek, 
            data_checksheet.point_cek, 
            data_checksheet.metode_cek, 
            data_checksheet.standard,
        ');
        $this->db->from('trs_pengerjaan_checksheet');
        $this->db->join('data_checksheet', 'trs_pengerjaan_checksheet.id_ck = data_checksheet.id_ck');
        $this->db->join('pm_monthly', 'trs_pengerjaan_checksheet.id_pmm = pm_monthly.id_pmm'); // Join untuk ambil tanggal
        $this->db->where('trs_pengerjaan_checksheet.id_mesin', $id_mesin);
        return $this->db->get()->result_array();
    }
    public function get_all_mesin_with_area() {
        $this->db->select('mesin.*, area.nama_area, lini.nama_lini');  // Tambahkan lini
        $this->db->from('mesin');
        $this->db->join('area', 'mesin.id_area = area.id_area', 'left');  // Join area
        $this->db->join('lini', 'area.id_lini = lini.id_lini', 'left');  // Join lini melalui area
        $this->db->order_by('lini.nama_lini', 'ASC');  // Urutkan berdasarkan lini
        $this->db->order_by('area.nama_area', 'ASC');  // Urutkan berdasarkan area
        return $this->db->get()->result_array();  // Kembalikan hasil query dalam bentuk array
    }
    public function get_mesin_info($id_mesin) {
        $this->db->select('mesin.*, area.nama_area, lini.nama_lini');
        $this->db->from('mesin');
        $this->db->join('area', 'mesin.id_area = area.id_area', 'left');
        $this->db->join('lini', 'area.id_lini = lini.id_lini', 'left');
        $this->db->where('mesin.id_mesin', $id_mesin);
        return $this->db->get()->row_array();
    }
    
    public function get_checksheet_by_mesin($id_mesin) {
        $this->db->select('
            t.*, 
            dc.item_cek, 
            dc.point_cek, 
            dc.metode_cek, 
            dc.standard,
            pm.tanggal as tanggal_pengerjaan
        ');
        $this->db->from('trs_pengerjaan_checksheet t');
        $this->db->join('data_checksheet dc', 't.id_ck = dc.id_ck');
        $this->db->join('pm_monthly pm', 't.id_pmm = pm.id_pmm');
        $this->db->where('t.id_mesin', $id_mesin);
        $this->db->order_by('pm.tanggal', 'DESC');
        return $this->db->get()->result_array();
    }
    public function get_checksheet_by_mesin_with_date($id_mesin, $start_date, $end_date) {
        $this->db->where('id_mesin', $id_mesin);
        $this->db->where('tanggal_pengerjaan >=', $start_date);
        $this->db->where('tanggal_pengerjaan <=', $end_date);
        $this->db->order_by('tanggal_pengerjaan', 'desc');
        return $this->db->get('checksheet')->result_array();
    }
    public function get_gambarPm($id_pmm) {
        $this->db->select('gambarPm');
        $this->db->from('trs_pengerjaan_checksheet');
        $this->db->where('id_pmm', $id_pmm);
        $this->db->limit(1);
        
        return $this->db->get()->row_array();
    }
    
}
?>
