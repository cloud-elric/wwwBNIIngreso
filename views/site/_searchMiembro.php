<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\SearchUsuarios */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ent-usuarios-search">

    <?php $form = ActiveForm::begin([
        'id'=>'form-buscar',
        'action' => ['miembros'],
        'method' => 'get',
        'options' => ['data-pjax' => true,'class'=>'page-search-form' ]
    ]); ?>

    <?= $form->field($model, 'txt_username', [
    'options' => ["class"=>"input-search input-search-dark form-group"],
    'template'=>'<i class="input-search-icon wb-user" aria-hidden="true"></i>{input}<button type="button" class="input-search-close icon wb-close js-clear-input" aria-label="Close"></button>'
])->textInput(['placeholder'=>'Nombre miembro'])->label(false) ?>

    <?= $form->field($model, 'txt_apellido_paterno',[
    'options' => ["class"=>"input-search input-search-dark form-group"],
    'template'=>'<i class="input-search-icon wb-user" aria-hidden="true"></i>{input}<button type="button" class="input-search-close icon wb-close js-clear-input" aria-label="Close"></button>'
])->textInput(['placeholder'=>'Apellido'])->label(false) ?>

    <?php  echo $form->field($model, 'txt_email',[
    'options' => ["class"=>"input-search input-search-dark form-group"],
    'template'=>'<i class="input-search-icon fa-envelope" aria-hidden="true"></i>{input}<button type="button" class="input-search-close icon wb-close js-clear-input" aria-label="Close"></button>'
])->textInput(['placeholder'=>'Email'])->label(false) ?>

    <div class="form-group">
        <?= Html::submitButton('Buscar', ['class' => 'btn btn-primary js-search-button', 'name'=>'isOpen', 'value'=>Yii::$app->request->get('isOpen')?'1':'0']) ?>
        <?= Html::button('Limpiar', ['class' => 'btn btn-default js-limpiar-campos']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
