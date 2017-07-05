<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\views\helpers\Alert;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<?= $success == true ? Alert::showSuccess() : ''; ?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'firstname')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'middlename')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'lastname')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'designation')->dropDownList(
            ['000'=>'-- Select --', 'Dr'=>'Dr', 'Mr'=>'Mr', 'Mrs'=>'Mrs'], 
            array('options' => array($selectedDesignation=>array('selected'=>true)))
         ) 
    ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'role_id')->dropDownList(
            $rolesMap, 
            array('options' => array($selectedRoleId=>array('selected'=>true)))
         ) 
    ?>
    

    <div class="form-group text-right">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
