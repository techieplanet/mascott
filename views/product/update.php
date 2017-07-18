<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Product */

$this->title = 'Products';
$subtitle = 'Edit Product: ' . $model->product_name;
//$this->params['breadcrumbs'][] = ['label' => 'Products', 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
//$this->params['breadcrumbs'][] = 'Update';
?>

<div class="product-update">

    <p>
        <h1>
            <?= Html::a(Html::encode($this->title), ['index'], ['class' => '']); ?> <small>(<?= $subtitle; ?>)</small>
            <?= Html::a('Create Product', ['create'], ['class' => 'btn btn-success btn-mas pull-right']); ?>
        </h1>
    </p>

    <?= $this->render('_form', [
        'model' => $model,
//        'success' => $success,
        'hcrMap' => $hcrMap,
        'countryMap' => $countryMap,
        'providerMap' => $providerMap,
        'ptMap' => $ptMap,
//        'selectedHolderId' => $selectedHolderId,
//        'selectedProviderId' => $selectedProviderId,
//        'selectedCountryId' => $selectedCountryId,
//        'selectedPTId' => $selectedPTId,
//        'selectedMASCodeAssgn' => $selectedMASCodeAssgn,
//        'selectedMASCodeStatus' => $selectedMASCodeStatus
    ]) ?>

</div>
