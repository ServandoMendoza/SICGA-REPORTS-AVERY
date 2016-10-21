<script>
    var ajaxGetSubAreas = "<?= base_url().'dt/getSubAreas';?>";
    var imgDiagramaPescado = "<?= base_url().'application/public/imgs/diagrama-pescado.jpg';?>";

    var arrAreaWeek = [], arrScrapAreaYear = [];
    var saScrapPerSaName = [], saScrapPerQty = [], saScrapPerPerc = [];
    var saScrapTotal = [];
    var saMachScrapSaName = [], saMachScrapName = [], saMachScrapQty = [], saMachScrapPerc = [];
    var saMachScrapProcSaName = [], saScrapProc = [];
    var saCodeScrap = [], saCodeScrapQty = [], saCodeScraPerc = [], saCodeScraSaName = "";
    var saMaNameReason = [], saMaReasonName = [], saMaReasonScrapQty = [], saMaReasonPerc = [];

    var metricGoal = parseFloat(<?= $metric_goal ?>);
    var areaName = "<?= $area_name ?>";
    var lessSAreaName = "<?= $less_sa_name ?>";
    var selectedYear = "<?= $selected_year ?>";
    var monthRange = "<?= $months[$start_month-1].' - '.$months[$end_month-1] ?>";


    <?php foreach($area_year_scrap as $key => $value): ?>
        arrAreaWeek.push(<?= $key + 1  ?>);
        arrScrapAreaYear.push(<?= $value['perc']  ?>);
    <?php endforeach; ?>

    <?php foreach($sa_scraps as $sa_scraps_key => $sa_scrap): ?>
        saScrapPerSaName.push('<?= $sa_scrap["sa_name"] ?>');
        saScrapPerQty.push(<?= $sa_scrap["scrap_qty"] * 1 ?>);
        saScrapPerPerc.push(<?= $sa_scrap["perc"] * 1 ?>);
    <?php endforeach; ?>

    <?php foreach($sa_scraps_process as $sa_scraps_key => $sa_scrap): ?>
        saScrapTotal.push(['<?= $sa_scrap["sa_name"] ?>', <?= $sa_scrap["scrap_qty"] * 1 ?>]);
    <?php endforeach; ?>

    <?php foreach($sa_machine_scrap as $sub_area => $machine_scrap): ?>
        var tempMachName = [];
        var tempMachQty = [];
        var tempMachPerc = [];

        <?php foreach($machine_scrap as $key => $machine): ?>
            tempMachName.push('<?= $machine["machine"] ?>');
            tempMachQty.push(<?= $machine["scrap_qty"] * 1 ?>);
            tempMachPerc.push(<?= $machine["perc"] * 1 ?>);
        <?php endforeach; ?>

        saMachScrapSaName.push('<?= $sub_area ?>');
        saMachScrapName.push(tempMachName);
        saMachScrapQty.push(tempMachQty);
        saMachScrapPerc.push(tempMachPerc);
    <?php endforeach; ?>

    <?php foreach($sa_machine_scrap_process as $sub_area => $machine_scrap): ?>
        var tempScrapSaAmt = [];

        <?php foreach($machine_scrap as $key => $machine): ?>
            tempScrapSaAmt.push(['<?= $machine["machine"] ?>', <?= $machine["scrap_qty"] * 1 ?>]);
        <?php endforeach; ?>

        saScrapProc.push(tempScrapSaAmt);
    <?php endforeach; ?>

    <?php foreach($sa_code_scrap as $code_scrap): ?>
        saCodeScrap.push('<?= $code_scrap["code"] ?>');
        saCodeScrapQty.push(<?= $code_scrap["scrap_qty"] * 1 ?>);
        saCodeScraPerc.push(<?= $code_scrap["perc"] * 1 ?>);
        saCodeScraSaName = '<?= $code_scrap["sa_name"] ?>';
    <?php endforeach; ?>

    <?php foreach($sa_m_scrap_reason as $machine => $reason_scrap): ?>
        var tempReasonName = [];
        var temReasonSqty = [];
        var tempReasonPerc = [];

        <?php foreach($reason_scrap as $key => $reason): ?>
            tempReasonName.push('<?= $reason["reason"] ?>');
            temReasonSqty.push(<?= $reason["net_amt"] * 1 ?>);
            tempReasonPerc.push(<?= $reason["perc"] * 1 ?>);
        <?php endforeach; ?>

        saMaNameReason.push('<?= $machine ?>');
        saMaReasonName.push(tempReasonName);
        saMaReasonScrapQty.push(temReasonSqty);
        saMaReasonPerc.push(tempReasonPerc);
    <?php endforeach; ?>

