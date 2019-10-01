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

$this->registerJs('Main.init()');
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
        <div class="d-flex" id="wrapper">

        <!-- Sidebar -->
        <div class="bg-light border-right" id="sidebar-wrapper">
        <div class="sidebar-heading">Tambo Gestion</div>
        <div class="list-group list-group-flush">
                <nav class="navbar navbar-expand-lg navbar-light">
                    <a  
                        class="navbar-toggler"
                        style="background: none;"
                        data-toggle="collapse" 
                        data-target="#navbarNav" 
                        aria-controls="navbarNav" 
                        aria-expanded="false" 
                    >
                        <i class="fas fa-caret-down"></i>
                    </a>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <?= $this->render('menu') ?>
                    </div>
                </nav>
            </div>
        </div>
        <!-- /#sidebar-wrapper -->

        <!-- Page Content -->
        <div id="page-content-wrapper">
        <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
	    <button class="btn btn-primary" id="menu-toggle">Icono</button>

	    <button class="navbar-toggler" type="button"
		data-toggle="collapse"
		data-target="#navbarSupportedContent"
		aria-controls="navbarSupportedContent"
		aria-expanded="false"
		aria-label="Toggle navigation">
		    <span class="navbar-toggler-icon"></span>
	    </button>
            <div class="collapse navbar-collapse " id="navbarSupportedContent">
                <ul class="navbar-nav ml-auto navbar-right-top">
                    <li class="nav-item dropdown nav-user">
                        <a class="nav-link nav-user-img" href="#" id="navbarDropdownMenuLink2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="far fa-user"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right nav-user-dropdown" aria-labelledby="navbarDropdownMenuLink2">
                            <?php if (isset(Yii::$app->user->identity->IdTambo)): ?>
                            <div class="nav-user-info">
                                <h5 class="mb-0 text-white nav-user-name">
                                    <?= "$usuario->Usuario" ?>
                                </h5>
                            </div>
                            <a class="dropdown-item" href="/usuarios/logout">
                                <i class="fas fa-power-off mr-2"></i>Cerrar sesión
                            </a>
                            <?php endif?>
                        </div>
                    </li>
                </ul>
            </div>
        </nav>
        <?php endif?>
        <div class="dashboard-wrapper">
            <div class="container-fluid dashboard-content ">
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
                <?= $content ?>
            </div>
        </div>
        <!-- /#page-content-wrapper -->

    </div>
    <!-- /#wrapper -->
    <script>
	$("#menu-toggle").click(function(e) {
            e.preventDefault();
            $("#wrapper").toggleClass("toggled");
	});
    </script>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
