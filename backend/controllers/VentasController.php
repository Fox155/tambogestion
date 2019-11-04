<?php

namespace backend\controllers;

use common\models\Ventas;
use common\models\GestorVentas;
use common\models\Sucursales;
use common\models\GestorSucursales;
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
        $venta = new Ventas();
        $venta->setScenario(Ventas::_ALTA);

        if($venta->load(Yii::$app->request->post()) && $venta->validate()){
            $resultado = GestorVentas::Alta($venta);

            Yii::$app->response->format = 'json';
            if (substr($resultado, 0, 2) == 'OK') {
                return ['error' => null];
            } else {
                return ['error' => $resultado];
            }
        }else {
            $sucursales  = 0;
            if($id == 0){
                $sucursales  = GestorSucursales::Buscar();
            }else{
                $venta->IdSucursal = $id;
            }

            $clientes = GestorClientes::Buscar();

            return $this->renderAjax('alta', [
                'titulo' => 'Nueva Venta',
                'model' => $venta,
                'sucursales' => $sucursales,
                'clientes' => $clientes
            ]);
        }
    }

    public function actionEditar($id)
    {
        $venta = new Ventas();
        $venta ->setScenario(Ventas::_MODIFICAR);

        if ($venta->load(Yii::$app->request->post()) && $venta->validate()) {
            $resultado = GestorVentas::Modificar($venta);

            Yii::$app->response->format = 'json';
            if ($resultado == 'OK') {
                return ['error' => null];
            } else {
                return ['error' => $resultado];
            }
        } else {
            $venta->IdVenta = $id;
            $venta->Dame();
            
            $clientes = GestorClientes::Buscar();

            return $this->renderAjax('alta', [
                'titulo' => 'Modificar Venta',
                'model' => $venta,
                'clientes' => $clientes
            ]);
        }
    }

    public function actionBorrar($id)
    {
        Yii::$app->response->format = 'json';
        
        $venta = new Ventas();
        $venta->IdVenta = $id;

        $resultado = GestorVentas::Borrar($venta);

        if ($resultado == 'OK') {
            return ['error' => null];
        } else {
            return ['error' => $resultado];
        }
    }
    
    public function actionDarbaja($id)
    {
        Yii::$app->response->format = 'json';
        
        $venta = new Ventas();
        $venta->IdVenta= $id;

        $resultado = $venta->DarBaja();

        if ($resultado == 'OK') {
            return ['error' => null];
        } else {
            return ['error' => $resultado];
        }
    }

    public function actionDetalle($id)
    {       
        $venta = new Ventas();
        $venta->IdVenta = $id;
        $venta->Dame();

        $busqueda = new BusquedaForm();

        if ($busqueda->load(Yii::$app->request->post()) && $busqueda->validate()) {
            $inicio = $busqueda->FechaInicio ? FechaHelper::toDateMysql($busqueda->FechaInicio) : NULL;
            $fin = $busqueda->FechaFin ? FechaHelper::toDateMysql($busqueda->FechaFin) : NULL;
            $incluye = $busqueda->Check ? $busqueda->Check : 'N';
            $pagos = $venta->BuscarPagos($inicio, $fin, $incluye);
        } else {
            $pagos = $venta->BuscarPagos();
        }

        return $this->render('detalle', [
            'titulo' => 'Detalle Venta',
            'model' => $venta,
            'busqueda' => $busqueda,
            'pagos' => $pagos,
        ]);
    }

    public function actionAltaPago($id)
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

    public function actionBorrarPago($id)
    {
        // if(Yii::$app->user->identity->IdTambo!='Administrador'){
        //     return;
        // }

        Yii::$app->response->format = 'json';
        
        $registro = new RegistrosLeche();
        $registro->IdRegistroLeche = $id;

        $resultado = Sucursales::BorrarRegistro($registro);

        if ($resultado == 'OK') {
            return ['error' => null];
        } else {
            return ['error' => $resultado];
        }
    }

    public function actionEditarPago($id)
    {
        // if(Yii::$app->user->identity->IdTambo!='Administrador'){
        //     return;
        // }
        
        $registro = new RegistrosLeche();

        $registro->setScenario(RegistrosLeche::_MODIFICAR);

        if ($registro->load(Yii::$app->request->post()) && $registro->validate()) {
            $resultado = Sucursales::ModificarRegistro($registro);

            Yii::$app->response->format = 'json';
            if ($resultado == 'OK') {
                return ['error' => null];
            } else {
                return ['error' => $resultado];
            }
        } else {
            $registro->IdRegistroLeche = $id;
            $registro->Dame();

            return $this->renderAjax('alta-registro', [
                'titulo' => 'Modificar Registro de Leche dia: '.$registro->Fecha,
                'model' => $registro
            ]);
        }
    }

}

?>