<?php
namespace common\models;

use Yii;
use yii\base\Model;

class UsuariosSucursales extends Model
{
    public $NroUsuarioSucursal;
    public $IdSucursal;
    public $IdUsuario;
    public $FechaDesde;
    public $FechaHasta;
    
    // Derivados
    public $Usuario;
    public $Sucursal;
    public $Tipo;

    const _ALTA = 'alta';

    public function attributeLabels()
    {
        return [
            'IdUsuario' => 'Usuario'
        ];
    }
 
    public function rules()
    {
        return [
            [['IdSucursal', 'IdUsuario'], 'required', 'on' => self::_ALTA],
            [$this->attributes(), 'safe']
        ];
    }
}