
$(document).ready(function(){
    $('#clear-form').click(function(){
        clearForm();
    });
    
    $('#add-batch').click(function(){
        var url = ($('#add-batch').text() == 'Add') ? 'create-batch' : 'update-batch';
        
        $('#loading-div').removeClass('hidden');
        
        $.ajax({
           type: 'POST',
           url: url,
           data: $('#update-form').serialize(),
           success: function(jsonResponse){
                //console.log('jsonResponse: ' + jsonResponse);
                var response = JSON.parse(jsonResponse);
                if(response.status == 'OK'){
                    if(url == 'create-batch')
                        addRowToTable(response.result);
                    else 
                        editRowInTable($('#batch-id').val(), response.result);

                    clearForm();
                } else if(response.status == 'ERROR'){
                    handleError(response.result);
                }
                
                $('#loading-div').addClass('hidden');
           },
           error: function(xHR, response, error){
               alert(error);
               $('#loading-div').addClass('hidden');
           }
        });
    });
    
    function addRowToTable(jsonResponse){
        var row = JSON.parse(jsonResponse);
        var table = $('#batchList').DataTable();
        count = $('#batchList tbody tr').length;
        
        table.row.add([
                ++count,
                row.batch_number,
                row.manufacturing_date,
                row.expiry_date,
                row.quantity,
                '<span>' +
                    '<a id="u'+row.id+'" href="" onclick="return updateBatch(' + row.id + ')" >' +
                        '<i class="glyphicon glyphicon-pencil" aria-hidden="true"></i>' +
                    '</a>' +
                '</span>' +
                '<span class="marginleft10">' +
                    '<a id="d'+row.id+'" href="" onclick="return deleteBatch(' + row.id + ')" >' +
                        '<i class="glyphicon glyphicon-trash" aria-hidden="true"></i>' +
                    '</a>' +
                '</span>'
           ]);      
           
        table.draw();
    }
    
    function editRowInTable(id, jsonResponse){
        var table = $('#batchList').DataTable();
        var cells = $('#u'+id).closest('tr').children('td');
        var row = JSON.parse(jsonResponse);
        
        $(cells[1]).text(row.batch_number);
        $(cells[2]).text(row.manufacturing_date);
        $(cells[3]).text(row.expiry_date);
        $(cells[4]).text(row.quantity);
        
        table.draw();
    }
 });
 
 function updateBatch(id){               
        var cells  = $('#u'+id).closest('tr').children('td');
       
        $('#batch-batch_number').val($(cells[1]).text());
        $('#batch-manufacturing_date').val($(cells[2]).text());
        $('#batch-expiry_date').val($(cells[3]).text());
        $('#batch-quantity').val($(cells[4]).text());
        $('#batch-id').val(id);
        
        $('#add-batch').text('Update');
                
        return false;
 }
 
 function deleteBatch(id){
        if (confirm('Are you sure you?')) {
            ;
        } else {
            return false;
        }
     $('#loading-div').removeClass('hidden');
        
        $.ajax({
           type: 'POST',
           url: 'delete-batch',
           data: {id: id},
           success: function(response){
               console.log('response: ' + response);
                
                if(response == 'OK'){
                    $('#u'+id).closest('tr')
                            .css('background-color','red')
                            .fadeOut(600, 'swing', function(){
                                $('#u'+id).closest('tr').remove();
                            });
                }
                
                $('#batch-batch_number').val('');
                $('#batch-manufacturing_date').val('');
                $('#batch-expiry_date').val('');
                $('#batch-quantity').val('');
                
                $('#add-batch').text('Add');
                $('#loading-div').addClass('hidden');
           },
           error: function(xHR, response, error){
               alert(error);
               $('#loading-div').addClass('hidden');
           }
        });
    return false;
 }
 
 
 function clearForm(){
    $('#batch-batch_number').val('');
    $('#batch-manufacturing_date').val('');
    $('#batch-expiry_date').val('');
    $('#batch-quantity').val('');

    $('#add-batch').text('Add');
 }
 
 
 function handleError(result) {
    var errorString = '';
    result = JSON.parse(result);
    for (key in result) {
        errorString += result[key] + '\n';
    }

    alert(errorString);  
 }