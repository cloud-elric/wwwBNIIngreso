<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\modules\ModUsuarios\models\EntUsuarios;
use yii\helpers\ArrayHelper;
use app\models\CatTiposPagos;

$this->registerJsFile(
    '@web/webAssets/js/agregar-invitado.js',
    ['depends' => [\app\assets\AppAsset::className()]]
);

$this->title="Registrar invitado";
?>
<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel">
            <div class="panel-body">
            <?php 
            $form = ActiveForm::begin([
						'id' => 'form-agregar-invitado',
						//'options' => ['class' => 'form-horizontal'],
						
						'enableClientValidation'=>true,
					]); ?>
            <br>
            <br>                

            <?= $form->field($invitado, 'id_usuario_miembro')->dropDownList(ArrayHelper::map(EntUsuarios::find()->where(['b_miembro'=>1, 'id_tipo_usuario'=>1])->orderBy("txt_username")->orderBy("txt_username, txt_apellido_paterno")->all(), 'id_usuario', 'nombreCompleto'), ['prompt'=>'Selecciona el miembro que te invito'])->label(false) ?>    

            <?= $form->field($invitado, 'txt_username')->textInput(['maxlength' => true, 'placeholder'=>'Nombre'])->label(false) ?>

            <?= $form->field($invitado, 'txt_apellido_paterno')->textInput(['maxlength' => true, 'placeholder'=>'Apellido paterno'])->label(false) ?>

            <?= $form->field($invitado, 'txt_email')->textInput(['maxlength' => true, 'placeholder'=>'Email'])->label(false) ?>

            <?= $form->field($registro, 'id_tipo_pago')->radioList(ArrayHelper::map(CatTiposPagos::find()->all(), 'id_tipo_pago', 'txt_nombre')) ?>

            <div class="form-group">
                <?= Html::submitButton('<span class="ladda-label">Registrar invitado</span>', ['class' => "btn btn-success btn-block btn-lg  ladda-button", 'id'=>'btn-guardar-invitado', "data-style"=>"zoom-in"]) ?>                
            </div>

            <?php ActiveForm::end(); ?>
            </div>
        </div>    
    </div>
</div>