<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Approval_model extends CI_Model {
    public function get_all_pmmonthly_monitoring() {
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
        $this->db->where_in('pm_monthly.status', [4, 5, 6, 7, 8]); // Menggunakan where_in untuk banyak nilai
        
        return $this->db->get()->result_array();
    }

    public function get_all_pmmonthly_planaktual() {
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
        $this->db->where_in('pm_monthly.status', [2, 3, 4, 5, 6, 7, 8]); // Menggunakan where_in untuk banyak nilai
        $this->db->where('pm_monthly.id_lini', 1); // Menambahkan filter untuk id_lini = 1
    
        return $this->db->get()->result_array();
    }
    
    public function get_all_pmmonthly_planaktual2() {
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
        $this->db->where_in('pm_monthly.status', [2, 3, 4, 5, 6, 7, 8]); // Menggunakan where_in untuk banyak nilai
        $this->db->where('pm_monthly.id_lini', 2); // Menambahkan filter untuk id_lini = 1
    
        return $this->db->get()->result_array();
    }
    
    
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
        $this->db->where_in('pm_monthly.status', [5, 6, 7, 8, 9]); // Menggunakan where_in untuk banyak nilai
        
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
        $this->db->where_in('pm_monthly.status', [6, 7, 8, 9]); // Menggunakan where_in untuk banyak nilai
        
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

    public function get_checkseet($id_pmm) {
        $this->db->select('trs_pengerjaan_checksheet.*, data_checksheet.item_cek, data_checksheet.point_cek, data_checksheet.metode_cek, data_checksheet.standard');
        $this->db->from('trs_pengerjaan_checksheet');
        $this->db->join('data_checksheet', 'trs_pengerjaan_checksheet.id_ck = data_checksheet.id_ck');
        
        $this->db->where('trs_pengerjaan_checksheet.id_pmm', $id_pmm);
        
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
    
    public function get_diverifikasi($id_pmm) {
        $this->db->select('
            pm_monthly.*, 
            u1.dipname AS prepared, 
            u2.dipname AS checked, 
            u3.dipname AS approve,
            pm_yearly.status AS yearStatus
        ');
        $this->db->from('pm_monthly');
        $this->db->join('users AS u1', 'pm_monthly.preparedBy = u1.id_users', 'left'); 
        $this->db->join('users AS u2', 'pm_monthly.checkedBy = u2.id_users', 'left'); 
        $this->db->join('users AS u3', 'pm_monthly.approveBy = u3.id_users', 'left'); 
        $this->db->join('pm_yearly', 'pm_monthly.id_pmy = pm_yearly.id_pmy', 'left'); 
        $this->db->where('pm_monthly.id_pmm', $id_pmm); 
    
        return $this->db->get()->row_array(); 
    }

    public function get_wi($id_mesin) {
        $this->db->select('trs_settingfwm.*, data_wi.nama_wi, data_wi.nama_file');
        $this->db->from('trs_settingfwm');
        $this->db->join('data_wi', 'trs_settingfwm.instruksi_kerja = data_wi.id_wi');
        
        $this->db->where('trs_settingfwm.id_mesin', $id_mesin);
        
        return $this->db->get()->row_array();
    }

    public function get_catatan($id_pmm) {
        $this->db->select('catatanReject');
        $this->db->from('pm_monthly');
        $this->db->where('id_pmm', $id_pmm);
    
        $result = $this->db->get()->row();
        return $result ? $result->catatanReject : null;
    }    

    public function approveFr($id_pmm, $id_user) {
        $data = [
            'status' => 6,
            'fr' => $id_user,
            'checkedBy' => $id_user,
            'checkedDate' => date('Y-m-d H:i:s')
        ];        
    
        return $this->db->where('id_pmm', $id_pmm)->update('pm_monthly', $data);
    }

    public function rejectFr($id_pmm, $user_id, $catatan) {
        $data = [
            'status' => 7,  // Ubah status ke "rejected"
            'catatanReject' => $catatan,
            'statusReject' => 1
        ];
    
        $this->db->where('id_pmm', $id_pmm);
        return $this->db->update('pm_monthly', $data); // Pastikan tabelnya benar
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

    public function approveSpv($id_pmm, $id_user) {
        $this->db->trans_start(); // Mulai transaksi database
        
        // Update status pm_monthly
        $data = [
            'status' => 8,
            'spv' => $id_user,
            'approveBy' => $id_user,
            'approveDate' => date('Y-m-d H:i:s')
        ];
        $this->db->where('id_pmm', $id_pmm)
                 ->update('pm_monthly', $data);
        
        // Ambil data tanggal dari pm_monthly
        $pmMonthly = $this->db->where('id_pmm', $id_pmm)
                      ->get('pm_monthly')
                      ->row();
        
        if ($pmMonthly) {
            $tanggal_pmm = strtotime($pmMonthly->tanggal); // Konversi ke timestamp
            $tanggal_sekarang = strtotime(date('Y-m-d'));
    
            // Tentukan status berdasarkan tanggal
            $status_pm_yearly = ($tanggal_pmm < $tanggal_sekarang) ? 2 : 3;
    
            // Update status di pm_yearly
            $this->db->where('id_pmy', $pmMonthly->id_pmy)
                     ->update('pm_yearly', ['status' => $status_pm_yearly]);
        }
    
        if ($pmMonthly) {
            $id_mesin = $pmMonthly->id_mesin;
            $freq = $this->db->where('id_mesin', $id_mesin)
                        ->get('trs_settingfwm')
                        ->row();
    
            $pmyearly = $this->db->where('id_pmy', $pmMonthly->id_pmy)
                ->get('pm_yearly')
                ->row();            
            
            if ($freq && $pmyearly) {
                $tahun_lama = $pmyearly->tahun;
                $bulan_lama = $pmyearly->bulan;
                $frekuensi = $freq->frekuensi; // Format bisa '1 week', '2 months', '1 year'
                
                // Cek apakah frekuensi dalam bentuk minggu, bulan, atau tahun
                if (strpos($frekuensi, 'week') !== false) {
                    $jumlah_minggu = (int) filter_var($frekuensi, FILTER_SANITIZE_NUMBER_INT);
                    $tanggal_baru = date('Y-m', strtotime("+$jumlah_minggu weeks", strtotime("$tahun_lama-$bulan_lama-01")));
                } elseif (strpos($frekuensi, 'month') !== false) {
                    $jumlah_bulan = (int) filter_var($frekuensi, FILTER_SANITIZE_NUMBER_INT);
                    $tanggal_baru = date('Y-m', strtotime("+$jumlah_bulan months", strtotime("$tahun_lama-$bulan_lama-01")));
                } elseif (strpos($frekuensi, 'year') !== false) {
                    $jumlah_tahun = (int) filter_var($frekuensi, FILTER_SANITIZE_NUMBER_INT);
                    $tanggal_baru = date('Y-m', strtotime("+$jumlah_tahun years", strtotime("$tahun_lama-$bulan_lama-01")));
                } else {
                    $tanggal_baru = "$tahun_lama-$bulan_lama"; // Default jika format tidak dikenal
                }
    
                list($tahun_baru, $bulan_baru) = explode('-', $tanggal_baru);
    
                // Insert data baru ke pm_yearly
                $data_pmy = [
                    'id_lini' => $pmyearly->id_lini,
                    'id_area' => $pmyearly->id_area,
                    'id_mesin' => $pmyearly->id_mesin,
                    'tahun' => $tahun_baru,
                    'bulan' => $bulan_baru,
                    'status' => 1 // Status default untuk entri baru
                ];
                $this->db->insert('pm_yearly', $data_pmy);
            }
        }
        
        return $this->db->trans_complete(); // Selesaikan transaksi
    }
    
}
?>
