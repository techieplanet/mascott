<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Product */

$this->title = 'Products';
$subtitle = 'Create New Product';
//$this->params['breadcrumbs'][] = ['label' => 'Products', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-create">

      <p>
        <h1>
            <?= Html::a(Html::encode($this->title), ['index'], ['class' => '']); ?> <small>(<?= $subtitle; ?>)</small>
            
            <?= 
                $success == true ?
                Html::a('Create Product', ['create'], ['class' => 'btn btn-success pull-right']) :
                ''
            ?>
        </h1>
    </p>

    <?= $this->render('_form', [
        'model' => $model,
        'success' => $success,
        'hcrMap' => $hcrMap,
        'countryMap' => $countryMap,
        'providerMap' => $providerMap,
        'ptMap' => $ptMap,
        'selectedHolderId' => $selectedHolderId,
        'selectedProviderId' => $selectedProviderId,
        'selectedCountryId' => $selectedCountryId,
        'selectedPTId' => $selectedPTId,
        'selectedMASCodeAssgn' => $selectedMASCodeAssgn,
        'selectedMASCodeStatus' => $selectedMASCodeStatus
    ]) ?>

</div>
