<?php

/* @var $this \yii\web\View */
/* @var $content string */

use common\models\Vacas;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;

?>

<div class="modal-dialog">
    <div class="modal-content">

        <div class="modal-header">
            <h5 class="modal-title"><?= $titulo ?>: <?= $model['Nombre'] ?></h5>
            <button type="button" class="close" onclick="Main.modalCerrar()">
                <span aria-hidden="true">&times;</span>
            </button>
            <!-- <span class="badge badge-danger">1</span> -->
        </div>
            
        <?php $form = ActiveForm::begin(['id' => 'vaca-estado-form']); ?>
        <div class="modal-body">
            <div id="errores-modal"> </div>

            <?= Html::activeHiddenInput($model, 'IdVaca') ?>

            <?php if (isset($lotes)): ?>
                <!-- <span class="badge badge-danger">2</span> -->
                <?= $form->field($model, 'IdLote')->dropDownList(ArrayHelper::map($lotes, 'IdLote', 'LoteSucursal'), ['prompt' => 'Lote']) ?>
            <?php else: ?>
                <!-- <span class="badge badge-danger">2</span> -->
                <?= $form->field($model, 'Estado')->dropDownList(Vacas::ProximosEstados($model['Estado']), ['prompt' => 'Estado'])->label('Nuevo Estado') ?>
            <?php endif; ?>
        </div>

        <div class="modal-footer">
            <!-- <span class="badge badge-danger">3</span> -->
            <button type="button" class="btn btn-default" onclick="Main.modalCerrar()">Cerrar</button>
            <?= Html::submitButton('Guardar', ['class' => 'btn btn-primary',]) ?>  
            <!-- <span class="badge badge-danger">4</span> -->
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>