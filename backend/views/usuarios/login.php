<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use common\models\Usuarios;

$this->title = 'Iniciar sesión - Tambo Gestion';
?>
<div class="container">
  <div class="card card-login mx-auto mt-5">
    <div class="card-header">Inicio de Sesion</div>
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
        <?= $form->field($model, 'Usuario', ['inputOptions' => ['placeholder' => 'Usuario'],])->textInput(['autofocus' => true])->label(false) ?>

        <!-- <span class="badge badge-danger">2</span> -->
        <?= $form->field($model, 'Password', ['inputOptions' => ['placeholder' => 'Contraseña'],])->passwordInput(['autofocus' => true])->label(false) ?>

        <!-- <span class="badge badge-danger">3</span> -->
        <?= Html::submitButton('Iniciar', ['class' => 'btn btn-lg btn-primary btn-block', 'name' => 'login-button']) ?>

      <?php ActiveForm::end(); ?>
    </div>
  </div>
</div>    
<p class="mt-5 mb-3 text-muted text-center my-auto"><?= Html::encode("Tambo Gestion") ?> © <?= date('Y') ?></p>