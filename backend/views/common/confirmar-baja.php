<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

?>

<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Confirmación de Borrado</h5>
            <button type="button" class="close" onclick="Main.modalCerrar()">
                <span aria-hidden="true">&times;</span>
            </button>
            <span class="badge badge-danger">1</span>
        </div>
            
        <?php $form = ActiveForm::begin(['id' => 'confirmacion-form']); ?>
        <div class="modal-body">
        <div id="errores-modal"> </div>
        Seleccione "Borrar" a continuación si está seguro de que desea boorrar <?= Html::encode($objeto) ?>.</div>
        <div class="modal-footer">
            <span class="badge badge-danger">2</span>
            <button type="button" class="btn btn-default" onclick="Main.modalCerrar()">Cancelar</button>
            <?= Html::submitButton('Borrar', ['class' => 'btn btn-lg btn-primary btn-block', 'name' => 'confirmacion-button']) ?>
            <span class="badge badge-danger">3</span>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>