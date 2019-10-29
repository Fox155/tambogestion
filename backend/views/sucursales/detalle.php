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
        <!-- Icon Cards-->
        <div class="row">

          <div class="col-xl-3 col-sm-6 mb-3">
            <div class="card text-white bg-primary o-hidden h-100">
              <div class="card-body">
                <div class="card-body-icon">
                  <i class="fas fa-fw fa-comments"></i>
                </div>
                <div class="mr-5">26 New Messages!</div>
              </div>
              <a class="card-footer text-white clearfix small z-1" href="#">
                <span class="float-left">View Details</span>
                <span class="float-right">
                  <i class="fas fa-angle-right"></i>
                </span>
              </a>
            </div>
          </div>

          <div class="col-xl-3 col-sm-6 mb-3">
            <div class="card text-white bg-warning o-hidden h-100">
              <div class="card-body">
                <div class="card-body-icon">
                  <i class="fas fa-fw fa-list"></i>
                </div>
                <div class="mr-5">11 New Tasks!</div>
              </div>
              <a class="card-footer text-white clearfix small z-1" href="#">
                <span class="float-left">View Details</span>
                <span class="float-right">
                  <i class="fas fa-angle-right"></i>
                </span>
              </a>
            </div>
          </div>

          <div class="col-xl-3 col-sm-6 mb-3">
            <div class="card text-white bg-success o-hidden h-100">
              <div class="card-body">
                <div class="card-body-icon">
                  <i class="fas fa-fw fa-shopping-cart"></i>
                </div>
                <div class="mr-5">123 New Orders!</div>
              </div>
              <a class="card-footer text-white clearfix small z-1" href="#">
                <span class="float-left">View Details</span>
                <span class="float-right">
                  <i class="fas fa-angle-right"></i>
                </span>
              </a>
            </div>
          </div>

          <div class="col-xl-3 col-sm-6 mb-3">
            <div class="card text-white bg-danger o-hidden h-100">
              <div class="card-body">
                <div class="card-body-icon">
                  <i class="fas fa-fw fa-life-ring"></i>
                </div>
                <div class="mr-5">13 New Tickets!</div>
              </div>
              <a class="card-footer text-white clearfix small z-1" href="#">
                <span class="float-left">View Details</span>
                <span class="float-right">
                  <i class="fas fa-angle-right"></i>
                </span>
              </a>
            </div>
          </div>

        </div>
        <!-- Icon Cards-->

        <?php if (isset($registros['Labels'])): ?>
        <div class="card mb-3">
            <div class="card-header">
                <i class="fas fa-chart-area"></i>
                Ejemplo de gráfico de Barras - Registros de Leche de la Sucursal: <?= Html::encode($model['Nombre']) ?>
            </div>
            <!-- Highcharts -->
            <div class="card-body">

                <?= Highcharts::widget([
                    'options' => [
                        'chart' => ['type' => 'column'],
                        'title' => ['text' => 'Registros de Leche de la Sucural: '.$model['Nombre']],
                        'yAxis' => [
                            'title' => ['text' => 'Litros de Leche']
                        ],
                        'xAxis' => [
                            'categories' => $registros['Labels'],
                            'type' => 'datetime'
                        ],
                        'series' => [
                            ['name' => 'Valor','data' => $registros['Data']]
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
            <!-- /Highcharts -->
            <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>
        </div>
        <?php endif ?>

    </div>
</div>