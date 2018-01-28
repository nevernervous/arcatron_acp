$(function() {


    // Table setup
    // ------------------------------

    // Setting datatable defaults
    $.extend( $.fn.dataTable.defaults, {
        autoWidth: false,
        columnDefs: [{
            orderable: true,
            width: '100px',
            targets: [6]
        }],
        dom: '<"datatable-header"fl><"datatable-scroll"t><"datatable-footer"ip>',
        language: {
            search: '<span>Filter:</span> _INPUT_',
            lengthMenu: '<span>Show:</span> _MENU_',
            paginate: { 'first': 'First', 'last': 'Last', 'next': '&rarr;', 'previous': '&larr;' }
        },
        drawCallback: function () {
            $(this).find('tbody tr').slice(-3).find('.dropdown, .btn-group').addClass('dropup');
        },
        preDrawCallback: function() {
            $(this).find('tbody tr').slice(-3).find('.dropdown, .btn-group').removeClass('dropup');
        }
    });


    // Basic datatable
    $('#datatable-search').DataTable({
        createdRow: function (row, data, dataIndex) {
            if( data[6] === '0' ){
                $(row).addClass('color-green');
            } else if( data[6] === '1' && data[5] ===  '1' ){
                $(row).addClass('color-red');
            } else if( data[6]=== '1' && data[5] !==  '1' ) {
                $(row).addClass('color-orange');
            } else if( data[6] === '2' ) {
                $(row).addClass('color-yellow');
            }
        }
    });

    // External table additions
    // ------------------------------

    // Add placeholder to the datatable filter option
    $('.dataTables_filter input[type=search]').attr('placeholder','Type to filter...');


    // Enable Select2 select for the length option
    $('.dataTables_length select').select2({
        minimumResultsForSearch: Infinity,
        width: 'auto'
    });


    // Floating labels
    // ------------------------------

    // Variables
    var onClass = "on";
    var showClass = "is-visible";


    // Setup
    $("input:not(.token-input):not(.bootstrap-tagsinput > input), textarea, select").on("checkval change", function () {

        // Define label
        var label = $(this).parents('.form-group-material').children(".control-label");

        // Toggle label
        if (this.value !== "") {
            label.addClass(showClass);
        }
        else {
            label.removeClass(showClass).addClass('animate');
        }

    }).on("keyup", function () {
        $(this).trigger("checkval");
    }).trigger("checkval").trigger('change');


    // Remove animation on page load
    $(window).on('load', function() {
        $(".form-group-material").children('.control-label.is-visible').removeClass('animate');
    });

});

