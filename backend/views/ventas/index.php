<?php

use common\models\Ventas;
use yii\web\View;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use common\components\FechaHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use kartik\date\DatePicker;

/* @var $this View */
/* @var $form ActiveForm */
/* @var $models Clientes */

$this->title = 'Ventas';
$this->params['breadcrumbs'][] = $this->title;

$layoutDatePicker = <<< HTML
<div class="input-group-prepend"><span class="input-group-text">Desde</span></div>
{input1}
<div class="input-group-append"><span class="input-group-text">hasta</span></div>
{input2}
HTML;
?>
<div class="row">
    <div class="col-sm-12">
        <div class="buscar--form">
            <?php $form = ActiveForm::begin(['layout' => 'inline',]); ?>

            <!-- <span class="badge badge-danger">1</span> -->
            <?= $form->field($busqueda, 'Cadena')->input('text', ['placeholder' => 'Búsqueda']) ?>

            <!-- <span class="badge badge-danger">2</span> -->
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

            <!-- <span class="badge badge-danger">3</span> -->
            <?= Html::submitButton('Buscar', ['class' => 'btn btn-secondary', 'name' => 'pregunta-button']) ?> 

            <?= $form->field($busqueda, 'Check')->checkbox(array('class' => 'check--buscar-form', 'label' => 'Incluir Bajas', 'value' => 'S', 'uncheck' => 'N')); ?> 
            <!-- <span class="badge badge-danger">4</span> -->

            <?php ActiveForm::end(); ?>
        </div>
        
        <div class="alta--button">
            <div class="alta--button">
            <?php if (!isset($sucursal['Nombre'])): ?>
                    <!-- <span class="badge badge-danger">5</span> -->
                    <button type="button" class="btn btn-primary"
                            data-modal="<?= Url::to(['/ventas/alta/', 'id' => 0]) ?>" 
                            data-mensaje="Nueva Venta">
                        Nueva Venta
                    </button>
                <?php else: ?>
                    <!-- <span class="badge badge-danger">5</span> -->
                    <button type="button" class="btn btn-primary"
                            data-modal="<?= Url::to(['/ventas/alta/', 'id' => $sucursal['IdSucursal']]) ?>" 
                            data-mensaje="Nueva Venta">
                        Nueva Venta
                    </button>
                <?php endif;?>
            </div>

        <div id="errores"> </div>
        
        <?php if (count($models) > 0): ?>
        <!-- <span class="badge badge-danger">6</span> -->
        <div class="card">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table">
                        <thead class="bg-light">
                            <tr class="border-0">
                                <?php if (!isset($sucursal['Nombre'])): ?>
                                    <th>Sucursal</th>
                                <?php endif ?>
                                <th>Cliente</th>
                                <th>Pagos</th>
                                <th>Litros</th>
                                <th>Monto</th>
                                <th>Fecha</th>
                                <?php if ($busqueda['Check'] == 'S'): ?>
                                    <th>Estado</th>
                                <?php endif ?>  
                                <th>Observaciones</th>                
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($models as $model): ?>
                                <tr>                               
                                    <?php if (!isset($sucursal['Nombre'])): ?>
                                        <td><?= Html::encode($model['Sucursal']) ?></td>
                                    <?php endif ?>
                                    <td><?= Html::encode($model['Cliente']) ?> </td>
                                    <td>
                                        <ul>
                                            <li>Numero de Pagos: <?= Html::encode($model['NroPagos']) ?></li>
                                            <li>Pagos Realizados: <?= Html::encode($model['Pagos']) ?></li>
                                        </ul>
                                    </td>
                                    <td><?= Html::encode($model['Litros']) ?> </td>
                                    <td>
                                        <ul>
                                            <li>Monto Presupuestado: <?= Html::encode($model['MontoPres']) ?></li>
                                            <li>Monto Pagado: <?= Html::encode($model['MontoPagar']) ?></li>
                                        </ul>
                                    </td>
                                    <td><?= Html::encode(FechaHelper::toDatetimeLocal($model['Fecha'])) ?></td>
                                    <?php if ($busqueda['Check'] == 'S'): ?>
                                        <td><?= Html::encode(Ventas::ESTADOS[$model['Estado']]) ?></td>
                                    <?php endif ?>  
                                    <td><?= Html::encode($model['Observaciones']) ?></td>
                                    <td>
                                        <div class="btn-group" role="group" aria-label="...">

                                            <button type="button" class="btn btn-default"
                                                    data-modal="<?= Url::to(['/ventas/alta-pago', 'id' => $model['IdVenta']]) ?>" 
                                                    data-mensaje="Nuevo Pago">
                                                <!-- <span class="badge badge-danger">7</span> -->
                                                <i class="fas fa-plus-circle" style="color: Tomato"></i>
                                            </button>
                                        
                                            <a class="btn btn-default"
                                                    href="<?= Url::to(['/ventas/detalle', 'id' => $model['IdVenta']]) ?>"
                                                    data-mensaje="Detalle">
                                                <!-- <span class="badge badge-danger">8</span> -->
                                                <i class="fas fa-info" style="color: Dodgerblue"></i>
                                            </a>

                                            <button type="button" class="btn btn-default"
                                                    data-modal="<?= Url::to(['/ventas/editar', 'id' => $model['IdVenta']]) ?>" 
                                                    data-mensaje="Editar">
                                                <!-- <span class="badge badge-danger">9</span> -->
                                                <i class="fa fa-edit" style="color: Dodgerblue"></i>
                                            </button>
                                        
                                            <?php if ($model['Estado'] == 'A'): ?>
                                                <button type="button" class="btn btn-default"
                                                        data-modal="<?= Url::to(['/ventas/dar-baja', 'id' => $model['IdVenta']]) ?>"
                                                        data-mensaje="Borrar">
                                                    <!-- <span class="badge badge-danger">10</span> -->
                                                    <i class="far fa-trash-alt" style="color: Tomato"></i>
                                                </button>
                                            <?php endif ?>  

                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <?php else: ?>
            <p><strong>No hay Ventas que coincidan con el criterio de búsqueda utilizado.</strong></p>
        <?php endif; ?>
    </div>
</div>