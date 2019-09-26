<?php
namespace common\models;

use Yii;
use yii\base\Model;

class Sucursales extends Model
{
    public $IdSucursal;
    public $IdTambo;
    public $Nombre;

    // DatosJSON
    public $Direccion;
    public $Telefono;
    
    const _ALTA = 'alta';
    const _MODIFICAR = 'modificar';
 
    public function rules()
    {
        return [
            [['Nombre'],
                'required', 'on' => self::_ALTA],
            [['IdSucursal', 'Nombre'],
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