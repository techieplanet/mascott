<?php
    use yii\helpers\Html;

?>


<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel text-center">
        <div class="image">
            <?= Html::img('@web/images/user.png', ['alt' => 'User Image']) ?>
        </div>
          <div class="padding10 text-center" style="color: #fff;">
          <p>Firstname Lastname</p>
          
        </div>
      </div>
     
      <!-- /.search form -->
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu">
        
        <!--------  DASHBOARD   -------------->
        <li class="active">
          <a href="#">
            <i class="fa fa-dashboard"></i> <span>DASHBOARD</span></i>
          </a>
        </li>
        
        <!--------  REGISTRATION   -------------->
        <li class="treeview">
          <a href="#">
            <i class="fa fa-files-o"></i>
            <span>REGISTRATION</span>
            <i class="fa fa-angle-left pull-right"></i>
          </a>
          <ul class="treeview-menu">
              <li>
                  <a href="pages/layout/top-nav.html" style="word-wrap: normal; ">
                      Product
                  </a>
              </li>
              <li>
                  <a href="pages/layout/boxed.html">
                      MAS Provider
                  </a>
              </li>
          </ul>
        </li>
        
        <!--------  USAGE   -------------->
        <li class="treeview">
          <a href="#">
            <i class="fa fa-files-o"></i>
            <span>USAGE</span>
            <i class="fa fa-angle-left pull-right"></i>
          </a>
          <ul class="treeview-menu">
              <li>
                  <a href="pages/layout/top-nav.html" style="word-wrap: normal; ">
                      Number of MAS requests <br/>received
                  </a>
              </li>
              <li>
                  <a href="pages/layout/boxed.html">
                      Percentage MAS activated <br/>products used
                  </a>
              </li>
          </ul>
        </li>
        
        
        <!--------  COUNTERFEITS   -------------->
        <li class="treeview">
          <a href="#">
            <i class="fa fa-files-o"></i>
            <span>COUNTERFEITS</span>
            <i class="fa fa-angle-left pull-right"></i>
          </a>
          <ul class="treeview-menu">
              <li>
                  <a href="pages/layout/top-nav.html" style="word-wrap: normal; ">
                      Percentage MAS requests <br/>confirmed counterfeits
                  </a>
              </li>
              <li>
                  <a href="pages/layout/boxed.html">
                      Percentage of reported fake <br/>responses confirmed as <br/>counterfeits
                  </a>
              </li>
          </ul>
        </li>
        
        <li>
          <a href="pages/calendar.html">
            <i class="fa fa-calendar"></i> 
            <span>USERS</span>
          </a>
        </li>
        
        <li>
          <a href="pages/calendar.html">
            <i class="fa fa-user"></i> 
            <span>ROLES</span>
          </a>
        </li>
        
        <li>
          <a href="pages/calendar.html">
            <i class="fa fa-user"></i> 
            <span>PROFILE</span>
          </a>
        </li>
        
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>