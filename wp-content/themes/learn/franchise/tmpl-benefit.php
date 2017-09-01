<?php /* template name: Преимущество */ ?><?php
fx_redirect();
?>
<?php $custom = get_post_custom(); ?>
<div class="get-lost-item col-md-6">
    <div class="get-lost-img"><?php the_php_thumb(get_the_ID(), 91, 91); ?><img src="<?php bloginfo('template_directory') ?>/img/shadow.png" alt=""></div>
    <p class="get-lost-item-description"><?php the_title() ?></p>
</div>