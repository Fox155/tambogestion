<?php

use common\models\Sucursales;
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
$this->title = 'Detalle de la Sucursal: ' . $model['Nombre'];
$this->params['breadcrumbs'][] = $this->title;

$layout3 = <<< HTML
<div class="input-group-prepend"><span class="input-group-text">Desde</span></div>
{input1}
<div class="input-group-append"><span class="input-group-text">hasta</span></div>
<!-- {separator} -->
{input2}
<!-- <div class="input-group-append">
    <span class="input-group-text kv-date-remove">
        <i class="fas fa-times kv-dp-icon"></i>
    </span>
</div> -->
HTML;

?>
<div class="row">

    <!-- Usuarios -->
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
                // 'removeButton' => '',
                'layout' => $layout3,
                'pluginOptions' => [
                    'format' => 'dd/mm/yyyy',
                    'autoclose' => true,
                    'clearBtn' => true,
                ]
            ]); ?>
            <!-- <div class="input-group-append">
                <span class="input-group-text kv-date-remove">
                    <i class="fas fa-times kv-dp-icon"></i>
                </span>
            </div> -->

            <?= Html::submitButton('Buscar', ['class' => 'btn btn-secondary', 'name' => 'pregunta-button']) ?> 

            <?php ActiveForm::end(); ?>
        </div>

        <div class="alta--button">
            <div class="alta--button">
                <button type="button" class="btn btn-primary"
                        data-modal="<?= Url::to(['/sucursales/asignar-usuario', 'id' => $model['IdSucursal']]) ?>" 
                        data-mensaje="Asignar Usuario">
                    <i class="fas fa-id-card"></i>
                    Asignar Usuario
                </button>
            </div>
        </div>

        <div id="errores"> </div>

      <?php if (count($usuarios) > 0): ?>
        <div class="card">
          <div class="card-header">
            <i class="fas fa-id-card"></i>
            Usuarios de la Sucursal: <?= Html::encode($model['Nombre']) ?>
          </div>
          <div class="card-body p-0">
              <div class="table-responsive">
                  <table class="table m-0">
                      <thead class="bg-light">
                          <tr class="border-0">
                              <th>Usuario</th>
                              <th>Email</th>
                              <th>Fecha de Alta</th>
                              <th>Tipo de Usuario</th>
                              <th>Acciones</th>
                          </tr>
                      </thead>
                      <tbody>
                        <?php foreach ($usuarios as $usuario): ?>
                          <tr>
                              <td><?= Html::encode($usuario['Usuario']) ?></td>
                              <td><?= Html::encode($usuario['Email']) ?></td>
                              <td><?= Html::encode(FechaHelper::toDateLocal($usuario['FechaAlta'])) ?></td>
                              <td><?= Html::encode($usuario['Tipo']) ?></td>
                              <td>
                                <!-- Acciones -->
                                <div class="btn-group" role="group" aria-label="...">
                              
                                  <button type="button" class="btn btn-default"
                                          data-ajax="<?= Url::to(['/sucursales/desasignar-usuario', 'idU' => $usuario['IdUsuario'], 'idS' => $model['IdSucursal']]) ?>"
                                          data-mensaje="Desasignar Usuario">
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
          <p><strong>No hay usuarios que coincidan con el criterio de búsqueda utilizado.</strong></p>
      <?php endif; ?>
    </div>

    <!-- Grafica -->
    <div class="col-sm-12" style="padding-bottom: 15px;">
      <?php if (isset($resumen['Labels'])): ?>
      <div class="card">
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
                          'categories' => $resumen['Labels'],
                          'type' => 'datetime'
                      ],
                      'series' => [
                          ['name' => 'Valor','data' => $resumen['Data']]
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
          <div class="card-footer small text-muted">
            Actualizado el <?= Html::encode($resumen['Footer']) ?>
          </div>
      </div>
      <?php endif ?>
    </div>
    
    <!-- Registros -->
    <div class="col-sm-12" style="padding-bottom: 15px;">

        <div class="alta--button">
            <div class="alta--button">
                <button type="button" class="btn btn-primary"
                        data-modal="<?= Url::to(['/sucursales/alta-registro', 'id' => $model['IdSucursal']]) ?>" 
                        data-mensaje="Añadir Registro de Leche">
                    <i class="fas fa-receipt"></i>
                    Añadir Registro de Leche
                </button>
            </div>
        </div>

        <div id="errores"> </div>

      <?php if (count($registros) > 0): ?>
        <div class="card">
          <div class="card-header">
            <i class="fas fa-receipt"></i>
            Registros de Leche de la Sucursal: <?= Html::encode($model['Nombre']) ?>
          </div>
          <div class="card-body p-0">
              <div class="table-responsive">
                  <table class="table m-0">
                      <thead class="bg-light">
                          <tr class="border-0">
                              <th>Fecha</th>
                              <th>Litros</th>
                              <th>Acciones</th>
                          </tr>
                      </thead>
                      <tbody>
                        <?php foreach ($registros as $registro): ?>
                          <tr>
                              <td><?= Html::encode(FechaHelper::toDateLocal($registro['Fecha'])) ?></td>
                              <td><?= Html::encode($registro['Litros']) ?></td>
                              <td>
                                <!-- Acciones -->
                                <div class="btn-group" role="group" aria-label="...">
          
                                  <button type="button" class="btn btn-default"
                                          data-modal="<?= Url::to(['/sucursales/editar-registro', 'id' => $registro['IdRegistroLeche']]) ?>" 
                                          data-mensaje="Editar">
                                      <i class="fa fa-edit" style="color: Dodgerblue"></i>
                                  </button>
                              
                                  <button type="button" class="btn btn-default"
                                          data-ajax="<?= Url::to(['/sucursales/borrar-registro', 'id' => $registro['IdRegistroLeche']]) ?>"
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
        <p><strong>No hay registros que coincidan con el criterio de búsqueda utilizado.</strong></p>
      <?php endif; ?>
    </div>

</div>