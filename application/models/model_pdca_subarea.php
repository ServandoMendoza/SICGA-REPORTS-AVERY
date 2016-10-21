<?php
/**
 * Created by PhpStorm.
 * User: servandomendoza
 * Date: 4/17/15
 * Time: 2:16 AM
 */

class Model_pdca_subarea extends CI_Model{
    function __construct()
    {
        parent::__construct();
    }

    function getSubArea()
    {
        $sql = "SELECT * FROM PDCA_Sub_Area";

        $query = $this->db->query($sql, array());

        if($query->num_rows() > 0)
            return $query->row();
        else
            return NULL;
    }

    function getTotalScrapCostByMonthlyRange($year, $start_month, $end_month)
    {
        $sql = "SELECT sa.id, sa.name, SUM(net_amt) AS net_amt
                FROM PDCA_Scrap s
                JOIN PDCA_Sub_Area sa ON (s.agc = sa.id)
                WHERE YEAR(s.tran_date) = ? AND (MONTH(tran_date) >= ? AND MONTH(tran_date) <= ?) AND bu = 1
                GROUP BY agc
                ORDER BY net_amt DESC;";

        $query = $this->db->query($sql, array($year, $start_month, $end_month));
        return ($query->num_rows() > 0)? $query->result() : NULL;
    }

    function getMachineScrapByMonthlyRange($year, $start_month, $end_month)
    {
        $sql = "SELECT sa.id, sa.name, co, SUM(net_amt) AS net_amt
                FROM PDCA_Scrap s
                JOIN PDCA_Sub_Area sa ON (s.agc = sa.id)
                WHERE YEAR(s.tran_date) = ? AND (MONTH(tran_date) >= ? AND MONTH(tran_date) <= ?) AND bu = 1
                GROUP BY sa.id, co
                ORDER BY sa.id, net_amt DESC";

        $query = $this->db->query($sql, array($year, $start_month, $end_month));
        return ($query->num_rows() > 0)? $query->result() : NULL;
    }

    function getCodeScrapByMonthlyRange($data)
    {
        $sql = "SELECT sa.id, sa.name, sum(net_amt) as net_amt, s.reason
                FROM PDCA_Scrap s
                JOIN PDCA_Sub_Area sa ON (s.agc = sa.id)
                WHERE YEAR(s.tran_date) = ? AND (MONTH(tran_date) >= ? AND MONTH(tran_date) <= ?) AND bu = 1
                AND sa.id = ?
                GROUP BY sa.id, s.reason
                ORDER BY sa.id, net_amt DESC";

        $query = $this->db->query($sql, array($data['year'], $data['start_month'], $data['end_month'],
            $data['sa_id']));
        return ($query->num_rows() > 0)? $query->result() : NULL;
    }

    function getReasonScrapBySaAndMachine($data)
    {
        $sql = "SELECT sa.id, sa.name, co, SUM(net_amt) AS net_amt, reason
                FROM PDCA_Scrap s
                JOIN PDCA_Sub_Area sa ON (s.agc = sa.id)
                WHERE YEAR(tran_date) = ? AND (MONTH(tran_date) >= ? AND MONTH(tran_date) <= ?) AND bu = 1
                AND co = ? AND sa.id = ?
                GROUP BY reason";

        $query = $this->db->query($sql, array($data['year'], $data['start_month'], $data['end_month'],
            $data['co'], $data['sa_id']));

        return ($query->num_rows() > 0)? $query->result() : NULL;
    }
}