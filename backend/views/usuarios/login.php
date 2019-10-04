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

            <?= $form->field($model, 'Usuario', ['inputOptions' => ['placeholder' => 'Usuario'],])->textInput(['autofocus' => true])->label(false) ?>

            <?= $form->field($model, 'Password', ['inputOptions' => ['placeholder' => 'Contraseña'],])->passwordInput(['autofocus' => true])->label(false) ?>

            <?= $form->field($busqueda, 'Check')->checkbox(array('class' => 'check--buscar-form', 'label' => 'Recordar contraseña', 'value' => 'S', 'uncheck' => 'N')); ?> 

            <?= Html::submitButton('Iniciar', ['class' => 'btn btn-lg btn-primary btn-block', 'name' => 'login-button']) ?>

            <div class="text-center">
                <a class="d-block small" href="/">¿Se te olvidó tu contraseña?</a>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>    
<p class="mt-5 mb-3 text-muted text-center my-auto"><?= Html::encode("Tambo Gestion") ?> © <?= date('Y') ?></p>