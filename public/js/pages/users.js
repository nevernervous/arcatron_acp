/* ------------------------------------------------------------------------------
*
*  # Basic datatables
*
*  Specific JS code additions for datatable_basic.html page
*
*  Version: 1.0
*  Latest update: Aug 1, 2015
*
* ---------------------------------------------------------------------------- */

$(function () {


    // Table setup
    // ------------------------------

    // Setting datatable defaults
    $.extend($.fn.dataTable.defaults, {
        autoWidth: false,
        columnDefs: [{
            orderable: false,
            width: '100px',
            targets: [4]
        }],
        dom: '<"datatable-header"fl><"datatable-scroll"t><"datatable-footer"ip>',
        language: {
            search: '<span>Filter:</span> _INPUT_',
            lengthMenu: '<span>Show:</span> _MENU_',
            paginate: {'first': 'First', 'last': 'Last', 'next': '&rarr;', 'previous': '&larr;'}
        },
        drawCallback: function () {
            $(this).find('tbody tr').slice(-3).find('.dropdown, .btn-group').addClass('dropup');
        },
        preDrawCallback: function () {
            $(this).find('tbody tr').slice(-3).find('.dropdown, .btn-group').removeClass('dropup');
        }
    });


    $('#datatable-users').dataTable({
        ajax: 'users/all',
        columns: [
            {data: 'name'},
            {data: 'email'},
            {data: 'roles[0].display_name'},
            {data: 'created_at'},
            {data: 'id'},
        ],
        columnDefs: [
            {
                render: function (data, type, row) {
                    return `<a href='users/edit/${row.id}'>${data}</a>`;
                },
                targets: 0
            },
            {
                render: function (data, type, row) {
                    return `
                        <ul class="icons-list">
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <i class="icon-menu9"></i>
                               </a>
                                <ul class="dropdown-menu dropdown-menu-right">
                                    <li><a href="#"><i class="icon-pencil"></i> Edit</a></li>
                                    <li><a href="#"><i class="icon-cross2"></i> Delete</a></li>
                                </ul>
							</li>
                        </ul>
                    `
                },
                sClass: 'text-center',
                targets: 4,
                orderable: false,
            }
        ]
    });


// Add placeholder to the datatable filter option
    $('.dataTables_filter input[type=search]').attr('placeholder', 'Type to filter...');


// Enable Select2 select for the length option
    $('.dataTables_length select').select2({
        minimumResultsForSearch: Infinity,
        width: 'auto'
    });
});