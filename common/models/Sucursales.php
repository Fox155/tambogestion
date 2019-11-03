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
    
    const _ALTA = 'alta';
    const _MODIFICAR = 'modificar';
 
    public function rules()
    {
        return [
            [['Nombre', 'Direccion', 'Telefono'],
                'required', 'on' => self::_ALTA],
            [['IdSucursal', 'Nombre', 'Direccion', 'Telefono'],
                'required', 'on' => self::_MODIFICAR],
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

    // /**
    //  * Permite asignar el punto de venta al que pertenece un usuario, controlando que ambos pertenezcan a la misma empresa.
	//  * Un usuario sólo puede pertenecer a un punto de venta. Por lo tanto se dan de baja las pertenencias anteriores y se 
	//  * da de alta la nueva en estado activo.
	//  * Devuelve OK o el mensaje de error en Mensaje.
    //  * xsp_asignar_usuario_puntoventa
    //  */
    // public function AsignarUsuario($IdUsuario)
    // {
    //     $sql = "call xsp_asignar_usuario_puntoventa( :token, :idusuario, :idpuntoventa, :IP, :userAgent, :app)";

    //     $query = Yii::$app->db->createCommand($sql);
        
    //     $query->bindValues([
    //         ':token' => Yii::$app->user->identity->Token,
    //         ':IP' => Yii::$app->request->userIP,
    //         ':userAgent' => Yii::$app->request->userAgent,
    //         ':app' => Yii::$app->id,
    //         ':idusuario' => $IdUsuario,
    //         ':idpuntoventa' => $this->IdPuntoVenta,
    //     ]);

    //     return $query->queryScalar();
    // }

    // /**
    //  * Permite desasignar a un usuario del punto de venta.
	//  * Devuelve OK o el mensaje de error en Mensaje.
    //  * xsp_desasignar_usuario_puntoventa
    //  */
    // public function DesasignarUsuario($IdUsuario)
    // {
    //     $sql = "call xsp_desasignar_usuario_puntoventa( :token, :idusuario, :IP, :userAgent, :app)";

    //     $query = Yii::$app->db->createCommand($sql);
        
    //     $query->bindValues([
    //         ':token' => Yii::$app->user->identity->Token,
    //         ':IP' => Yii::$app->request->userIP,
    //         ':userAgent' => Yii::$app->request->userAgent,
    //         ':app' => Yii::$app->id,
    //         ':idusuario' => $IdUsuario
    //     ]);

    //     return $query->queryScalar();
    // }

    // /**
    //  * Permite buscar usuarios de un punto de venta, indicando una cadena de búsqueda y un punto de venta.
    //  * xsp_buscar_usuarios_puntosventa
    //  */
    // public function BuscarUsuarios(string $Cadena = '')
    // {
    //     $sql = 'CALL xsp_buscar_usuarios_puntosventa( :cadena, :idPuntoVenta )';
        
    //     $query = Yii::$app->db->createCommand($sql);
    
    //     $query->bindValues([
    //         ':cadena' => $Cadena,
    //         ':idPuntoVenta' => $this->IdPuntoVenta
    //     ]);
        
    //     return $query->queryAll();
    // }

    // /**
    //  * Permite listar usuarios  asignables a un punto de venta.
    //  * xsp_dame_usuarios_asignar_puntosventa
    //  */
    // public function DameUsuariosAsignar()
    // {
    //     $sql = 'CALL xsp_dame_usuarios_asignar_puntosventa( :idPuntoVenta )';
        
    //     $query = Yii::$app->db->createCommand($sql);
    
    //     $query->bindValues([
    //         ':idPuntoVenta' => $this->IdPuntoVenta
    //     ]);
        
    //     return $query->queryAll();
    // }
}