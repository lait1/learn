<?php /* Template Name: Подарок другу */ ?><?php
if($GLOBALS['front']!=true){
    header('Location: /');
    exit;
}
?>
<div class="block present" id="GIFT">
    <div class="container">
        <div class="row"><?php $custom = get_post_custom() ?>
            <div class="col-md-offset-2 col-md-2 gift-image">
                <img src="<?php bloginfo('template_directory') ?>/images/podarok.png">
            </div>
            <div class="col-md-6 present_text">
                <div class="form_wrap form_wrap_bottom">
                    <h3 class="block_header"><?php the_title(); ?><img style="position: relative;bottom: 2px;" src="http://likegame.biz/wp-content/themes/likegame/images/RUR.png"></h3>
                    <form id="gift_form1" method="post" action="/delivery" novalidate="novalidate">
                        <div class="col-md-12">
                            <input name="user_name_land" class="input_text name-input" type="text" placeholder="Введите имя" required="" aria-required="true">
                            <input name="user_email" class="input_text phone-input tooltipster tooltipstered" type="text" placeholder="Введите e-mail" required="" aria-required="true">
                            <input type="submit" class="submit-button yellow_button  gift_button" value="<?php echo $custom['fx_present_btn_label'][0] ?>">
                        </div>
                        <div class="clearfix"></div>
                    </form>
                    <div class="clearfix"></div>
                    <script>
                        $('#gift_form1').validate({
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
