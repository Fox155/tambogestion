<?php

namespace backend\modules\api\controllers;

use Yii;
use common\models\Sucursales;
use common\models\Vacas;
use common\models\SesionesOrdeño;
use common\models\GestorSesionesOrdeño;
use common\models\Producciones;
use common\models\GestorProducciones;
use common\components\FechaHelper;
use yii\web\HttpException;

class ProduccionesController extends BaseController
{
    public function actionAlta()
    {
        $sucursal = new Sucursales();
        $sucursal->setScenario(Sucursales::_AUTH);

        if (!($sucursal->load(Yii::$app->request->post(), '') && $sucursal->validate())) {
            throw new HttpException('403', 'No se tienen los permisos necesarios.');
        }

        // Busco la sucursal por Apikey
        $sucursal->DamePorApiKey();
        if (!isset($sucursal->IdSucursal) || $sucursal->IdSucursal == 0) {
            return ['error' => 'Sucursal no encontrada'];
        }

        $vaca = new Vacas();
        $vaca->setScenario(Vacas::_AUTH);

        if (!($vaca->load(Yii::$app->request->post(), '') && $vaca->validate())) {
            return ['error' => 'Error al cargar los datos de la vaca'];
        }

        // Busco la vaca
        $vaca->DamePorRFID();
        if (!isset($vaca->IdVaca) || $vaca->IdVaca == 0) {
            return ['error' => 'Vaca no encontrada'];
        }
        if ($vaca->IdSucursal != $sucursal->IdSucursal) {
            return ['error' => 'La Vaca no corresponde a la sucursal indicada'];
        }

        // Busca/Alta la sesion de ordeño
        $sesion = new SesionesOrdeño();

        $sesion->IdSucursal = $vaca->IdSucursal;
        $sesion->Fecha = FechaHelper::toDateMysql(Yii::$app->request->post('FechaInicio'));
        $sesion->setScenario(SesionesOrdeño::_ALTA);

        if (!($sesion->load(Yii::$app->request->post(), '') && $sesion->validate())) {
            return ['error' => 'Error al cargar los datos de la sesion de ordeñe'];
        }

        $resultado = (new GestorSesionesOrdeño())->Alta($sesion);
        if (substr($resultado, 0, 2) != 'OK') {
            return ['error' => $resultado];
        }
        $sesion->IdSesionOrdeño = substr($resultado, 2, strlen($resultado));

        // Alta de la produccion
        $produccion = new Producciones();

        $produccion->IdVaca = $vaca->IdVaca;
        $produccion->NroLactancia = $vaca->NroLactancia;
        $produccion->IdSesionOrdeño = $sesion->IdSesionOrdeño;
        $produccion->setScenario(Producciones::_ALTA);

        Yii::info(json_encode($produccion),'PRODUCCION');
        if (!($produccion->load(Yii::$app->request->post(), '') && $produccion->validate())) {
            Yii::info(json_encode($produccion),'PRODUCCION 2');
            return ['error' => 'Error al cargar los datos de la produccion'];
        }

        $resultado = (new GestorProducciones())->Alta($produccion);
        if (substr($resultado, 0, 2) == 'OK') {
            return ['error' => null];
        } else {
            return ['error' => $resultado];
        }
    }
}
