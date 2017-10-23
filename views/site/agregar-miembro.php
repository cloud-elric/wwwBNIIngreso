<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
$this->title="Agregar miembro";

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
                <?php $form = ActiveForm::begin([
						'id' => 'form-ajax',
						//'options' => ['class' => 'form-horizontal'],
						'enableAjaxValidation' => true,
						'enableClientValidation'=>true,
					]); ?>

                    

                    <?= $form->field($model, 'txt_username')->textInput(['maxlength' => true, 'placeholder'=>'Nombre'])->label(false) ?>

                    <?= $form->field($model, 'txt_apellido_paterno')->textInput(['maxlength' => true, 'placeholder'=>'Apellido paterno'])->label(false) ?>

                    <?= $form->field($model, 'txt_apellido_materno')->textInput(['maxlength' => true, 'placeholder'=>'Apellido materno'])->label(false) ?>

                    <?= $form->field($model, 'txt_email')->textInput(['maxlength' => true, 'placeholder'=>'Email'])->label(false) ?>
                    

                    <div class="form-group">
                        <?= Html::submitButton($model->isNewRecord ? 'Registrarme' : 'Actualizar información', ['class' => "btn btn-success btn-block btn-lg"]) ?>
                    </div>

                    <?php ActiveForm::end(); ?>
                </div>
            </div>

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
   