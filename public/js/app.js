$(function () {

    $('.select').select2({
        minimumResultsForSearch: Infinity
    });

    $('.modal.has-input').on('hidden.bs.modal', function() {
        $(this).find("input").val("");
        $(this).find(".validation-error-label").remove();
    });

    $('form.ajax').ajaxForm({
        delegation: true,
        error: function (data, statusText, xhr, $form) {
            new PNotify({
                title: 'Fail!',
                text: 'Sever encountered  error.Please try again.',
                addclass: 'bg-danger',
                icon: 'icon-shield-notice',
                delay: 1000,
            });
        },
        success: function (data, statusText, shr, $form) {
            if(data.status === 'success') {
                new PNotify({
                    title: 'Success!',
                    text: data.message,
                    addclass: 'bg-success',
                    icon: 'icon-shield-check',
                    delay: 1000,
                });
                if (data.reload) {
                    setTimeout(function () {
                        location.reload();
                    }, 200);
                } else {
                    if($form.hasClass('closeModalAfter')) {
                        $('.modal').modal('hide');
                    }
                }
            } else {
                if (data.swal) {
                    swal({
                        title: "Sorry...",
                        text: data.message,
                        confirmButtonColor: "#EF5350",
                        type: "error"
                    });
                }else {
                    new PNotify({
                        title: 'Fail!',
                        text: data.message,
                        addclass: 'bg-danger',
                        icon: 'icon-shield-notice',
                        delay: 1000,
                    });
                }
            }
        }
    });

    $.fn.dataTable.ext.errMode = 'none';

    setInterval( function() {
        var date = new Date();
        var hours = date.getHours();
        var minutes = date.getMinutes();
        $("#hour").html(( hours < 10 ? "0" : "" ) + hours);
        $("#minute").html(( minutes < 10 ? "0" : "" ) + minutes);
        $("#month").html(moment().format("MMM D"));
        $("#year").html(moment().format("YYYY"));
        $("#full").html(moment().format("MMMM Do YYYY, HH:mm:ss"));
    },1000);
});