<?php
use app\modules\ModUsuarios\models\EntUsuarios;
use \yii\helpers\Url;
?>
<div class="media">
    <div class="media-left">
        <div class="avatar <?=($model->id_status == EntUsuarios::STATUS_ACTIVED)? "avatar-online":"avatar-busy"?>">
            <img src="<?=$model->imageProfile?>" alt="<?=$model->nombreCompleto?>">
            <i></i>
        </div>
    </div>

    <div class="media-body">
        <h4 class="media-heading">
            <?=$model->nombreCompleto?>
        </h4>
        <div>
            <?php
            if($usuarioFacebook = $model->isRegisterFaceBook()){
            ?>    

            <a class="text-action" href="https://www.facebook.com/<?=$usuarioFacebook->id_facebook?>">
            <i class="icon icon-color bd-facebook" aria-hidden="true"></i>
            Registrado mediante Facebook

            <?php 
            }
            ?>
            </a>
        </div>
    </div>

    <!-- Single button -->
<div class="media-right">
    <div class="btn-group">
        <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Acciones <span class="caret"></span>
        </button>
        <ul class="dropdown-menu dropdown-menu-info dropdown-menu-right">
            <li>
                <a href="<?=Url::base()?>/site/detalles-miembro?token=<?=$model->txt_token?>". data-token="<?=$model->txt_token?>">
                        Ver detalles
                </a>
            </li>
        </ul>
        </div>
    </div>
</div>
