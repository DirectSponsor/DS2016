/**
 * This file is part of Organic Directory Application
 *
 * @copyright Copyright (c) 2016 McGarryIT
 * @link      (http://www.mcgarryit.com)
 */
$(document).ready(function(){
    var selectedLinkURL = '';
    var list = $('#admin_dir_list').dataTable({
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
                className: 'control',
                orderable: false,
                targets:   0
            }
        ],
        order: [[ 4, 'asc' ]]
    });

});


