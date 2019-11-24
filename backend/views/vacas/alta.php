<?php

use common\models\Vacas;
use yii\bootstrap4\ActiveForm;
use kartik\date\DatePicker;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\View;

/* @var $this View */
/* @var $form ActiveForm */
/* @var $model Vacas */
/* @var $lotes Lotes */

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

        <?php $form = ActiveForm::begin(['id' => 'vacas-form',]) ?>

        <div class="modal-body">
            <div id="errores-modal"> </div>

            <?= Html::activeHiddenInput($model, 'IdVaca') ?>

            <?= Html::activeHiddenInput($model, 'IdSucursal') ?>
            
            <!-- <span class="badge badge-danger">2</span> -->
            <?= $form->field($model, 'IdCaravana', ['inputOptions' => ['autocomplete' => 'off']]) ?>

            <!-- <span class="badge badge-danger">3</span> -->
            <?= $form->field($model, 'IdRFID', ['inputOptions' => ['autocomplete' => 'off']]) ?>

            <?php if (!isset($model['IdVaca'])): ?>
                <?php if (!isset($model['IdLote'])): ?>
                    <!-- <span class="badge badge-danger">12</span> -->
                    <?= $form->field($model, 'IdLote')->dropDownList(ArrayHelper::map($lotes, 'IdLote', 'LoteSucursal'), ['prompt' => 'Lote']) ?>

                    <!-- <span class="badge badge-danger">13</span> -->
                    <p> Fecha de Ingreso al Lote </p>
                    <?= DatePicker::widget([
                        'model' => $model,
                        'attribute' => 'FechaIngreso',
                        'language' => 'es',
                        'options' => ['placeholder' => 'Ingrese la Fecha...', 'autocomplete' => "off",],
                        'pluginOptions' => [
                            'format' => 'dd/mm/yyyy',
                            'autoclose' => true,
                            'clearBtn' => true,
                        ]
                    ]);
                    ?>
            
                <?php else: ?>
                    <p> 
                    <!-- <span class="badge badge-danger">13</span> -->
                    Fecha de Ingreso al Lote </p>
                    <?= DatePicker::widget([
                        'model' => $model,
                        'attribute' => 'FechaIngreso',
                        'language' => 'es',
                        'options' => ['placeholder' => 'Ingrese la Fecha...', 'autocomplete' => "off",],
                        'pluginOptions' => [
                            'format' => 'dd/mm/yyyy',
                            'autoclose' => true,
                            'clearBtn' => true,
                        ]
                    ]);
                    ?>
                <?php endif; ?>

                <!-- <span class="badge badge-danger">14</span> -->
                <?= $form->field($model, 'Estado')->dropDownList(Vacas::ESTADOS_ALTA, ['prompt' => 'Estado']) ?>
            <?php endif; ?>

            <!-- <span class="badge badge-danger">5</span> -->
            <?= $form->field($model, 'Nombre', ['inputOptions' => ['autocomplete' => 'off']]) ?>

            <!-- <span class="badge badge-danger">6</span> -->
            <?= $form->field($model, 'Raza') ?>

            <!-- <span class="badge badge-danger">7</span> -->
            <?= $form->field($model, 'Peso', ['inputOptions' => ['autocomplete' => 'off']]) ?>

            <p> 
            <!-- <span class="badge badge-danger">8</span> -->
            Fecha de Nacimiento </p>
            <?= DatePicker::widget([
                'model' => $model,
                'attribute' => 'FechaNac',
                'language' => 'es',
                'options' => ['placeholder' => 'Ingrese la Fecha...', 'autocomplete' => "off",],
                'pluginOptions' => [
                    'format' => 'dd/mm/yyyy',
                    'autoclose' => true,
                    'clearBtn' => true,
                ]
            ]);
            ?>

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