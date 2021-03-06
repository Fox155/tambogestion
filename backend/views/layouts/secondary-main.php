<?php

/* @var $this \yii\web\View */
/* @var $content string */

use backend\assets\AppAsset;
use yii\helpers\Html;
use common\widgets\Alert;

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
<body id="page-top">
<?php $this->beginBody() ?>

  <!-- Dashboar Main Wrapper -->
  <div class="dashboard-main-wrapper">
    
    <?php if (isset(Yii::$app->user->identity->IdTambo)): ?>
    <!-- NAV BAR -->
    <nav class="navbar navbar-expand navbar-dark bg-dark static-top">

      <a class="navbar-brand mr-1" href="/">Tambo Gestion</a>

      <button class="btn btn-link btn-sm text-white order-1 order-sm-0" id="sidebarToggle" href="#">
        <i class="fas fa-bars"></i>
      </button>

      <!-- Navbar Search -->
      <form class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">
        <div class="input-group">
          <input type="text" class="form-control" placeholder="Buscar por..." aria-label="Search" aria-describedby="basic-addon2">
          <div class="input-group-append">
            <button class="btn btn-primary" type="button">
              <i class="fas fa-search"></i>
            </button>
          </div>
        </div>
      </form>

      <!-- Navbar -->
      <ul class="navbar-nav ml-auto ml-md-0">
        <li class="nav-item dropdown no-arrow mx-1">
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
        </li>
        <li class="nav-item dropdown no-arrow mx-1">
          <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <span class="badge badge-danger">5</span>
            <i class="fas fa-envelope fa-fw"></i>
          </a>
          <div class="dropdown-menu dropdown-menu-right" aria-labelledby="messagesDropdown">
            <a class="dropdown-item" href="#">Action</a>
            <a class="dropdown-item" href="#">Another action</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="#">Something else here</a>
          </div>
        </li>
        <li class="nav-item dropdown no-arrow">
          <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-user-circle fa-fw"></i>
          </a>
          <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
            <a class="dropdown-item" href="#">Settings</a>
            <a class="dropdown-item" href="#">Activity Log</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">Logout</a>
          </div>
        </li>
      </ul>

    </nav>
    <!-- NAV BAR -->
    <?php endif?>
    
    <!-- Wrapper -->
    <div id="wrapper">

      <?php if (isset(Yii::$app->user->identity->IdTambo)): ?>
      <!-- Sidebar -->
          <?= $this->render('menu') ?>
      <!-- #/Sidebar -->
      <?php endif?>

      <!-- Content Dashboard Wrapper -->
      <div id="content-wrapper" class="dashboard-wrapper">
        <!-- /.container-fluid -->
        <div class="container-fluid dashboard-content ">
            <?php if (isset(Yii::$app->user->identity->IdTambo)): ?>
            <!-- Page Header -->
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="page-header">
                        <h2 class="pageheader-title"><?= $this->title ?></h2>
                        <div class="container">
                            <?= Alert::widget() ?>
                        </div>
                        <div class="page-breadcrumb">
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
            <!-- Page Header -->
            <?php endif?>
            <?= $content ?>
        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- Content Dashboard Wrapper -->

      <!-- Sticky Footer -->
      <footer class="sticky-footer">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>Copyright © Tambo Gestion 2019</span>
          </div>
        </div>
      </footer>

    </div>
    <!-- Wrapper -->

  </div>
  <!-- Dashboar Main Wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Logout Modal-->
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Listo para salir?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Seleccione "Cerrar sesión" a continuación si está listo para finalizar su sesión actual.</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
          <a class="btn btn-primary" href="/usuarios/logout">Cerrar sesión</a>
        </div>
      </div>
    </div>
  </div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>