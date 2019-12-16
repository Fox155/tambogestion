<?php

namespace backend\controllers;

use common\models\Usuarios;
use common\models\Sucursales;
use common\models\Lotes;
use common\models\Vacas;
use common\models\GestorLotes;
use common\models\GestorVacas;
use common\models\forms\BusquedaForm;
use common\models\forms\LactanciaForm;
use common\components\FechaHelper;
use common\components\TiposUsuarioHelper;
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
            $vendidas = $busqueda->Check2 ? $busqueda->Check2 : 'N';
            $vacas = GestorVacas::Buscar($idS, $idL, $incluye, $vendidas, $cadena);
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
            $anterior = array();
            $anterior = [
                [
                    'label' => "Sucursales",
                    'link' => Url::to(['/sucursales'])
                ],
                [
                    'label' => "Lotes de la sucursal: " . $sucursal->Nombre,
                    'link' => Url::to(['/lotes', 'id' => $idS])
                ],
            ];
        }else{
            $anterior = array();
            $anterior = [
                [
                    'label' => "Sucursales",
                    'link' => Url::to(['/sucursales'])
                ]
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
        $vaca = new Vacas();
        $vaca->IdSucursal = $idS;
        $vaca->setScenario(Vacas::_ALTA);

        if($vaca->load(Yii::$app->request->post()) /*&& $vaca->validate()*/){
            $vaca->FechaIngreso = FechaHelper::toDateMysql($vaca->FechaIngreso);
            $vaca->FechaNac = FechaHelper::toDateMysql($vaca->FechaNac);

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
                $lotes =  GestorLotes::Buscar($idS);
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
            $vaca->FechaNac = FechaHelper::toDateMysql($vaca->FechaNac);
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
            $vacas->FechaNac = FechaHelper::toDateLocal($vacas->FechaNac);
               
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

    public function actionEstado($id)
    {
        $vacas = new Vacas();
        $vacas->IdVaca = $id;
        $vacas->setScenario(Vacas::_ESTADO);

        if ($vacas->load(Yii::$app->request->post()) && $vacas->validate()) {
            $resultado = $vacas->CambiarEstado();

            Yii::$app->response->format = 'json';
            if ($resultado == 'OK') {
                return ['error' => null];
            } else {
                return ['error' => $resultado];
            }
        } else {
            $vacas->Dame();

            return $this->renderAjax('cambiar', [
                'titulo' => 'Cambiar Estado a la Vaca',
                'model' => $vacas,
            ]);
        }
    }

    public function actionLote($id)
    {
        $vacas = new Vacas();
        $vacas->IdVaca = $id;
        $vacas->setScenario(Vacas::_LOTE);

        if ($vacas->load(Yii::$app->request->post()) && $vacas->validate()) {
            $resultado = $vacas->CambiarLote();

            Yii::$app->response->format = 'json';
            if ($resultado == 'OK') {
                return ['error' => null];
            } else {
                return ['error' => $resultado];
            }
        } else {
            $vacas->Dame();
            $lotes =  GestorLotes::Buscar(0);

            return $this->renderAjax('cambiar', [
                'titulo' => 'Cambiar Lote a la Vaca',
                'model' => $vacas,
                'lotes' => $lotes,
            ]);
        }
    }


    public function actionBorrar($id)
    {
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
        
        $lactancias = $vaca->ListarResumenLactancias();
        $producciones = 0;

        return $this->render('detalle', [
            'titulo' => 'Detalle Vaca',
            'model' => $vaca,
            'busqueda' => $busqueda,
            'lactancias' => $lactancias,
            'producciones' => $producciones
        ]);
    }

    public function actionLactancia($id)
    {
        $vacas = new Vacas();
        $vacas->IdVaca = $id;
        $vacas->Dame();

        $lactancia = new LactanciaForm();

        if($vacas->Estado == 'SECA'){
            $lactancia->setScenario(LactanciaForm::_ALTA);
            $vacas->Estado = 'LACTANTE';
            $titulo = "Nueva Lactancia";
        }else if ($vacas->Estado == 'LACTANTE'){
            $lactancia->setScenario(LactanciaForm::_FINALIZA);
            $vacas->Estado = 'SECA';
            $titulo = "Finalizar Lactancia";
        }else{
            return [];
        }
        
        if ($lactancia->load(Yii::$app->request->post()) && $lactancia->validate()) {
            $resultado = $vacas->CambiarEstado();

            Yii::$app->response->format = 'json';
            if ($resultado == 'OK') {
                return ['error' => null];
            } else {
                return ['error' => $resultado];
            }
        } else {
            return $this->renderAjax('lactancia', [
                'titulo' => $titulo,
                'model' => $vacas,
                'lactancia' => $lactancia,
            ]);
        }
    }

}

?>