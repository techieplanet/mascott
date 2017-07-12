<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\views\helpers\Alert;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<?= $success == true ? Alert::showSuccess() : ''; ?>

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
            <?= $form->field($model, 'designation')->dropDownList(
                    ['000'=>'-- Select --', 'Dr'=>'Dr', 'Mr'=>'Mr', 'Mrs'=>'Mrs'], 
                    array('options' => array($selectedDesignation=>array('selected'=>true)))
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
        <div class="col-md-4">
            <?= $form->field($model, 'role_id')->dropDownList(
                    $rolesMap, 
                    array('options' => array($selectedRoleId=>array('selected'=>true)))
                 ) 
            ?>
        </div>
    </div>
    <br>
    <div class="form-group text-right">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success btn-mas' : 'btn btn-primary btn-mas']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
