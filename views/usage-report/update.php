<?php

use yii\helpers\Html;
use yii\web\View;

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
            <?= Html::a('Create New Report', ['create'], ['class' => 'btn btn-mas pull-right margintop5 marginleft5']); ?>
            <?= Html::a('<span class="glyphicon glyphicon-chevron-left"></span>Back', 
                    ['index'], ['class'=>'btn btn-mas pull-right margintop5']) ?>
        </h1>
    </p>

    <?= $this->render('_form', [
        'model' => $model,
        'lh' => $lh,
        'parentsJson' => $parentsJson
    ]) ?>

</div>

<?php
    $this->registerJs(
            "$('#usage-menu').addClass('active');"
        ,View::POS_LOAD,
        'reports-update-menu'
    );
?>