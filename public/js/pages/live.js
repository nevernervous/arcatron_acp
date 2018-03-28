let limit = 10;
let onlineTable;
let offlineTable;
let packetLossTable;
let mutes = [];
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

let offlineTableHeight = ($(window).height() - 150 - 453) / 2;
let packetLossTableHieght = ($(window).height() - 150 - 453) / 2;

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

let mute = function (id) {
    $.get('live/mute?id=' + id, function (data) {
        // let icon = $('#mute' + id);
        // let className = icon.attr('class');
        // icon.attr('class', className === 'icon-bell2' ? 'icon-bell-cross': 'icon-bell2');
        offlineTable.api().ajax.reload();
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
            dataSrc: function (data) {
                $('#online_today').text(data.today);
                $('#online_week').text(data.week);
                $('#online_month').text(data.month);
                if (data.data.length === 0) {
                    $('#datatable-online_wrapper').addClass('hide');
                }
                else {
                    let wrapper = $('#datatable-online_wrapper');
                    if (wrapper.hasClass('hide')) {
                        wrapper.removeClass('hide');
                        onlineTable.fnDraw();
                    }
                }
                return data.data;
            }
        },
        bLengthChange: false,
        bPaginate: false,
        bInfo: false,
        bFilter: false,
        autoWidth: false,
        scrollY: 150,
        scrollCollapse: true,
        columns: [
            {data: 'customer.name'},
            {data: 'department_name'},
            {data: 'device_name'},
            {data: 'device_ip'},
            {data: 'date'},
            {data: 'critical_level'},
            {data: 'alarm_state'},
            {data: 'last_state'},
            {data: 'last_state_date'},
            {data: 'id'}
        ],
        ordering: false,
        columnDefs: [{
            width: '130px',
            targets: [3],
        },{
            width: '160px',
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
                if (data === 0)
                    return 'ONLINE';
                if (data === 1)
                    return 'OFFLINE';
                else
                    return 'PACKET LOSS';
            }
        },{
            width: '160px',
            targets: [8],
        },{
            width: '70px',
            targets: [9],
            render: function (data, type, row) {
                return `
                        <button type="button" class="btn btn-primary ack" onclick="ack(${data})">ACK</button>  
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
            dataSrc : function (data) {
                $('#offline_today').text(data.today);
                $('#offline_week').text(data.week);
                $('#offline_month').text(data.month);
                mutes = data.mutes;
                if (data.data.length === 0) {
                    $('#datatable-offline_wrapper').addClass('hide');
                }
                else {
                    let wrapper = $('#datatable-offline_wrapper');
                    if (wrapper.hasClass('hide')) {
                        wrapper.removeClass('hide');
                        offlineTable.fnDraw();
                    }
                }
                return data.data;
            }
        },
        bLengthChange: false,
        bPaginate: false,
        bInfo: false,
        bFilter: false,
        scrollY: offlineTableHeight,
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
            {data: 'id'},
            {data: 'id'}
        ],
        ordering: false,
        columnDefs: [{
            width: '130px',
            targets: [3],
        },{
            width: '160px',
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
            targets: [7],
            render: function (data, type, row) {
                let iconClass = mutes.includes(data) ? 'icon-bell2' : 'icon-bell-cross';
                return `
                        <button type="button" class="btn btn-sm btn-primary button-icon" onclick="mute(${data})">
                        <i id="mute${data}" class="${iconClass}"></i>
                        </button>  
                    `
            },
        },{
            width: '70px',
            targets: [8],
            render: function (data, type, row) {
                return `
                        <button type="button" class="btn btn-sm btn-primary ack" onclick="ack(${data})">ACK</button>  
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
        },
        fnDrawCallback : function (oSettings) {
            let height = $('#datatable-offline_wrapper div .dataTables_scrollBody').height();
            if (height < offlineTableHeight) {
                let headerHeight = height === 0 ? 57 : 0;
                $('#datatable-packet-loss_wrapper div .dataTables_scrollBody').css('max-height', offlineTableHeight + packetLossTableHieght - height + headerHeight + 'px');
            }
        }
    });

    packetLossTable = $('#datatable-packet-loss').dataTable({
        ajax: {
            url: 'live/status?as=2',
            dataSrc: function (data) {
                $('#packet_today').text(data.today);
                $('#packet_week').text(data.week);
                $('#packet_month').text(data.month);
                if (data.data.length === 0) {
                    $('#datatable-packet-loss_wrapper').addClass('hide');
                }
                else {
                    let wrapper = $('#datatable-packet-loss_wrapper');
                    if (wrapper.hasClass('hide')) {
                        wrapper.removeClass('hide');
                        packetLossTable.fnDraw();
                    }
                }
                return data.data;
            }
        },
        bLengthChange: false,
        bPaginate: false,
        bInfo: false,
        bFilter: false,
        autoWidth: false,
        scrollY: offlineTableHeight,
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
            width: '160px',
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
                        <button type="button" class="btn btn-primary ack" onclick="ack(${data})">ACK</button>  
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
        },
        fnDrawCallback : function (oSettings) {
            let height = $('#datatable-packet-loss_wrapper div .dataTables_scrollBody').height();
            if (height < packetLossTableHieght) {
                let headerHeight = height === 0 ? 57 : 0;
                $('#datatable-offline_wrapper div .dataTables_scrollBody').css('max-height', offlineTableHeight + packetLossTableHieght - height + headerHeight + 'px');
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