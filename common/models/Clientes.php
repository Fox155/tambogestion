<?php
namespace common\models;

use Yii;
use yii\base\Model;

class Clientes extends Model
{
    public $IdCliente;    
    public $IdTambo;
    public $Apellido;
    public $Nombre;
    public $TipoDoc;
    public $NroDoc;
    public $Estado;
    public $Observaciones;
    public $Datos;

    //Datos de la Lista Precio
    public $IdListaPrecio;
    public $Lista;
    public $Precio;


     // DatosJSON
     public $Direccion;
     public $Telefono;

     
    const _ALTA = 'alta';
    const _MODIFICAR = 'modificar';

    const ESTADOS = [
        'A' => 'Activo',
        'B' => 'Baja',
        'T' => 'Todos'
    ];
 
    const _TIPO = [
        'CUIT' => 'CUIT',
        'CUIL' => 'CUIL'
    ];

    public function rules()
    {
        return [
            [['Apellido', 'Nombre','NroDoc','Direccion','Telefono','Observaciones'],
                'required', 'on' => self::_ALTA],
            [['IdCliente','Apellido', 'Nombre','TipoDoc','NroDoc','Direccion','Telefono','Observaciones'],
                'required', 'on' => self::_MODIFICAR],
            [$this->attributes(), 'safe']
        ];
    }

    public function attributeLabels()
    {
        return [
            'IdListaPrecio' => 'Lista Precio',
        ];
    }

    /**
     * Permite instanciar un cliente desde la base de datos.
     * tsp_dame_cliente
     */
    public function Dame()
    {
        $sql = 'CALL tsp_dame_cliente( :id )';
        
        $query = Yii::$app->db->createCommand($sql);
    
        $query->bindValues([
            ':id' => $this->IdCliente
        ]);
        
        $this->attributes = $query->queryOne();
        
        $datos = json_decode($this->Datos);
        $this->Direccion = $datos->{'Direccion'};
        $this->Telefono = $datos->{'Telefono'};
    }

      /**
     * tsp_darbaja_cliente
     */
    public function Darbaja(Clientes $cliente)
    {
        $sql = "call tsp_darbaja_cliente(:cliente)";

        $query = Yii::$app->db->createCommand($sql);
        
        $query->bindValues([
            ':cliente' => $cliente->IdCliente,
        ]);

        return $query->queryScalar();
    }

     /**
     * tsp_activar_cliente
     */
    public function Activar(Clientes $cliente)
    {
        $sql = "call tsp_activar_cliente(:cliente)";

        $query = Yii::$app->db->createCommand($sql);
        
        $query->bindValues([
            ':cliente' => $cliente->IdCliente,
        ]);

        return $query->queryScalar();
    }


}