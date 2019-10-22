<?php

namespace common\models\charts;

use yii\base\Model;

class RegistroLecheChart extends Model
{
    public $Labels;
    public $Data;

    public function rules()
    {
        return [
            ['Data', 'each', 'rule' => ['trim']],
            ['Data', 'each', 'rule' => ['integer']],
            [['Labels', 'Data'], 'safe'],
        ];
    }
}
