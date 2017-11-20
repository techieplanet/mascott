<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Complaint */

$this->title = 'Create Complaint';
$this->params['breadcrumbs'][] = ['label' => 'Complaints', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="complaint-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>


<?php
    $this->registerJs(
            "$('#complaint-menu').addClass('active');"
        ,View::POS_LOAD,
        'complaint-create-menu'
    );
?>
