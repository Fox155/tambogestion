<?php
namespace common\models;

use Yii;
use yii\base\Model;
use common\models\charts\RegistroLecheChart;

class Vacas extends Model
{
    public $IdVaca;
    public $IdCaravana;
    public $IdRFID;
    public $Nombre;
    public $Raza;
    public $Peso;
    public $FechaNac;
    public $Observaciones;

    // Derivados
    public $IdLote;
    public $Lote;
    public $FechaIngreso;
    public $IdSucursal;
    public $Sucursal;
    public $Estado;

    
    const _ALTA = 'alta';
    const _MODIFICAR = 'modificar';

    const ESTADOS = [
        'VAQUILLONA' => 'Vaquillona',
        'SECA' => 'Seca',
        'LACTANTE' => 'Lactante',
        'MUERTA' => 'Muerta',
        'VENDIDA' => 'Vendida',
        'BAJA' => 'Baja',
        'T' => 'Todos'
    ];

    const ESTADOS_ALTA = [
        'SECA' => 'Seca',
        'LACTANTE' => 'Lactante',
        'VAQUILLONA' => 'Vaquillona',
    ];

    public function attributeLabels()
    {
        return [
            'IdLote' => 'Lote',
            'IdCaravana' => 'Caravana',
            'IdRFID' => 'RFID',
            'FechaNac' => 'Fecha de Nacimiento',
            'FechaIngreso' => 'Fecha de Ingreso al Lote',
        ];
    }
 
    public function rules()
    {
        return [
            [['IdLote', 'IdCaravana', 'IdRFID', 'Estado'],
                'required', 'on' => self::_ALTA],
            [['IdVaca', 'IdLote', 'IdCaravana', 'IdRFID', 'Raza'],
                'required', 'on' => self::_MODIFICAR],
            [$this->attributes(), 'safe']
        ];
    }

    /**
     * Permite instanciar una vaca desde la base de datos.
     * tsp_dame_vaca
     */
    public function Dame()
    {
        $sql = 'CALL tsp_dame_vaca( :id )';
        
        $query = Yii::$app->db->createCommand($sql);
    
        $query->bindValues([
            ':id' => $this->IdVaca
        ]);
        
        $this->attributes = $query->queryOne();
    }

    /**
     * tsp_listar_lactancias
     */
    public function ListarLactancias()
    {
        $sql = "call tsp_listar_lactancias_vaca( :id )";

        $query = Yii::$app->db->createCommand($sql);
        
        $query->bindValues([
            ':id' => $this->IdVaca,
        ]);

        return $query->queryAll();
    }

    /**
     * tsp_listar_producciones_ultima_lactancia
     */
    public function ListarProduccionesUltLac()
    {
        $sql = "call tsp_resumen_producciones_vaca( :id )";

        $query = Yii::$app->db->createCommand($sql);
        
        $query->bindValues([
            ':id' => $this->IdVaca,
        ]);

        $registros = new RegistroLecheChart();

        $registros->attributes = $query->queryOne();

        $registros->Labels = json_decode($registros->Labels);
        $registros->Data = json_decode($registros->Data);
        // $registros->Labels = $labels->{'Labels'};
        // $registros->Data = $data->{'Data'};

        return $registros;
    }
}