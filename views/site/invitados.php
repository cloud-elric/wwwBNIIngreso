<?php

use yii\helpers\Html;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\ModUsuarios\models\EntUsuariosSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Invitados';
$this->params['breadcrumbs'][] = $this->title;

$this->registerCssFile(
    '@web/webassets/css/users.css',
    ['depends' => [\app\assets\AppAsset::className()]]
);

$this->registerJsFile(
    '@web/webassets/js/usuarios.js',
    ['depends' => [\app\assets\AppAsset::className()]]
);
?>

 <!-- Panel -->
 <div class="panel">
    <div class="panel-body">
        <form class="page-search-form" role="search">
        <div class="input-search input-search-dark">
            <i class="input-search-icon wb-search" aria-hidden="true"></i>
            <input type="text" class="form-control" id="inputSearch" name="search" placeholder="Buscar usuario">
            <button type="button" class="input-search-close icon wb-close" aria-label="Close"></button>
        </div>
        </form>
        <div class="nav-tabs-horizontal">
       
        
        <div class="tab-content">
            <div class="tab-pane animation-fade active" id="all_contacts" role="tabpanel">
                <?php
                echo ListView::widget([
                    'dataProvider' => $dataProvider,
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
