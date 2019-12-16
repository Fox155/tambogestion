<?php

namespace common\models;

use Yii;

class GestorSucursales
{
    /**
     * tsp_alta_sucursal
     */
    public function Alta(Sucursales $sucursal)
    {
        $sql = "call tsp_alta_sucursal( :idtambo, :nombre, :datos)";

        $query = Yii::$app->db->createCommand($sql);
        
        $query->bindValues([
            ':idtambo' => Yii::$app->user->identity->IdTambo,
            ':nombre' => $sucursal->Nombre,
            ':datos' => json_encode([
                'Telefono' => $sucursal->Telefono,
                'Direccion' => $sucursal->Direccion
            ]),
        ]);

        return $query->queryScalar();
    }

    /**
     * tsp_buscar_sucursales
     */
    public function Buscar($Cadena = '')
    {
        $sql = "call tsp_buscar_sucursales( :idtambo, :idusuario, :cadena)";

        $query = Yii::$app->db->createCommand($sql);
        
        $query->bindValues([
            ':idtambo' => Yii::$app->user->identity->IdTambo,
            ':idusuario' => Yii::$app->user->identity->IdUsuario,
            ':cadena' => $Cadena,
        ]);

        return $query->queryAll();
    }

    /**
     * tsp_modificar_sucursal
     */
    public function Modificar(Sucursales $sucursal)
    {
        $sql = "call tsp_modificar_sucursal( :idsucursal, :nombre, :datos)";

        $query = Yii::$app->db->createCommand($sql);
        
        $query->bindValues([
            ':idsucursal' => $sucursal->IdSucursal,
            ':nombre' => $sucursal->Nombre,
            ':datos' => json_encode([
                'Telefono' => $sucursal->Telefono,
                'Direccion' => $sucursal->Direccion
            ]),
        ]);

        return $query->queryScalar();
    }

    /**
     * tsp_borrar_sucursal
     */
    public function Borrar(Sucursales $sucursal)
    {
        $sql = "call tsp_borrar_sucursal(:idsucursal)";

        $query = Yii::$app->db->createCommand($sql);
        
        $query->bindValues([
            ':idsucursal' => $sucursal->IdSucursal,
        ]);

        return $query->queryScalar();
    }
}