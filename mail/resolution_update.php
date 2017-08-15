<?php
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this \yii\web\View view component instance */
/* @var $message \yii\mail\BaseMessage instance of newly created mail message */
/* @var $ */

?>

<p>
    Dear <?= $firstname . ' ' . $lastname ?>,<br/>
    A new resolution update has been created on the MAS platform. <br/><br/>
    
    <span style="text-decoration: underline">Details:</span><br/>
    Product Name: <?= $report->batch->product->product_name ?><br/>
    Product Type: <?= $report->batch->product->productType->title ?><br/>
    Batch Number: <?= $report->batch->batch_number ?><br/>
    Phone Number: <?= $report->phone ?><br/>
    Location: <?= $report->location->location_name ?><br/>
    Complaint: <?= $report->getResponseAsText() ?><br/>
    Resolution: <?= $report->complaint->getResultAsText() ?>
    <br/><br/>
    
    Please visit <?= Html::a('Request Page', $url ) ?> for further details and action.<br/><br/>
    
    If the link above does not work, please copy the following link into your browser's address bar and hit Enter.<br/>
    
    <?= $url; ?>
    
</p>