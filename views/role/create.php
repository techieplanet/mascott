<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Role */

$this->title = 'Role';
$subtitle = 'Create New Role';
$this->params['breadcrumbs'][] = ['label' => 'Roles', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="role-create">

    <p>
        <h1>
            <?= Html::a(Html::encode($this->title), ['index'], ['class' => '']); ?> <small>(<?= $subtitle; ?>)</small>
            
            <?= 
                $success == true ?
                Html::a('Create Role', ['create'], ['class' => 'btn btn-success pull-right']) :
                ''
            ?>
        </h1>
    </p>

    <?= $this->render('_form', [
        'model' => $model,
        'processedPermissions' => $processedPermissions,
        'rolePermissions' => $rolePermissions,
        'success' => $success
    ]) ?>

</div>
