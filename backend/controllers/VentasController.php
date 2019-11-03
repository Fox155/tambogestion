<?php

namespace backend\controllers;

use common\models\Ventas;
use common\models\GestorVentas;
use common\models\Sucursales;
use common\models\Clientes;
use common\models\GestorClientes;
use common\models\ListasPrecio;
use common\models\GestorListasPrecio;
use common\models\forms\BusquedaForm;
use Yii;
use yii\web\Controller;
use yii\data\Pagination;
use common\components\FechaHelper;

class VentasController extends Controller
{
    public function actionIndex($id)
    {
        $busqueda = new BusquedaForm();

        if ($busqueda->load(Yii::$app->request->post()) && $busqueda->validate()) {
            $cadena = $busqueda->Cadena ? $busqueda->Cadena : '';
            $incluye = $busqueda->Check ? $busqueda->Check : 'N';
            $inicio = $busqueda->FechaInicio ? FechaHelper::toDateMysql($busqueda->FechaInicio) : NULL;
            $fin = $busqueda->FechaFin ? FechaHelper::toDateMysql($busqueda->FechaFin) : NULL;
            $ventas = GestorVentas::Buscar($id,$cadena, $inicio, $fin, $incluye);
        } else {
            $ventas = GestorVentas::Buscar($id);
        }

        $sucursal = new Sucursales();
        if($id != 0){
            $sucursal->IdSucursal = $id;
            $sucursal->Dame();
        }

        return $this->render('index', [
            'models' => $ventas,
            'busqueda' => $busqueda,
            'sucursal' => $sucursal
        ]);
    }

    public function actionAlta($id)
    {
        // if(Yii::$app->user->identity->IdTambo!='Administrador'){
        //     return;
        // }

        $clientes = new Clientes();
        $clientes->setScenario(Clientes::_ALTA);

        if($clientes->load(Yii::$app->request->post()) && $clientes->validate()){
            $resultado = GestorClientes::Alta($clientes);

            Yii::$app->response->format = 'json';
            if (substr($resultado, 0, 2) == 'OK') {
                return ['error' => null];
            } else {
                return ['error' => $resultado];
            }
        }else {
            $listasprecio  = 0;
            if($id == 0){
                $listasprecio  = GestorListasPrecio::Buscar();
            }else{
                $clientes->IdListaPrecio = $id;
            }

            return $this->renderAjax('alta', [
                'titulo' => 'Nuevo Cliente',
                'model' => $clientes,
                'listaprecio' => $listasprecio
            ]);
        }
    }

    public function actionEditar($id)
    {
       
        $clientes = new Clientes();
        $clientes ->setScenario(Clientes::_MODIFICAR);

        if ($clientes->load(Yii::$app->request->post()) && $clientes->validate()) {
            $resultado = GestorClientes::Modificar($clientes);

            Yii::$app->response->format = 'json';
            if ($resultado == 'OK') {
                return ['error' => null];
            } else {
                return ['error' => $resultado];
            }
        } else {
            $clientes->IdCliente = $id;
            
            $clientes->Dame();
            $listasprecio  = GestorListasPrecio::Buscar();

            return $this->renderAjax('alta', [
                'titulo' => 'Modificar Cliente',
                'model' => $clientes,
                'listaprecio' => $listasprecio
            ]);
        }
    }

    public function actionBorrar($id)
    {
        Yii::$app->response->format = 'json';
        
        $clientes = new Clientes();
        $clientes->IdCliente= $id;

        $resultado = GestorClientes::Borrar($clientes);

        if ($resultado == 'OK') {
            return ['error' => null];
        } else {
            return ['error' => $resultado];
        }
    }
    
    public function actionDarbaja($id)
    {
        Yii::$app->response->format = 'json';
        
        $clientes = new Clientes();
        $clientes->IdCliente= $id;

        $resultado = Clientes::Darbaja($clientes);

        if ($resultado == 'OK') {
            return ['error' => null];
        } else {
            return ['error' => $resultado];
        }
    }

    public function actionActivar($id)
        {
            Yii::$app->response->format = 'json';
            
            $clientes = new Clientes();
            $clientes->IdCliente= $id;
    
            $resultado = Clientes::Activar($clientes);
    
            if ($resultado == 'OK') {
                return ['error' => null];
            } else {
                return ['error' => $resultado];
        }    

    }

}

?>