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
 
    public function rules()
    {
        return [
            [['Litros', 'IdSucursal'], 'required', 'on' => self::_ALTA],
            [$this->attributes(), 'safe']
        ];
    }

}