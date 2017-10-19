<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\components\AccessControlExtend;
use app\modules\ModUsuarios\models\EntUsuarios;
use app\models\Meerkat;

class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    // public function behaviors()
    // {
        // return [
        //     'access' => [
        //         'class' => AccessControlExtend::className(),
        //         'only' => ['logout', 'about'],
        //         'rules' => [
        //             [
        //                 'actions' => ['logout'],
        //                 'allow' => true,
        //                 'roles' => ['admin'],
        //             ],
                   
        //         ],
        //     ],
            // 'verbs' => [
            //     'class' => VerbFilter::className(),
            //     'actions' => [
            //         'logout' => ['post'],
            //     ],
            // ],
        //];
    //}

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }


    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        
       
        return $this->render('index');
    }

    public function actionIdentificarMiembro(){

        return $this->render('identificar-miembro');
    }

    public function actionIdentificandoMiembro(){

        Yii::$app->response->format = Response::FORMAT_JSON;

        if(isset($_POST['imgBase64'])){
            $data = $_POST['imgBase64'];
            
        
            $data = str_replace('data:image/png;base64,', '', $data);
            $data = str_replace(' ', '+', $data);
            $data = base64_decode($data);
            $idFoto = uniqid();
            $file = 'imagenes-comparar/'. $idFoto . '.png';
            $success = file_put_contents($file, $data);
        
            $baseUrl = Yii::$app->urlManager->createAbsoluteUrl(['']);
            $urlImage = $baseUrl.'imagenes-comparar/'.$idFoto . '.png';
        
        
             $meerkatApi = new Meerkat();
             $resultado = json_decode ( $meerkatApi->reconocerUsuario($urlImage));

            print_r($resultado);

            exit;

             $usuario = false;
            
             $usuarioEncontrado['status'] = "No encontrado";
        
            
             foreach($resultado as $persona){
                 if(!$usuario){
                     foreach($persona as $datos){
                         $token = $datos->recognition->predictedLabel;
                         $usuario = true;
        
                      $usuarioEncontrado = EntUsuarios::findOne(["txt_token"=>$token]);
                            
                        
                     }
                 } 
             }
             echo json_encode($usuarioEncontrado);
        
             exit;
           
        }
    }

    
}
