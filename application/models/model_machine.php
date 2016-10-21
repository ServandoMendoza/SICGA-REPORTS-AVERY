<?php
/**
 * Created by PhpStorm.
 * User: servandomac
 * Date: 3/15/15
 * Time: 2:48 PM
 */

class Model_machine extends CI_Model{
    function __construct()
    {
        parent::__construct();
    }

    function getSubAreaMachines($id_sub_area)
    {
        $sql = "SELECT cm.id_machine, m.name
                FROM SICGA_Sub_Area sa
                JOIN SICGA_Cell c ON (sa.id = c.id_sub_area)
                JOIN SICGA_Cell_Machine cm ON (cm.id_cell = c.id)
                JOIN SICGA_Machine m ON(cm.id_machine = m.id)
                WHERE sa.id = ?";

        $query = $this->db->query($sql, array($id_sub_area));

        if($query->num_rows() > 0)
            return $query->result();
        else
            return NULL;
    }

    function getAreaMachines($id_area)
    {
        $sql = "SELECT cm.id_machine
                FROM SICGA_Area a
                JOIN SICGA_Sub_Area sa ON(sa.id_area = a.id)
                JOIN SICGA_Cell c ON (sa.id = c.id_sub_area)
                JOIN SICGA_Cell_Machine cm ON (cm.id_cell = c.id)
                WHERE a.id = ?";

        $query = $this->db->query($sql, array($id_area));

        if($query->num_rows() > 0)
            return $query->result();
        else
            return NULL;
    }

}