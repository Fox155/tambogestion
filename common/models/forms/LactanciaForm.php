<?php

namespace common\models\forms;

use yii\base\Model;

class LactanciaForm extends Model
{
    public $FechaInicio;
    public $FechaFin;
    public $Id;

    const _ALTA = 'alta';
    const _FINALIZA = 'finaliza';

    /**
     * Reglas para validar los formularios.
     *
     * @return Array Reglas de validación
     */
    public function rules()
    {
        return [
            [['FechaInicio', 'FechaFin'], 'trim'],
            [['FechaInicio', 'FechaFin'], 'default', 'value' => ''],
            [['Id'], 'integer', 'min' => 0],
            [['Id'], 'default', 'value' => 0],
            [['FechaInicio'], 'required', 'on' => self::_ALTA],
            [['FechaFin'], 'required', 'on' => self::_FINALIZA],
            [['FechaInicio', 'FechaFin', 'Id'], 'safe'],
        ];
    }
}