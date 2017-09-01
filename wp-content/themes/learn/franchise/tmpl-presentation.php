<?php /* template name: Презентация */ ?><?php
fx_redirect();
?>
<?php $custom = get_post_custom(); ?>
<div class="get-present">
    <div id="slider1" class="sl-slider-wrapper">
        <div class="sl-slider">

            <?php
            $fx_slides = new WP_Query(array(
                'order' => 'ASC',
                'orderby' => 'menu_order',
                'post_parent' => get_the_ID(),
                'post_type' => 'page',
            ));
            $slide_count = 0;
            //var_dump($fx_slides);
            $videolinks = '';
            $i=0;

            if($fx_slides->have_posts()){
                $slide_count = $fx_slides->post_count;
                while($fx_slides->have_posts()){
                    $fx_slides->the_post();
                    //echo 'slide!';
                    get_template_part( 'tmpl-slide-single' );

                    $custom1 = get_post_custom();

                    $i++;
                }
            }

            ?>
            <div class="next hidden-xs" ><img src="<?php bloginfo('template_directory') ?>/img/r_arrow.png" alt=""></div>
            <div class="prev hidden-xs" ><img src="<?php bloginfo('template_directory') ?>/img/l_arrow.png" alt=""></div>
        </div>
            <!-- /sl-slider -->

    </div>
        <!-- /slider-wrapper -->
    <form action="" method="post" id="form93" class="present-form form_class">
        <div class="container">
            <h3><div class="first_span_title"><?php echo $custom['fx_subheader1'][0] ?></div>
                <div class="two_span_title"><?php echo $custom['fx_subheader2'][0] ?></div></h3>
            <div class="row-present">
                <input type="text" class="present-input" name="name_city" placeholder="Укажите город" required>
            </div>
            <div class="row-present">
                <input type="text" class="present-input" name="user_name" placeholder="Введите имя" required>
                <input type="tel" class="present-input tooltipster" title="Номер телефона в формате 79120000000" name="user_phone" placeholder="Введите телефон" required>
                <input type="email" class="present-input tooltipster" name="user_email" title="Адрес электронной почты. Например: mail@yandex.ru" placeholder="Введите e-mail" required>
            </div>
            <input type="hidden" name="form_id" class="form_id" value="AC_PODROBNO">
            <button type="submit" class="present-btn green_btn"><?php echo $custom['fx_btn_label'][0] ?></button>
        </div>
    </form>
</div>