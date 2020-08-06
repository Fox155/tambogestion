<?php

namespace backend\modules\api\controllers;

use Yii;
use common\models\ListasPrecio;
use common\models\GestorListasPrecio;
use common\models\forms\BusquedaForm;

use yii\web\HttpException;
use yii\helpers\ArrayHelper;

class ListasPrecioController extends BaseController
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
        $busqueda = new BusquedaForm();

        $gestor = new GestorListasPrecio();

        $busqueda->load(Yii::$app->request->post());
        $cadena = $busqueda->Cadena ? $busqueda->Cadena : '';
        $incluye = $busqueda->Check ? $busqueda->Check : 'N';
        $IdTambo = Yii::$app->user->identity['IdTambo'];
        $ListasPrecio = $gestor->Buscar($incluye, $cadena, $IdTambo);

        return [
            'models' => $ListasPrecio,
        ];
    }

    public function actionAlta()
    {
        $modelo = new ListasPrecio();
        $modelo->setScenario(ListasPrecio::_ALTA);

        if ($modelo->load(Yii::$app->request->post(), '') && $modelo->validate()) {
            $idTambo = Yii::$app->user->identity['IdTambo'];

            $resultado = GestorListasPrecio::Alta($modelo, $idTambo);

            Yii::$app->response->format = 'json';
            if (substr($resultado, 0, 2) == 'OK') {
                return ['error' => null];
            } else {
                return ['error' => $resultado];
            }
        } else {
            return ['error' => 'Error de validacion'];
        }
    }

    public function actionHistorico($id)
    {
        $listaprecio = new ListasPrecio();
        $listaprecio->IdListaPrecio = $id;

        $historicos = $listaprecio->Historico();

        return [
            'models' => $historicos,
        ];
    }
}
