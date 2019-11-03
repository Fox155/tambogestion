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
            'IdSucursal' => 'Sucursal',
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
            ':id' => $this->IdLote
        ]);
        
        $this->attributes = $query->queryOne();
    }
}