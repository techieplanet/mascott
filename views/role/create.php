<?php

use yii\helpers\Html;
use yii\web\View;

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
        'role-create-menu'
    );
?>