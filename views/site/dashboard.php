<?php
//use Yii;
use yii\web\View;
/* @var $this yii\web\View */

$this->title = 'Dashboard';
?>
<div class="site-index">
    <div class="row">
        <div class="col-md-3">
            <div class="row">
                <div class="col-md-8 indicator-text">Total Number of MAS Providers<br/></div>
                <div class="col-md-3 indicator-value indicator-color1 text-center"><?= $providersCount ?></div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="row">
                <div class="col-md-8 indicator-text">Total Number of <br/>Products</div>
                <div class="col-md-3 indicator-value indicator-color2 text-center"><?= $productCount; ?></div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="row">
                <div class="col-md-8 indicator-text" style="padding: inherit 5px;">
                    Total Number of Negative Responses
                </div>
                <div class="col-md-3 indicator-value  indicator-color3 text-center"><?= $confirmedCounterfeitsCount; ?></div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="row">
                <div class="col-md-8 indicator-text">Total Number of Unresolved Requests</div>
                <div class="col-md-3 indicator-value indicator-color4 text-center"><?= $unresolvedComplaintsCount; ?></div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-12" style="height: 30px"></div>
    </div>
    
    <div class="body-content">
        <div class="row marginbottom15">
            <div class="col-md-6">
                <div class=" panel panel-default text-center">
                    <div class="panel-heading">MAS Requests Received by GeoZones</div>
                    <div class="panel-body">
                        <div id="requests1" class="paddingtop20" style="height: 400px; margin: 0 auto"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class=" panel panel-default text-center">
                    <div class="panel-heading">Batches registered per product</div>
                    <div class="panel-body">
                        <div id="requests2" class="paddingtop20" style="height: 400px; margin: 0 auto"></div>
                    </div>
                </div>
            </div>
        </div>
            <div class="row">
            <div class="col-md-6">
                <div class=" panel panel-default text-center">
                    <div class="panel-heading">Confirmed negative responses</div>
                    <div class="panel-body">
                        <div id="counterfeits1" class="paddingtop20" style="height: 400px; margin: 0 auto"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class=" panel panel-default text-center">
                    <div class="panel-heading">Confirmed negative responses per product</div>
                    <div class="panel-body">
                        <div id="counterfeits2" class="paddingtop20" style="height: 400px; margin: 0 auto"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
    $this->registerJs(
            "$('#dashboard-menu').addClass('active');"            
        ,View::POS_LOAD,
        'dashboard-menu'
    );
    
    $this->registerJsFile(
        '@web/js/dashboard-ops.js',
        ['depends' => [\yii\web\JqueryAsset::className()]]
    );
    
    $this->registerJs("
            //chart data variables
            masRequestsByGeo = $MASRequestsByGeo;   
            productBatches = $productBatches;
            confirmedCounterfeits = $confirmedCounterfeits;
            counterfeitsCountByProduct = $counterfeitsCountByProduct;
                
            //chart calls
            drawMASRequestsChart(masRequestsByGeo);
            drawProductBatchesChart(productBatches);
            drawConfirmedCounterfeitsChart(confirmedCounterfeits);
            drawCounterfeitsCountByProductChart(counterfeitsCountByProduct);
            
        ",View::POS_READY,
        'dashboard-menu'
    );
    
    
    $this->registerJs("
        (function() {
                        //set high charts global color scheme for all high charts instances on this page
                        Highcharts.setOptions({
                            colors: ['#8FAD1F', '#2F9E69','#3366CC', '#DC3912', '#FF9900', '#109618', '#990099', '#0099C6', '#DD4477', '#AAAA11', '#B77322']
                        });
                    })();
                  ",
                View::POS_END,
                'highcharts-colors'
            );   
?>