<!DOCTYPE html>
<html lang="ru">
    <head>
        <meta charset="utf-8">
        <link href="<?php bloginfo('template_directory') ?>/css/bootstrap.css" rel="stylesheet" type="text/css">
        <link href="<?php bloginfo('template_directory') ?>/css/owl.carousel.min.css" rel="stylesheet" type="text/css">
        <link href="<?php bloginfo('template_directory') ?>/css/font-awesome.css" rel="stylesheet" type="text/css">
        <meta name="viewport" content="user-scalable=no, initial-scale=1.0, maximum-scale=1.0, width=device-width">
        <link href="<?php bloginfo('template_directory') ?>/css/style.css" rel="stylesheet" type="text/css">
        <title><?php bloginfo('name'); ?></title>
        <?php wp_head(); ?>
    </head>
    <body>
        <div class="top-header">
            <div class="container">
                <div class="visible-xs pull-right">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span> 
                    </button>
                </div>
                <div class="top-header__address pull-left"><i class="fa fa-map-marker"></i><span><?php echo get_option('fx_home', 'ул. Грибоедова 134'); ?></span></div>
                <div class="top-header__phone dropdown pull-left">
                    <div type="button" data-toggle="dropdown"><i class="fa fa-phone"></i><span><?php echo get_option('fx_city_phone', '8 (800) 500-8772'); ?></span></div>
                    <ul class="dropdown-menu dropdown_phone">
                        <li class="text-center">+7(902) 832-97-27</li>
                    </ul>
                </div>
                <div class="top-header__login dropdown pull-right login">
                    <div class="login__toggle" type="button" data-toggle="dropdown"><i class="fa fa-user"></i><span>Пользователь</span></div>
                    <ul class="dropdown-menu">
                        <li><a href="/wp-admin">Личный кабинет</a></li>
                        <li><a href="#">Выход</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="navbar navbar-inverse">
            <div class="container">
                <div class="navbar-header hidden-xs">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span> 
                    </button>
                </div>
                <div class="collapse navbar-collapse" id="myNavbar">
                    <ul class="nav navbar-nav">
                        <li><a href="/">Главная</a></li>
                        <li><a href="/news/">Новости</a></li>
                        <li><a href="/events/">Расписание</a></li> 
                        <li><a href="/comments/">Отзывы</a></li> 
                        <li><a href="/contact/">Контакты</a></li> 
                    </ul>
                </div>
            </div>
        </div>