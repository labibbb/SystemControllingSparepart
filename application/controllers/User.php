<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('User_model'); // Ganti Users_Model menjadi User_model
    }
    
    public function index() {
        $data['users'] = $this->User_model->get_all_users();
        $this->load->view('user', $data);
    }

    public function add() {
        date_default_timezone_set('Asia/Jakarta');

        $data = [
            'username' => $this->input->post('username'),
            'password' => password_hash($this->input->post('password'), PASSWORD_BCRYPT),
            'dipname'  => $this->input->post('dipname'),
            'level'    => $this->input->post('level'),
            'role'     => $this->input->post('role'),
            'plant'    => $this->input->post('plant'),
            'status' => 1,
            'active' => 1,
            'sysdate'  => date('Y-m-d H:i:s')
        ];
        $this->User_model->insert_user($data);
        echo json_encode(['status' => 'success']);
    }

    public function edit($id) {
        $user = $this->User_model->get_user_by_id($id);
        echo json_encode($user);
    }

    public function update() {
        $id = $this->input->post('id_users');
        date_default_timezone_set('Asia/Jakarta');

        $data = [
            'username' => $this->input->post('username'),
            'dipname'  => $this->input->post('dipname'),
            'level'    => $this->input->post('level'),
            'role'     => $this->input->post('role'),
            'plant'    => $this->input->post('plant'),
            'status' => 1,
            'active' => 1,
            'sysdate'  => date('Y-m-d H:i:s')
        ];
        
        if ($this->input->post('password')) {
            $data['password'] = password_hash($this->input->post('password'), PASSWORD_BCRYPT);
        }
        
        $this->User_model->update_user($id, $data); // Perbaiki dari User_Model ke User_model
        echo json_encode(['status' => 'success']);
    }

    public function delete($id) {
        if ($id) {
            $this->User_model->delete_user($id);
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'ID tidak valid']);
        }
    }
}
?>
