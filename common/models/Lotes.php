<?php
namespace common\models;

use common\models\charts\RegistroAvanzado;
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
    public $LoteSucursal;
    public $Ganado;
    
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

    public function attributeLabels()
    {
        return [
            'IdSucursal' => 'Sucursal',
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

    /**
     * tsp_listar_resumen_producciones_lote
     */
    public function ResumenProducciones($inicio = NULL, $fin = NULL)
    {
        $sql = "call tsp_listar_resumen_producciones_lote( :id, :inicio, :fin)";

        $query = Yii::$app->db->createCommand($sql);
        
        $query->bindValues([
            ':id' => $this->IdLote,
            ':inicio' => $inicio,
            ':fin' => $fin,
        ]);

        $registros = new RegistroAvanzado();

        $registros->attributes = $query->queryOne();

        $registros->Labels = json_decode($registros->Labels);
        $registros->Data = json_decode($registros->Data);

        return $registros;
    }
}