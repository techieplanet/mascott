/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


function populateStatesSelect(states) {
    $('#state_id').empty().append(new Option('--Select State--', 0));
    $.each(states, function(index, element){
        $('#state_id').append(new Option(element.location_name, index));
    });
    dropDownListSorter('state_id');
 }
 
 function populateLGAsSelect(lgas) {
    $('#lga_id').empty().append(new Option('--Select LGA--', 0));
    $.each(lgas, function(index, element){
        $('#lga_id').append(new Option(element, index));
    });
    dropDownListSorter('lga_id');
 }
 
 function updateLocationHidden(locationId){
     $('#usagereport-location_id').val(locationId);
 }
 
 $(document).ready(function(){
     
    $('#geozone_id').change(function() {
        var zoneId = $('#geozone_id').val();
        
        if(zoneId > 0) 
            populateStatesSelect(lh[zoneId].states);
        else
            $('#state_id').empty().append(new Option('--Select State--', 0));
        
        $('#lga_id').empty().append(new Option('--Select LGA--', 0));
        //updateLocationHidden(zoneId);
    });
    
    $('#state_id').change(function() {
        var zoneId = $('#geozone_id').val();
        var stateId = $('#state_id').val();
        
        if(stateId > 0){
            populateLGAsSelect(lh[zoneId].states[stateId].lgas);
            //updateLocationHidden(stateId);
        }
        else 
            $('#lga_id').empty().append(new Option('--Select LGA--', 0)); 
    });
    
//    $('#lga_id').change(function() {
//        var lgaId = $('#lga_id').val();
//    });
    
 });
    