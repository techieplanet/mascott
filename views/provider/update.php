<?php

use yii\helpers\Html;
use yii\web\View;

/* @var $this yii\web\View */
/* @var $model app\models\Provider */

$this->title = 'Provider';
$subtitle = 'Edit Provider: ' . $model->provider_name;

//$this->params['breadcrumbs'][] = ['label' => 'Providers', 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
//$this->params['breadcrumbs'][] = 'Update';
?>

<div class="provider-update">

    <p>
        <h1>
            <?= Html::a(Html::encode($this->title), ['index'], ['class' => '']); ?> <small>(<?= $subtitle; ?>)</small>
            <?= Html::a('Create New Provider', ['create'], ['class' => 'btn btn-mas pull-right margintop5 marginleft5']); ?>
            <?= Html::a('<span class="glyphicon glyphicon-chevron-left"></span>Back', 
                    ['index'], ['class'=>'btn btn-mas pull-right margintop5']) ?>
        </h1>
    </p>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

<?php
    $this->registerJs(
            "$('#reg-menu, #reg_provider-menu').addClass('active');"
        ,View::POS_LOAD,
        'product-list-data-table'
    );
?>