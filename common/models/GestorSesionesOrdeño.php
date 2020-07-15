<?php

namespace common\models;

use Yii;

class GestorSesionesOrdeño
{
    public function Alta(SesionesOrdeño $sesion)
    {
        $sql = "call tsp_alta_sesionordeño( :IdSucursal, :Fecha, :Observaciones)";

        $query = Yii::$app->db->createCommand($sql);

        $query->bindValues([
            ':IdSucursal' => $sesion->IdSucursal,
            ':Fecha' => $sesion->Fecha,
            ':Observaciones' => $sesion->Observaciones,
        ]);

        return $query->queryScalar();
    }
}
