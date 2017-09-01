<!DOCTYPE html>
<html lang="en">
<?php $custom = get_post_custom() ?>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="cleartype" content="on">
    <meta name="viewport" content="width=730">
    <meta name="MobileOptimized" content="730">
    <meta name="HandheldFriendly" content="True">
    <meta name="description" content="<?php echo $custom['fx_description'][0] ?>">
    <meta name="keywords" content="<?php echo $custom['fx_keywords'][0] ?>">
    <title><?php
        if(!empty($custom['fx_title'][0])){
            echo $custom['fx_title'][0];
        }else{
            wp_title('', true);
        }

        ?></title>
    <!-- Bootstrap -->
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">

    <link rel="shortcut icon" href="<?php bloginfo('template_directory') ?>/img/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory') ?>/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory') ?>/css/non-responsive.css">
<!--  -->
    <link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory') ?>/css/tooltipster.css">
    <link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory') ?>/css/style.css?v=1.2" />
    <link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory') ?>/css/custom.css?v=1.0" />
    <script type="text/javascript" src="<?php bloginfo('template_directory') ?>/js/modernizr.custom.79639.js"></script>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script type="text/javascript" src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script type="text/javascript" src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script type="text/javascript" src="http://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
    <script type="text/javascript" src="<?php bloginfo('template_directory') ?>/js/videoLightning.min.js?v=3.0.6"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="<?php bloginfo('template_directory') ?>/js/bootstrap.min.js"></script>

    <script type="text/javascript">
        $(document).ready(function(){
            videoLightning({settings: {
                autoplay: true,
                color: "white",
                width: $(window).width(),
                height: $(window).height(),
            }, element: ".video-link"});


        });

    </script>

    <?php wp_head(); ?>
</head>

<body>
<img src="<?php bloginfo('template_directory') ?>/img/footer-logo.png" alt="" style="display: none;">
<?php

$GLOBALS['front']=true;

$fx_pages = new WP_Query(array(
    'order' => 'ASC',
    'orderby' => 'menu_order',
    'post_parent' => get_the_ID(),
    'post_type' => 'page',
));

if($fx_pages->have_posts()){
    while( $fx_pages->have_posts() ){
        $fx_pages->the_post();

        require_once( basename(get_page_template()) );
    }
    wp_reset_postdata();
}else{
    echo 'something went wrong.';
    echo date('c', time());
}
?>


    <footer>
        <div class="container">
            <div class="footer">
                <img src="<?php bloginfo('template_directory') ?>/img/footer-logo.png" alt="">
                <div class="phone">
                    <span class="number"><?php echo get_option('fx_franchise_phone', '8 (800) 500-8772'); ?></span>
                    <div class="call-btn" data-toggle="modal" data-target="#get-press">
                        <img src="<?php bloginfo('template_directory') ?>/img/telefon.png" alt="">
                        <div>Заказать звонок</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="get-press" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-content">
                <div class="modal-body">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <form action="" method="post" id="form94" class="modal-form form_class">
                        <h3>Закажите звонок, и мы Вaм перезвоним</h3>
                        <input type="text" class="modal-input" name="user_name" placeholder="Введите имя" required>
                        <input type="tel" class="modal-input tooltipster" name="user_phone" title="Номер телефона в формате 79120000000" placeholder="Введите телефон" required>
                        <input type="hidden" name="form_id" class="form_id" value="AC_CALL">
                        <button type="submit" class="modal-btn green_btn phone-ico">Заказать звонок</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal fade" id="get-app" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-content modal-quest">
                <div class="modal-body">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <form action="" method="post" id="form95" class="modal-form form_class">
                        <h3>Открой квест LOST в своём городе</h3>
                        <input type="text" class="modal-input" name="user_name" placeholder="Введите имя" required>
                        <input type="tel" class="modal-input tooltipster" name="user_phone" title="Номер телефона в формате 79120000000" placeholder="Введите телефон" required>
                        <input type="email" class="modal-input tooltipster" name="user_email" title="Адрес электронной почты. Например: mail@yandex.ru" placeholder="Введите E-mail" required>
                        <input type="text" class="modal-input" name="name_city" id="name_city_popup_input" placeholder="Название города">
                        <input type="hidden" name="form_id" class="form_id" value="AC_OPEN">
                        <button type="submit" class="modal-btn green_btn">Отправить заявку</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal fade" id="get-video" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-content modal-quest">
                <div class="modal-body">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <form action="" method="post" id="form96" class="modal-form form_class">
                        <h3>Получите полную версию видео на Ваш электронный адрес</h3>
                        <input type="text" class="modal-input" name="user_name" placeholder="Введите имя">
                        <input type="tel" class="modal-input tooltipster" name="user_phone" title="Номер телефона в формате 79120000000" placeholder="Введите телефон">
                        <input type="email" class="modal-input tooltipster" name="user_email" title="Адрес электронной почты. Например: mail@yandex.ru" placeholder="Введите E-mail">
                        <input type="hidden" name="form_id" class="form_id" value="AC_VIDEO">
                        <button type="submit" class="modal-btn green_btn">Получить видео</button>
                    </form>
                    <div id="result-message"> </div>
                </div>
            </div>
        </div>
    </footer>
