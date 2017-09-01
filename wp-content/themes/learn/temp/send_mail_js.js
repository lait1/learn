$('.send_mail_form').each(function(){
        var id = $(this).attr('id');

        console.log('#'+id);
        $('#'+id).validate({
            rules: {
                name: {
                    required: true,
                    maxlength: 255,
                },
                phone: {
                    required: true,
                    minlength: 7,
                    maxlength: 40
                },
            },
            submitHandler: function(form) {

                form = $(form);
                var submit_btn = form.find('button[type="submit"]');

                $.ajax({
                    dataType: "json",
                    method: "post",
                    url: '/wp-admin/admin-ajax.php',
                    data: {
                        data: form.serializeArray(),
                        action: 'send_mail',
                    },
                    beforeSend: function() {
                        submit_btn.attr('disabled', 'disabled').attr("data-text", submit_btn.text()).text('отправка...');
                    },
                    success: function(response) {

                        submit_btn.removeAttr("disabled").text(submit_btn.attr("data-text"));

                        $.fancybox({content: response.msg});
                    },
                    error: function(){
                        submit_btn.removeAttr("disabled").text(submit_btn.attr("data-text"));
                        alert('Ошибка отправки данных на сервер');
                    }
                });
            }
        });
    });