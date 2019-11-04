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

            <?= $form->field($busqueda, 'Cadena')->input('text', ['placeholder' => 'Búsqueda']) ?>

            <?= Html::submitButton('Buscar', ['class' => 'btn btn-secondary', 'name' => 'pregunta-button']) ?> 

            <?= $form->field($busqueda, 'Check')->checkbox(array('class' => 'check--buscar-form', 'label' => 'Incluir Bajas', 'value' => 'S', 'uncheck' => 'N')); ?> 

            <?= $form->field($busqueda, 'Check2')->checkbox(array('class' => 'check--buscar-form', 'label' => 'Listar Acciones', 'value' => 'S', 'uncheck' => 'N')); ?> 

            <?php ActiveForm::end(); ?>
        </div>
        
        <div class="alta--button">
            <div class="alta--button">
                <?php if (!isset($listasprecio['IdListaPrecio'])): ?>
                    <button type="button" class="btn btn-primary"
                            data-modal="<?= Url::to(['/clientes/alta/', 'id' => 0]) ?>" 
                            data-mensaje="Nuevo Cliente">
                        Nuevo Cliente
                    </button>
                <?php else: ?>
                    <button type="button" class="btn btn-primary"
                            data-modal="<?= Url::to(['/cliente/alta/', 'id' => $listasprecio['IdListaPrecio']]) ?>" 
                            data-mensaje="Nuevo Cliente">
                        Nuevo Cliente
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
                                <th>Cliente</th>
                                <th>Documento</th>
                                <?php if ($busqueda['Check'] == 'S'): ?>
                                    <th>Estado</th>
                                <?php endif ?>
                                <th>Datos</th>
                                <th>Listas Precio</th>
                                <th>Observaciones</th>                
                                <th>Operaciones</th>
                                <?php if ($busqueda['Check2'] == 'S'): ?>
                                    <th>Acciones</th>
                                <?php endif ?>
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
                                     <!-- Operaciones -->
                                        <div class="btn-group" role="group" aria-label="...">
                                            
                                            <a class="btn btn-default"
                                                    href="<?= Url::to(['/clientes/ventas', 'id' => $model['IdCliente']]) ?>"
                                                    data-mensaje="Ventas">
                                                <i class="fas fa-comment-dollar" style="color: green"></i>
                                            </a>
                                        </div>
                                    </td>
                                    <?php if ($busqueda['Check2'] == 'S'): ?>
                                    <td>
                                        <!-- Acciones -->
                                        <div class="btn-group" role="group" aria-label="...">

                                                <button type="button" class="btn btn-default"
                                                        data-modal="<?= Url::to(['/clientes/editar', 'id' => $model['IdCliente']]) ?>" 
                                                        data-mensaje="Editar">
                                                    <i class="fa fa-edit" style="color: Dodgerblue"></i>
                                                </button>
                                            
                                                <button type="button" class="btn btn-default"
                                                        data-ajax="<?= Url::to(['/clientes/borrar', 'id' => $model['IdCliente']]) ?>"
                                                        data-mensaje="Borrar">
                                                    <i class="far fa-trash-alt" style="color: Tomato"></i>
                                                </button>
                                                    <?php if ($model['Estado'] == 'B'): ?>
                                                        <button type="button" class="btn btn-default"
                                                            data-ajax="<?= Url::to(['/clientes/activar', 'id' => $model['IdCliente']]) ?>"
                                                            data-mensaje="Activar">
                                                        <i class="fas fa-toggle-on" style="color: indigo" > </i>
                                                        </button>
                                                    <?php else: ?>
                                                        <button type="button" class="btn btn-default"
                                                            data-ajax="<?= Url::to(['/clientes/darbaja', 'id' => $model['IdCliente']]) ?>"
                                                            data-mensaje="Dar de Baja">
                                                        <i class="fas fa-toggle-off" style="color: indigo"></i>
                                                        </button>
                                                    <?php endif ?>                                             
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
            <p><strong>No hay Clientes que coincidan con el criterio de búsqueda utilizado.</strong></p>
        <?php endif; ?>
    </div>
</div>