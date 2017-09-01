<?php
    use yii\helpers\Html;
    use yii\helpers\Url;
    $permissions = Yii::$app->session['user_permissions'];
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
          <?= 
                Yii::$app->user->identity->firstname . ' ' . 
                Yii::$app->user->identity->lastname;
          ?>
        </div>
      </div>
     
      <!-- /.search form -->
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu">
        
        <!--------  DASHBOARD   -------------->
        <li id="dashboard-menu" class="">
          <?= Html::a('<i class="fa fa-dashboard"></i> DASHBOARD',
                  '@web/site/dashboard', 
                  ['title' => '', 'style'=> 'word-wrap: normal;']); ?>
        </li>
        
        <!--------  REGISTRATION   -------------->
        <?php
            if(
                    in_array('view_edit_form_a', $permissions) ||
                    in_array('view_edit_hcr', $permissions) ||
                    in_array('view_edit_mas_provider', $permissions) 
              ) {
        ?>
                <li id="reg-menu" class="treeview">
                  <a href="#">
                    <i class="fa fa-files-o"></i>
                    <span>REGISTRATION</span>
                    <i class="fa fa-angle-left pull-right"></i>
                  </a>
                  <ul class="treeview-menu">
                      <?php if(in_array('view_edit_form_a', $permissions)) { ?>
                        <li id="reg_product-menu" class="">
                          <?= Html::a('Product','@web/product', ['title' => '', 'style'=> 'word-wrap: normal;']); ?>
                        </li>
                      <?php } ?>
                      <?php if(in_array('view_edit_mas_provider', $permissions)) { ?>
                        <li id="reg_provider-menu">
                          <?= Html::a('MAS Provider','@web/provider', ['title' => '', 'style'=> 'word-wrap: normal;']); ?>
                        </li>
                      <?php } ?>
                      <?php if(in_array('view_edit_hcr', $permissions)) { ?>
                        <li id="reg_hcr-menu">
                          <?= Html::a('HCR','@web/hcr', ['title' => '', 'style'=> 'word-wrap: normal;']); ?>
                        </li>
                      <?php } ?>
                  </ul>
                </li>
                
        <?php } ?>
                
        <!--------  USAGE   -------------->
        <?php if(in_array('view_edit_form_b', $permissions)) { ?>
            <li id="usage-menu" class="">
                <?= Html::a('<i class="fa fa-files-o"></i>USAGE REPORT','@web/usage-report', ['title' => '', 'style'=> 'word-wrap: normal;']); ?>
            </li>
        <?php } ?>
        
        <?php if(in_array('view_edit_res_b', $permissions)) { ?>
            <li id="complaint-menu" class="">
                <?= Html::a('<i class="fa fa-files-o"></i> COMPLAINTS RESOLUTION',
                        '@web/complaint', 
                        ['title' => '', 'style'=> 'word-wrap: normal;']); ?>
            </li>
        <?php } ?>
        
        
        <?php
            if(
                in_array('view_charts_reports', $permissions) ||
                in_array('view_res_report', $permissions) ||
                in_array('view_regional_data', $permissions)  ||
                in_array('view_edit_form_a', $permissions) 
              ) {
        ?>
        <!--------  REPORTS   -------------->
            <li id="reports-menu" class="treeview">
              <a href="#">
                <i class="fa fa-files-o"></i> <span>REPORTS</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                
                <li id="reports_product-report-menu">
                  <a href="#"><i class="fa fa-circle-o"></i> Products <i class="fa fa-angle-left pull-right"></i></a>
                  <ul class="treeview-menu">
                     <?php if(in_array('view_edit_form_a', $permissions)) { ?>
                        <li id="reports_product-reg-update-menu" class="paddingxleft10">
                          <?= Html::a('<i class="fa fa-circle-o"></i> MAS Registration Update','@web/product/report', ['title' => '', 'style'=> 'word-wrap: normal;']); ?>
                        </li>
                        <li id="reports_product-expiry-menu" class="paddingleft10">
                          <?= Html::a('<i class="fa fa-circle-o"></i> Product Expiry Status','@web/product/expiring', ['title' => '', 'style'=> 'word-wrap: normal;']); ?>
                        </li>
                     <?php } ?>
                  </ul>
                </li>

                <li id="reports_usage-report-menu">
                  <a href="#"><i class="fa fa-circle-o"></i> Usage <i class="fa fa-angle-left pull-right"></i></a>
                  <ul class="treeview-menu">
                     <?php if(in_array('view_edit_form_b', $permissions)) { ?>
                    <li id="reports_usage-mas-requests-menu">
                        <?= Html::a('<i class="fa fa-circle-o"></i>Number of MAS requests <br/>received',
                                    '@web/usage-report/requests-received', 
                                    ['title' => '', 'style'=> 'word-wrap: normal;']); ?>
                    </li>
                    <li id="reports_usage-mas-activated-menu">
                        <?= Html::a('<i class="fa fa-circle-o"></i>Percentage MAS activated <br/>products used',
                                    '@web/usage-report/activated-used', 
                                    ['title' => '', 'style'=> 'word-wrap: normal;']); ?>
                    </li>
                     <?php }  ?>
                  </ul>
                </li>
                
                
                <?php if(in_array('view_res_report', $permissions)){ ?>
                    <li id="reports_counterfeits-report-menu">
                      <a href="#"><i class="fa fa-circle-o"></i> Counterfeits <i class="fa fa-angle-left pull-right"></i></a>
                      <ul class="treeview-menu">
                        <li id="reports_counterfeits-fake-responses-menu">
                            <?= Html::a('<i class="fa fa-circle-o"></i>Percentage of MAS requests <br/>that returned fake responses',
                                    '@web/counterfeit/fake-responses', 
                                    ['title' => '', 'style'=> 'word-wrap: normal;']); ?>
                        </li>
                        <li id="reports_counterfeits-confirmed-menu">
                            <?= Html::a('<i class="fa fa-circle-o"></i>Percentage MAS requests <br/>confirmed counterfeits',
                                    '@web/counterfeit/confirmed-counterfeits', 
                                    ['title' => '', 'style'=> 'word-wrap: normal;']); ?>
                        </li>
                        <li id="reports_counterfeits-fake-menu">
                            <?= Html::a('<i class="fa fa-circle-o"></i>Percentage of reported fake <br/>responses confirmed as <br/>counterfeits',
                                    '@web/counterfeit/fake-confirmed', 
                                    ['title' => '', 'style'=> 'word-wrap: normal;']); ?>
                            </a>
                        </li>
                      </ul>
                    </li>
                <?php } ?>

              </ul>
            </li>
        <?php } ?>
        
        
        <?php
            if(
                in_array('create_role', $permissions) ||
                in_array('edit_role', $permissions) ||
                in_array('view_role', $permissions) ||
                in_array('delete_role', $permissions)
              ) {
        ?>
            <li id="role-menu">
              <?= Html::a('<i class="fa fa-user"></i> ROLES','@web/role', 
                        ['title' => '', 'style'=> 'word-wrap: normal;']); ?>
            </li>
        <?php } ?>
            
        
        <?php
            if(
                in_array('create_user', $permissions) ||
                in_array('edit_user', $permissions) ||
                in_array('view_user', $permissions) ||
                in_array('delete_user', $permissions)
              ) {
        ?>
            <li id="user-menu">
                <?= Html::a('<i class="fa fa-user"></i> USERS','@web/user', 
                        ['title' => '', 'style'=> 'word-wrap: normal;']); ?>
            </li>
        <?php } ?>
            
            
        <li id="profile-menu" class="treeview">
            <a href="#">
                <i class="fa fa-user"></i>
                <span>PROFILE</span>
                <i class="fa fa-angle-left pull-right"></i>
            </a>
            <ul class="treeview-menu">
                <li id="profile_change-menu">
                    <?= Html::a(
                            '<i class="fa fa-user"></i> Change Profile',
                            Url::toRoute(['user/profile', 'id' => Yii::$app->user->id]), 
                            ['title' => '', 'style'=> 'word-wrap: normal;']); ?>
                </li>
              </ul>
        </li>
        
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>