<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\views\helpers\Alert;

/* @var $this yii\web\View */
/* @var $model app\models\Provider */
/* @var $form yii\widgets\ActiveForm */
?>

<?= Yii::$app->session->hasFlash('saved') ? Alert::showSuccess() : ''; ?>

<div class="provider-form x-form-padding">

    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-md-8 paddingleft0">
    <?= $form->field($model, 'provider_name')->textInput(['maxlength' => true]) ?>
        </div>
    </div>
    <br>
    <div class="row">
        <fieldset>
            <legend>Address</legend>
            <div class="col-md-4 paddingleft0">
                <?= $form->field($model, 'street')->textInput(['maxlength' => false]) ?>
            </div>
            <div class="col-md-4">
                <?= $form->field($model, 'city')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-md-4">
                <?= $form->field($model, 'state')->textInput(['maxlength' => true]) ?>
            </div>
        </fieldset>
    </div>
    <br>
    <div class="row">
        <fieldset>
            <legend>Contact</legend>
            <div class="col-md-4 paddingleft0">
                <?= $form->field($model, 'contact_person')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-md-4">
                <?= $form->field($model, 'contact_phone')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-md-4">
                <?= $form->field($model, 'contact_email')->textInput(['maxlength' => true, 'email' => true]) ?>
            </div>
        </fieldset>
    </div>
    <br>
    <div class="text-right">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-mas' : 'btn btn-mas']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
