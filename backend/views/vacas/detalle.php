<?php

use common\models\Vacas;
use yii\web\View;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use backend\assets\VacasAsset;
use miloschuman\highcharts\Highcharts;
use yii\bootstrap\ActiveForm;
use kartik\date\DatePicker;

VacasAsset::register($this);

/* @var $this View */
/* @var $form ActiveForm */
$this->title = 'Detalle de la Vaca: ' . $model['Nombre'];
$this->params['breadcrumbs'][] = $this->title;

$modelJson = json_encode($model);

$this->registerJs("Vacas.iniciar($modelJson);");
?>
<div class="row">
    <div class="col-sm-12" id="vacas">
        <div class="col-sm-12">
            <p><strong>Detalle.</strong></p>

            <div class="card">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table">
                            <thead class="bg-light">
                                <tr class="border-0">
                                    <th>Nombre</th>
                                    <th>Lote</th>
                                    <th>Caravana</th>
                                    <th>RFID</th>
                                    <th>Peso</th>
                                    <th>Fecha de Nacimiento</th>
                                    <th>Estado</th>
                                    <th>Observaciones</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{ vaca.Nombre }}</td>
                                    <td>{{ vaca.Lote }}</td>
                                    <td>{{ vaca.IdCaravana }}</td>
                                    <td>{{ vaca.RFID }}</td>
                                    <td>{{ vaca.Peso }}</td>
                                    <td>{{ vaca.FechaNac }}</td>
                                    <td>{{ vaca.Estado }}</td>
                                    <td>{{ vaca.Observaciones }}</td>
                                    <td>
                                        <button type="button" class="btn btn-default"
                                                data-hint="Topo Boton">
                                            <i class="fab fa-telegram-plane"></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>

        <div class="col-sm-12">
            <p><strong>Lactancias.</strong></p>

            <div class="card">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table">
                            <thead class="bg-light">
                                <tr class="border-0">
                                    <th>Nombre</th>
                                    <th>Lote</th>
                                    <th>Caravana</th>
                                    <th>RFID</th>
                                    <th>Peso</th>
                                    <th>Fecha de Nacimiento</th>
                                    <th>Estado</th>
                                    <th>Observaciones</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{ vaca.Nombre }}</td>
                                    <td>{{ vaca.Lote }}</td>
                                    <td>{{ vaca.IdCaravana }}</td>
                                    <td>{{ vaca.RFID }}</td>
                                    <td>{{ vaca.Peso }}</td>
                                    <td>{{ vaca.FechaNac }}</td>
                                    <td>{{ vaca.Estado }}</td>
                                    <td>{{ vaca.Observaciones }}</td>
                                    <td>
                                        <button type="button" class="btn btn-default"
                                                data-hint="Topo Boton">
                                            <i class="fab fa-telegram-plane"></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-12">
            <p><strong>Producciones ultima Lactancia.</strong></p>

            <?php if (isset($producciones['Labels'])): ?>
            <div class="card mb-3">
                <div class="card-header">
                    <i class="fas fa-chart-area"></i>
                    Ejemplo de gráfico de Barras - Producciones de la Vaca: <?= Html::encode($model['Nombre']) ?>
                </div>

                <div class="col-sm-12">
                    <?php $form = ActiveForm::begin([
                    ]); ?>

                    <?= DatePicker::widget([
                        'model' => $busqueda,
                        'attribute' => 'FechaInicio',
                        'attribute2' => 'FechaFin',
                        'options' => ['placeholder' => 'Fecha desde'],
                        'options2' => ['placeholder' => 'Fecha hasta'],
                        'separator' => '  hasta  ',
                        'type' => DatePicker::TYPE_RANGE,
                        'form' => $form,
                        'pluginOptions' => [
                            'format' => 'yyyy-mm-dd',
                            'autoclose' => true,
                        ]
                    ]);
                    ?>

                    <?= Html::submitButton('Buscar', ['class' => 'btn btn-secondary', 'name' => 'pregunta-button']) ?> 

                    <?php ActiveForm::end(); ?>
                </div>

                <!-- Highcharts -->
                <div class="card-body">

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
                <!-- /Highcharts -->
                <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>
            </div>
            <?php endif ?>
        </div>

    </div>
</div>