<div class="modal fade" id="response_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-content modal-quest">
        <div class="modal-body">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h3 id="response_msg"></h3>
        </div>
    </div>
</div>
</body>

<script type="text/javascript" src="<?php bloginfo('template_directory') ?>/js/jquery.tooltipster.min.js"></script>
<script type="text/javascript" src="<?php bloginfo('template_directory') ?>/js/validate/jquery.validate.min.js"></script>
<script type="text/javascript" src="<?php bloginfo('template_directory') ?>/js/jquery.ba-cond.min.js"></script>
<script type="text/javascript" src="<?php bloginfo('template_directory') ?>/js/jquery.slitslider.js"></script>
<script type="text/javascript" src="<?php bloginfo('template_directory') ?>/js/scripts.js?v=1.1"></script>
    <script src="<?php bloginfo('template_directory') ?>/js/fx_bg_slider.js"></script>
<script type="text/javascript">

    // send the forms
    $('.form_class').each(function() {
        var id = $(this).attr('id');
        var btn_text = $('#' + id).text();

        $('#' + id).validate({
            rules: {

                user_email: {
                    required: true,
                    email: true
                },
                user_phone: {
                    required: true,
                    digits: true,
                    minlength: 11,
                    maxlength: 20
                },
                user_name: {
                    required: true,
                    minlength: 2,
                    maxlength: 20
                },
                city_name: {
                    required: true
                }

            },
            submitHandler: function(form) {
                $.ajax({
                    dataType: "json",
                    method: "post",
                    url: '/wp-admin/admin-ajax.php',
                    data: {
                        data: $('#' + id).serializeArray(),
                        action: 'fx_submit_form',
                    },
                    beforeSend: function() {
                        //$('#' + id).find('button').attr("data-text", $('#' + id).find('button').text()).text('отправка...');
                        $('#' + id).find('button').attr("disabled", "disabled").attr("data-text", $('#' + id).find('button').text()).text('отправка...');
                    },
                    success: function(response) {
                        $('#' + id).find('button').removeAttr("disabled").text($('#' + id).find('button').attr("data-text"));
                        //dump(response.rsp);
                        // alert(response);
                        //console.log(response);
                        if(response.stat == 'ok'){
                            $(form).clearForm();
                            var form_id = $(form).find('.form_id').val();
                            var target = form_id.replace('AC_', '');
                            //alert(target);

                            yaCounter<?php echo get_option('fx_yametric_id') ?>.reachGoal(target);
                        }
                        $('.modal').modal('hide');
                        window.setTimeout(function(){
                            $('#response_modal').modal('show');
                        }, 500);
                        $('#response_msg').text(response.msg);

                    }
                });
            }
        });
    });
</script>
<!-- Yandex.Metrika counter -->
<script type="text/javascript">
    (function (d, w, c) {
        (w[c] = w[c] || []).push(function() {
            try {
                w.yaCounter<?php echo get_option('fx_yametric_id') ?> = new Ya.Metrika({
                    id:<?php echo get_option('fx_yametric_id') ?>,
                    clickmap:true,
                    trackLinks:true,
                    accurateTrackBounce:true,
                    webvisor:true
                });
                console.log('yaMetrika init');

                <?php if(!empty($_GET['utm_campaign'])): ?>
                console.log('utm goal');
                yaCounter<?php echo get_option('fx_yametric_id') ?>.reachGoal('<?php echo preg_replace('/[^a-z0-9\-_]+/iu', '', $_GET['utm_campaign']) ?>');
                <?php endif; ?>

            } catch(e) { }
        });

        var n = d.getElementsByTagName("script")[0],
            s = d.createElement("script"),
            f = function () { n.parentNode.insertBefore(s, n); };
        s.type = "text/javascript";
        s.async = true;
        s.src = "https://mc.yandex.ru/metrika/watch.js";

        if (w.opera == "[object Opera]") {
            d.addEventListener("DOMContentLoaded", f, false);
        } else { f(); }


    })(document, window, "yandex_metrika_callbacks");
</script>
<noscript><div><img src="https://mc.yandex.ru/watch/<?php echo get_option('fx_yametric_id') ?>" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->
<script>

    setTimeout(function () {
            if (typeof yaCounter<?php echo get_option('fx_yametric_id') ?> !== "undefined") {
                //alert('minute');
                yaCounter<?php echo get_option('fx_yametric_id') ?>.reachGoal('time');
            }
        }, 40*1000
    );

</script>


<!-- Google Tag Manager -->
<noscript><iframe src="//www.googletagmanager.com/ns.html?id=GTM-MDQKV4"
                  height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
        new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
        j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
        '//www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','GTM-MDQKV4');</script>
<!-- End Google Tag Manager -->
<?php wp_footer(); ?>
