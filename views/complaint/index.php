<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\web\View;
use app\views\helpers\ActionButton;
use app\views\helpers\Alert;

use app\models\Complaint;
use app\models\Location;
use app\models\UsageReport;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $model app\models\Complaint */

$this->title = 'Complaints';
$this->params['breadcrumbs'][] = $this->title;
?>

<section class="content-header marginbottom20">
    <h1><?= $this->title; ?></h1>
</section>

<!--<div class="row">
    <div class="col-md-12">
        <p class="text-right">
            <?= Html::a('Create Report', ['create'], ['class' => 'btn btn-success']) ?>
        </p>
    </div>
</div>-->

<div class="row">
    <div class="col-md-12">
        <?= Yii::$app->session->hasFlash('saved') ? Alert::showSuccess() : '' ?>
        <?= Yii::$app->session->hasFlash('error') ? Alert::showError(implode('<br/>',$model->getErrors('validation_result'))) : ''; ?>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <table id="complaintsList" class="table table-striped table-bordered dataTable" role="grid" style="width: 100%;">
            <thead>
                <tr>
                    <th class="sorting">SN</th>
                    <th class="sorting">Report ID</th>
                    <th class="sorting">Phone Number</th>
                    <th class="sorting">Location</th>
                    <th class="sorting">Response</th>
                    <th class="sorting">Date Reported</th>
                    <th class="sorting">Verification Status</th>
                    <th class="text-center">Date Verified</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th class="sorting">SN</th>
                    <th class="sorting">Report ID</th>
                    <th class="sorting">Phone Number</th>
                    <th class="sorting">Location</th>
                    <th class="sorting">Response</th>
                    <th class="sorting">Date Reported</th>
                    <th class="sorting">Verification Status</th>
                    <th class="text-center">Date Verified</th>
                    <th>Actions</th>
                </tr>
            </tfoot>
            
            <tbody>
        <?php
            //echo is_array($roles) ? 'array' : 'scalar'; exit;
            $count=0;
            foreach($fakeReports as $report){
        ?>
                    <tr>
                        <td><?php echo ++$count; ?></td>
                        <td><?php echo $report->id; ?></td>
                        <td><?php echo $report->phone; ?></td>
                        <td><?php echo implode(' > ', Location::getLocationTraceText($report->location_id)) ?></td>
                        
                        <?php
                            $text = $report->getResponseAsText();
                            $type = '';
                            switch($text){
                                case UsageReport::FAKE: $type = 'danger'; break;
                                case UsageReport::INVALID: $type = 'warning'; break;
                            }            
                        ?>
                        <td class="text-center bold"><?php echo Alert::showButton($text, $type); ?></td>
                        <td><?php echo $report->date_reported; ?></td>                        
                        <?php
                            $text = $report->getComplaintResultAsText();
                            $type = '';
                            switch($text){
                                case Complaint::CONFIRMED: $type = 'danger'; break;
                                case Complaint::UNCONFIRMED: $type = 'success'; break;
                                case Complaint::UNRESOLVED: $type = 'warning'; break;
                                default: $type = 'warning';
                            }            
                        ?>
                        <td class="text-center"><?php echo Alert::showButton($text, $type); ?></td> 
                        <td class="text-center">
                            <?= is_object($report->complaint) ? $report->complaint->created_date : '-'; ?>
                        </td>
                        <td>
                            <span>
                                <?php 
                                    $values = [
                                        'id'=>$report->id,
                                        'phone'=>$report->phone, 
                                        'location'=>  implode(' > ', Location::getLocationTraceText($report->location_id)),
                                        'response'=>$report->getResponseAsText(),
                                        'result' => is_object($report->complaint) ? $report->complaint->validation_result : 0
                                    ];
                                    echo Html::a(
                                        '<i class="glyphicon glyphicon-pencil" aria-hidden="true"></i>',
                                        '#',
                                        [
                                            'class' => '',
                                            'id' => 'edit-complaint-'.$report->id,
                                            'data-toggle' => 'modal',
                                            'data-target' => '#myModal',
                                            'onclick' => 'showResolutionModal(' . json_encode($values) . ')'
                                        ]
                                    ); 
                                ?>
                            </span>
                            <span class="marginleft10">
                                <?php echo is_object($report->complaint) ? 
                                        ActionButton::deleteButton('complaint', $report->complaint->id): ''; ?>
                            </span>
                        </td>
                    </tr>
        <?php
            }
        ?>
                </tbody>
        </table>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Complaint Resolution</h4>
      </div>
      <div class="modal-body">
          <?php require_once '_form.php'; ?>
      </div>
<!--      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-mas">Save changes</button>
      </div>-->
    </div>
  </div>
</div>

<?php
    $this->registerJs("
        function showResolutionModal(report) {
               $('#complaint-report_id').val(report.id);
               $('#report-phone').text(report.phone);
               $('#report-location').text(report.location);
               $('#report-response').text(report.response);
               $('#complaint-validation_result').val(report.result);
        }
    ",
    View::POS_END,
    'button-clicks');
            
    $this->registerJs(
        "
            $('#complaintsList').DataTable();
            
            $('#ask').click(function(){
                if($('#complaint-validation_result').val() == 0){
                    $('#vr-error').removeClass('hidden');
                    return;
                }
                
                $('#vr-error').addClass('hidden');
                $('#ask').addClass('hidden');
                $('#action-options').removeClass('hidden');
            });
            
            $('#cancel').click(function(){
                $('#ask').removeClass('hidden');
                $('#action-options').addClass('hidden');
            });
            
            $('#myModal').on('hidden.bs.modal', function (e) {
                $('#ask').removeClass('hidden');
                $('#action-options').addClass('hidden');
                $('#vr-error').addClass('hidden');
                $('#complaint-validation_result').val(0);
            })
        ",
        View::POS_READY,
        'reports-list-data-table'
    );
?>