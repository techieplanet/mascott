<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\web\View;
use app\views\helpers\ActionButton;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Usage Reports';
//$this->params['breadcrumbs'][] = $this->title;
?>
<section class="content-header">
    <h1><?= $this->title; ?></h1>
</section>

<div class="row">
    <div class="col-md-12">
        <p class="text-right">
            <?= Html::a('Create Report', ['create'], ['class' => 'btn btn-success']) ?>
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
                    <th class="sorting">Phone Number</th>
                    <th class="sorting">Location</th>
                    <th class="sorting">Response</th>
                    <th class="sorting">Date Reported</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th class="sorting">SN</th>
                    <th class="sorting">Batch Number</th>
                    <th class="sorting">Phone Number</th>
                    <th class="sorting">Location</th>
                    <th class="sorting">Response</th>
                    <th class="sorting">Date Reported</th>
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
                        <td><?php echo $report->phone; ?></td>
                        <td><?php echo $report->location_id; ?></td>
                        <td><?php echo $report->response; ?></td>
                        <td><?php echo $report->date_reported; ?></td>                        
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