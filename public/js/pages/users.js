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
                                    <li><a href="#" onclick="deleteUser(${data})"><i class="icon-cross2"></i> Delete</a></li>
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

    // Style checkboxes and radios
    $('.styled').uniform();


    // Setup validation
    $("#new_user_form").validate({
        ignore: 'input[type=hidden], .select2-search__field', // ignore hidden fields
        errorClass: 'validation-error-label',
        successClass: 'validation-valid-label',
        highlight: function(element, errorClass) {
            $(element).removeClass(errorClass);
        },
        unhighlight: function(element, errorClass) {
            $(element).removeClass(errorClass);
        },

        // Different components require proper error label placement
        errorPlacement: function(error, element) {

            // Styled checkboxes, radios, bootstrap switch
            if (element.parents('div').hasClass("checker") || element.parents('div').hasClass("choice") || element.parent().hasClass('bootstrap-switch-container') ) {
                if(element.parents('label').hasClass('checkbox-inline') || element.parents('label').hasClass('radio-inline')) {
                    error.appendTo( element.parent().parent().parent().parent() );
                }
                else {
                    error.appendTo( element.parent().parent().parent().parent().parent() );
                }
            }

            // Unstyled checkboxes, radios
            else if (element.parents('div').hasClass('checkbox') || element.parents('div').hasClass('radio')) {
                error.appendTo( element.parent().parent().parent() );
            }

            // Input with icons and Select2
            else if (element.parents('div').hasClass('has-feedback') || element.hasClass('select2-hidden-accessible')) {
                error.appendTo( element.parent() );
            }

            // Inline checkboxes, radios
            else if (element.parents('label').hasClass('checkbox-inline') || element.parents('label').hasClass('radio-inline')) {
                error.appendTo( element.parent().parent() );
            }

            // Input group, styled file input
            else if (element.parent().hasClass('uploader') || element.parents().hasClass('input-group')) {
                error.appendTo( element.parent().parent() );
            }

            else {
                error.insertAfter(element);
            }
        },
        validClass: "validation-valid-label",
        rules: {
            password: {
                minlength: 5
            },
            password_confirm: {
                equalTo: '#password',
                minlength: 5
            }
        },
        messages: {
            username: "Enter email.",
            password: {
                required: "Enter password.",
                minlength: jQuery.validator.format("At least {0} characters required.")
            },
            password_confirm: {
                required: "Enter confirm password.",
                equalTo: "The password confirmation does not match.",
                minlength: jQuery.validator.format("At least {0} characters required.")
            }
        }
    });

});

let deleteUser = function (id) {
    bootbox.confirm({
        title: "<b>Delete user?</b>",
        message: "Are you sure to delete this user?",
        buttons: {
            confirm: {
                label: 'Yes',
                className: 'btn-success'
            },
            cancel: {
                label: 'No',
                className: 'btn-danger'
            }
        },
        callback: function (result) {
            if(result) {
                $.post("users/delete", {id}, function (data) {
                    if ( data.status === 'success') {
                        new PNotify({
                            title: 'Success!',
                            text: data.message,
                            addclass: 'bg-success',
                            icon: 'icon-shield-check',
                            delay: 1000,
                        });
                        setTimeout(function () {
                            location.reload();
                        }, 200);
                    } else {
                        new PNotify({
                            title: 'Fail!',
                            text: data.message,
                            addclass: 'bg-danger',
                            icon: 'icon-shield-notice',
                            delay: 1000,
                        });
                    }
                });
            }
        }
    });
};