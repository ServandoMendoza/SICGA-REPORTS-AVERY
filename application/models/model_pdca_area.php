<?php
/**
 * Created by PhpStorm.
 * User: servandomendoza
 * Date: 4/17/15
 * Time: 10:26 AM
 */

class Model_pdca_area extends CI_Model{
    function __construct()
    {
        parent::__construct();
    }

    function getTotalScrapCostMonthlyByYear($year)
    {
        $sql = "SELECT MONTH(tran_date) AS month_date, sum(net_amt) AS net_amt
                FROM PDCA_Scrap
                WHERE YEAR(tran_date) = ?
                GROUP BY MONTH(tran_date)
                ORDER BY month_date";

        $query = $this->db->query($sql, array($year));
        return ($query->num_rows() > 0)? $query->result() : NULL;
    }

    function getTotalScrapCostWeeklyByYear($year)
    {
        $sql = "SELECT sum(net_amt) AS net_amt, WEEK(tran_date) AS week_date
                FROM PDCA_Scrap
                WHERE YEAR(tran_date) = 2015
                GROUP BY WEEK(tran_date)
                ORDER BY week_date;";

        $query = $this->db->query($sql, array($year));
        return ($query->num_rows() > 0)? $query->result() : NULL;
    }

    function getTotalSaScrapCostByMonthlyRange($year, $start_month, $end_month)
    {
        $sql = "SELECT sa.name, SUM(net_amt) AS net_amt
                FROM PDCA_Scrap s
                JOIN PDCA_Sub_Area sa ON (s.agc = sa.id)
                WHERE YEAR(s.tran_date) = ? AND (MONTH(tran_date) >= 1 AND MONTH(tran_date) <= 5) AND bu = 1
                GROUP BY agc
                ORDER BY net_amt DESC;";

        $query = $this->db->query($sql, array($year, $start_month, $end_month));
        return ($query->num_rows() > 0)? $query->result() : NULL;
    }
}