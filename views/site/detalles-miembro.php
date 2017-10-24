<?php
use yii\helpers\Html;
use app\models\Calendario;

$this->title="Detalle del miembro";

$this->registerCssFile(
    '@web/webassets/css/profile.css',
    ['depends' => [\app\assets\AppAsset::className()]]
);

$registros = $miembro->registros;

?>
<div class="row">
        <div class="col-md-3">
          <!-- Page Widget -->
          <div class="widget widget-shadow text-center">
            <div class="widget-header">
              <div class="widget-header-content">
                <a class="avatar avatar-lg" href="javascript:void(0)">
                  <img src="<?=$miembro->imageProfile?>" alt="<?=$miembro->nombreCompleto?>">
                </a>
                <h4 class="profile-user"><?=$miembro->nombreCompleto?></h4>
                <p class="profile-job"><?=$miembro->b_miembro?"Honorable miembro":"Honorable invitado"?></p>
              </div>
            </div>
        
          </div>
          <!-- End Page Widget -->
        </div>
        <div class="col-md-9">
          <!-- Panel -->
          <div class="panel">
            <div class="panel-body nav-tabs-animate">
              <ul class="nav nav-tabs nav-tabs-line" data-plugin="nav-tabs" role="tablist">
                <li class="active" role="presentation"><a data-toggle="tab" href="#activities" aria-controls="activities" role="tab">Historial de registro <span class="badge badge-danger"><?=count($registros)?></span></a></li>
                
              </ul>
              <div class="tab-content">
                <div class="tab-pane active animation-slide-left" id="activities" role="tabpanel">
                  <ul class="list-group">
                    <?php
                    foreach($registros as $registro){
                    ?>
                     <li class="list-group-item">
                      <div class="media">
                        <div class="media-body">
                          <h4 class="media-heading"><?=Calendario::getDateComplete($registro->fch_registro)?></h4>
                          <small>Tipo de pago: <?=$registro->idTipoPago->txt_nombre?></small>
                        </div>
                      </div>
                    </li>
                    <?php
                    }
                    ?>
                   
                  </ul>
                  
                </div>
               
              </div>
            </div>
          </div>
          <!-- End Panel -->
        </div>
      </div>