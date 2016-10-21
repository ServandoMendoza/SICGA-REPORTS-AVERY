<script>
    var ajaxGetSubAreas = "<?= base_url().'dt/getSubAreas';?>";
    var imgCalendar = "<?= base_url().'application/public/imgs/calendar.gif';?>";
</script>

<script type="text/javascript" src="<?php echo base_url();?>application/public/js/dt/build.js" ></script>

<h1>Tiempo Muerto - Generar Reporte</h1>

<?php
    $frmAttr = array('role' => 'form', 'class' => 'form-horizontal', 'id' => 'build-form');
    $metricsOps = array(
        '1' => 'UpTime'
    );
    $weekOps = array();

    for($i = 1; $i <= 52 ; $i++)
    {
        $weekOps[$i] = $i;
    }

//    $weekAttr = array('name' => 'week', 'id' => 'week', 'class' => 'form-control',
//    'placeholder' => 'Ej. 6...');
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
    $problemDefAttr = array('name' => 'problem_def', 'id' => 'problem_def', 'class' => 'form-control',
    'placeholder' => 'Ej. El negocio de divisores actualmente tiene una meta de uptime del 75%.De acuerdo con la informacion el area de  PRINTED esta al 75.23%(ytd) de uptime. Actual 70.28% , printed es el area que se estara analizando. ...');
    $studyReachAttr = array('name' => 'study_reach', 'id' => 'study_reach', 'class' => 'form-control',
    'placeholder' => 'Ej. Aumentar el % de uptime de insertables actual al 75% o por arriba de la meta....');

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

        <?= form_open('dt/graphReport',$frmAttr); ?>

        <?= form_input(array('name' => 'id_area', 'id' => 'id_area', 'value' => $id_area, 'type' => 'hidden'));  ?>
        <?= form_input(array('name' => 'id_subarea', 'id' => 'id_subarea', 'value' => $id_subarea, 'type' => 'hidden'));  ?>

        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Parámetros: </h3>
            </div>
            <div class="panel-body">
                <div class="form-group">
                    <label for="licenciatura" class="col-sm-3 control-label">Métrico: </label>
                    <div class="col-sm-9">
                        <?= form_dropdown('metric', $metricsOps, '', 'class="form-control"'); ?>
                    </div>
                </div>
                <div class="form-group">
                    <label for="telefono" class="col-sm-3 control-label">Semana: </label>
                    <div class="col-sm-9">
                        <?= form_dropdown('week', $weekOps, 6, 'class="form-control"'); ?>
                    </div>
                </div>
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