<script>
    var imgCalendar = "<?= base_url().'application/public/imgs/calendar.gif';?>";
</script>

<script type="text/javascript" src="<?php echo base_url();?>application/public/js/dt/build.js" ></script>

<h1>Scrap - Generar Reporte</h1>

<?php
$frmAttr = array('role' => 'form', 'class' => 'form-horizontal', 'id' => 'build-form');
$metricsOps = array(
    '1' => 'Scrap'
);
$weekOps = array();
$months = array('Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre',
    'Octubre', 'Noviembre', 'Diciembre');

// Testing...
$testing = true;
if($testing)
{
    $month_val = array(6013, 5013, 8013, 1013, 9013, 6453, 6343, 5423, 1032, 9023, 3543, 9999);
    $full_area_val = array_sum($month_val);
    $sub_areas_va =  array(20000, 50881);

    $agc_vals['AG16'] = array(6265, 4869, 7924, 1913, 3788, 14434, 9607, 2081);
    $agc_vals['AG30'] = array(3598, 342, 2440, 181, 611, 248, 450, 3279, 1275, 1060, 918, 44, 8, 802, 4417, 327);

    $problemDefTxt = "El resultado del métrico de scrap en las semanas 41 a la 45 fue en promedio 0.55%, sin embargo se ha mantenido inestable y en el YTD estamos a 2.15% fuera de la meta del 1.4%...";
    $studyReachTxt = "El alcance de este PDCA es encontrar las causas que originan que el scrap este fuera de meta y establecer acciones que nos ayuden a cumplir con la meta del 1.4% en el resto de los meses del 2013...";
}
else{
    $full_area_val = '';
    $sub_areas_va =  array('', '');
    $problemDefTxt = '';
    $studyReachTxt = '';
}

for($i = 1; $i <= 52 ; $i++)
    $weekOps[$i] = $i;

for($i = 2000; $i <= 2032 ; $i++)
    $years[$i] = $i;

$areaInversionAttr = array('name' => 'area_inversion', 'id' => 'area_inversion', 'class' => 'form-control inversionField',
    'placeholder' => 'Ej. 1092312...', 'value' => $full_area_val);
$ag30Attr = array('name' => 'sub_area_inv[AG30]', 'id' => 'AG30', 'class' => 'form-control inversionField',
    'placeholder' => 'Ej. 1092312...', 'value' => $sub_areas_va[0]);
$ag16Attr = array('name' => 'sub_area_inv[AG16]', 'id' => 'AG16', 'class' => 'form-control inversionField',
    'placeholder' => 'Ej. 1092312...', 'value' => $sub_areas_va[1]);
$dateAttr = array('name' => 'date', 'id' => 'date', 'class' => 'form-control', 'style' => 'display:inline;width:90%',
    'placeholder' => 'Ej. 03/14/15...', 'readonly' => 'true', 'value' => $date_now);
$businessAttr = array('name' => 'business', 'id' => 'business', 'class' => 'form-control',
    'placeholder' => 'Ej. Divisores...');
$metricGoalAttr = array('name' => 'metric_goal', 'id' => 'metric_goal', 'class' => 'form-control',
    'placeholder' => 'Ej. 75.00%...');
$actualAttr = array('name' => 'actual', 'id' => 'actual', 'class' => 'form-control',
    'placeholder' => 'Ej. 70.28%...');
$ytdAttr = array('name' => 'ytd', 'id' => 'ytd', 'class' => 'form-control',
    'placeholder' => 'Ej. 75.23%...');
$membersAttr = array('name' => 'members', 'id' => 'members', 'class' => 'form-control',
    'placeholder' => 'Ej. Octavio S. / Juan P. / Luis Alberto...');
$problemDefAttr = array('name' => 'problem_def', 'id' => 'problem_def', 'class' => 'form-control', 'value' => $problemDefTxt,
    'placeholder' => 'Ej. El resultado del métrico de scrap en las semanas 41 a la 45 fue en promedio 0.55%, sin embargo se ha mantenido inestable y en el YTD estamos a 2.15% fuera de la meta del 1.4%...');
$studyReachAttr = array('name' => 'study_reach', 'id' => 'study_reach', 'class' => 'form-control', 'value' => $studyReachTxt,
    'placeholder' => 'Ej. El alcance de este PDCA es encontrar las causas que originan que el scrap este fuera de meta y establecer acciones que nos ayuden a cumplir con la meta del 1.4% en el resto de los meses del 2013...');

$generateBtnAttr = array('id' => 'generar', 'name' => 'generar', 'class' => 'btn btn-primary');
?>

<div class="row">
    <div class="col-md-12">
        <p>Llene los campos a continuación para generar los gráficos:</p>

        <?= validation_errors(); ?>
    </div>
</div>

