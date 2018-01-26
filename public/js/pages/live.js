let limit = 10;
let statusesTable;

let showMore = function () {
    limit += 10;
    $('#btn-show-less').toggleClass('collapse', limit <= 10);
    statusesTable.api().ajax.url('live/status?limit=' + limit).load();
    statusesTable.api().ajax.reload();
};

let showLess = function () {
    limit -= 10;
    $('#btn-show-less').toggleClass('collapse', limit <= 10);
    statusesTable.api().ajax.url('live/status?limit=' + limit).load();
    statusesTable.api().ajax.reload();
};

let ack = function (id) {
    $.get('live/ack?id=' + id, function (data) {
        statusesTable.api().ajax.reload();
        if (data.status === 'success') {
            new PNotify({
                title: 'Success!',
                text: 'Successfully acknowledged.',
                addclass: 'bg-success',
                icon: 'icon-shield-check',
                delay: 1000,
            });
        } else {
            new PNotify({
                title: 'Fail!',
                text: 'Failed to acknowledge.',
                addclass: 'bg-danger',
                icon: 'icon-shield-notice',
                delay: 1000,
            });
        }
    });
};

$(function () {


    // Table setup
    // ------------------------------

    // Setting datatable defaults
    $.extend($.fn.dataTable.defaults, {
        autoWidth: false,
        dom: '<"datatable-header"fl><"datatable-scroll"t><"datatable-footer"ip>',
        language: {
            search: '<span>Filter:</span> _INPUT_',
        },
        drawCallback: function () {
            $(this).find('tbody tr').slice(-3).find('.dropdown, .btn-group').addClass('dropup');
        },
        preDrawCallback: function () {
            $(this).find('tbody tr').slice(-3).find('.dropdown, .btn-group').removeClass('dropup');
        }
    });

    statusesTable = $('#datatable-statuses').dataTable({
        ajax: 'live/status?limit=' + limit,
        bLengthChange: false,
        bPaginate: false,
        bInfo: false,
        columns: [
            {data: 'customer.name'},
            {data: 'device_name'},
            {data: 'device_ip'},
            {data: 'department_name'},
            {data: 'date'},
            {data: 'critical_level'},
            {data: 'alarm_state'},
            {data: 'id'}
        ],
        ordering: false,
        columnDefs: [{
            width: 'auto',
            targets: [5],
            sClass: 'text-center'
        },{
            width: 'auto',
            targets: [6],
            sClass: 'text-center'
        },{
            width: 'auto',
            targets: [7],
            render: function (data, type, row) {
                return `
                        <button type="button" class="btn btn-primary" onclick="ack(${data})">ACK</button>  
                    `
            },
        }],
        createdRow: function (row, data, dataIndex) {
            if( data.alarm_state === 0 ){
                $(row).addClass('color-green');
            } else if( data.alarm_state === 1 && data.critical_level ===  1 ){
                $(row).addClass('color-red');
            } else if( data.alarm_state === 1 && data.critical_level !==  1 ) {
                $(row).addClass('color-orange');
            } else if( data.alarm_state === 2 ) {
                $(row).addClass('color-yellow');
            }
        }
    });

    setInterval( function () {
        statusesTable.api().ajax.reload();
    }, 5000 );

    // Add placeholder to the datatable filter option
    $('.dataTables_filter input[type=search]').attr('placeholder', 'Type to filter...');
});