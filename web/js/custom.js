/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


function dropDownListSorter(selectId){
    var options = $('#'+selectId+ ' option');
    var arr = options.map(function(_, o) { return { t: $(o).text(), v: o.value }; }).get();
    arr.sort(function(o1, o2) { return o1.t > o2.t ? 1 : o1.t < o2.t ? -1 : 0; });
    options.each(function(i, o) {
      o.value = arr[i].v;
      $(o).text(arr[i].t);
    });
 }
 
 
 function setdropdownListSelectedOption(selectBoxId, value){
     $('#'+selectBoxId).val(value).change();
 }
 
 
 function jqxListSorter(jqxComboId){
    var items = $('#'+jqxComboId).jqxComboBox('getItems');
    
    for(i=0; i<items.length-1; i++){
        for(j=i+1; j<items.length; j++){
            if(items[i].label > items[j].label){
                swap = items[i];
                items[i] = items[j];
                items[j] = swap;
                //$('#'+jqxComboId).jqxComboBox('updateAt', items[j], i );
                //$('#'+jqxComboId).jqxComboBox('updateAt', swap, j );
            }
        }
    }
    
    $.each(items, function(index, element){
       
    });
 }
 
function jqxArraySorter(items){
    //var items = $('#'+jqxComboId).jqxComboBox('getItems');
    
    for(i=0; i<items.length-1; i++){
        for(j=i+1; j<items.length; j++){
            if(items[i].label > items[j].label){
                swap = items[i];
                items[i] = items[j];
                items[j] = swap;
                //$('#'+jqxComboId).jqxComboBox('updateAt', items[j], i );
                //$('#'+jqxComboId).jqxComboBox('updateAt', swap, j );
            }
        }
    }
    
    return items;
}
 
 
 function jqxSetSelectedItems(jqxComboId, items){
    $.each(items, function(index, item){
        $('#'+jqxComboId).jqxComboBox('selectItem', item );
    });
 }