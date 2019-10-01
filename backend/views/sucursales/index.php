<?php

use common\models\Sucursales;
use yii\web\View;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this View */
/* @var $form ActiveForm */
$this->title = 'Sucursales';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-sm-12">
        <div class="buscar--form">
            <?php $form = ActiveForm::begin(['layout' => 'inline',]); ?>

            <?= $form->field($busqueda, 'Cadena')->input('text', ['placeholder' => 'Búsqueda']) ?>

            <?= Html::submitButton('Buscar', ['class' => 'btn btn-secondary', 'name' => 'pregunta-button']) ?> 

            <?php ActiveForm::end(); ?>
        </div>

        <div class="alta--button">
        
            <div class="alta--button">
                <button type="button" class="btn btn-primary"
                        data-modal="<?= Url::to(['/sucursales/alta']) ?>" 
                        data-hint="Nueva Sucursal">
                    Nueva Sucursal
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
                                <th>Sucursal</th>
                                <th>Datos</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($models as $model): ?>
                                <tr>
                                    <td><?= Html::encode($model['Nombre']) ?></td>
                                    <td>
                                        <ul>
                                        <?php foreach (json_decode($model['Datos']) as $nombre => $valor): ?>
                                            <li><?= Html::encode($nombre) ?>: <?= Html::encode($valor) ?></li>
                                        <?php endforeach; ?>
                                        </ul>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group" aria-label="...">

                                            
                                                <button type="button" class="btn btn-default"
                                                        data-modal="<?= Url::to(['/sucursales/editar', 'id' => $model['IdSucursal']]) ?>" 
                                                        data-hint="Editar">
                                                    <i class="fa fa-edit" style="color: Dodgerblue"></i>
                                                </button>
                                            
                                                <button type="button" class="btn btn-default"
                                                        data-ajax="<?= Url::to(['/sucursales/borrar', 'id' => $model['IdSucursal']]) ?>"
                                                        data-hint="Borrar">
                                                    <i class="far fa-trash-alt" style="color: Tomato"></i>
                                                </button>
                                            
                                                <a class="btn btn-default"
                                                        href="<?= Url::to(['/lotes/', 'id' => $model['IdSucursal']]) ?>"
                                                        data-hint="Lotes">
                                                    <i class="fas fa-sitemap" style="color: Green"></i>
                                                </a>

                                                <a class="btn btn-default"
                                                        href="<?= Url::to(['/vacas', 'idS' => $model['IdSucursal'], 'idL' => 0]) ?>"
                                                        data-hint="Vacas">
                                                    <i class="fas fa-hat-cowboy-side" style="color: Brown"></i>
                                                </a>

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
            <p><strong>No hay sucursales que coincidan con el criterio de búsqueda utilizado.</strong></p>
        <?php endif; ?>
    </div>
</div>