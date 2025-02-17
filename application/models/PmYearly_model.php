<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PmYearly_model extends CI_Model {

    public function get_all_settings() {
        $this->db->select('s.id_fwp, l.nama_lini, a.nama_area, m.nama_mesin, s.frekuensi, s.instruksi_kerja');
        $this->db->from('trs_settingfwm s');
        $this->db->join('lini l', 's.id_lini = l.id_lini');
        $this->db->join('area a', 's.id_area = a.id_area');
        $this->db->join('mesin m', 's.id_mesin = m.id_mesin');
        return $this->db->get()->result_array();
    }

    public function get_lini() {
        return $this->db->get_where('lini', ['status' => 1])->result_array();
    }

    public function get_area_by_lini($id_lini) {
        return $this->db->get_where('area', ['id_lini' => $id_lini, 'status' => 1])->result_array();
    }

    public function get_mesin_by_area($id_area) {
        return $this->db->get_where('mesin', ['id_area' => $id_area, 'status' => 1])->result_array();
    }

    public function insert_pmyearly($data) {
        return $this->db->insert('pm_yearly', $data);
    }

    public function getFilteredData($tahun, $bulan, $id_area) {
        $this->db->select('pm_yearly.*, lini.nama_lini, area.nama_area, mesin.nama_mesin');
        $this->db->from('pm_yearly');
        $this->db->join('lini', 'pm_yearly.id_lini = lini.id_lini');
        $this->db->join('area', 'pm_yearly.id_area = area.id_area');
        $this->db->join('mesin', 'pm_yearly.id_mesin = mesin.id_mesin');

        // Filter ID Lini = 1 (Untuk Painting 1)
        $this->db->where('pm_yearly.id_lini', 1);

        // Filter berdasarkan dropdown
        if (!empty($tahun)) {
            $this->db->where('pm_yearly.tahun', $tahun);
        }
        if (!empty($bulan)) {
            $this->db->where('pm_yearly.bulan', $bulan);
        }
        if (!empty($id_area)) {
            $this->db->where('pm_yearly.id_area', $id_area);
        }

        return $this->db->get()->result_array();
    }

    public function getFilteredData2($tahun, $bulan, $id_area) {
        $this->db->select('pm_yearly.*, lini.nama_lini, area.nama_area, mesin.nama_mesin');
        $this->db->from('pm_yearly');
        $this->db->join('lini', 'pm_yearly.id_lini = lini.id_lini');
        $this->db->join('area', 'pm_yearly.id_area = area.id_area');
        $this->db->join('mesin', 'pm_yearly.id_mesin = mesin.id_mesin');

        // Filter ID Lini = 1 (Untuk Painting 1)
        $this->db->where('pm_yearly.id_lini', 2);

        // Filter berdasarkan dropdown
        if (!empty($tahun)) {
            $this->db->where('pm_yearly.tahun', $tahun);
        }
        if (!empty($bulan)) {
            $this->db->where('pm_yearly.bulan', $bulan);
        }
        if (!empty($id_area)) {
            $this->db->where('pm_yearly.id_area', $id_area);
        }

        return $this->db->get()->result_array();
    }

    // Ambil daftar area untuk dropdown (ID lini = 1)
    public function getAreas() {
        $this->db->select('*');
        $this->db->from('area');
        $this->db->where('id_lini', 1);
        $this->db->order_by('id_area', 'ASC');
        return $this->db->get()->result_array();
    }

    public function getAreas2() {
        $this->db->select('*');
        $this->db->from('area');
        $this->db->where('id_lini', 2);
        $this->db->order_by('id_area', 'ASC');
        return $this->db->get()->result_array();
    }
}
?>
