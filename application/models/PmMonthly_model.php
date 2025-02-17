<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PmMonthly_model extends CI_Model {
    public function get_all_pmmonthly() {
        $this->db->select('pm_monthly.*, lini.nama_lini, area.nama_area, mesin.nama_mesin, users.dipname');
        $this->db->from('pm_monthly');
        $this->db->join('lini', 'pm_monthly.id_lini = lini.id_lini');
        $this->db->join('area', 'pm_monthly.id_area = area.id_area');
        $this->db->join('mesin', 'pm_monthly.id_mesin = mesin.id_mesin');
        $this->db->join('users', 'pm_monthly.id_users = users.id_users', 'left');
        return $this->db->get()->result_array();
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
