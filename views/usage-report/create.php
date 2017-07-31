<?php

use yii\helpers\Html;
use yii\web\View;

/* @var $this yii\web\View */
/* @var $model app\models\UsageReport */

$this->title = 'Usage Report';
$subtitle = 'Create New Usage Report';
//$this->params['breadcrumbs'][] = ['label' => 'Usage Reports', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="usage-report-create x-create-padding">

    <p>
        <h1>
            <?= Html::a(Html::encode($this->title), ['index'], ['class' => '']); ?> <small>(<?= $subtitle; ?>)</small>
            
            <?php
                //Yii::$app->session->hasFlash('saved') ?
                //Html::a('Create Provider', ['create'], ['class' => 'btn btn-success pull-right']) : 
                //''
            ?>
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
        'reports-create-menu'
    );
?>