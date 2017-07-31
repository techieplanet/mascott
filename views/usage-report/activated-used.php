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
?>

<?php $form = ActiveForm::begin([
        'id' => 'activated-form'
]); ?>
    <div class="row">
        <div class="col-md-12 marginbottom10">
            <div class="row">
                <div class="col-md-1"></div>
                <div class="col-md-10">
                    <div class="col-md-4">
                      <?= $form->field($product, 'product_name')->dropDownList(
                             $productMap
                          )
                     ?>
                    </div>
                    <div class="col-md-4">
                         <?= $form->field($product, 'product_type')->dropDownList(
                                $ptMap
                             )
                        ?>
                    </div>
                    <div class="col-md-4">
                        <?= $form->field($product, 'provider_id')->dropDownList(
                               $providerMap
                            )
                       ?>
                    </div> 
                </div>
                <div class="col-md-1"></div>
            </div>
        </div>
    </div>
        
<div class="row">
    <div class="col-md-3"></div>
        <div class="col-md-3">
            <?= $form->field($model, 'created_date')->widget(DatePicker::classname(), [
                'language' => 'en',
                'dateFormat' => 'yyyy-MM-dd',
                'clientOptions' => ['changeYear' => true, 'changeMonth' => true],
                'options' => ['id'=>'from_date', 'class' => 'form-control', 'placeholder' => 'yyyy-MM-dd']
            ])->label('From') ?>
        </div>    
        <div class="col-md-3">
            <?= $form->field($model, 'created_date')->widget(DatePicker::classname(), [
                'language' => 'en',
                'dateFormat' => 'yyyy-MM-dd',
                'clientOptions' => ['changeYear' => true, 'changeMonth' => true],
                'options' => ['id'=>'to_date', 'class' => 'form-control', 'placeholder' => 'yyyy-MM-dd']
            ])->label('To') ?>
        </div>
    <div class="col-md-3"></div>
</div>

<div class="row">
        
        <div class="col-md-12 margintop15 marginbottom50 text-center">
            <?= Html::button('Filter', ['id'=>'filterButton', 'class' => 'btn btn-mas']); ?>
        </div>
        
    </div>
<?php ActiveForm::end(); ?>

    <div class="row">
<!--    <div class="col-md-12" id="container" style="min-width: 310px; max-width: 800px; height: 400px; margin: 0 auto"></div>-->
        <div class="col-md-1"></div>
            <div class="col-md-10">
                <div class=" panel panel-default text-center">
                    <div class="panel-heading">MAS Usage</div>
                    <div class="panel-body">
                        <div id="container"></div>
                    </div>
                </div>
            </div>
        <div class="col-md-1"></div>
    </div>

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
            usageData = $usageData;
           
            drawChart(usageData); //draw initial chart
            
            $('#filterButton').on('click', function(){
                $('#myModal').modal();
                data = {
                    product_id: $('#product-product_name').val(),
                    product_type: $('#product-product_type').val(),
                    provider_id: $('#product-provider_id').val(),
                    from_date: $('#from_date').val(),
                    to_date: $('#to_date').val()
                };
                

                $.ajax({
                    url: 'activated-used',
                    type: 'POST',
                    data: data,
                    success: function(jsonResponse){
                        drawChart(jsonResponse);
                        $('#myModal').modal('hide')
                    },
                    error: function(jqXHR, textStatus, errorThrown ){
                        console.log('jqXHR: '+JSON.stringify(jqXHR));
                        console.log('textStatus: '+textStatus);
                        console.log('errorThrown: '+errorThrown);
                    }
                });
            });
            
            
            function drawChart(usageData){
                log(usageData);
                
                Highcharts.chart('container', {
                    chart: {
                        type: 'column'
                    },
                    title: {
                        text: 'MAS Usage'
                    },
                    lang: {
                        noData: 'No data to display'
                    },
                    noData: {
                        style: {
                            fontWeight: 'normal',
                            fontSize: '15px',
                            textDecoration: 'underline',
                            color: '#363636'
                        }
                    },
                    subtitle: {
                        //text: 'Source: <a href=\"https://en.wikipedia.org/wiki/World_population\">Wikipedia.org</a>'
                    },
                    xAxis: {
                        categories:  Object.keys(usageData),
                        title: {
                            text: '',
                            align: 'middle',
                            offset: 40,
                            style: {'fontWeight': 'bold',  'color': '#363636'}
                        }
                    },
                    yAxis: {
                        min: 0,
                        title: {
                            text: 'Percentage MAS requests received <br/>on activated products',
                            align: 'middle',
                            offset: 60,
                            style: {'fontWeight': 'bold', 'color': '#363636'}
                        },
                        labels: {
                            overflow: 'justify'
                        },
                        tickAmount: 5
                    },
                    tooltip: {
                        valueSuffix: ' requests',
                        formatter: function (){
                            return this.x + ': ' + '<strong>' + this.y + '%' + '</strong>';
                        }
                    },
                    plotOptions: {
                        bar: {
                            dataLabels: {
                                enabled: true
                            }
                        }
                    },
                    legend: {
                        layout: 'vertical',
                        align: 'right',
                        verticalAlign: 'top',
                        x: -40,
                        y: 80,
                        floating: true,
                        borderWidth: 1,
                        backgroundColor: ((Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'),
                        shadow: true,
                        enabled: false
                    },
                    credits: {
                        enabled: false
                    },
                    series: [{ data: Object.values(usageData)}]
                });
            }
            
            
        ",
        View::POS_READY,
        'activated-form-js'
    );    
    
    $this->registerJs("
        (function() {
                        //set high charts global color scheme for all high charts instances on this page
                        Highcharts.setOptions({
                            colors: ['#2F9E69','#3366CC', '#DC3912', '#FF9900', '#109618', '#990099', '#0099C6', '#DD4477', '#AAAA11', '#B77322']
                        });
                    })();
                  ",
                View::POS_END,
                'highcharts-colors'
            );   
?>
