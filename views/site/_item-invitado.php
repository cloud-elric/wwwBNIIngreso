<?php
use app\modules\ModUsuarios\models\EntUsuarios;
use app\models\Calendario;
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
            <small>
            <?=count($model->registros)>0?Calendario::getDateComplete($model->registros[0]->fch_registro):"Sin forma de pago"?>
            </small>
        </h4>
        <p>
            <i class="icon icon-color wb-envelope" aria-hidden="true"></i><?=$model->txt_email?>
        </p>
        <p>
            <i class="icon icon-color wb-user-add" aria-hidden="true"></i>Invitado por: <?=$model->invitadoPor?$model->invitadoPor->nombreCompleto:"Sin invitación"?>
        </p>
        <p>    
            <i class="icon icon-color wb-payment" aria-hidden="true"></i>Forma de pago: <?=count($model->registros)>0?$model->registros[0]->idTipoPago->txt_nombre:"Sin forma de pago"?>
        </p>
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
        <button type="button" class="btn btn-info dropdown-toggle disabled" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Acciones <span class="caret"></span>
        </button>
        <ul class="dropdown-menu dropdown-menu-info dropdown-menu-right">
            <li>
                <a class="js-recovery-pass ladda-button" data-style="zoom-in" data-token="<?=$model->txt_token?>">
                    <span class="ladda-label">
                        Reenviar email de activación
                    </span>
                </a>
            </li>
            <li><a href="#">Editar</a></li>
            <li><a href="#">Deshabilitar</a></li>
        </ul>
        </div>
    </div>
</div>
