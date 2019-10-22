<?php

use backend\models\Menu;
use dosamigos\chartjs\ChartJs;

/* @var $this yii\web\View */

$this->title = 'Tambo Gestion';
?>
<div class="row">
    <div class="col-sm-12">
        <div class="card mb-3">
          <div class="card-header">
            <i class="fas fa-chart-area"></i>
            Ejemplo de gráfico de área - 2amigos
          </div>
          <div class="card-body">
            <!-- ChartJS 2amigos -->
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
            <!-- /ChartJS 2amigos -->
          </div>
          <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>
        </div>

        <div class="col-lg-4">
            <!-- Grafico de Torta -->
            <div class="card mb-3">
              <div class="card-header">
                <i class="fas fa-chart-pie"></i>
                Ejemplo de gráfico circular - 2amigos</div>
              <div class="card-body">
                <?=ChartJs::widget([
                    'type' => 'pie',
                    'id' => 'structurePie',
                    'options' => [
                        'height' => 200,
                        'width' => 400,
                    ],
                    'data' => [
                        'radius' =>  "90%",
                        'labels' => ['Label 1', 'Label 2', 'Label 3'], // Your labels
                        'datasets' => [
                            [
                                'data' => ['35.6', '17.5', '46.9'], // Your dataset
                                'label' => '',
                                'backgroundColor' => [
                                        '#ADC3FF',
                                        '#FF9A9A',
                                    'rgba(190, 124, 145, 0.8)'
                                ],
                                'borderColor' =>  [
                                        '#fff',
                                        '#fff',
                                        '#fff'
                                ],
                                'borderWidth' => 1,
                                'hoverBorderColor'=>["#999","#999","#999"],                
                            ]
                        ]
                    ],
                    'clientOptions' => [
                        'legend' => [
                            'display' => false,
                            'position' => 'bottom',
                            'labels' => [
                                'fontSize' => 14,
                                'fontColor' => "#425062",
                            ]
                        ],
                        'tooltips' => [
                            'enabled' => true,
                            'intersect' => true
                        ],
                        'hover' => [
                            'mode' => false
                        ],
                        'maintainAspectRatio' => false,

                    ]
                    ]);
                ?>
              </div>
              <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>
            </div>
            <!-- /Grafico de Torta -->
          </div>
          
    </div>
</div>