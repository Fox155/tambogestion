<?php
namespace common\models;

use Yii;
use yii\base\Model;

class ListasPrecio extends Model
{
    public $IdListaPrecio;
    public $IdTambo;
    public $Lista;
    public $Precio;
    public $Estado;

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
            [['Lista', 'Precio'],
                'required', 'on' => self::_ALTA],
            [['IdListaPrecio','Lista', 'Precio'],
                'required', 'on' => self::_MODIFICAR],
            [$this->attributes(), 'safe']
        ];
    }

    /**
     * Permite instanciar una Lista de Precio desde la base de datos.
     * tsp_dame_listaprecio
     */
    public function Dame()
    {
        $sql = 'CALL tsp_dame_listaprecio( :id )';
        
        $query = Yii::$app->db->createCommand($sql);
    
        $query->bindValues([
            ':id' => $this->IdListaPrecio
        ]);
        
        $this->attributes = $query->queryOne();
    }

    /**
     * tsp_listar_historico_listaprecio
     */
    public function Historico()
    {
        $sql = "call tsp_listar_historico_listaprecio( :id )";

        $query = Yii::$app->db->createCommand($sql);
        
        $query->bindValues([
            ':id' => $this->IdListaPrecio
        ]);

        return $query->queryAll();
    }

}