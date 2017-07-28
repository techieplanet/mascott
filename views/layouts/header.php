<?php
    use yii\helpers\Html;
    use yii\helpers\Url;
?>

<header class="main-header">
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top" role="navigation">
        <!-- Logo -->
        <a href="<?= Url::home(true) ?>" class="logo-anchor text-center">
            <div class="logo-icon pull-left">
                <?= Html::img('@web/images/logo.png', ['alt' => 'Logo']) ?>
            </div>
            <span class="logo-text">
                NATIONAL AGENCY FOR FOODS AND DRUGS<br/> ADMINISTRATION AND CONTROL (NAFDAC)<br/>
                <span class="sub-logo-text">MAS Reporting System</span>
            </span>
        </a>
        
      <!-- Sidebar toggle button-->
<!--      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>-->
      
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <?= Html::img('@web/images/user.png', ['alt' => 'User Image']) ?>
              <span class="hidden-xs">
                  <?= 
                        Yii::$app->user->identity->firstname . ' ' . 
                        Yii::$app->user->identity->lastname;
                  ?>
              </span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <!--<img src="dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">-->
                <p>
                  <?= 
                        Yii::$app->user->identity->firstname . ' ' . 
                        Yii::$app->user->identity->lastname . ' (' .
                        Yii::$app->user->identity->role->title . ')'; 
                  ?>
                </p>
              </li>
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="#" class="btn btn-default btn-flat">Profile</a>
                </div>
                <div class="pull-right">
                  <a href="<?= Url::toRoute('site/logout', true) ?>" class="btn btn-default btn-flat">Sign out</a>
                </div>
              </li>
            </ul>
          </li>
          <!-- Control Sidebar Toggle Button -->
<!--          <li>
            <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
          </li>-->
        </ul>
      </div>
    </nav>
  </header>