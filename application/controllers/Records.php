<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Records extends CI_Controller {
    public function index()
    {
        $this->load->database();
        $pageNum = ($this->input->get("page", 1) < 1) ? 1 : $this->input->get("page", 1);
        $this->db->limit(10, ($pageNum - 1) * 10);
        $query = $this->db->get("csv");
        $data['data'] = $query->result();
        $data['total'] = $this->db->count_all("csv");
        echo json_encode($data);
    }
}