<?php
namespace common\models;

use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

class Usuarios extends ActiveRecord  implements IdentityInterface
{
    public $IdUsuario;
    public $IdTambo;
    public $IdTipoUsuario;
    public $Usuario;
    public $Email;
    public $Password;
    public $Token;
    public $IntentosPass;
    public $FechaAlta;
    public $Estado;

    // Derivados
    public $TipoUsuario;
    public $IdsSucursales;

    // Cambiar Pass
    public $PasswordOld;
    public $PasswordNew;
    public $PasswordRep;
    
    const _ALTA = 'alta';
    const _MODIFICAR = 'modificar';
    const _LOGIN =  'login';
    const _CAMBIAR =  'cambiar';
    
    const ESTADOS = [
        'A' => 'Activo',
        'B' => 'Baja',
        'S' => 'Suspendido',
        'C' => 'Debe Cambiar Contraseña',
        'T' => 'Todos'
    ];

    const TIPOS_USUARIOS = [
        1 => 'Administrador',
        2 => 'Operador',
        0 => 'Todos'
    ];

    const APLICACIONES = [
        'A' => 'Administración'
    ];
    
    public static function tableName()
    {
        return 'Usuarios';
    }

    public function attributeLabels()
    {
        return [
            'IdTipoUsuario' => 'Tipo de Usuario',
            'IdTambo' => 'Tambo',
            'Password' => 'Contraseña',
            'PasswordOld' => 'Antigua Contraseña',
            'PasswordNew' => 'Nueva Contraseña',
            'PasswordRep' => 'Repita la Contraseña',
            'IdsSucursales' => 'Sucursales asignadas',
            'IdUsuario' => 'Usuario'
        ];
    }
 
    public function rules()
    {
        return [
            ['Email','email'],
            ['IdsSucursales', 'each', 'rule' => ['integer']],
            [['Usuario', 'Password'], 'required', 'on' => self::_LOGIN],
            [['IdTipoUsuario', 'Usuario', 'Email', 'Password', 'IdsSucursales'], 'required', 'on' => self::_ALTA],
            [['IdUsuario', 'IdTipoUsuario', 'Email', 'IdsSucursales'], 'required', 'on' => self::_MODIFICAR],
            [['PasswordOld', 'PasswordNew', 'PasswordRep'], 'required', 'on' => self::_CAMBIAR],
            [$this->attributes(), 'safe'],
            [['IdsSucursales','TipoUsuario'], 'safe']
        ];
    }

    /**
     * Finds an identity by the given ID.
     * @param string|int $id the ID to be looked for
     * @return IdentityInterface the identity object that matches the given ID. Null
     * should be returned if such an identity cannot be found or the identity is not
     * in an active state (disabled, deleted, etc.)
     *
     * @param id
     */
    public static function findIdentity($id)
    {
        $usuario = new Usuarios();
        
        $usuario->IdUsuario = $id;
        
        $usuario->Dame();
        
        return $usuario;
    }

    /**
     * Finds an identity by the given token.
     * @param mixed $token the token to be looked for
     * @param mixed $type the type of the token. The value of this parameter depends
     * on the implementation. For example, [[\yii\filters\auth\HttpBearerAuth]] will
     * set this parameter to be `yii\filters\auth\HttpBearerAuth`.
     * @return IdentityInterface the identity object that matches the given token.
     * Null should be returned if such an identity cannot be found or the identity is
     * not in an active state (disabled, deleted, etc.)
     *
     * @param token
     * @param type
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        $usuario = new Usuarios();
        
        $usuario->Token = $token;
        
        $usuario->DamePorToken();
        
        if ($usuario->IdUsuario != null) {
            return $usuario;
        } else {
            return null;
        }
    }

    /**
     * Returns an ID that can uniquely identify a user identity.
     * @return string|int an ID that uniquely identifies a user identity.
     */
    public function getId()
    {
        return $this->IdUsuario;
    }

    /**
     * Returns a key that can be used to check the validity of a given identity ID.
     * The key should be unique for each individual user, and should be persistent so
     * that it can be used to check the validity of the user identity.  The space of
     * such keys should be big enough to defeat potential identity attacks.  This is
     * required if [[User::enableAutoLogin]] is enabled.
     * @return string a key that is used to check the validity of a given identity ID.
     *
     * @see validateAuthKey()
     */
    public function getAuthKey()
    {
        return $this->Token;
    }

