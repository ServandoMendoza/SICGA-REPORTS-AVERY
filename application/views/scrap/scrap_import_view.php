
<script type="text/javascript" src="<?php echo base_url();?>application/public/js/scrap/import.js" ></script>

<div class="row">
    <div class="col-md-6 margin-bottom-low">

        <h1 class="morado">Importar Scrap</h1>

        <?php if(!empty($error)): ?>
            <div class="alert alert-danger alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span>
                    <span class="sr-only">Close</span></button>
                <?= $error; ?>
            </div>
        <?php endif; ?>

        <?php
            $frmAttr = array('role' => 'form', 'class' => 'form-horizontal', 'id' => 'upload-form');
            $generateBtnAttr = array('id' => 'generar', 'name' => 'generar', 'class' => 'btn btn-primary');
        ?>

        <p> * Archivo (.csv) solamente. </p>

        <p>
            * Una vez subido el archivo, espere hasta recibir el mensaje de confirmación,
            no refresque la página, ni envie de nuevo. Esto es con el fin de evitar registros repetidos.
        </p>

        <?= form_open_multipart(base_url().'scrap/do_upload', $frmAttr);?>

        <div class="form-group">
            <label for="userfile" class="col-sm-3 control-label">Archivo: </label>
            <div class="col-sm-9">
                <input type="file" name="userfile" size="20" class="form-control"/>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-12 text-right">
                <?= form_button($generateBtnAttr, 'Subir'); ?>
            </div>
        </div>

        <?php form_close(); ?>
    </div>
</div>