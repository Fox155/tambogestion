<?php
namespace common\components;

use InvalidArgumentException;
use Yii;

class LecheHelper
{
    public static function corregida($acumulada, $mesesTotales, $diasTotales)
    {
        $factorMeses = 0;
        $factorDias = 0;

        if ($diasTotales < 40) {
                $factorDias=8.32;
            }else if($diasTotales > 40 && $diasTotales < 50){
                $factorDias=6.24;
            }else if($diasTotales > 50 && $diasTotales < 60){
                $factorDias=4.94;
            }else if($diasTotales > 60 && $diasTotales < 70){
                $factorDias=4.16;
            }else if($diasTotales > 70 && $diasTotales < 80){
                $factorDias=3.58;
            }else if($diasTotales > 80 && $diasTotales < 90){
                $factorDias=3.15;
            }else if($diasTotales > 90 && $diasTotales < 100){
                $factorDias=2.82;
            }else if($diasTotales > 100 && $diasTotales < 110){
                $factorDias=2.55;
            }else if($diasTotales > 110 && $diasTotales < 120){
                $factorDias=2.34;
            }else if($diasTotales > 120 && $diasTotales < 130){
                $factorDias=2.16;
            }else if($diasTotales > 130 && $diasTotales < 140){
                $factorDias=2.01;
            }else if($diasTotales > 140 && $diasTotales < 150){
                $factorDias=1.88;
            }else if($diasTotales > 150 && $diasTotales < 160){
                $factorDias=1.77;
            }else if($diasTotales > 160 && $diasTotales < 170){
                $factorDias=1.67;
            }else if($diasTotales > 170 && $diasTotales < 180){
                $factorDias=1.58;
            }else if($diasTotales > 180 && $diasTotales < 190){
                $factorDias=1.51;
            }else if($diasTotales > 190 && $diasTotales < 200){
                $factorDias=1.44;
            }else if($diasTotales > 200 && $diasTotales < 210){
                $factorDias=1.38;
            }else if($diasTotales > 210 && $diasTotales < 220){
                $factorDias=1.32;
            }else if($diasTotales > 220 && $diasTotales < 230){
                $factorDias=1.27;
            }else if($diasTotales > 230 && $diasTotales < 240){
                $factorDias=1.23;
            }else if($diasTotales > 240 && $diasTotales < 250){
                $factorDias=1.19;
            }else if($diasTotales > 250 && $diasTotales < 260){
                $factorDias=1.15;
            }else if($diasTotales > 260 && $diasTotales < 270){
                $factorDias=1.12;
            }else if($diasTotales > 270 && $diasTotales < 280){
                $factorDias=1.08;
            }else if($diasTotales > 280 && $diasTotales < 290){
                $factorDias=1.06;
            }else if($diasTotales > 290 && $diasTotales < 300){
                $factorDias=1.03;
            }else{
                $factorDias=1.01;
        }

        if ($mesesTotales < 22) {
                $factorMeses=1.35;
            }else if($mesesTotales > 22 && $mesesTotales < 23){
                $factorMeses=1.32;
            }else if($mesesTotales > 23 && $mesesTotales < 24){
                $factorMeses=1.30;
            }else if($mesesTotales > 24 && $mesesTotales < 26){
                $factorMeses=1.28;
            }else if($mesesTotales > 26 && $mesesTotales < 28){
                $factorMeses=1.25;
            }else if($mesesTotales > 28 && $mesesTotales < 30){
                $factorMeses=1.22;
            }else if($mesesTotales > 30 && $mesesTotales < 32){
                $factorMeses=1.20;
            }else if($mesesTotales > 32 && $mesesTotales < 34){
                $factorMeses=1.18;
            }else if($mesesTotales > 34 && $mesesTotales < 36){
                $factorMeses=1.16;
            }else if($mesesTotales > 36 && $mesesTotales < 38){
                $factorMeses=1.14;
            }else if($mesesTotales > 38 && $mesesTotales < 40){
                $factorMeses=1.13;
            }else if($mesesTotales > 40 && $mesesTotales < 42){
                $factorMeses=1.11;
            }else if($mesesTotales > 42 && $mesesTotales < 44){
                $factorMeses=1.09;
            }else if($mesesTotales > 44 && $mesesTotales < 46){
                $factorMeses=1.08;
            }else if($mesesTotales > 46 && $mesesTotales < 48){
                $factorMeses=1.06;
            }else if($mesesTotales > 48 && $mesesTotales < 51){
                $factorMeses=1.05;
            }else if($mesesTotales > 51 && $mesesTotales < 54){
                $factorMeses=1.04;
            }else if($mesesTotales > 54 && $mesesTotales < 57){
                $factorMeses=1.02;
            }else if($mesesTotales > 57 && $mesesTotales < 60){
                $factorMeses=1.01;
            }else if($mesesTotales > 60 && $mesesTotales < 66){
                $factorMeses=1.01;
            }else if($mesesTotales > 66 && $mesesTotales < 72){
                $factorMeses=1.00;
            }else if($mesesTotales > 72 && $mesesTotales < 90){
                $factorMeses=1.00;
            }else if($mesesTotales > 90 && $mesesTotales < 96){
                $factorMeses=1.00;
            }else if($mesesTotales > 96 && $mesesTotales < 108){
                $factorMeses=1.00;
            }else if($mesesTotales > 108 && $mesesTotales < 120){
                $factorMeses=1.02;
            }else if($mesesTotales > 120 && $mesesTotales < 132){
                $factorMeses=1.05;
            }else if($mesesTotales > 132 && $mesesTotales < 144){
                $factorMeses=1.06;
            }else if($mesesTotales > 144 && $mesesTotales < 156){
                $factorMeses=1.09;
            }else if($mesesTotales > 156 && $mesesTotales < 168){
                $factorMeses=1.13;
            }else{
                $factorMeses=1.16;
        }

        return $acumulada * $factorMeses * $factorDias;
    }
}