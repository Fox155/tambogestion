<?php

namespace backend\controllers;

use common\models\Usuarios;
use common\models\Sucursales;
use common\models\GestorSucursales;
use common\models\forms\BusquedaForm;
use Yii;
use yii\web\Controller;
use yii\data\Pagination;

class SucursalesController extends Controller
{
    public function actionIndex()
    {
        $busqueda = new BusquedaForm();

        $gestor = new GestorSucursales();

        if ($busqueda->load(Yii::$app->request->post()) && $busqueda->validate()) {
            $cadena = $busqueda->Cadena ? $busqueda->Cadena : '';
            $sucursales = $gestor->Buscar($cadena);
        } else {
            $sucursales = $gestor->Buscar();
        }

        return $this->render('index', [
            'models' => $sucursales,
            'busqueda' => $busqueda
        ]);
    }

    public function actionAlta()
    {
        // if(Yii::$app->user->identity->IdTambo!='Administrador'){
        //     return;
        // }

        $sucursal = new Sucursales();

        $sucursal->setScenario(Sucursales::_ALTA);

        if($sucursal->load(Yii::$app->request->post()) && $sucursal->validate()){
            $resultado = GestorSucursales::Alta($sucursal);

            Yii::$app->response->format = 'json';
            if (substr($resultado, 0, 2) == 'OK') {
                return ['error' => null];
            } else {
                return ['error' => $resultado];
            }
        }else {
            return $this->renderAjax('alta', [
                'model' => $sucursal
            ]);
        }
    }

    public function actionEditar($id)
    {
        // if(Yii::$app->user->identity->IdTambo!='Administrador'){
        //     return;
        // }
        
        $sucursal = new Sucursales();

        $sucursal->setScenario(Sucursales::_MODIFICAR);

        if ($sucursal->load(Yii::$app->request->post()) && $sucursal->validate()) {
            $resultado = GestorSucursales::Modificar($sucursal);

            Yii::$app->response->format = 'json';
            if ($resultado == 'OK') {
                return ['error' => null];
            } else {
                return ['error' => $resultado];
            }
        } else {
            $sucursal->IdSucursal = $id;
            
            $sucursal->Dame();

            return $this->renderAjax('alta', [
                        'model' => $sucursal
            ]);
        }
    }

    public function actionBorrar($id)
    {
        // if(Yii::$app->user->identity->IdTambo!='Administrador'){
        //     return;
        // }

        Yii::$app->response->format = 'json';
        
        $sucursal = new Sucursales();
        $sucursal->IdSucursal = $id;

        $resultado = GestorSucursales::Borrar($sucursal);

        if ($resultado == 'OK') {
            return ['error' => null];
        } else {
            return ['error' => $resultado];
        }
    }    
}

?>