<div class="row">
    <div class="col-md-7">

        <?= form_open('scrap/graphReport',$frmAttr); ?>

        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Configuración: </h3>
            </div>
            <div class="panel-body">
                <div class="form-group">
                    <label for="licenciatura" class="col-sm-3 control-label">Año: </label>
                    <div class="col-sm-9">
                        <?= form_dropdown('year', $years, date("Y"), 'class="form-control"'); ?>
                    </div>
                </div>
                <div class="form-group">
                    <label for="telefono" class="col-sm-3 control-label">Mes inicial: </label>
                    <div class="col-sm-9">
                        <?= form_dropdown('start_month', $months, 0, 'class="form-control"'); ?>
                    </div>
                </div>
                <div class="form-group">
                    <label for="telefono" class="col-sm-3 control-label">Mes final: </label>
                    <div class="col-sm-9">
                        <?= form_dropdown('end_month', $months, 1, 'class="form-control"'); ?>
                    </div>
                </div>

            </div>
        </div>

        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Inversiones Totales: </h3>
            </div>
            <div class="panel-body">
                <p> Inversión por Área:</p>

                <div class="form-group">
                    <label for="telefono" class="col-sm-3 control-label">BINDERS: </label>
                    <div class="col-sm-9">
                        <?= form_input($areaInversionAttr, set_value('area_inversion')); ?>
                    </div>
                </div>

                <p> Inversión por Sub Área:</p>

                <div class="form-group">
                    <label for="telefono" class="col-sm-3 control-label">AG30: </label>
                    <div class="col-sm-9">
                        <?= form_input($ag30Attr, set_value('AG30')); ?>
                    </div>
                </div>
                <div class="form-group">
                    <label for="telefono" class="col-sm-3 control-label">AG16: </label>
                    <div class="col-sm-9">
                        <?= form_input($ag16Attr, set_value('AG16')); ?>
                    </div>
                </div>

                <?php foreach($machines as $key => $value): ?>

                    <p> Máquinas de la sub area <?= $key ?>:</p>

                    <?php foreach($value as $key2 => $machine): ?>

                        <div class="form-group">
                            <label for="telefono" class="col-sm-3 control-label"><?= $machine['co'] ?>: </label>
                            <div class="col-sm-9">
                                <input type="text" name="<?= $machine['agc'].'['.$machine['co'].']' ?>" value="<?= ($testing) ? $agc_vals["{$machine['agc']}"][$key2] : '' ?>"
                                       class="form-control inversionField" placeholder="Ej. 1060828..." >
                                </div>
                        </div>

                    <?php endforeach; ?>
                <?php endforeach; ?>

                <p> Inversión por mes:</p>

                <?php foreach($months as $key => $month): ?>
                    <div class="form-group">
                        <label for="telefono" class="col-sm-3 control-label"><?= $month ?>: </label>
                        <div class="col-sm-9">
                            <input type="text" name="month[]" id="<?= $month ?>" value="<?= ($testing) ? $month_val[$key] : '' ?>"
                                   class="form-control inversionField" placeholder="Ej. 1060828..." >
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Parámetros: </h3>
            </div>
            <div class="panel-body">
                <div class="form-group">
                    <label for="telefono" class="col-sm-3 control-label">Fecha: </label>
                    <div class="col-sm-9">
                        <?= form_input($dateAttr, set_value('date')); ?>
                    </div>
                </div>
                <div class="form-group">
                    <label for="telefono" class="col-sm-3 control-label">Negocio: </label>
                    <div class="col-sm-9">
                        <?= form_input($businessAttr, set_value('business')); ?>
                    </div>
                </div>
                <div class="form-group">
                    <label for="telefono" class="col-sm-3 control-label">Meta del métrico: </label>
                    <div class="col-sm-9">
                        <?= form_input($metricGoalAttr, set_value('metric_goal')); ?>
                    </div>
                </div>
                <div class="form-group">
                    <label for="telefono" class="col-sm-3 control-label">Actual: </label>
                    <div class="col-sm-9">
                        <?= form_input($actualAttr, set_value('actual')); ?>
                    </div>
                </div>
                <div class="form-group">
                    <label for="telefono" class="col-sm-3 control-label">YTD: </label>
                    <div class="col-sm-9">
                        <?= form_input($ytdAttr, set_value('ytd')); ?>
                    </div>
                </div>
                <div class="form-group">
                    <label for="telefono" class="col-sm-3 control-label">Integrantes: </label>
                    <div class="col-sm-9">
                        <?= form_input($membersAttr, set_value('members')); ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Definición del problema: </h3>
            </div>
            <div class="panel-body">
                <div class="form-group">
                    <div class="col-sm-12">
                        <?= form_textarea($problemDefAttr, set_value('problem_def')); ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Enunciado de Meta (Alcance del estudio): </h3>
            </div>
            <div class="panel-body">
                <div class="form-group">
                    <div class="col-sm-12">
                        <?= form_textarea($studyReachAttr, set_value('study_reach')); ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-12 text-right">
                <?= form_submit($generateBtnAttr, 'Generar Gráfico'); ?>
            </div>
        </div>

        <?= form_close(); ?>
    </div>
</div>