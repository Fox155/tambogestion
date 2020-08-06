<?php

namespace common\models\charts;

use yii\base\Model;

class RegistroLecheChart extends Model
{
    public $Labels;
    public $Data;
    public $Footer;
    public $Pico;
    public $DiasPico;
    public $FechaPico;
    public $FechaLactancia;

    public function rules()
    {
        return [
            ['Labels', 'each', 'rule' => ['trim']],
            ['Data', 'each', 'rule' => ['integer']],
            [['Footer'], 'trim'],
            [['Pico'], 'integer'],
            [$this->attributes(), 'safe'],
        ];
    }
}
