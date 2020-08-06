<?php

use common\models\Lotes;
use common\models\Sucursal;
use yii\web\View;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use common\components\TiposUsuarioHelper;

use yii\data\ArrayDataProvider;
use kartik\export\ExportMenu;

/* @var $this View */
/* @var $form ActiveForm */
/* @var $models Lotes */
/* @var $sucursal Sucursales */

if (isset($sucursal['Nombre'])) {
    $this->params['breadcrumbs'][] = $anterior;
    $this->title = 'Lotes de la Sucursal: ' . $sucursal['Nombre'];
} else {
    $this->title = 'Lotes';
}

$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-sm-12">
        <div class="buscar--form">
            <?php $form = ActiveForm::begin(['layout' => 'inline',]); ?>

            <!-- <span class="badge badge-danger">1</span> -->
            <?= $form->field($busqueda, 'Cadena')->input('text', ['placeholder' => 'Búsqueda']) ?>

            <!-- <span class="badge badge-danger">2</span> -->
            <?= Html::submitButton('Buscar', ['class' => 'btn btn-secondary', 'name' => 'pregunta-button']) ?>

            <?= $form->field($busqueda, 'Check')->checkbox(array('class' => 'check--buscar-form', 'label' => 'Incluir Bajas', 'value' => 'S', 'uncheck' => 'N')); ?>
            <!-- <span class="badge badge-danger">3</span> -->

            <?= "" //$form->field($busqueda, 'Check2')->checkbox(array('class' => 'check--buscar-form', 'label' => 'Listar Acciones', 'value' => 'S', 'uncheck' => 'N')); 
            ?>

            <?php ActiveForm::end(); ?>
        </div>


        <div class="btn-group" role="group" aria-label="...">

            <div class="alta--button">
                <?php if (TiposUsuarioHelper::esAdministrador()) : ?>
                    <div class="alta--button">
                        <?php if (!isset($sucursal['Nombre'])) : ?>
                            <!-- <span class="badge badge-danger">4</span> -->
                            <button type="button" class="btn btn-primary" data-modal="<?= Url::to(['/lotes/alta/', 'id' => 0]) ?>" data-mensaje="Nuevo Lote">
                                Nuevo Lote
                            </button>
                        <?php else : ?>
                            <!-- <span class="badge badge-danger">4</span> -->
                            <button type="button" class="btn btn-primary" data-modal="<?= Url::to(['/lotes/alta/', 'id' => $sucursal['IdSucursal']]) ?>" data-mensaje="Nuevo Lote">
                                Nuevo Lote
                            </button>
                        <?php endif; ?>
                    </div>
                <?php endif ?>
            </div>

            <div class="alta--button" style="padding-left: 12px;">
                <?=
                    ExportMenu::widget([
                        'dataProvider' => new ArrayDataProvider(['allModels' => $models]),
                        'asDropdown' => true,
                        'dropdownOptions' => [
                            'label' => 'Exportar todos',
                            'title' => false,
                            'icon' => '<i class="fas fa-file-export" style="color: Dodgerblue"></i>',
                        ],
                        'columnSelectorOptions' => [
                            'label' => 'Columnas...',
                            'title' => false,
                            'icon' => false,
                        ],
                        'columns' => [
                            'Nombre',
                            'Sucursal',
                            'Ganado',
                        ],
                        'selectedColumns' => [0, 1, 2],
                        'disabledColumns' => [0],
                        'exportConfig' => [
                            // ExportMenu::FORMAT_HTML => [
                            //     'label' => 'HTML',
                            //     'mime' => 'text/html',
                            //     'extension' => 'html',
                            //     'writer' => ExportMenu::FORMAT_HTML
                            // ],
                            // ExportMenu::FORMAT_CSV => [
                            //     'label' => 'CSV',
                            //     'mime' => 'application/csv',
                            //     'extension' => 'csv',
                            //     'writer' => ExportMenu::FORMAT_CSV
                            // ],
                            // ExportMenu::FORMAT_TEXT => [
                            //     'label' => 'Texto',
                            //     'mime' => 'text/plain',
                            //     'extension' => 'csv',
                            //     'writer' => ExportMenu::FORMAT_TEXT
                            // ],
                            // ExportMenu::FORMAT_PDF => [
                            //     'label' => 'PDF',
                            //     'mime' => 'application/pdf',
                            //     'extension' => 'pdf',
                            //     'writer' => ExportMenu::FORMAT_PDF,
                            // ],
                            ExportMenu::FORMAT_HTML => false,
                            ExportMenu::FORMAT_CSV => false,
                            ExportMenu::FORMAT_TEXT => false,
                            ExportMenu::FORMAT_PDF => false,
                            ExportMenu::FORMAT_EXCEL => [
                                'label' => 'Excel 95 +',
                                'mime' => 'application/vnd.ms-excel',
                                'extension' => 'xls',
                                'writer' => ExportMenu::FORMAT_EXCEL
                            ],
                            ExportMenu::FORMAT_EXCEL_X => [
                                'label' => 'Excel 2007+',
                                'mime' => 'application/application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                                'extension' => 'xlsx',
                                'writer' => ExportMenu::FORMAT_EXCEL_X
                            ],
                        ],
                    ]);
                ?>
            </div>

        </div>

        <div id="errores"> </div>

        <?php if (count($models) > 0) : ?>
            <!-- <span class="badge badge-danger">5</span> -->
            <div class="card">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table">
                            <thead class="bg-light">
                                <tr class="border-0">
                                    <th>Lote</th>
                                    <th>Sucursal</th>
                                    <th>Ganado Total</th>
                                    <th>Estado</th>
                                    <th>Operaciones</th>
                                    <?php if ($busqueda['Check2'] == 'S') : ?>
                                        <!-- <th>Acciones</th> -->
                                    <?php endif ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($models as $model) : ?>
                                    <tr>
                                        <td><?= Html::encode($model['Nombre']) ?></td>
                                        <td><?= Html::encode($model['Sucursal']) ?></td>
                                        <td><?= Html::encode($model['Ganado']) ?></td>
                                        <td><?= Html::encode(Lotes::ESTADOS[$model['Estado']]) ?></td>
                                        <td>
                                            <!-- Operaciones -->
                                            <div class="btn-group" role="group" aria-label="...">

                                                <a class="btn btn-default" href="<?= Url::to(['/lotes/detalle', 'id' => $model['IdLote']]) ?>" data-mensaje="Detalle">
                                                    <!-- <span class="badge badge-danger">6</span> -->
                                                    <i class="fas fa-info" style="color: Dodgerblue"></i>
                                                </a>

                                                <a class="btn btn-default" href="<?= Url::to(['/vacas', 'idS' => $model['IdSucursal'], 'idL' => $model['IdLote']]) ?>" data-mensaje="Vacas">
                                                    <!-- <span class="badge badge-danger">7</span> -->
                                                    <i class="fas fa-hat-cowboy-side" style="color: Brown"></i>
                                                </a>

                                                <?php if (TiposUsuarioHelper::esAdministrador()) : ?>
                                                    <button type="button" class="btn btn-default" data-modal="<?= Url::to(['/lotes/editar', 'id' => $model['IdSucursal'], 'idL' => $model['IdLote']]) ?>" data-mensaje="Editar">
                                                        <!-- <span class="badge badge-danger">8</span> -->
                                                        <i class="fa fa-edit" style="color: Dodgerblue"></i>
                                                    </button>

                                                    <button type="button" class="btn btn-default" data-modal="<?= Url::to(['/lotes/dar-baja', 'id' => $model['IdLote']]) ?>" data-mensaje="Borrar">
                                                        <!-- <span class="badge badge-danger">9</span> -->
                                                        <i class="far fa-trash-alt" style="color: Tomato"></i>
                                                    </button>
                                                <?php endif ?>

                                            </div>
                                        </td>
                                        <?php if ($busqueda['Check2'] == 'S') : ?>
                                            <!-- <td>
                                        <div class="btn-group" role="group" aria-label="...">
                                                

                                        </div>
                                    </td> -->
                                        <?php endif ?>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        <?php else : ?>
            <p><strong>No hay Lotes que coincidan con el criterio de búsqueda utilizado.</strong></p>
        <?php endif; ?>
    </div>
</div>