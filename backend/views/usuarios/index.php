<?php

use common\models\Usuarios;
use yii\web\View;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this View */
/* @var $form ActiveForm */
$this->title = 'Usuarios';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-sm-12">
        <div class="buscar--form">
            <?php $form = ActiveForm::begin(['layout' => 'inline',]); ?>

            <?= $form->field($busqueda, 'Combo')->dropDownList(Usuarios::TIPOS_USUARIOS, ['prompt' => 'Tipo de Usuario']) ?>

            <?= $form->field($busqueda, 'Combo2')->dropDownList(Usuarios::ESTADOS, ['prompt' => 'Estado']) ?>

            <?= $form->field($busqueda, 'Cadena')->input('text', ['placeholder' => 'Búsqueda']) ?>

            <?= Html::submitButton('Buscar', ['class' => 'btn btn-secondary', 'name' => 'pregunta-button']) ?> 

            <?php ActiveForm::end(); ?>
        </div>

        <div class="alta--button">
        
            <div class="alta--button">
                <button type="button" class="btn btn-primary"
                        data-modal="<?= Url::to(['/usuarios/alta']) ?>" 
                        data-mensaje="Nuevo Usuario">
                    Nuevo Usuario
                </button>
            </div>

        <div id="errores"> </div>
        
        <?php if (count($models) > 0): ?>
        <div class="card">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table">
                        <thead class="bg-light">
                            <tr class="border-0">
                                <th>Usuario</th>
                                <th>Email</th>
                                <th>Estado</th>
                                <th>Fecha de Alta</th>
                                <th>Tipo de Usuario</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($models as $model): ?>
                                <tr>
                                    <td><?= Html::encode($model['Usuario']) ?></td>
                                    <td><?= Html::encode($model['Email']) ?></td>
                                    <td><?= Html::encode($model['Estado']) ?></td>
                                    <td><?= Html::encode($model['FechaAlta']) ?></td>
                                    <td><?= Html::encode($model['TipoUsuario']) ?></td>
                                    <td>
                                        <!-- Acciones -->
                                        <div class="btn-group" role="group" aria-label="...">
                  
                                                <button type="button" class="btn btn-default"
                                                        data-modal="<?= Url::to(['/usuarios/editar', 'id' => $model['IdUsuario']]) ?>" 
                                                        data-mensaje="Editar">
                                                    <i class="fa fa-edit" style="color: Dodgerblue"></i>
                                                </button>

                                            <?php if ($model['IdUsuario'] != Yii::$app->user->identity->IdUsuario): ?>
                                                <button type="button" class="btn btn-default"
                                                        data-ajax="<?= Url::to(['/usuarios/borrar', 'id' => $model['IdUsuario']]) ?>"
                                                        data-mensaje="Borrar">
                                                    <i class="far fa-trash-alt" style="color: Tomato"></i>
                                                </button>
                                            <?php endif; ?>

                                        </div>
                                    </td> 
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <?php else: ?>
            <p><strong>No hay usuarios que coincidan con el criterio de búsqueda utilizado.</strong></p>
        <?php endif; ?>

    </div>
</div>