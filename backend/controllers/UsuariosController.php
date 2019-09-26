<?php

namespace backend\controllers;

use common\models\Usuarios;
use common\models\GestorUsuarios;
use common\models\GestorTipoUsuario;
use common\models\forms\BuscarForm;
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

        // $this->layout = 'login';

        if ($usuario->load(Yii::$app->request->post()) && $usuario->validate()) {
            $login = $usuario->Login('A', $usuario->Password, Yii::$app->security->generateRandomString(300));

            if ($login['Mensaje'] == 'OK') {
                Yii::$app->user->login($usuario);
                Yii::$app->session->set('Token', $usuario->Token);
                Yii::$app->session->set('TipoUsuario', $usuario->Tipo);
                Yii::$app->session->set('IdTambo', $usuario->IdTambo);

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
        }

        return $this->render('login', [
            'model' => $usuario,
        ]);
    }

    public function actionLogout()
    {
        Yii::$app->user->identity->Logout();
        Yii::$app->user->logout();
        return $this->goHome();
    }

    public function actionIndex()
    {
        // $busqueda = new BuscarForm();

        // if ($busqueda->load(Yii::$app->request->post()) && $busqueda->validate()) {
        //     $tipo = $busqueda->Combo ? $busqueda->Combo : 'T';
        //     $estado = $busqueda->Combo2 ? $busqueda->Combo2 : 'A';
        //     $clientes = $gestor->Buscar($busqueda->Cadena, $tipo, $estado);
        // } else {
        //     $clientes = $gestor->Buscar();
        // }

        $usuarios = GestorUsuarios::Buscar();

        return $this->render('index', [
            'models' => $usuarios
            // 'busqueda' => $busqueda
        ]);
    }

    public function actionAlta()
    {
        PermisosHelper::verificarPermiso('AltaCliente');

        $cliente = new Clientes();

        $cliente->Tipo = Yii::$app->request->get('Tipo');

        if ($cliente->Tipo == 'F') {
            $cliente->setScenario(Clientes::_ALTA_FISICA);
        } else {
            $cliente->setScenario(Clientes::_ALTA_JURIDICA);
        }

        $listas = GestorListasPrecio::Buscar();

        if ($cliente->load(Yii::$app->request->post()) && $cliente->validate()) {
            $gestor = new GestorClientes();
            $resultado = $gestor->Alta($cliente);

            Yii::$app->response->format = 'json';
            if (substr($resultado, 0, 2) == 'OK') {
                return ['error' => null];
            } else {
                return ['error' => $resultado];
            }
        } else {
            return $this->renderAjax('alta', [
                'titulo' => 'Alta Cliente',
                'model' => $cliente,
                'listas' => $listas
            ]);
        }
    }

    public function actionEditar($id)
    {
        PermisosHelper::verificarPermiso('ModificarCliente');
        
        $cliente = new Clientes();

        $clienteAux = new Clientes();
        $clienteAux->IdCliente = $id;
        $clienteAux->Dame();
        if ($clienteAux->Tipo == 'F') {
            $cliente->setScenario(Clientes::_MODIFICAR_FISICA);
        } else {
            $cliente->setScenario(Clientes::_MODIFICAR_JURIDICA);
        }
        
        $listas = GestorListasPrecio::Buscar();

        if ($cliente->load(Yii::$app->request->post()) && $cliente->validate()) {
            $gestor = new GestorClientes();
            $resultado = $gestor->Modificar($cliente);

            Yii::$app->response->format = 'json';
            if ($resultado == 'OK') {
                return ['error' => null];
            } else {
                return ['error' => $resultado];
            }
        } else {
            return $this->renderAjax('alta', [
                        'titulo' => 'Editar Cliente',
                        'model' => $clienteAux,
                        'listas' => $listas
            ]);
        }
    }

    public function actionBorrar($id)
    {
        PermisosHelper::verificarPermiso('BorrarCliente');

        Yii::$app->response->format = 'json';
        
        $cliente = new Clientes();
        $cliente->IdCliente = $id;

        $gestor = new GestorClientes();

        $resultado = $gestor->Borrar($cliente);

        if ($resultado == 'OK') {
            return ['error' => null];
        } else {
            return ['error' => $resultado];
        }
    }

    public function actionActivar($id)
    {
        PermisosHelper::verificarPermiso('ActivarCliente');

        Yii::$app->response->format = 'json';
        
        $cliente = new Clientes();
        $cliente->IdCliente = $id;

        $resultado = $cliente->Activar();

        if ($resultado == 'OK') {
            return ['error' => null];
        } else {
            return ['error' => $resultado];
        }
    }

    public function actionDarBaja($id)
    {
        PermisosHelper::verificarPermiso('DarBajaCliente');

        Yii::$app->response->format = 'json';
        
        $cliente = new Clientes();
        $cliente->IdCliente = $id;

        $resultado = $cliente->DarBaja();

        if ($resultado == 'OK') {
            return ['error' => null];
        } else {
            return ['error' => $resultado];
        }
    }
}
?>