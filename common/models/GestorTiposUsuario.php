<?php

namespace common\models;

use Yii;

class GestorTiposUsuario
{
    /**
     * tsp_buscar_sucursales
     */
    public function Listar()
    {
        $sql = "call tsp_listar_tipos_usuario()";

        $query = Yii::$app->db->createCommand($sql);

        return $query->queryAll();
    }
}