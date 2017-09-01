<?php
 get_header(); ?>
<body>
<div class="fixed_delivery_bg"></div>
<div class="bg_order">
    <div class="container">
        <div class="row">
            <div class="col-md-2 col-md-offset-1">
                <a href="/" ><img class="logo" src="<?php bloginfo('template_directory') ?>/images/logo_footer.png"></a>
            </div>
            <div class="col-md-8">
                <!--<p class="delivery_header_text">БЕСПЛАТНАЯ ДОСТАВКА ПО РОССИИ</p>-->
                <h1 class="delivery_header page_header"><?php the_post(); the_title(); ?></h1>
            </div>
            <div class="clearfix"></div>
        </div>
        <div class="row">
            <div class="col-md-offset-1 col-md-10">

                <div class="content other_page_content contacts-page">
                    <?php the_content() ?>
                </div>
            </div>
        </div>

    </div>
<!--    <div class="delivery_footer">
        <div class="footer_menu">
            <ul>
                <li>
                    <a href="">О возврате</a>
                </li>
                <li>
                    <a href="">Договор-оферта</a>
                </li>
                <li>
                    <a href="">Контакты</a>
                </li>
            </ul>
        </div>
    </div>-->
</div>

<?php wp_footer() ?>
</body>
