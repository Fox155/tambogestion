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

    /**
     * Permite instanciar un tambo desde la base de datos.
     * tsp_dame_tambo
     */
    public function Dame()
    {
        $sql = 'CALL tsp_dame_tambo( :id )';
        
        $query = Yii::$app->db->createCommand($sql);
    
        $query->bindValues([
            ':id' => $this->IdTambo
        ]);
        
        $this->attributes = $query->queryOne();
    }
}