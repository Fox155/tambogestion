<?php
namespace common\models;

use Yii;
use yii\base\Model;
use common\models\charts\RegistroAvanzado;

class Tambos extends Model
{
    public $IdTambo;
    public $Nombre;
    public $CUIT;
    public $Estado;
 
    public function rules()
    {
        return [
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

    /**
     * tsp_resumen_producciones_tambo
     */
    public function ResumenProducciones()
    {
        $sql = "call tsp_resumen_producciones_tambo( :id )";

        $query = Yii::$app->db->createCommand($sql);
        
        $query->bindValues([
            ':id' => $this->IdTambo,
        ]);

        $registros = new RegistroAvanzado();

        $registros->attributes = $query->queryOne();

        $registros->Labels = json_decode($registros->Labels);
        $registros->Data = json_decode($registros->Data);
        $registros->Participantes = json_decode($registros->Participantes);

        return $registros;
    }

    /**
     * tsp_resumen_ventas_tambo
     */
    public function ResumenVentas()
    {
        $sql = "call tsp_resumen_ventas_tambo( :id )";

        $query = Yii::$app->db->createCommand($sql);
        
        $query->bindValues([
            ':id' => $this->IdTambo,
        ]);

        $registros = new RegistroAvanzado();

        $registros->attributes = $query->queryOne();

        $registros->Labels = json_decode($registros->Labels);
        $registros->Data = json_decode($registros->Data);
        $registros->Participantes = json_decode($registros->Participantes);

        return $registros;
    }
}