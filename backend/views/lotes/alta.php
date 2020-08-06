<?php

use common\models\Lotes;
use yii\bootstrap4\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\View;

/* @var $this View */
/* @var $form ActiveForm */
/* @var $model Lotes */
/* @var $sucursales Sucursales */
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

        <?php $form = ActiveForm::begin(['id' => 'lotes-form',]) ?>

        <div class="modal-body">
            <div id="errores-modal"> </div>

            <?= Html::activeHiddenInput($model, 'IdLote') ?>

            <?php if (!isset($model['IdSucursal'])): ?>
                <!-- <span class="badge badge-danger">2</span> -->
                <?= $form->field($model, 'IdSucursal', ['inputOptions' => ['autocomplete' => 'off']])->dropDownList(ArrayHelper::map($sucursales, 'IdSucursal', 'Nombre'), ['prompt' => 'Sucursal']) ?>
            <?php endif; ?>
            
            <!-- <span class="badge badge-danger">3</span> -->
            <?= $form->field($model, 'Nombre', ['inputOptions' => ['autocomplete' => 'off']]) ?>
            
        </div>
        <div class="modal-footer">
            <!-- <span class="badge badge-danger">4</span> -->
            <button type="button" class="btn btn-default" onclick="Main.modalCerrar()">Cerrar</button>
            <?= Html::submitButton('Guardar', ['class' => 'btn btn-primary',]) ?>  
            <!-- <span class="badge badge-danger">5</span> -->
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>