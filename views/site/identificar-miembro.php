<?php
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use app\models\CatTiposPagos;
use yii\widgets\ActiveForm;
$this->title="Identificar miembro";

$this->registerJsFile(
    '@web/webAssets/js/identificar-usuario.js',
    ['depends' => [\app\assets\AppAsset::className()]]
);
?>
<div class="col-md-10 col-md-offset-1">
    <div class="panel">
        <div class="panel-body">

            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <div class="container-media">
                        <video style="width:100%;" class="embed-responsive-item" id="v"></video>
                        <img class="img-responsive" style="width:100%; display:none;"  id="photo" alt="photo"> 
                        <button class="btn btn-primary btn-block" id="take">
                            <i class="icon fa-camera" aria-hidden="true"></i>
                        </button>
                        <div class="row container-btn-actions">
                            <div class="col-md-6 no-padding-right">
                                <button class="btn btn-danger btn-block" id="btn-cancel">
                                    <i class="icon fa-close" aria-hidden="true"></i>
                                </button>
                            </div>
                            <div class="col-md-6 no-padding-left">
                                <button class="btn btn-success btn-block ladda-button" data-style="zoom-in" id="btn-guardar">
                                    <span class="ladda-label">
                                        <i class="icon fa-check" aria-hidden="true"></i>
                                    </span>                
                                </button>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
            <canvas id="canvas" style="display:none;"></canvas>
        </div>
    </div>
</div>
   


<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Resultado</h4>
            </div>
            <div class="modal-body">

                <h5>Bienvenido(a) <span  id="nombre-usuario"></span></h5>
                <img style="width:100%;" id="imagen-encontrada" />

                <div class="row">
                    <div class="col-md-6 col-md-offset-3 text-center">
                    <?php 
                    $form = ActiveForm::begin([
                                'id' => 'form-agregar-registro',
                                //'options' => ['class' => 'form-horizontal'],
                                
                                'enableClientValidation'=>true,
                            ]); ?>
                    <br>
                    <br>                

                    <?= $form->field($registro, 'id_tipo_pago')->radioList(ArrayHelper::map(CatTiposPagos::find()->all(), 'id_tipo_pago', 'txt_nombre')) ?>

                    <div class="form-group">
                        <?= Html::submitButton('<span class="ladda-label">Registrar entrada</span>', ['class' => "btn btn-succes btn-block btn-lg js-registrar-entrada ladda-button", "data-style"=>"zoom-in",  'id'=>'btn-guardar-miembro', 'data-token'=>""]) ?>
                    </div>

                    <?php 
                    ActiveForm::end(); 
                    ?>    
                    </div>
                </div>   
                <div class="row">
                    <div class="col-md-6 col-md-offset-3 text-center">
                        <button class="btn btn-danger js-close-modal">
                            No soy yo
                        </button>
                    </div>
                </div> 
            </div>

        </div>
    </div>
</div>