<script>
    var ajaxGetSubAreas = "<?= base_url().'dt/getSubAreas';?>";
</script>

<script type="text/javascript" src="<?php echo base_url();?>application/public/js/dt/index.js" ></script>

<h1>Tiempo Muerto - Reporte</h1>

<div class="row">
    <div class="col-md-12">
        <p>Eliga Area y Sub Area para iniciar el proceso.</p>
    </div>
</div>

<div class="row">
    <div class="col-md-7">
        <?php
        $frmAttr = array('role' => 'form', 'class' => 'form-horizontal');

        if(count($areas)) {
            $areaOps[0] = "Seleccione...";
            foreach($areas as $area)
                $areaOps["{$area->id}"] = $area->name;
        }
        else{
            $areaOps[0] = 'Error... No se encontraron areas';
        }

        $addBtnAttr = array('id' => 'next', 'name' => 'next', 'class' => 'btn btn-primary');

        echo validation_errors();
        echo form_open('dt',$frmAttr);

        ?>

        <div class="form-group">
            <label for="id_area" class="col-sm-4 control-label">Seleccionar Area: </label>
            <div class="col-sm-8">
                <?= form_dropdown('id_area', $areaOps, '', 'class="form-control" id="id_area"'); ?>
            </div>
        </div>

        <div id="sub-area-box" class="form-group">
            <label for="id_turno" class="col-sm-4 control-label">Seleccionar SubArea:</label>
            <div class="col-sm-8">
                <?= form_dropdown('id_sub_area', array(), '', 'class="form-control" id="id_sub_area"'); ?>
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-12 text-right">
                <?= form_submit($addBtnAttr, 'Siguiente'); ?>
            </div>
        </div>
        <?= form_close(); ?>


    </div>
</div>