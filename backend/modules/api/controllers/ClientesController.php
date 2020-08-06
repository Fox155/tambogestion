<?php

namespace backend\modules\api\controllers;

use Yii;
use common\models\Clientes;
use common\models\GestorClientes;
use common\models\forms\BusquedaForm;
use common\components\TiposUsuarioApiHelper;

use yii\web\HttpException;
use yii\helpers\ArrayHelper;

class ClientesController extends BaseController
{
    public function behaviors()
    {
        return ArrayHelper::merge(
            parent::behaviors(),
            [
                'bearerAuth' => [
                    'class' => \yii\filters\auth\HttpBearerAuth::className(),
                ],
            ]
        );
    }

    public function actionIndex()
    {
        TiposUsuarioApiHelper::verificarAdministrador();

        $busqueda = new BusquedaForm();

        $busqueda->load(Yii::$app->request->post());
        $cadena = $busqueda->Cadena ? $busqueda->Cadena : '';
        $incluye = $busqueda->Check ? $busqueda->Check : 'N';
        $IdTambo = Yii::$app->user->identity['IdTambo'];
        $clientes = GestorClientes::Buscar($incluye, $cadena, $IdTambo);

        return [
            'models' => $clientes,
        ];
    }

    public function actionAlta()
    {
        TiposUsuarioApiHelper::verificarAdministrador();

        $clientes = new Clientes();
        $clientes->setScenario(Clientes::_ALTA);

        if($clientes->load(Yii::$app->request->post(), '') && $clientes->validate()){
            $idTambo = Yii::$app->user->identity['IdTambo'];

            $resultado = GestorClientes::Alta($clientes, $idTambo);

            Yii::$app->response->format = 'json';
            if (substr($resultado, 0, 2) == 'OK') {
                return ['error' => null];
            } else {
                return ['error' => $resultado];
            }
        }else {
            return ['error' => 'Error de validacion'];
        }
    }

    public function actionEditar()
    {
        TiposUsuarioApiHelper::verificarAdministrador();

        $cliente = new Clientes();
        $cliente->setScenario(Clientes::_MODIFICAR);

        if($cliente->load(Yii::$app->request->post(), '') && $cliente->validate()){
            $resultado = GestorClientes::Modificar($cliente);

            Yii::$app->response->format = 'json';
            if (substr($resultado, 0, 2) == 'OK') {
                return ['error' => null];
            } else {
                return ['error' => $resultado];
            }
        }else {
            return ['error' => 'Error de validacion'];
        }
    }

    public function actionDarbaja()
    {
        TiposUsuarioApiHelper::verificarAdministrador();
        Yii::$app->response->format = 'json';
        
        $cliente = new Clientes();
        $cliente->IdCliente= Yii::$app->request->post('Id');

        $resultado = Clientes::Darbaja($cliente);

        if ($resultado == 'OK') {
            return ['error' => null];
        } else {
            return ['error' => $resultado];
        }
    }
}
