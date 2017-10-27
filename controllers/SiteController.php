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
use app\modules\ModUsuarios\models\Utils;

class SiteController extends Controller
{


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

    public function actionMiembros()
    {
        $searchModel = new EntUsuariosSearch();
        $dataProvider = $searchModel->searchMiembros(Yii::$app->request->queryParams);

        return $this->render('miembros', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionIdentificarMiembro()
    {
        $registro = new EntRegistrosUsuarios();
        $registro->id_tipo_pago = 1;

        return $this->render('identificar-miembro', ['registro' => $registro]);
    }

    public function actionIdentificandoMiembro()
    {

        Yii::$app->response->format = Response::FORMAT_JSON;

        if (isset($_POST['imgBase64'])) {
            $data = $_POST['imgBase64'];


            $data = str_replace('data:image/png;base64,', '', $data);
            $data = str_replace(' ', '+', $data);
            $data = base64_decode($data);
            $idFoto = uniqid();
            $file = 'imagenes-comparar/' . $idFoto . '.png';
            $success = file_put_contents($file, $data);

            $baseUrl = Yii::$app->urlManager->createAbsoluteUrl(['']);
            $urlImage = $baseUrl . 'imagenes-comparar/' . $idFoto . '.png';


            $meerkatApi = new Meerkat();
            $resultado = json_decode($meerkatApi->reconocerUsuario($urlImage));

            $usuario = false;

            $usuarioEncontrado['status'] = "No encontrado";
            $usuarioEncontrado['resultado'] = $resultado;


            foreach ($resultado as $persona) {
                if (!$usuario) {
                    foreach ($persona as $datos) {
                        if ($datos->recognition->confidence > 30) {
                            $token = $datos->recognition->predictedLabel;
                        }
                        else {
                            $token = null;
                        }
                        $usuario = true;

                        $usuarioEncontrado['usuario'] = EntUsuarios::find()->where(["txt_token" => $token])->one();

                    }
                }
            }
            return $usuarioEncontrado;

            exit;

        }
    }

    public function actionAgregarEntrada()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $respuesta['status'] = "error";
        $respuesta['mensaje'] = "Faltan parametros";
        $registro = new EntRegistrosUsuarios();



        if (isset($_POST["token"]) && $registro->load(Yii::$app->request->post())) {
            $token = $_POST["token"];
            $usuario = EntUsuarios::find()->where(["txt_token" => $token])->one();
            if ($usuario) {

                $registro->id_usuario = $usuario->id_usuario;
                $registro->fch_registro = Utils::getFechaActual();

                if ($registro->save()) {
                    $respuesta["mensaje"] = "Registro completo";
                    $respuesta["status"] = "success";
                }
                else {
                    $respuesta["mensaje"] = "No se pudo guardar al usuario";
                }
            }
            else {
                $respuesta["mensaje"] = "No se encontro al usuario";
            }
        }

        return $respuesta;

    }

    public function actionAgregarMiembros()
    {
        $model = new EntUsuarios([
            'scenario' => 'registerInput'
        ]);


        $registro = new EntRegistrosUsuarios();



        return $this->render("agregar-miembros", ['model' => $model, 'registro' => $registro]);
    }

    public function actionGuardarMiembro()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $model = new EntUsuarios();
        $registro = new EntRegistrosUsuarios();
        $respuesta["status"] = "error";
        $respuesta["mensaje"] = "Faltan parametros";


        if ($model->load(Yii::$app->request->post()) && $registro->load(Yii::$app->request->post())) {

            $model->b_miembro = 1;

            $model->image = $_POST['EntUsuarios']['image'];


            $transaction = EntUsuarios::getDb()->beginTransaction();


            try {
                if ($model = $model->signup()) {

                    $respuesta["resultado"] = $this->guargarUsuarioMeerkat($model);

                    $registro->id_usuario = $model->id_usuario;
                    $registro->fch_registro = Utils::getFechaActual();
                    if ($registro->save()) {
                        $transaction->commit();
                        $respuesta["status"] = "success";
                        $respuesta["mensaje"] = "Usuario guardado correctamente";
                    }
                    else {

                        $transaction->rollBack();
                        $respuesta["mensaje"] = "No se pudo guardar el registro";
                    }
                }
                else {
                    $respuesta["mensaje"] = "No se pudo guardar el usuario";
                }



            } catch (\Exception $e) {
                $transaction->rollBack();
                $respuesta["mensaje"] = $e;
                throw $e;
            }
        }

        return $respuesta;


    }

