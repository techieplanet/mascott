<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\web\View;
use app\views\helpers\ActionButton;
use app\models\Location;
use app\models\UsageReport;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $report app\models\UsageReport */

$this->title = 'Usage Reports';
//$this->params['breadcrumbs'][] = $this->title;
?>
<section class="content-header">
    <h1><?= $this->title; ?></h1>
</section>

<div class="row">
    <div class="col-md-12">
        <p class="text-right">
            <?= Html::a('Create New Report', ['create'], ['class' => 'btn btn-mas']) ?>
            <?= Html::a('<i class="fa fa-upload" aria-hidden="true"></i>  Upload Excel Data File', 
                    ['import-usage-data'], 
                    ['class' => 'btn btn-mas marginleft10']) ?>
        </p>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <table id="reportsList" class="table table-striped table-bordered dataTable" role="grid" style="width: 100%;">
            <thead>
                <tr>
                    <th class="sorting">SN</th>
                    <th class="sorting">Batch Number</th>
                    <th class="text-center">Phone Number</th>
                    <th class="text-center">Location</th>
                    <th class="text-center">Response</th>
                    <th class="text-center">Date Reported</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th class="sorting">SN</th>
                    <th class="sorting">Batch Number</th>
                    <th class="text-center">Phone Number</th>
                    <th class="text-center">Location</th>
                    <th class="text-center">Response</th>
                    <th class="text-center">Date Reported</th>
                    <th>Actions</th>
                </tr>
            </tfoot>
            
                <tbody>
        <?php
            //echo is_array($roles) ? 'array' : 'scalar'; exit;
            $count=0;
            foreach($reports as $report){
        ?>
                    <tr>
                        <td><?php echo ++$count; ?></td>
                        <td><?php echo $report->batch_number; ?></td>
                        <td class="text-center"><?php echo $report->phone; ?></td>
                        <td class="text-center"><?php echo Location::findOne($report->location_id)->location_name; ?></td>
                        <td class="text-center"><?php echo $report->getResponseAsText($report->response) ?></td>
                        <td class="text-center"><?php echo $report->date_reported; ?></td>                        
                        <td>
                            <span>
                                <?php echo ActionButton::updateButton('usage-report', $report->id); ?>
                            </span>
                            <span class="marginleft10">
                                <?php echo ActionButton::deleteButton('usage-report', $report->id); ?>
                            </span>
                        </td>
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
        "$('#reportsList').DataTable();",
        View::POS_READY,
        'reports-list-data-table'
    );
?>

<?php
    $this->registerJs(
            "$('#usage-menu').addClass('active');"
        ,View::POS_LOAD,
        'reports-menu'
    );
?>