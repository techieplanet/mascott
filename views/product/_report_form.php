<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\DatePicker;
use yii\web\View;
use yii\bootstrap\Modal;

use app\views\helpers\Alert;

/* @var $this yii\web\View */
/* @var $model app\models\Product */
/* @var $form yii\widgets\ActiveForm */
$homeUrl = Yii::$app->homeUrl;
?>

<?php $form = ActiveForm::begin([
        'id' => 'product-report-form',
        'options'=> ['class' => 'x-form-padding']
]); ?>
    <div class="row marginbottom10">
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
    </div>
    <div class="row marginbottom10">
            <div class="col-md-1"></div>
            <div class="`col-md-10">
                <div class="row">
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
                </div>
            </div>
            <div class="col-md-1"></div>
        </div>
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-8">
                <div class="row">
                    <div class="col-md-5">
                        <?= $form->field($model, 'created_date')->widget(DatePicker::classname(), [
                            'language' => 'en',
                            'dateFormat' => 'yyyy-MM-dd',
                            'clientOptions' => ['changeYear' => true, 'changeMonth' => true],
                            'options' => ['id'=>'from_date', 'class' => 'form-control', 'placeholder' => 'yyyy-MM-dd']
                        ])->label('From') ?>
                    </div>
                    <div class="col-md-5">
                        <?= $form->field($model, 'created_date')->widget(DatePicker::classname(), [
                            'language' => 'en',
                            'dateFormat' => 'yyyy-MM-dd',
                            'clientOptions' => ['changeYear' => true, 'changeMonth' => true],
                            'options' => ['id'=>'to_date', 'class' => 'form-control','placeholder' => 'yyyy-MM-dd']
                        ])->label('To') ?>
                    </div>
                </div>
            </div>
            <div class="col-md-2"></div>
        </div>
        <div class="row">
            <div class="col-md-12 margintop25 marginbottom50 text-center">
                <?= Html::button('Filter', ['id'=>'filterButton', 'class' => 'btn btn-mas']); ?>
            </div>
        
    </div>
<?php ActiveForm::end(); ?>

<?php
    Modal::begin([
        //'header' => '<h2>Hello world</h2>',
        //'toggleButton' => ['label' => 'click me'],
        'clientOptions' => ['backdrop' => 'static'],
        'options' => ['id'=>'myModal', 'class' => 'loading-modal text-center'],
        'size' => 'SIZE_SMALL'
    ]);

    echo '<div class="row">' . 
            '<div class="col-md-offset-4 col-md-4 gif-wrapper">' .
                Html::img('@web/images/loading.gif', ['alt' => 'Loading Image', 'width' => '32', 'height' => '32']) .
                '<br/>' .
                '<div class="bold">Loading...</div>' .
            '</div>' .
         '</div>';

    Modal::end();
?>
<?php
    $this->registerJs("
              
            $('#filterButton').on('click', function(){
                $('#myModal').modal();
                $.ajax({
                    url: 'report',
                    type: 'POST',
                    data: $('#product-report-form').serialize(),
                    success: function(jsonResponse){
                        console.log('jsonResponse: '+jsonResponse);
                        updateTable(jsonResponse);
                        $('#myModal').modal('hide')
                    },
                    error: function(jqXHR, textStatus, errorThrown ){
                        console.log('jqXHR: '+JSON.stringify(jqXHR));
                        console.log('textStatus: '+textStatus);
                        console.log('errorThrown: '+errorThrown);
                    }
                });
            });
        
            function updateTable(jsonResponse){
                var products = JSON.parse(jsonResponse);
                var table = $('#productsList').DataTable();
                table.clear().draw();

                var count = 0;
                $.each(products, function(index,element){
                   table.row.add([
                            ++count,
                            element.product_name,
                            element.productType.title,
                            element.certificateHolder.name,
                            element.brand_name,
                            element.generic_name,
                            element.nrn
                       ]);        
                });
                
                table.draw();
            }
        ",
        View::POS_READY,
        'product-report=form'
    );    
?>

