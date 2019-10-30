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

            <?= $form->field($busqueda, 'Cadena')->input('text', ['placeholder' => 'Búsqueda']) ?>

            <?= $form->field($busqueda, 'Check')->checkbox(array('class' => 'check--buscar-form', 'label' => 'Listar Acciones', 'value' => 'S', 'uncheck' => 'N')); ?> 

            <?= Html::submitButton('Buscar', ['class' => 'btn btn-secondary', 'name' => 'pregunta-button']) ?> 

            <?php ActiveForm::end(); ?>
        </div>

        <div class="alta--button">
        
            <div class="alta--button">
                <button type="button" class="btn btn-primary"
                        data-modal="<?= Url::to(['/sucursales/alta']) ?>" 
                        data-mensaje="Nueva Sucursal">
                    Nueva Sucursal
                </button>
            </div>

        <div id="errores"> </div>
        
        <?php if (count($models) > 0): ?>
        <div class="card">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table">
                        <thead class="bg-light">
                            <tr class="border-0">
                                <th>Sucursal</th>
                                <th>Datos</th>
                                <th>Operaciones</th>
                                <?php if ($busqueda['Check'] == 'S'): ?>
                                    <th>Acciones</th>
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
                                    <td>
                                        <!-- Operaciones -->
                                        <div class="btn-group" role="group" aria-label="...">
                                            
                                                <a class="btn btn-default"
                                                        href="<?= Url::to(['/sucursales/detalle', 'id' => $model['IdSucursal']]) ?>"
                                                        data-mensaje="Detalle">
                                                    <i class="fas fa-info" style="color: Dodgerblue"></i>
                                                </a>

                                                <a class="btn btn-default"
                                                        href="<?= Url::to(['/lotes', 'id' => $model['IdSucursal']]) ?>"
                                                        data-mensaje="Lotes">
                                                    <i class="fas fa-sitemap" style="color: Green"></i>
                                                </a>

                                                <a class="btn btn-default"
                                                        href="<?= Url::to(['/vacas', 'idS' => $model['IdSucursal'], 'idL' => 0]) ?>"
                                                        data-mensaje="Vacas">
                                                    <img src="./cow.ico">
                                                </a>

                                        </div>
                                    </td> 
                                    <?php if ($busqueda['Check'] == 'S'): ?>
                                    <td>
                                        <!-- Acciones -->
                                        <div class="btn-group" role="group" aria-label="...">
                  
                                                <button type="button" class="btn btn-default"
                                                        data-modal="<?= Url::to(['/sucursales/editar', 'id' => $model['IdSucursal']]) ?>" 
                                                        data-mensaje="Editar">
                                                    <i class="fa fa-edit" style="color: Dodgerblue"></i>
                                                </button>
                                            
                                                <button type="button" class="btn btn-default"
                                                        data-ajax="<?= Url::to(['/sucursales/borrar', 'id' => $model['IdSucursal']]) ?>"
                                                        data-mensaje="Borrar">
                                                    <i class="far fa-trash-alt" style="color: Tomato"></i>
                                                </button>

                                        </div>
                                    </td> 
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