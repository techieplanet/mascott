<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Login';
//$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row push-down">
    <div class="col-md-1"></div>
    <div class="col-md-10 bgwhite nopadding">
            <div class="loginform-header text-center">
                <div class="logo-icon logo-pull-up">
                    <?= Html::img('@web/images/logo.png', ['alt' => 'Logo']) ?>
                </div>
                <div class="logo-text nofloat" style="padding-bottom: 10px;">
                    NATIONAL AGENCY FOR FOOD AND DRUGS
                    <br>
                    ADMINISTRATION AND CONTROL (NAFDAC)
                    <br>
                    <span class="sub-logo-text">MAS Reporting System</span>
                </div> <!-- green header -->
            </div>
            
        
                <div class="loginform text-center">
                        <?php $form = ActiveForm::begin([
                //            'id' => 'login-form',
                //            //'action' => 'site/login',
                //            //'layout' => 'horizontal',
                //            'fieldConfig' => [
                //                'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
                //                'labelOptions' => ['class' => 'col-lg-1 control-label'],
                //            ],
                        ]); ?>


                            <?= $form->field($model, 'email')->textInput([
                                'autofocus' => true, 
                                'placeholder' => $model->getAttributeLabel('email')
                             ])->label(false) 
                            ?>

                            <?= $form->field($model, 'password')->passwordInput([
                                    'placeholder' => $model->getAttributeLabel('password')
                                ])->label(false)  
                            ?>

                            <?php //$form->field($model, 'rememberMe')->checkbox([
                                //'template' => "<div class=\"col-lg-offset-1 col-lg-3\">{input} {label}</div>\n<div class=\"col-lg-8\">{error}</div>",
                            //]) ?>

                            <div class="form-group">
                                <div class="col-lg-12 text-center">
                                    <?= Html::submitButton('Login', ['class' => 'btn btn-primary btn-mas uppercase', 'name' => 'login-button']) ?>
                                </div>
                            </div>

                        <?php ActiveForm::end(); ?>
                </div>
    </div>
    <div class="col-md-1"></div>
</div>