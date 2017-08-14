<?php

use yii\helpers\Html;
use yii\web\View;

/* @var $this yii\web\View */
/* @var $model app\models\User */

$this->title = 'Users';
$subtitle = 'Edit User: ' . $model->firstname . ' ' . $model->lastname;
//$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
//$this->params['breadcrumbs'][] = 'Update';
?>
<div class="user-update">

    <p>
        <h1>
            <?= Html::a(Html::encode($this->title), ['index'], ['class' => '']); ?> <small>(<?= $subtitle; ?>)</small>
            <?= Html::a('Create New User', ['create'], ['class' => 'btn btn-mas pull-right margintop5 marginleft5']); ?>
            <?= Html::a('<span class="glyphicon glyphicon-chevron-left"></span>Back', 
                    ['index'], ['class'=>'btn btn-mas pull-right margintop5']) ?>
        </h1>
    </p>

    <?= $this->render('_form', [
        'model' => $model,
        'rolesMap' => $rolesMap,
        'providerMap' => $providerMap,
        //'success' => $success,
        //'selectedRoleId' => $selectedRoleId,
        //'selectedDesignation' => $selectedDesignation,
    ]) ?>

    <?php //unset($model->role) ?>
</div>


<?php
    $this->registerJs(
            "$('#user-menu').addClass('active');"
        ,View::POS_LOAD,
        'user-update-menu'
    );
?>