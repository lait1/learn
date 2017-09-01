<?php /* template name: Преимущества */ ?><?php
fx_redirect();
?>
<?php $custom = get_post_custom(); ?>
<div class="get-lost">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2><?php the_title() ?></h2>
            </div>
        </div>
        <div class="row">
            <?php
            $fx_slides = new WP_Query(array(
                'order' => 'ASC',
                'orderby' => 'menu_order',
                'post_parent' => get_the_ID(),
                'post_type' => 'page',
            ));
            $slide_count = 0;
            //var_dump($fx_slides);
            if($fx_slides->have_posts()){
                $slide_count = $fx_slides->post_count;
                while($fx_slides->have_posts()){
                    $fx_slides->the_post();
                    //echo 'slide!';
                    get_template_part( 'tmpl-benefit' );
                }
            }
            ?>
        </div>
    </div>
</div>