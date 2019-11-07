<?php
namespace common\models;

use Yii;
use yii\base\Model;

class Ventas extends Model
{
    public $IdVenta;
    public $IdCliente;
    public $IdSucursal;
    public $MontoPres;
    public $MontoPagar;
    public $NroPagos;
    public $Litros;
    public $Fecha;
    public $Estado;
    public $Datos;
    public $Observaciones;

    // Derivados
    public $Sucursal;
    public $Cliente;
    public $Pagos;
    
    const _ALTA = 'alta';
    const _MODIFICAR = 'modificar';

    const ESTADOS = [
        'A' => 'Activo',
        'B' => 'Baja',
        'T' => 'Todos'
    ];
 
    public function rules()
    {
        return [
            [['IdSucursal','IdCliente', 'MontoPres', 'NroPagos', 'Litros'],
                'required', 'on' => self::_ALTA],
            [['IdVenta', 'IdSucursal','IdCliente', 'MontoPres', 'NroPagos', 'Litros'],
                'required', 'on' => self::_MODIFICAR],
            [$this->attributes(), 'safe']
        ];
    }

    public function attributeLabels()
    {
        return [
            'IdSucursal' => 'Sucursal',
            'Pagos' => 'Pagos Realizados',
            'NroPagos' => 'Numero de Pagos',
            'IdCliente' => 'Cliente',
            'MontoPres' => 'Monto Presupuestado',
            'MontoPagar' => 'Monto Pagado',
        ];
    }

    /**
     * Procedimiento que sirve para instanciar una Venta desde la base de datos.
     * tsp_dame_venta
     */
    public function Dame()
    {
        $sql = 'CALL tsp_dame_venta( :id )';
        
        $query = Yii::$app->db->createCommand($sql);
    
        $query->bindValues([
            ':id' => $this->IdVenta
        ]);
        
        $this->attributes = $query->queryOne();
    }

    /**
     * Permite dar de baja una venta, controlando que no este dado de baja ya.
     * Devuelve OK o el mensaje de error en Mensaje.
     * tsp_darbaja_venta
     */
    public function DarBaja()
    {
        $sql = 'CALL tsp_darbaja_venta( :id )';
        
        $query = Yii::$app->db->createCommand($sql);
    
        $query->bindValues([
            ':id' => $this->IdVenta
        ]);
        
        $this->attributes = $query->queryOne();
    }

    /**
     * tsp_buscar_pagos
     */
    public function BuscarPagos($inicio = NULL, $fin = NULL)
    {
        $sql = "call tsp_buscar_pagos( :id, :inicio, :fin)";

        $query = Yii::$app->db->createCommand($sql);
        
        $query->bindValues([
            ':id' => $this->IdVenta,
            ':inicio' => $inicio,
            ':fin' => $fin,
        ]);

        return $query->queryAll();
    }

    /**
     * Permite dar de alta un nuevo Pago de una Venta, siempre que la venta se encuentre activa y no este pagada ya.
     * Devuelve OK+Id o el mensaje de error en Mensaje.
     * tsp_alta_pago
     */
    public function AltaPago(Pagos $pago)
    {
        $sql = "call tsp_alta_pago( :idventa, :tipo, :comp, :monto)";

        $query = Yii::$app->db->createCommand($sql);
        
        $query->bindValues([
            ':idventa' => $this->IdVenta,
            ':tipo' => $pago->TipoComp,
            ':comp' => $pago->NroComp,
            ':monto' => $pago->Monto,
        ]);

        return $query->queryScalar();
    }

    /**
     * Permite modificar los datos de un Pago.
     * Devuelve OK+Id o el mensaje de error en Mensaje.
     * tsp_modificar_pago
     */
    public function ModificarPago(Pagos $pago)
    {
        $sql = "call tsp_modificar_pago( :idventa, :nropago, :tipo, :comp, :monto)";

        $query = Yii::$app->db->createCommand($sql);
        
        $query->bindValues([
            ':idventa' => $this->IdVenta,
            ':nropago' => $pago->NroPago,
            ':tipo' => $pago->TipoComp,
            ':comp' => $pago->NroComp,
            ':monto' => $pago->Monto,
        ]);

        return $query->queryScalar();
    }

    /**
     * Permite borrar un pago.
     * Devuelve OK+Id o el mensaje de error en Mensaje.
     * tsp_borrar_pago
     */
    public function BorrarPago(Pagos $pago)
    {
        $sql = "call tsp_borrar_pago( :idventa , :nropago)";

        $query = Yii::$app->db->createCommand($sql);
        
        $query->bindValues([
            ':idventa' => $this->IdVenta,
            ':nropago' => $pago->NroPago,
        ]);

        return $query->queryScalar();
    }
}