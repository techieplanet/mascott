<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\web\View;
use app\views\helpers\Alert;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<?= Yii::$app->session->hasFlash('saved') ? Alert::showSuccess() : ''; ?>

<div class="user-form x-form-padding">

    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'firstname')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'middlename')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'lastname')->textInput(['maxlength' => true]) ?>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'role_id')->dropDownList(
                    $rolesMap, 
                    array('options' => array($model->role_id=>array('selected'=>true)))
                 ) 
            ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>
        </div>
    </div>
    <br>
    <div class="row">        
        <div class="col-md-4 hidden" id="provider-box">
            <?= $form->field($model, 'provider_id')->dropDownList(
                    $providerMap, 
                    array('options' => array($model->provider_id=>array('selected'=>true)))
                 ) 
            ?>
        </div>
        
        <div class="col-md-4 hidden" id="zone-box">
            <?= $form->field($model, 'zone_id')->dropDownList(
                    $zonesMap, 
                    array('options' => array($model->zone_id=>array('selected'=>true)))
                 ) 
            ?>
        </div>
    </div>
    <br>
    <div class="text-right">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', [
            'class' => $model->isNewRecord ? 'btn btn-mas' : 'btn btn-mas',
            ]) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php
        $this->registerJs("
            $('#user-role_id').change(function(){
                if( $('#user-role_id option:selected').text().toUpperCase() == 'MAS PROVIDER' ){
                    $('#provider-box').removeClass('hidden');
                    $('#zone-box').addClass('hidden');
                } else if( $('#user-role_id option:selected').text().toUpperCase() == 'NAFDAC REGIONAL ADMINISTRATOR' ) {
                    $('#provider-box').addClass('hidden');
                    $('#zone-box').removeClass('hidden');
                } else {
                    $('#provider-box').addClass('hidden');
                    $('#zone-box').addClass('hidden');
                    $('#user-provider_id').val(0);
                    $('#user-zone_id').val(0);
                }
            });
            
            if( $('#user-role_id option:selected').text().toUpperCase() == 'MAS PROVIDER' ) {
                $('#provider-box').removeClass('hidden');
            } else if( $('#user-role_id option:selected').text().toUpperCase() == 'NAFDAC REGIONAL ADMINISTRATOR' ) {
                $('#zone-box').removeClass('hidden');
            }
        ",
        View::POS_READY,
        'reports-list-data-table'
    );
?>