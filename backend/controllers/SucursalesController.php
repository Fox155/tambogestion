<?php

namespace backend\controllers;

use common\models\Usuarios;
use common\models\Sucursales;
use common\models\GestorSucursales;
use common\models\RegistrosLeche;
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
                'titulo' => 'Alta Sucursal',
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
                'titulo' => 'Modificar Sucursal',
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
    
    public function actionDetalle($id)
    {
        // if(Yii::$app->user->identity->IdTambo!='Administrador'){
        //     return;
        // }
        
        $sucursal = new Sucursales();
        $sucursal->IdSucursal = $id;
            
        $sucursal->Dame();

        $registros = $sucursal->ResumenRegistrosLeche(5);

        return $this->render('detalle', [
            'titulo' => 'Detalle Sucursal',
            'model' => $sucursal,
            'registros' => $registros
        ]);
    }

    public function actionAltaRegistro($id)
    {
        $registro = new RegistrosLeche();
        $registro->setScenario(RegistrosLeche::_ALTA);
        $registro->IdSucursal = $id;

        $sucursal = new Sucursales();
        $sucursal->IdSucursal = $id;

        if($registro->load(Yii::$app->request->post()) && $registro->validate()){
            $resultado = $sucursal->AltaRegistro($registro);

            Yii::$app->response->format = 'json';
            if (substr($resultado, 0, 2) == 'OK') {
                return ['error' => null];
            } else {
                return ['error' => $resultado];
            }
        }else {
            $sucursal->Dame();
            $registro->Fecha = date('Y-m-d');
            return $this->renderAjax('alta-registro', [
                'titulo' => 'Alta Registro de Leche Sucursal: '.$sucursal->Nombre,
                'model' => $registro
            ]);
        }
    }
}

?>