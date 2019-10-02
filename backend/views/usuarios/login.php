<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use common\models\Usuarios;

$this->title = 'Iniciar sesión - Tambo Gestion';
?>
<?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

    <h1 class="h3 mb-3 font-weight-normal">Iniciar sesión</h1>

    <?php
    foreach (Yii::$app->session->getAllFlashes() as $key => $message) {
        echo '<div class="alert alert-' . $key . ' alert-dismissable">'
        . '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>'
        . $message . '</div>';
    }
    ?>

    <?= $form->field($model, 'Usuario', [
        'inputOptions' => ['placeholder' => 'Usuario'],
    ])->textInput(['autofocus' => true])->label(false) ?>

    <?= $form->field($model, 'Password', [
        'inputOptions' => ['placeholder' => 'Contraseña'],
    ])->passwordInput()->label(false) ?>
                                                    
    <?= Html::submitButton('Iniciar', ['class' => 'btn btn-lg btn-primary btn-block', 'name' => 'login-button']) ?>  

<?php ActiveForm::end(); ?>
