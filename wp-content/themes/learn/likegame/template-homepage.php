<?php /* Template Name: Главная */
get_header();

if(!is_main_site()){
    //echo '<script>alert(1);</script>';
    $GLOBALS['current_blog'] = get_current_blog_id();

}

$custom=get_post_custom();
?>
<body>
<img style="display: none;" src="http://likegame.biz/wp-content/uploads/2015/09/link.jpg" >
<div id="wrapper" class="">
    <div id="yt_wrap">

    <div class="menu" style="padding: 0 20px; ">
        <!--<div class="container">-->
            <div class="row">
                <div class="col-sm-6 col-md-offset-0">
                    <img class="logo" src="<?php bloginfo('template_directory') ?>/images/logo_footer.png">
                </div>
                <!--<div class="col-md-5 hidden-xs hidden-sm">
                    &nbsp;
                </div>-->
                <div class="col-sm-6">
                    <div class="phone">
                        <a href="tel:+<?php echo preg_replace('/[^0-9]+/iu', '', get_option('fx_phone', '+7(342)298-09-82')); ?>"><?php echo get_option('fx_phone', '+7(342)298-09-82'); ?></a>
                        <?php if(get_option('fx_phone2') != ''): ?>
                        <br><a href="tel:+<?php echo preg_replace('/[^0-9]+/iu', '', get_option('fx_phone2')); ?>"><?php echo get_option('fx_phone2'); ?></a>
                        <?php endif; ?>
                        <?php if(get_option('fx_phone3') != ''): ?>
                        <br><a href="tel:+<?php echo preg_replace('/[^0-9]+/iu', '', get_option('fx_phone3')); ?>"><?php echo get_option('fx_phone3'); ?></a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <!--</div>-->
    </div>
        <?php
        if(!is_main_site() && MULTISITE && $custom['get_content_from_main_site'][0] == 'yes') {
            switch_to_blog(1);
            $new_query = new WP_Query('p=4&post_type=page');
            //var_dump($new_query);
            $new_query->the_post();
            $custom = get_post_custom();
        }
 ?>
    <div class="container">
        <div class="row" id="order_form">
            <div class="col-md-offset-2 col-md-8">
                <div class="main_header">
                    <h1 class="main_header_l1"><?php echo $custom['fx_header_l1'][0] ?></h1>
                    <h3 class="main_header_l2"><?php echo $custom['fx_header_l2'][0] ?></h3></h1></div>
                <div class="play_video_header video-link" data-video-id="<?php echo $custom['fx_video_id'][0] ?>"></div>
            </div>
            <div class="col-md-offset-2 col-md-5" >
                <div class="counter_wrap">
                    <h4 class="counter_header1"><?php echo $custom['fx_promo_l1'][0] ?></h4>
                    <h4 class="counter_header2"><?php echo $custom['fx_promo_l2'][0] ?></h4>
                    <div class="counter">
                        <?php get_template_part('timer'); ?>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form_wrap header_form" >
                    <h3 class="header_form_title"><?php echo $custom['fx_form_header'][0] ?></h3>
                    <form id="header_form" class="main_land_form" method="post" action="/delivery">

                            <input name="user_name_land" class="input_text name-input" type="text" placeholder="Введите имя" required>
                            <input name="user_email" class="input_text phone-input tooltipster" type="text" placeholder="Введите e-mail" required>
                            <input type="submit" class="submit-button yellow_button" value="<?php echo $custom['fx_btn_label'][0] ?>">

                        <div class="clearfix"></div>
                    </form>
                    <div class="clearfix"></div>
                    <script>
                        $('#header_form').validate({
                            rules: {
                                user_name_land: {
                                    required: true
                                },
                                user_email: {
                                required: true,
                                email: true
                                },
                            }
                        });
                    </script>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
    </div>
    <div id="P1" class="player12"
         data-property="{videoURL:'http://youtu.be/1i2kRsr_oJk',containment:'#yt_wrap',startAt:0,mute:true,autoPlay:true,loop:true,opacity:1, showControls:false}">
    </div>

<?php
// list the pages
/*
$pages = get_pages(array(
    'sort_order' => 'ASC',
    'sort_column' => 'menu_order',
    'hierarchical' => 0,
    'parent' => get_the_ID(),
    'exclude_tree' => '',
    'post_type' => 'page',
));
*/
$fx_pages = new WP_Query(array(
    'order' => 'ASC',
    'orderby' => 'menu_order',
    'post_parent' => get_the_ID(),
    'post_type' => 'page',
));

//var_dump($pages);
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




</div>



<script src="<?php bloginfo('template_directory') ?>/js/jquery.jcarousel.min.js"></script>
<script>
    $(document).ready(function(){
        $('.jcarousel').jcarousel({
            // Configuration goes here
        });
        $('.jcarousel-prev').click(function() {
            $('.jcarousel').jcarousel('scroll', '-=2');
            return false;
        });

        $('.jcarousel-next').click(function() {
            $('.jcarousel').jcarousel('scroll', '+=2');
            return false;
        });

        $('.carousel-link').click(function(){
            var cur_link = this;

            /*$('.gallery_image').fadeOut(500);
            $('#gallery_image_'+$(this).attr('data-image')).fadeIn(500);*/
            if($(cur_link).attr('data-disabled') != 'true'){
                $('.carousel-link').attr('data-disabled', 'true');
                var pic_id = $(this).attr('data-image');
                $('.gallery_image').css('z-index', '2');
                $('#gallery_image_'+pic_id).css('z-index', '3').fadeIn(500, function(){
                    $('.gallery_image').each(function(){
                        //console.log('loop: '+$(this).attr('id'));
                        if($(this).attr('id') != 'gallery_image_'+pic_id){
                            $(this).hide();
                            $('.carousel-link').attr('data-disabled', 'false');
                        }
                    });
                    $('#gallery_image_'+pic_id).css('z-index', '2');
                });
            }

            return false;
        });

        $('#gallery_image_1').show();
    });

</script>
<div class="videoClose" style="display:none; z-index:30000 !important; position:fixed; top:50px; right:50px; font-size:30pt; color:white; cursor:pointer">
    <span onclick="$('.videoClose').hide(); $('.video-wrapper').hide(500); $('.video-frame').remove();">&#10005;</span>
</div>
<?php 
$user_name_error = $_GET['user_name_error'];
$user_email_error = $_GET['user_email_error']; 
 ?>
<!-- Modal error -->
<div class="modal fade" id="Modalerror" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><img src="<?php bloginfo('template_directory') ?>/images/x.png"></button>
                <div class="form_wrap form_wrap_bottom">
                    <h3 class="block_header"><?php echo $user_name_error;?><br><?php echo $user_email_error;?></h3>
                    
                </div>
            </div>
        </div>
    </div>
</div>
<?php 

if(!empty($user_name_error) || !empty($user_email_error)):?>
    <script>
    $('#Modalerror').modal('show');
    </script>
<?php endif ?>
<?php if(MULTISITE) switch_to_blog( $GLOBALS['current_blog'] ); ?>
<?php wp_footer() ?>
</body>
</html>
