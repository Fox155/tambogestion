<?php

namespace common\models;

use Yii;
use yii\base\Model;

class Produc extends Model
{
    public $IdProduccion;
    public $IdSesionOrdeño;
    public $IdVaca;
    public $NroLactancia;
    public $Produccion;
    public $FechaInicio;
    public $FechaFin;
    public $Medidor;
    public $IdRFID;

    // DatosMedidor
    public $NombreMedidor;

    const _ALTA = 'alta';

    public function rules()
    {
        return [
            [
                ['IdVaca', 'NroLactancia', 'IdSesionOrdeño', 'Produccion', 'FechaInicio', 'FechaFin'],
                'required', 'on' => self::_ALTA
            ],
            [$this->attributes(), 'safe']
        ];
    }
}
