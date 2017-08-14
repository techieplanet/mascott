<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Complaint */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="complaint-form">
    
    <div class="row marginbottom20">
        <div class="col-md-12"><strong>Phone: </strong> <span id="report-phone" class="paddingleft10"></span></div>
        <div class="col-md-12"><strong>Location: </strong> <span id="report-location" class="paddingleft10"></span></div>
        <div class="col-md-12"><strong>Response: </strong> <span id="report-response" class="paddingleft10"></span></div>
    </div>
    
    <?php $form = ActiveForm::begin([
            'action' => '/mas/web/complaint/handle'
    ]); ?>
    
    <?= $form->field($model, 'validation_result')->dropDownList(
            array_merge(array('--Select Status--'), $model->getComplaintStatuses()), 
            array('options' => array($model->validation_result => array('selected'=>true)))
         )->label('Verification Status')
    ?>
    <span class="error-text hidden" id="vr-error">You have to select a result.</span>

    <?= $form->field($model, 'report_id')->hiddenInput(['maxlength' => true])->label('') ?>
    
    <div class="text-right">
        <span id="ask"><?= Html::button('Submit', ['class' => 'btn btn-mas']) ?></span>
        <span class="hidden" id="action-options">
            <span class="marginright10">Are you sure? &nbsp;</span>
            <?= Html::button('No', ['id'=>'cancel','class' => 'btn btn-default marginright15']) ?>
            <?= Html::submitButton('Yes', ['class' => 'btn btn-mas']) ?>
        </span>
    </div>

    <?php ActiveForm::end(); ?>

</div>
