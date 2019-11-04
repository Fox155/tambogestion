<?php

use common\models\Ventas;
use yii\bootstrap4\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\View;

/* @var $this View */
/* @var $form ActiveForm */
/* @var $model Ventas */
/* @var $sucursales Sucursales */
?>
<div class="modal-dialog">
    <div class="modal-content">

        <div class="modal-header">
            <h5 class="modal-title"><?= $titulo ?></h5>
            <button type="button" class="close" onclick="Main.modalCerrar()">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>

        <?php $form = ActiveForm::begin(['id' => 'ventas-form',]) ?>

        <div class="modal-body">
            <div id="errores-modal"> </div>

            <?= Html::activeHiddenInput($model, 'IdVenta') ?>

            <?php if (!isset($model['IdSucursal'])): ?>
                <?= $form->field($model, 'IdSucursal')->dropDownList(ArrayHelper::map($sucursales, 'IdSucursal', 'Nombre'), ['prompt' => 'Sucursal']) ?>
            <?php else: ?>
                <?= Html::activeHiddenInput($model, 'IdSucursal') ?>
            <?php endif; ?>

            <?= $form->field($model, 'IdCliente')->dropDownList(ArrayHelper::map($clientes, 'IdCliente', 'NombreCompleto'), ['prompt' => 'Cliente']) ?>
            
            <?= $form->field($model, 'MontoPres') ?>

            <?= $form->field($model, 'NroPagos') ?>

            <?= $form->field($model, 'Litros') ?>

            <?= $form->field($model, 'Observaciones')->textarea() ?>
            
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" onclick="Main.modalCerrar()">Cerrar</button>
            <?= Html::submitButton('Guardar', ['class' => 'btn btn-primary',]) ?>  
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>