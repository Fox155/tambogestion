<?php

use common\models\Sucursales;
use yii\bootstrap4\ActiveForm;
use common\components\FechaHelper;
use kartik\date\DatePicker;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\View;

/* @var $this View */
/* @var $form ActiveForm */
/* @var $model Sucursales */
?>
<div class="modal-dialog">
    <div class="modal-content">

        <div class="modal-header">
            <h5 class="modal-title"><?= $titulo ?></h5>
            <button type="button" class="close" onclick="Main.modalCerrar()">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>

        <?php $form = ActiveForm::begin(['id' => 'usuario-sucursal-form',]) ?>

        <div class="modal-body">
            <div id="errores-modal"> </div>

            <?= Html::activeHiddenInput($model, 'NroUsuarioSucursal') ?>

            <?= Html::activeHiddenInput($model, 'IdSucursal') ?>
            
            <?= $form->field($model, 'IdUsuario')->dropDownList(ArrayHelper::map($usuarios, 'IdUsuario', 'Usuario'), ['prompt' => 'Usuario']) ?>

        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" onclick="Main.modalCerrar()">Cerrar</button>
            <?= Html::submitButton('Guardar', ['class' => 'btn btn-primary',]) ?>  
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>