<?php

namespace common\components;

use InvalidArgumentException;
use Yii;

class FechaHelper
{
    public static function toDateMysql($fecha)
    {
        if ($fecha == null || $fecha == '') {
            return null;
        }

        $unixTimestamp = strtotime(str_replace('/', '-', $fecha));

        if (!$unixTimestamp) {
            throw new InvalidArgumentException("La fecha {$fecha} es inválida.");
        }

        return date("Y-m-d", $unixTimestamp);
    }

    public static function toDatetimeMysql($fecha)
    {
        if ($fecha == null || $fecha == '') {
            return null;
        }

        $unixTimestamp = strtotime(str_replace('/', '-', $fecha));

        if (!$unixTimestamp) {
            throw new InvalidArgumentException("La fecha {$fecha} es inválida.");
        }

        return date("Y-m-d H:i:s", $unixTimestamp);
    }

    public static function toDateLocal($fecha)
    {
        if ($fecha == null || $fecha == '') {
            return null;
        }

        return Yii::$app->formatter->asDate($fecha);
    }

    public static function toDatetimeLocal($fecha, $incluyeSegundos = false)
    {
        if ($fecha == null || $fecha == '') {
            return null;
        }

        $formatoSalida = self::formatoSalidaDatetimeLocal($incluyeSegundos);
        return date($formatoSalida, strtotime($fecha));
    }

    private static function formatoSalidaDatetimeLocal(bool $incluyeSegundos): string
    {
        return $incluyeSegundos ? 'd/m/Y H:i:s' : 'd/m/Y H:i';
    }
}
