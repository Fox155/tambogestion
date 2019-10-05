<?php

namespace common\models;

use Yii;

class GestorVacas
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
     * tsp_buscar_vacas
     */
    public function Buscar($IdSucursal, $IdLote, $Incluye = 'N', $Cadena = '')
    {
        $sql = "call tsp_buscar_vacas( :idsucursal, :idlote, :cadena, :incluye)";

        $query = Yii::$app->db->createCommand($sql);
        
        $query->bindValues([
            // ':idtambo' => Yii::$app->user->identity->IdTambo,
            ':idsucursal' => $IdSucursal,
            ':idlote' => $IdLote,
            ':incluye' => $Incluye,
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