</script>

<script type="text/javascript" src="<?php echo base_url();?>application/public/js/highcharts/js/highcharts.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>application/public/js/highcharts/js/modules/exporting.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>application/public/js/scrap/report.js" ></script>

<?php
$diagramNumOps = array();
for($i=1;$i<=10;$i++)
    $diagramNumOps[$i] = $i;
?>

<div class="row">
    <div class="col-md-12 text-center">
        <h1>GAP ANALYSIS -  Método PDCA</h1>
    </div>
</div>

<div class="row">
    <div class="col-md-4">
        <span class="text-bold">Semana:</span> <?= $months[$start_month-1].' - '.$months[$end_month-1].' '.$selected_year ?>
    </div>
    <div class="col-md-4">
        <span class="text-bold">Fecha:</span> <?= $date_selected ?>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <span class="text-bold">Integrantes:</span> <?= $members ?>
    </div>
</div>

<div class="row">
    <div class="col-md-4">
        <span class="text-bold">Meta del Métrico:</span> <?= (!empty($metric_goal))? $metric_goal.'%': '' ?>
    </div>
    <div class="col-md-4">
        <span class="text-bold">Actual:</span> <?= (!empty($actual))? $actual.'%': '' ?>
    </div>
    <div class="col-md-4">
        <span class="text-bold">YTD:</span> <?= (!empty($ytd))? $ytd.'%': '' ?>
    </div>
</div>

