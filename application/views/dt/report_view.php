<script>
    var ajaxGetSubAreas = "<?= base_url().'dt/getSubAreas';?>";
    var imgDiagramaPescado = "<?= base_url().'application/public/imgs/diagrama-pescado.jpg';?>";
    var arrAreaWeek = [];
    var arrUpTimeArea = [];
    var arrUpTimeSubArea = [];
    var arrUpTimeSubAreaMachines = [];
    var arrDtgSaYtdName = [];
    var arrDtgSaYtdSum = [];
    var arrDtgSaYtdPercSum = [];
    var arrSubAreaMachinesDtName  = [];
    var arrSubAreaMachineDt = [];
    var arrMachineDt = [];

    var arrMaquinaGrupoDTDT = [];
    var arrMaquinaGrupoDT = [];
    var arrMaquinaDT = [];


    var metaMetrico = <?= $metric_goal ?>;
    var areaName = "<?= $area->name ?>";
    var subAreaName = "<?= $sub_area->name ?>";

    <?php foreach($total_area_uptime as $key => $value): ?>
        arrAreaWeek.push(<?= $key  ?>);
        arrUpTimeArea.push(<?= $value['perc']  ?>);
    <?php endforeach; ?>

    <?php foreach($total_sarea_uptime as $key => $value): ?>
        arrUpTimeSubArea.push(<?= $value['perc']  ?>);
    <?php endforeach; ?>

    <?php foreach($total_sa_machine_time as $key => $value): ?>
        arrUpTimeSubAreaMachines.push(['<?= $value['machine_name']  ?>', <?= $value['perc']  ?>]);
    <?php endforeach; ?>

    <?php foreach($total_ytd_sa as $key => $value): ?>
        arrDtgSaYtdName.push('<?= $value['dcg_name']  ?>');
        arrDtgSaYtdSum.push(<?= number_format($value['total_work'], 2, '.', '') * 1 ?>);
        arrDtgSaYtdPercSum.push(<?= $value['perc_acum'] * 1  ?>);
    <?php endforeach; ?>

    <?php
        if(count($total_sarea_dcg_time) > 0):
        foreach($total_sarea_dcg_time as $key => $value):
    ?>
        arrSubAreaMachinesDtName.push('<?= $key ?>');

        var obj={};
        var dcg_name = []; var perc = []; var perc_acum = [];

        <?php foreach($value as $key2 => $value2): ?>
            dcg_name.push('<?= $value2['dcg_name']?>');
            perc.push(<?= $value2['perc'] * 1?>);
            perc_acum.push(<?= $value2['perc_acum']?>);
        <?php endforeach; ?>

            obj.dcg_name = dcg_name;
            obj.perc = perc;
            obj.perc_acum = perc_acum;

            arrSubAreaMachineDt.push(obj);

    <?php
        endforeach;
        endif;

        if(count($total_dcg_dc_machine) > 0):
        foreach($total_dcg_dc_machine as $key => $dcg_arr):?>

    <?php        foreach($dcg_arr as $key2 => $dt_arr): ?>



    <?php           foreach($dt_arr as $key3 => $dt):

    ?>

                    var obj={};
                    var dc_name = []; var perc = []; var perc_acum = [];

        <?php         foreach($dt as $key4 => $val4): ?>

                        dc_name.push('<?= $val4['description']?>');
                        perc.push(<?= $val4['perc'] * 1?>);
                        perc_acum.push(<?= $val4['perc_acum']?>);


    <?php endforeach; ?>
        obj.dcg_name = '<?= $key3 ?>';
        obj.dc_name = dc_name;
        obj.perc = perc;
        obj.perc_acum = perc_acum;

        //console.log(obj);
        arrMaquinaGrupoDTDT.push(obj);
  <?php endforeach; ?>
    arrMaquinaGrupoDT.push(arrMaquinaGrupoDTDT);
    arrMaquinaGrupoDTDT = [];
  <?php endforeach; ?>


    <?php endforeach;endif; ?>

        //console.log(arrMaquinaGrupoDT);
//        console.log(123);

</script>

<script type="text/javascript" src="<?php echo base_url();?>application/public/js/highcharts/js/highcharts.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>application/public/js/highcharts/js/modules/exporting.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>application/public/js/dt/report.js" ></script>

<?php
    $diagramNumOps = array();
    for($i=1;$i<=10;$i++)
        $diagramNumOps[$i] = $i;
?>

<div class="row">
    <div class="col-md-12 text-center">
        <h1>Uptime PDCA semana <?= $week ?></h1>
    </div>
</div>

<div class="row">
    <div class="col-md-4">
        <span class="text-bold">Métrico:</span> <?= $metric ?>
    </div>
    <div class="col-md-4">
        <span class="text-bold">Semana:</span> <?= $week ?>
    </div>
    <div class="col-md-4">
        <span class="text-bold">Fecha:</span> <?= $date ?>
    </div>
