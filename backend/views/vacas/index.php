<?php

use common\models\Lotes;
use common\models\Sucursal;
use common\models\Vacas;
use yii\web\View;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use common\components\FechaHelper;

/* @var $this View */
/* @var $form ActiveForm */
/* @var $lote Lotes */
/* @var $sucursal Sucursales */
/* @var $models Vacas */
if(isset($sucursal['Nombre']) && isset($lote['Nombre'])){
    $this->title = 'Vacas de la Sucursal: ' . $sucursal['Nombre'] . ' - Lote: ' . $lote['Nombre'];
}else{
    if(isset($sucursal['Nombre'])){
        $this->title = 'Vacas de la Sucursal: ' . $sucursal['Nombre'];
    } else if(isset($lote['Nombre'])){
        $this->title =  'Vacas del Lote: ' . $lote['Nombre'];
    }else{
        $this->title =  'Vacas';
    }
}

$this->params['breadcrumbs'][] = $anterior;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-sm-12">
        <div class="buscar--form">
            <?php $form = ActiveForm::begin(['layout' => 'inline',]); ?>

            <?= $form->field($busqueda, 'Cadena')->input('text', ['placeholder' => 'Búsqueda']) ?>

            <?= Html::submitButton('Buscar', ['class' => 'btn btn-secondary', 'name' => 'pregunta-button']) ?> 

            <?= $form->field($busqueda, 'Check')->checkbox(array('class' => 'check--buscar-form', 'label' => 'Incluir Bajas', 'value' => 'S', 'uncheck' => 'N')); ?> 
            
            <?= $form->field($busqueda, 'Check')->checkbox(array('class' => 'check--buscar-form', 'label' => 'Incluir Vendidas/Muertas', 'value' => 'S', 'uncheck' => 'N')); ?> 

            <?php ActiveForm::end(); ?>
        </div>

        <div class="alta--button">
        
            <div class="alta--button">
                <?php if (!isset($lote['Nombre'])): ?>
                    <button type="button" class="btn btn-primary"
                            data-modal="<?= Url::to(['/vacas/alta/', 'idS' => $sucursal['IdSucursal'], 'idL' => 0]) ?>" 
                            data-mensaje="Nueva Vaca">
                        Nueva Vaca
                    </button>
                <?php else: ?>
                    <button type="button" class="btn btn-primary"
                            data-modal="<?= Url::to(['/vacas/alta/', 'idS' => $sucursal['IdSucursal'], 'idL' => $lote['IdLote']]) ?>" 
                            data-mensaje="Nueva Vaca">
                        Nueva Vaca
                    </button>
                <?php endif ?>
            </div>

        <div id="errores"> </div>
        
        <?php if (count($models) > 0): ?>
        <div class="card">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table">
                        <thead class="bg-light">
                            <tr class="border-0">
                                <th>Vaca</th>
                                <?php if (!isset($lote['Nombre'])): ?>
                                    <th>Lote</th>
                                <?php endif ?>
                                <th>Caravana</th>
                                <th>RFID</th>
                                <th>Peso</th>
                                <th>Fecha de Nacimiento</th>
                                <th>Estado</th>
                                <th>Observaciones</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($models as $model): ?>
                                <tr>
                                    <td><?= Html::encode($model['Nombre']) ?></td>
                                    <?php if (!isset($lote['Nombre'])): ?>
                                        <td><?= Html::encode($model['Lote']) ?></td>
                                    <?php endif ?>
                                    <td><?= Html::encode($model['IdCaravana']) ?></td>
                                    <td><?= Html::encode($model['IdRFID']) ?></td>
                                    <td><?= Html::encode($model['Peso']) ?></td>
                                    <td><?= Html::encode(FechaHelper::toDateLocal($model['FechaNac'])) ?></td>
                                    <td><?= Html::encode(Vacas::ESTADOS[$model['Estado']]) ?></td>
                                    <td><?= Html::encode($model['Observaciones']) ?></td>
                                    <td>
                                        <div class="btn-group" role="group" aria-label="...">
                                            
                                            <a class="btn btn-default"
                                                    href="<?= Url::to(['/vacas/detalle', 'id' => $model['IdVaca']]) ?>"
                                                    data-mensaje="Detalle">
                                                <i class="fas fa-info" style="color: Dodgerblue"></i>
                                            </a>

                                            <button type="button" class="btn btn-default"
                                                    data-modal="<?= Url::to(['/vacas/estado', 'id' => $model['IdVaca']]) ?>" 
                                                    data-mensaje="Cambiar Estado">
                                                <i class="fas fa-file-alt" style="color: Green"></i>
                                            </button>

                                            <button type="button" class="btn btn-default"
                                                    data-modal="<?= Url::to(['/vacas/lote', 'id' => $model['IdVaca']]) ?>" 
                                                    data-mensaje="Cambiar de Lote">
                                                <i class="fas fa-sign-out-alt" style="color: Indigo"></i>
                                            </button>

                                            <button type="button" class="btn btn-default"
                                                    data-modal="<?= Url::to(['/vacas/editar', 'id' => $model['IdVaca'], 'idS' => $sucursal['IdSucursal']]) ?>" 
                                                    data-mensaje="Editar">
                                                <i class="fa fa-edit" style="color: Dodgerblue"></i>
                                            </button>
                                            
                                            <button type="button" class="btn btn-default"
                                                    data-ajax="<?= Url::to(['/vacas/borrar', 'id' => $model['IdVaca']]) ?>"
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
            <p><strong>No hay Vacas que coincidan con el criterio de búsqueda utilizado.</strong></p>
        <?php endif; ?>
    </div>
</div>