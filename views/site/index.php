<?php

/* @var $this yii\web\View */
use \yii\helpers\Url;
$this->title = 'Registro de entrada';
?>
<div class="panel">
    <div class="panel-body">
        <div class="row">
            <div class="col-md-6">
                <br>
                <a href="<?=Url::base()?>/site/identificar-miembro" class="btn btn-success btn-block btn-lg">Identificar miembro</a>
            </div>
            
            <div class="col-md-6">
                <br>
                <a href="<?=Url::base()?>/site/agregar-invitado" class="btn btn-primary btn-block btn-lg">Invitado</a>
            </div>
        </div>
    </div>
</div>