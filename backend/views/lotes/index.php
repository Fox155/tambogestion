<?php

use common\models\Lotes;
use common\models\Sucursal;
use yii\web\View;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this View */
/* @var $form ActiveForm */
/* @var $models Lotes */
/* @var $sucursal Sucursales */
$this->title = isset($sucursal['Nombre']) ? 'Lotes de la Sucursal: ' . $sucursal['Nombre'] : 'Lotes';

$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-sm-12">
        <div class="buscar--form">
            <?php $form = ActiveForm::begin(['layout' => 'inline',]); ?>

            <?= $form->field($busqueda, 'Cadena')->input('text', ['placeholder' => 'Búsqueda']) ?>

            <?= $form->field($busqueda, 'Check')->checkbox(array('class' => 'check--buscar-form', 'label' => 'Incluir Bajas', 'value' => 'S', 'uncheck' => 'N')); ?> 

            <?= $form->field($busqueda, 'Check2')->checkbox(array('class' => 'check--buscar-form', 'label' => 'Listar Acciones', 'value' => 'S', 'uncheck' => 'N')); ?> 

            <?= Html::submitButton('Buscar', ['class' => 'btn btn-secondary', 'name' => 'pregunta-button']) ?> 

            <?php ActiveForm::end(); ?>
        </div>

        <div class="alta--button">
            <div class="alta--button">
                <?php if (!isset($sucursal['Nombre'])): ?>
                    <button type="button" class="btn btn-primary"
                            data-modal="<?= Url::to(['/lotes/alta/', 'id' => 0]) ?>" 
                            data-mensaje="Nuevo Lote">
                        Nuevo Lote
                    </button>
                <?php else: ?>
                    <button type="button" class="btn btn-primary"
                            data-modal="<?= Url::to(['/lotes/alta/', 'id' => $sucursal['IdSucursal']]) ?>" 
                            data-mensaje="Nuevo Lote">
                        Nuevo Lote
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
                                <th>Lote</th>
                                <th>Sucursal</th>
                                <th>Ganado Total</th>
                                <th>Estado</th>
                                <th>Operaciones</th>
                                <?php if ($busqueda['Check2'] == 'S'): ?>
                                    <th>Acciones</th>
                                <?php endif ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($models as $model): ?>
                                <tr>
                                    <td><?= Html::encode($model['Nombre']) ?></td>
                                    <td><?= Html::encode($model['Sucursal']) ?></td>
                                    <td><?= Html::encode($model['Ganado']) ?></td>
                                    <td><?= Html::encode(Lotes::ESTADOS[$model['Estado']]) ?></td>
                                    <td>
                                        <!-- Operaciones -->
                                        <div class="btn-group" role="group" aria-label="...">
                                                <a class="btn btn-default"
                                                        href="<?= Url::to(['/vacas', 'idS' => $model['IdSucursal'], 'idL' => $model['IdLote']]) ?>"
                                                        data-mensaje="Vacas">
                                                    <i class="fas fa-hat-cowboy-side" style="color: Brown"></i>
                                                </a>
                                        </div>
                                    </td>
                                    <?php if ($busqueda['Check2'] == 'S'): ?>
                                    <td>
                                        <!-- Acciones -->
                                        <div class="btn-group" role="group" aria-label="...">
                                                <button type="button" class="btn btn-default"
                                                        data-modal="<?= Url::to(['/lotes/editar', 'id' => $model['IdSucursal'], 'idL' => $model['IdLote']]) ?>" 
                                                        data-mensaje="Editar">
                                                    <i class="fa fa-edit" style="color: Dodgerblue"></i>
                                                </button>
                                            
                                                <button type="button" class="btn btn-default"
                                                        data-ajax="<?= Url::to(['/lotes/borrar', 'id' => $model['IdLote']]) ?>"
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
            <p><strong>No hay Lotes que coincidan con el criterio de búsqueda utilizado.</strong></p>
        <?php endif; ?>
    </div>
</div>