<?php

/* @var $this \yii\web\View */
/* @var $content string */

use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\helpers\Url;
use common\widgets\Alert;

// if (Yii::$app->user->isGuest) {
//   $this->redirect(['/usuarios/login']);
// }

AppAsset::register($this);

$defaultCrumb = [ 'label' => 'Inicio', 'link' => '/' ];

if (isset($this->params['breadcrumbs'])) {
    array_unshift($this->params['breadcrumbs'], $defaultCrumb);
} else {
    $this->params['breadcrumbs'] = [
        $defaultCrumb
    ];
}

$usuario = Yii::$app->user->identity;

$this->registerJs('Main.iniciar()');
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode("Tambo Gestion") ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
    <div class="dashboard-main-wrapper">

      <?php if (isset(Yii::$app->user->identity->IdTambo)): ?>
      <!-- NAV BAR -->
      <nav class="navbar navbar-expand navbar-dark bg-dark static-top">
      <div class="navbar-collapse collapse justify-content-between">
        <div class="navbar-collapse collapse justify-content-left">
        <a class="navbar-brand mr-1" href="/">
        <!-- <span class="badge badge-danger">1</span> -->
        Tambo Gestion</a>

        <button class="btn btn-link btn-sm text-white order-1 order-sm-0" id="sidebarToggle" href="#">
          <!-- <span class="badge badge-danger">2</span> -->
          <i class="fas fa-bars"></i>
        </button>
        </div>

        <!-- Navbar -->
        <ul class="navbar-nav ml-auto ml-md-0">
          <!-- <li class="nav-item dropdown no-arrow mx-1">
            <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <span class="badge badge-danger">3</span>
              <i class="fas fa-bell fa-fw"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="alertsDropdown">
              <a class="dropdown-item" href="#">Action</a>
              <a class="dropdown-item" href="#">Another action</a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" href="#">Something else here</a>
            </div>
          </li> -->
          <li class="nav-item dropdown no-arrow">
            <!-- <span class="badge badge-danger justify-content-left">3</span> -->
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <i class="fas fa-user-circle fa-fw"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
              <button type="button" class="dropdown-item"
                  data-modal="<?= Url::to(['/usuarios/cambiar-password']) ?>" >
                  <!-- <span class="badge badge-danger">14</span> -->
                  <i class="fas fa-key"></i>
                  Cambiar mi Contraseña
              </button>
              <div class="dropdown-divider"></div>
              <button type="button" class="dropdown-item"
                      data-modal="<?= Url::to(['/usuarios/logout']) ?>" >
                  <!-- <span class="badge badge-danger">15</span> -->
                  <i class="fas fa-power-off"></i>
                  Cerrar sesión
              </button>
            </div>
          </li>
        </ul>

      </div>
      </nav>
      <!-- NAV BAR -->
      <?php endif?>

      <div class="d-flex" id="wrapper">
        
        <?php if (isset(Yii::$app->user->identity->IdTambo)): ?>
        <!-- Sidebar -->
            <?= $this->render('menu') ?>
        <!-- #/Sidebar -->
        <?php endif?>

        <!-- Page Content -->
        <div id="page-content-wrapper">

          <div class="dashboard-wrapper">
            <div class="container-fluid dashboard-content ">
                <?php if (isset(Yii::$app->user->identity->IdTambo)): ?>
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="page-header">
                            <!-- <span class="badge badge-danger">11</span> -->
                            <h2 class="pageheader-title"><?= $this->title ?></h2>
                            <div class="container">
                                <?= Alert::widget() ?>
                            </div>
                            <div class="page-breadcrumb">
                                <!-- <span class="badge badge-danger">12</span> -->
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                    <?php foreach ($this->params['breadcrumbs'] as $i => $crumb): ?>
                                        <?php if ($i === 0 || $i < count($this->params['breadcrumbs'])-1): ?>
                                        <li class="breadcrumb-item">
                                          <a href="<?= $crumb['link'] ?>" class="breadcrumb-link">
                                            <?= $crumb['label'] ?>
                                          </a>
                                        </li>
                                        <?php else: ?>
                                        <li class="breadcrumb-item active" aria-current="page">
                                          <?= $crumb ?>
                                        </li>
                                        <?php endif ?>
                                    <?php endforeach ?>
                                    </ol>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endif ?>
                <!-- <span class="badge badge-danger">13</span> -->
                <?=$content ?>
            </div>
          </div>
        </div>
        <!-- /#page-content-wrapper -->
      </div>
    </div>
    <!-- /#wrapper -->

    <a class="scroll-to-top rounded" href="#page-top">
      <i class="fas fa-angle-up"></i>
    </a>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
