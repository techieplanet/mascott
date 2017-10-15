/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$(function () {
  $('[data-toggle="popover"]').popover();
})


function complaintsPopover(){
    $('#complaint-menu').popover({
        //html: true,
        content: 'Results from NAFDAC evaluation and analysis of flagged reports.',
        trigger: 'hover'
    });
}

function masRequestsReceivedPopover(){
    $('#reports_usage-mas-requests-menu').popover({
        html: true,
        content: 'Defined as the number of requests sent by the consumer for verification.',
        trigger: 'hover',
    });
}