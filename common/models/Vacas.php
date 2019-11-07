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
        'VAQUILLON' => 'Vaquillon'
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
            [['IdVaca', 'IdLote', 'IdCaravana', 'IdRFID', 'Estado'],
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

        // $lactancias = $query->queryAll();

        // foreach ($lactancias as $lactancia){
        //     $meses = 0;
        //     $dias = 0;

        //     if ($lactancia['Dias'] < 40) {
        //             $dias=8.32;
        //         }else if($lactancia['Dias'] > 40 && $lactancia['Dias'] < 50){
        //             $dias=6.24;
        //         }else if($lactancia['Dias'] > 50 && $lactancia['Dias'] < 60){
        //             $dias=4.94;
        //         }else if($lactancia['Dias'] > 60 && $lactancia['Dias'] < 70){
        //             $dias=4.16;
        //         }else if($lactancia['Dias'] > 70 && $lactancia['Dias'] < 80){
        //             $dias=3.58;
        //         }else if($lactancia['Dias'] > 80 && $lactancia['Dias'] < 90){
        //             $dias=3.15;
        //         }else if($lactancia['Dias'] > 90 && $lactancia['Dias'] < 100){
        //             $dias=2.82;
        //         }else if($lactancia['Dias'] > 100 && $lactancia['Dias'] < 110){
        //             $dias=2.55;
        //         }else if($lactancia['Dias'] > 110 && $lactancia['Dias'] < 120){
        //             $dias=2.34;
        //         }else if($lactancia['Dias'] > 120 && $lactancia['Dias'] < 130){
        //             $dias=2.16;
        //         }else if($lactancia['Dias'] > 130 && $lactancia['Dias'] < 140){
        //             $dias=2.01;
        //         }else if($lactancia['Dias'] > 140 && $lactancia['Dias'] < 150){
        //             $dias=1.88;
        //         }else if($lactancia['Dias'] > 150 && $lactancia['Dias'] < 160){
        //             $dias=1.77;
        //         }else if($lactancia['Dias'] > 160 && $lactancia['Dias'] < 170){
        //             $dias=1.67;
        //         }else if($lactancia['Dias'] > 170 && $lactancia['Dias'] < 180){
        //             $dias=1.58;
        //         }else if($lactancia['Dias'] > 180 && $lactancia['Dias'] < 190){
        //             $dias=1.51;
        //         }else if($lactancia['Dias'] > 190 && $lactancia['Dias'] < 200){
        //             $dias=1.44;
        //         }else if($lactancia['Dias'] > 200 && $lactancia['Dias'] < 210){
        //             $dias=1.38;
        //         }else if($lactancia['Dias'] > 210 && $lactancia['Dias'] < 220){
        //             $dias=1.32;
        //         }else if($lactancia['Dias'] > 220 && $lactancia['Dias'] < 230){
        //             $dias=1.27;
        //         }else if($lactancia['Dias'] > 230 && $lactancia['Dias'] < 240){
        //             $dias=1.23;
        //         }else if($lactancia['Dias'] > 240 && $lactancia['Dias'] < 250){
        //             $dias=1.19;
        //         }else if($lactancia['Dias'] > 250 && $lactancia['Dias'] < 260){
        //             $dias=1.15;
        //         }else if($lactancia['Dias'] > 260 && $lactancia['Dias'] < 270){
        //             $dias=1.12;
        //         }else if($lactancia['Dias'] > 270 && $lactancia['Dias'] < 280){
        //             $dias=1.08;
        //         }else if($lactancia['Dias'] > 280 && $lactancia['Dias'] < 290){
        //             $dias=1.06;
        //         }else if($lactancia['Dias'] > 290 && $lactancia['Dias'] < 300){
        //             $dias=1.03;
        //         }else{
        //             $dias=1.01;
        //     }

        //     if ($lactancia['Meses'] < 22) {
        //             $meses=1.35;
        //         }else if($lactancia['Meses'] > 22 && $lactancia['Meses'] < 23){
        //             $meses=1.32;
        //         }else if($lactancia['Meses'] > 23 && $lactancia['Meses'] < 24){
        //             $meses=1.30;
        //         }else if($lactancia['Meses'] > 24 && $lactancia['Meses'] < 26){
        //             $meses=1.28;
        //         }else if($lactancia['Meses'] > 26 && $lactancia['Meses'] < 28){
        //             $meses=1.25;
        //         }else if($lactancia['Meses'] > 28 && $lactancia['Meses'] < 30){
        //             $meses=1.22;
        //         }else if($lactancia['Meses'] > 30 && $lactancia['Meses'] < 32){
        //             $meses=1.20;
        //         }else if($lactancia['Meses'] > 32 && $lactancia['Meses'] < 34){
        //             $meses=1.18;
        //         }else if($lactancia['Meses'] > 34 && $lactancia['Meses'] < 36){
        //             $meses=1.16;
        //         }else if($lactancia['Meses'] > 36 && $lactancia['Meses'] < 38){
        //             $meses=1.14;
        //         }else if($lactancia['Meses'] > 38 && $lactancia['Meses'] < 40){
        //             $meses=1.13;
        //         }else if($lactancia['Meses'] > 40 && $lactancia['Meses'] < 42){
        //             $meses=1.11;
        //         }else if($lactancia['Meses'] > 42 && $lactancia['Meses'] < 44){
        //             $meses=1.09;
        //         }else if($lactancia['Meses'] > 44 && $lactancia['Meses'] < 46){
        //             $meses=1.08;
        //         }else if($lactancia['Meses'] > 46 && $lactancia['Meses'] < 48){
        //             $meses=1.06;
        //         }else if($lactancia['Meses'] > 48 && $lactancia['Meses'] < 51){
        //             $meses=1.05;
        //         }else if($lactancia['Meses'] > 51 && $lactancia['Meses'] < 54){
        //             $meses=1.04;
        //         }else if($lactancia['Meses'] > 54 && $lactancia['Meses'] < 57){
        //             $meses=1.02;
        //         }else if($lactancia['Meses'] > 57 && $lactancia['Meses'] < 60){
        //             $meses=1.01;
        //         }else if($lactancia['Meses'] > 60 && $lactancia['Meses'] < 66){
        //             $meses=1.01;
        //         }else if($lactancia['Meses'] > 66 && $lactancia['Meses'] < 72){
        //             $meses=1.00;
        //         }else if($lactancia['Meses'] > 72 && $lactancia['Meses'] < 90){
        //             $meses=1.00;
        //         }else if($lactancia['Meses'] > 90 && $lactancia['Meses'] < 96){
        //             $meses=1.00;
        //         }else if($lactancia['Meses'] > 96 && $lactancia['Meses'] < 108){
        //             $meses=1.00;
        //         }else if($lactancia['Meses'] > 108 && $lactancia['Meses'] < 120){
        //             $meses=1.02;
        //         }else if($lactancia['Meses'] > 120 && $lactancia['Meses'] < 132){
        //             $meses=1.05;
        //         }else if($lactancia['Meses'] > 132 && $lactancia['Meses'] < 144){
        //             $meses=1.06;
        //         }else if($lactancia['Meses'] > 144 && $lactancia['Meses'] < 156){
        //             $meses=1.09;
        //         }else if($lactancia['Meses'] > 156 && $lactancia['Meses'] < 168){
        //             $meses=1.13;
        //         }else{
        //             $meses=1.16;
        //     }

        //     $lactancia['Corregida'] = $lactancia['Acumulada'] * $meses * $dias;

        //     $lactancia['Corregida'] = 777;
        // }

        // return $lactancias;
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