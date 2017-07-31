<?php

use yii\helpers\Html;
use yii\web\View;

/* @var $this yii\web\View */
/* @var $model app\models\Provider */

$this->title = 'Create Provider';
$subtitle = 'Create New Provider';
//$this->params['breadcrumbs'][] = ['label' => 'Providers', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="provider-create x-create-padding">

    <p>
        <h1>
            <?= Html::a(Html::encode($this->title), ['index'], ['class' => '']); ?> <small>(<?= $subtitle; ?>)</small>
            
            <?= 
                Yii::$app->session->hasFlash('saved') ?
                Html::a('Create Provider', ['create'], ['class' => 'btn btn-success pull-right']) : 
                ''
            ?>
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