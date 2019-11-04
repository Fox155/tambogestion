<?php

use common\models\Clientes;
use yii\bootstrap4\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\View;

/* @var $this View */
/* @var $form ActiveForm */
/* @var $model Clientes */
/* @var $listasprecio ListaPrecio */
?>
<div class="modal-dialog">
    <div class="modal-content">

        <div class="modal-header">
            <h5 class="modal-title"><?= $titulo ?>: <?= $model['Apellido'] ?></h5>
            <button type="button" class="close" onclick="Main.modalCerrar()">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>

        <?php $form = ActiveForm::begin(['id' => 'cliente-form',]) ?>

        <div class="modal-body">
            <div id="errores-modal"> </div>

                <?= Html::activeHiddenInput($model, 'IdCliente') ?>
    
                <?= $form->field($model, 'Apellido') ?>
                <?= $form->field($model, 'Nombre') ?>
                <?= $form->field($model, 'TipoDoc')->dropDownList(Clientes::_TIPO,['prompt' => 'Tipo de Documento']) ?>
                <?= $form->field($model, 'NroDoc') ?>
                <?php if (!isset($model['IdListaPrecio'])): ?>
                    <?= $form->field($model, 'IdListaPrecio')->dropDownList(ArrayHelper::map($listaprecio, 'IdListaPrecio', 'Lista'), ['prompt' => 'Lista']) ?>
                <?php else: ?>
                    <?= $form->field($model, 'IdListaPrecio')->dropDownList(ArrayHelper::map($listaprecio, 'IdListaPrecio', 'Lista'), ['prompt' => 'Lista aqui']) ?>
                <?php endif; ?>

                <?= $form->field($model, 'Direccion') ?>

                <?= $form->field($model, 'Telefono') ?>

                <?= $form->field($model, 'Observaciones')->textarea() ?>

            </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" onclick="Main.modalCerrar()">Cerrar</button>
            <?= Html::submitButton('Guardar', ['class' => 'btn btn-primary',]) ?>  
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>