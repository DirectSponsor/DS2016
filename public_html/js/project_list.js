/**
 * This file is part of Organic Directory Application
 *
 * @copyright Copyright (c) 2016 McGarryIT
 * @link      (http://www.mcgarryit.com)
 */
var list;
var selectedLinkURL = '';
var selectedRows = 0;
var projectId = 0;
var currentProjectId = 0;

$(document).ready(function(){

    list = $('#project_list').DataTable({
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
                text: 'Support Project',
                action: function ( e, dt, node, config ) {
                    if (projectId == 0) {
                        alert("No Project Selected");
                    } else {
                        window.location.href = window.location.href + "/"+projectId+"/support";
                    }
                },
                enabled: true
            }
        ],
        order: [[ 5, 'desc' ]]
    });
    list.on( 'select', function (e, dt, type, indexes) {
        var rowId = list.row( { selected: true } ).index();
        projectId = list.cell(rowId, 2).data();
        if(isSponsor) {
            var fullySupportedColIdx = 6;
        } else {
            var fullySupportedColIdx = 5;
        }
        var fullySupported = list.cell(rowId, fullySupportedColIdx).data();
        if ((fullySupported == 'No') && (enableSupport)) {
            toggleSupportButton(true);
        }
    } );
    list.on( 'deselect', function () {
        projectId = 0;
        toggleSupportButton(false);
    } );
    toggleSupportButton(false);

});
function toggleSupportButton(trueOrFalse) {
    list.button( 0 ).enable( trueOrFalse );
}

