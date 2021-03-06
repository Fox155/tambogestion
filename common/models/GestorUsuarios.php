<?php

namespace common\models;

use Yii;

class GestorUsuarios
{
    /**
     * tsp_alta_usuario
     */
    public function Alta(Usuarios $usuario)
    {
        $sql = "call tsp_alta_usuario( :token, :idtipo, :usuario, :pass, :email)";

        $query = Yii::$app->db->createCommand($sql);
        
        $query->bindValues([
            ':token' => Yii::$app->user->identity->Token,
            ':idtipo' => $usuario->IdTipoUsuario,
            ':usuario' => $usuario->Usuario,
            ':email' => $usuario->Email,
            ':pass' => md5($usuario->Password),
        ]);

        return $query->queryScalar();
    }

    /**
     * tsp_buscar_usuarios
     */
    public function Buscar($Tipo = 0 ,$Estado = 'A', $Cadena = '')
    {
        $sql = "call tsp_buscar_usuarios( :idtambo, :cadena, :estado, :tipo)";

        $query = Yii::$app->db->createCommand($sql);
        
        $query->bindValues([
            ':idtambo' => Yii::$app->session->get('IdTambo'),
            ':tipo' => $Tipo,
            ':estado' => $Estado,
            ':cadena' => $Cadena,
        ]);

        return $query->queryAll();
    }

    /**
     * tsp_modificar_usuario
     */
    public function Modificar(Usuarios $usuario)
    {
        $sql = "call tsp_modificar_usuario( :token, :idusuario, :tipo, :email )";

        $query = Yii::$app->db->createCommand($sql);
        
        $query->bindValues([
            ':token' => Yii::$app->user->identity->Token,
            ':tipo' => $usuario->IdTipoUsuario,
            ':idusuario' => $usuario->IdUsuario,
            ':email' => $usuario->Email,
        ]);

        return $query->queryScalar();
    }

    /**
     * tsp_borra_usuario
     */
    public function Borrar(Lotes $lote)
    {
        $sql = "call tsp_borra_usuario(:token, :idusuario)";

        $query = Yii::$app->db->createCommand($sql);
        
        $query->bindValues([
            ':token' => Yii::$app->user->identity->Token,
            ':idusuario' => $usuario->IdUsuario,
        ]);

        return $query->queryScalar();
    }
}