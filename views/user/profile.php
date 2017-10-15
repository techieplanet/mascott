<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;

/* @var $this yii\web\View */
/* @var $model app\models\User */

$this->title = 'Profile';
$subtitle = 'Edit Profile: ' . $model->firstname . ' ' . $model->lastname;
?>
<div class="user-update">

    <p>
        <h1>
            <?= Html::a(Html::encode($this->title), ['index'], ['class' => '']); ?> <small>(<?= $subtitle; ?>)</small>
            <?= Html::a(
                '<i class="fa fa-unlock-alt "></i> Change Password',
                Url::toRoute(['user/change-password', 'id' => Yii::$app->user->id]), 
                ['title' => '', 'style'=> '', 
                    'class' => 'bold simple-anchor pull-right']); ?>
        </h1>
    </p>

    <?= $this->render('_profile_form', [
        'model' => $model
    ]) ?>

</div>

<?php
    $this->registerJs(
            "$('#profile-menu, #profile_change-menu').addClass('active');"
        ,View::POS_LOAD,
        'profile-change-menu'
    );
?>