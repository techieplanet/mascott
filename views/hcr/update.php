<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Hcr */

$this->title = 'HCR ';
$subtitle = 'Edit Hcr: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'HCR', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="hcr-update">

    <p>
        <h1>
            <?= Html::a(Html::encode($this->title), ['index'], ['class' => '']); ?> <small>(<?= $subtitle; ?>)</small>
            <?= Html::a('Create Hcr', ['create'], ['class' => 'btn btn-mas pull-right']); ?>
        </h1>
    </p>

    <?= $this->render('_form', [
        'model' => $model,
        'processedPermissions' => $processedPermissions,
        'hcrPermissions' => $hcrPermissions,
        'success' => $success
    ]) ?>

</div>

