<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\User */

$this->title = 'User';
$subtitle = 'Create New User';
//$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-create x-create-padding">

    <p>
        <h1>
            <?= Html::a(Html::encode($this->title), ['index'], ['class' => '']); ?> <small>(<?= $subtitle; ?>)</small>
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

</div>