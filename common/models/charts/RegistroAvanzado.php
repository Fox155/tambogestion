<?php

namespace common\models\charts;

use yii\base\Model;

class RegistroAvanzado extends Model
{
    public $Labels;
    public $Data;
    public $Participantes;
    public $Footer;

    public function rules()
    {
        return [
            ['Labels', 'each', 'rule' => ['trim']],
            ['Data', 'each', 'rule' => ['integer']],
            [['Footer'], 'trim'],
            [['Labels', 'Data', 'Participantes'], 'safe'],
        ];
    }
}