<?php /* Template Name: Навыки */ ?><?php
if($GLOBALS['front']!=true){
    header('Location: /');
    exit;
}
?>
<?php $custom = get_post_custom(); ?>
<div class="block skills" id="NAV">
    <div class="container">
        <div class="row">
            <div class="col-md-offset-1 col-md-10">
                <h2 class="block_header"><?php the_title() ?></h2>
            </div>
            <div class="clearfix"></div>
            <?php
            $fx_benefits = new WP_Query(array(
                'order' => 'ASC',
                'orderby' => 'menu_order',
                'post_parent' => get_the_ID(),
                'post_type' => 'page',
            ));
            if($fx_benefits->have_posts()) {
                $fxi = 0;
                while ($fx_benefits->have_posts()) {
                    $fx_benefits->the_post();
                    ?>
                    <div class="col-md-2 <?php if($fxi == 0) echo 'col-md-offset-1'; ?> skill">
                        <div class="skill_image"><?php the_post_thumbnail() ?></div>
                        <h3 class="skill_name"><?php the_title() ?></h3>
                    </div>

                    <?php $fxi++;
                }
            }
            ?>
            <div class="clearfix"></div>
            <div class="col-md-offset-1 col-md-10" id="PRICE">
                <div class="form_wrap form_wrap_bottom">
                    <h3 class="block_header"><?php echo $custom['fx_form_header'][0]; echo ' '; echo get_option('fx_game_price');?> <img style="position: relative;bottom: 2px;" src="<?php bloginfo('template_directory') ?>/images/RUR.png"></h3>
                    <form id="footer_form1" method="post" action="/delivery">
                        <div class="col-md-4">
                            <input name="user_name_land" class="input_text name-input" type="text" placeholder="Введите имя" required >
                        </div>
                        <div class="col-md-4">
                            <input name="user_email" class="input_text phone-input tooltipster" type="text" placeholder="Введите e-mail" required >
                        </div>
                        <div class="col-md-4">
                            <input type="submit" class="submit-button yellow_button" value="<?php echo $custom['fx_btn_label'][0] ?>">
                        </div>
                        <div class="clearfix"></div>
                    </form>
                    <div class="clearfix"></div>
                    <script>
                        $('#footer_form1').validate({
                            rules: {
                                user_name_land: {
                                    required: true
                                },
                                user_email: {
                                required: true,
                                email: true
                                },
                            }
                        });
                    </script>
                </div>
            </div>
        </div>
    </div>
</div>

