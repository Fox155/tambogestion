<?php

use common\models\ListasPrecio;
use yii\web\View;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this View */
/* @var $form ActiveForm */
/* @var $models ListasPrecio */

$this->title = 'Listas de Precios';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-sm-12">
        <div class="buscar--form">
            <?php $form = ActiveForm::begin(['layout' => 'inline',]); ?>

            <?= $form->field($busqueda, 'Cadena')->input('text', ['placeholder' => 'Búsqueda']) ?>

            <?= $form->field($busqueda, 'Check')->checkbox(array('class' => 'check--buscar-form', 'label' => 'Incluir Bajas', 'value' => 'S', 'uncheck' => 'N')); ?> 

            <?= Html::submitButton('Buscar', ['class' => 'btn btn-secondary', 'name' => 'pregunta-button']) ?> 

            <?php ActiveForm::end(); ?>
        </div>

        <div class="alta--button">
        
        <div class="alta--button">
            <button type="button" class="btn btn-primary"
                    data-modal="<?= Url::to(['/listas-precio/alta']) ?>" 
                    data-hint="Nueva Lista Precio">
                Nueva Lista Precio
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
                                <th>Lista</th>
                                <th>Precio</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($models as $model): ?>
                                <tr>
                                    <td><?= Html::encode($model['Lista']) ?></td>
                                    <td><?= Html::encode($model['Precio']) ?></td>
                                    <td><?= Html::encode(ListasPrecio::ESTADOS[$model['Estado']]) ?></td>
                                    <td>
                                        <div class="btn-group" role="group" aria-label="...">
                                                <button type="button" class="btn btn-default"
                                                        data-modal="<?= Url::to(['/listas-precio/editar', 'id' => $model['IdListaPrecio']]) ?>" 
                                                        data-mensaje="Editar">
                                                    <i class="fa fa-edit" style="color: Dodgerblue"></i>
                                                </button>

                                                <button type="button" class="btn btn-default"
                                                        data-modal="<?= Url::to(['/listas-precio/historico', 'id' => $model['IdListaPrecio']]) ?>" 
                                                        data-mensaje="Historico">
                                                    <i class="fa fa-history" style="color: Green"></i>
                                                </button>
                                            
                                                <button type="button" class="btn btn-default"
                                                        data-ajax="<?= Url::to(['/listas-precio/borrar', 'id' => $model['IdListaPrecio']]) ?>"
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
            <p><strong>No hay Listas de Precio que coincidan con el criterio de búsqueda utilizado.</strong></p>
        <?php endif; ?>
    </div>
</div>