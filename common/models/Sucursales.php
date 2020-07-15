<?php
namespace common\models;

use common\models\charts\RegistroAvanzado;
use Yii;
use yii\base\Model;

class Sucursales extends Model
{
    public $IdSucursal;
    public $IdTambo;
    public $Nombre;
    public $Datos;
    public $Litros;

    // DatosJSON
    public $Direccion;
    public $Telefono;

    // Auth
    public $ApiKey;
    
    const _ALTA = 'alta';
    const _MODIFICAR = 'modificar';
    const _AUTH = 'auth';
 
    public function rules()
    {
        return [
            [['Nombre', 'Direccion', 'Telefono'],
                'required', 'on' => self::_ALTA],
            [['IdSucursal', 'Nombre', 'Direccion', 'Telefono'],
                'required', 'on' => self::_MODIFICAR],
            [['ApiKey'], 'required', 'on' => self::_AUTH],
            [$this->attributes(), 'safe']
        ];
    }

    /**
     * Permite instanciar un punto venta desde la base de datos.
     * tsp_dame_sucursal
     */
    public function Dame()
    {
        $sql = 'CALL tsp_dame_sucursal( :id )';
        
        $query = Yii::$app->db->createCommand($sql);
    
        $query->bindValues([
            ':id' => $this->IdSucursal
        ]);
        
        $this->attributes = $query->queryOne();

        $datos = json_decode($this->Datos);
        $this->Telefono = $datos->{'Telefono'};
        $this->Direccion = $datos->{'Direccion'};
    }

    /**
     * tsp_listar_lotes_Sucursal
     */
    public function ListarLotes()
    {
        $sql = "call tsp_listar_lotes_Sucursal( :idsucursal)";

        $query = Yii::$app->db->createCommand($sql);
        
        $query->bindValues([
            ':idsucursal' => $this->IdSucursal,
        ]);

        return $query->queryAll();
    }

    /**
     * tsp_buscar_registroleche
     */
    public function BuscarRegistros($inicio = NULL, $fin = NULL)
    {
        $sql = "call tsp_buscar_registroleche( :idsucursal, :inicio, :fin)";

        $query = Yii::$app->db->createCommand($sql);
        
        $query->bindValues([
            ':idsucursal' => $this->IdSucursal,
            ':inicio' => $inicio,
            ':fin' => $fin,
        ]);

        return $query->queryAll();
    }

    /**
     * tsp_listar_lotes_Sucursal
     */
    public function ResumenRegistrosLeche(int $Limite)
    {
        $sql = "call tsp_resumen_registroleche( :idsucursal, :limite)";

        $query = Yii::$app->db->createCommand($sql);
        
        $query->bindValues([
            ':idsucursal' => $this->IdSucursal,
            ':limite' => $Limite,
        ]);

        $registros = new RegistroAvanzado();

        $registros->attributes = $query->queryOne();

        $registros->Labels = json_decode($registros->Labels);
        $registros->Data = json_decode($registros->Data);
        // $registros->Labels = $labels->{'Labels'};
        // $registros->Data = $data->{'Data'};

        return $registros;
    }

    /**
     * Permite dar de alta un registro de leche de una sucursal.
     * Controlando que solo se pueda anotar una registracion por dia en una sucursal
     * Devuelve OK+Id o el mensaje de error en Mensaje.
     * tsp_alta_registroleche
     */
    public function AltaRegistro(RegistrosLeche $registro)
    {
        $sql = "call tsp_alta_registroleche( :idsucursal, :litros, :fecha)";

        $query = Yii::$app->db->createCommand($sql);
        
        $query->bindValues([
            ':idsucursal' => $this->IdSucursal,
            ':litros' => $registro->Litros,
            ':fecha' => $registro->Fecha,
        ]);

        return $query->queryScalar();
    }

    /**
     * Permite dar de alta un registro de leche de una sucursal.
     * Controlando que solo se pueda anotar una registracion por dia en una sucursal
     * Devuelve OK+Id o el mensaje de error en Mensaje.
     * tsp_modificar_registroleche
     */
    public function ModificarRegistro(RegistrosLeche $registro)
    {
        $sql = "call tsp_modificar_registroleche( :id, :litros, :fecha)";

        $query = Yii::$app->db->createCommand($sql);
        
        $query->bindValues([
            ':id' => $registro->IdRegistroLeche,
            ':litros' => $registro->Litros,
            ':fecha' => $registro->Fecha,
        ]);

        return $query->queryScalar();
    }

    /**
     * Permite borrar un registro de leche.
     * Devuelve OK+Id o el mensaje de error en Mensaje.
     * tsp_borrar_registroleche
     */
    public function BorrarRegistro(RegistrosLeche $registro)
    {
        $sql = "call tsp_borrar_registroleche( :id)";

        $query = Yii::$app->db->createCommand($sql);
        
        $query->bindValues([
            ':id' => $registro->IdRegistroLeche,
        ]);

        return $query->queryScalar();
    }

    public function DamePorApiKey()
    {
        $sql = 'CALL tsp_dame_sucursal_por_apikey( :apikey )';
        
        $query = Yii::$app->db->createCommand($sql);
    
        $query->bindValues([
            ':apikey' => $this->ApiKey
        ]);
        
        $this->attributes = $query->queryOne();
    }
}