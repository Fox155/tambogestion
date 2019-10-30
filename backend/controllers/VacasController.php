<?php

namespace backend\controllers;

use common\models\Usuarios;
use common\models\Sucursales;
use common\models\Lotes;
use common\models\Vacas;
use common\models\GestorVacas;
use common\models\forms\BusquedaForm;
use Yii;
use yii\web\Controller;
use yii\helpers\Url;

class VacasController extends Controller
{
    public function actionIndex($idS, $idL)
    {
        $busqueda = new BusquedaForm();

        if ($busqueda->load(Yii::$app->request->post()) && $busqueda->validate()) {
            $cadena = $busqueda->Cadena ? $busqueda->Cadena : '';
            $incluye = $busqueda->Check ? $busqueda->Check : 'N';
            $vacas = GestorVacas::Buscar($idS, $idL, $incluye, $cadena);
        } else {
            $vacas =  GestorVacas::Buscar($idS, $idL);
        }

        $sucursal = new Sucursales();
        $sucursal->IdSucursal = $idS;
        $sucursal->Dame();

        $lote = new Lotes();
        if($idL != 0){
            $lote->IdLote = $idL;
            $lote->Dame();
            $anterior = [
                'label' => "Lotes de la sucursal: " . $sucursal->Nombre,
                'link' => Url::to(['/lotes', 'id' => $idS])
            ];
        }else{
            $anterior = [
                'label' => "Sucursales",
                'link' => Url::to(['/sucursales'])
            ];
        }

        return $this->render('index', [
            'models' => $vacas,
            'busqueda' => $busqueda,
            'sucursal' => $sucursal,
            'anterior' => $anterior,
            'lote' => $lote
        ]);
    }

    public function actionAlta($idS, $idL)
    {
        // if(Yii::$app->user->identity->IdTambo!='Administrador'){
        //     return;
        // }

        $vaca = new Vacas();
        $vaca->IdSucursal = $idS;
        $vaca->setScenario(Vacas::_ALTA);

        if($vaca->load(Yii::$app->request->post()) /*&& $vaca->validate()*/){
            $resultado = GestorVacas::Alta($vaca);

            Yii::$app->response->format = 'json';
            if (substr($resultado, 0, 2) == 'OK') {
                return ['error' => null];
            } else {
                return ['error' => $resultado];
            }
        }else {
            $lotes = 0;
            if($idL == 0){
                $sucursal = new Sucursales();
                $sucursal->IdSucursal = $idS;
                $lotes = $sucursal->ListarLotes();
            }else{
                $vaca->IdLote = $idL;
            }

            return $this->renderAjax('alta', [
                'titulo' => 'Alta Vaca',
                'lotes' => $lotes,
                'model' => $vaca
            ]);
        }
    }

    public function actionEditar($id,$idS)
    {
       
        $vacas = new Vacas();
        $vacas->IdSucursal = $idS;
        $vacas->setScenario(Vacas::_MODIFICAR);

        if ($vacas->load(Yii::$app->request->post()) && $vacas->validate()) {
            $resultado = GestorVacas::Modificar($vacas);

            Yii::$app->response->format = 'json';
            if ($resultado == 'OK') {
                return ['error' => null];
            } else {
                return ['error' => $resultado];
            }
        } else {
            $vacas->IdVaca = $id;
            $vacas->Dame();
            
               
            $sucursal = new Sucursales();
            $sucursal->IdSucursal = $idS;
            $lotes = $sucursal->ListarLotes();
            

            return $this->renderAjax('alta', [
                'titulo' => 'Modificar Vaca',
                'model' => $vacas,
                'lotes' => $lotes
            ]);
        }
    }


    public function actionBorrar($id)
    {
        // if(Yii::$app->user->identity->IdTambo!='Administrador'){
        //     return;
        // }

        Yii::$app->response->format = 'json';
        
        $vaca= new Vacas();
        $vaca->IdVaca = $id;

        $resultado = GestorVacas::Borrar($vaca);

        if ($resultado == 'OK') {
            return ['error' => null];
        } else {
            return ['error' => $resultado];
        }
    }
    
    public function actionDetalle($id)
    {
        $busqueda = new BusquedaForm();
        
        $vaca = new Vacas();
        $vaca->IdVaca = $id;
        
        $vaca->Dame();
        
        $lactancias = $vaca->ListarLactancias();

        if ($busqueda->load(Yii::$app->request->post()) && $busqueda->validate()) {
            $cadena = $busqueda->Cadena ? $busqueda->Cadena : '';
            $incluye = $busqueda->Check ? $busqueda->Check : 'N';
            $vacas = GestorVacas::Buscar($idS, $idL, $incluye, $cadena);
        } else {
            $vacas =  GestorVacas::Buscar($idS, $idL);
        }
        
        $producciones = $vaca->ListarProduccionesUltLac();

        return $this->render('detalle', [
            'titulo' => 'Detalle Vaca',
            'model' => $vaca,
            'busqueda' => $busqueda,
            'lactancias' => $lactancias,
            'producciones' => $producciones
        ]);
    }

}

?>