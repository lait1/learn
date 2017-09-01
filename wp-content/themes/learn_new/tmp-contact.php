<?php /* Template Name: Контакты */?>
<?php get_template_part("header"); ?>   

        <div class="b-contacts">
            <div class="container">
                <div class="b-contacts__h1">Адреса и контакты</div>
                <div class="b-contacts__h2">Свяжитесь со мной любым из перечисленных ниже способом и я обязательно дам обратную связь! :)</div>
                <div class="row">
                   <div class="col-sm-1 hidden-xs"></div>
                    <div class="col-sm-10">
                        <diw class="row text-center">
                            <div class="col-sm-4">
                                <div class="b-contacts__item">
                                    <div class="contact">
                                        <div class="contact__icon mail"></div>
                                        <div class="contact__title">Почта</div>
                                        <div class="contact__subtitle"><?php echo get_option('fx_email', 'admin@yandex.ru'); ?></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="b-contacts__item">
                                    <div class="contact">
                                        <div class="contact__icon place"></div>
                                        <div class="contact__title">Адрес</div>
                                        <div class="contact__subtitle"><?php echo get_option('fx_home', 'ул. Грибоедова 134'); ?></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="b-contacts__item">
                                    <div class="contact">
                                        <div class="contact__icon phone"></div>
                                        <div class="contact__title">Телефон</div>
                                        <div class="contact__subtitle"><?php echo get_option('fx_city_phone', '8 (800) 500-8772'); ?></div>
                                    </div>
                                </div>
                            </div>
                        </diw>
                    </div>
                </div>
            </div>
        </div>      


<?php get_template_part("footer"); ?>
<?php wp_footer(); ?>
