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

<?php
    $this->registerJs("
            $('#reports-menu, #reports_usage-report-menu').addClass('active');
            $('#reports_usage-mas-requests-menu').addClass('active2');
        ", 
        View::POS_LOAD,
        'per-menu'
    );
?>