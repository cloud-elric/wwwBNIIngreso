
<?php
namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\components\AccessControlExtend;
use app\modules\ModUsuarios\models\EntUsuarios;
use yii\widgets\ActiveForm;
use app\models\EntRegistrosUsuarios;
use app\modules\ModUsuarios\models\EntUsuariosSearch;
use app\modules\ModUsuarios\models\Utils;

class LeadsController extends Controller
{
    /**
     * @inheritdoc
     */
     public function behaviors()
     {
         return [
             'access' => [
                 'class' => AccessControlExtend::className(),
                 'only' => ['dashboard'],
                 'rules' => [
                     [
                         'actions' => ['dashboard-leads'],
                         'allow' => true,
                         'roles' => ['miembro'],
                     ],
                   
                 ],
             ],
            // 'verbs' => [
            //     'class' => VerbFilter::className(),
            //     'actions' => [
            //         'logout' => ['post'],
            //     ],
            // ],
        ];
    }

    public function actionDashboardLeads(){

    }
}
?>