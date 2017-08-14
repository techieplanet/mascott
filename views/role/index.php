
<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\web\View;
use app\views\helpers\ActionButton;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */


$this->title = 'Roles';
//$this->params['breadcrumbs'][] = $this->title;

?>

<section class="content-header">
    <h1><?= $this->title; ?></h1>
</section>

<div class="row">
    <div class="col-md-12">
        <p class="text-right">
            <?= Html::a('Create Role', ['create'], ['class' => 'btn btn-success']) ?>
        </p>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <table id="rolesList" class="table table-striped table-bordered dataTable" role="grid" style="width: 100%;">
            <thead>
                <tr>
                    <th class="sorting">SN</th>
                    <th class="sorting">Title</th>
                    <th class="sorting">Description</th>
                    <th>Actions</th>
                </tr>
            </thead>
              <tfoot>
                <tr>
                    <th class="sorting">SN</th>
                    <th class="sorting">Title</th>
                    <th class="sorting">Description</th>
                    <th>Actions</th>
                </tr>
            </tfoot>
                <tbody>
        <?php
            //echo is_array($roles) ? 'array' : 'scalar'; exit;
            $count=0;
            foreach($roles as $role){
        ?>
                
                    <tr>
                        <td><?php echo ++$count; ?></td>
                        <td><?php echo $role->title; ?></td>
                        <td><?php echo $role->description; ?></td>
                        <td>
                            <span>
                                <?php echo ActionButton::updateButton('role', $role->id); ?>
                            </span>
                            <span class="marginleft10">
                                <?php echo ActionButton::deleteButton('role', $role->id); ?>
                            </span>
                        </td>
                    </tr>
        <?php
            }
        ?>
                 </tbody>
        </table>
    </div>
</div>    

<?php
    $this->registerJs(
        "$('#rolesList').DataTable();",
        View::POS_READY,
        'roles-list-data-table'
    );
?>

<?php
    $this->registerJs(
            "$('#role-menu').addClass('active');"
        ,View::POS_LOAD,
        'role-menu'
    );
?>