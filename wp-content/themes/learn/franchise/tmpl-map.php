<?php /* template name: Карта */ ?><?php
fx_redirect();
?>
<?php $custom = get_post_custom(); ?>
<div class="maps-block">
    <div class="container">
        <div class="maps">
            <div class="maps-title">
                <h2><?php the_title() ?></h2>
            </div>

            <?php
            $fx_slides = new WP_Query(array(
                'order' => 'ASC',
                'orderby' => 'menu_order',
                'post_type' => 'city',
            ));
            if($fx_slides->have_posts()){
                $slide_count = $fx_slides->post_count;
                while($fx_slides->have_posts()){
                    $fx_slides->the_post();
                    //echo 'slide!';
                    get_template_part( 'tmpl-city' );
                }
            }

            if(is_user_logged_in()){?>
                <div id="city_phantom" class="map_city_wrap grey" style="top: 100px; left: 100px;">
                    <a class="single_city_link" href="#"><img class="city_point" src="<?php bloginfo('template_directory') ?>/img/black_i.png" alt=""></a>
                    <div class="maps-white-block stiker">
                        <div class="wrap-maps-hidden-block">
                            <h3 class="map_city_title">Фантом</h3>
                            <p>X: <span id="fx_city_x"></span><br>
                                Y: <span id="fx_city_y"></span></p>
                        </div>
                    </div>
                </div>
                <script>
                    $(document).ready(function(){
                        $( "#city_phantom" ).draggable({
                            drag: function(){
                                $('#fx_city_x').text($('#city_phantom').css('left'));
                                $('#fx_city_y').text($('#city_phantom').css('top'));
                            }
                        });
                    });
                </script>
            <?php
            }
            ?>
            <?php if(!empty($custom['fx_help_maps'][0])): ?>
            <div class="wrap_help_maps">
                <div class="help_arrow"><img src="<?php bloginfo('template_directory') ?>/img/arrow_top.png" alt=""></div>
                <div class="help_text"><?php echo $custom['fx_help_maps'][0]; ?></div>
                <div class="help_arrow"><img src="<?php bloginfo('template_directory') ?>/img/arrow_bottom.png" alt=""></div>
            </div>
           <?php endif; ?>

            <div class="wrap-form-maps">
                <form action="" id="form91" method="post" class="maps-form form_class">
                    <h2><?php echo $custom['fx_title_form'][0] ?></h2>
                    <div class="row-maps">
                        <input type="text" class="city-input" name="name_city" placeholder="Город" required>
                    </div>
                    <div class="row-maps">
                        <input type="text" class="maps-input" name="user_name" placeholder="Имя" required>
                        <input type="tel" class="maps-input tooltipster" name="user_phone" title="Номер телефона в формате 79120000000" placeholder="Телефон" required>
                        <input type="hidden" name="form_id" class="form_id" value="AC_MARKET">
                        <input type="email" class="maps-input tooltipster" name="user_email" title="Адрес электронной почты. Например: mail@yandex.ru" placeholder="E-mail" required>
                    </div>
                    <button type="submit" class="maps-btn green_btn">Получить анализ рынка</button>
                </form>
            </div>
        </div>
    </div>
</div>