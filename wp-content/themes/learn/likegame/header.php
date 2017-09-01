<?php $GLOBALS['front']=true;
$fx_ancestors = get_ancestors(get_queried_object_id(), 'page');
foreach($fx_ancestors as $fx_ancestor){
    if($fx_ancestor == 4){
        header('Location: /');
        exit;
    }
}
if ($_SERVER['HTTPS'] == "on") {
    $url = "http://". $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
    header("Location: $url");
    exit;
}
//require_once('includes/phpthumb_init.php');


//init timer
if(!isset($_COOKIE['fx_timer'])){
    $GLOBALS['fx_timer_time'] = time()+7200+rand(1, 7200);
    setcookie('fx_timer', $GLOBALS['fx_timer_time'], time()+3600*24, '/', str_replace('http://', '', get_option('siteurl')) );
    setcookie('fx_timer_generated', time(), time()+3600*24, '/', str_replace('http://', '', get_option('siteurl')) );
}else{
    if(is_numeric($_COOKIE['fx_timer']) &&is_numeric($_COOKIE['fx_timer_generated']) ){
        $GLOBALS['fx_timer_time'] = $_COOKIE['fx_timer'];

        $daystarttime = mktime(0,0,30);

        if( $_COOKIE['fx_timer_generated'] < $daystarttime ){
            // timer was generated yesterday, so check if its completed and set new
            if( (time() - $GLOBALS['fx_timer_time']) > 3600 ){
                $GLOBALS['fx_timer_time'] = time()+7200+rand(1, 7200);
                setcookie('fx_timer', $GLOBALS['fx_timer_time'], time()+3600*24, '/', str_replace('http://', '', get_option('siteurl')) );
                setcookie('fx_timer_generated', time(), time()+3600*24, '/', str_replace('http://', '', get_option('siteurl')) );
            }

        }

    }else{
        $GLOBALS['fx_timer_time'] = time()+7200+rand(1, 7200);
        setcookie('fx_timer', $GLOBALS['fx_timer_time'], time()+3600*24, '/', str_replace('http://', '', get_option('siteurl')) );
        setcookie('fx_timer_generated', time(), time()+3600*24, '/', str_replace('http://', '', get_option('siteurl')) );
    }
}

