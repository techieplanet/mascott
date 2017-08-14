<?php

use yii\helpers\Html;
use yii\web\View;

/* @var $this yii\web\View */
/* @var $model app\models\Role */

$this->title = 'Roles ';
$subtitle = 'Edit Role: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Roles', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="role-update">

    <p>
        <h1>
            <?= Html::a(Html::encode($this->title), ['index'], ['class' => '']); ?> <small>(<?= $subtitle; ?>)</small>
            <?= Html::a('Create New Role', ['create'], ['class' => 'btn btn-mas pull-right margintop5 marginleft5']); ?>
            <?= Html::a('<span class="glyphicon glyphicon-chevron-left"></span>Back', 
                    ['index'], ['class'=>'btn btn-mas pull-right margintop5']) ?>
        </h1>
    </p>

    <?= $this->render('_form', [
        'model' => $model,
        'processedPermissions' => $processedPermissions,
        'rolePermissions' => $rolePermissions,
    ]) ?>

</div>


<?php
    $this->registerJs(
            "$('#role-menu').addClass('active');"
        ,View::POS_LOAD,
        'role-update-menu'
    );
?>