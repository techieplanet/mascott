<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\web\View;
use app\views\helpers\ActionButton;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Providers';
//$this->params['breadcrumbs'][] = $this->title;
?>

<section class="content-header">
    <h1><?= $this->title; ?></h1>
</section>

<div class="row">
    <div class="col-md-12">
        <p class="text-right">
            <?= Html::a('Create Provider', ['create'], ['class' => 'btn btn-success']) ?>
        </p>
    </div>
</div>


<div class="row">
    <div class="col-md-12">
        <table id="providersList" class="table table-striped table-bordered dataTable" role="grid" style="width: 100%;">
            <thead>
                <tr>
                    <th class="sorting">SN</th>
                    <th class="sorting">Provider Name</th>
                    <th class="sorting">Contact Name</th>
                    <th class="sorting">Contact Phone</th>
                    <th class="sorting">Contact Email</th>
                    <th>Actions</th>
                </tr>
            </thead>
                <tbody>
        <?php
            //echo is_array($roles) ? 'array' : 'scalar'; exit;
            $count=0;
            foreach($providers as $provider){
        ?>
                    <tr>
                        <td><?php echo ++$count; ?></td>
                        <td><?php echo $provider->provider_name; ?></td>
                        <td><?php echo $provider->contact_person; ?></td>
                        <td><?php echo $provider->contact_phone; ?></td>
                        <td><?php echo $provider->contact_email; ?></td>
                        <td>
                            <span>
                                <?php echo ActionButton::updateButton('provider', $provider->id); ?>
                            </span>
                            <span class="marginleft10">
                                <?php echo ActionButton::deleteButton('provider', $provider->id); ?>
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
        "$('#providersList').DataTable();",
        View::POS_READY,
        'product-list-data-table'
    );
?>