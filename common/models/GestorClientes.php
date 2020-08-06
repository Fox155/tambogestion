<?php

namespace common\models;

use Yii;

class GestorClientes
{
    /**
     * tsp_alta_cliente
     */
    public function Alta(Clientes $cliente, $IdTambo = 0)
    {
        $sql = "call tsp_alta_cliente( :idtambo, :idlistaprecio, :apellido, :nombre, :tipodoc, :nrodoc, :datos, :observaciones)";

        $query = Yii::$app->db->createCommand($sql);

        if (Yii::$app->session->get('IdTambo')) {
            $IdTambo = Yii::$app->session->get('IdTambo');
        }
        
        $query->bindValues([
            ':idtambo' => $IdTambo,
            ':idlistaprecio' => $cliente->IdListaPrecio , 
            ':apellido' => $cliente->Apellido, 
            ':nombre' => $cliente->Nombre , 
            ':tipodoc' => $cliente->TipoDoc, 
            ':nrodoc' => $cliente->NroDoc , 
            ':datos' => json_encode([
                'Telefono' => $cliente->Telefono,
                'Direccion' => $cliente->Direccion
            ]), 
            ':observaciones' =>$cliente->Observaciones 
        ]);

        return $query->queryScalar();
    }

    /**
     * tsp_buscar_cliente
     */
    public function Buscar($Incluye = 'N', $Cadena = '', $IdTambo = null)
    {
        $sql = "call tsp_buscar_clientes( :idtambo,:cadena,:incluye)";

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
     * tsp_modificar_cliente
     */
    public function Modificar(Clientes $cliente)
    {
        $sql = "call tsp_modificar_cliente(:idcliente, :idlistaprecio, :apellido, :nombre, :tipodoc, :nrodoc, :datos, :observaciones)";

        $query = Yii::$app->db->createCommand($sql);
        
        $query->bindValues([
            ':idcliente' => $cliente->IdCliente,
            ':idlistaprecio' => $cliente->IdListaPrecio , 
            ':apellido' => $cliente->Apellido, 
            ':nombre' => $cliente->Nombre , 
            ':tipodoc' => $cliente->TipoDoc, 
            ':nrodoc' => $cliente->NroDoc , 
            ':datos' => json_encode([
                'Telefono' => $cliente->Telefono,
                'Direccion' => $cliente->Direccion
            ]), 
            ':observaciones' =>$cliente->Observaciones
        ]);

        return $query->queryScalar();
    }

    /**
     * tsp_borrar_cliente
     */
    public function Borrar(Clientes $cliente)
    {
        $sql = "call tsp_borrar_cliente(:cliente)";

        $query = Yii::$app->db->createCommand($sql);
        
        $query->bindValues([
            ':cliente' => $cliente->IdCliente,
        ]);

        return $query->queryScalar();
    }

   
}