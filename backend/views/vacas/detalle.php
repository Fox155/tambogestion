<?php

use common\models\Vacas;
use common\components\FechaHelper;
use common\components\LecheHelper;
use yii\web\View;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use miloschuman\highcharts\Highcharts;
use kartik\date\DatePicker;

/* @var $this View */
/* @var $form ActiveForm */
$this->title = 'Detalle de la Vaca: ' . $model['Nombre'];
$this->params['breadcrumbs'][] = $this->title;

$layoutDatePicker = <<< HTML
<div class="input-group-prepend"><span class="input-group-text">Desde</span></div>
{input1}
<div class="input-group-append"><span class="input-group-text">hasta</span></div>
{input2}
HTML;
?>
<div class="row">
        <!-- Detalle Vaca -->
        <div class="col-sm-12" style="padding-bottom: 15px;">

            <div class="card">
                <div class="card-header">
                    <i class="fas fa-receipt"></i>
                    Detalle de la Vaca: <?= Html::encode($model['Nombre']) ?>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table m-0">
                            <thead class="bg-light">
                                <tr class="border-0">
                                    <th>Nombre</th>
                                    <th>Lote</th>
                                    <th>Caravana</th>
                                    <th>RFID</th>
                                    <th>Peso</th>
                                    <th>Fecha de Nacimiento</th>
                                    <?php if (count($lactancias) > 0): ?>
                                        <th>Edad en Meses</th>
                                    <?php endif; ?>
                                    <th>Estado</th>
                                    <th>Observaciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><?= Html::encode($model['Nombre']) ?></td>
                                    <td><?= Html::encode($model['Lote']) ?></td>
                                    <td><?= Html::encode($model['IdCaravana']) ?></td>
                                    <td><?= Html::encode($model['IdRFID']) ?></td>
                                    <td><?= Html::encode($model['Peso']) ?></td>
                                    <td><?= Html::encode(FechaHelper::toDateLocal($model['FechaNac'])) ?></td>
                                    <?php if (count($lactancias) > 0): ?>
                                        <td><?= Html::encode($lactancias[0]['Meses']) ?></td>
                                    <?php endif; ?>
                                    <td><?= Html::encode(Vacas::ESTADOS[$model['Estado']]) ?></td>
                                    <td><?= Html::encode($model['Observaciones']) ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>

        <!-- Lactancias -->
        <div class="col-sm-12" style="padding-bottom: 15px;">
            <div id="errores"> </div>
            
            <?php if (count($lactancias) > 0): ?>
                <div class="card">
                    <div class="card-header">
                        <i class="fas fa-file-alt"></i>
                        Lactancias
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table">
                                <thead class="bg-light">
                                    <tr class="border-0">
                                        <th>Numero de Lactancia</th>
                                        <th>Fecha de Inicio</th>
                                        <th>Fecha de Fin</th>
                                        <th>Acumulada</th>
                                        <th>Dias de la Lactancia</th>
                                        <th>Corregida a 305</th>
                                        <th>Observaciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($lactancias as $lactancia): ?>
                                        <tr>
                                            <td><?= Html::encode($lactancia['NroLactancia']) ?></td>
                                            <td><?= Html::encode(FechaHelper::toDateLocal($lactancia['FechaInicio'])) ?></td>
                                            <td>
                                                <?php if (!isset($lactancia['FechaFin'])): ?>
                                                    <?= Html::encode(FechaHelper::toDateLocal($lactancia['FechaFin'])) ?>
                                                <?php endif ?>
                                            </td>
                                            <td><?= Html::encode($lactancia['Acumulada']) ?></td>
                                            <td><?= Html::encode($lactancia['Dias']) ?></td>
                                            <td><?= Html::encode(LecheHelper::corregida($lactancia['Acumulada'], $lactancia['Meses'], $lactancia['Dias'])) ?></td>
                                            <td><?= Html::encode($lactancia['Observaciones']) ?></td> 
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            <?php else: ?>
                <p><strong>La Vaca no tuvo lactancias registradas.</strong></p>
            <?php endif; ?>
        </div>

        <!-- Grafica -->
        <div class="col-sm-12" style="padding-bottom: 15px;">
            
            <?php if (isset($producciones['Labels'])): ?>
                <div class="card">
                    <div class="card-header">
                        <i class="fas fa-chart-area"></i>
                        Producciones ultima Lactancia
                    </div>

                    <div class="card-body p-0">

                        <?= Highcharts::widget([
                            'options' => [
                                'chart' => ['type' => 'areaspline'],
                                'title' => ['text' => 'Producciones de la Vaca: '.$model['Nombre']],
                                'yAxis' => [
                                    'title' => ['text' => 'Litros de Leche']
                                ],
                                'xAxis' => [
                                    'categories' => $producciones['Labels'],
                                    'type' => 'datetime'
                                ],
                                'series' => [
                                    ['name' => 'Valor','data' => $producciones['Data']]
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

                    <div class="card-footer small text-muted">
                        Actualizado: <?= Html::encode(FechaHelper::toDatetimeLocal( date('Y-m-d h:m:s') )) ?>
                    </div>
                </div>
            <?php else: ?>
                <p><strong>La Vaca no tuvo lactancias registradas.</strong></p>
            <?php endif; ?>
        </div>

</div>