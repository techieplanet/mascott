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
<body class="skin-green centered-layout sidebar-mini wysihtml5-supported">
<?php $this->beginBody() ?>

<div class="wrapper">
    <?php require 'plain_header.php'; ?>

        <!-- Content Wrapper. Contains page content -->
        <!--<div class="content-wrapper">-->
            
            <section class="content">
                <div class="row">
                    <div class="col-md-4"></div>
                    <div class="col-md-4">
                        <?= $content; ?>
                    </div>
                    <div class="col-md-4"></div>
                </div>
            </section><!-- /.content -->
<!--        </div> /.content-wrapper -->
   
    
</div>
    
<?php $this->endBody() ?>

</body>
</html>
<?php $this->endPage() ?>
