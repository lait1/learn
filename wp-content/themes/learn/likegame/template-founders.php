<?php /* Template Name: Создатели */ ?><?php
if($GLOBALS['front']!=true){
    header('Location: /');
    exit;
}
?>
<div class="block founders" id="CREAT">
    <div class="container">
        <div class="row">
            <div class="col-md-offset-1 col-md-10">
                <h2 class="block_header"><?php the_title(); ?></h2>
                <?php
                $fx_content = get_the_content();
                $fx_benefits = new WP_Query(array(
                    'order' => 'ASC',
                    'orderby' => 'menu_order',
                    'post_parent' => get_the_ID(),
                    'post_type' => 'page',
                ));
                if($fx_benefits->have_posts()) {
                while ($fx_benefits->have_posts()) {
                $fx_benefits->the_post();

                $custom = get_post_custom();
                ?>

                    <div class="col-md-4 founder">
                        <?php the_post_thumbnail(); ?>
                        <h4 class="founder_name"><?php the_title() ?></h4>
                        <div class="founder_line">
                            <div class="founder_icon"><img src="<?php bloginfo('template_directory') ?>/images/zvezda.png"></div>
                            <div class="founder_text"><?php echo $custom['fx_player_line1'][0] ?></div>
                        </div>
                        <div class="founder_line">
                            <div class="founder_icon"><img src="<?php bloginfo('template_directory') ?>/images/rubl.png"></div>
                            <div class="founder_text"><?php echo $custom['fx_player_line2'][0] ?></div>
                        </div>
                    </div>
                    <?php
                }
                }
                ?>
                <div class="clearfix"></div>

                <div class="founder_p">
                    <?php echo apply_filters('the_content', $fx_content) ?>
                </div>
            </div>
        </div>
    </div>
</div>
