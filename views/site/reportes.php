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
    '@web/webassets/plugins/select2/select2.css',
    ['depends' => [\app\assets\AppAsset::className()]]
);

$this->registerJsFile(
    '@web/webassets/plugins/select2.js',
    ['depends' => [\app\assets\AppAsset::className()]]
);

$this->registerJsFile(
    '@web/webassets/components/select2.js',
    ['depends' => [\app\assets\AppAsset::className()]]
);

$this->registerJsFile(
    '@web/webassets/js/reportes.js',
    ['depends' => [\app\assets\AppAsset::className()]]
);
?>

<?php

 foreach($fechaDisponibles as $fchDisponible){

 }
?>

<select class="form-control" data-plugin="select2">
                    <optgroup label="Alaskan/Hawaiian Time Zone">
                      <option value="AK">Alaska</option>
                      <option value="HI">Hawaii</option>
                    </optgroup>
                    <optgroup label="Pacific Time Zone">
                      <option value="CA">California</option>
                      <option value="NV">Nevada</option>
                      <option value="OR">Oregon</option>
                      <option value="WA">Washington</option>
                    </optgroup>
                    <optgroup label="Mountain Time Zone">
                      <option value="AZ">Arizona</option>
                      <option value="CO">Colorado</option>
                      <option value="ID">Idaho</option>
                      <option value="MT">Montana</option>
                      <option value="NE">Nebraska</option>
                      <option value="NM">New Mexico</option>
                      <option value="ND">North Dakota</option>
                      <option value="UT">Utah</option>
                      <option value="WY">Wyoming</option>
                    </optgroup>
                    <optgroup label="Central Time Zone">
                      <option value="AL">Alabama</option>
                      <option value="AR">Arkansas</option>
                      <option value="IL">Illinois</option>
                      <option value="IA">Iowa</option>
                      <option value="KS">Kansas</option>
                      <option value="KY">Kentucky</option>
                      <option value="LA">Louisiana</option>
                      <option value="MN">Minnesota</option>
                      <option value="MS">Mississippi</option>
                      <option value="MO">Missouri</option>
                      <option value="OK">Oklahoma</option>
                      <option value="SD">South Dakota</option>
                      <option value="TX">Texas</option>
                      <option value="TN">Tennessee</option>
                      <option value="WI">Wisconsin</option>
                    </optgroup>
                    <optgroup label="Eastern Time Zone">
                      <option value="CT">Connecticut</option>
                      <option value="DE">Delaware</option>
                      <option value="FL">Florida</option>
                      <option value="GA">Georgia</option>
                      <option value="IN">Indiana</option>
                      <option value="ME">Maine</option>
                      <option value="MD">Maryland</option>
                      <option value="MA">Massachusetts</option>
                      <option value="MI">Michigan</option>
                      <option value="NH">New Hampshire</option>
                      <option value="NJ">New Jersey</option>
                      <option value="NY">New York</option>
                      <option value="NC">North Carolina</option>
                      <option value="OH">Ohio</option>
                      <option value="PA">Pennsylvania</option>
                      <option value="RI">Rhode Island</option>
                      <option value="SC">South Carolina</option>
                      <option value="VT">Vermont</option>
                      <option value="VA">Virginia</option>
                      <option value="WV">West Virginia</option>
                    </optgroup>
                  </select>



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
