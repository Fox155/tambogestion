<?php

namespace common\models\forms;

use yii\base\Model;

class CambiarPasswordForm extends Model
{
    public $PasswordOld;
    public $PasswordNew;
    public $PasswordRep;

    const _CAMBIAR =  'cambiar';
    const _RESET =  'reset';
    
    public function attributeLabels()
    {
        return [
            'PasswordOld' => 'Contraseña actual',
            'PasswordNew' => 'Nueva contraseña',
            'PasswordRep' => 'Ingresar nuevamente la nueva contraseña'
        ];
    }

    public function rules()
    {
        return [
            ['PasswordRep', 'compare', 'compareAttribute' => 'PasswordNew'],
            [['PasswordOld', 'PasswordNew', 'PasswordRep'], 'required', 'on' => self::_CAMBIAR],
            [['PasswordNew', 'PasswordRep'], 'trim' ],
            ['PasswordNew', 'string', 'length' => [1, 15]],
            [['PasswordNew', 'PasswordRep'], 'required', 'on' => self::_RESET],
            [$this->attributes(), 'safe'],
        ];
    }
}