<?php
namespace common\models;

use Yii;
use yii\base\Model;

class Pagos extends Model
{
    public $IdVenta;
    public $NroPago;
    public $TipoComp;
    public $NroComp;
    public $Monto;
    public $Fecha;
    
    const _ALTA = 'alta';
    const _MODIFICAR = 'modificar';
 
    public function rules()
    {
        return [
            [['IdVenta', 'TipoComp', 'NroComp', 'Monto'], 'required', 'on' => self::_ALTA],
            [['IdVenta', 'NroPago', 'TipoComp', 'NroComp', 'Monto'], 'required', 'on' => self::_MODIFICAR],
            [$this->attributes(), 'safe']
        ];
    }

    public function attributeLabels()
    {
        return [
            'TipoComp' => 'Tipo de Comprobante',
            'NroComp' => 'Numero de Comprobante',
        ];
    }

    /**
     * Procedimiento que sirve para instanciar un Pago desde la base de datos.
     * tsp_dame_pago
     */
    public function Dame()
    {
        $sql = 'CALL tsp_dame_pago( :idventa, :nropago )';
        
        $query = Yii::$app->db->createCommand($sql);
    
        $query->bindValues([
            ':idventa' => $this->IdVenta,
            ':nropago' => $this->NroPago
        ]);
        
        $this->attributes = $query->queryOne();
    }
}