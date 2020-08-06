<?php

use common\models\Sucursales;
use yii\web\View;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use common\components\TiposUsuarioHelper;
// use nullref\datatable\DataTable;

use yii\data\ArrayDataProvider;
use kartik\export\ExportMenu;

/* @var $this View */
/* @var $form ActiveForm */

$this->title = 'Sucursales';
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

            <?= "" //$form->field($busqueda, 'Check')->checkbox(array('class' => 'check--buscar-form', 'label' => 'Listar Acciones', 'value' => 'S', 'uncheck' => 'N')); 
            ?>

            <?php ActiveForm::end(); ?>
        </div>

        <div class="btn-group" role="group" aria-label="...">
            <div class="alta--button">

                <?php if (TiposUsuarioHelper::esAdministrador()) : ?>
                    <div class="alta--button">
                        <!-- <span class="badge badge-danger">3</span> -->
                        <button type="button" class="btn btn-primary" data-modal="<?= Url::to(['/sucursales/alta']) ?>" data-mensaje="Nueva Sucursal">
                            Nueva Sucursal
                        </button>
                    </div>
                <?php endif ?>

            </div>

            <div class="alta--button" style="padding-left: 12px;">
                <?=
                    ExportMenu::widget([
                        'dataProvider' => new ArrayDataProvider(['allModels' => $models]),
                        'asDropdown' => true,
                        'dropdownOptions' => [
                            'label' => 'Exportar todas',
                            'title' => false,
                            'icon' => '<i class="fas fa-file-export" style="color: Dodgerblue"></i>',
                        ],
                        'columnSelectorOptions' => [
                            'label' => 'Columnas...',
                            'title' => false,
                            'icon' => false,
                        ],
                        'columns' => [
                            // ['class' => 'yii\grid\SerialColumn'],
                            // 'IdSucursal',
                            // 'Nombre',
                            [
                                'attribute' => 'Nombre',
                                'vAlign' => 'middle',
                                'width' => '400px',
                            ],
                            [
                                'attribute' => 'Litros',
                                'label' => 'Litros Registrados',
                            ],
                            [
                                'attribute' => 'Datos',
                                'label' => 'Direccion',
                                'value' => function ($model) {
                                    $direcion = json_decode($model['Datos'])->Direccion ?? 'ZZ';
                                    return Html::encode($direcion);
                                },
                                'format' => 'raw'
                            ],
                            [
                                'attribute' => 'Datos',
                                'label' => 'Telefono',
                                'value' => function ($model) {
                                    $telefono = json_decode($model['Datos'])->Telefono ?? 'GG';
                                    return Html::encode($telefono);
                                },
                            ],
                            // ['class' => 'yii\grid\ActionColumn'],
                        ],
                        'selectedColumns' => [0, 1, 2],
                        'disabledColumns' => [0], // Nombre de la Sucursal
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
            <!-- <span class="badge badge-danger">4</span> -->
            <div class="card">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table">
                            <thead class="bg-light">
                                <tr class="border-0">
                                    <th>Sucursal</th>
                                    <th>Datos</th>
                                    <th>Litros Registrados</th>
                                    <th>Operaciones</th>
                                    <?php if ($busqueda['Check'] == 'S') : ?>
                                        <!-- <th>Acciones</th> -->
                                    <?php endif ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($models as $model) : ?>
                                    <tr>
                                        <td><?= Html::encode($model['Nombre']) ?></td>
                                        <td>
                                            <ul>
                                                <?php foreach (json_decode($model['Datos']) as $nombre => $valor) : ?>
                                                    <?php if ($nombre != 'ApiKey') : ?>
                                                        <li><?= Html::encode($nombre) ?>: <?= Html::encode($valor) ?></li>
                                                    <?php endif ?>
                                                <?php endforeach; ?>
                                            </ul>
                                        </td>
                                        <td><?= Html::encode($model['Litros']) ?></td>
                                        <td>
                                            <!-- Operaciones -->
                                            <div class="btn-group" role="group" aria-label="...">

                                                <button type="button" class="btn btn-default" data-modal="<?= Url::to(['/sucursales/alta-registro', 'id' => $model['IdSucursal']]) ?>" data-mensaje="Añadir Registro de Leche">
                                                    <!-- <span class="badge badge-danger">5</span> -->
                                                    <i class="fas fa-plus-circle" style="color: Tomato"></i>
                                                </button>

                                                <a class="btn btn-default" href="<?= Url::to(['/sucursales/detalle', 'id' => $model['IdSucursal']]) ?>" data-mensaje="Detalle">
                                                    <!-- <span class="badge badge-danger">6</span> -->
                                                    <i class="fas fa-info" style="color: Dodgerblue"></i>
                                                </a>

                                                <?php if (TiposUsuarioHelper::esAdministrador()) : ?>
                                                    <a class="btn btn-default" href="<?= Url::to(['/ventas', 'id' => $model['IdSucursal']]) ?>" data-mensaje="Ventas">
                                                        <!-- <span class="badge badge-danger">7</span> -->
                                                        <i class="fas fa-shopping-cart" style="color: Green"></i>
                                                    </a>
                                                <?php endif ?>

                                                <a class="btn btn-default" href="<?= Url::to(['/lotes', 'id' => $model['IdSucursal']]) ?>" data-mensaje="Lotes">
                                                    <!-- <span class="badge badge-danger">8</span> -->
                                                    <i class="fas fa-sitemap" style="color: Indigo"></i>
                                                </a>

                                                <a class="btn btn-default" href="<?= Url::to(['/vacas', 'idS' => $model['IdSucursal'], 'idL' => 0]) ?>" data-mensaje="Vacas">
                                                    <!-- <span class="badge badge-danger">9</span> -->
                                                    <!-- <img src="./cow.ico"> -->
                                                    <i class="fas fa-hat-cowboy-side" style="color: Brown"></i>
                                                </a>

                                                <!-- TiposUsuarioHelper::esAdministrador() -->
                                                <?php if (TiposUsuarioHelper::esAdministrador()) : ?>
                                                    <button type="button" class="btn btn-default" data-modal="<?= Url::to(['/sucursales/editar', 'id' => $model['IdSucursal']]) ?>" data-mensaje="Editar">
                                                        <!-- <span class="badge badge-danger">10</span> -->
                                                        <i class="fa fa-edit" style="color: Dodgerblue"></i>
                                                    </button>

                                                    <button type="button" class="btn btn-default" data-modal="<?= Url::to(['/sucursales/borrar', 'id' => $model['IdSucursal']]) ?>" data-mensaje="Borrar">
                                                        <!-- <span class="badge badge-danger">11</span> -->
                                                        <i class="far fa-trash-alt" style="color: Tomato"></i>
                                                    </button>
                                                <?php endif ?>

                                            </div>
                                        </td>
                                        <?php if ($busqueda['Check'] == 'S') : ?>
                                            <!-- <td>
                                        Acciones
                                        <div class="btn-group" role="group" aria-label="...">
                  
                                                

                                        </div>
                                    </td>  -->
                                        <?php endif ?>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        <?php else : ?>
            <p><strong>No hay sucursales que coincidan con el criterio de búsqueda utilizado.</strong></p>
        <?php endif; ?>

    </div>
</div>