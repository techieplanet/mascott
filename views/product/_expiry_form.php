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
//Product name, product type, dosage form batch number

?>

<?php $form = ActiveForm::begin([
        'id' => 'exp-report-form',
        'options'=> ['class' => 'x-form-padding']
]); ?>
    <div class="row">   
        <div class="col-md-4">
            <?= $form->field($model, 'batch_number')->textInput(); ?>
        </div>
        
        <div class="col-md-4">
            <?= $form->field($model, 'product_id')->dropDownList(
                   $productMap,
                   array('options' => array(0=>array('selected'=>true)))
                )
           ?>
        </div>
        
        <div class="col-md-4">
            <?= $form->field($product, 'product_type')->dropDownList(
                    $ptMap,
                    array('options' => array(0=>array('selected'=>true)))
                 )
            ?>
        </div>
    </div>
<hr>
    <div class="row">
        <div class="col-md-12 margintop10 marginbottom20 text-center">
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
            '<div class="col-md-offset-4 col-md-4 gif-wrapper bg-sidebar">' .
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
                    url: 'expiring',
                    type: 'POST',
                    data: $('#exp-report-form').serialize(),
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
                var batches = JSON.parse(jsonResponse);
                var table = $('#expList').DataTable();
                table.clear().draw();

                var count = 0;
                $.each(batches, function(index,element){
                   table.row.add([
                            ++count,
                            element.product.product_name,
                            element.batch_number,
                            element.product.productType.title,
                            element.product.certificateHolder.name,
                            element.product.nrn,
                            element.manufacturing_date,
                            element.expiry_date
                       ]);        
                });
                
                table.draw();
            }
        ",
        View::POS_READY,
        'product-report=form'
    );    
?>

