/**
 * This file is part of Organic Directory Application
 *
 * @copyright Copyright (c) 2016 McGarryIT
 * @link      (http://www.mcgarryit.com)
 */
var list;
var transId = 0;

$(document).ready(function(){

    list = $('#receipts_list').DataTable({
        lengthMenu: [[5, 10, 25, 50, -1], [5, 10, 25, 50, "All"]],
        autoWidth: true,
        responsive: {
            details: {
                type: 'column',
                target: 0
            }
        },
        columnDefs: [
            {
                orderable: false,
                className: 'select-checkbox',
                targets:   1
            },
            {
                className: 'control',
                orderable: false,
                targets:   0
            }
        ],
        select: {
            style:    'os',
            selector: 'td:nth-child(2)'
        },
        dom: 'Bfrtip',
        buttons: [
            {
                text: 'Confirm',
                action: function ( e, dt, node, config ) {
                    if (transId === 0) {
                        alert("No Receipt Selected");
                    } else {
                        processConfirmation(transId);
                    }
                },
                enabled: true
            },
            {
                text: 'Confirm Late',
                className: 'marginLeftBtn',
                action: function ( e, dt, node, config ) {
                    if (transId === 0) {
                        alert("No Receipt Selected");
                    } else {
                        processLate(transId);
                    }
                },
                enabled: true
            }
        ],
        order: [[ 5, 'desc' ]]
    });
    list.on( 'select', function (e, dt, type, indexes) {
        var rowId = list.row( { selected: true } ).index();
        transId = list.cell(rowId, 2).data();
        var status = list.cell(rowId, 6).data();
        if ((status === 'Pending') || (status === 'Late')) {
            toggleConfirmButton(true);
        }
    } );
    list.on( 'deselect', function () {
        transId = 0;
        toggleConfirmButton(false);
    } );
    toggleConfirmButton(false);

});

function toggleConfirmButton(trueOrFalse) {
    list.button(0).enable( trueOrFalse );
    list.button(1).enable( trueOrFalse );
}

/*
 * Transaction Processing Functions
 *
 */
function processConfirmation(transIdSelected) {
    var amount = prompt("\nPlease enter the amount\n\n   You actually received\n\n in your Local Currency?\n\n", "");
    if (!amount) {
        return false;
    }
    var postObj = {};
    postObj.amount = amount;
    return processTransaction(transIdSelected, 'confirm', postObj);
}
function processLate(transIdSelected) {
    var response = confirm("Please confirm\n\nYou have NOT RECEIVED\n\nthe selected payment?");
    if (!response) {
        return false;
    }
    var postObj = {};
    return processTransaction(transIdSelected, 'late', postObj);
}
function processTransaction(transIdSelected, requestType, postObj) {
    var jsonResult = ajax_update("/transactions/"+transIdSelected+"/"+requestType, 'POST', postObj);
    if (jsonResult['result'] === 'error') {
        return false;
    } else {
        alert('\n\n'+jsonResult['text']+'\n\n');
        location = window.location.href;
        return true;
    }
}
