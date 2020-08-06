<?php

namespace backend\modules\api\controllers;

use Yii;
use common\models\GestorUsuarios;
use common\models\forms\BusquedaForm;
use common\components\TiposUsuarioApiHelper;
use yii\web\HttpException;

class UsuariosController extends BaseController
{
    public function actionIndex($IdTambo = 0)
    {
        // Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $usuario = TiposUsuarioApiHelper::dameSiAdministrador();

        $busqueda = new BusquedaForm();

        $busqueda->load(Yii::$app->request->post());
        $cadena = $busqueda->Cadena ? $busqueda->Cadena : '';
        $tipo = $busqueda->Combo ? $busqueda->Combo : 0;
        $estado = $busqueda->Combo2 ? $busqueda->Combo2 : 'A';
        $usuarios = GestorUsuarios::Buscar($tipo, $estado, $cadena, $usuario->IdTambo);

        return [
            'models' => $usuarios,
        ];
    }
}
