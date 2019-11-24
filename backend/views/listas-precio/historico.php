<?php

/* @var $this \yii\web\View */
/* @var $content string */

use common\components\FechaHelper;
use yii\helpers\Html;

?>

<div class="modal-dialog">
    <div class="modal-content">

        <div class="modal-header">
            <h5 class="modal-title"><?= $titulo ?>: <?= $lista['Lista'] ?></h5>
            <button type="button" class="close" onclick="Main.modalCerrar()">
                <span aria-hidden="true">&times;</span>
            </button>
            <!-- <span class="badge badge-danger">1</span> -->
        </div>
            
        <div class="modal-body">
            <?php if (count($models) > 0): ?>
            <!-- <span class="badge badge-danger">2</span> -->
            <div class="card">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table">
                            <thead class="bg-light">
                                <tr class="border-0">
                                    <th>Precio</th>
                                    <th>Fecha de Inicio</th>
                                    <th>Fecha de Fin</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($models as $model): ?>
                                    <tr>
                                        <td><?= Html::encode($model['Precio']) ?></td>
                                        <td><?= Html::encode(FechaHelper::toDateLocal($model['FechaInicio'])) ?></td>
                                        <td><?= Html::encode(FechaHelper::toDateLocal($model['FechaFin'])) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <?php else: ?>
                <p><strong>No hay un Listado Historico para esta Lista.</strong></p>
            <?php endif; ?>
        </div>

        <div class="modal-footer">
            <!-- <span class="badge badge-danger">3</span> -->
            <button type="button" class="btn btn-default" onclick="Main.modalCerrar()">Cerrar</button>
        </div>
    </div>
</div>