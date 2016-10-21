<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>
            <?=$title_for_layout?>
        </title>

        <link rel="shortcut icon" href="<?= base_url()."application/public/imgs/favicon.ico" ?>" type="image/x-icon">
        <?= link_tag('application/public/css/bootstrap.min.css');?>
        <?= link_tag('application/public/css/bootstrap-theme.min.css');?>
        <?= link_tag('application/public/css/site.css');?>
        <link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
        <?= link_tag('application/public/css/bootstrapValidator.min.css');?>

        <script type="text/javascript" src="<?= base_url()."application/public/js/jquery-1.11.1.min.js";?>"></script>
        <script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
        <script type="text/javascript" src="<?= base_url()."application/public/js/bootstrap.min.js";?>"></script>
        <script type="text/javascript" src="<?= base_url()."application/public/js/notify.min.js";?>"></script>
        <script type="text/javascript" src="<?= base_url()."application/public/js/bootstrapValidator.min.js";?>"></script>

        <?=$css_for_layout?>
        <?=$js_for_layout?>
    </head>
    <body>
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                            data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="<?= base_url()?>">AVERY - Report Tool</a>
                </div>
                <div id="navbar" class="collapse navbar-collapse">
                    <ul class="nav navbar-nav">
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Tiempo Muerto <span class="caret"></span></a>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="<?= base_url()?>">Graficar</a></li>
                            </ul>
                        </li>

                    </ul>
                    <ul class="nav navbar-nav">
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Scrap <span class="caret"></span></a>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="<?= base_url()?>scrap/import">Importar</a></li>
                                <li><a href="<?= base_url()?>scrap">Graficar</a></li>
                            </ul>
                        </li>

                    </ul>
                </div><!--/.nav-collapse -->
            </div>
        </nav>

        <div class="container">
            <div class="starter-template"> <?=$content_for_layout?> </div>
        </div><!-- /.container -->

    </body>
</html>