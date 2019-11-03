<?php
namespace common\models;

use Yii;
use yii\base\Model;

class RegistrosLeche extends Model
{
    public $IdSucursal;
    public $IdRegistroLeche;
    public $Litros;
    public $Fecha;
    
    const _ALTA = 'alta';
    const _MODIFICAR = 'modificar';
 
    public function rules()
    {
        return [
            [['Litros', 'Fecha', 'IdSucursal'], 'required', 'on' => self::_ALTA],
            [['IdRegistroLeche', 'Litros', 'Fecha'], 'required', 'on' => self::_MODIFICAR],
            [$this->attributes(), 'safe']
        ];
    }

    /**
     * Procedimiento que sirve para instanciar un registro de leche desde la base de datos.
     * tsp_dame_registroleche
     */
    public function Dame()
    {
        $sql = 'CALL tsp_dame_registroleche( :id )';
        
        $query = Yii::$app->db->createCommand($sql);
    
        $query->bindValues([
            ':id' => $this->IdRegistroLeche
        ]);
        
        $this->attributes = $query->queryOne();
    }
}