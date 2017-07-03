<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\web\View;
use app\views\helpers\ActionButton;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider 
/* @var $user app\models\User */

$this->title = 'Users';
//$this->params['breadcrumbs'][] = $this->title;
?>

<section class="content-header">
    <h1><?= $this->title; ?></h1>
</section>

<div class="row">
    <div class="col-md-12">
        <p class="text-right">
            <?= Html::a('Create User', ['create'], ['class' => 'btn btn-success']) ?>
        </p>
    </div>
</div>

<div class="col-md-12">
    <table id="list" class="table table-striped table-bordered dataTable" role="grid" style="width: 100%;">
        <thead>
            <tr>
                <th class="">SN</th>
                <th class="">First Name</th>
                <th class="">Last Name</th>
                <th class="">Designation</th>
                <th class="">Email</th>
                <th class="">Phone</th>
                <th class="">Role</th>
                <th class="">Actions</th>
            </tr>
        </thead>
    <?php
        //echo is_array($roles) ? 'array' : 'scalar'; exit;
        $count=0;
        foreach($users as $user){
    ?>
            <tbody>
                <tr>
                    <td><?php echo ++$count; ?></td>
                    <td><?php echo $user->firstname; ?></td>
                    <td><?php echo $user->middlename; ?></td>
                    <td><?php echo $user->lastname; ?></td>
                    <td><?php echo $user->designation; ?></td>
                    <td><?php echo $user->email; ?></td>
                    <td><?php echo $user->phone; ?></td>
                    <td><?php echo $user->role_id; ?></td>
                    <td>
                        <span>
                            <?php echo ActionButton::updateButton('user', $user->id); ?>
                        </span>
                        <span class="marginleft10">
                            <?php echo ActionButton::deleteButton('user', $user->id); ?>
                        </span>
                    </td>
                </tr>
            </tbody>
    <?php
        }
    ?>
    </table>
</div>

<?php
    $this->registerJs(
        "$('#list').DataTable();",
        View::POS_READY,
        'users-list-data-table'
    );
?>