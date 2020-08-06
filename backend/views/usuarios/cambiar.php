<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use common\models\Usuarios;

$this->title = 'Cambiar Contraseña';
?>
<div class="container">
  <div class="card card-login mx-auto mt-5">
    <div class="card-header">Cambiar Contraseña</div>
    <div class="card-body">
      <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
        <?php
          foreach (Yii::$app->session->getAllFlashes() as $key => $message) {
              echo '<div class="alert alert-' . $key . ' alert-dismissable">'
              . '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>'
              . $message . '</div>';
          }
        ?>

        <!-- <span class="badge badge-danger">1</span> -->
        <?= $form->field($model, 'PasswordOld', ['inputOptions' => ['placeholder' => 'Antigua Contraseña'],])->passwordInput(['autofocus' => true]) ?>

        <!-- <span class="badge badge-danger">2</span> -->
        <?= $form->field($model, 'PasswordNew', ['inputOptions' => ['placeholder' => 'Nueva Contraseña'],])->passwordInput(['autofocus' => true]) ?>

        <!-- <span class="badge badge-danger">3</span> -->
        <?= $form->field($model, 'PasswordRep', ['inputOptions' => ['placeholder' => 'Repita la Contraseña'],])->passwordInput(['autofocus' => true]) ?>

        <!-- <span class="badge badge-danger">4</span> -->
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-lg btn-primary btn-block', 'name' => 'login-button']) ?>

      <?php ActiveForm::end(); ?>
    </div>
  </div>
</div>