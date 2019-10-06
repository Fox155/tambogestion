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

    public function actionEditar($id)
    {
        // if(Yii::$app->user->identity->IdTambo!='Administrador'){
        //     return;
        // }
        
        $vaca = new Vacas();
        $lote->IdSucursal = $id;

        $lote->setScenario(Lotes::_MODIFICAR);

        if ($lote->load(Yii::$app->request->post()) && $lote->validate()) {
            $resultado = GestorLotes::Modificar($lote);

            Yii::$app->response->format = 'json';
            if ($resultado == 'OK') {
                return ['error' => null];
            } else {
                return ['error' => $resultado];
            }
        } else {
            $lote->IdLote = $idL;
            $lote->Dame();

            return $this->renderAjax('alta', [
                'titulo' => 'Modificar Lote',
                'model' => $lote
            ]);
        }
    }

    public function actionBorrar($id)
    {
        // if(Yii::$app->user->identity->IdTambo!='Administrador'){
        //     return;
        // }

        Yii::$app->response->format = 'json';
        
        $lote = new Lotes();
        $lote->IdLote = $id;

        $resultado = GestorLotes::Borrar($lote);

        if ($resultado == 'OK') {
            return ['error' => null];
        } else {
            return ['error' => $resultado];
        }
    }    
}

?>