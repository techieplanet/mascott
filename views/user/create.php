<?php

use yii\helpers\Html;
use yii\web\View;

/* @var $this yii\web\View */
/* @var $model app\models\User */

$this->title = 'User';
$subtitle = 'Create New User';
//$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-create x-create-padding">

    <p>
        <?= Html::a('<span class="glyphicon glyphicon-chevron-left"></span>Back', 
                ['index'], ['class'=>'btn btn-mas pull-right margintop5']) ?>
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

<?php
    $this->registerJs(
            "$('#user-menu').addClass('active');"
        ,View::POS_LOAD,
        'user-create-menu'
    );
?>