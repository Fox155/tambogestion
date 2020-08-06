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
            <!-- <span class="badge badge-danger">1</span> -->
        </div>

        <?php $form = ActiveForm::begin(['id' => 'registro-leche-form',]) ?>

        <div class="modal-body">
            <div id="errores-modal"> </div>

            <?= Html::activeHiddenInput($model, 'IdRegistroLeche') ?>

            <?= Html::activeHiddenInput($model, 'IdSucursal') ?>
            
            <!-- <span class="badge badge-danger">2</span> -->
            <?= $form->field($model, 'Litros', ['inputOptions' => ['autocomplete' => 'off']]) ?>

            <!-- <span class="badge badge-danger">3</span> -->
            <p> Fecha </p>
            <?= DatePicker::widget([
                'model' => $model,
                'attribute' => 'Fecha',
                'language' => 'es',
                'options' => ['placeholder' => 'Ingrese la Fecha...', 'autocomplete' => "off",],
                'pluginOptions' => [
                    'todayHighlight' => true,
                    'format' => 'dd/mm/yyyy',
                    'autoclose' => true,
                    'clearBtn' => true,
                ]
            ]);
            ?>
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