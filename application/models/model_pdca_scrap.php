<?php

class Model_pdca_scrap extends CI_Model{
    function __construct()
    {
        parent::__construct();
    }

    function insert_batch($data)
    {
        $this->db->trans_start();
        $this->db->insert_batch('PDCA_Scrap', $data);
        $this->db->trans_complete();

        return true;
    }

    function get_machines(){
        $sql = "SELECT DISTINCT(co) AS co, agc FROM PDCA_Scrap WHERE bu = 1";

        $query = $this->db->query($sql, array());
        return ($query->num_rows() > 0)? $query->result_array() : NULL;
    }
}