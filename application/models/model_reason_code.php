<?php

class Model_reason_code extends CI_Model{
    function __construct()
    {
        parent::__construct();
    }

    function insert($data)
    {
        $this->db->trans_start();
        $this->db->insert('PDCA_Reason_Code', $data);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();

        return $insert_id;
    }
}