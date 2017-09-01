<?php /* Template Name: Страница оплаты */


$echo_form = false;
$message = 'Ошибка в параметрах запроса. Если вы уверены, что по этой ссылке должна быть форма оплаты, свяжитесь с менеджером по телефону, указанному в шапке главной страницы.';
if(isset($_GET['cid']) && isset($_GET['oid'])){
    $user_id = preg_replace('/[^a-g0-9]+/iu', '', $_GET['cid']);
    $order_id = preg_replace('/[^0-9]+/iu', '', $_GET['oid']);

    if(strlen($user_id) == 32 && is_numeric($order_id)){
        //ok, tey to get data from db
        $rows = $wpdb->get_results("SELECT * from ".$wpdb->prefix."fx_orders_data where line_id='$order_id' LIMIT 1");
        if(!empty($rows)){
            if($rows[0]->userid == $user_id && $rows[0]->paid=='0'){
                // var is ok, echo form
                $echo_form = true;
                $summ = $rows[0]->summ;
                $cps_phone = $rows[0]->teladdress;
                $cps_email = $rows[0]->email;
            }else{
                header('Location: /payment/success');
                die();
                $message = 'Заказ уже оплачен';
            }
        }
    }
}

if(!$echo_form && $message == ''){
    //header('Location: /');
}
get_header();
$custom = get_post_custom();
?>
<body>
<div class="fixed_delivery_bg"></div>
<div class="bg_order">
    <div class="container">
        <div class="row">
            <div class="col-md-2 col-md-offset-1">
                <a href="/" ><img class="logo" src="<?php bloginfo('template_directory') ?>/images/logo_footer.png"></a>
            </div>
            <div class="col-md-8">
                <h1 class="delivery_header page_header"><?php the_post(); the_title(); ?></h1>
            </div>
            <div class="clearfix"></div>
        </div>
        <div class="row">
            <div class="col-md-offset-1 col-md-10">

                <div class="content">
                    <?php if($echo_form): ?>
                    <div class="div-order-payment">
                        <h1><?php echo $custom['sergey_custom_header'][0] ?></h1>
                        <h2>Заказ на сумму <?php echo $summ ?> рублей</h2>
                        <!--<h6>Выбери способ оплаты</h6>-->
                        <?php if(get_option('fx_payment_method') == 'ya_money'): // yandex money ?>
                            <form method="post" action="https://money.yandex.ru/quickpay/confirm.xml">
                                <input type="hidden" name="receiver" value="<?php echo get_option('fx_yamoney_wallet', '410011293603770') ?>">
                                <input type="hidden" name="formcomment " value="Покупка LikeGame">
                                <input type="hidden" name="short-dest" value="Покупка LikeGame">
                                <input type="hidden" name="quickpay-form" value="small">
                                <input type="hidden" name="targets" value="Оплата заказа <?php echo $order_id ?>">
                                <input type="hidden" name="sum" value="<?php echo $summ ?>">
                                <input type="hidden" name="label" value="<?php echo $order_id ?>">
                                <div class="div-payment-types">
                                    <label>
                                        <input class="chk-payment" name="paymentType" value="AC" type="radio" checked="checked">
                                        Банковские карты
                                        <div class="payment-big-icons-bankcards"></div>
                                    </label>
                                    <br>
                                    <label>
                                        <input class="chk-payment" name="paymentType" value="PC" type="radio">
                                        Яндекс.Деньги
                                        <div class="payment-big-icons-yandex-dengi"></div>
                                    </label>
                                </div>
                                <input class="link-pay delivery_next" value="Оплатить" type="submit">
                            </form>
                        <?php else: // yandex kassa ?>

                            <div class="div-payment-types">
                                <label>
                                    <input class="chk-payment" name="payment-yandex" value="AC" type="radio" checked="checked">
                                    Банковские карты
                                    <div class="payment-big-icons-bankcards"></div>
                                </label>
                                <br>
                                <label>
                                    <input class="chk-payment" name="payment-yandex" value="PC" type="radio">
                                    Яндекс.Деньги
                                    <div class="payment-big-icons-yandex-dengi"></div>
                                </label>
                                <br>
                                <label>
                                    <input class="chk-payment" name="payment-yandex" value="WM" type="radio">
                                    WebMoney (WMR)
                                    <div class="payment-big-icons-webmoney-rub"></div>
                                </label>
                                <br>
                                <label>
                                    <input class="chk-payment" name="payment-yandex" value="GP" type="radio">
                                    Терминалы: Связной, Евросеть, Сбербанк
                                    <div class="payment-big-icons-terminals"></div>
                                </label>
                                <br>
                                <label>
                                    <input class="chk-payment" name="payment-yandex" value="AB" type="radio">
                                    Альфа-Клик
                                    <div class="payment-big-icons-alfa-click"></div>
                                </label>
                                <br>
                                <label>
                                    <input class="chk-payment" name="payment-yandex" value="SB" type="radio">
                                    Сбербанк: оплата по SMS или Сбербанк Онлайн
                                    <div class="payment-big-icons-sb-online"></div>
                                </label>
                                <br>
                                <label>
                                    <input class="chk-payment" name="payment-yandex" value="PB" type="radio">
                                    Интернет-банк Промсвязьбанка PSB-Retail
                                    <div class="payment-big-icons-promsvyaz"></div>
                                </label>
                                <br>
                                <label>
                                    <input class="chk-payment" name="payment-yandex" value="МА" type="radio">
                                    MasterPass
                                    <div class="payment-big-icons-masterpass"></div>
                                </label>
                                <br>
                            </div>
                            <form novalidate="novalidate" action="https://money.yandex.ru/eshop.xml" method="post">
                            <!--<form novalidate="novalidate" action="https://demomoney.yandex.ru/eshop.xml" method="post">-->

                                <!-- Обязательные поля -->
                                <input name="shopId" value="<?php echo get_option('yashop_shopid') ?>" type="hidden">
                                <input name="scid" value="<?php echo get_option('yashop_scid') ?>" type="hidden">
                                <input name="sum" value="<?php echo $summ ?>" type="hidden">
                                <input name="customerNumber" value="<?php echo $user_id ?>" type="hidden">

                                <!-- Необязательные поля -->
                                <input name="paymentType" value="AC" id="payment_type" type="hidden">
                                <input name="shopSuccessURL" value="http://likegame.biz/payment/success" type="hidden">
                                <input name="shopFailURL" value="http://likegame.biz/payment/fail" type="hidden">
                                <input name="cps_phone" value="<?php echo $cps_phone ?>" type="hidden">
                                <input name="cps_email" value="<?php echo $cps_email ?>" type="hidden">

                                <!-- order -->
                                <input name="orderNumber" value="<?php echo $order_id ?>" type="hidden">
                                <!--<input name="orderSessionId" value="ecsr2jtwdtdflszwbdhxzj5b" type="hidden">-->

                                <input class="link-pay delivery_next" value="Оплатить" type="submit">
                            </form>
                            <script>
                                $('.chk-payment').click(function(){
                                    $('#payment_type').val($(this).val());
                                });
                            </script>
                        <?php endif; // payment method ?>
                    </div>
                <?php else: ?>
                <p><?php echo $message ?></p>
                <?php endif; ?>
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
