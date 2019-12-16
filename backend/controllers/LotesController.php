<?php

namespace backend\controllers;

use common\models\Usuarios;
use common\models\Sucursales;
use common\models\Lotes;
use common\models\GestorLotes;
use common\models\GestorSucursales;
use common\models\forms\BusquedaForm;
use Yii;
use yii\web\Controller;
use yii\helpers\Url;
use common\components\TiposUsuarioHelper;

class LotesController extends Controller
{
    public function actionIndex($id)
    {
        $busqueda = new BusquedaForm();

        if ($busqueda->load(Yii::$app->request->post()) && $busqueda->validate()) {
            $cadena = $busqueda->Cadena ? $busqueda->Cadena : '';
            $incluye = $busqueda->Check ? $busqueda->Check : 'N';
            $lotes = GestorLotes::Buscar($id, $incluye, $cadena);
        } else {
            $lotes =  GestorLotes::Buscar($id);
        }

        $sucursal = new Sucursales();
        if($id != 0){
            $sucursal->IdSucursal = $id;
            $sucursal->Dame();
            $anterior = [
                'label' => "Sucursales",
                'link' => Url::to(['/sucursales'])
            ];
        }else{
            $anterior = [];
        }

        return $this->render('index', [
            'models' => $lotes,
            'busqueda' => $busqueda,
            'sucursal' => $sucursal,
            'anterior' => $anterior,
        ]);
    }

    public function actionAlta($id)
    {
        TiposUsuarioHelper::verificarAdministrador();

        $lotes = new Lotes();
        // $lotes->IdSucursal = $id;

        $lotes->setScenario(Lotes::_ALTA);

        if($lotes->load(Yii::$app->request->post()) && $lotes->validate()){
            $resultado = GestorLotes::Alta($lotes);

            Yii::$app->response->format = 'json';
            if (substr($resultado, 0, 2) == 'OK') {
                return ['error' => null];
            } else {
                return ['error' => $resultado];
            }
        }else {
            $sucursales = 0;
            if($id == 0){
                $sucursales = GestorSucursales::Buscar();
            }else{
                $lotes->IdSucursal = $id;
            }

            return $this->renderAjax('alta', [
                'titulo' => 'Alta Lote',
                'model' => $lotes,
                'sucursales' => $sucursales,
            ]);
        }
    }

    public function actionEditar($id, $idL)
    {
        TiposUsuarioHelper::verificarAdministrador();
        
        $lote = new Lotes();
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
        TiposUsuarioHelper::verificarAdministrador();

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

    public function actionDarBaja($id)
    {
        TiposUsuarioHelper::verificarAdministrador();
        
        $request = Yii::$app->request;

        if ($request->isGet)  {
            return $this->renderAjax('@app/views/common/confirmar-baja', [
                'objeto' => 'al lote',
            ]);
        }

        Yii::$app->response->format = 'json';
        
        $lote = new Lotes();
        $lote->IdLote = $id;

        $resultado = $lote->DarBaja();

        if ($resultado == 'OK') {
            return ['error' => null];
        } else {
            return ['error' => $resultado];
        }
    }
    
    public function actionDetalle($id)
    {
        $busqueda = new BusquedaForm();
        
        $lote = new Lotes();
        $lote->IdLote = $id;
        
        $lote->Dame();
        
        $producciones = $lote->ResumenProducciones();

        return $this->render('detalle', [
            'titulo' => 'Detalle Vaca',
            'model' => $lote,
            'busqueda' => $busqueda,
            'producciones' => $producciones
        ]);
    }
}

?>