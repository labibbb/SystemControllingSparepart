<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Wi extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('Wi_model');
        $this->load->library('session');
        $this->check_session_timeout();
    }

    private function check_session_timeout() {
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

    public function index() {
        $data['wi'] = $this->Wi_model->get_all_wi();
        $this->load->view('wi', $data);
    }

    public function add() {
        $upload_path = './uploads/wi_files/';
        if (!is_dir($upload_path)) {
            mkdir($upload_path, 0777, true);
        }

        // Konfigurasi upload untuk file Excel
        $config['upload_path']   = $upload_path;
        $config['allowed_types'] = 'xls|xlsx|pdf'; // Hanya menerima file Excel
        $config['max_size']      = 10240; // 10 MB
        $config['overwrite']     = FALSE; // Jangan menimpa file dengan nama yang sama

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('file_wi')) {
            echo json_encode([
                'status'  => 'error',
                'message' => $this->upload->display_errors()
            ]);
        } else {
            $upload_data = $this->upload->data();
            $data = [
                'nama_wi'    => $this->input->post('nama_wi'),
                'nama_file'  => $upload_data['file_name'],
                'ukuran_file'=> $upload_data['file_size'],
                'id_users'   => $this->session->userdata('user_id'),
                'status'     => 1
            ];

            if ($this->Wi_model->insert_wi($data)) {
                echo json_encode(['status' => 'success', 'message' => 'File Excel berhasil diunggah']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Gagal menyimpan ke database']);
            }
        }
    }
}
?>
