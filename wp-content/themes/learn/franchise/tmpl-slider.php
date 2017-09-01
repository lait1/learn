<?php /* template name: Шапка */ ?><?php
fx_redirect();
?>
<?php $custom = get_post_custom() ?>
<header>
     <div id="slider" class="sl-slider-wrapper">
            <div class="sl-slider">

                <?php
                $fx_slides = new WP_Query(array(
                    'order' => 'ASC',
                    'orderby' => 'menu_order',
                    'post_parent' => get_the_ID(),
                    'post_type' => 'page',
                ));
                $slide_count = 0;
                //var_dump($fx_slides);
                $videolinks = '';
                $i=0;

                if($fx_slides->have_posts()){
                    $slide_count = $fx_slides->post_count;
                    while($fx_slides->have_posts()){
                        $fx_slides->the_post();
                        //echo 'slide!';
                        get_template_part( 'tmpl-slide' );

                        $custom1 = get_post_custom();
                        if($custom1['fx_slide_video'][0] != ''){
                            $videolinks .= '<a href="#" data-video-id="'.$custom1['fx_slide_video'][0].'" class="video_link_j video_link_j_'.$i.'"></a>';
                            $videolinks .= '<script>videoLightning({settings: {
                                                autoplay: true,
                                                color: "white",
                                                width: $(window).width(),
                                                height: $(window).height(),
                                            }, element: ".video_link_j_'.$i.'"});</script>';
                        }

                        $i++;
                    }
                }

                ?>

            </div>
            <!-- /sl-slider -->
            <?php
            if($slide_count > 0){
                echo '<nav id="nav-dots" class="nav-dots">';

                for( $i =0; $i<$slide_count; $i++ ){
                    if($i == 0){
                        echo '<span class="nav-dot-current"></span>';
                    }
                    else{
                        echo '<span></span>';
                    }
                }

                echo '</nav>';
            }
            ?>
        </div>
        <!-- /slider-wrapper -->

<div class="wrap-header-content">
    <div class="container">
    <div class="row">
        <div class="col-md-12">
        <div class="header-top">
            <img src="<?php bloginfo('template_directory') ?>/img/logo.png" alt="">
            <div class="phone">
                <span class="number"><?php echo get_option('fx_franchise_phone', '8 (800) 500-8772'); ?></span>
                <div class="call-btn" data-toggle="modal" data-target="#get-press">
                        <img src="<?php bloginfo('template_directory') ?>/img/telefon.png" alt="">
                        <div>Заказать звонок</div>
                </div>
            </div>
        </div>
        <div class="header-title">
            <h1><?php echo $custom['fx_header_l1'][0] ?></h1>
            <h2><?php echo $custom['fx_header_l2'][0] ?></h2>
            <h3><?php echo $custom['fx_header_l3'][0] ?></h3>
        </div>
        </div>
        </div>
            <div class="row">
            <div class="col-md-7"></div>
            <div class="col-md-5">
                <form action="" method="post" id="form90" class="header-main-form form_class">
                    <div class="form-title"><?php echo $custom['fx_form_header'][0] ?></div>
                    <input type="text" class="call-input" name="user_name" placeholder="Имя" required>
                    <input type="tel" class="call-input tooltipster" title="Номер телефона в формате 79120000000" name="user_phone" placeholder="Телефон" required>
                    <input type="email" class="call-input tooltipster" name="user_email" placeholder="E-mail" title="Адрес электронной почты. Например: mail@yandex.ru" required>
                    <input type="hidden" name="form_id" class="form_id" value="AC_PREZ_INST">
                    <button type="submit" class="call-btn green_btn"><?php echo $custom['fx_btn_text'][0] ?></button>
                </form>
            </div>
            </div>
        </div>
    </div>

    <div class="video_link_j_wrap" >
        <?php
        echo $videolinks;
        ?>
    </div>
</header>