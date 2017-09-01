<?php /* Template Name: Подвал */ ?><?php
if($GLOBALS['front']!=true){
    header('Location: /');
    exit;
}
$custom = get_post_custom();
?>
<div class="block footer" id="SUB">
    <div class="container">
        <div class="row">
            <div class="col-md-offset-1 col-md-10">
                <h3 class="block_header"><?php the_title() ?></h3>
                <div class="socials">
                    <a target="_blank" href="<?php echo $custom['fx_link_youtube'][0] ?>" class="social"><img src="<?php bloginfo('template_directory') ?>/images/youtube.png"></a>
                    <a target="_blank" href="<?php echo $custom['fx_link_fb'][0] ?>" class="social"><img src="<?php bloginfo('template_directory') ?>/images/facebook.png"></a>
                    <a target="_blank" href="<?php echo $custom['fx_link_insta'][0] ?>" class="social"><img src="<?php bloginfo('template_directory') ?>/images/insta.png"></a>
                    <a target="_blank" href="<?php echo $custom['fx_link_twitt'][0] ?>" class="social"><img src="<?php bloginfo('template_directory') ?>/images/twitter.png"></a>
                    <a target="_blank" href="<?php echo $custom['fx_link_vk'][0] ?>" class="social"><img src="<?php bloginfo('template_directory') ?>/images/vk.png"></a>
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="col-md-12">
                <hr>
                <div class="col-md-2">
                    <img src="<?php bloginfo('template_directory') ?>/images/logo_footer.png" class="logo_footer">
                </div>
                <div class="col-md-8">
                    <div class="delivery_footer main_footer">
                        <div class="footer_menu">
                            <ul>
                                <li>
                                    <a href="/smi">СМИ о нас</a>
                                </li>
                                <li>
                                    <a href="/oferta">Договор-оферта</a>
                                </li>
                                <li>
                                    <a href="/contacts">Контакты</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-2 right" style="margin-top:35px;display: none;">
                    <span style="font-weight: 300;">Дизайн</span> <span style="font-size: 150%;font-weight: 300;">octopus-m.ru</span>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal form -->
<div class="modal fade" id="Modalform" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><img src="<?php bloginfo('template_directory') ?>/images/x.png"></button>
                <div class="form_wrap form_wrap_bottom">
                    <h3 class="block_header">Получи Like Game за 2900 + доставку по России бесплатно </h3>
                    <form id="modal_form1" method="post" action="/delivery">
                        <div class="col-md-12">
                            <input name="user_name_land" class="input_text name-input" type="text" placeholder="Введите имя" required="">
                            <input name="user_email" class="input_text phone-input tooltipster tooltipstered" type="text" placeholder="Введите E-mail" required="">
                            <input type="submit" class="submit-button yellow_button" value="Получить like game">
                        </div>
                        <div class="clearfix"></div>
                    </form>
                    <script>
                    $('#modal_form1').validate({
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
