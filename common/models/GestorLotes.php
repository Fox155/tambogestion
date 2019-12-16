<?php

namespace common\models;

use Yii;

class GestorLotes
{
    /**
     * tsp_alta_lote
     */
    public function Alta(Lotes $lote)
    {
        $sql = "call tsp_alta_lote( :idsucursal, :nombre)";

        $query = Yii::$app->db->createCommand($sql);
        
        $query->bindValues([
            ':idsucursal' => $lote->IdSucursal,
            ':nombre' => $lote->Nombre,
        ]);

        return $query->queryScalar();
    }

    /**
     * tsp_buscar_lotes
     */
    public function Buscar($IdSucursal, $Incluye = 'N', $Cadena = '')
    {
        $sql = "call tsp_buscar_lotes( :idsucursal, :idtambo, :idusuario, :incluye, :cadena)";

        $query = Yii::$app->db->createCommand($sql);
        
        $query->bindValues([
            ':idtambo' => Yii::$app->user->identity->IdTambo,
            ':idsucursal' => $IdSucursal,
            ':idusuario' => Yii::$app->user->identity->IdUsuario,
            ':incluye' => $Incluye,
            ':cadena' => $Cadena,
        ]);

        return $query->queryAll();
    }

    /**
     * tsp_modificar_lote
     */
    public function Modificar(Lotes $lote)
    {
        $sql = "call tsp_modificar_lote( :idlote, :nombre)";

        $query = Yii::$app->db->createCommand($sql);
        
        $query->bindValues([
            ':idlote' => $lote->IdLote,
            ':nombre' => $lote->Nombre,
        ]);

        return $query->queryScalar();
    }

    /**
     * tsp_borrar_lote
     */
    public function Borrar(Lotes $lote)
    {
        $sql = "call tsp_borrar_lote(:idlote)";

        $query = Yii::$app->db->createCommand($sql);
        
        $query->bindValues([
            ':idlote' => $lote->IdLote,
        ]);

        return $query->queryScalar();
    }
}