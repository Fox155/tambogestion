<?php

use backend\models\Menu;
use dosamigos\chartjs\ChartJs;

/* @var $this yii\web\View */

$this->title = 'Tambo Gestion';
?>
<div class="row">
    <div class="col-sm-12">
        <!-- Icon Cards-->
        <div class="row">

          <div class="col-xl-3 col-sm-6 mb-3">
            <div class="card text-white bg-primary o-hidden h-100">
              <div class="card-body">
                <div class="card-body-icon">
                  <i class="fas fa-fw fa-kaaba"></i>
                </div>
                <div class="mr-5">Sucursales</div>
              </div>
              <a class="card-footer text-white clearfix small z-1" href="/sucursales">
                <span class="float-left">Detalles</span>
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
                <div class="mr-5">Ventas</div>
              </div>
              <a class="card-footer text-white clearfix small z-1" href="/ventas/0">
                <span class="float-left">Detalles</span>
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
                  <i class="fas fa-fw fa-sitemap"></i>
                </div>
                <div class="mr-5">Lotes</div>
              </div>
              <a class="card-footer text-white clearfix small z-1" href="/lotes/0">
                <span class="float-left">Lotes</span>
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
                  <i class="fas fa-fw fa-user-friends"></i>
                </div>
                <div class="mr-5">Clientes</div>
              </div>
              <a class="card-footer text-white clearfix small z-1" href="/clientes">
                <span class="float-left">Detalles</span>
                <span class="float-right">
                  <i class="fas fa-angle-right"></i>
                </span>
              </a>
            </div>
          </div>

        </div>

    </div>
</div>