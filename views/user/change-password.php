<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\ActiveForm;
use app\views\helpers\Alert;

/* @var $this yii\web\View */
/* @var $model app\models\User */

$this->title = 'Change Password';
$subtitle = $model->firstname . ' ' . $model->lastname;
?>
<div class="user-update">
    <p>
        <?= Html::a('<span class="glyphicon glyphicon-chevron-left"></span>Back', 
                Url::toRoute(['user/profile', 'id' => Yii::$app->user->id]), 
                ['class'=>'btn btn-mas pull-right margintop5']) ?>
        <h1>
            <?= Html::a(Html::encode($this->title), ['index'], ['class' => '']); ?> <small>(<?= $subtitle; ?>)</small>
        </h1>
    </p>
    
    <?= Yii::$app->session->hasFlash('changed_error') ? 
        Alert::showError('Password change error. Ensure you have filled the form correctly') : ''; ?>

    <div class="user-form x-form-padding">

        <?php 
                $form = ActiveForm::begin(['id'=>'cpf']);
                $form->validateOnType = true;
        ?>
        <div class="row">
            <div class="col-md-4">
                <?= $form->field($model, 'tempPass')->passwordInput(['maxlength' => true, 'value'=>''])->label('Current Password') ?>
            </div>
            <div class="col-md-4">
                <?= $form->field($model, 'new_password')->passwordInput(['maxlength' => true, 'value'=>'']) ?>
            </div>
            <div class="col-md-4">
                <?= $form->field($model, 'new_password_repeat')
                                ->passwordInput(['maxlength' => true, 'value'=>''])
                                ->label('Confirm Password') 
                ?>
            </div>
        </div>
        <br>
        <!--<div class="text-right">-->
        <div class="row">
            <div class="col-md-8" style="font-size: 20px; color: #2F9E69; text-decoration: underline;">
                 <?php if(Yii::$app->session['default-password'] === true) { ?>
                        <strong><em>Please change your password before you can proceed on the platform</em></strong>
                <?php } ?>
                </div>
                 <div class="col-md-4 pull-right text-right">
                    <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Submit', [
                        'class' => $model->isNewRecord ? 'btn btn-mas' : 'btn btn-mas',
                        ]) ?>
                </div>
        </div>
        <?php ActiveForm::end(); ?>

    </div>

</div>

<?php
//    $this->registerJs(
//            "$('#profile-menu, #profile_change_password-menu').addClass('active');"
//        ,View::POS_LOAD,
//        'profile-change-password-menu'
//    );
    
    $this->registerJs(
            "
             $('#user-new_password, #user-new_password_repeat').on('keyup', function(){
                newPass = $('#user-new_password').val();
                passRepeat = $('#user-new_password_repeat').val();
                console.log(newPass, passRepeat);
                if(newPass != passRepeat){
                    $('#user-new_password ~ .help-block')
                            .html('Must be same as confirm password')
                            .closest('div.form-group').addClass('has-error');  
                } else {
                    $('#user-new_password ~ .help-block')
                            .html('')
                            .closest('div.form-group')
                            .removeClass('has-error')
                            .addClass('has-success');  
                }
            });
            ",View::POS_READY,
        'profile-change-password-menu'
    );
    
?>