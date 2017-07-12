<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\DatePicker;
use app\views\helpers\Alert;

/* @var $this yii\web\View */
/* @var $model app\models\Product */
/* @var $form yii\widgets\ActiveForm */
?>

<?= $success == true ? Alert::showSuccess() : ''; ?>

<div class="product-form x-form-padding">

    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
       <div class="col-md-4">
            <?= $form->field($model, 'provider_id')->dropDownList(
                   $providerMap, 
                   array('options' => array($selectedProviderId=>array('selected'=>true)))
                )
           ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'nrn')->textInput(['maxlength' => true]) ?>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'mas_code_assigned')->dropDownList(
                    ['0'=>'-- Select --', '1'=>'No', '2'=>'Yes'], 
                    array('options' => array($selectedMASCodeAssgn=>array('selected'=>true)))
                 ) 
            ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'mas_code_status')->dropDownList(
                    ['0'=>'-- Select --', '1'=>'Not Activated', '2'=>'Activated'],
                    array('options' => array($selectedMASCodeStatus=>array('selected'=>true)))
                 ) 
            ?>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'product_name')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'product_type')->dropDownList(
                    $ptMap, 
                    array('options' => array($selectedPTId=>array('selected'=>true)))
                 ) 
            ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'dosage_form')->textInput(['maxlength' => true]) ?>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'certificate_holder')->dropDownList(
                    $hcrMap, 
                    array('options' => array($selectedHolderId=>array('selected'=>true)))
                 ) 
            ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'production_country')->dropDownList(
                   $countryMap, 
                   array('options' => array($selectedCountryId=>array('selected'=>true)))
                ) 
           ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'brand_name')->textInput(['maxlength' => true]) ?>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'generic_name')->textInput(['maxlength' => true]) ?>
        </div>
    </div>
    <hr>
    <div class="row">       
        <div class="col-md-4">
            <?= $form->field($model, 'batch_number')->textInput(['maxlength' => true]) ?>
        </div>        
        <div class="col-md-3">
            <?= $form->field($model, 'manufacturing_date')->widget(DatePicker::classname(), [
                'language' => 'en',
                'dateFormat' => 'yyyy-MM-dd',
            ])->textInput(['placeholder' => 'yyyy-MM-dd']) ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'expiry_date')->widget(DatePicker::classname(), [
                'language' => 'en',
                'dateFormat' => 'yyyy-MM-dd',
            ])->textInput(['placeholder' => 'yyyy-MM-dd']) ?>
        </div>        
    </div>
<br>    
    <div class="form-group text-right">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success btn-mas' : 'btn btn-primary btn-mas']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
