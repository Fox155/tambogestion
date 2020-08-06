<?php

use backend\models\Menu;
use yii\helpers\Html;
use yii\helpers\Url;
use miloschuman\highcharts\Highcharts;
use yii\bootstrap\ActiveForm;
use kartik\date\DatePicker;

/* @var $this yii\web\View */

$this->title = 'Tambo Gestion';
?>
<div class="row">
  <div class="col-sm-12" style="padding-bottom: 15px;">
    <!-- Icon Cards-->
    <div class="card-group">
      <a class="card text-white bg-success" style="height:120px" href="/ventas/0">
        <div class="card-body">
          <!-- <span class="badge badge-dark">1</span> -->
          <div class="card-body-icon">
            <i class="fas fa-fw fa-shopping-cart"></i>
          </div>
          <div class="mr-5">
            <h4>Ventas</h4>
          </div>
        </div>
        <!-- <a class="card-footer text-white clearfix small z-1" href="/ventas/0">
                <span class="float-left">Detalles</span>
                <span class="float-right">
                  <i class="fas fa-angle-right"></i>
                </span>
              </a> -->
      </a>

      <a class="card text-white bg-primary" style="height:120px" href="/sucursales">
        <div class="card-body">
          <!-- <span class="badge badge-dark">2</span> -->
          <div class="card-body-icon">
            <i class="fas fa-fw fa-kaaba"></i>
          </div>
          <div class="mr-5">
            <h4>Sucursales</h4>
          </div>
        </div>
        <!-- <a class="card-footer text-white clearfix small z-1" href="/sucursales">
                <span class="float-left">Detalles</span>
                <span class="float-right">
                  <i class="fas fa-angle-right"></i>
                </span>
              </a> -->
      </a>

      <a class="card text-white bg-warning" style="height:120px" href="/lotes/0">
        <div class="card-body">
          <!-- <span class="badge badge-dark">3</span> -->
          <div class="card-body-icon">
            <i class="fas fa-fw fa-sitemap"></i>
          </div>
          <div class="mr-5">
            <h4>Lotes</h4>
          </div>
        </div>
        <!-- <a class="card-footer text-white clearfix small z-1" href="/lotes/0">
                <span class="float-left">Lotes</span>
                <span class="float-right">
                  <i class="fas fa-angle-right"></i>
                </span>
              </a> -->
      </a>

      <a class="card text-white bg-danger" style="height:120px" href="/clientes">
        <div class="card-body">
          <!-- <span class="badge badge-dark">4</span> -->
          <div class="card-body-icon">
            <i class="fas fa-fw fa-user-friends"></i>
          </div>
          <div class="mr-5">
            <h4>Clientes</h4>
          </div>
        </div>
        <!-- <a class="card-footer text-white clearfix small z-1" href="/clientes">
                <span class="float-left">Detalles</span>
                <span class="float-right">
                  <i class="fas fa-angle-right"></i>
                </span>
              </a> -->
      </a>

      <a class="card text-white bg-info" style="height:120px" href="/usuarios">
        <div class="card-body">
          <!-- <span class="badge badge-dark">5</span> -->
          <div class="card-body-icon">
            <i class="fas fa-fw fa-id-card"></i>
          </div>
          <div class="mr-5">
            <h4>Usuarios</h4>
          </div>
        </div>
      </a>

      <a class="card text-white" style="height:120px; background-color: SeaGreen;" href="/listas-precio">
        <div class="card-body">
          <!-- <span class="badge badge-dark">6</span> -->
          <div class="card-body-icon">
            <i class="fas fa-fw fa-money-check-alt"></i>
          </div>
          <div class="mr-5">
            <h4>Listas de Precios</h4>
          </div>
        </div>
      </a>

    </div>

  </div>

  <!-- <div class="col-sm-12" style="padding-bottom: 15px;">
      <?php if (isset($model['Nombre'])) : ?>
        <div class="card">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table m-0">
                        <thead class="bg-light">
                            <tr class="border-0">
                                <th>Nombre</th>
                                <th>CUIT</th>
                                <th>Operaciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><?= Html::encode($model['Nombre']) ?></td>
                                <td><?= Html::encode($model['CUIT']) ?></td>
                                <td style="width: 24rem;">
                                    <div class="btn-group" role="group" aria-label="...">

                                      <a class="btn btn-default"
                                          href="<?= Url::to(['/ventas/0']) ?>"
                                          data-mensaje="Ventas">
                                        <i class="fas fa-shopping-cart" style="color: Green"></i>
                                      </a>

                                      <a class="btn btn-default"
                                          href="/sucursales"
                                          data-mensaje="Sucursales">
                                        <i class="fas fa-kaaba" style="color: DodgerBlue"></i>
                                      </a>

                                      <a class="btn btn-default"
                                          href="<?= Url::to(['/lotes/0']) ?>"
                                          data-mensaje="Lotes">
                                        <i class="fas fa-sitemap" style="color: Indigo"></i>
                                      </a>

                                      <a class="btn btn-default"
                                          href="<?= Url::to(['/clientes']) ?>"
                                          data-mensaje="Clientes">
                                        <i class="fas fa-user-friends" style="color: OrangeRed"></i>
                                      </a>

                                      <a class="btn btn-default"
                                          href="<?= Url::to(['/listas-precio']) ?>"
                                          data-mensaje="Lista de Precios">
                                        <i class="fas fa-money-check-alt" style="color: SeaGreen"></i>
                                      </a>

                                      <a class="btn btn-default"
                                          href="<?= Url::to(['/usuarios']) ?>"
                                          data-mensaje="Usuarios">
                                        <i class="fas fa-id-card" style="color: Brown"></i>
                                      </a>

                                    </div>
                                </td> 
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
      <?php endif; ?>
    </div> -->



  <div class="col-sm-6" style="padding-bottom: 15px;">
    <?php if (isset($producciones['Labels'])) : ?>
      <div class="card m-10">
        <div class="card-header m-10">
          <i class="fas fa-chart-area"></i>
          Ejemplo de Resumen ultimas Producciones: <?= Html::encode($model['Nombre']) ?>
        </div>

        <!-- Highcharts -->
        <div class="card-body">
          <!-- <span class="badge badge-danger">7</span> -->
          <?= Highcharts::widget([
            'options' => [
              'chart' => ['type' => 'column'],
              'title' => ['text' => 'Producciones del Tambo: ' . $model['Nombre']],
              'yAxis' => [
                'title' => ['text' => 'Litros de Leche Registrados']
              ],
              'xAxis' => [
                'title' => ['text' => 'Dias'],
                'categories' => $producciones['Labels'],
                'type' => 'date'
              ],
              'series' => [
                ['name' => 'Litros', 'data' => $producciones['Data']]
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
          Actualizado el <?= Html::encode($producciones['Footer']) ?>
        </div>
      </div>
    <?php endif ?>
  </div>

  <div class="col-sm-6" style="padding-bottom: 15px;">
    <?php if (isset($ventas['Labels'])) : ?>
      <div class="card">
        <div class="card-header">
          <i class="fas fa-chart-area"></i>
          Ejemplo de Resumen ultimas Ventas: <?= Html::encode($model['Nombre']) ?>
        </div>

        <!-- Highcharts -->
        <div class="card-body">
          <!-- <span class="badge badge-danger">8</span> -->
          <?= Highcharts::widget([
            'options' => [
              'chart' => ['type' => 'column'],
              'title' => ['text' => 'Ventas del Tambo: ' . $model['Nombre']],
              'yAxis' => [
                'title' => ['text' => 'Monto de Pagos']
              ],
              'xAxis' => [
                'title' => ['text' => 'Dias'],
                'categories' => $ventas['Labels'],
                'type' => 'date'
              ],
              'series' => [
                ['name' => 'Pagos', 'data' => $ventas['Data']]
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
          Actualizado el <?= Html::encode($ventas['Footer']) ?>
        </div>
      </div>
    <?php endif ?>
  </div>

</div>