    private function guargarUsuarioMeerkat($miembro)
    {

        $data = $miembro->image;

        $data = str_replace('data:image/png;base64,', '', $data);
        $data = str_replace(' ', '+', $data);
        $data = base64_decode($data);
        $idFoto = $miembro->txt_token;
        $file = 'imagenes/' . $idFoto . '.png';
        $success = file_put_contents($file, $data);

        $baseUrl = Yii::$app->urlManager->createAbsoluteUrl(['']);
        $urlImage = $baseUrl . 'imagenes/' . $idFoto . '.png';


        $meerkatApi = new Meerkat();
         //return $meerkatApi->guardarUsuario($urlImage, $miembro->txt_token);


    }


    public function actionHardGuardarMeerkat($token)
    {
        $meerkatApi = new Meerkat();

        $baseUrl = Yii::$app->urlManager->createAbsoluteUrl(['']);
        $urlImage = $baseUrl . 'imagenes/' . $token . '.png';
        echo $meerkatApi->guardarUsuario($urlImage, $token);
    }

    public function actionAgregarInvitado()
    {
        $model = new EntUsuarios([
            'scenario' => 'registerInvitado'
        ]);

        $registro = new EntRegistrosUsuarios();


        return $this->render('agregar-invitado', ['invitado' => $model, 'registro' => $registro]);
    }


    public function actionGuardarInvitado()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $respuesta['status'] = 'error';
        $respuesta['mensaje'] = 'Ocurrio un problema';
        $model = new EntUsuarios();
        $registro = new EntRegistrosUsuarios();

        if ($model->load(Yii::$app->request->post()) && $registro->load(Yii::$app->request->post())) {


            $model->b_miembro = 0;

            $transaction = EntUsuarios::getDb()->beginTransaction();

            try {

                if ($model = $model->signup()) {

                    $registro->id_usuario = $model->id_usuario;
                    $registro->fch_registro = Utils::getFechaActual();
                    if ($registro->save()) {
                        $transaction->commit();
                        $respuesta['status'] = 'success';
                        $respuesta['mensaje'] = 'Invitado registrado correctamente';
                    }
                    else {
                        $transaction->rollBack();
                        $respuesta['mensaje'] = 'Ocurrio un problema al guardar';
                    }
                }
                else {
                    $respuesta['mensaje'] = 'No se enviaron todos los datos';
                }



            } catch (\Exception $e) {
                $transaction->rollBack();
                throw $e;
                $respuesta['mensaje'] = $e;
            }
        }

