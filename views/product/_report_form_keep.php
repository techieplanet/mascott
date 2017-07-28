<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\DatePicker;
use yii\web\View;
use app\views\helpers\Alert;

/* @var $this yii\web\View */
/* @var $model app\models\Product */
/* @var $form yii\widgets\ActiveForm */
$homeUrl = Yii::$app->homeUrl;
?>

<?php $form = ActiveForm::begin([
        'id' => 'product-report-form'
]); ?>
    <div class="row">
       <div class="col-md-4">
            <?= $form->field($model, 'provider_id')->dropDownList(
                   $providerMap, 
                   array('options' => array($model->provider_id=>array('selected'=>true)))
                )
           ?>
        </div>
        
        <div class="col-md-4">
            <?= $form->field($model, 'product_name')->dropDownList(
                   $productMap, 
                   array('options' => array($model->id=>array('selected'=>true)))
                )
           ?>
        </div>
        
        <div class="col-md-4">
            <?= $form->field($model, 'product_type')->dropDownList(
                    $ptMap, 
                    array('options' => array($model->product_type=>array('selected'=>true)))
                 ) 
            ?>
        </div>
        
        <div class="col-md-4">
            <?= $form->field($model, 'production_country')->dropDownList(
                   $countryMap, 
                   array('options' => array($model->production_country=>array('selected'=>true)))
                ) 
           ?>
        </div>
        
        
        <div class="col-md-4">
            <?= $form->field($model, 'mas_code_status')->dropDownList(
                    ['0'=>'-- Select --', '1'=>'Not Activated', '2'=>'Activated'],
                    array('options' => array($model->mas_code_status=>array('selected'=>true)))
                 ) 
            ?>
        </div>       
        
        
        <div class="col-md-4">
            <div style="margin-top: 5px;" id='jqxZoneBox'></div>
            <div style="margin-top: 5px;" id='jqxStateBox'></div>
            <div style="margin-top: 5px;" id='jqxLGABox'></div>
        </div>
        
        <div class="col-md-4">
            <?= $form->field($model, 'created_date')->widget(DatePicker::classname(), [
                'language' => 'en',
                'dateFormat' => 'yyyy-MM-dd',
                'clientOptions' => ['changeYear' => true, 'changeMonth' => true],
                'options' => ['id'=>'from_date']
            ])->label('From') ?>
        </div>
    
        <div class="col-md-4">
            <?= $form->field($model, 'created_date')->widget(DatePicker::classname(), [
                'language' => 'en',
                'dateFormat' => 'yyyy-MM-dd',
                'clientOptions' => ['changeYear' => true, 'changeMonth' => true],
                'options' => ['id'=>'to_date']
            ])->label('To') ?>
        </div>
        
        <div class="col-md-12 marginbottom20 text-center">
            <?= Html::button('Filter', ['id'=>'filterButton',]); ?>
        </div>
        
    </div>
<?php ActiveForm::end(); ?>

<?php

//$this->registerJsFile('@web/plugins/jqwidgets/scripts/demos.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('@web/plugins/jqwidgets/jqwidgets/jqxcore.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('@web/plugins/jqwidgets/jqwidgets/jqxbuttons.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('@web/plugins/jqwidgets/jqwidgets/jqxscrollbar.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('@web/plugins/jqwidgets/jqwidgets/jqxlistbox.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('@web/plugins/jqwidgets/jqwidgets/jqxcombobox.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('@web/plugins/jqwidgets/jqwidgets/jqxpanel.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('@web/plugins/jqwidgets/jqwidgets/jqxcheckbox.js', ['depends' => [\yii\web\JqueryAsset::className()]]);

    $this->registerJsFile(
        '@web/js/location-ops.js',
        ['depends' => [\yii\web\JqueryAsset::className()]]
    );
    
    $this->registerJs("
            //console.log('inside the setion');
            lh = $lh;
            homeUrl = '$homeUrl'; console.log('homeUrl: ' + homeUrl);
                
            var zones = new Array();
            var states = new Array();
            var LGAs = new Array();

            //console.log(JSON.stringify(lh));
            for(key in lh){
                gzObject = lh[key];
                zones.push({value: gzObject.id, label: gzObject.location_name});
            }

            zones = jqxArraySorter(zones);

            // Create a jqxComboBox
            $('#jqxZoneBox').jqxComboBox({source: zones, multiSelect: true, width: 200, height: 25});
            $('#jqxStateBox').jqxComboBox({source: states, multiSelect: true, width: 200, height: 25});
            $('#jqxLGABox').jqxComboBox({source: LGAs, multiSelect: true, width: 200, height: 25});
        ",
        View::POS_READY,
        'product-report=form'
    );    
?>