</div>

<div class="row">
    <div class="col-md-4">
        <span class="text-bold">Negocio:</span> <?= $business ?>
    </div>
    <div class="col-md-4">
        <span class="text-bold">Meta del métrico:</span> <?= (!empty($metric_goal))? $metric_goal.'%': '' ?>
    </div>
    <div class="col-md-2">
        <span class="text-bold">Actual:</span> <?= (!empty($actual))? $actual.'%': '' ?>
    </div>
    <div class="col-md-2">
        <span class="text-bold">YTD:</span> <?= (!empty($ytd))? $ytd.'%': '' ?>
    </div>
</div>


<div class="row">
    <div class="col-md-12">
        <span class="text-bold">Integrantes:</span> <?= $members ?>
    </div>
</div>


<div class="row" style="margin-top: 20px">
    <div class="col-md-12">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Paso 1. Verificación de la Tendencia del Métrico. </h3>
            </div>
            <div class="panel-body">
                <div id="area_ut" style="min-width: 500px; height: 400px; margin: 0 auto"></div>
                <div id="sub_area_ut" style="min-width: 500px; height: 400px; margin: 0 auto"></div>
            </div>
        </div>

    </div>

    <div class="col-md-12">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Paso 2. Definición del problema. </h3>
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
                    <div id="machines_sa_ut" style="min-width: 500px; height: 400px; margin: 0 auto"></div>
                </div>
                <div class="col-md-6">
                    <div id="dtg_sa_ytd" style="min-width: 500px; height: 400px; margin: 0 auto"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-12">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Paso 4. Enunciado de Meta (Alcance del estudio). </h3>
            </div>
            <div class="panel-body">
                <?= $study_reach ?>
            </div>
        </div>
    </div>

    <div class="col-md-12">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Paso 5. Análisis de Causa raíz (pareto de 2do nivel, Fishbone, 5 porqués).</h3>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-6">
                        <div id="sa_dtg_machine_1" style="min-width: 500px; max-height: 400px; margin: 0 auto"></div>
                    </div>
                    <div class="col-md-6">
                        <div id="sa_dtg_machine_2" style="min-width: 500px; max-height: 400px; margin: 0 auto"></div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div id="sa_dt_1_machine_1" style="min-width: 500px; max-height: 400px; margin: 0 auto"></div>
                    </div>
                    <div class="col-md-6">
                        <div id="sa_dt_1_machine_2" style="min-width: 500px; max-height: 400px; margin: 0 auto"></div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div id="sa_dt_2_machine_1" style="min-width: 500px; max-height: 400px; margin: 0 auto"></div>
                    </div>
                    <div class="col-md-6">
                        <div id="sa_dt_2_machine_2" style="min-width: 500px; max-height: 400px; margin: 0 auto"></div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-5">
                        <label for="licenciatura" class="col-sm-8 control-label">Numero de diagramas de pescado: </label>
                        <div class="col-sm-4">
                            <?= form_dropdown('diag_numb', $diagramNumOps, '', 'class="form-control" id="diag_numb"'); ?>
                        </div>
                    </div>
                </div>
                <div class="row" id="d-pescado-box">
                    <div class="col-md-12">
                        <img src="<?= base_url().'application/public/imgs/diagrama-pescado.jpg';?>" alt="" class="img-responsive"/>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="col-md-12">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Paso 6. Definición de Acciones de Contención. </h3>
            </div>
            <div class="panel-body">
                <table class="table table-bordered">
                    <thead>
                    <tr bgcolor="#E8E8E8">
                        <th width="30%">Acción</th>
                        <th>Líder</th>
                        <th>&iquest;Cuándo?</th>
                        <th>Estatus</th>
                        <th>Impacto</th>
                        <th>Comentarios/Update</th>
                    </tr>
                    <tr bgcolor="#FFFF66">
                        <th colspan="6" style="text-align:center;"><?= $sub_area->name ?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-12">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Paso 7. Definición de Acciones Correctivas: </h3>
            </div>
            <div class="panel-body">
                <table class="table table-bordered">
                    <thead>
                    <tr bgcolor="#E8E8E8">
                        <th width="30%">Acción</th>
                        <th>Líder</th>
                        <th>&iquest;Cuándo?</th>
                        <th>Estatus</th>
                        <th>Impacto</th>
                        <th>Comentarios/Update</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-12">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Paso 8. Estandarice en otras areas. (Comparta la información de las contramedidas que sí funcionaron). </h3>
            </div>
            <div class="panel-body">
                <table class="table table-bordered">
                    <thead>
                    <tr bgcolor="#E8E8E8">
                        <th width="30%">Acción</th>
                        <th>Líder</th>
                        <th>&iquest;Cuándo?</th>
                        <th>Estatus</th>
                        <th>Impacto</th>
                        <th>Comentarios/Update</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>