        return $respuesta;
    }

    public function actionInvitados()
    {

        $searchModel = new EntUsuariosSearch();
        $dataProvider = $searchModel->searchInvitados(Yii::$app->request->queryParams);

        return $this->render('invitados', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionDetallesMiembro($token = null)
    {

        $miembro = EntUsuarios::find()->where(["txt_token" => $token])->one();
        if ($miembro) {

            return $this->render("detalles-miembro", ["miembro" => $miembro]);
        }
        else {
            $this->goHome();
        }


    }

    public function actionTestDate()
    {
        echo Utils::getFechaActual();
    }

    public function actionReportes()
    {

        $searchModel = new EntUsuariosSearch();
        $dataProviderInvitados = $searchModel->searchInvitados(Yii::$app->request->queryParams);

        $dataProviderMiembros = $searchModel->searchMiembros(Yii::$app->request->queryParams);

        $fechaDisponibles = EntRegistrosUsuarios::find()
        ->select(['fch_registro as fch_disponible'])
        ->groupBy(['fch_registro'])
        ->all();


        return $this->render("reportes", [
            'dataProviderInvitados' => $dataProviderInvitados, 
            'dataProviderMiembro' => $dataProviderMiembros,
            'fechaDisponibles' => $fechaDisponibles
            ]);
    }


    public function actionExportarAsistenciasMiembros(){
        
       
        $registros =  EntRegistrosUsuarios::find()->joinWith('idUsuario')->where('mod_usuarios_ent_usuarios.b_miembro=1')->orderBy("fch_registro")->all();
        
        
		$arrayCsv = [ ];
		$i = 0;
		foreach ( $registros as $registro ) {
            $arrayCsv [$i] ['nombreCompleto'] = $registro->idUsuario->nombreCompleto;
            $arrayCsv [$i] ['email'] = $registro->idUsuario->txt_email;
            $arrayCsv [$i] ['fch_registro'] = $registro->fch_registro;
            $arrayCsv [$i] ['num_invitados'] = count($registro->idUsuario->invitados);
			
			$i++;
		}
	//print_r($arrayCsv );
	//exit ();
		$this->downloadSendHeaders ( 'reporte.csv' );
		echo $this->array2CsvMiembro ( $arrayCsv );
		die();
    }

    public function actionExportarAsistenciasInvitados(){
        
       
        $registros =  EntRegistrosUsuarios::find()->joinWith('idUsuario')->where('mod_usuarios_ent_usuarios.b_miembro=0')->orderBy("fch_registro")->all();
        
        
		$arrayCsv = [ ];
		$i = 0;
		foreach ( $registros as $registro ) {
            $arrayCsv [$i] ['nombreCompleto'] = $registro->idUsuario->nombreCompleto;
            $arrayCsv [$i] ['email'] = $registro->idUsuario->txt_email;
            $arrayCsv [$i] ['fch_registro'] = $registro->fch_registro;
            $arrayCsv [$i] ['nombre'] = $registro->idUsuario->invitadoPor?$registro->idUsuario->invitadoPor->nombreCompleto:'';
			
			$i++;
		}
	//print_r($arrayCsv );
	//exit ();
		$this->downloadSendHeaders ( 'reporte.csv' );
		echo $this->array2CsvInvitado ( $arrayCsv );
		die();
    }

    private function array2CsvMiembro($array) {
        if (count ( $array ) == 0) {
            return null;
        }
        ob_start();
        $df = fopen ( "php://output", "w" );
        fputcsv ( $df, [
                'Nombre completo',
                'Email',				
                'Fecha registro',
                '# de invitados'
        ]
            );
        foreach ( $array as $row ) {
            fputcsv ( $df, $row );
        }
        fclose ( $df );
        return ob_get_clean();
    }
    

    private function array2CsvInvitado($array) {
        if (count ( $array ) == 0) {
            return null;
        }
        ob_start();
        $df = fopen ( "php://output", "w" );
        fputcsv ( $df, [
                'Nombre completo',
                'Email',				
                'Fecha registro',
                'Invitado por'
        ]
            );
        foreach ( $array as $row ) {
            fputcsv ( $df, $row );
        }
        fclose ( $df );
        return ob_get_clean();
    }

    private function downloadSendHeaders($filename) {
		// disable caching
		$now = gmdate ( "D, d M Y H:i:s" );
		// header("Expires: Tue, 03 Jul 2001 06:00:00 GMT");
		header ( "Cache-Control: max-age=0, no-cache, must-revalidate, proxy-revalidate" );
		header ( "Last-Modified: {$now} GMT" );
		// force download
		header ( "Content-Type: application/force-download" );
		header ( "Content-Type: application/octet-stream" );
		// comentario sin sentido
		header ( "Content-Type: application/download" );
		// disposition / encoding on response body
		header ( "Content-Disposition: attachment;filename={$filename}" );
		header ( "Content-Transfer-Encoding: binary" );
	}

}
