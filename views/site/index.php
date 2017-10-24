<?php

/* @var $this yii\web\View */
use \yii\helpers\Url;
$this->title = '';
?>
<div class="panel">
    <div class="panel-body">
        <div class="row">
            <div class="col-md-6">
                <a href="<?=Url::base()?>/site/identificar-miembro" class="btn btn-success btn-block btn-lg">Miembro</a>
            </div>
            <div class="col-md-6">
                <a href="<?=Url::base()?>/site/agregar-invitado" class="btn btn-primary btn-block btn-lg">Invitado</a>
            </div>
        </div>
    </div>
</div>