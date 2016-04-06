/**
 * This file is part of Organic Directory Application
 *
 * @copyright Copyright (c) 2016 McGarryIT
 * @link      (http://www.mcgarryit.com)
 */
$(document).ready(function(){
    var selectedLinkURL = '';
    var list = $('#recipient_list').dataTable({
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
                text: 'Join Project',
                action: function ( e, dt, node, config ) {
                    alert(
                        'Row data: '+
                        JSON.stringify( dt.row( { selected: true } ).data() )
                    );
                },
                enabled: true
            }
        ],
        order: [[ 4, 'asc' ]]
    });
    list.on( 'select', function () {
        var selectedRows = list.rows( { selected: true } ).count();

        list.button( 0 ).enable( selectedRows === 1 );
    } );


});


