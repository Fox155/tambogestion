<?php

namespace common\models;

use yii\base\Model;

class Lactancias extends Model
{
    public $IdVaca;
    public $NroLactancia;
    public $FechaInicio;
    public $FechaFin;
    public $Observaciones;
    public $Producciones;
    public $Acumulada;
    public $Meses;
    public $Dias;

    // Derivados
    public $Corregida;

    public function rules()
    {
        return [
            [$this->attributes(), 'safe'],
        ];
    }
}