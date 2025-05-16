<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pengerjaan extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Pengerjaan_model');
        $this->load->library('session');
        $this->check_session_timeout();
    }

    private function check_session_timeout()
    {
        $timeout = 8 * 60 * 60; // 8 jam dalam detik

        if ($this->session->userdata('logged_in')) {
            $last_login_time = $this->session->userdata('last_login_time');

            if ((time() - $last_login_time) > $timeout) {
                $this->session->sess_destroy(); // Hapus sesi
                redirect('login'); // Redirect ke halaman login
                exit();
            } else {
                // Perbarui waktu login agar tidak logout saat masih aktif
                $this->session->set_userdata('last_login_time', time());
            }
        } else {
            redirect('login'); // Jika belum login, redirect ke halaman login
            exit();
        }
    }

    public function index()
    {
        if (!$this->session->userdata('logged_in') || $this->session->userdata('level') != 3) {
            show_404(); // Tampilkan halaman 404
        }
        $pmmonthly = $this->Pengerjaan_model->getFilteredData($this->session->userdata('user_id'));
        $pmmonthly2 = $this->Pengerjaan_model->getFilteredData2($this->session->userdata('user_id'));
        $pmmonthly3 = $this->Pengerjaan_model->get_all_pmmonthly_monitoring();

        $data = [
            'pmmonthly' => $pmmonthly,
            'pmmonthly2' => $pmmonthly2,
            'pmmonthly3' => $pmmonthly3
        ];

        $this->load->view('pengerjaanView', $data);
    }

    public function detail()
    {
        $id_mesin = $this->input->post('id_mesin');
        $tanggal = $this->input->post('tanggal');
        $id_pmm = $this->input->post('id_pmm');

        $update = $this->Pengerjaan_model->updateStatus($id_pmm);
        $singlechecksheet = $this->Pengerjaan_model->get_singlecheckseet($id_mesin);
        $checksheet = $this->Pengerjaan_model->get_checkseet($id_mesin);
        $wi = $this->Pengerjaan_model->get_wi($id_mesin);
        $pmm = $this->Pengerjaan_model->get_diverifikasi($id_pmm);
        $data = [
            'singleChecksheet' => $singlechecksheet,
            'checksheet' => $checksheet,
            'tanggal' => $tanggal,
            'wi' => $wi,
            'id_pmm' => $id_pmm,
            'pmm' => $pmm
        ];

        $this->load->view('pengerjaanDetail', $data);
    }

    public function insertPengerjaan()
    {
        $dataList = $this->input->post('data');
        $user_id = $this->session->userdata('user_id');

        $upload_path = './uploads/pengerjaan/';
        if (!is_dir($upload_path)) {
            mkdir($upload_path, 0777, true);
        }

        foreach ($dataList as $index => $data) {
            $image_name = null;

            // Cek apakah ada file gambar yang dikirim
            if (!empty($_FILES["gambar_{$index}"]['name'])) {
                $file_ext = pathinfo($_FILES["gambar_{$index}"]['name'], PATHINFO_EXTENSION);
                $image_name = 'pengerjaan_' . time() . "_$index." . $file_ext; // Nama unik
                $target_file = $upload_path . $image_name;

                // Pindahkan file ke folder uploads
                if (!move_uploaded_file($_FILES["gambar_{$index}"]['tmp_name'], $target_file)) {
                    echo json_encode(['status' => 'error', 'message' => 'Gagal mengupload gambar']);
                    return;
                }
            }

            $image_name2 = null;

            // Cek apakah ada file gambar yang dikirim
            if (!empty($_FILES["gambarPm_{$index}"]['name'])) {
                $file_ext = pathinfo($_FILES["gambarPm_{$index}"]['name'], PATHINFO_EXTENSION);
                $image_name2 = 'pengerjaanPm_' . time() . "_$index." . $file_ext; // Nama unik
                $target_file = $upload_path . $image_name2;

                // Pindahkan file ke folder uploads
                if (!move_uploaded_file($_FILES["gambarPm_{$index}"]['tmp_name'], $target_file)) {
                    echo json_encode(['status' => 'error', 'message' => 'Gagal mengupload gambar']);
                    return;
                }
            }

            $insertData = [
                'id_users'   => isset($user_id) ? trim($user_id) : null,
                'id_pmm'     => isset($data['id_pmm']) ? (int)$data['id_pmm'] : null,
                'id_ck'      => isset($data['id_ck']) ? (int)$data['id_ck'] : null,
                'id_lini'    => isset($data['id_lini']) ? (int)$data['id_lini'] : null,
                'id_area'    => isset($data['id_area']) ? (int)$data['id_area'] : null,
                'id_mesin'   => isset($data['id_mesin']) ? (int)$data['id_mesin'] : null,
                'aktual'     => isset($data['aktual']) ? trim($data['aktual']) : null,
                'tindakan'   => isset($data['tindakan']) ? trim($data['tindakan']) : null,
                'hasil'      => isset($data['hasil']) ? trim($data['hasil']) : null,
                'keterangan' => isset($data['keterangan']) ? trim($data['keterangan']) : null,
                'gambar'     => $image_name,
                'status'     => isset($data['status']) ? (int)$data['status'] : 1,
                'gambarPm'   => $image_name2,
                'catatan'    => isset($data['catatan']) ? trim($data['catatan']) : null,
            ];

            log_message('debug', 'Insert Data: ' . print_r($insertData, true));

            if (!$this->db->insert('trs_pengerjaan_checksheet', $insertData)) {
                log_message('error', 'Failed to insert data');
            }
        }

        $uniquePmmIds = array_unique(array_column($dataList, 'id_pmm'));

        if (!empty($uniquePmmIds)) {
            // Ambil data tanggal berdasarkan id_pmm
            $this->db->select('id_pmm, tanggal');
            $this->db->where_in('id_pmm', $uniquePmmIds);
            $query = $this->db->get('pm_monthly');
            $result = $query->result_array();

            $today = date('Y-m-d'); // Tanggal hari ini

            foreach ($result as $row) {
                $status = 5;
                $preparedBy = $this->session->userdata('user_id');
                $preparedDate = date('Y-m-d H:i:s');
                $this->db->where('id_pmm', $row['id_pmm']);
                $this->db->update('pm_monthly', [
                    'status' => $status,
                    'preparedBy' => $preparedBy,
                    'preparedDate' => $preparedDate
                ]);

                if ($this->db->affected_rows() > 0) {
                    log_message('debug', "Status pm_monthly updated for id_pmm: {$row['id_pmm']} to status: {$status}");
                } else {
                    log_message('error', "Failed to update pm_monthly status for id_pmm: {$row['id_pmm']}");
                }
            }
        }

        echo json_encode(['status' => 'success', 'message' => 'Data berhasil disimpan']);
    }

    public function insertPengerjaanRes($id_pmm2)
    {
        $dataList = $this->input->post('data');
        $user_id = $this->session->userdata('user_id');

        $upload_path = './uploads/pengerjaan/';
        if (!is_dir($upload_path)) {
            mkdir($upload_path, 0777, true);
        }

        $uniquePmmIds = array_unique(array_column($dataList, 'id_pmm'));

        foreach ($dataList as $index => $data) {
            $image_name = null;

            // Cek apakah ada file gambar yang dikirim
            if (!empty($_FILES["gambar_{$index}"]['name'])) {
                $file_ext = pathinfo($_FILES["gambar_{$index}"]['name'], PATHINFO_EXTENSION);
                $image_name = 'pengerjaan_' . time() . "_$index." . $file_ext; // Nama unik
                $target_file = $upload_path . $image_name;

                // Pindahkan file ke folder uploads
                if (!move_uploaded_file($_FILES["gambar_{$index}"]['tmp_name'], $target_file)) {
                    echo json_encode(['status' => 'error', 'message' => 'Gagal mengupload gambar']);
                    return;
                }
            }

            $image_name2 = null;

            // Cek apakah ada file gambar yang dikirim
            if (!empty($_FILES["gambarPm_{$index}"]['name'])) {
                $file_ext = pathinfo($_FILES["gambarPm_{$index}"]['name'], PATHINFO_EXTENSION);
                $image_name2 = 'pengerjaanPm_' . time() . "_$index." . $file_ext; // Nama unik
                $target_file = $upload_path . $image_name2;

                // Pindahkan file ke folder uploads
                if (!move_uploaded_file($_FILES["gambarPm_{$index}"]['tmp_name'], $target_file)) {
                    echo json_encode(['status' => 'error', 'message' => 'Gagal mengupload gambar']);
                    return;
                }
            }

            $insertData = [
                'id_users'   => isset($user_id) ? trim($user_id) : null,
                'id_pmm'     => isset($data['id_pmm']) ? (int)$data['id_pmm'] : null,
                'id_ck'      => isset($data['id_ck']) ? (int)$data['id_ck'] : null,
                'id_lini'    => isset($data['id_lini']) ? (int)$data['id_lini'] : null,
                'id_area'    => isset($data['id_area']) ? (int)$data['id_area'] : null,
                'id_mesin'   => isset($data['id_mesin']) ? (int)$data['id_mesin'] : null,
                'aktual'     => isset($data['aktual']) ? trim($data['aktual']) : null,
                'tindakan'   => isset($data['tindakan']) ? trim($data['tindakan']) : null,
                'hasil'      => isset($data['hasil']) ? trim($data['hasil']) : null,
                'keterangan' => isset($data['keterangan']) ? trim($data['keterangan']) : null,
                'gambar'     => $image_name,
                'status'     => isset($data['status']) ? (int)$data['status'] : 1,
                'gambarPm'   => $image_name2,
                'catatan'    => isset($data['catatan']) ? trim($data['catatan']) : null,

            ];

            log_message('debug', 'Insert Data: ' . print_r($insertData, true));

            if (!$this->db->insert('trs_pengerjaan_checksheet', $insertData)) {
                log_message('error', 'Failed to insert data');
            }
        }

        if (!empty($uniquePmmIds)) {
            // Ambil data tanggal berdasarkan id_pmm
            $this->db->select('id_pmm, tanggal');
            $this->db->where_in('id_pmm', $uniquePmmIds);
            $query = $this->db->get('pm_monthly');
            $result = $query->result_array();

            $today = date('Y-m-d'); // Tanggal hari ini

            foreach ($result as $row) {
                $status = 5;
                $preparedBy = $this->session->userdata('user_id');
                $preparedDate = date('Y-m-d H:i:s');
                $this->db->where('id_pmm', $row['id_pmm']);
                $this->db->update('pm_monthly', [
                    'status' => $status,
                    'preparedBy' => $preparedBy,
                    'preparedDate' => $preparedDate
                ]);

                if ($this->db->affected_rows() > 0) {
                    log_message('debug', "Status pm_monthly updated for id_pmm: {$row['id_pmm']} to status: {$status}");
                } else {
                    log_message('error', "Failed to update pm_monthly status for id_pmm: {$row['id_pmm']}");
                }
            }
        }

        echo json_encode(['status' => 'success', 'message' => 'Data berhasil disimpan']);
    }

    public function detailRes()
    {
        $id_mesin = $this->input->post('id_mesin');
        $tanggal = $this->input->post('tanggal');
        $id_pmm = $this->input->post('id_pmm');
        $pmBefore = $this->input->post('pmBefore');

        $update = $this->Pengerjaan_model->updateStatus($id_pmm);
        $singlechecksheet = $this->Pengerjaan_model->get_singlecheckseet($id_mesin);
        $checksheet = $this->Pengerjaan_model->get_checkseetres($pmBefore);
        $catatan = $this->Pengerjaan_model->get_catatan($pmBefore);
        $wi = $this->Pengerjaan_model->get_wi($id_mesin);
        $pmm = $this->Pengerjaan_model->get_diverifikasi($pmBefore);

        $data = [
            'singleChecksheet' => $singlechecksheet,
            'checksheet' => $checksheet,
            'catatan' => $catatan,
            'tanggal' => $tanggal,
            'wi' => $wi,
            'id_pmm' => $id_pmm,
            'pmm' => $pmm
        ];

        $this->load->view('pengerjaanRes', $data);
    }
}
