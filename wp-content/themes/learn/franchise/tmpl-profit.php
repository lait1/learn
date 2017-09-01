<?php /* template name: Прибыль */ ?><?php
fx_redirect();
?>
<?php $custom = get_post_custom(); ?>
<div class="shadow-line"></div>
<div class="profit-block">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="profit-title">
                    <h2><?php the_title() ?></h2>
                    <h3><?php echo $custom['fx_subheader'][0] ?></h3>
                </div>
            </div>
        </div>
        <div class="row hidden-xs hidden-sm">
            <div class="col-md-12">
                <div class="profit-item">
                    <div class="profit-item-name"><?php echo $custom['fx_profit_title1'][0] ?></div>
                    <div class="profit-item-diagram item-1">
                        <img src="<?php bloginfo('template_directory') ?>/img/profit-1.png" alt="">
                    </div>
                    <div class="profit-item-money"><?php echo $custom['fx_profit_money1'][0] ?></div>
                </div>
                <div class="profit-item">
                    <div class="profit-item-name"><?php echo $custom['fx_profit_title2'][0] ?></div>
                    <div class="profit-item-diagram item-2">
                        <img src="<?php bloginfo('template_directory') ?>/img/profit-2.png" alt="">
                    </div>
                    <div class="profit-item-money"><?php echo $custom['fx_profit_money2'][0] ?></div>
                </div>
                <div class="profit-item">
                    <div class="profit-item-name"><?php echo $custom['fx_profit_title3'][0] ?></div>
                    <div class="profit-item-diagram item-3">
                        <img src="<?php bloginfo('template_directory') ?>/img/profit-3.png" alt="">
                    </div>
                    <div class="profit-item-money"><?php echo $custom['fx_profit_money3'][0] ?></div>
                </div>
                <div class="profit-item">
                    <div class="profit-item-name"><?php echo $custom['fx_profit_title4'][0] ?></div>
                    <div class="profit-item-diagram item-4">
                        <img src="<?php bloginfo('template_directory') ?>/img/profit-4.png" alt="">
                    </div>
                    <div class="profit-item-money"><?php echo $custom['fx_profit_money4'][0] ?></div>
                </div>
                <div class="profit-item">
                    <div class="profit-item-name"><?php echo $custom['fx_profit_title5'][0] ?></div>
                    <div class="profit-item-diagram item-5">
                        <img src="<?php bloginfo('template_directory') ?>/img/profit-5.png" alt="">
                    </div>
                    <div class="profit-item-money"><?php echo $custom['fx_profit_money5'][0] ?></div>
                </div>
                <div class="profit-item">
                    <div class="profit-item-name"><?php echo $custom['fx_profit_title6'][0] ?></div>
                    <div class="profit-item-diagram item-6">
                        <img src="<?php bloginfo('template_directory') ?>/img/profit-6.png" alt="">
                    </div>
                    <div class="profit-item-money"><?php echo $custom['fx_profit_money6'][0] ?></div>
                </div>
            </div>
        </div>
        <div class="row hidden-md hidden-lg">
            <div class="progress">
                <div class="progress-bar progress-bar-warning" style="width: 100%"></div>
                <div class="progress-bar-text"><?php echo $custom['fx_profit_title1'][0] ?> - <?php echo $custom['fx_profit_money1'][0] ?></div>
            </div>
            <div class="progress">
                <div class="progress-bar progress-bar-warning" style="width: 20%"></div>
                <div class="progress-bar progress-bar-transparent" style="width: 80%"></div>
                <div class="progress-bar-text">
                    <?php echo $custom['fx_profit_title2'][0] ?> - <?php echo $custom['fx_profit_money2'][0] ?>
                </div>
            </div>
            <div class="progress">
                                <div class="progress-bar progress-bar-warning" style="width: 20%"></div>
                <div class="progress-bar progress-bar-transparent" style="width: 80%"></div>
                <div class="progress-bar-text">
                    <?php echo $custom['fx_profit_title3'][0] ?> - <?php echo $custom['fx_profit_money3'][0] ?>
                </div>
            </div>
            <div class="progress">
                
                <div class="progress-bar progress-bar-warning" style="width: 10%"></div>
                <div class="progress-bar progress-bar-transparent" style="width: 90%"></div>
                <div class="progress-bar-text">
                    <?php echo $custom['fx_profit_title4'][0] ?> - <?php echo $custom['fx_profit_money4'][0] ?>
                </div>
            </div>
            <div class="progress">
                
                <div class="progress-bar progress-bar-warning" style="width: 15%"></div>
                <div class="progress-bar progress-bar-transparent" style="width: 85%"></div>
                <div class="progress-bar-text">
                    <?php echo $custom['fx_profit_title5'][0] ?> - <?php echo $custom['fx_profit_money5'][0] ?>
                </div>
            </div>
            <div class="progress">
                
                <div class="progress-bar progress-bar-success" style="width: 35%"></div>
                <div class="progress-bar progress-bar-transparent" style="width: 65%"></div>
                <div class="progress-bar-text">
                    <?php echo $custom['fx_profit_title6'][0] ?> - <?php echo $custom['fx_profit_money6'][0] ?>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="down"><img src="<?php bloginfo('template_directory') ?>/img/down.png" alt=""></div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="calc-title">
                    <h2><?php echo $custom['fx_subheader2'][0] ?></h2>
                </div>
                <div class="slivers">
                    <p><?php echo $custom['people_pop_slider_title'][0] ?></p>
                    <div class="slider-wrap">
                        <div id="slider-people"></div>
                        <div class="slider_line" style="left:0">| <span class="people_value_min"><?php echo $custom['people_value_min'][0] ?></span></div>
                        <div class="slider_line" style="right:0">| <span class="people_value_max"><?php echo $custom['people_value_max'][0] ?></span></div>
                    </div>
                    <div class="people_value_wrap">
                        <span id="people_value_def">500 000</span>
                    </div>
                    <p><?php echo $custom['people_quest_slider_title'][0] ?></p>
                    <div class="slider-wrap">
                        <div id="slider-quest"></div>
                        <div class="slider_line" style="left:0">| <span>1</span></div>
                        <div class="slider_line" style="left:50%">| <span>2</span></div>
                        <div class="slider_line" style="right:0">| <span>3</span></div>
                        <!--<div class="slider_line" style="left:75%">| <span>4</span></div>
                        <div class="slider_line" style="right:0">| <span>5</span></div>-->
                    </div>
                </div>
                <form action="" id="form92" method="post" class="calc-form form_class">
                    <input type="hidden" id="people" name="city_h">
                    <input type="hidden" id="quest" name="city_q">
                     <div class="wrap-calc-input">
                        <input type="text" class="calc-input" name="name_city" placeholder="Город" required>
                     </div>   
                    <div class="wrap-calc-input">
                        <input type="text" class="calc-input" name="user_name" placeholder="Имя" required>
                        <input type="tel" class="calc-input tooltipster" title="Номер телефона в формате 79120000000" name="user_phone" placeholder="Телефон" required>
                        <input type="email" class="calc-input tooltipster" name="user_email" title="Адрес электронной почты. Например: mail@yandex.ru" placeholder="E-mail" required>
                    </div>
                    <input type="hidden" name="form_id" class="form_id" value="AC_PROFIT">
                    <button type="submit" class="calc-btn green_btn"><?php echo $custom['fx_btn_label'][0] ?></button>
                </form>
            </div>
        </div>
    </div>
    <div class="shadow-line-small"></div>
</div>
<script type="text/javascript">
$(document).ready(function() {
    $("#slider-people").slider({
        range: "min",
        value: 500000,
        min: <?php echo preg_replace('/[^0-9]+/iu', '',  $custom['people_value_min'][0] ); ?>,
        max: <?php echo preg_replace('/[^0-9]+/iu', '',  $custom['people_value_max'][0] ); ?>,
        step: 100000,
        slide: function(event, ui) {
            $("#people").val(ui.value);
            $("#people_value_def").text(ui.value);
        },
    });
    $("#people").val(500000);
    $("#slider-quest").slider({
        range: "min",
        value: 2,
        min: 1,
        max: 3,
        slide: function(event, ui) {
            $("#quest").val(ui.value);
        },
    });
    $("#quest").val(2);
});
</script>