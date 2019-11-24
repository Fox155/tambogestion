<?php
namespace common\models;

use Yii;
use yii\base\Model;
use common\models\charts\RegistroLecheChart;
use yii\helpers\ArrayHelper;

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
    const _ESTADO = 'estado';
    const _LOTE = 'lote';

    const ESTADOS_LISTAR = [
        'VAQUILLONA' => 'Vaquillona',
        'SECA' => 'Seca',
        'LACTANTE' => 'Lactante',
        'MUERTA' => 'Muerta',
        'VENDIDA' => 'Vendida',
        'BAJA' => 'Baja',
        'T' => 'Todos'
    ];

    const ESTADOS = [
        'VAQUILLONA' => 'Vaquillona',
        'SECA' => 'Seca',
        'LACTANTE' => 'Lactante',
        'MUERTA' => 'Muerta',
        'VENDIDA' => 'Vendida',
        'BAJA' => 'Baja',
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
            [['IdVaca', 'Estado'], 'required', 'on' => self::_ESTADO],
            [['IdVaca', 'IdLote'], 'required', 'on' => self::_LOTE],
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
     * tsp_cambiar_estado_vaca
     */
    public function CambiarEstado()
    {
        $sql = 'CALL tsp_cambiar_estado_vaca( :id, :estado )';
        
        $query = Yii::$app->db->createCommand($sql);
    
        $query->bindValues([
            ':id' => $this->IdVaca,
            ':estado' => $this->Estado
        ]);
        
        return $query->queryScalar();
    }

    /**
     * tsp_cambiar_lote_vaca
     */
    public function CambiarLote()
    {
        $sql = 'CALL tsp_cambiar_lote_vaca( :id, :lote )';
        
        $query = Yii::$app->db->createCommand($sql);
    
        $query->bindValues([
            ':id' => $this->IdVaca,
            ':lote' => $this->IdLote
        ]);
        
        return $query->queryScalar();
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

    /**
     * tsp_listar_producciones_ultima_lactancia
     */
    public function Aspamento($id, $nro)
    {
        $sql = "call tsp_resumen_producciones_vaca( :id, :nrolactancia)";

        $query = Yii::$app->db->createCommand($sql);
        
        $query->bindValues([
            ':id' => $id,
            ':nrolactancia' => $nro,
        ]);

        return $query->queryOne();
    }

    /**
     * tsp_listar_lactancias
     */
    public function ListarResumenLactancias()
    {
        $sql = "call tsp_listar_lactancias_vaca( :id )";

        $query = Yii::$app->db->createCommand($sql);
        
        $query->bindValues([
            ':id' => $this->IdVaca,
        ]);

        $lactancias = $query->queryAll();

        $resArr = array();
        foreach ($lactancias as $lactancia){
            $tmpArr = array();
            $sql = "call tsp_resumen_producciones_vaca( :id, :nrolactancia)";

            $query2 = Yii::$app->db->createCommand($sql);
            
            $query2->bindValues([
                ':id' => $this->IdVaca,
                ':nrolactancia' => $lactancia['NroLactancia'],
            ]);

            $resumen = $query2->queryOne();

            $lactancia = $lactancia + $resumen;

            // $lactancia['Data'] = 0;

            // $lactancia['Data'] = $resumen['Data'];
            // $lactancia['Labels'] = $resumen['Labels'];
            // $lactancia['Footer'] = $resumen['Footer'];
            // $lactancia['Pico'] = $resumen['Pico'];
            // $lactancia['FechaPico'] = $resumen['FechaPico'];

            $lactancia[] = $resumen;

            // $lactancia[] = $resumen['Data'];
            // $lactancia[] = $resumen['Labels'];
            // $lactancia[] = $resumen['Footer'];
            // $lactancia[] = $resumen['Pico'];
            // $lactancia[] = $resumen['FechaPico'];

            foreach ($lactancia as $key=>$value)
            {
                $tmpArr[$key] = $value;
            }
            foreach ($resumen as $key=>$value)
            {
                $tmpArr[$key] = $value;
            }


            $tmpArr['Labels'] = json_decode($tmpArr['Labels']);
            $tmpArr['Data'] = json_decode($tmpArr['Data']);
            $resArr[] = $tmpArr;

            // $lactancia += [ "Data" => $resumen['Data'] ];
            // $lactancia += [ "Labels" => $resumen['Labels'] ];
            // $lactancia += [ "Pico" => $resumen['Pico'] ];
            // $lactancia += [ "FechaPico" => $resumen['FechaPico'] ];
        }

        return $resArr;
    }

    public function ProximosEstados($estado)
    {
        $estados;
        switch ($estado){
            case 'VAQUILLONA':
                $estados = [
                    'LACTANTE' => 'Lactante',
                    'MUERTA' => 'Muerta',
                    'VENDIDA' => 'Vendida',
                    'BAJA' => 'Baja',
                ];
                break;
            case 'LACTANTE':
                $estados = [
                    'SECA' => 'Seca',
                    'MUERTA' => 'Muerta',
                    'VENDIDA' => 'Vendida',
                    'BAJA' => 'Baja',
                ];
                break;
            case 'SECA':
                $estados = [
                    'LACTANTE' => 'Lactante',
                    'MUERTA' => 'Muerta',
                    'VENDIDA' => 'Vendida',
                    'BAJA' => 'Baja',
                ];
                break;
            case 'BAJA':
                $estados = [];
                break;
            default :
                $estados = [
                    'BAJA' => 'Baja',
                ];
                break;
        }
        return $estados;
    }
}