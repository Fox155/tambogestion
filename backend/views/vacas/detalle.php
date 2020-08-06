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

foreach ($anterior as $ante){
    $this->params['breadcrumbs'][] = $ante;
}
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
        <!-- <span class="badge badge-danger">1</span> -->
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
                                    <th>Identificadores</th>
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
                                    <td>
                                        <div style="list-style-type: none;">
                                            <li>
                                            Caravana: <?= Html::encode($model['IdCaravana']) ?>
                                            </li>
                                            <li>
                                            RFID: <?= Html::encode($model['IdRFID']) ?>
                                            </li>
                                        </div>
                                    </td>
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
            <!-- <span class="badge badge-danger">2</span> -->
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
                                        <th>Lactancia</th>
                                        <th>Fechas</th>
                                        <th>Corregida a 305</th>
                                        <th>Acumulada</th>
                                        <th>Promedio</th>
                                        <th>Pico</th>
                                        <th>Dias de la Lactancia</th>
                                        <th>Dias a Pico</th>
                                        <th>Observaciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($lactancias as $i => $lactancia): ?>
                                        <tr>
                                            <td>Numero: <?= Html::encode($lactancia['NroLactancia']) ?></td>
                                            <td style="list-style-type: none;">
                                                <li>
                                                    Inicio: <?= Html::encode(FechaHelper::toDateLocal($lactancia['FechaInicio'])) ?>
                                                </li>
                                                <li>
                                                    Pico: <?= Html::encode(FechaHelper::toDateLocal($lactancia['FechaPico'])) ?>
                                                </li>
                                                <?php if ($lactancia['FechaFin'] != ''): ?>
                                                    <li>
                                                        Fin: <?= Html::encode(FechaHelper::toDateLocal($lactancia['FechaFin'])) ?>
                                                    </li>
                                                <?php endif ?>
                                            </td>
                                            <td><?= Html::encode(LecheHelper::corregida($lactancia['Acumulada'], $lactancia['Meses'], $lactancia['Dias'])) ?></td>
                                            <td><?= Html::encode($lactancia['AcumuladaL']) ?></td>
                                            <td><?= Html::encode($lactancia['PromedioL']) ?></td>
                                            <td><?= Html::encode($lactancia['Pico']) ?></td>
                                            <td><?= Html::encode($lactancia['Dias']) ?></td>
                                            <td><?= Html::encode($lactancia['DiasPico']) ?></td>
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
            
            <?php if (isset($lactancias[0]['Labels'])): ?>
                <!-- <span class="badge badge-danger">3</span> -->
                <div class="card">
                    <div class="card-header">
                        <i class="fas fa-chart-area"></i>
                        Producciones de la Ultima Lactancia
                    </div>

                    <div class="card-body p-0">

                        <?= Highcharts::widget([
                            'options' => [
                                'chart' => ['type' => 'areaspline'],
                                'title' => ['text' => 'Producciones de la Ultima Lactancia de la Vaca: '.$model['Nombre']],
                                'yAxis' => [
                                    'title' => ['text' => 'Litros de Leche']
                                ],
                                'xAxis' => [
                                    'categories' => $lactancias[0]['Labels'],
                                    'type' => 'datetime'
                                ],
                                'series' => [
                                    ['name' => 'Valor','data' => $lactancias[0]['Data']]
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
                        Actualizado: <?= Html::encode($lactancias[0]['Footer']) ?>
                    </div>
                </div>
            <?php else: ?>
            <?php endif; ?>
                <!-- <p><strong>La Vaca no tuvo lactancias registradas.</strong></p> -->
        </div>

        <!-- Historico -->
        <div class="col-sm-12" style="padding-bottom: 15px;">
            
            <?php if (isset($lactancias[0]['Labels'])): ?>
                <!-- <span class="badge badge-danger">3</span> -->
                <div class="card">
                    <div class="card-header">
                        <i class="fas fa-chart-area"></i>
                        Producciones de todas las Lactancias
                    </div>

                    <div class="card-body p-0">
                        <?php 
                            $seriesL = array();
                            foreach($lactancias as $i => $lactancia){
                                $seriesL[$i]['name'] = 'Lactancia Nro: '.$lactancia['NroLactancia'];
                                $seriesL[$i]['data'] = $lactancias[$i]['Data'];
                            }
                        ?>

                        <?= Highcharts::widget([
                            'options' => [
                                'chart' => ['type' => 'areaspline'],
                                'title' => ['text' => 'Producciones de todas las Lactancias de la Vaca: '.$model['Nombre']],
                                'yAxis' => [
                                    'title' => ['text' => 'Litros de Leche']
                                ],
                                'series' => $seriesL,
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
                        Actualizado: <?= Html::encode($lactancias[0]['Footer']) ?>
                    </div>
                </div>
            <?php else: ?>
            <?php endif; ?>
                <!-- <p><strong>La Vaca no tuvo lactancias registradas.</strong></p> -->
        </div>

</div>