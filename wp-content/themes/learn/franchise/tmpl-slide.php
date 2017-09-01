<?php /* template name: Слайд */ ?><?php
fx_redirect();
?>
<?php $custom = get_post_custom(); ?>

<div class="sl-slide" data-orientation="vertical" data-slice1-rotation="0" data-slice2-rotation="0" data-slice1-scale="1" data-slice2-scale="1">
    <input type="hidden" class="data-video" value="<?php echo $custom['fx_slide_video'][0] ?>">
    <div class="sl-slide-inner">
        <div class="bg-img" style="background-image: url('<?php echo wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'full')[0] ?>');"></div>
        <div class="container slider_content_container">

            <div class="header-main-title">
                <span class="p1"><?php echo $custom['fx_slide_line_1'][0] ?></span>
                <span class="p2"><?php echo $custom['fx_slide_line_2'][0] ?></span>
                <span class="p3"><?php echo $custom['fx_slide_line_3'][0] ?></span>
            </div>
        </div>
    </div>
</div>