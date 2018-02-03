let limit = 10;
let onlineTable;
let offlineTable;
let packetLossTable;

let showMore = function () {
    limit += 10;
    $('#btn-show-less').toggleClass('collapse', limit <= 10);
    onlineTable.api().ajax.url('live/status?limit=' + limit).load();
    onlineTable.api().ajax.reload();
};

let showLess = function () {
    limit -= 10;
    $('#btn-show-less').toggleClass('collapse', limit <= 10);
    onlineTable.api().ajax.url('live/status?limit=' + limit).load();
    onlineTable.api().ajax.reload();
};

let ack = function (id) {
    $.get('live/ack?id=' + id, function (data) {
        onlineTable.api().ajax.reload();
        offlineTable.api().ajax.reload();
        packetLossTable.api().ajax.reload();
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

    onlineTable = $('#datatable-online').dataTable({
        ajax: {
            url: 'live/status?as=0',
            complete: function (data) {
                $('#online_today').text(data.responseJSON.today);
                $('#online_week').text(data.responseJSON.week);
                $('#online_month').text(data.responseJSON.month);
            }
        },
        bLengthChange: false,
        bPaginate: false,
        bInfo: false,
        bFilter: false,
        autoWidth: false,
        scrollY: "200px",
        scrollCollapse: true,
        columns: [
            {data: 'customer.name'},
            {data: 'department_name'},
            {data: 'device_name'},
            {data: 'device_ip'},
            {data: 'date'},
            {data: 'critical_level'},
            {data: 'alarm_state'},
            {data: 'id'}
        ],
        ordering: false,
        columnDefs: [{
            width: '130px',
            targets: [3],
        },{
            width: '150px',
            targets: [4],
        },{
            width: '80px',
            targets: [5],
            sClass: 'text-center'
        },{
            width: '80px',
            targets: [6],
            render: function (data, type, row) {
                return 'ONLINE';
            }
        },{
            width: '70px',
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

    offlineTable = $('#datatable-offline').dataTable({
        ajax: {
            url: 'live/status?as=1',
            complete: function (data) {
                $('#offline_today').text(data.responseJSON.today);
                $('#offline_week').text(data.responseJSON.week);
                $('#offline_month').text(data.responseJSON.month);
            }
        },
        bLengthChange: false,
        bPaginate: false,
        bInfo: false,
        bFilter: false,
        scrollY: 200,
        autoWidth: false,
        bAutoWidth: false,
        scrollCollapse: true,
        columns: [
            {data: 'customer.name'},
            {data: 'department_name'},
            {data: 'device_name'},
            {data: 'device_ip'},
            {data: 'date'},
            {data: 'critical_level'},
            {data: 'alarm_state'},
            {data: 'id'}
        ],
        ordering: false,
        columnDefs: [{
            width: '130px',
            targets: [3],
        },{
            width: '150px',
            targets: [4],
        },{
            width: '80px',
            targets: [5],
            sClass: 'text-center'
        },{
            width: '80px',
            targets: [6],
            render: function (data, type, row) {
                return 'OFFLINE';
            }
        },{
            width: '70px',
            targets: [7],
            render: function (data, type, row) {
                return `
                        <button type="button" class="btn btn-sm btn-primary" onclick="ack(${data})">ACK</button>  
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

    packetLossTable = $('#datatable-packet-loss').dataTable({
        ajax: {
            url: 'live/status?as=2',
            complete: function (data) {
                $('#packet_today').text(data.responseJSON.today);
                $('#packet_week').text(data.responseJSON.week);
                $('#packet_month').text(data.responseJSON.month);
            }
        },
        bLengthChange: false,
        bPaginate: false,
        bInfo: false,
        bFilter: false,
        autoWidth: false,
        scrollY: "200px",
        scrollCollapse: true,
        columns: [
            {data: 'customer.name'},
            {data: 'department_name'},
            {data: 'device_name'},
            {data: 'device_ip'},
            {data: 'date'},
            {data: 'critical_level'},
            {data: 'alarm_state'},
            {data: 'id'}
        ],
        ordering: false,
        columnDefs: [{
            width: '130px',
            targets: [3],
        },{
            width: '150px',
            targets: [4],
        },{
            width: '80px',
            targets: [5],
            sClass: 'text-center'
        },{
            width: '80px',
            targets: [6],
            render: function (data, type, row) {
                return 'PACKET LOSS'
            }
        },{
            width: '70px',
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
        onlineTable.api().ajax.reload();
        offlineTable.api().ajax.reload();
        packetLossTable.api().ajax.reload();
    }, 5000 );

    // // Add placeholder to the datatable filter option
    // $('.dataTables_filter input[type=search]').attr('placeholder', 'Type to filter...');
});