<div class="row" style="margin-top: 20px">
    <div class="col-md-12">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Paso 1. Verificación de la Tendencia del Métrico. </h3>
            </div>
            <div class="panel-body">
                <div id="year_weekly" style="min-width: 500px; min-height: 400px; margin: 0 auto"></div>

                <div id="monthly_scrap" style="width: 100%;">
                    <div class="ytd" style="width:7%">
                        <ul class="ytd ytd-first">
                            <li>Scrap</li>
                            <li><?= $area_name ?></li>
                            <li>Meta <?= $metric_goal ?>%</li>
                            <li>Actual Scrap</li>
                            <li>GAP</li>
                            <li>&nbsp;</li>
                        </ul>
                    </div>
                    <?php foreach($area_monthly_scrap as $value): ?>
                        <div class="ytd">
                            <ul class="ytd text-center">
                                <li><?= $value["month"] ?></li>
                                <li><?= $value["inversion"] ?></li>
                                <li><?= $value["goal"] ?></li>
                                <li><?= $value["actual_scrap"] ?></li>
                                <li style="color:<?= ($value["gap"])? '#00b05c' : '#ff484f'?>">
                                    $<?= $value["gap"] ?>
                                </li>
                                <li><?= $value["actual_perc"].'%' ?></li>
                            </ul>
                        </div>
                    <?php endforeach; ?>

                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Paso 2. Definición del Problema. </h3>
            </div>
            <div class="panel-body">
                <?= $problem_def ?>
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Paso 3. Análisis de Causa - Pareto de 1er Nivel. </h3>
            </div>
            <div class="panel-body">
                <div class="col-md-6">
                    <div id="sa_scrap_per" style="min-width: 500px; max-height: 400px; margin: 0 auto"></div>
                </div>
                <div class="col-md-6">
                    <div id="sa_scrap" style="min-width: 500px; max-height: 400px; margin: 0 auto"></div>
                </div>
                <div class="col-md-6">
                    <div id="sa_machine1_scrap" style="min-width: 500px; max-height: 400px; margin: 0 auto"></div>
                </div>
                <div class="col-md-6">
                    <div id="sa_machine2_scrap" style="min-width: 500px; max-height: 400px; margin: 0 auto"></div>
                </div>
                <div class="col-md-6">
                    <div id="sa_machine1_scrap_proc" style="min-width: 500px; max-height: 400px; margin: 0 auto"></div>
                </div>
                <div class="col-md-6">
                    <div id="sa_machine2_scrap_proc" style="min-width: 500px; max-height: 400px; margin: 0 auto"></div>
                </div>
                <div class="col-md-6">
                    <div id="sa_code_scrap" style="min-width: 500px; max-height: 400px; margin: 0 auto"></div>
                </div>
                <div class="col-md-6">
                    <div id="sa_m_reason_1" style="min-width: 500px; max-height: 400px; margin: 0 auto"></div>
                </div>
                <div class="col-md-6">
                    <div id="sa_m_reason_2" style="min-width: 500px; max-height: 400px; margin: 0 auto"></div>
                </div>
                <div class="col-md-6">
                    <div id="sa_m_reason_3" style="min-width: 500px; max-height: 400px; margin: 0 auto"></div>
                </div>
                <div class="col-md-6">
                    <div id="sa_m_reason_4" style="min-width: 500px; max-height: 400px; margin: 0 auto"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Paso 4. Enunciado de Meta (Alcance del estudio):</h3>
            </div>
            <div class="panel-body">
                <?= $study_reach ?>
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Paso 5. Análisis de Causa raíz (pareto de 2do nivel, Fishbone, 5 porqués)</h3>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-5">
                        <label for="licenciatura" class="col-sm-8 control-label">Número de diagramas de pescado: </label>
                        <div class="col-sm-4">
                            <?= form_dropdown('diag_numb', $diagramNumOps, 1, 'class="form-control" id="diag_numb"'); ?>
                        </div>
                    </div>
                </div>
                <div class="row" id="d-pescado-box">
                    <div class="col-md-12">
                        <img src="<?= base_url().'application/public/imgs/diagrama-pescado.jpg';?>" alt="Diagrama Pescado" class="img-responsive"/>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Paso 6. Definición de Acciones de Contención.</h3>
            </div>
            <div class="panel-body">
                <table class="table table-bordered tbl-pdca-scrap">
                    <tr class="active">
                        <th>Accion</th>
                        <th>Líder</th>
                        <th>¿Cuando?</th>
                        <th>Estatus</th>
                        <th>¿Funcionó?</th>
                        <th>Nueva Fecha</th>
                        <th>Comentarios</th>
                    </tr>
                    <tr class="active">
                        <td>Insertables (SCRAP DE AJUSTES)</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td align="center">
                            <img src="<?= base_url().'application/public/imgs/circle.png';?>" width="15px"/>
                        </td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td>AJUSTES DE INICIO DE TURNO, INICIO, ESTACIONES MOVIDAS</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td align="center">
                            <img src="<?= base_url().'application/public/imgs/circle.png';?>" width="15px"/>
                        </td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td>Analizar Datos</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td align="center">
                            <img src="<?= base_url().'application/public/imgs/circle.png';?>" width="15px"/>
                        </td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                    <?php for($i=0;$i<3;$i++): ?>
                        <tr>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td align="center">
                                <img src="<?= base_url().'application/public/imgs/circle.png';?>" width="15px"/>
                            </td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                        </tr>
                    <?php endfor; ?>
                    <tr class="active">
                        <td>Cambio de Papel</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                    <?php for($i=0;$i<5;$i++): ?>
                        <tr>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td align="center">
                                <img src="<?= base_url().'application/public/imgs/circle.png';?>" width="15px"/>
                            </td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                        </tr>
                    <?php endfor; ?>
                    <tr class="active">
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                    <?php for($i=0;$i<3;$i++): ?>
                        <tr>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td align="center">
                                <img src="<?= base_url().'application/public/imgs/circle.png';?>" width="15px"/>
                            </td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                        </tr>
                    <?php endfor; ?>
                    <tr class="active">
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                    <?php for($i=0;$i<5;$i++): ?>
                        <tr>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td align="center">
                                <img src="<?= base_url().'application/public/imgs/circle.png';?>" width="15px"/>
                            </td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                        </tr>
                    <?php endfor; ?>

                </table>
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Paso 7. Definición de Acciones Correctivas.</h3>
            </div>
            <div class="panel-body">
                <table class="table table-bordered tbl-pdca-scrap">
                    <tr class="active">
                        <th>Accion</th>
                        <th>Líder</th>
                        <th>¿Cuando?</th>
                        <th>Estatus</th>
                        <th>Impacto</th>
                        <th>Comentarios</th>
                    </tr>
                    <?php for($i=0;$i<10;$i++): ?>
                    <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                    <?php endfor; ?>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Paso 8. Estandarice en otras areas. (Comparta la información de las contramedidas que sí funcionaron).</h3>
            </div>
            <div class="panel-body">
                <table class="table table-bordered tbl-pdca-scrap">
                    <tr class="active">
                        <th>Accion</th>
                        <th>Líder</th>
                        <th>¿Cuando?</th>
                        <th>Estatus</th>
                        <th>Impacto</th>
                        <th>Comentarios</th>
                    </tr>
                    <?php for($i=0;$i<10;$i++): ?>
                        <tr>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                        </tr>
                    <?php endfor; ?>
                </table>
            </div>
        </div>
    </div>
</div>

