<?php
namespace common\models;

use Yii;
use yii\base\Model;

class Lotes extends Model
{
    public $IdLote;
    public $IdSucursal;
    public $Nombre;
    public $Estado;

    // Derivados
    public $Sucursal;
    
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
            [['IdSucursal','Nombre'],
                'required', 'on' => self::_ALTA],
            [['IdLote','IdSucursal', 'Nombre'],
                'required', 'on' => self::_MODIFICAR],
            [$this->attributes(), 'safe']
        ];
    }

    /**
     * Permite instanciar un lote desde la base de datos.
     * tsp_dame_lote
     */
    public function Dame()
    {
        $sql = 'CALL tsp_dame_lote( :id )';
        
        $query = Yii::$app->db->createCommand($sql);
    
        $query->bindValues([
            ':id' => $this->IdLote
        ]);
        
        $this->attributes = $query->queryOne();
    }
}