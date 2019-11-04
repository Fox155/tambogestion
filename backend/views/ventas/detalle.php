<?php

use common\models\Ventas;
use common\models\Pagos;
use yii\web\View;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use common\components\FechaHelper;
use kartik\date\DatePicker;
use miloschuman\highcharts\Highcharts;

/* @var $this View */
/* @var $form ActiveForm */
$this->title = 'Detalle de la Venta';
$this->params['breadcrumbs'][] = $this->title;

$layout = <<< HTML
<div class="input-group-prepend"><span class="input-group-text">Desde</span></div>
{input1}
<div class="input-group-append"><span class="input-group-text">hasta</span></div>
{input2}
HTML;

?>
<div class="row">

    <div class="col-sm-12" style="padding-bottom: 15px;">
        <div class="buscar--form">
            <?php $form = ActiveForm::begin(['layout' => 'inline',]); ?>

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
                'layout' => $layout,
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
                <button type="button" class="btn btn-primary"
                        data-modal="<?= Url::to(['/ventas/alta-pago', 'id' => $model['IdVenta']]) ?>" 
                        data-mensaje="Nuevo Pago">
                    Nuevo Pago
                </button>
            </div>
        </div>

        <div id="errores"> </div>

        <?php if (count($pagos) > 0): ?>
        <div class="card">
          <div class="card-header">
            <i class="fas fa-info"></i>
            Pagos de la Venta
          </div>
          <div class="card-body p-0">
              <div class="table-responsive">
                  <table class="table m-0">
                      <thead class="bg-light">
                          <tr class="border-0">
                              <th>Numero de Comprobante</th>
                              <th>Tipo de Comprobante</th>
                              <th>Monto</th>
                              <th>Fecha</th>
                              <th>Estado</th>
                              <th>Acciones</th>
                          </tr>
                      </thead>
                      <tbody>
                        <?php foreach ($pagos as $pago): ?>
                          <tr>
                                <td><?= Html::encode($pago['NroComp']) ?></td>
                                <td><?= Html::encode($pago['TipoComp']) ?></td>
                                <td><?= Html::encode($pago['Monto']) ?></td>
                                <td><?= Html::encode(FechaHelper::toDateLocal($pago['Fecha'])) ?></td>
                                <td><?= Html::encode(Pagos::ESTADOS[$model['Estado']]) ?></td>
                                <td>
                                <!-- Acciones -->
                                <div class="btn-group" role="group" aria-label="...">
          
                                  <button type="button" class="btn btn-default"
                                          data-modal="<?= Url::to(['/ventas/editar-pago', 'idN' => $pago['IdVenta'], 'nro' => $pago['NroPago']]) ?>" 
                                          data-mensaje="Editar">
                                      <i class="fa fa-edit" style="color: Dodgerblue"></i>
                                  </button>
                              
                                  <button type="button" class="btn btn-default"
                                          data-ajax="<?= Url::to(['/ventas/borrar-pago', 'idN' => $pago['IdVenta'], 'nro' => $pago['NroPago']]) ?>"
                                          data-mensaje="Borrar">
                                      <i class="far fa-trash-alt" style="color: Tomato"></i>
                                  </button>

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
            <p><strong>No hay Pagos que coincidan con el criterio de búsqueda utilizado.</strong></p>
        <?php endif; ?>
      
    </div>
</div>