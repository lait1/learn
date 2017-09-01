<?php /* Template Name: Игроки */ ?><?php
if($GLOBALS['front']!=true){
    header('Location: /');
    exit;
}
?>
<div class="block players" id="GAMERS">
    <div class="container">
        <div class="row">
            <div class="col-md-offset-1 col-md-10">
                <h2 class="block_header"><?php the_title() ?></h2>
            </div>
        </div>
        <?php //$custom = get_post_custom(); var_dump($custom); ?>
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
                if($fx_benefits->have_posts()) {
                    while ($fx_benefits->have_posts()) {
                        $fx_benefits->the_post();

                        $custom = get_post_custom();
                        ?>
                        <div class="col-md-4 player">
                            <div class="player_inner center"
                                 style="background-image: url('<?php echo $custom['fx_player_bg_image'][0] ?>')" >
                                <h4 class="player_header"><?php the_title() ?></h4>
                                <a class="player_toggle_feedback" href="#" data-toggle="modal"
                                   data-target="#feedback_popup_<?php echo get_the_ID() ?>">Посмотреть отзыв</a>

                                <div class="pl_line">
                                    <div class="pl_icon"><img
                                            src="<?php bloginfo('template_directory') ?>/images/shapka.png"></div>
                                    <div class="pl_text"><?php echo $custom['fx_player_line1'][0] ?></div>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="pl_line">
                                    <div class="pl_icon"><img
                                            src="<?php bloginfo('template_directory') ?>/images/vremya.png"></div>
                                    <div class="pl_text"><?php echo $custom['fx_player_line2'][0] ?></div>
                                    <div class="clearfix"></div>
                                </div>
                                <a href="#" class="anchor yellow_button order_button" data-toggle="modal" data-target="#Modalform">Заказать игру</a>
                            </div>
                        </div>

                        <!--modals-->
                        <div class="modal fade" id="feedback_popup_<?php echo get_the_ID() ?>" tabindex="-1" role="dialog"
                             aria-labelledby="feedback_popup_1" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-body">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><img
                                                src="<?php bloginfo('template_directory') ?>/images/x.png"></button>
                                        <div class="col-md-6">
                                            <p class="feedback_name"><?php echo $custom['fx_player_name'][0] ?></p>

                                            <p class="feedback_text"><?php echo $custom['fx_player_feedback'][0] ?></p>

                                            <p class="feedback_link"><?php echo $custom['fx_player_link'][0] ?></p>
                                        </div>
                                        <div class="col-md-6"><?php the_post_thumbnail(); ?></div>
                                        <div class="clearfix"></div>
                                    </div>
                                </div>
                                <!-- /.modal-content -->
                            </div>
                            <!-- /.modal-dialog -->
                        </div>

                        <?php
                    }
                }
                ?>
                <div class="clearfix"></div>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
</div>
