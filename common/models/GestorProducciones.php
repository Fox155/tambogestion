<?php

namespace common\models;

use common\components\FechaHelper;
use Yii;

class GestorProducciones
{
    public function Alta(Producciones $produccion)
    {
        $sql = "call tsp_alta_produccion( :IdSesion, :IdVaca, :NroLactancia, :Produccion, :FechaInicio, :FechaFin, :Medidor)";

        $query = Yii::$app->db->createCommand($sql);

        $query->bindValues([
            ':IdSesion' => $produccion->IdSesionOrdeño,
            ':IdVaca' => $produccion->IdVaca,
            ':NroLactancia' => $produccion->NroLactancia,
            ':Produccion' => $produccion->Produccion,
            ':FechaInicio' => FechaHelper::toDatetimeMysql($produccion->FechaInicio),
            ':FechaFin' => FechaHelper::toDatetimeMysql($produccion->FechaFin),
            ':Medidor' => json_encode([
                'Nombre' => $produccion->Medidor ?? "",
            ]),
        ]);

        return $query->queryScalar();
    }
}