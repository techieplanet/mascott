<?php

use yii\helpers\Html;

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
            <?= Html::a('Create Role', ['create'], ['class' => 'btn btn-success pull-right']); ?>
        </h1>
    </p>

    <?= $this->render('_form', [
        'model' => $model,
        'processedPermissions' => $processedPermissions,
        'rolePermissions' => $rolePermissions,
    ]) ?>

</div>
