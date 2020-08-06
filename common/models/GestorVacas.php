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
        $sql = "call tsp_alta_vaca( :idcaravana, :idrfid, :idlote, :nombre, :raza, :peso, :fechanac, :observaciones, :fechaingreso, :estado)";

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
    public function Buscar($IdSucursal, $IdLote, $Incluye = 'N', $Vendidas = 'N', $Cadena = '')
    {
        $sql = "call tsp_buscar_vacas( :idsucursal, :idlote, :cadena, :incluye, :vendidas)";

        $query = Yii::$app->db->createCommand($sql);
        
        $query->bindValues([
            // ':idtambo' => Yii::$app->user->identity->IdTambo,
            ':idsucursal' => $IdSucursal,
            ':idlote' => $IdLote,
            ':incluye' => $Incluye,
            ':vendidas' => $Vendidas,
            ':cadena' => $Cadena,
        ]);

        return $query->queryAll();
    }

    /**
     * tsp_modificar_vaca
     */
    public function Modificar(Vacas $vaca)
    {
        $sql = "call tsp_modificar_vaca(:idvaca,:idcaravana, :idrfid ,:nombre,:raza,:peso,:fechanac,:observaciones)";
        $query = Yii::$app->db->createCommand($sql);
        
        $query->bindValues([
            ':idvaca' => $vaca->IdVaca,
            ':idcaravana' => $vaca->IdCaravana,
            ':idrfid' => $vaca->IdRFID, 
            ':nombre' => $vaca->Nombre,
            ':raza' => $vaca->Raza,
            ':peso'  => $vaca->Peso,
            ':fechanac' => $vaca->FechaNac,
            ':observaciones' => $vaca->Observaciones
        ]);

        return $query->queryScalar();
    }

    /**
     * tsp_borrar_vaca
     */
    public function Borrar(Vacas $vaca)
    {
        $sql = "call tsp_borrar_vaca(:idvaca)";

        $query = Yii::$app->db->createCommand($sql);
        
        $query->bindValues([
            ':idvaca' => $vaca->IdVaca,
        ]);

        return $query->queryScalar();
    }
}