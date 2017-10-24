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
use yii\widgets\ActiveForm;
use app\models\EntRegistrosUsuarios;
use app\modules\ModUsuarios\models\EntUsuariosSearch;

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

             $usuario = false;
            
             $usuarioEncontrado['status'] = "No encontrado";
        
            
             foreach($resultado as $persona){
                 if(!$usuario){
                     foreach($persona as $datos){
                         $token = $datos->recognition->predictedLabel;
                         $usuario = true;
        echo $token;
                      $usuarioEncontrado = EntUsuarios::find()->where(["txt_token"=>$token])->one();
                            
                        
                     }
                 } 
             }
             echo json_encode($usuarioEncontrado);
        
             exit;
           
        }
    }

    public function actionAgregarMiembros(){
        $model = new EntUsuarios ( [ 
            'scenario' => 'registerInput' 
        ] );
        

        $registro = new EntRegistrosUsuarios();
        

    
        return $this->render("agregar-miembros", ['model'=>$model, 'registro'=>$registro]);
    }

    public function actionGuardarMiembro(){
        Yii::$app->response->format = Response::FORMAT_JSON;
        $model = new EntUsuarios();
        $registro = new EntRegistrosUsuarios();

        

        if ($model->load ( Yii::$app->request->post () ) && $registro->load(Yii::$app->request->post()) ){

            $model->b_miembro = 1;

            $model->image = $_POST['EntUsuarios']['image'];
            

            $transaction = EntUsuarios::getDb()->beginTransaction();

            
            try {
                if($model = $model->signup()){

                    $this->guargarUsuarioMeerkat($model);       

                    $registro->id_usuario = $model->id_usuario;
                    if($registro->save()){
                        $transaction->commit();    
                    }else{
                        $transaction->rollBack();
                    }
                }
                    
                

            } catch(\Exception $e) {
                $transaction->rollBack();
                throw $e;
            } 
        }
    

    }

    private function guargarUsuarioMeerkat($miembro){

        $data = $miembro->image;
    
        $data = str_replace('data:image/png;base64,', '', $data);
        $data = str_replace(' ', '+', $data);
        $data = base64_decode($data);
        $idFoto = $miembro->txt_token;
        $file = 'imagenes/'. $idFoto . '.png';
        $success = file_put_contents($file, $data);

        $baseUrl = Yii::$app->urlManager->createAbsoluteUrl(['']);
        $urlImage = $baseUrl.'imagenes/'.$idFoto . '.png';
    
        echo $urlImage;
        $meerkatApi = new Meerkat();
        echo   $meerkatApi->guardarUsuario($urlImage, $miembro->txt_token);
      
    }

    public function actionAgregarInvitado(){
        $model = new EntUsuarios ( [ 
            'scenario' => 'registerInvitado' 
        ] );

        $registro = new EntRegistrosUsuarios();


        return $this->render('agregar-invitado', ['invitado'=>$model, 'registro'=>$registro]);
    }


    public function actionGuardarInvitado(){
        Yii::$app->response->format = Response::FORMAT_JSON;
        $respuesta['status'] = 'error';
        $respuesta['mensaje']='Ocurrio un problema';
        $model = new EntUsuarios();
        $registro = new EntRegistrosUsuarios();

        if ($model->load ( Yii::$app->request->post () ) && $registro->load(Yii::$app->request->post()) ){
            
            
            $model->b_miembro = 0;

            $transaction = EntUsuarios::getDb()->beginTransaction();

            try {
                
                if($model = $model->signup()){     

                    $registro->id_usuario = $model->id_usuario;
                    if($registro->save()){
                        $transaction->commit();
                        $respuesta['status'] = 'success';
                        $respuesta['mensaje'] = 'Invitado registrado correctamente';
                    }else{
                        $transaction->rollBack();
                        $respuesta['mensaje'] = 'Ocurrio un problema al guardar';
                    }
                }else{
                    $respuesta['mensaje'] = 'No se enviaron todos los datos';
                }
                    
                

            } catch(\Exception $e) {
                $transaction->rollBack();
                throw $e;
                $respuesta['mensaje'] = $e;
            } 
        }

        return $respuesta;
    }

    public function actionInvitados(){

        $searchModel = new EntUsuariosSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('invitados', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    
}
