<?php

namespace common\models;

use Yii;

class GestorUsuarios
{
    /**
     * tsp_alta_vaca
     */
    public function Alta(Vacas $vaca)
    {
        $sql = "call tsp_alta_vaca( :idcaravana, :idrfid, :nombre, :raza, :peso, :fechanac, :observaciones, :idlote, :fechaingreso, :estado)";

        $query = Yii::$app->db->createCommand($sql);
        
        $query->bindValues([
            ':idcaravana' => $vaca->IdCaravana,
            ':idrfid' => $vaca->IdRFID,
            ':nombre' => $vaca->Nombre,
            ':raza' => $vaca->Raza,
            ':peso' => $vaca->Peso === '' ? 0 : $vaca->Peso,
            ':fechanac' => $vaca->FechaNac,
            ':observaciones' => $vaca->Observaciones,
            ':idlote' => $vaca->IdLote,
            ':fechaingreso' => $vaca->FechaIngreso,
            ':estado' => $vaca->Estado,
        ]);

        return $query->queryScalar();
    }

    /**
     * xsp_buscar_usuarios
     */
    public function Buscar($Tipo = 0 ,$Estado = 'A', $Cadena = '')
    {
        $sql = "call xsp_buscar_usuarios( :idtambo, :cadena, :estado, :tipo)";

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
     * tsp_modificar_vaca
     */
    public function Modificar(Vacas $vaca)
    {
        $sql = "call tsp_modificar_vaca( :idlote, :nombre)";

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