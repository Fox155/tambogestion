<?php

/* @var $this \yii\web\View */
/* @var $content string */

use common\models\Vacas;
use common\models\forms\LactanciaForm;
use kartik\date\DatePicker;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;

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
            
        <?php $form = ActiveForm::begin(['id' => 'vaca-estado-form']); ?>
        <div class="modal-body">
            <div id="errores-modal"> </div>

            <?= Html::activeHiddenInput($model, 'IdVaca') ?>

            <?php if ( $lactancia->getScenario() == LactanciaForm::_ALTA): ?>
                <p> 
                <!-- <span class="badge badge-danger">2</span> -->
                Fecha de Inicio de la Lactancia </p>
                <?= DatePicker::widget([
                    'model' => $lactancia,
                    'attribute' => 'FechaInicio',
                    'language' => 'es',
                    'options' => ['placeholder' => 'Ingrese la Fecha...', 'autocomplete' => "off", 'autofocus' => "off",],
                    'pluginOptions' => [
                        'todayHighlight' => true,
                        'format' => 'dd/mm/yyyy',
                        'autoclose' => true,
                        'clearBtn' => true,
                    ]
                ]);
                ?>
            <?php else: ?>
                <p> 
                <!-- <span class="badge badge-danger">2</span> -->
                Fecha de Finalizacion de la Lactancia </p>
                <?= DatePicker::widget([
                    'model' => $lactancia,
                    'attribute' => 'FechaFin',
                    'language' => 'es',
                    'options' => ['placeholder' => 'Ingrese la Fecha...', 'autocomplete' => "off", 'autofocus' => "off",],
                    'pluginOptions' => [
                        'todayHighlight' => true,
                        'format' => 'dd/mm/yyyy',
                        'autoclose' => true,
                        'clearBtn' => true,
                    ]
                ]);
                ?>
            <?php endif; ?>
        </div>

        <div class="modal-footer">
            <!-- <span class="badge badge-danger">3</span> -->
            <button type="button" class="btn btn-default" onclick="Main.modalCerrar()">Cerrar</button>
            <?= Html::submitButton('Guardar', ['class' => 'btn btn-primary',]) ?>  
            <!-- <span class="badge badge-danger">4</span> -->
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>