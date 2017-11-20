
<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\web\View;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

use app\views\helpers\ActionButton;
use app\views\helpers\Alert;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */


$this->title = 'Holder of Certificate of Registration (HCR)';
//$this->params['breadcrumbs'][] = $this->title;

?>

<section class="content-header">
    <h1><?= $this->title; ?></h1>
</section>

<div class="row">
    <div class="col-md-12">
        
<!-- Button trigger modal -->
        <p class="text-right">
            <button class="btn btn-mas" data-toggle="modal" data-target="#createHcrModal">Add New HCR</button>
        </p>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <?= Yii::$app->session->hasFlash('saved') ? Alert::showSuccess() : '' ?>
        <?= Yii::$app->session->hasFlash('error') ? Alert::showError(implode('<br/>',$model->getErrors('validation_result'))) : ''; ?>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <table id="hcr" class="table table-striped table-bordered dataTable" hcr="grid" style="width: 100%;">
            <thead>
                <tr>
                    <th class="sorting">SN</th>
                    <th class="sorting">Name</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th class="sorting">SN</th>
                    <th class="sorting">Name</th>
                    <th>Actions</th>
                </tr>
            </tfoot>
            <tbody>
                <?php
                    $count=0;
                    foreach($hcr as $h){
                ?>
                        <tr>
                            <td><?php echo ++$count; ?></td>
                            <td><?php echo $h->name; ?></td>
                            <td>
                                <span>
                                    <a title="Edit" href="#" data-toggle="modal" 
                                       data-target="#updateHcrModal"
                                       onclick="
                                           $('#edit-hcr-name').val('<?= $h->name; ?>'); 
                                           $('#edit-hcr-id').val(<?= $h->id; ?>);
                                           $('#hcr-name-label').html('<?= $h->name; ?>');"
                                    >
                                        <i class="glyphicon glyphicon-pencil"></i>
                                    </a>
                                    <?php //echo ActionButton::updateButton('hcr', $h->id); ?>
                                </span>
                                <span class="marginleft10">
                                    <?php echo ActionButton::deleteButton('hcr', $h->id); ?>
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

<!--Start Create HCR Modal Form -->
<?php $form = ActiveForm::begin([
                'id' => 'add-hcr-form',
                'action' => Url::to(['hcr/create']),
                'options' => [
                    'role' => 'form',
                    //'class' => 'form-horizontal'
                ],
        ]) 
?>
<!-- Modal -->
<div class="modal fade" id="createHcrModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
            &times;
            </button>
            <h4 class="modal-title" id="myModalLabel">Add New HCR</h4>
        </div>
        <div class="modal-body">
            <?= $form->field($hcrObj, 'name')->textInput(['placeholder'=>'Enter Name']) ?>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <?= Html::submitButton('Submit', ['class' => 'btn btn-mas']) ?>
        </div>
    </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<?php ActiveForm::end() ?>
<!-- End Create HCR Modal Form -->

<!--Start Update HCR Modal Form -->
<?php $form2 = ActiveForm::begin([
                'id' => 'update-hcr-form',
                'action' => Url::to(['hcr/update']),
                'options' => [
                    'role' => 'form',
                ],
        ]) 
?>

<!-- Modal -->
<div class="modal fade" id="updateHcrModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title" id="myModalLabel">
                Edit HCR
                <small>(<span id="hcr-name-label"></span>)</small>
            </h4>
        </div>
        <div class="modal-body">
            <?= $form2->field($h, 'name')->textInput(['placeholder'=>'Enter Name', 'id' => 'edit-hcr-name']) ?>
            <?= $form2->field($h, 'id')->hiddenInput(['id' => 'edit-hcr-id'])->label(false) ?>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <?= Html::submitButton('Update', ['class' => 'btn btn-mas', 'id'=>"update-button"]) ?>
        </div>
    </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<?php ActiveForm::end() ?>
<!-- End Update HCR Modal Form -->
                    
                    
                    
<?php
    $this->registerJs(
        "$('#hcr').DataTable();",
        View::POS_READY,
        'hcr-data-table'
    );
?>


<?php
    $this->registerJs(
            "$('#reg-menu, #reg_hcr-menu').addClass('active');"
        ,View::POS_LOAD,
        'hcr-menu'
    );
?>