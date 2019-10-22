<?php

use common\models\Sucursales;
use yii\web\View;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use dosamigos\chartjs\ChartJs;
use miloschuman\highcharts\Highcharts;

/* @var $this View */
/* @var $form ActiveForm */
$this->title = 'Detalle de la Sucursal: ' . $model['Nombre'];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-sm-12">

        <div class="card">
            <div class="card-header">
                <i class="fas fa-chart-area"></i>
                Ejemplo de gráfico de área - Registros de leche
            </div>
            <!-- ChartJS 2amigos -->
            <div class="card-body">
                <?= ChartJs::widget([
                    'type' => 'line',
                    'options' => [
                        'height' => "30",
                        'width' => "100%",
                    ],
                    'clientOptions' => [
                    'legend' => [
                        'display' => false,
                    ],
                    'scales' => [
                        'xAxes' => [
                        'gridLines' => [
                            'display' => "false"
                        ]
                        ],
                        'yAxes' => [
                        'gridLines' => [
                            'color' => "rgba(0, 0, 0, .125)"
                        ]
                        ]
                    ],
                    ],
                    'data' => [
                        'labels' => ["January", "February", "March", "April", "May", "June", "July"],
                        'datasets' => [
                            [
                                'backgroundColor' => "rgba(2,117,216,0.2)",
                                'borderColor' => "#0080c0",
                                'pointBackgroundColor' => "#0080c0",
                                'pointBorderColor' => "rgba(255,255,255,0.8)",
                                'pointHoverBackgroundColor' => "#0080c0",
                                'pointRadius' => 5,
                                'data' => [65, 59, 90, 81, 56, 55, 40]
                            ],
                            [
                                'backgroundColor' => "rgba(255,99,132,0.2)",
                                'borderColor' => "rgba(255,99,132,1)",
                                'pointBackgroundColor' => "rgba(255,99,132,1)",
                                'pointBorderColor' => "#fff",
                                'pointHoverBackgroundColor' => "rgba(255,99,132,1)",
                                'pointHoverBorderColor' => "#fff",
                                'pointRadius' => 5,
                                'data' => [28, 48, 40, 19, 96, 27, 100]
                            ]
                        ]
                    ]
                ]);
                ?>
            </div>
            <!-- /ChartJS 2amigos -->
            <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>
        </div>

        <div class="card">
            <?php if (isset($registros['Labels'])): ?>
            <div class="card-header">
                <i class="fas fa-chart-area"></i>
                Ejemplo de gráfico de Barras - Registros de leche
            </div>
            <!-- ChartJS 2amigos -->
            
            <div class="card-body">
                <?= ChartJs::widget([
                    'type' => 'bar',
                    'options' => [
                        'height' => "30",
                        'width' => "100%",
                    ],
                    'clientOptions' => [
                        'legend' => [
                            'display' => false,
                        ],
                        'scales' => [
                            'xAxes' => [
                                'time' => [
                                    'unit' => 'day'
                                ],
                                'gridLines' => [
                                    'display' => "false"
                                ]
                            ],
                            'yAxes' => [
                                'ticks' => [
                                    'min' => 0,
                                    'max' => 800,
                                    'maxTicksLimit' => 5
                                ],
                                'gridLines' => [
                                    'color' => "rgba(0, 0, 0, .125)"
                                ]
                            ]
                        ],
                    ],
                    'data' => [
                        'labels' => $registros['Labels'],
                        'datasets' => [
                            [
                                'backgroundColor'=> "rgba(2,117,216,1)",
                                'borderColor'=> "rgba(2,117,216,1)",
                                'data'=> $registros['Data'],
                            ]
                        ]
                    ]
                ]);
                ?>
            </div>
            <!-- /ChartJS 2amigos -->
            <?php endif ?>
            <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>
        </div>

        <div class="card">
            <?php if (isset($registros['Labels'])): ?>
            <div class="card-header">
                <i class="fas fa-chart-area"></i>
                Ejemplo de gráfico de Barras - Registros de leche - Highcharts
            </div>
            <!-- Highcharts -->
            <div class="card-body">

                <?= Highcharts::widget([
                    'options' => [
                        'chart' => ['type' => 'column'],
                        'title' => ['text' => 'Registro de Leche de la Sucural: '.$model['Nombre']],
                        'yAxis' => [
                            'title' => ['text' => 'Litros de Leche']
                        ],
                        'xAxis' => [
                            'categories' => $registros['Labels'],
                            'type' => 'datetime'
                        ],
                        'series' => [
                            ['data' => $registros['Data']]
                        ],
                        'credits' => [
                            'enabled' => false
                        ],
                        'legend' => [
                            'enabled' => false
                        ],
                    ]
                    ]);
                ?>

            </div>
            <!-- /ChartJS 2amigos -->
            <?php endif ?>
            <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>
        </div>

    </div>
</div>