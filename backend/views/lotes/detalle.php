<?php

use common\models\Lotes;
use common\components\FechaHelper;
use yii\web\View;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use miloschuman\highcharts\Highcharts;
use kartik\date\DatePicker;

/* @var $this View */
/* @var $form ActiveForm */
$this->title = 'Detalle del Lote: ' . $model['Nombre'];
$this->params['breadcrumbs'][] = $this->title;

$layoutDatePicker = <<< HTML
<div class="input-group-prepend"><span class="input-group-text">Desde</span></div>
{input1}
<div class="input-group-append"><span class="input-group-text">hasta</span></div>
{input2}
HTML;
?>
<div class="row">
        <!-- Detalle del Lote -->
        <div class="col-sm-12" style="padding-bottom: 15px;">
        <div class="buscar--form">
            <?php $form = ActiveForm::begin(['layout' => 'inline',]); ?>

            <!-- <span class="badge badge-danger">1</span> -->
            <?= DatePicker::widget([
                'model' => $busqueda,
                'type' => DatePicker::TYPE_RANGE,
                'form' => $form,
                'language' => 'es',
                'attribute' => 'FechaInicio',
                'attribute2' => 'FechaFin',
                'options' => ['placeholder' => 'Fecha desde',
                              'autocomplete' => "off",
                              'style' => 'border-top-width: 0px;
                                          border-bottom-width: 0px;
                                          height: 20px;
                                          border-left-width: 0px;
                                          border-right-width: 0px;' ],
                'options2' => ['placeholder' => 'Fecha hasta',
                              'autocomplete' => "off",
                              'style' => 'border-top-width: 0px;
                                          border-bottom-width: 0px;
                                          height: 20px;
                                          border-left-width: 0px;
                                          border-right-width: 0px;' ],
                'separator' => '<div class="input-group-append"><span class="input-group-text">hasta</span></div>',
                'layout' => $layoutDatePicker,
                'pluginOptions' => [
                    'format' => 'dd/mm/yyyy',
                    'autoclose' => true,
                    'clearBtn' => true,
                ]
            ]); ?>

            <!-- <span class="badge badge-danger">2</span> -->
            <?= Html::submitButton('Buscar', ['class' => 'btn btn-secondary', 'name' => 'pregunta-button']) ?> 

            <?php ActiveForm::end(); ?>
        </div>
        <!-- <span class="badge badge-danger">1</span> -->
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-receipt"></i>
                    Detalle del Lote: <?= Html::encode($model['Nombre']) ?>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table m-0">
                            <thead class="bg-light">
                                <tr class="border-0">
                                    <th>Lote</th>
                                    <th>Sucursal</th>
                                    <th>Ganado Total</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><?= Html::encode($model['Nombre']) ?></td>
                                    <td><?= Html::encode($model['Sucursal']) ?></td>
                                    <td><?= Html::encode($model['Ganado']) ?></td>
                                    <td><?= Html::encode(Lotes::ESTADOS[$model['Estado']]) ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>

        <!-- Grafica -->
        <div class="col-sm-12" style="padding-bottom: 15px;">
            
            <?php if (isset($producciones['Labels'])): ?>
                <!-- <span class="badge badge-danger">2</span> -->
                <div class="card">
                    <div class="card-header">
                        <i class="fas fa-chart-area"></i>
                        Promedio de Producciones del Lote
                    </div>

                    <div class="card-body p-0">

                        <?= Highcharts::widget([
                            'options' => [
                                'chart' => ['type' => 'areaspline'],
                                'title' => ['text' => 'Promedio de Producciones del Lote: '.$model['Nombre']],
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
                <p><strong>No hay producciones registradas en este Lote.</strong></p>
            <?php endif; ?>
        </div>

</div>