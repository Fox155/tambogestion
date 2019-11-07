<?php

namespace backend\controllers;

use common\models\Usuarios;
use common\models\ListasPrecio;
use common\models\GestorListasPrecio;
use common\models\forms\BusquedaForm;
use Yii;
use yii\web\Controller;
use yii\data\Pagination;

class ListasPrecioController extends Controller
{
    public function actionIndex()
    {
        $busqueda = new BusquedaForm();

        $gestor = new GestorListasPrecio();

        if ($busqueda->load(Yii::$app->request->post()) && $busqueda->validate()) {
            $cadena = $busqueda->Cadena ? $busqueda->Cadena : '';
            $incluye = $busqueda->Check ? $busqueda->Check : 'N';
            $ListasPrecio = $gestor->Buscar($incluye, $cadena);
        } else {
            $ListasPrecio = $gestor->Buscar();
        }

        return $this->render('index', [
            'models' => $ListasPrecio,
            'busqueda' => $busqueda
        ]);
    }

    public function actionAlta()
    {
        // if(Yii::$app->user->identity->IdTambo!='Administrador'){
        //     return;
        // }

        $listasprecio = new ListasPrecio();

        $listasprecio ->setScenario(ListasPrecio::_ALTA);

        if($listasprecio->load(Yii::$app->request->post()) && $listasprecio->validate()){
            $resultado = GestorListasPrecio::Alta($listasprecio);

            Yii::$app->response->format = 'json';
            if (substr($resultado, 0, 2) == 'OK') {
                return ['error' => null];
            } else {
                return ['error' => $resultado];
            }
        }else {
            return $this->renderAjax('alta', [
                'titulo' => 'Alta Listas Precio',
                'model' => $listasprecio
            ]);
        }
    }

    public function actionEditar($id)
    {
        // if(Yii::$app->user->identity->IdTambo!='Administrador'){
        //     return;
        // }
        
        $listasprecio = new ListasPrecio();

        $listasprecio ->setScenario(ListasPrecio::_MODIFICAR);

        if ($listasprecio->load(Yii::$app->request->post()) && $listasprecio->validate()) {
            $resultado = GestorListasPrecio::Modificar($listasprecio);

            Yii::$app->response->format = 'json';
            if ($resultado == 'OK') {
                return ['error' => null];
            } else {
                return ['error' => $resultado];
            }
        } else {
            $listasprecio->IdListaPrecio = $id;
            
            $listasprecio->Dame();

            return $this->renderAjax('alta', [
                'titulo' => 'ModificarListasPrecio',
                'model' => $listasprecio
            ]);
        }
    }

    public function actionBorrar($id)
    {
        Yii::$app->response->format = 'json';
        
        $listasprecio = new ListasPrecio();
        $listasprecio->IdListaPrecio = $id;

        $resultado = GestorListasPrecio::Borrar($listasprecio);

        if ($resultado == 'OK') {
            return ['error' => null];
        } else {
            return ['error' => $resultado];
        }
    }
    
    public function actionHistorico($id)
    {       
        $listaprecio = new ListasPrecio();
        $listaprecio->IdListaPrecio = $id;

        $historicos = $listaprecio->Historico();

        return $this->renderAjax('historico', [
            'titulo' => 'Detalle Venta',
            'models' => $historicos,
            'lista' => $listaprecio,
        ]);
    }
}

?>