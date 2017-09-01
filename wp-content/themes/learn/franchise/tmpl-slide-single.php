<?php /* template name: Слайд-презентация */ ?><?php
fx_redirect();
?>
<?php $custom = get_post_custom(); ?>

<div class="sl-slide fx_slide" data-orientation="vertical" data-slice1-rotation="0" data-slice2-rotation="0" data-slice1-scale="1" data-slice2-scale="1">
    <div class="sl-slide-inner">
        <div class="bg-img" style="background-image: url('<?php echo wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'full')[0] ?>');"></div>
        <div class="container slider_content_container">


        </div>
    </div>
</div>