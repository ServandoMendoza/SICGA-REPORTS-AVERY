<?php
/**
 * Created by PhpStorm.
 * User: servandomac
 * Date: 3/15/15
 * Time: 2:58 PM
 */

class Model_production_model extends CI_Model{
    function __construct()
    {
        parent::__construct();
    }

    function getTotalProdMachineByYearWeekRange($machine_id, $year_week_s, $year_week_e)
    {
        $sql = "SELECT sum(program_time) as total_time, id, COUNT(*) AS records
                FROM SICGA_Production_Model
                WHERE machine_id = ? AND YEARWEEK(DATE(create_date), 1) >= ?
                AND YEARWEEK(DATE(create_date), 1) <= ?";

        $query = $this->db->query($sql, array($machine_id, $year_week_s,$year_week_e));

        if($query->num_rows() > 0)
            return $query->row();
        else
            return NULL;
    }

    function getTotalProdMachineDtByYearWeekRange($machine_id, $year_week_s, $year_week_e)
    {
        $sql = "SELECT sum(pdt.dead_time) as total_time
                FROM SICGA_Production_Model pm
                JOIN SICGA_Production_Dead_Time pdt ON (pdt.production_model_id = pm.id)
                WHERE pm.machine_id = $machine_id AND
                YEARWEEK(DATE(pm.create_date), 1) >= ? AND YEARWEEK(DATE(pm.create_date), 1) <= ?";

        $query = $this->db->query($sql, array($year_week_s, $year_week_e));

        if($query->num_rows() > 0)
            return $query->row();
        else
            return NULL;
    }

    function getTotalProductionByYearWeek($year_week, $machines)
    {
        $sql = "SELECT sum(program_time) as total_time
                FROM SICGA_Production_Model
                WHERE
                machine_id IN ($machines) AND
                YEARWEEK(DATE(create_date), 1) = ?";

        $query = $this->db->query($sql, array($year_week));

        if($query->num_rows() > 0)
            return $query->row();
        else
            return NULL;
    }

    function getTotalProductionDtByYearWeek($year_week, $machines)
    {
        $sql = "SELECT sum(pdt.dead_time) as total_time
                FROM SICGA_Production_Model pm
                JOIN SICGA_Production_Dead_Time pdt ON (pdt.production_model_id = pm.id)
                WHERE
                pm.machine_id IN ($machines) AND
                YEARWEEK(DATE(pm.create_date), 1) = ?";

        $query = $this->db->query($sql, array($year_week));

        if($query->num_rows() > 0)
            return $query->row();
        else
            return NULL;
    }

    function getYTDSubAreaGroupDT($machines, $year_week_s, $year_week_e)
    {
        $sql = "SELECT sum(pdt.dead_time) as total_time, dcg.name, pm.machine_id, pdt.id as prod_dt_id, dcg.id as dcg_id
                FROM SICGA_Production_Model pm
                JOIN SICGA_Production_Dead_Time pdt ON (pdt.production_model_id = pm.id)
                JOIN SICGA_Death_Code dc ON (pdt.death_code_id = dc.id)
                JOIN SICGA_Death_Code_Group dcg ON (dc.death_code_group_id = dcg.id)
                WHERE pm.machine_id IN ($machines) AND
                YEARWEEK(DATE(pm.create_date), 1) >= ? AND YEARWEEK(DATE(pm.create_date), 1) <= ?
                GROUP BY dcg.id
                ORDER BY total_time desc;";

        $query = $this->db->query($sql, array($year_week_s,$year_week_e));

        if($query->num_rows() > 0)
            return $query->result();
        else
            return NULL;
    }

    function getYTDMachineGroupDT($machine_id, $year_week_s, $year_week_e)
    {
        $sql = "SELECT sum(pdt.dead_time) as total_time, dcg.name, pm.machine_id, pdt.id as prod_dt_id, dcg.id as dcg_id
                FROM SICGA_Production_Model pm
                JOIN SICGA_Production_Dead_Time pdt ON (pdt.production_model_id = pm.id)
                JOIN SICGA_Death_Code dc ON (pdt.death_code_id = dc.id)
                JOIN SICGA_Death_Code_Group dcg ON (dc.death_code_group_id = dcg.id)
                WHERE pm.machine_id = ? AND
                YEARWEEK(DATE(pm.create_date), 1) >= ? AND YEARWEEK(DATE(pm.create_date), 1) <= ?
                GROUP BY dcg.id
                ORDER BY total_time desc;";

        $query = $this->db->query($sql, array($machine_id, $year_week_s,$year_week_e));

        if($query->num_rows() > 0)
            return $query->result();
        else
            return NULL;
    }

    function getYTDMachineDtGroupDts($machine_id, $dcg_id, $year_week_s, $year_week_e)
    {
        $sql = "SELECT dc.description, pm.machine_id, pdt.id as prod_dt_id, sum(pdt.dead_time) as dead_time, dc.id
                FROM SICGA_Production_Model pm
                JOIN SICGA_Production_Dead_Time pdt ON (pdt.production_model_id = pm.id)
                JOIN SICGA_Death_Code dc ON (pdt.death_code_id = dc.id)
                JOIN SICGA_Death_Code_Group dcg ON (dc.death_code_group_id = dcg.id)
                WHERE  pm.machine_id = ? AND dcg.id = ? AND
                YEARWEEK(DATE(pm.create_date), 1) >= ? AND YEARWEEK(DATE(pm.create_date), 1) <= ?
                GROUP BY dc.id
                ORDER BY dead_time desc;";

        $query = $this->db->query($sql, array($machine_id, $dcg_id, $year_week_s,$year_week_e));

        if($query->num_rows() > 0)
            return $query->result();
        else
            return NULL;
    }



}