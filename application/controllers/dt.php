<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Class Controller Dt (Dead Time)
 *
 * This controller get data feeded by Main Avery Prod Line Application,
 * to report DT PDCA Graph Reports.
 *
 */

class Dt extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->library('utilities');
        $this->load->library('layout');
        $this->load->helper('cookie');
        $this->load->model('model_area');
        $this->load->model('model_production_model');
        $this->load->model('model_machine');
    }

    /**
     * Main page to build Dead Time report.
     */
    public function index()
    {
        $this->layout->title('Avery - Report Tool');
        $data['areas'] = $this->model_area->getAreas();

        $this->form_validation->set_rules('id_area','id_area','required|trim');
        $this->form_validation->set_rules('id_sub_area','id_sub_area','required|trim');

        if($this->form_validation->run() != FALSE)
        {
            $id_area = $this->input->post('id_area');
            $id_sub_area = $this->input->post('id_sub_area');
            redirect(base_url().'dt/build/'.$id_area.'/'.$id_sub_area);
        }

        $this->layout->view('dt/index_view',$data);
    }

    /**
     * Report View of build params
     */
    public function build()
    {
        $this->layout->title('Avery - Report Tool');

        $data['id_area'] = $this->uri->segment(3);
        $data['id_subarea'] = $this->uri->segment(4);
        $data['date_now'] = date("Y-m-d");

        $this->layout->view('dt/build_view', $data);
    }

    /**
     * Post graph report, this process all report data.
     */
    public function graphReport()
    {
        $this->layout->title('Avery - DT Graph Report');

        $data['id_area'] = $this->input->post('id_area');
        $data['id_subarea'] = $this->input->post('id_subarea');
        $data['metric'] = $this->input->post('metric');
        $data['week'] = $this->input->post('week');
        $data['date'] = $this->input->post('date');
        $data['business'] = $this->input->post('business');
        $data['metric_goal'] = $this->input->post('metric_goal');
        $data['actual'] = $this->input->post('actual');
        $data['ytd'] = $this->input->post('ytd');
        $data['members'] = $this->input->post('members');
        $data['problem_def'] = $this->input->post('problem_def');
        $data['study_reach'] = $this->input->post('study_reach');

        $exploded_date = explode("-",$data['date']);
        $year = $exploded_date[0];
        $initial_week = ($data['week'] >= 6) ? $data['week'] - 6 : 0;

        $first_week_year = ($initial_week + 1 < 10) ? $year.'0'.($initial_week+1) : $year.($initial_week+1) ;
        $last_week_year = ($data['week'] + 1 < 10)? $year.'0'.$data['week'] : $year.$data['week'];

        $data['area'] = $this->model_area->getAreaById($data['id_area']);
        $data['sub_area'] = $this->model_area->getSubAreaById($data['id_subarea']);

        $a_machines = $this->model_machine->getAreaMachines($data['id_area']);
        $a_machineids = '';
        $sa_machineids = '';

        if(!empty($a_machines) && count($a_machines)) {
            foreach ($a_machines as $machine) {
                $a_machineids .= $machine->id_machine . ',';
            }

            $a_machineids = rtrim($a_machineids, ",");
            $sa_machines = $this->model_machine->getSubAreaMachines($data['id_subarea']);


            foreach ($sa_machines as $machine) {
                $sa_machineids .= $machine->id_machine . ',';
            }

            $sa_machineids = rtrim($sa_machineids, ",");
        }


        /***
         * Paso 1. Verificación de la Tendencia del Métrico.
         */

        // Start to break down by week (total del area)
        $total_area_time = array();

        if(!empty($a_machineids)) {
            for ($i = ($initial_week + 1); $i <= $data['week']; $i++) {
                if ($i < 10)
                    $year_week = $year . '0' . $i;
                else
                    $year_week = $year . $i;

                $machineProd = $this->model_production_model->getTotalProductionByYearWeek($year_week, $a_machineids);
                $machineDt = $this->model_production_model->getTotalProductionDtByYearWeek($year_week, $a_machineids);

                $totalWorkMinutes = $machineProd->total_time;
                $totalDtMinutes = $machineDt->total_time;

                $total_area_time[$i] = array(
                    'year_week' => $year_week,
                    'total_work' => $totalWorkMinutes,
                    'total_dt' => $totalDtMinutes,
                    'perc' => ($totalWorkMinutes > 0) ? number_format(100 - (($totalDtMinutes * 100) / $totalWorkMinutes), 2, '.', '') : 0
                );
            }
        }

        // Start to break down by week (total del subarea)
        $total_sarea_time = array();

        if(!empty($sa_machineids)) {
            for ($i = ($initial_week + 1); $i <= $data['week']; $i++) {
                if ($i < 10)
                    $year_week = $year . '0' . $i;
                else
                    $year_week = $year . $i;

                $machineProd = $this->model_production_model->getTotalProductionByYearWeek($year_week, $sa_machineids);
                $machineDt = $this->model_production_model->getTotalProductionDtByYearWeek($year_week, $sa_machineids);

                $totalWorkMinutes = $machineProd->total_time;
                $totalDtMinutes = $machineDt->total_time;

                $total_sarea_time[$i] = array(
                    'year_week' => $year_week,
                    'total_work' => $totalWorkMinutes,
                    'total_dt' => $totalDtMinutes,
                    'perc' => ($totalWorkMinutes > 0) ? number_format(100 - (($totalDtMinutes * 100) / $totalWorkMinutes), 2, '.', '') : 0
                );
            }
        }

        /***
         * Paso 3. Análisis de Causa - Pareto de 1er Nivel
         */

        $total_sa_machine_time = array();
        $ytd_sa_total = array();

        if(!empty($sa_machineids)) {
            foreach ($sa_machines as $machine) {
                $machineProd = $this->model_production_model->getTotalProdMachineByYearWeekRange($machine->id_machine,
                    $first_week_year, $last_week_year);

                // Machines without programs (they never worked), will be ignored
                if (!$machineProd->records * 1)
                    continue;

                $machineDt = $this->model_production_model->getTotalProdMachineDtByYearWeekRange($machine->id_machine,
                    $first_week_year, $last_week_year);

                $totalWorkMinutes = $machineProd->total_time;
                $totalDtMinutes = $machineDt->total_time;

                $total_sa_machine_time[$machine->id_machine] = array(
                    'machine_id' => $machine->id_machine,
                    'machine_name' => $this->utilities->short_string($machine->name, 28),
                    'year_week_range' => $first_week_year . ' - ' . $last_week_year,
                    'total_work' => $totalWorkMinutes,
                    'total_dt' => $totalDtMinutes,
                    'perc' => ($totalWorkMinutes > 0) ? number_format(100 - (($totalDtMinutes * 100) / $totalWorkMinutes), 2, '.', '') * 1 : 0
                );
            }

            // Make YTD Graph

            $ytds = $this->model_production_model->getYTDSubAreaGroupDT($sa_machineids, $first_week_year, $last_week_year);
            $total_ytd_sa = 0;
            $perc_acum = 0;

            if(!empty($ytds)) {
                foreach ($ytds as $ytd) {
                    $ytd_sa_total[] = array(
                        'total_work' => $ytd->total_time,
                        'dcg_name' => $this->utilities->short_string($ytd->name, 28),
                        'machine_id' => $ytd->machine_id,
                        'prod_dt_id' => $ytd->prod_dt_id,
                        'dcg_id' => $ytd->dcg_id,
                        'perc' => 0,
                        'perc_acum' => 0
                    );

                    $total_ytd_sa += $ytd->total_time;
                }

                foreach ($ytd_sa_total as $key => $ydt_value) {
                    $ytd_sa_total[$key]['perc'] = ($total_ytd_sa > 0) ? number_format((($ydt_value['total_work'] * 100) / $total_ytd_sa), 2, '.', '') : 0;
                    $perc_acum += $ytd_sa_total[$key]['perc'];
                    $ytd_sa_total[$key]['perc_acum'] = $perc_acum;
                }
            }
        }

        /***
         * Paso 5. Análisis de Causa raíz (pareto de 2do nivel, Fishbone, 5 porqués).
         */

        $arr_dcg_dt_time = array();

        if(count($total_sa_machine_time)) {

            // Order machines by less uptime descendent by subarea.

            $this->utilities->array_sort_by_column($total_sa_machine_time, 'perc');

            // Get first 2 machines with less uptime

            $i = 0;
            $less_ut_machines = array();

            foreach ($total_sa_machine_time as $value) {
                if ($i == 2) break;

                $less_ut_machines[] = array(
                    'machine_id' => $value['machine_id'],
                    'machine_name' => $this->utilities->short_string($value['machine_name'], 28),
                    'total_work' => $value['total_work']
                );

                $i++;
            }

            // Build dt graph array by machines with less uptime in subarea.

            foreach ($less_ut_machines as $val) {
                $dcg_machine_times = $this->model_production_model->getYTDMachineGroupDT($val['machine_id'],
                    $first_week_year, $last_week_year);

                $percentage_acum = 0;

                if (count($dcg_machine_times) > 0) {
                    foreach ($dcg_machine_times as $oval) {
                        $percentage = ($val['total_work'] > 0) ?
                            number_format((($oval->total_time * 100) / $val['total_work']), 2, '.', '') : 0;
                        $percentage_acum += $percentage;

                        $arr_dcg_dt_time["{$val['machine_name']}"][] = array(
                            'dcg_name' => $this->utilities->short_string($oval->name, 28),
                            'perc' => $percentage,
                            'perc_acum' => $percentage_acum,
                            'dcg_id' => $oval->dcg_id,
                            'prod_dt_id' => $oval->prod_dt_id,
                            'total_dt' => $oval->total_time,
                            'machine_id' => $val['machine_id'],
                        );
                    }
                }
            }
        }

        /***
         * Paso 5. (DTG DESGLOZADOS).
         */

        // Get two Dead Code Groups with more dead time.

        $dcg_machine_maxdt = array();
        $dcg_dc_machine = array(array());

        if(!empty($arr_dcg_dt_time) && count($arr_dcg_dt_time)) {
            foreach ($arr_dcg_dt_time as $key => $value) {

                // Because they are ordered by total deat time in model rs we get frist two or frist one
                // in case we dont have 2

                if (count($value) > 1) {
                    $dcg_machine_maxdt[$key][] = $value[0];
                    $dcg_machine_maxdt[$key][] = $value[1];
                } else {
                    $dcg_machine_maxdt[$key][] = $value[0];
                }
            }
        }

        // Machine...

        if($dcg_machine_maxdt) {
            foreach ($dcg_machine_maxdt as $key => $val) {
                $dc_machine = array();

                // Dead Time Groups by machine

                foreach ($val as $key2 => $val2) {
                    $dcg_machine_times = $this->model_production_model->getYTDMachineDtGroupDts($val2['machine_id'],
                        $val2['dcg_id'], $first_week_year, $last_week_year);

                    $perc_acum = 0;

                    // Dead time by group

                    foreach ($dcg_machine_times as $val3) {
                        $percentage = ($val2['total_dt'] > 0) ? (($val3->dead_time * 100) / $val2['total_dt']) : 0;
                        $perc_acum += $percentage;

                        $dc_machine["{$val2['dcg_name']}"][] = array(
                            'description' => $this->utilities->short_string($val3->description, 28),
                            'dead_time' => $val3->dead_time,
                            'perc' => number_format($percentage, 2, '.', ''),
                            'perc_acum' => number_format($perc_acum, 2, '.', '')
                        );
                    }
                }

                $dcg_dc_machine[$key][] = $dc_machine;
            }
        }

        $data['total_area_uptime'] = $total_area_time;
        $data['total_sarea_uptime'] = $total_sarea_time;
        $data['total_sa_machine_time'] = $total_sa_machine_time;
        $data['total_ytd_sa'] = $ytd_sa_total;
        $data['total_sarea_dcg_time'] = $arr_dcg_dt_time;
        $data['total_dcg_dc_machine'] = $dcg_dc_machine;

        $this->layout->view('dt/report_view', $data);
    }

    /**
     * Ajax controller function to get SubAreas in Dt First View selection
     */

    public function getSubAreas()
    {
        $id_area = $this->input->post('id_area');
        $subAreas = $this->model_area->getSubAreaByAreaId($id_area);

        header('Content-Type: application/json');
        echo json_encode( array('subareas' => $subAreas) );
    }
}