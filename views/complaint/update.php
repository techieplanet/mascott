<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Complaint */

$this->title = 'Update Complaint: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Complaints', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="complaint-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

<?php
    $this->registerJs(
            "$('#complaint-menu').addClass('active');"
        ,View::POS_LOAD,
        'complaint-update-menu'
    );
?>
