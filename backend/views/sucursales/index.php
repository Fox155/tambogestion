<?php

use common\models\Sucursales;
use yii\web\View;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
// use nullref\datatable\DataTable;

/* @var $this View */
/* @var $form ActiveForm */
$this->title = 'Sucursales';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-sm-12">
        <div class="buscar--form">
            <?php $form = ActiveForm::begin(['layout' => 'inline',]); ?>

            <!-- <span class="badge badge-danger">1</span> -->
            <?= $form->field($busqueda, 'Cadena')->input('text', ['placeholder' => 'Búsqueda']) ?>

            <!-- <span class="badge badge-danger">2</span> -->
            <?= Html::submitButton('Buscar', ['class' => 'btn btn-secondary', 'name' => 'pregunta-button']) ?>

            <?="" //$form->field($busqueda, 'Check')->checkbox(array('class' => 'check--buscar-form', 'label' => 'Listar Acciones', 'value' => 'S', 'uncheck' => 'N')); ?> 

            <?php ActiveForm::end(); ?>
        </div>

        <div class="alta--button">
        
            <div class="alta--button">
            <!-- <span class="badge badge-danger">3</span> -->
                <button type="button" class="btn btn-primary"
                        data-modal="<?= Url::to(['/sucursales/alta']) ?>" 
                        data-mensaje="Nueva Sucursal">
                    Nueva Sucursal
                </button>
            </div>

        </div>

        <div id="errores"> </div>
        
        <?php if (count($models) > 0): ?>
        <!-- <span class="badge badge-danger">4</span> -->
        <div class="card">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table">
                        <thead class="bg-light">
                            <tr class="border-0">
                                <th>Sucursal</th>
                                <th>Datos</th>
                                <th>Litros Registrados</th>
                                <th>Operaciones</th>
                                <?php if ($busqueda['Check'] == 'S'): ?>
                                    <!-- <th>Acciones</th> -->
                                <?php endif ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($models as $model): ?>
                                <tr>
                                    <td><?= Html::encode($model['Nombre']) ?></td>
                                    <td>
                                        <ul>
                                        <?php foreach (json_decode($model['Datos']) as $nombre => $valor): ?>
                                            <li><?= Html::encode($nombre) ?>: <?= Html::encode($valor) ?></li>
                                        <?php endforeach; ?>
                                        </ul>
                                    </td>
                                    <td><?= Html::encode($model['Litros']) ?></td>
                                    <td>
                                        <!-- Operaciones -->
                                        <div class="btn-group" role="group" aria-label="...">

                                                <button type="button" class="btn btn-default"
                                                        data-modal="<?= Url::to(['/sucursales/alta-registro', 'id' => $model['IdSucursal']]) ?>" 
                                                        data-mensaje="Añadir Registro de Leche">
                                                        <!-- <span class="badge badge-danger">5</span> -->
                                                    <i class="fas fa-plus-circle" style="color: Tomato"></i>
                                                </button>
                                            
                                                <a class="btn btn-default"
                                                        href="<?= Url::to(['/sucursales/detalle', 'id' => $model['IdSucursal']]) ?>"
                                                        data-mensaje="Detalle">
                                                        <!-- <span class="badge badge-danger">6</span> -->
                                                    <i class="fas fa-info" style="color: Dodgerblue"></i>
                                                </a>

                                                <a class="btn btn-default"
                                                    href="<?= Url::to(['/ventas', 'id' => $model['IdSucursal']]) ?>"
                                                    data-mensaje="Ventas">
                                                    <!-- <span class="badge badge-danger">7</span> -->
                                                    <i class="fas fa-shopping-cart" style="color: Green"></i>
                                                </a>

                                                <a class="btn btn-default"
                                                        href="<?= Url::to(['/lotes', 'id' => $model['IdSucursal']]) ?>"
                                                        data-mensaje="Lotes">
                                                        <!-- <span class="badge badge-danger">8</span> -->
                                                    <i class="fas fa-sitemap" style="color: Indigo"></i>
                                                </a>

                                                <a class="btn btn-default"
                                                        href="<?= Url::to(['/vacas', 'idS' => $model['IdSucursal'], 'idL' => 0]) ?>"
                                                        data-mensaje="Vacas">
                                                        <!-- <span class="badge badge-danger">9</span> -->
                                                    <!-- <img src="./cow.ico"> -->
                                                    <i class="fas fa-hat-cowboy-side" style="color: Brown"></i>
                                                </a>

                                                <button type="button" class="btn btn-default"
                                                        data-modal="<?= Url::to(['/sucursales/editar', 'id' => $model['IdSucursal']]) ?>" 
                                                        data-mensaje="Editar">
                                                        <!-- <span class="badge badge-danger">10</span> -->
                                                    <i class="fa fa-edit" style="color: Dodgerblue"></i>
                                                </button>
                                            
                                                <button type="button" class="btn btn-default"
                                                        data-modal="<?= Url::to(['/sucursales/borrar', 'id' => $model['IdSucursal']]) ?>"
                                                        data-mensaje="Borrar">
                                                        <!-- <span class="badge badge-danger">11</span> -->
                                                    <i class="far fa-trash-alt" style="color: Tomato"></i>
                                                </button>

                                        </div>
                                    </td> 
                                    <?php if ($busqueda['Check'] == 'S'): ?>
                                    <!-- <td>
                                        Acciones
                                        <div class="btn-group" role="group" aria-label="...">
                  
                                                

                                        </div>
                                    </td>  -->
                                    <?php endif ?>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <?php else: ?>
            <p><strong>No hay sucursales que coincidan con el criterio de búsqueda utilizado.</strong></p>
        <?php endif; ?>

    </div>
</div>