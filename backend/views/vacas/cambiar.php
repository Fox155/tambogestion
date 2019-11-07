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
        </div>
            
        <?php $form = ActiveForm::begin(['id' => 'vaca-estado-form']); ?>
        <div class="modal-body">
            <div id="errores-modal"> </div>

            <?= Html::activeHiddenInput($model, 'IdVaca') ?>

            <?php if (isset($lotes)): ?>
                <?= $form->field($model, 'IdLote')->dropDownList(ArrayHelper::map($lotes, 'IdLote', 'LoteSucursal'), ['prompt' => 'Lote']) ?>
            <?php else: ?>
                <?= $form->field($model, 'Estado')->dropDownList(Vacas::ESTADOS, ['prompt' => 'Estado'])->label('Nuevo Estado') ?>
            <?php endif; ?>
        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-default" onclick="Main.modalCerrar()">Cerrar</button>
            <?= Html::submitButton('Guardar', ['class' => 'btn btn-primary',]) ?>  
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>