    /**
     * Validates the given auth key.  This is required if [[User::enableAutoLogin]] is
     * enabled.
     * @param string $authKey the given auth key
     * @return bool whether the given auth key is valid.
     * @see getAuthKey()
     *
     * @param authKey
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Permite instanciar un usuario desde la base de datos.
     * xsp_dame_usuario
     */
    public function Dame()
    {
        $sql = 'CALL tsp_dame_usuario( :idUsuario )';
        
        $query = Yii::$app->db->createCommand($sql);
    
        $query->bindValues([
            ':idUsuario' => $this->IdUsuario
        ]);
        
        $this->attributes = $query->queryOne();
    }
    
    /**
     * Permite instanciar un usuario por Usuario desde la base de datos.
     * xsp_dame_usuario_por_usuario
     */
    public function DamePorUsuario()
    {
        $sql = 'CALL tsp_dame_usuario_por_usuario( :usuario )';
        
        $query = Yii::$app->db->createCommand($sql);
    
        $query->bindValues([
            ':usuario' => $this->Usuario
        ]);
        
        $this->attributes = $query->queryOne();
    }

    /**
     * tsp_dame_usuario_por_token
     */
    public function DamePorToken()
    {
        $sql = 'CALL tsp_dame_usuario_por_token( :token )';
        
        $query = Yii::$app->db->createCommand($sql);
        
        $query->bindValues([
            ':token' => $this->Token
        ]);
        
        $res = $query->queryOne();
        
        $this->attributes = $res;
        
        return $res;
    }

    /**
     * Permite obtener el password hash de un usuario a partir del nombre de usuario.
     * xsp_dame_password_hash
     */
    public function DamePassword()
    {
        $sql = "CALL tsp_dame_password_hash ( :usuario )";

        $query = Yii::$app->db->createCommand($sql);

        $query->bindValue(':usuario', $this->Usuario);

        return $query->queryScalar();
    }

    public function CambiarPassword($Token = null, $OldPass = null, $NewPass = null, $Modo = 'U')
    {
        if ($Modo != 'R') {
            // Verifico que el password anterior sea correcto
            $hash = $this->DamePassword();

            if (!(strlen($hash) == 32 && $hash == md5($OldPass)) && !password_verify($OldPass, $hash)) {
                return 'No se puede cambiar la contraseña. La contraseña anterior es incorrecta.';
            }
        }

        $newHash = password_hash($NewPass, PASSWORD_DEFAULT);

        $sql = "CALL tsp_cambiar_password( :modo, :token, :passwordNuevo)";

        $query = Yii::$app->db->createCommand($sql);

        $query->bindValues([
            ':modo' => $Modo,
            ':token' => $Token,
            ':passwordNuevo' => $newHash,
        ]);

        return $query->queryScalar();
    }

    public function RestablecerPassword($Password = '')
    {
        $sql = "CALL tsp_restablecer_password( :token, :idusuario, :passwordNuevo)";

        $query = Yii::$app->db->createCommand($sql);

        $query->bindValues([
            ':idusuario' => $this->IdUsuario,
            ':token' => Yii::$app->user->identity->Token,
            ':passwordNuevo' => password_hash($Password, PASSWORD_DEFAULT),
        ]);

        return $query->queryScalar();
    }

    public function Login($App = '', $Pass = null, $Token = null)
    {
        $hash = $this->DamePassword();

        $necesitaRehash = false;

        // El usuario tiene hash en MD5 y coincide con el password ingresado
        if (strlen($hash) == 32 && $hash == md5($Pass)) {
            $necesitaRehash = true;
            $esValido = 'S';
        } elseif (password_verify($Pass, $hash)) {
            $esValido = 'S';
            // Si es necesario rehash
            if (password_needs_rehash($hash, PASSWORD_DEFAULT)) {
                $necesitaRehash = true;
            }
        } else {
            $esValido = 'N';
        }

        $sql = "CALL tsp_login( :usuario, :esValido, :token, :app )";

        $query = Yii::$app->db->createCommand($sql);

        $query->bindValues([
            ':app' => $App,
            ':usuario' => $this->Usuario,
            ':esValido' => $esValido,
            ':token' => $Token
        ]);

        $result = $query->queryOne();

        $this->attributes = $result;

        return $result;
    }

    public function Logout()
    {
        $sql = 'CALL tsp_logout( :token )';
        
        $query = Yii::$app->db->createCommand($sql);
        
        $query->bindValues([
            ':token' => Yii::$app->user->identity->Token
        ]);
        
        return $query->queryScalar();
    }
    
    public function ExisteUsuario()
    {
        $sql = 'CALL tsp_existe_usuario( :usuario )';
        
        $query = Yii::$app->db->createCommand($sql);
        
        $query->bindValues([
            ':usuario' => $this->Usuario
        ]);
        
        return $query->queryScalar();
    }
}
