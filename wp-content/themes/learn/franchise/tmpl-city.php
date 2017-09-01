<?php /* template name: Город на карте */ ?><?php
fx_redirect();
?>
<?php $custom = get_post_custom(); ?>

<div id="city_<?php echo get_the_ID() ?>"
     class="map_city_wrap <?php echo $custom['fx_color'][0] ?>"
     style="top: <?php echo $custom['fx_top'][0] ?>px; left: <?php echo $custom['fx_left'][0] ?>px;">
    <a class="single_city_link" href="#"><img class="city_point" src="<?php bloginfo('template_directory') ?>/img/point-<?php echo $custom['fx_color'][0] ?>.png" alt=""></a>
    <?php if($custom['fx_color'][0] == 'green'){
        echo '<div class="maps-oringe-block stiker">';
    }
    else{
        echo '<div class="maps-white-block stiker">';
    }
    ?>

        <div class="wrap-maps-hidden-block">
            <h3 class="map_city_title"><?php the_title() ?></h3>
            <?php the_content() ?>
            <div class="map_city_btn <?php
                if($custom['fx_color'][0] == 'green'){
                    echo 'maps-orige-btn';
                }
                else{
                    echo 'maps-white-btn';
                }
            ?>" data-toggle="modal" data-target="#get-app"><?php
                if($custom['fx_btn_label'][0] == ''){
                    echo 'Открыть свой квест';
                }
                else{
                    echo $custom['fx_btn_label'][0];
                }
                ?></div>
        </div>
    </div>
</div>
