<?php /* template name: Отзывы */ 
fx_redirect();

$custom = get_post_custom(); 
if(is_user_logged_in()){?>

<div class="otziv-row">
	<div id="slider2" class="sl-slider-wrapper">
        <div class="sl-slider">

            <?php
            $fx_slides = new WP_Query(array(
                'order' => 'ASC',
                'orderby' => 'menu_order',
                'post_parent' => get_the_ID(),
                'post_type' => 'page',
            ));
            $slide_count = 0;
            $videolinks = '';
            $i=0;

            if($fx_slides->have_posts()){
                $slide_count = $fx_slides->post_count;
                while($fx_slides->have_posts()){
                    $fx_slides->the_post();
                    get_template_part( 'tmpl-otziv' );

                    $custom1 = get_post_custom();

                    $i++;
                }
            }

            ?>
            <div class="next hidden-xs" ><img src="<?php bloginfo('template_directory') ?>/img/r_arrow.png" alt=""></div>
            <div class="prev hidden-xs" ><img src="<?php bloginfo('template_directory') ?>/img/l_arrow.png" alt=""></div>
        </div>
            <!-- /sl-slider -->

    </div>
</div>
<script>
	$(document).ready(function(){
    $('#slider2').bgSliderSingle();
});
</script>
<?php } ?>
