<?php /* Template Name: Преимущества */ ?><?php
if($GLOBALS['front']!=true){
    header('Location: /');
    exit;
}
?>
<div class="block block2" id="PREM">
    <div class="container">
        <div class="row">
            <div class="col-md-offset-1 col-md-10">
                <h2 class="block_header"><?php the_title() ?></h2>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-offset-1 col-md-10">
                <?php
                $fx_benefits = new WP_Query(array(
                    'order' => 'ASC',
                    'orderby' => 'menu_order',
                    'post_parent' => get_the_ID(),
                    'post_type' => 'page',
                ));
                if($fx_benefits->have_posts()){
                    while($fx_benefits->have_posts()){
                        $fx_benefits->the_post();
                        ?>
                        <div class="col-md-4 benefit">
                            <?php the_post_thumbnail('full') ?>
                            <h3 class="benefit_header"><?php the_title() ?></h3>
                        </div>
                        <?php
                    }
                }

                ?>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>

</div>
