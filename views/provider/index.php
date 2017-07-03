<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Providers';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="provider-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Provider', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'provider_name',
            'street:ntext',
            'city',
            'state',
            // 'contact_person',
            // 'contact_phone',
            // 'contact_email:email',
            // 'created_by',
            // 'created_date',
            // 'modified_by',
            // 'modified_date',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
