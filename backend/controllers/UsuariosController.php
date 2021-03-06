<?php

namespace backend\controllers;

use common\models\Usuarios;
use common\models\GestorUsuarios;
use common\models\GestorTiposUsuario;
use common\models\forms\BusquedaForm;
// use common\models\forms\AuditoriaForm;
// use common\components\PermisosHelper;
use common\components\TiposUsuarioHelper;
use Yii;
use yii\web\Controller;
use yii\data\Pagination;
use yii\helpers\ArrayHelper;

class UsuariosController extends Controller
{
    public function actionLogin()
    {
        // Si ya estoy logueado redirecciona al home
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        // Guardo también en la sesión los parámetros de Empresa
        // $empresa = new Empresa();
        // Yii::$app->session->open();

        $usuario = new Usuarios();
        $usuario->setScenario(Usuarios::_LOGIN);

        $busqueda = new BusquedaForm();

        if ($usuario->load(Yii::$app->request->post()) && $usuario->validate()) {
            $login = $usuario->Login('A', $usuario->Password, Yii::$app->security->generateRandomString(300));

            if ($login['Mensaje'] == 'OK') {
                Yii::$app->user->login($usuario);
                Yii::$app->session->set('Token', $usuario->Token);
                $usuario->Dame();
                Yii::$app->session->set('TipoUsuario', $usuario->TipoUsuario);
                Yii::$app->session->set('IdTambo', $usuario->IdTambo);
                Yii::$app->session->set('IdsSucursales', $usuario->IdsSucursales);

                //Guardo los permisos del tipo de usuario
                //TiposUsuarioHelper::guardarPermisosTipoUsuarioSesion($usuario->DamePermisos());

                // El usuario debe modificar el password
                // if ($usuario->Estado == 'C') {
                //     Yii::$app->session->setFlash('info', 'Debe modificar su contraseña antes de ingresar.');
                //     return $this->redirect('/usuarios/cambiar-password');
                // } else {
                //     return $this->redirect(Yii::$app->user->returnUrl);
                // }
            } else {
                $usuario->Password = null;
                Yii::$app->session->setFlash('danger', $login['Mensaje']);
            }

            return $this->goHome();
        }

        return $this->render('login', [
            'model' => $usuario,
            'busqueda' => $busqueda,
        ]);
    }

    public function actionLogout()
    {
        $request = Yii::$app->request;

        if ($request->isGet)  {
            return $this->renderAjax('logout', []);
        }

        Yii::$app->user->identity->Logout();
        Yii::$app->user->logout();
        return $this->goHome();
    }

    public function actionIndex()
    {
        $busqueda = new BusquedaForm();

        if ($busqueda->load(Yii::$app->request->post()) && $busqueda->validate()) {
            $tipo = $busqueda->Combo ? $busqueda->Combo : 0;
            $estado = $busqueda->Combo2 ? $busqueda->Combo2 : 'A';
            $usuarios = GestorUsuarios::Buscar($tipo, $estado, $busqueda->Cadena);
        } else {
            $usuarios = GestorUsuarios::Buscar();
        }

        return $this->render('index', [
            'models' => $usuarios,
            'busqueda' => $busqueda
        ]);
    }

    public function actionAlta()
    {
        $usuario = new Usuarios();
        $usuario->setScenario(Usuarios::_ALTA);

        if ($usuario->load(Yii::$app->request->post()) && $usuario->validate()) {
            $resultado = GestorUsuarios::Alta($usuario);

            Yii::$app->response->format = 'json';
            if (substr($resultado, 0, 2) == 'OK') {
                return ['error' => null];
            } else {
                return ['error' => $resultado];
            }
        } else {
            $tipos = GestorTiposUsuario::Listar();

            return $this->renderAjax('alta', [
                'titulo' => 'Alta Usuario',
                'model' => $usuario,
                'tipos' => $tipos
            ]);
        }
    }

    public function actionEditar($id)
    {
        $usuario = new Usuarios();
        
        $usuario->setScenario(Usuarios::_MODIFICAR);
        
        if ($usuario->load(Yii::$app->request->post()) && $usuario->validate()) {
            $resultado = GestorUsuarios::Modificar($usuario);
            
            Yii::$app->response->format = 'json';
            if ($resultado == 'OK') {
                return ['error' => null];
            } else {
                return ['error' => $resultado];
            }
        } else {
            $usuario->IdUsuario = $id;
            $usuario->Dame();
            $tipos = GestorTiposUsuario::Listar();

            return $this->renderAjax('alta', [
                'titulo' => 'Modificar Usuario',
                'model' => $usuario,
                'tipos' => $tipos
            ]);
        }
    }

    public function actionBorrar($id)
    {
        Yii::$app->response->format = 'json';
        
        $usuario = new Usuarios();
        $usuario->IdUsuario = $id;

        $resultado = GestorUsuarios::Borrar($usuario);

        if ($resultado == 'OK') {
            return ['error' => null];
        } else {
            return ['error' => $resultado];
        }
    }

    public function actionActivar($id)
    {
        Yii::$app->response->format = 'json';
        
        $usuario = new Usuarios();
        $usuario->IdUsuario = $id;

        $resultado = $usuario->Activar();

        if ($resultado == 'OK') {
            return ['error' => null];
        } else {
            return ['error' => $resultado];
        }
    }

    public function actionDarBaja($id)
    {
        Yii::$app->response->format = 'json';
        
        $usuario = new Usuarios();
        $usuario->IdUsuario = $id;

        $resultado = $usuario->DarBaja();

        if ($resultado == 'OK') {
            return ['error' => null];
        } else {
            return ['error' => $resultado];
        }
    }
}
?>