<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\web\View;
use yii\widgets\ActiveForm;

use app\views\helpers\ActionButton;
use app\models\ProductType;
use app\models\Product;
use app\models\HCR;

$this->title = 'Product Expiry Status';
//$this->params['breadcrumbs'][] = $this->title;
?>

<section class="content-header">
    <h1><?= $this->title; ?></h1>
</section>

<div class="row">
    <div class="col-md-12">
        <?= $this->render('_expiry_form', [
            'batches' => $batches,
            'model' => $model,
            'product' => $product,
            'productType' => new ProductType(),
            'productMap' => $productMap,
            'ptMap' => $ptMap
        ]) ?>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <table id="expList" class="table table-striped table-bordered dataTable" role="grid" style="width: 100%;">
            <thead>
                <tr>
                    <th class="sorting">SN</th>
                    <th class="sorting">Product Name</th>
                    <th class="sorting">Batch Number</th>
                    <th class="sorting">Product Type</th>
                    <th class="sorting">Certificate Holder</th>
                    <th class="sorting">NAFDAC Reg. Number</th>                    
                    <th class="sorting">Manufacturing Date</th>
                    <th class="sorting">Expiry Date</th>
                </tr>
            </thead>
            
            <tfoot>
                <tr>
                    <th class="sorting">SN</th>
                    <th class="sorting">Product Name</th>
                    <th class="sorting">Batch Number</th>
                    <th class="sorting">Product Type</th>
                    <th class="sorting">Certificate Holder</th>
                    <th class="sorting">NAFDAC Reg. Number</th>                    
                    <th class="sorting">Manufacturing Date</th>
                    <th class="sorting">Expiry Date</th>
                </tr>
            </tfoot>
            
                <tbody>
        <?php
            //echo is_array($roles) ? 'array' : 'scalar'; exit;
            $count=0;
            foreach($batches as $batch){
        ?>
                    <tr>
                        <td><?php echo ++$count; ?></td>
                        <td><?php echo $batch->product->product_name; ?></td>
                        <td><?php echo $batch->batch_number; ?></td>
                        <td><?php echo $batch->product->productType->title; ?></td>
                        <td><?php echo $batch->product->certificateHolder->name; ?></td>
                        <td><?php echo $batch->product->nrn ?></td>
                        <td><?php echo $batch->manufacturing_date; ?></td>
                        <td><?php echo $batch->expiry_date; ?></td>
                    </tr>
        <?php
            }
        ?>
                </tbody>
        </table>
    </div>
</div>

<?php
    $this->registerJs(
        "$('#expList').DataTable();",
        View::POS_READY,
        'exp-list-data-table'
    );
?>

<?php
    $this->registerJs("
            $('#reports-menu, #reports_product-report-menu').addClass('active');
            $('#reports_product-expiry-menu').addClass('active2');
        ", 
        View::POS_LOAD,
        'per-menu'
    );
?>