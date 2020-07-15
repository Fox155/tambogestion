<?php
namespace common\models;

use Yii;
use yii\base\Model;

class SesionesOrdeño extends Model
{
    public $IdSesionOrdeño;
    public $IdSucursal;
	public $Fecha;
	public $Observaciones;
    
    const _ALTA = 'alta';
 
    public function rules()
    {
        return [
            [['IdSucursal', 'Fecha'],
                'required', 'on' => self::_ALTA],
            [$this->attributes(), 'safe']
        ];
    }

    /**
     * Permite instanciar un punto venta desde la base de datos.
     * tsp_dame_sucursal
     */
    // public function Dame()
    // {
    //     $sql = 'CALL tsp_dame_sucursal( :id )';
        
    //     $query = Yii::$app->db->createCommand($sql);
    
    //     $query->bindValues([
    //         ':id' => $this->IdSucursal
    //     ]);
        
    //     $this->attributes = $query->queryOne();

    //     $datos = json_decode($this->Datos);
    //     $this->Telefono = $datos->{'Telefono'};
    //     $this->Direccion = $datos->{'Direccion'};
    // }
}