<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\UsageReport */

$this->title = 'Usage Report';
$subtitle = 'Edit Report';
//$this->params['breadcrumbs'][] = ['label' => 'Usage Reports', 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
//$this->params['breadcrumbs'][] = 'Update';
?>
<div class="usage-report-update">

    <p>
        <h1>
            <?= Html::a(Html::encode($this->title), ['index'], ['class' => '']); ?> <small>(<?= $subtitle; ?>)</small>
            <?= Html::a('Create Report', ['create'], ['class' => 'btn btn-success pull-right']); ?>
        </h1>
    </p>

    <?= $this->render('_form', [
        'model' => $model,
        'lh' => $lh,
        'parentsJson' => $parentsJson
    ]) ?>

</div>
