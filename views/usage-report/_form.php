<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\DatePicker;
use yii\web\View;
use yii\jui\AutoComplete;

use app\views\helpers\Alert;

//use yii\web\JqueryAsset;
//JqueryAsset::register(this);

/* @var $this yii\web\View */
/* @var $model app\models\UsageReport */
/* @var $form yii\widgets\ActiveForm */
?>

<?= Yii::$app->session->hasFlash('saved') ? Alert::showSuccess() : ''; ?>

<div class="usage-report-form x-form-padding">

    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-md-3">
            <?php $selected = !is_null($model->batch) ? $model->batch->product_id : 0; ?>
            <?= $form->field($product, 'product_name')->dropDownList(
                    $productMap,
                    array('options' => array($selected=>array('selected'=>true))) 
              )  ?>
          </div>
        <div class="col-md-3 paddingleft0">
            <?= $form->field($model, 'batch_number')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'response')->dropDownList(
                    [0 => '--Select--', 1 => 'Genuine', 2 => 'False', 3 => 'Invalid' ],
                    array('options' => array($model->response=>array('selected'=>true))) 
                )
            ?>
        </div>
    </div>
    <br>
   
    <!--
    NB: the geozone combo is populated here because the php variable 
    will not be accessible in an external JS file.
    Other associative functions for states and lgas are in the location-ops.js file
    -->
    <div class="row">
        <fieldset>
            <legend>Address</legend>
                <div class="col-md-4 paddingleft0">
                    <?= Html::label( 'Geozone', $for = null, $options = [] ) ?>
                    <?= Html::dropDownList ( 'UsageReport[geozone_id]', 
                                                $selection = null,
                                                $items = ['--Select Zone--'], 
                                                $options = ['id'=>'geozone_id', 'class' => 'form-control']
                            ) 
                    ?>           
                </div>
                 <div class="col-md-4">    
                    <?= Html::label( 'State', $for = null, $options = [] ) ?>
                    <?= Html::dropDownList ( 'UsageReport[state_id]', 
                                                $selection = null,
                                                $items = ['--Select State--'], 
                                                $options = ['id'=>'state_id', 'class' => 'form-control']
                            ) 
                    ?>
                 </div>
                 <div class="col-md-4">    
                    <?= Html::label( 'LGA', $for = null, $options = [] ) ?>
                    <?= Html::dropDownList ( 'UsageReport[lga_id]', 
                                                $selection = null,
                                                $items = ['--Select LGA--'], 
                                                $options = ['id'=>'lga_id', 'class' => 'form-control']
                            ) 
                    ?>
                 </div>
        </fieldset>
    </div>
        
    <?php //$form->field($model, 'location_id')->hiddenInput()->label(false) ?>
    <br><br>
    <div class="row">
        <br>
        <fieldset>
            <legend></legend>
                <div class="col-md-4 paddingleft0">
                    <?= $form->field($model, 'pin_4_digits')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-md-4">
                    <?= $form->field($model, 'date_reported')->widget(DatePicker::classname(), [
                       'language' => 'en',
                       'dateFormat' => 'yyyy-MM-dd',
                   ])->textInput(['placeholder' => 'yyyy-MM-dd']) ?>
                </div>
            </div>
            <div class="text-right">
                <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-mas' : 'btn btn-mas']) ?>
            </div>
    </fieldset>

    <?php ActiveForm::end(); ?>

</div>

<?php
    $this->registerJsFile(
        '@web/js/location-ops.js',
        ['depends' => [\yii\web\JqueryAsset::className()]]
    );
    
    $this->registerJs(
        "
         $(document).ready(function(){
            lh = $lh;
            parentsJson = $parentsJson;
                
            for(key in lh){
                gzObject = lh[key];
                $('#geozone_id').append(new Option(gzObject.location_name, key));
            }
            
            dropDownListSorter('geozone_id');
            
            if(parentsJson != '0') {
                setdropdownListSelectedOption('geozone_id', parentsJson[0]);
                setdropdownListSelectedOption('state_id', parentsJson[1]);
                setdropdownListSelectedOption('lga_id', parentsJson[2]);
            }
            
            //NB: the geozone combo is populated here because the php variable 
            //will not be accessible in an external JS file.
            //Other associative functions for states and lgas are in the location-ops.js file
            
        });",
        View::POS_READY,
        'my-button-handler'
    );
?>