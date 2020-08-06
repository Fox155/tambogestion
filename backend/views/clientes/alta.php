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
            <!-- <span class="badge badge-danger">1</span> -->
        </div>

        <?php $form = ActiveForm::begin(['id' => 'cliente-form',]) ?>

        <div class="modal-body">
            <div id="errores-modal"> </div>

                <?= Html::activeHiddenInput($model, 'IdCliente') ?>
    
                <!-- <span class="badge badge-danger">2</span> -->
                <?= $form->field($model, 'Apellido', ['inputOptions' => ['autocomplete' => 'off']]) ?>

                <!-- <span class="badge badge-danger">3</span> -->
                <?= $form->field($model, 'Nombre', ['inputOptions' => ['autocomplete' => 'off']]) ?>

                <!-- <span class="badge badge-danger">4</span> -->
                <?= $form->field($model, 'TipoDoc')->dropDownList(Clientes::_TIPO,['prompt' => 'Tipo de Documento']) ?>

                <!-- <span class="badge badge-danger">5</span> -->
                <?= $form->field($model, 'NroDoc', ['inputOptions' => ['autocomplete' => 'off']]) ?>

                <!-- <span class="badge badge-danger">6</span> -->
                <?= $form->field($model, 'IdListaPrecio')->dropDownList(ArrayHelper::map($listaprecio, 'IdListaPrecio', 'Lista'), ['prompt' => 'Lista']) ?>

                <!-- <span class="badge badge-danger">7</span> -->
                <?= $form->field($model, 'Direccion', ['inputOptions' => ['autocomplete' => 'off']]) ?>

                <!-- <span class="badge badge-danger">8</span> -->
                <?= $form->field($model, 'Telefono', ['inputOptions' => ['autocomplete' => 'off']]) ?>

                <!-- <span class="badge badge-danger">9</span> -->
                <?= $form->field($model, 'Observaciones')->textarea() ?>

            </div>
        <div class="modal-footer">
            <!-- <span class="badge badge-danger">10</span> -->
            <button type="button" class="btn btn-default" onclick="Main.modalCerrar()">Cerrar</button>
            <?= Html::submitButton('Guardar', ['class' => 'btn btn-primary',]) ?>  
            <!-- <span class="badge badge-danger">11</span> -->
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>