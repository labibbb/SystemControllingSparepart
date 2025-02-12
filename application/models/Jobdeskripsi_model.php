<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Jobdeskripsi_Model extends CI_Model {
    
    public function get_all_jobdeskripsi() {
        return $this->db->get('job_deskripsi')->result_array();
    }    

    public function insert_jobdeskripsi($data) {
        return $this->db->insert('job_deskripsi', $data);
    }

    public function get_jobdeskripsi_by_id($id) {
        return $this->db->get_where('job_deskripsi', ['id_job' => $id])->row_array();
    }

    public function update_jobdeskripsi($id, $data) {
        $this->db->where('id_job', $id);
        return $this->db->update('job_deskripsi', $data);
    }

    public function delete_jobdeskripsi($id) {
        $this->db->where('id_job', $id);
        return $this->db->update('job_deskripsi', ['status' => 0]); // Soft delete
    }
}
?>
