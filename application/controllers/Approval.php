<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Approval extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Approval_model');
        $this->load->library('session');
        $this->load->library('pdf');
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

    public function monitoringPlan()
    {
        // Ambil data sesuai filter awal
        $pmmonthly = $this->Approval_model->get_all_pmmonthly_planaktual();

        $data = [
            'pmmonthly' => $pmmonthly
        ];

        $this->load->view('actualPlanView', $data);
    }

    public function monitoringPlan2()
    {
        // Ambil data sesuai filter awal
        $pmmonthly = $this->Approval_model->get_all_pmmonthly_planaktual2();

        $data = [
            'pmmonthly' => $pmmonthly
        ];

        $this->load->view('actualPlanViews', $data);
    }

    public function monitoring()
    {
        // Ambil data sesuai filter awal
        $pmmonthly = $this->Approval_model->get_all_pmmonthly_monitoring();

        $data = [
            'pmmonthly' => $pmmonthly
        ];

        $this->load->view('monitoringApproval', $data);
    }

    public function monitorings()
    {
        // Ambil data sesuai filter awal
        $pmmonthly = $this->Approval_model->get_all_pmmonthly_monitoring();

        $data = [
            'pmmonthly' => $pmmonthly
        ];

        $this->load->view('monitoringSchedule', $data);
    }

    public function index()
    {
        // Ambil data sesuai filter awal
        $pmmonthly = $this->Approval_model->get_all_pmmonthly();
        $lini = $this->Approval_model->get_lini();

        $data = [
            'pmmonthly' => $pmmonthly,
            'lini' => $lini
        ];

        $this->load->view('approvalFRView', $data);
    }

    public function index2()
    {
        // Ambil data sesuai filter awal
        $pmmonthly = $this->Approval_model->get_all_pmmonthly2();
        $lini = $this->Approval_model->get_lini();

        $data = [
            'pmmonthly' => $pmmonthly,
            'lini' => $lini
        ];

        $this->load->view('approvalSPVView', $data);
    }

    public function detail2()
    {
        $id_mesin = $this->input->post('id_mesin');
        $tanggal = $this->input->post('tanggal');
        $id_pmm = $this->input->post('id_pmm');

        $singlechecksheet = $this->Approval_model->get_singlecheckseet($id_mesin);
        $checksheet = $this->Approval_model->get_checkseet($id_pmm);
        $wi = $this->Approval_model->get_wi($id_mesin);
        $gambarPm = $this->Approval_model->get_gambarPm($id_pmm);
        $pmm = $this->Approval_model->get_diverifikasi($id_pmm);

        $data = [
            'singleChecksheet' => $singlechecksheet,
            'checksheet' => $checksheet,
            'tanggal' => $tanggal,
            'wi' => $wi,
            'id_pmm' => $id_pmm,
            'pmm' => $pmm,
            'gambarPm' => $gambarPm['gambarPm'] ?? null
        ];

        $this->load->view('approvalSPVDetail', $data);
    }

    public function detail3()
    {
        $id_mesin = $this->input->post('id_mesin');
        $tanggal = $this->input->post('tanggal');
        $id_pmm = $this->input->post('id_pmm');

        $singlechecksheet = $this->Approval_model->get_singlecheckseet($id_mesin);
        $catatan = $this->Approval_model->get_catatan($id_pmm);
        $checksheet = $this->Approval_model->get_checkseet($id_pmm);
        $wi = $this->Approval_model->get_wi($id_mesin);
        $pmm = $this->Approval_model->get_diverifikasi($id_pmm);
        $gambarPm = $this->Approval_model->get_gambarPm($id_pmm);

        $data = [
            'singleChecksheet' => $singlechecksheet,
            'catatan' => $catatan,
            'checksheet' => $checksheet,
            'tanggal' => $tanggal,
            'wi' => $wi,
            'id_pmm' => $id_pmm,
            'pmm' => $pmm,
            'gambarPm' => $gambarPm['gambarPm'] ?? null
        ];

        $this->load->view('approvalSPVRead', $data);
    }

    public function detail4()
    {
        $id_mesin = $this->input->post('id_mesin');
        $tanggal = $this->input->post('tanggal');
        $id_pmm = $this->input->post('id_pmm');

        $singlechecksheet = $this->Approval_model->get_singlecheckseet($id_mesin);
        $catatan = $this->Approval_model->get_catatan($id_pmm);
        $checksheet = $this->Approval_model->get_checkseet($id_pmm);
        $wi = $this->Approval_model->get_wi($id_mesin);
        $pmm = $this->Approval_model->get_diverifikasi($id_pmm);
        $gambarPm = $this->Approval_model->get_gambarPm($id_pmm);

        $data = [
            'singleChecksheet' => $singlechecksheet,
            'catatan' => $catatan,
            'checksheet' => $checksheet,
            'tanggal' => $tanggal,
            'wi' => $wi,
            'id_pmm' => $id_pmm,
            'pmm' => $pmm,
            'gambarPm' => $gambarPm['gambarPm'] ?? null
        ];

        $this->load->view('approvalFRRead', $data);
    }

    public function detail()
    {
        $id_mesin = $this->input->post('id_mesin');
        $tanggal = $this->input->post('tanggal');
        $id_pmm = $this->input->post('id_pmm');

        $singlechecksheet = $this->Approval_model->get_singlecheckseet($id_mesin);
        $checksheet = $this->Approval_model->get_checkseet($id_pmm);
        $wi = $this->Approval_model->get_wi($id_mesin);
        $pmm = $this->Approval_model->get_diverifikasi($id_pmm);
        $gambarPm = $this->Approval_model->get_gambarPm($id_pmm);
        $catatan = $this->Approval_model->get_catatancs($id_pmm);

        $data = [
            'singleChecksheet' => $singlechecksheet,
            'checksheet' => $checksheet,
            'tanggal' => $tanggal,
            'wi' => $wi,
            'id_pmm' => $id_pmm,
            'pmm' => $pmm,
            'gambarPm' => $gambarPm['gambarPm'] ?? null,
            'catatan' => $catatan['catatan'] ?? null
        ];

        $this->load->view('approvalFRDetail', $data);
    }

    public function approveFr($id_pmm)
    {
        $user_id = $this->session->userdata('user_id');

        if (empty($id_pmm)) {
            echo json_encode(['status' => 'error', 'message' => 'ID PMM tidak boleh kosong']);
            return;
        }

        $update = $this->Approval_model->approveFr($id_pmm, $user_id);

        if ($update) {
            echo json_encode(['status' => 'success', 'message' => 'Data berhasil disimpan']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Gagal menyimpan data']);
        }
    }

    public function rejectFr($id_pmm)
    {
        $user_id = $this->session->userdata('user_id');
        $catatan = $this->input->post('catatan'); // Ambil catatan dari POST request

        // Validasi ID PMM tidak boleh kosong
        if (empty($id_pmm)) {
            echo json_encode(['status' => 'error', 'message' => 'ID PMM tidak boleh kosong']);
            return;
        }

        // Validasi catatan tidak boleh kosong
        if (empty($catatan)) {
            echo json_encode(['status' => 'error', 'message' => 'Catatan tidak boleh kosong']);
            return;
        }

        // Update status dan catatan di model
        $update = $this->Approval_model->rejectFr($id_pmm, $user_id, $catatan);

        if ($update) {
            echo json_encode(['status' => 'success', 'message' => 'Data berhasil disimpan']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Gagal menyimpan data']);
        }
    }

    public function approveSpv($id_pmm)
    {
        $user_id = $this->session->userdata('user_id');

        if (empty($id_pmm)) {
            echo json_encode(['status' => 'error', 'message' => 'ID PMM tidak boleh kosong']);
            return;
        }

        $update = $this->Approval_model->approveSpv($id_pmm, $user_id);

        if ($update) {
            echo json_encode(['status' => 'success', 'message' => 'Data berhasil disimpan']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Gagal menyimpan data']);
        }
    }


    public function rejectSpv($id_pmm)
    {
        $user_id = $this->session->userdata('user_id');
        $catatan = $this->input->post('catatan'); // Ambil catatan dari POST request

        // Validasi ID PMM tidak boleh kosong
        if (empty($id_pmm)) {
            echo json_encode(['status' => 'error', 'message' => 'ID PMM tidak boleh kosong']);
            return;
        }

        // Validasi catatan tidak boleh kosong
        if (empty($catatan)) {
            echo json_encode(['status' => 'error', 'message' => 'Catatan tidak boleh kosong']);
            return;
        }

        // Update status dan catatan di model
        $update = $this->Approval_model->rejectSpv($id_pmm, $user_id, $catatan);

        if ($update) {
            echo json_encode(['status' => 'success', 'message' => 'Data berhasil disimpan']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Gagal menyimpan data']);
        }
    }

    public function exportPdf()
    {
        $id_mesin = $this->input->post('id_mesin');
        $id_pmm = $this->input->post('id_pmm');

        $singlechecksheet = $this->Approval_model->get_singlecheckseet($id_mesin);
        $checksheet = $this->Approval_model->get_checkseet($id_pmm);
        $wi = $this->Approval_model->get_wi($id_mesin);
        $pmm = $this->Approval_model->get_diverifikasi($id_pmm);

        $this->load->library('pdf');
        $tanggal = $this->input->post('tanggal_doc') ?? $singlechecksheet['tanggal_doc'] ?? date('Y-m-d');

        // Menentukan ukuran halaman A2 landscape
        $pdf = new Pdf(array(594, 420), 'mm', '', true, 'UTF-8', false); // A2 landscape

        // Menambahkan halaman dengan ukuran yang telah ditentukan
        $pdf->AddPage('L', array(594, 420)); // A2 landscape

        $logoPath = FCPATH . './uploads/logo.jpg'; // Ganti dengan path sesuai gambar Anda
        $pdf->Image($logoPath, 10, 20, 60, 30);

        // Header judul
        $pdf->SetFont('helvetica', 'B', 20);
        $pdf->Cell(0, 10, $singlechecksheet['nama_doc'], 0, 1, 'C');

        // =====================
        // Kolom Kiri (Informasi Detail)
        // =====================
        $pdf->SetFont('helvetica', '', 12);

        // Koordinat kiri atas
        // Set posisi awal (misal lebih turun ke bawah)
        $pdf->SetXY(10, 60);
        $pdf->setCellPadding(2);
        // Lebar kolom
        $labelWidth = 35;
        $dataWidth = 80;
        $cellHeight = 6;

        // Data tabel
        $rows = [
            ['No Form', ': ' . $singlechecksheet['no_doc']],
            ['Pemilik Doc', ': MAINTENANCE DEPT'],
            ['No Doc', ': ' . $singlechecksheet['no_doc']],
            ['Lini', ': ' . $singlechecksheet['nama_lini']],
            ['Area', ': ' . $singlechecksheet['nama_area']],
            ['Mesin', ': ' . $singlechecksheet['nama_mesin']],
        ];

        // Loop untuk buat tabel
        foreach ($rows as $row) {
            $pdf->SetX(10);
            $pdf->Cell($labelWidth, $cellHeight, $row[0], 1, 0); // Kolom label
            $pdf->Cell($dataWidth, $cellHeight, $row[1], 1, 1);   // Kolom data
        }

        // =====================
        // Kolom Kanan (Tabel Verifikasi)
        // =====================
        // Atur koordinat pojok kanan atas manual (misal di pojok kanan halaman)
        $pdf->SetXY(464, 37); // Ubah posisi sesuai kebutuhan layout

        $pdf->SetFont('', 'B');
        $pdf->SetFont('dejavusans', '', 10);
        $pdf->Cell(120, 7, 'Diverifikasi oleh System', 1, 1, 'C');

        $pdf->SetXY(464, 44);
        $pdf->Cell(40, 7, 'Prepared By', 1, 0, 'C');
        $pdf->Cell(40, 7, 'Checked By', 1, 0, 'C');
        $pdf->Cell(40, 7, 'Approved By', 1, 1, 'C');

        $pdf->SetFont('', '');
        $pdf->SetXY(464, 51);
        $pdf->Cell(40, 21, $pmm['prepared'], 1, 0, 'C');
        $pdf->Cell(40, 21, $pmm['checked'], 1, 0, 'C');
        $pdf->Cell(40, 21, $pmm['approve'], 1, 1, 'C');

        $pdf->SetXY(464, 72);
        $pdf->Cell(40, 7, !empty($pmm['preparedDate']) ? date('d/m/Y H:i', strtotime($pmm['preparedDate'])) : '', 1, 0, 'C'); 
        $pdf->Cell(40, 7, !empty($pmm['checkedDate']) ? date('d/m/Y H:i', strtotime($pmm['checkedDate'])) : '', 1, 0, 'C');
        $pdf->Cell(40, 7, !empty($pmm['approveDate']) ? date('d/m/Y H:i', strtotime($pmm['approveDate'])) : '', 1, 1, 'C');

                // Menjadi:
        $pdf->SetXY(464, 100);
        // Perbesar tinggi sel menjadi 10mm (bukan 7mm) dan lebarnya disesuaikan
        $pdf->Cell(80, 10, 'Tanggal Pembuatan Checksheet', 1, 0, 'C');
        $pdf->Cell(40, 10, date('d/m/Y', strtotime($tanggal)), 1, 0, 'C');
        $pdf->Ln(30);
        // Buat tabelm
        $tbl = '
<style>
    table, th, td {
        border: 1px solid #000;
    }
</style>
<table cellspacing="0" cellpadding="3">
    <tr>
        <th rowspan="2" width="10mm" valign="middle" align="center">No</th>
        <th rowspan="2" width="50mm" valign="middle" align="center">Item Check</th>
        <th rowspan="2" width="80mm" style="text-align: center; vertical-align: middle;">Point Check</th>
        <th rowspan="2" width="50mm" style="text-align: center; vertical-align: middle;">Metode</th>
        <th rowspan="2" width="70mm" style="text-align: center; vertical-align: middle;">Standard</th>
        <th colspan="2" width="50mm" style="text-align: center; vertical-align: middle;">Aktual</th>
        <th colspan="4" width="50mm" style="text-align: center; vertical-align: middle;">Tindakan</th>
        <th colspan="3" width="50mm" style="text-align: center; vertical-align: middle;">Hasil</th>
        <th rowspan="2" width="165mm" style="text-align: center; vertical-align: middle;">Keterangan</th>
    </tr>
    <tr>
        <th style="text-align: center; vertical-align: middle;">OK</th><th style="text-align: center; vertical-align: middle;">NG</th>
        <th style="text-align: center; vertical-align: middle;">1</th><th style="text-align: center; vertical-align: middle;">2</th><th style="text-align: center; vertical-align: middle;">3</th><th style="text-align: center; vertical-align: middle;">4</th>
        <th style="text-align: center; vertical-align: middle;">v</th><th style="text-align: center; vertical-align: middle;">△</th><th style="text-align: center; vertical-align: middle;">×</th>
    </tr>';

        // Dummy data
        $data = [];
        $i = 1;
        foreach ($checksheet as $row) {
            $aktual = strtolower($row['aktual']);

           // Tindakan - kosongkan jika OK
    $tindakan_array = ['', '', '', ''];
    if ($aktual === 'ng' && isset($row['tindakan']) && is_numeric($row['tindakan'])) {
        $index = (int)$row['tindakan'] - 1;
        if ($index >= 0 && $index < 4) {
            $tindakan_array[$index] = 'v';
        }
    }

    // Hasil - hanya isi jika NG
    $hasil_array = ['', '', ''];
    if ($aktual === 'ng') {
        if (isset($row['hasil'])) {
            switch (strtoupper($row['hasil'])) {
                case '1':
                    $hasil_array[0] = 'v ';
                    break;
                case '2':
                    $hasil_array[1] = '△';
                    break;
                case '3':
                    $hasil_array[2] = '×';
                    break;
            }
        }
    }
            $data[] = [
                'no' => $i,
                'item_check' => $row['item_cek'],
                'point_check' => $row['point_cek'],
                'metode' => $row['metode_cek'],
                'standard' => $row['standard'],
                'aktual_ok' => $aktual === 'ok' ? 'OK' : '',
                'aktual_ng' => $aktual === 'ng' ? 'NG' : '',
                'tindakan' => $tindakan_array,
                'hasil' => $hasil_array, // Hasil disesuaikan dengan logika tindakan
                'keterangan' => isset($row['keterangan']) ? $row['keterangan'] : '',
                'catatan' => isset($row['catatan']) ? $row['catatan'] : ''

            ];
            $i++;
        }

        // Grouping untuk rowspan
        $lastItemCheck = '';
        $rowspanCount = 0;
        $itemCheckIndex = 0;

        // Hitung rowspan
        foreach ($data as $i => $row) {
            if ($row['item_check'] !== $lastItemCheck) {
                $lastItemCheck = $row['item_check'];
                $rowspanCount = 1;
                $itemCheckIndex = $i;
            } else {
                $rowspanCount++;
            }
            $data[$itemCheckIndex]['rowspan'] = $rowspanCount;
            $data[$i]['show_item_check'] = ($i === $itemCheckIndex);
        }

        // Render table rows
        foreach ($data as $i => $row) {
            $tbl .= '<tr>';
            $tbl .= '<td style="text-align: center; vertical-align: middle;">' . $row['no'] . '</td>';

            // Merge "Item Check" jika perlu
            if ($row['show_item_check']) {
                $tbl .= '<td rowspan="' . $row['rowspan'] . '" style="text-align: center; vertical-align: middle;">' . $row['item_check'] . '</td>';
            }

            $tbl .= '
        <td style="text-align: center; vertical-align: middle;">' . $row['point_check'] . '</td>
        <td style="text-align: center; vertical-align: middle;">' . $row['metode'] . '</td>
        <td style="text-align: center; vertical-align: middle;">' . $row['standard'] . '</td>
        <td style="text-align: center; vertical-align: middle;">' . $row['aktual_ok'] . '</td>
        <td style="text-align: center; vertical-align: middle;">' . $row['aktual_ng'] . '</td>
        <td style="text-align: center; vertical-align: middle;">' . $row['tindakan'][0] . '</td>
        <td style="text-align: center; vertical-align: middle;">' . $row['tindakan'][1] . '</td>
        <td style="text-align: center; vertical-align: middle;">' . $row['tindakan'][2] . '</td>
        <td style="text-align: center; vertical-align: middle;">' . $row['tindakan'][3] . '</td>
        <td style="text-align: center; vertical-align: middle;">' . $row['hasil'][0] . '</td>
        <td style="text-align: center; vertical-align: middle;">' . $row['hasil'][1] . '</td>
        <td style="text-align: center; vertical-align: middle;">' . $row['hasil'][2] . '</td>
        <td style="text-align: center; vertical-align: middle;">' . $row['keterangan'] . '</td>
    ';
            $tbl .= '</tr>';
        }

        $tbl .= '</table>';
        $tbl .= '
        <table cellspacing="0" cellpadding="4" style="border:1px solid #000;" width="180mm">
            <tr>
                <td width="140mm" style="border-right:1px solid #000;">
                    <b>TINDAKAN :</b><br>
                    1 : Dibersihkan/Dirapikan/Pelumasan<br>
                    2 : Disetting/Disencangkan<br>
                    3 : Direpair<br>
                    4 : Diganti
                </td>
                <td width="50mm" style="border-right:1px solid #000;">
                    <b>HASIL :</b><br>
                    v : OK & Mesin Jalan<br>
                    △ : Abnormal<br>
                    × : Mesin Stop
                </td>
                <td width="70mm">
            <b>CATATAN:</b> ' . $row['catatan'] . '
        </td>
            </tr>
        </table>';

        $pdf->writeHTML($tbl, true, false, false, false, '');

        // Output PDF
        $pdf->Output('checksheet.pdf', 'I');
    }
}
