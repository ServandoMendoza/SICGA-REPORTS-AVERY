<?php
/**
 * Created by PhpStorm.
 * User: servandomac
 * Date: 3/12/15
 * Time: 5:55 PM
 */

class Model_area extends CI_Model{
    function __construct()
    {
        parent::__construct();
    }

    function getAreas()
    {
        $sql = "SELECT * FROM SICGA_Area";

        $query = $this->db->query($sql, array());

        if($query->num_rows() > 0)
            return $query->result();
        else
            return NULL;
    }

    function getAreaById($id_area)
    {
        $sql = "SELECT * FROM SICGA_Area where id = ?";

        $query = $this->db->query($sql, array($id_area));

        if($query->num_rows() > 0)
            return $query->row();
        else
            return NULL;
    }

    function getAreaScrap()
    {
        $sql = "SELECT * FROM PDCA_Scrap";

        $query = $this->db->query($sql, array());

        if($query->num_rows() > 0)
            return $query->row();
        else
            return NULL;
    }

    function getSubAreaById($id_area)
    {
        $sql = "SELECT * FROM SICGA_Sub_Area where id = ?";

        $query = $this->db->query($sql, array($id_area));

        if($query->num_rows() > 0)
            return $query->row();
        else
            return NULL;
    }

    function getSubAreaByAreaId($id_area)
    {
        $sql = "SELECT * FROM SICGA_Sub_Area where id_area = ?";

        $query = $this->db->query($sql, array($id_area));

        if($query->num_rows() > 0)
            return $query->result();
        else
            return NULL;
    }

}