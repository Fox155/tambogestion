<?php

use common\models\Clientes;
use yii\web\View;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this View */
/* @var $form ActiveForm */
/* @var $models Clientes */

$this->title = 'Clientes';
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

            <?= $form->field($busqueda, 'Check')->checkbox(array('class' => 'check--buscar-form', 'label' => 'Incluir Bajas', 'value' => 'S', 'uncheck' => 'N')); ?> 
            <!-- <span class="badge badge-danger">3</span> -->

            <?php ActiveForm::end(); ?>
        </div>
        
        <div class="alta--button">
            <div class="alta--button">
                <!-- <span class="badge badge-danger">4</span> -->
                <button type="button" class="btn btn-primary"
                        data-modal="<?= Url::to(['/clientes/alta/']) ?>" 
                        data-mensaje="Nuevo Cliente">
                    Nuevo Cliente
                </button>
            </div>

        <div id="errores"> </div>
        
        <?php if (count($models) > 0): ?>
        <!-- <span class="badge badge-danger">5</span> -->
        <div class="card">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table">
                        <thead class="bg-light">
                            <tr class="border-0">
                                <th>Cliente</th>
                                <th>Documento</th>
                                <?php if ($busqueda['Check'] == 'S'): ?>
                                    <th>Estado</th>
                                <?php endif ?>
                                <th>Datos</th>
                                <th>Listas Precio</th>
                                <th>Observaciones</th>                
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($models as $model): ?>
                                <tr>                               
                                    <td><?= Html::encode($model['Apellido']) ?> <?= Html::encode($model['Nombre']) ?></td>           
                                    <td><?= Html::encode($model['TipoDoc']) ?>: <?= Html::encode($model['NroDoc']) ?></td>
                                    <?php if ($busqueda['Check'] == 'S'): ?>
                                        <td><?= Html::encode(Clientes::ESTADOS[$model['Estado']]) ?></td>
                                    <?php endif ?>
                                    <td>
                                    <ul>
                                        <?php foreach (json_decode($model['Datos']) as $nombre => $valor): ?>
                                            <li><?= Html::encode($nombre) ?>: <?= Html::encode($valor) ?></li>
                                        <?php endforeach; ?>
                                    </ul>
                                    </td>
                                    <td><?= Html::encode($model['Lista']) ?> - $<?= Html::encode($model['Precio'])?></td>
                                    <td><?= Html::encode($model['Observaciones']) ?></td>
                                    <td>
                                        <!-- Acciones -->
                                        <div class="btn-group" role="group" aria-label="...">

                                            <button type="button" class="btn btn-default"
                                                    data-modal="<?= Url::to(['/clientes/editar', 'id' => $model['IdCliente']]) ?>" 
                                                    data-mensaje="Editar">
                                                    <!-- <span class="badge badge-danger">6</span> -->
                                                <i class="fa fa-edit" style="color: Dodgerblue"></i>
                                            </button>
                                        
                                            <button type="button" class="btn btn-default"
                                                    data-modal="<?= Url::to(['/clientes/darbaja', 'id' => $model['IdCliente']]) ?>"
                                                    data-mensaje="Borrar">
                                                    <!-- <span class="badge badge-danger">7</span> -->
                                                <i class="far fa-trash-alt" style="color: Tomato"></i>
                                            </button>
                                            <?php if ($model['Estado'] == 'B'): ?>
                                                <button type="button" class="btn btn-default"
                                                    data-ajax="<?= Url::to(['/clientes/activar', 'id' => $model['IdCliente']]) ?>"
                                                    data-mensaje="Activar">
                                                    <!-- <span class="badge badge-danger">8</span> -->
                                                <i class="fas fa-toggle-on" style="color: indigo" > </i>
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