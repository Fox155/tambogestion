<?php

use common\models\ListasPrecio;
use yii\bootstrap4\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\View;

/* @var $this View */
/* @var $form ActiveForm */
/* @var $model ListaPrecio */
?>
<div class="modal-dialog">
    <div class="modal-content">

        <div class="modal-header">
            <h5 class="modal-title"><?= $titulo ?>: <?= $model['Lista'] ?></h5>
            <button type="button" class="close" onclick="Main.modalCerrar()">
                <span aria-hidden="true">&times;</span>
            </button>
            <!-- <span class="badge badge-danger">1</span> -->
        </div>

        <?php $form = ActiveForm::begin(['id' => 'listaprecio-form',]) ?>

        <div class="modal-body">
            <div id="errores-modal"> </div>

                <?= Html::activeHiddenInput($model, 'IdListaPrecio') ?>
    
                <!-- <span class="badge badge-danger">2</span> -->
                <?= $form->field($model, 'Lista') ?>
    
                <!-- <span class="badge badge-danger">3</span> -->
                <?= $form->field($model, 'Precio') ?>

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