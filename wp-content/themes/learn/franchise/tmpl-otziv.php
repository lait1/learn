<?php /* template name: Слайд отзыва */ 
fx_redirect();

$custom = get_post_custom(); 
?>

<div class="sl-slide fx_slide" data-orientation="vertical" data-slice1-rotation="0" data-slice2-rotation="0" data-slice1-scale="1" data-slice2-scale="1">
    <div class="sl-slide-inner">
        <div class="container slider_content_container">
            <div class="main-otziv">
            	<!-- <div class="photo_otziv"><img src="<?php echo wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'full')[0] ?>" alt=""></div> -->
                <div class="photo_otziv"><?php the_php_thumb(get_the_ID(), 250, 350); ?></div>
                <div class="text_otziv"><?php the_content() ?></div>
                <div class="name_otziv"><?php echo $custom['fx_name_otziv'][0] ?></div>
            </div>
        </div>
    </div>
</div>
