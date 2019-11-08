<?php

use common\models\Vacas;
use yii\bootstrap4\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\View;

/* @var $this View */
/* @var $form ActiveForm */
/* @var $model Vacas */
/* @var $lotes Lotes */
// 2015-06-12
?>
<div class="modal-dialog">
    <div class="modal-content">

        <div class="modal-header">
            <h5 class="modal-title"><?= $titulo ?>: <?= $model['Nombre'] ?></h5>
            <button type="button" class="close" onclick="Main.modalCerrar()">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>

        <?php $form = ActiveForm::begin(['id' => 'vacas-form',]) ?>

        <div class="modal-body">
            <div id="errores-modal"> </div>

            <?= Html::activeHiddenInput($model, 'IdVaca') ?>

            <?= Html::activeHiddenInput($model, 'IdSucursal') ?>
            
            <?= $form->field($model, 'IdCaravana') ?>

            <?= $form->field($model, 'IdRFID') ?>

            <?php if (!isset($model['IdLote'])): ?>
                <?= $form->field($model, 'IdLote')->dropDownList(ArrayHelper::map($lotes, 'IdLote', 'LoteSucursal'), ['prompt' => 'Lote']) ?>

                <?= $form->field($model, 'FechaIngreso') ?>
            <?php else: ?>
                <?= Html::activeHiddenInput($model, 'IdLote') ?>
            <?php endif; ?>

            <?= $form->field($model, 'Estado')->dropDownList(Vacas::ESTADOS_ALTA, ['prompt' => 'Estado']) ?>

            <?= $form->field($model, 'Nombre') ?>

            <?= $form->field($model, 'Raza') ?>

            <?= $form->field($model, 'Peso') ?>

            <?= $form->field($model, 'FechaNac') ?>

            <?= $form->field($model, 'Observaciones') ?>
            
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" onclick="Main.modalCerrar()">Cerrar</button>
            <?= Html::submitButton('Guardar', ['class' => 'btn btn-primary',]) ?>  
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>