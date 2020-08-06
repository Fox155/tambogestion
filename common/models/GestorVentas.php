<?php

namespace common\models;

use Yii;

class GestorVentas
{
    /**
     * Permite dar de alta una nueva Venta, siempre que la sucursal tenga la cantidad necesaria.
     * Devuelve OK+Id o el mensaje de error en Mensaje.
     * tsp_alta_venta
     */
    public function Alta(Ventas $venta)
    {
        $sql = "call tsp_alta_venta( :idcliente, :idsucursal, :monto, :pagos, :litros, :datos, :observaciones)";

        $query = Yii::$app->db->createCommand($sql);
        
        $query->bindValues([
            ':idcliente' => $venta->IdCliente,
            ':idsucursal' => $venta->IdSucursal,
            ':monto' => $venta->MontoPres,
            ':pagos' => $venta->NroPagos,
            ':litros' => $venta->Litros,
            ':datos' => $venta->Datos,
            ':observaciones' => $venta->Observaciones,
        ]);

        return $query->queryScalar();
    }

    /**
     * Permite buscar Ventas dentro de una sucursal, indicando una cadena de búsqueda.
     * tsp_buscar_ventas
     */
    public function Buscar($IdSucursal, $Cadena = '', $inicio = NULL, $fin = NULL, $Incluye = 'N')
    {
        $sql = "call tsp_buscar_ventas( :idsucursal, :idtambo, :cadena, :inicio, :fin, :incluye)";

        $query = Yii::$app->db->createCommand($sql);
        
        $query->bindValues([
            ':idtambo' => Yii::$app->user->identity->IdTambo,
            ':idsucursal' => $IdSucursal,
            ':incluye' => $Incluye,
            ':cadena' => $Cadena,
            ':inicio' => $inicio,
            ':fin' => $fin,
        ]);

        return $query->queryAll();
    }

    /**
     * Permite modificar los datos de una Venta.
     * Devuelve OK o el mensaje de error en Mensaje.
     * tsp_modificar_venta
     */
    public function Modificar(Ventas $venta)
    {
        $sql = "call tsp_modificar_venta( :id, :cliente, :monto, :pagos, :litros, :datos, :observaciones)";

        $query = Yii::$app->db->createCommand($sql);
        
        $query->bindValues([
            ':id' => $venta->IdVenta,
            ':cliente' => $venta->IdCliente,
            ':monto' => $venta->MontoPres,
            ':pagos' => $venta->NroPagos,
            ':litros' => $venta->Litros,
            ':datos' => $venta->Datos,
            ':observaciones' => $venta->Observaciones,
        ]);

        return $query->queryScalar();
    }

    /**
     * Permite borrar una venta controlando que no tenga pagos asociados.
     * Devuelve OK o un mensaje de error en Mensaje.
     * tsp_borrar_venta
     */
    public function Borrar(Ventas $venta)
    {
        $sql = "call tsp_borrar_venta(:id)";

        $query = Yii::$app->db->createCommand($sql);
        
        $query->bindValues([
            ':id' => $venta->IdVenta,
        ]);

        return $query->queryScalar();
    }
}