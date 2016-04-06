/**
 * This file is part of Organic Directory Application
 *
 * @copyright Copyright (c) 2016 McGarryIT
 * @link      (http://www.mcgarryit.com)
 */
var projectObjs = {};
var invitationsSelectedObj = {};
var selectedLinkURL = '';
var selectedRows = 0;
var projectId = 0;
var invitationId = 0;
var registered = '';
var currentProjectId = 0;

$(document).ready(function(){

    for(var projectIndex in projects){
        instantiateDataTable(projectObjs, projectIndex);
        toggleAllSupportButtonFalse(projectIndex);
    }

    $('#sendInvitation').on('click', function(evt) {
        if ($('#role_type').val() === 'Coordinator') {
            var response = confirm("This will cancel the existing Coordinator for the project. Continue?");
            if (response === true) {
                // continue
            } else {
                evt.preventDefault();
            }
        }
    });
});

function instantiateDataTable(projectObjs, projectIndex) {
    var tableId = '#invitation_list'+projectIndex;
    projectObjs[projectIndex] = $(tableId).DataTable({
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
                text: 'Re-Send Invitation',
                action: function ( e, dt, node, config ) {
                    invitationId = invitationsSelectedObj[projectIndex];
                    if (invitationId == 0) {
                        alert("No Invitation Selected");
                    } else {
                        window.location.href = window.location.href + "/"+invitationId+"/resend";
                    }
                },
                enabled: true
            }
        ],
        order: [[ 4, 'asc' ]]
    });
    projectObjs[projectIndex].on( 'select', function (e, dt, type, indexes) {
        var rowId = projectObjs[projectIndex].row( { selected: true } ).index();
        invitationId = projectObjs[projectIndex].cell(rowId, 3).data();
        invitationsSelectedObj[projectIndex] = invitationId;
        registered = projectObjs[projectIndex].cell(rowId, 7).data();
        if ((projects[projectIndex] === 0) && (registered === 'No')) {
            toggleSupportButtonTrue(projectIndex);
        }
    } );
    projectObjs[projectIndex].on( 'deselect', function () {
        invitationsSelectedObj[projectIndex] = 0;
        toggleAllSupportButtonFalse(projectIndex);
    } );
}
function toggleSupportButtonTrue(projectIndex) {
    projectObjs[projectIndex].button( 0 ).enable( true );
}
function toggleAllSupportButtonFalse(projectIndex) {
    projectObjs[projectIndex].button( 0 ).enable( false );
}
