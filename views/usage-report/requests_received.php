<?php
    use yii\web\View;
?>
<div class="row">
    <div class="col-md-12">
        <?= $this->render('_requests_form', [
            'product' => $product,
            'model' => $model,
            'location' => $location,
            'ptMap' => $ptMap,
            'providerMap' => $providerMap,
            'lh'=>$lh,
            'usageData' => $usageData
        ]) ?>
    </div>
</div>