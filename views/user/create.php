<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\User */

$this->title = 'User';
$subtitle = 'Create New User';
//$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-create">

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
        'rolesMap' => $rolesMap,
        'success' => $success,
        'selectedRoleId' => $selectedRoleId,
        'selectedDesignation' => $selectedDesignation,
    ]) ?>

</div>
