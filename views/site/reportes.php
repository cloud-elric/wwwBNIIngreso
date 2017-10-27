<?php
use \yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\ModUsuarios\models\EntUsuariosSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Reportes de asistencia';
$this->params['breadcrumbs'][] = $this->title;

$this->registerCssFile(
    '@web/webassets/css/users.css',
    ['depends' => [\app\assets\AppAsset::className()]]
);

$this->registerJsFile(
    '@web/webassets/js/usuarios.js',
    ['depends' => [\app\assets\AppAsset::className()]]
);

$this->registerCssFile(
    '@web/webassets/plugins/bootstrap-datepicker/bootstrap-datepicker.css',
    ['depends' => [\app\assets\AppAsset::className()]]
);

$this->registerJsFile(
    '@web/webassets/plugins/bootstrap-datepicker/bootstrap-datepicker.js',
    ['depends' => [\app\assets\AppAsset::className()]]
);

$this->registerJsFile(
    '@web/webassets/components/bootstrap-datepicker.js',
    ['depends' => [\app\assets\AppAsset::className()]]
);

$this->registerJsFile(
    '@web/webassets/js/reportes.js',
    ['depends' => [\app\assets\AppAsset::className()]]
);
?>

<?php

// foreach($fechaDisponibles as $fchDisponible){
//     echo $fchDisponible->fch_disponible;
// }
?>



 <!-- Panel -->
 <div class="panel">
    <div class="panel-body">
        <!-- <div class="example-wrap">
            <h4 class="example-title">Seleccionar fecha de asistencia</h4>
            <div class="example">
                <div id="inlineDatepicker" data-autoclose="false" data-date="03/12/2015"></div>
                <input type="hidden" id="inputHiddenInline" />
            </div>
        </div> -->
        <div class="nav-tabs-horizontal">
            <ul class="nav nav-tabs nav-tabs-line" data-plugin="nav-tabs" role="tablist">
                <li class="active" role="presentation"><a data-toggle="tab" href="#miembros" aria-controls="miembros"
                role="tab">Miembros</a></li>
                <li role="presentation"><a data-toggle="tab" href="#invitados" aria-controls="invitados"
                role="tab">Invitados</a></li>
                </li>
            </ul>
        
            <div class="tab-content">
                <div class="tab-pane animation-fade active" id="miembros" role="tabpanel">
                    <div class="text-right">
                        <a target="_blank" class="btn btn-success" href="<?=Url::base()?>/site/exportar-asistencias-miembros">Exportar</a>
                    </div>
                    <?php
                    echo ListView::widget([
                        'dataProvider' => $dataProviderMiembro,
                        'itemView' => '_item-miembro',
                        'layout' => "<ul class='list-group'>{items}</ul>\n{summary}\n{pager}",
                        'itemOptions'=>[
                            'tag'=>'li',
                            'class'=>'list-group-item'
                        ],
                        'summaryOptions'=>[
                            'class'=>'pull-left'
                        ],
                        'pager'=>[
                            'options'=>[
                                'class'=>'pagination pull-right'
                            ]
                        ]
                        
                    ]);
                    ?>
                </div>

                <div class="tab-pane animation-fade active" id="invitados" role="tabpanel">
                    <div class="text-right">
                        <a target="_blank" class="btn btn-success" href="<?=Url::base()?>/site/exportar-asistencias-invitados">Exportar</a>
                    </div>
                    <?php
                    echo ListView::widget([
                        'dataProvider' => $dataProviderInvitados,
                        'itemView' => '_item-invitado',
                        'layout' => "<ul class='list-group'>{items}</ul>\n{summary}\n{pager}",
                        'itemOptions'=>[
                            'tag'=>'li',
                            'class'=>'list-group-item'
                        ],
                        'summaryOptions'=>[
                            'class'=>'pull-left'
                        ],
                        'pager'=>[
                            'options'=>[
                                'class'=>'pagination pull-right'
                            ]
                        ]
                        
                    ]);
                    ?>
                </div>
        </div>
    </div>
</div>
</div>   
<!-- End Panel -->













    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
