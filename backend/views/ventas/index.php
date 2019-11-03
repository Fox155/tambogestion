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

            <?= $form->field($busqueda, 'Cadena')->input('text', ['placeholder' => 'Búsqueda']) ?>

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

            <?= Html::submitButton('Buscar', ['class' => 'btn btn-secondary', 'name' => 'pregunta-button']) ?> 

            <?= $form->field($busqueda, 'Check')->checkbox(array('class' => 'check--buscar-form', 'label' => 'Incluir Bajas', 'value' => 'S', 'uncheck' => 'N')); ?> 

            <?php ActiveForm::end(); ?>
        </div>
        
        <div class="alta--button">
            <div class="alta--button">
            <?php if (!isset($sucursal['Nombre'])): ?>
                    <button type="button" class="btn btn-primary"
                            data-modal="<?= Url::to(['/ventas/alta/', 'id' => 0]) ?>" 
                            data-mensaje="Nueva Venta">
                        Nueva Venta
                    </button>
                <?php else: ?>
                    <button type="button" class="btn btn-primary"
                            data-modal="<?= Url::to(['/ventas/alta/', 'id' => $sucursal['IdSucursal']]) ?>" 
                            data-mensaje="Nueva Venta">
                        Nueva Venta
                    </button>
                <?php endif;?>
            </div>

        <div id="errores"> </div>
        
        <?php if (count($models) > 0): ?>
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
                                <th>Numero de Pagos</th>
                                <th>Litros</th>
                                <th>Monto Presupuestado</th>
                                <th>Monto Pagado</th>
                                <th>Pagos Realizados</th>
                                <th>Fecha</th>
                                <th>Estado</th>
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
                                    <td><?= Html::encode($model['Cliente']) ?>
                                    <td><?= Html::encode($model['NroPagos']) ?>
                                    <td><?= Html::encode($model['Litros']) ?>
                                    <td><?= Html::encode($model['MontoPres']) ?>
                                    <td><?= Html::encode($model['MontoPagar']) ?>
                                    <td><?= Html::encode($model['Pagos']) ?></td>
                                    <td><?= Html::encode(FechaHelper::toDatetimeLocal($model['Fecha'])) ?></td>
                                    <td><?= Html::encode($model['Estado']) ?></td>
                                    <td><?= Html::encode($model['Observaciones']) ?></td>
                                    <td>
                                        <div class="btn-group" role="group" aria-label="...">

                                            <button type="button" class="btn btn-default"
                                                    data-modal="<?= Url::to(['/ventas/editar', 'id' => $model['IdVenta']]) ?>" 
                                                    data-mensaje="Editar">
                                                <i class="fa fa-edit" style="color: Dodgerblue"></i>
                                            </button>
                                        
                                            <button type="button" class="btn btn-default"
                                                    data-ajax="<?= Url::to(['/ventas/borrar', 'id' => $model['IdVenta']]) ?>"
                                                    data-mensaje="Borrar">
                                                <i class="far fa-trash-alt" style="color: Tomato"></i>
                                            </button>
                                            <?php if ($model['Estado'] == 'B'): ?>
                                                <button type="button" class="btn btn-default"
                                                    data-ajax="<?= Url::to(['/ventas/activar', 'id' => $model['IdVenta']]) ?>"
                                                    data-mensaje="Activar">
                                                <i class="fas fa-toggle-on" style="color: indigo" > </i>
                                                </button>
                                            <?php else: ?>
                                                <button type="button" class="btn btn-default"
                                                    data-ajax="<?= Url::to(['/ventas/darbaja', 'id' => $model['IdVenta']]) ?>"
                                                    data-mensaje="Dar de Baja">
                                                <i class="fas fa-toggle-off" style="color: indigo"></i>
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
            <p><strong>No hay Clientes que coincidan con el criterio de búsqueda utilizado.</strong></p>
        <?php endif; ?>
    </div>
</div>