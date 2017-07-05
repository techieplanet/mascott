<?php

//use app\assets\AppAsset;
//AppAsset::register($this);  // $this represents the view object

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    
</head>
<body class="skin-green sidebar-mini wysihtml5-supported">
<?php $this->beginBody() ?>

<div class="wrapper">
    <?php require 'header.php'; ?>
    <?php require 'sidebar.php'; ?>

<!--    <div class="container">
        <?= 
            Breadcrumbs::widget([
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]) 
        ?>
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            
            <section class="content">
                <?= $content; ?>
            </section><!-- /.content -->
        </div><!-- /.content-wrapper -->
        
    
                
    <footer class="main-footer">
<!--        <div class="pull-right hidden-xs">
          <b>Version</b> 2.3.0
        </div>-->
        <div class="text-right"><strong>Copyright &copy; <?= date('Y') ?></strong> All rights reserved.</div>
    </footer>
    
</div>

<!--<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; My Company <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>-->

    <?php //require '../web/plugins/plugins.php' ?>
    
<?php $this->endBody() ?>

</body>
</html>
<?php $this->endPage() ?>
