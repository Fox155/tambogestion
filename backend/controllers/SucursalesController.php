<?php

namespace backend\controllers;

use common\models\Usuarios;
use common\models\UsuariosSucursales;
use common\models\Sucursales;
use common\models\GestorSucursales;
use common\models\GestorUsuarios;
use common\models\RegistrosLeche;
use common\models\forms\BusquedaForm;
use common\components\FechaHelper;
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
        if (Yii::$app->request->isGet)  {
            return $this->renderAjax('@app/views/common/confirmar-baja', [
                'objeto' => 'la sucursal',
            ]);
        }

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

        $busqueda = new BusquedaForm();

        if ($busqueda->load(Yii::$app->request->post()) && $busqueda->validate()) {
            $inicio = $busqueda->FechaInicio ? FechaHelper::toDateMysql($busqueda->FechaInicio) : NULL;
            $fin = $busqueda->FechaFin ? FechaHelper::toDateMysql($busqueda->FechaFin) : NULL;
            $registros = $sucursal->BuscarRegistros($inicio,$fin);
        } else {
            $registros = $sucursal->BuscarRegistros();
        }

        $resumen = $sucursal->ResumenRegistrosLeche(10);

        $usuarios = $sucursal->BuscarUsuarios();

        return $this->render('detalle', [
            'titulo' => 'Detalle Sucursal',
            'model' => $sucursal,
            'busqueda' => $busqueda,
            'registros' => $registros,
            'usuarios' => $usuarios,
            'resumen' => $resumen
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
            $registro->Fecha = date('d/m/Y');
            return $this->renderAjax('alta-registro', [
                'titulo' => 'Alta Registro de Leche Sucursal: '.$sucursal->Nombre,
                'model' => $registro
            ]);
        }
    }

    public function actionBorrarRegistro($id)
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

    public function actionEditarRegistro($id)
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

    public function actionAsignarUsuario($id)
    {
        $usuario = new UsuariosSucursales();
        $usuario->setScenario(UsuariosSucursales::_ALTA);
        $usuario->IdSucursal = $id;

        $sucursal = new Sucursales();
        $sucursal->IdSucursal = $id;

        if($usuario->load(Yii::$app->request->post()) && $usuario->validate()){
            $resultado = $sucursal->AsignarUsuario($usuario);

            Yii::$app->response->format = 'json';
            if (substr($resultado, 0, 2) == 'OK') {
                return ['error' => null];
            } else {
                return ['error' => $resultado];
            }
        }else {
            $sucursal->Dame();

            $usuarios = GestorUsuarios::Buscar();

            return $this->renderAjax('asignar-usuario', [
                'titulo' => 'Asignar Usuario a la Sucursal: '.$sucursal->Nombre,
                'model' => $usuario,
                'usuarios' => $usuarios,
            ]);
        }
    }

    public function actionDesasignarUsuario($idU, $idS)
    {
        // if(Yii::$app->user->identity->IdTambo!='Administrador'){
        //     return;
        // }

        Yii::$app->response->format = 'json';
        
        $usuario = new UsuariosSucursales();
        $usuario->IdUsuario = $idU;
        $usuario->IdSucursal = $idS;

        $resultado = Sucursales::DesasignarUsuario($usuario);

        if ($resultado == 'OK') {
            return ['error' => null];
        } else {
            return ['error' => $resultado];
        }
    }
}

?>