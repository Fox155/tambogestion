<?php

use common\models\Usuarios;
use yii\bootstrap4\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\View;

/* @var $this View */
/* @var $form ActiveForm */
/* @var $model Usuarios */
/* @var $tipos TiposUsuario */
// 2015-06-12
?>
<div class="modal-dialog">
    <div class="modal-content">

        <div class="modal-header">
            <h5 class="modal-title"><?= $titulo ?>: <?= $model['Usuario'] ?></h5>
            <button type="button" class="close" onclick="Main.modalCerrar()">
                <span aria-hidden="true">&times;</span>
            </button>
            <!-- <span class="badge badge-danger">1</span> -->
        </div>

        <?php $form = ActiveForm::begin(['id' => 'usuario-form',]) ?>

        <div class="modal-body">
            <div id="errores-modal"> </div>

            <?= Html::activeHiddenInput($model, 'IdUsuario') ?>

            <?= Html::activeHiddenInput($model, 'IdTambo') ?>

            <?php if ($titulo == 'Alta Usuario'): ?>
                <!-- <span class="badge badge-danger">2</span> -->
                <?= $form->field($model, 'Usuario') ?>
            <?php else: ?>
                <?= Html::activeHiddenInput($model, 'Usuario', ['inputOptions' => ['autocomplete' => 'off']]) ?>
            <?php endif; ?>
            
            <!-- <span class="badge badge-danger">3</span> -->
            <?= $form->field($model, 'Email')->input('email') ?>

            <?php if ($titulo == 'Alta Usuario'): ?>
                <!-- <span class="badge badge-danger">4</span> -->
                <?= $form->field($model, 'Password')->passwordInput() ?>
            <?php endif; ?>

            <?php if ($model['IdUsuario'] != Yii::$app->user->identity->IdUsuario): ?>
                <!-- <span class="badge badge-danger">5</span> -->
                <?= $form->field($model, 'IdTipoUsuario')->dropDownList(ArrayHelper::map($tipos, 'IdTipoUsuario', 'Tipo'), ['prompt' => 'Tipo de Usuario']) ?>

                <!-- <span class="badge badge-danger">6</span> -->
                <?= $form->field($model, 'IdsSucursales')->checkboxList(ArrayHelper::map($sucursales, 'IdSucursal', 'Nombre')) ?>
            <?php else: ?>
                <?= Html::activeHiddenInput($model, 'IdTipoUsuario') ?>

                <?= Html::activeHiddenInput($model, 'IdsSucursales') ?>
            <?php endif; ?>

        </div>
        <div class="modal-footer">
            <!-- <span class="badge badge-danger">7</span> -->
            <button type="button" class="btn btn-default" onclick="Main.modalCerrar()">Cerrar</button>
            <?= Html::submitButton('Guardar', ['class' => 'btn btn-primary',]) ?>  
            <!-- <span class="badge badge-danger">8</span> -->
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>