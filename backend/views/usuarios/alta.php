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
        </div>

        <?php $form = ActiveForm::begin(['id' => 'usuario-form',]) ?>

        <div class="modal-body">
            <div id="errores-modal"> </div>

            <?= Html::activeHiddenInput($model, 'IdUsuario') ?>

            <?= Html::activeHiddenInput($model, 'IdTambo') ?>

            <?php if ($titulo == 'Alta Usuario'): ?>
                <?= $form->field($model, 'Usuario') ?>
            <?php else: ?>
                <?= Html::activeHiddenInput($model, 'Usuario') ?>
            <?php endif; ?>
            
            <?= $form->field($model, 'Email')->input('email') ?>

            <?php if ($titulo == 'Alta Usuario'): ?>
                <?= $form->field($model, 'Password')->passwordInput() ?>
            <?php else: ?>
                <?= Html::activeHiddenInput($model, 'Password') ?>
            <?php endif; ?>

            <?= $form->field($model, 'IdTipoUsuario')->dropDownList(ArrayHelper::map($tipos, 'IdTipoUsuario', 'Tipo'), ['prompt' => 'Tipo de Usuario']) ?>
            
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" onclick="Main.modalCerrar()">Cerrar</button>
            <?= Html::submitButton('Guardar', ['class' => 'btn btn-primary',]) ?>  
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>