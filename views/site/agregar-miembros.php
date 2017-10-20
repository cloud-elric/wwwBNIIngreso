<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\CatTiposPagos;
use yii\helpers\ArrayHelper;

$this->title="Agregar miembro";

$this->registerJsFile(
    '@web/webAssets/js/agregar-miembros.js',
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
                            <div class="col-md-12">
                                <button class="btn btn-danger btn-block" id="btn-cancel">
                                    <i class="icon fa-close" aria-hidden="true"></i>
                                </button>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>

            <?php 
            $form = ActiveForm::begin([
						'id' => 'form-agregar-miembro',
						//'options' => ['class' => 'form-horizontal'],
						
						'enableClientValidation'=>true,
					]); ?>
            <br>
            <br>                

            <?= $form->field($model, 'image')->hiddenInput(["class"=>"hide"])->label(false) ?>    

            <?= $form->field($model, 'txt_username')->textInput(['maxlength' => true, 'placeholder'=>'Nombre'])->label(false) ?>

            <?= $form->field($model, 'txt_apellido_paterno')->textInput(['maxlength' => true, 'placeholder'=>'Apellido paterno'])->label(false) ?>

            <?= $form->field($registro, 'id_tipo_pago')->radioList(ArrayHelper::map(CatTiposPagos::find()->all(), 'id_tipo_pago', 'txt_nombre')) ?>

            <div class="form-group">
                <?= Html::submitButton($model->isNewRecord ? 'Registrarme' : 'Actualizar información', ['class' => "btn btn-success btn-block btn-lg", 'id'=>'btn-guardar-miembro']) ?>
            </div>

            <?php ActiveForm::end(); ?>
            <canvas id="canvas" style="display:none;"></canvas>
        </div>
    </div>
</div>
   