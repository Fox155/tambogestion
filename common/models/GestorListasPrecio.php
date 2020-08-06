<?php

namespace common\models;

use Yii;

class GestorListasPrecio
{
    /**
     * tsp_alta_listaprecio
     */
    public function Alta(ListasPrecio $listaprecio, $IdTambo = 0)
    {
        $sql = "call tsp_alta_listaprecio( :idtambo, :lista , :precio)";

        $query = Yii::$app->db->createCommand($sql);

        if (Yii::$app->session->get('IdTambo')) {
            $IdTambo = Yii::$app->session->get('IdTambo');
        }

        $query->bindValues([
            ':idtambo' => $IdTambo,
            ':lista' => $listaprecio->Lista,
            ':precio' => $listaprecio->Precio,
        ]);

        return $query->queryScalar();
    }

    /**
     * tsp_buscar_listaprecio
     */
    public function Buscar($Incluye = 'N', $Cadena = '', $IdTambo = 0)
    {
        $sql = "call tsp_buscar_listaprecio( :idtambo, :incluye, :cadena)";

        $query = Yii::$app->db->createCommand($sql);

        if (Yii::$app->session->get('IdTambo')) {
            $IdTambo = Yii::$app->session->get('IdTambo');
        }

        $query->bindValues([
            ':idtambo' => $IdTambo,
            ':incluye' => $Incluye,
            ':cadena' => $Cadena,
        ]);

        return $query->queryAll();
    }

    /**
     * tsp_modificar_listaprecio
     */
    public function Modificar(ListasPrecio $listaprecio)
    {
        $sql = "call tsp_modificar_listaprecio( :idlistaprecio, :lista , :precio)";

        $query = Yii::$app->db->createCommand($sql);

        $query->bindValues([
            ':idlistaprecio' => $listaprecio->IdListaPrecio,
            ':lista' => $listaprecio->Lista,
            ':precio' => $listaprecio->Precio,
        ]);

        return $query->queryScalar();
    }

    /**
     * tsp_borrar_listaprecio
     */
    public function Borrar(ListasPrecio $listaprecio)
    {
        $sql = "call tsp_borrar_listaprecio(:listaprecio)";

        $query = Yii::$app->db->createCommand($sql);

        $query->bindValues([
            ':listaprecio' => $listaprecio->IdListaPrecio,
        ]);

        return $query->queryScalar();
    }
}
