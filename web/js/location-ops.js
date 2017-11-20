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
    
    
    
    /***************************************************
     * THIS IS THE JQWIDGETS LOCATION WIDGET PART
     **************************************************/        
    function populateStatesJqx(items) {
        var selectedStateItems = $('#jqxStateBox').jqxComboBox('getSelectedItems');
        states = new Array();
        
        $.each(items, function (index, item) {
            var zoneId = item.value;
            zoneStates = (lh[zoneId].states);
            
            $.each(zoneStates, function(index, element){
                states.push({value: index, label: element.location_name, zoneId: zoneId});
            });
        });
        $('#jqxStateBox').jqxComboBox('clear'); //clear all items in state combo first
        
        states = jqxArraySorter(states); //sort
        
        $('#jqxStateBox').jqxComboBox({source: states, multiSelect: true, width: 200, height: 25});
                
        jqxSetSelectedItems('jqxStateBox', selectedStateItems); //set selected items: custom.js
        
     }
 
    
    function populateLGAJqx(items) {
        var selectedLGAItems = $('#jqxLGABox').jqxComboBox('getSelectedItems');
        LGAs = new Array();

        $.each(items, function (index, item) {
            var stateId = item.value;
            stateLGAS = (lh[item.originalItem.zoneId].states[stateId].lgas);
            
            $.each(stateLGAS, function(index, element){
                LGAs.push({value: index, label: element, stateId: stateId});
            });
        });
        
        $('#jqxLGABox').jqxComboBox('clear'); //clear all items in state combo first
                
        LGAs = jqxArraySorter(LGAs);
        
        $('#jqxLGABox').jqxComboBox({source: LGAs, multiSelect: true, width: 200, height: 25});
        
        jqxSetSelectedItems('jqxLGABox', selectedLGAItems); //set selected items: custom.js
    }
    
    
    $('#jqxZoneBox').on('change', function (event) {
        var items = $('#jqxZoneBox').jqxComboBox('getSelectedItems');
        populateStatesJqx(items);
    });
    
    
    //on change of the state box
    $('#jqxStateBox').on('change', function (event) {
        var items = $('#jqxStateBox').jqxComboBox('getSelectedItems');
        populateLGAJqx(items);
    });
    
 });
 
 
 function extractJQXItemsValues(items){
        var valuesArray = [];
        $.each(items, function(index, element){
            valuesArray.push(element.value);
        });
        
        return valuesArray;
    }