$custom = get_post_custom();
?><!DOCTYPE html>
<html>
<head>
    <!-- meta -->
    <meta http-equiv="Content-type" content="text/html; charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="cleartype" content="on">
    <meta name="viewport" content="width=1000">
    <meta name="MobileOptimized" content="1000">
    <meta name="HandheldFriendly" content="True">
    <meta name="document-state" content="Dynamic">
    <meta name="robots" content="all">
    <meta name="description" content="<?php echo $custom['fx_description'][0] ?>">
    <meta name="keywords" content="<?php echo $custom['fx_keywords'][0] ?>">

    <title><?php
        if(!empty($custom['fx_title'][0])){
            echo $custom['fx_title'][0];
        }else{
            wp_title('', true);
        }

    ?></title>

    <link rel="shortcut icon" href="<?php bloginfo('template_directory') ?>/images/favicon.png">

    <!-- style sheets -->
    <!--<link href="//fonts.googleapis.com/css?family=PT+Sans:400,400italic,700,700italic&amp;subset=latin,cyrillic" rel="stylesheet" type="text/css">-->

    <!--<link rel="stylesheet" href="<?php /*bloginfo('template_directory') */?>/ytplayer/dist/css/jquery.mb.YTPlayer.min.css">-->
    <link rel="stylesheet" href="<?php bloginfo('template_directory') ?>/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php bloginfo('template_directory') ?>/css/tooltipster.css">
    <link rel="stylesheet" href="<?php bloginfo('template_directory') ?>/style.css?v=1.98">
    <?php wp_head() ?>
    <!-- scripts -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>  <!-- ïîäêëþ÷àåì jquery -->
    <script type="text/javascript" src="<?php bloginfo('template_directory') ?>/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="<?php bloginfo('template_directory') ?>/js/videoLightning.min.js"></script>
    <script type="text/javascript" src="<?php bloginfo('template_directory') ?>/js/jquery.autocomplete.min.js"></script>
    
    <script type="text/javascript" src="<?php bloginfo('template_directory') ?>/js/validate/jquery.validate.min.js"></script>
    <script type="text/javascript" src="<?php bloginfo('template_directory') ?>/js/jquery.tooltipster.min.js"></script>

    <!--<script type="text/javascript" src="<?php /*bloginfo('template_directory') */?>/js/inputmask/inputmask.min.js"></script>-->
    <!--<script type="text/javascript" src="<?php /*bloginfo('template_directory') */?>/js/inputmask/inputmask.extensions.min.js"></script>
    <script type="text/javascript" src="<?php /*bloginfo('template_directory') */?>/js/inputmask/inputmask.regex.extensions.min.js"></script>
    <script type="text/javascript" src="<?php /*bloginfo('template_directory') */?>/js/inputmask/jquery.inputmask.min.js"></script>-->

    <!--<script type="text/javascript" src="<?php /*bloginfo('template_directory') */?>/js/jquery.smooth-scroll.min.js"></script>-->

    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <!--<script type="text/javascript" charset="utf-8" src="/js/jquery.tubular.1.0.js"></script>--> <!--  ïîäêëþ÷àåì ïëàãèí -->

    <script>
        function isScrolledIntoView(elem)
        {
            var $elem = $(elem);
            var $window = $(window);

            var docViewTop = $window.scrollTop();
            var docViewBottom = docViewTop + $window.height();

            var elemTop = $elem.offset().top;
            var elemBottom = elemTop + $elem.height();

            return ((elemBottom <= docViewBottom) && (elemTop >= docViewTop));
        }
        jQuery('document').ready(function() {
            var options = { videoId: '1i2kRsr_oJk', start: 3 };
            //$('#wrapper').tubular(options);

            videoLightning({settings: {
                autoplay: true,
                color: "white",
                width: $(window).width(),
                height: $(window).height(),
            }, element: ".video-link"});

            $('.tooltipster').tooltipster({
                trigger: 'custom',
                position: 'bottom',
            });
            $('.tooltipster').focus(function(){
                $(this).tooltipster('show');
            });
            $('.tooltipster').blur(function(){
                $(this).tooltipster('hide');
            });
            /*
            //$.mask.definitions['e']='[àáâãäåæçèêëìíîïðñòóôõö÷øùýþÿ ]';
            //$('.phone-input').mask('+9(999)999-99-99');
            //$('.name-input').mask('eeeeeeeeee', {autoclear: false});
            $('.phone-input').inputmask('+9(999)999-99-99', {
                clearIncomplete: true,
            });
            $('.name-input').inputmask('a{2,20}', {
                clearIncomplete: true,
                "onincomplete": function () {
                    //$(this).val('');
                }
            });
            $('.email-input').inputmask('email', {
                clearIncomplete: true
            });
            $('.street-input1').inputmask('Regex', {
                regex: "[à-ÿa-z0-9 \-]+/iu",
                clearIncomplete: true,
            });
*/
            //$('a.anchor').smoothScroll();

            $(window).scroll(function(){
                if($(window).scrollTop()>$('#yt_wrap').height()){
                    $('#fixed_button').css('display', 'block');
                }else{
                    $('#fixed_button').css('display', 'none')
                }
            });
        });


    </script>

    <!-- Yandex.Metrika counter -->
    <script type="text/javascript">
        (function (d, w, c) {
            (w[c] = w[c] || []).push(function() {
                try {
                    w.yaCounter<?php echo get_option('fx_yametric_id', '3080646') ?> = new Ya.Metrika({
                        id:<?php echo get_option('fx_yametric_id', '3080646') ?>,
                        clickmap:true,
                        trackLinks:true,
                        accurateTrackBounce:true,
                        webvisor:true
                    });
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
    <noscript><div><img src="https://mc.yandex.ru/watch/<?php echo get_option('fx_yametric_id', '3080646') ?>" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
    <!-- /Yandex.Metrika counter -->
</head>