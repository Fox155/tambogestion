<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use common\models\Usuarios;

?>

<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Listo para salir?</h5>
            <button type="button" class="close" onclick="Main.modalCerrar()">
                <span aria-hidden="true">&times;</span>
            </button>
            <!-- <span class="badge badge-danger">1</span> -->
        </div>
            
        <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
        <div class="modal-body">Seleccione "Cerrar sesión" a continuación si está listo para finalizar su sesión actual.</div>
        <div class="modal-footer">
            <!-- <span class="badge badge-danger">2</span> -->
            <button type="button" class="btn btn-default" onclick="Main.modalCerrar()">Cancelar</button>
            <?= Html::submitButton('Cerrar sesión', ['class' => 'btn btn-lg btn-primary btn-block', 'name' => 'logout-button']) ?>
            <!-- <span class="badge badge-danger">3</span> -->
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>