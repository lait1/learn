<footer>
    <div class="container">
        <div class="social-icon">
            <a href="http://www.youtube.com/"><span class="youtube"></span></a>
            <a href="https://vk.com/"><span class="vk"></span></a>
            <a href="https://instagram.com/"><span class="inst"></span></a>
        </div>
        <hr class="line-footer">
        <div class="footer">
            <a href="/" class="footer-logo">
                    <img src="<?php bloginfo('template_directory') ?>/img/logo.png" alt=""></a>
                    <ul>
                        <li><a href="#">Обучение</a></li>
                        <li><a href="#">Отзывы</a></li>
                        <li><a href="#">Блог</a></li>
                        <li><a href="#">Контакты</a></li>
                        <li><a href="#">Плитика конфиденциальности</a></li>
                    </ul>
                    <div class="menu-right-block">
                        <p>Город <a href="#" class="city"> Пермь</a></p>
                        <span class="ico"></span>
                        <div class="phone">
                        <span><strong>8-800-000-00-00</strong></span><br>
                        <span>(342)<strong> 247-77-16</strong></span>   
                        </div>
                        <div class="btm" data-toggle="modal" data-target="#call-me">Заказать звонок</div>
                    </div>
        </div>
        <div class="copy">
            <p>&copy;2010-2015 НОУ "Школа массажа Секрет" Все права защищены.</p>
            <p>Использование материалов разрешено только с согласия правообладателей.</p>
            <p>Сайт имеет возрастное ограничение 18+</p>
        </div>
        </div>
    </footer>
<div class="modal fade" id="registr" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-window">
                <form action="#">
                    <p>Регистрация</p>
                    <input type="email" class="call-input" name="reg-email" placeholder="E-mail" required >
                    <input type="password" class="call-input" name="reg-pw" placeholder="Пароль" required >
                    <input type="text" class="call-input" name="reg-name" placeholder="Имя" required >
                    <input type="tel" class="call-input" name="reg-tel" placeholder="Телефон" required >
                    <input type="submit" class="call-btn" value="Зарегистрироваться" >
                    </form>
                </div>
</div>
<div class="modal fade" id="call-me" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-window">
                <form action="#">
                    <p>Мы перезвоним вам в течении 10 минут</p>
                    <input type="text" class="call-input" name="reg-name" placeholder="Имя" required >
                    <input type="tel" class="call-input" name="reg-tel" placeholder="Телефон" required >
                    <input type="submit" class="call-btn" value="Позвоните мне" >
                    </form>
                </div>
</div>
<div class="modal fade" id="login" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-window">
                <form action="#">
                    <p>Вход</p>
                    <input type="email" class="call-input" name="reg-name" placeholder="E-mail" required >
                    <input type="password" class="call-input" name="reg-tel" placeholder="Пароль" required >
                    <input type="submit" class="call-btn" value="Войти" >
                    </form>
                </div>
</div>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="<?php bloginfo('template_directory') ?>/js/bootstrap.min.js"></script>