<?php /* Template Name: Страница заказа */

$display_delivery_form = false;
$display_pers_form = false;
global $wpdb;

$delivery_methods_enabled = json_decode(get_option('fx_delivery_methods_enabled'), true);
if($delivery_methods_enabled == null) $delivery_methods_enabled = array();

$default_delivery_method = get_option('fx_default_delivery_method');

if($_POST['address_form_submitted'] == 'yes'){
//    1. we have hidden $_POST (address_form_submitted)
//        also here we should have userid and orderid (hidden fields)
//        check them like in payment
    //echo '<br>Form submitted';

    $user_id = preg_replace('/[^a-g0-9]+/iu', '', $_POST['user_id']);
    $order_id = preg_replace('/[^0-9]+/iu', '', $_POST['order_id']);

    $rows = $wpdb->get_results("SELECT * from ".$wpdb->prefix."fx_orders_data where line_id='$order_id' LIMIT 1");
    if(!empty($rows)) {
        //echo '<br>row found';
        if ($rows[0]->userid == $user_id) {
            //echo '<br>row ok';
            // order is here
            if ($rows[0]->state == 'personal') {
                //echo '<br>row state personal';
                // personal info filled

                //check da vars and add new
                $index_error = '0';
                $region_error = '0';
                $city_error = '0';
                $street_error = '0';
                $dom_error = '0';
                $korpus_error = '0';
                $kvartira_error = '0';

                $quantity = validate_fields('number', $_POST['quantity']);
                if (!is_numeric($quantity)) $quantity = 1;

                $promo_code = validate_fields('promo', $_POST['promo_code']);


                if ($_POST['delivery_type'] == 'post') {
                    $delivery_type = 'post';
                }
                elseif ($_POST['delivery_type'] == 'courier') {
                    $delivery_type = 'courier';
                }
                elseif ($_POST['delivery_type'] == 'self'){
                    $delivery_type = 'self';
                }
                elseif ($_POST['delivery_type'] == 'rus_post_nal'){
                    $delivery_type = 'rus_post_nal';
                }
                else{
                    $delivery_type = $default_delivery_method;
                }

                if($_POST['delivery_company'] == 'ems'){
                    $delivery_company = 'ems';
                }else{
                    $delivery_company = 'rus_post';
                }


                $country = validate_fields('text', $_POST['country']);
                if($country == '') $country = 'RU'; //set RU if wrong (hacked?)

                if($delivery_type == 'post' || $delivery_type == 'rus_post_nal'){
                    //echo '<br>delivery post';
                    if($country == 'RU'){
                        //echo '<br>country ru';
                        $index = validate_fields('number', $_POST['index']);
                    }else{
                        if( strlen(preg_replace('/[^a-zа-я0-9\- ]+/iu', '', $_POST['index'])) != strlen($_POST['index']) ){
                            $index_error = 'warning';
                        }
                    }
                    if( strlen(preg_replace('/[^a-zа-я0-9\- ]+/iu', '', $_POST['region'])) != strlen($_POST['region']) ){
                        $region_error = 'warning';
                    }
                    if( strlen(preg_replace('/[^a-zа-я0-9\- ]+/iu', '', $_POST['city'])) != strlen($_POST['city']) ){
                        $city_error = 'warning';
                    }
                    if( strlen(preg_replace('/[^a-zа-я0-9\- ]+/iu', '', $_POST['street'])) != strlen($_POST['street']) ){
                        $street_error = 'warning';
                    }
                    if( strlen(preg_replace('/[^a-zа-я0-9\- \/]+/iu', '', $_POST['dom'])) != strlen($_POST['dom']) ){
                        $dom_error = 'warning';
                    }
                    if( strlen(preg_replace('/[^a-zа-я0-9\- ]+/iu', '', $_POST['korpus'])) != strlen($_POST['korpus']) ){
                        $korpus_error = 'warning';
                    }
                    if( strlen(preg_replace('/[^a-zа-я0-9\- \/]+/iu', '', $_POST['kvartira'])) != strlen($_POST['kvartira']) ){
                        $kvartira_error = 'warning';
                    }

                }
                elseif($delivery_type == 'courier'){
                    if( strlen(preg_replace('/[^a-zа-я0-9\- ]+/iu', '', $_POST['street'])) != strlen($_POST['street']) ){
                        $street_error = 'warning';
                    }
                    if( strlen(preg_replace('/[^a-zа-я0-9\- \/]+/iu', '', $_POST['dom'])) != strlen($_POST['dom']) ){
                        $dom_error = 'warning';
                    }
                    if( strlen(preg_replace('/[^a-zа-я0-9\- ]+/iu', '', $_POST['korpus'])) != strlen($_POST['korpus']) ){
                        $korpus_error = 'warning';
                    }
                    if( strlen(preg_replace('/[^a-zа-я0-9\- \/]+/iu', '', $_POST['kvartira'])) != strlen($_POST['kvartira']) ){
                        $kvartira_error = 'warning';
                    }
                }

                // rus address



                // че делать с этими двумя - хз. заполняются автоматом, если кто что наменяет - будет бред.
                // остается отфильтровать, отправить в емс, если доставка не считается - то взять знаечние и поля
                $region_holder = preg_replace('/[^a-z0-9\-]+/iu', '', $_POST['region_holder']);
                $city_holder = preg_replace('/[^a-z0-9\-]+/iu', '', $_POST['city_holder']);

                $index = preg_replace('/[^a-zа-я0-9\- ]+/iu', '', $_POST['index']);
                $region = preg_replace('/[^a-zа-я0-9\- ]+/iu', '', $_POST['region']); // has '-' in ID
                $city = preg_replace('/[^a-zа-я0-9\- ]+/iu', '', $_POST['city']); //the same
                $street = preg_replace('/[^а-я0-9\- ]+/iu', '', $_POST['street']);
                $dom = preg_replace('/[^a-zа-я0-9\- \/]+/iu', '',  $_POST['dom']);
                $korpus = preg_replace('/[^а-я0-9\- ]+/iu', '', $_POST['korpus']);
                $kvartira = preg_replace('/[^a-zа-я0-9\- \/]+/iu', '',  $_POST['kvartira']);


                // get price
                $discount = 0;
                if($promo_code != ''){
                    $discount = get_promo_discount($promo_code);
                }
                $game_price = get_option('fx_game_price', '2900');
                $game_price_discounted = round($game_price-$game_price*$discount/100);
                $price_total = round($game_price_discounted*$quantity);


                $everything_ok = false;
                if($delivery_type == 'post' || $delivery_type == 'rus_post_nal'){

                    if( $region == '') $region_error = 'error';
                    if( $city == '') $city_error = 'error';
                    if( $street == '') $street_error = 'error';
                    if( $dom == '') $dom_error = 'error';

                    if($country == 'RU'){
                        if(strlen($index) != 6) $index_error = 'error';

                        if($index_error == '0'
                            && $region_error == '0'
                            && $city_error == '0'
                            && $street_error == '0'
                            && $dom_error == '0'
                            && $korpus_error == '0'
                            && $kvartira_error == '0'
                        ){
                            //echo '<br>post:ru:no-errors';
                            if($delivery_type == 'rus_post_nal'){
                                $delivery_company = 'rus_post_nal';
                                //$delivery_price = $price_total*get_option('fx_nal_pay_percent', '30')/100;
                                $delivery_price = '0';
                            }
                            else {
                                if ($delivery_company == 'ems') {
                                    // get the delivery_price if available
                                    if ($city_holder != '') {
                                        $delivery_price = ems_get_delivery_summ($city_holder, $quantity);
                                    } elseif ($region_holder != '') {
                                        $delivery_price = ems_get_delivery_summ($region_holder, $quantity);
                                    } else {
                                        $delivery_company = 'rus_post';
                                        $delivery_price = '0';
                                    }
                                } else {
                                    $delivery_company = 'rus_post';
                                    $delivery_price = '0';
                                }
                            }

                            $info_to_add = array(
                                'order_date' => time(),
                                'state' => 'delivery',
                                'quantity' => $quantity,
                                'promo' => $promo_code,
                                'price' => $game_price_discounted,
                                'delivery_company' => $delivery_company,
                                'delivery_price' => $delivery_price,
                                'summ' => $price_total+$delivery_price,

                                'indexto' => $index,
                                'country' => 'Россия',
                                'region' => ems_decode($region, 'regions'),
                                'city' => ems_decode($city, 'cities'),
                                'street' => $street,
                                'house' => $dom,
                                'corpus' => $korpus,
                                'room' => $kvartira,
                            );

                            if($delivery_type == 'rus_post_nal'){
                                //$info_to_add['summ'] = $price_total*get_option('fx_nal_pay_percent', '30')/100;
                                $info_to_add['paid_nal'] = '0';
                            }
                            $everything_ok = true;
                        }
                    }
                    else{
                        if( $index == '') $index_error='error';

                        if($index_error == '0'
                            && $region_error == '0'
                            && $city_error == '0'
                            && $street_error == '0'
                            && $dom_error == '0'
                            && $korpus_error == '0'
                            && $kvartira_error == '0'

                        ) {
                            //echo '<br>post:other:no-errors';
                            // other country, ems only
                            $delivery_company = 'ems';
                            $delivery_price = ems_get_delivery_summ($country, $quantity);

                            $info_to_add = array(
                                'order_date' => time(),
                                'state' => 'delivery',
                                'quantity' => $quantity,
                                'promo' => $promo_code,
                                'price' => $game_price_discounted,
                                'delivery_company' => $delivery_company,
                                'delivery_price' => $delivery_price,
                                'summ' => $price_total+$delivery_price,

                                'indexto' => $index,
                                'country' => ems_decode($country, 'countries'),
                                'region' => $region,
                                'city' => $city,
                                'street' => $street,
                                'house' => $dom,
                                'corpus' => $korpus,
                                'room' => $kvartira,
                            );
                            $everything_ok = true;
                        }
                    }
                }
                elseif($delivery_type == 'courier'){
                    if( $street == '') $street_error = 'error';
                    if( $dom == '') $dom_error = 'error';

                    if($index_error == '0'
                        && $region_error == '0'
                        && $city_error == '0'
                        && $street_error == '0'
                        && $dom_error == '0'
                        && $korpus_error == '0'
                        && $kvartira_error == '0'
                    ){
                        $delivery_price = get_option('fx_courier_delivery_price', '0');

                        $info_to_add = array(
                            'order_date' => time(),
                            'state' => 'delivery',
                            'quantity' => $quantity,
                            'promo' => $promo_code,
                            'price' => $game_price_discounted,
                            'delivery_company' => $delivery_type,
                            'delivery_price' => $delivery_price,
                            'summ' => $price_total+$delivery_price,

                            'street' => $street,
                            'house' => $dom,
                            'corpus' => $korpus,
                            'room' => $kvartira,
                        );
                        $everything_ok = true;
                    }
                }
                else{
                    $info_to_add = array(
                        'order_date' => time(),
                        'quantity' => $quantity,
                        'promo' => $promo_code,
                        'price' => $game_price_discounted,
                        'delivery_company' => 'Самовывоз',
                        'delivery_price' => '0',
                        'summ' => $price_total,
                        'state' => 'delivery',
                        //'paid_nal' => '1',
                    );
                    $everything_ok = true;
                }

                if($everything_ok){
                    // update row
                    $line_to_update = $rows[0]->line_id;
                    $result = $wpdb->update($wpdb->prefix."fx_orders_data", $info_to_add, array('line_id'=>$rows[0]->line_id));

                    $rows = $wpdb->get_results("SELECT * from ".$wpdb->prefix."fx_orders_data where line_id='$line_to_update' LIMIT 1");

                    if($info_to_add['delivery_company'] == 'rus_post_nal'){
                        // send da mail
                        fx_send_aviso_mail(array(
                            'order_id' => $rows[0]->line_id,
                            'date' => date('d.m.Y H:i:s'),
                            'name' => $rows[0]->adresat,
                            'email' => $rows[0]->email,
                            'phone' => $rows[0]->teladdress,
                            'quantity' => $rows[0]->quantity,
                            'delivery_type' => delivery_string_decode($rows[0]->delivery_company),
                            'address' => $info_to_add['indexto'].', '.$info_to_add['country'].', '.$info_to_add['region'].', '.$info_to_add['city'].', улица '.$info_to_add['street'].', дом '.$info_to_add['house'].', корпус '.$info_to_add['corpus'].', квартира '.$info_to_add['room'],
                            'promo' => $rows[0]->promo,
                            'summ' => $rows[0]->summ,
                            'inv' => $rows[0]->inv,
                        ), get_option('admin_email' , "fx3201@yandex.ru"), 'Оформлен новый заказ (наложенный платеж)', 'Только что был оформлен новый заказ с доставкой наложенным платежом.', '');

                        $mail_text = page_formatted('mail-delivery-post-nal')->post_content;
                        fx_send_aviso_mail(array(
                            'order_id' => $rows[0]->line_id,
                            'date' => date('d.m.Y H:i:s'),
                            'name' => $rows[0]->adresat,
                            'quantity' => $rows[0]->quantity,
                            'delivery_type' => delivery_string_decode($rows[0]->delivery_company),
                            'address' => $info_to_add['indexto'].', '.$info_to_add['country'].', '.$info_to_add['region'].', '.$info_to_add['city'].', улица '.$info_to_add['street'].', дом '.$info_to_add['house'].', корпус '.$info_to_add['corpus'].', квартира '.$info_to_add['room'],
                            'summ' => $rows[0]->summ,
                            //'inv' => $rows[0]->inv,
                        ), $rows[0]->email, 'Like Game - Ваш заказ успешно оформлен', $mail_text, "<p>Рустам Зарипов,<br>Аяз Шабутдинов,<br>Алексей Нечаев,<br>Like Game Team<br><br><a href='http://likegame.biz'>www.likegame.biz</a><br><a href='vk.com/biznes.igra'>vk.com/biznes.igra</a><br></p>");

                        header('Location: /delivery/rpn-order-ok');
                    }
                    else {
                        header('Location: /payment?cid=' . $user_id . '&oid=' . $line_to_update);
                    }
                    exit;
                }

                //something wrong
                $display_delivery_form = true;
                $delivery_error = true;
            }elseif($rows[0]->state == 'delivery') {
                // go to payment
                header('Location: /payment/?cid='.$user_id.'&oid='.$order_id);
                exit();
            }else{
                // go to personal
                header('Location: /delivery');
                exit();
            }
        }else{
            //something went wrong
            header('Location: /delivery');
            exit();
        }

    }else{
        //no row
        header('Location: /delivery');
        exit();
    }
//        if ( row is not filled up ){
//            check the vars
//            if(ok){
//                update the row
//                go to payment
//            }else{
//                show errors and warnings
//            }
//
//        }else{
//            go to payment
//        }
}elseif(isset($_GET['cid']) && isset($_GET['oid'])){
//        so we are redirected from 1st step or got here by link
//        check the vars like in payment page.
    $user_id = preg_replace('/[^a-g0-9]+/iu', '', $_GET['cid']);
    $order_id = preg_replace('/[^0-9]+/iu', '', $_GET['oid']);

    if(strlen($user_id) == 32 && is_numeric($order_id)){
        //ok, try to get data from db
        $rows = $wpdb->get_results("SELECT * from ".$wpdb->prefix."fx_orders_data where line_id='$order_id' LIMIT 1");
        if(!empty($rows)){
            if($rows[0]->userid == $user_id){
                if($rows[0]->state == 'delivery'){
                    // go to payment
                    header('Location: /payment/?cid='.$user_id.'&oid='.$order_id);
                    exit();
                }elseif($rows[0]->state == 'personal'){
                    // show address form
                    $display_delivery_form = true;

                    // init defaults
                    if( (array_search('ems', $delivery_methods_enabled) !== false  || array_search('rus_post', $delivery_methods_enabled) !== false)
                    && ($default_delivery_method == 'ems' || $delivery_methods_enabled == 'rus_post') ){
                        $delivery_company = $default_delivery_method;
                    }else{
                        $delivery_company = 'rus_post';
                    }
                }else{
                    // go to personal form
                    header('Location: /delivery');
                    exit();
                }

            }else{
                // fallback
                header('Location: /delivery');
                exit();
            }
        }
    }
}elseif($_POST['personal_form_submitted'] == 'yes'){
    // we have hidden $_POST var (personal_form_submitted)

    // init. all ok.
    $user_surname_error = '0';
    $user_name_error = '0';
    $user_middlename_error = '0';
    $user_phone_error ='0';
    $user_email1_error='0';

    //check all personal vars
    //generate warnings
    if(strlen(preg_replace('/[^a-zа-я]+/iu', '', $_POST['user_surname'])) != strlen($_POST['user_surname'])){
        $user_surname_error = 'warning';
    }
    $user_surname = preg_replace('/[^a-zа-я]+/iu', '', $_POST['user_surname']);

    if(strlen(preg_replace('/[^a-zа-я]+/iu', '', $_POST['user_name'])) != strlen($_POST['user_name'])){
        $user_name_error = 'warning';
    }
    $user_name = preg_replace('/[^a-zа-я]+/iu', '', $_POST['user_name']);

    if(strlen(preg_replace('/[^a-zа-я]+/iu', '', $_POST['user_middlename'])) != strlen($_POST['user_middlename'])){
        $user_middlename_error = 'warning';
    }
    $user_middlename = preg_replace('/[^a-zа-я]+/iu', '', $_POST['user_middlename']);

    if(validate_fields('phone', $_POST['user_phone']) == ''){
        $user_phone_error = 'warning';
    }
    $user_phone = validate_fields('phone', $_POST['user_phone']);

    if(validate_fields('email', $_POST['user_email']) == ''){
        $user_email1_error = 'error';
    }
    $user_email1 = preg_replace('/[^a-z0-9 ._\-@]+/iu', '', $_POST['user_email']);

    //generate errors
    if($user_surname == '') $user_surname_error = 'error';
    if($user_name == '') $user_name_error = 'error';
    if($user_middlename == '') $user_middlename_error = 'error';
    if($user_phone == '') $user_phone_error ='error';
    if($user_email1 == '') $user_email1_error='error';

    //if ok
    if($user_name_error == '0'
        && $user_phone_error == '0'
        && $user_email1_error == '0'
        && $user_middlename_error == '0'
        && $user_surname_error == '0'
    ){
//            try to find the unfilled row with that userid (email not filled up)
//                update the row. update everything (date too!)
//            else
//                insert new row
        if(check_user_id_cookie()){
            $user_id = $_COOKIE['user_id'];
        }else{
            $user_id = generate_user_id();
        }

        $info_to_add = array(
            'userid' => $user_id,
            'teladdress' => '+'.$user_phone,
            'email' => $user_email1,
            'order_date' => time(),
            'adresat' => $user_surname. ' '.$user_name.' '.$user_middlename,
            'state' => 'personal',
        );

        $rows = $wpdb->get_results("SELECT * from ".$wpdb->prefix."fx_orders_data where userid='$user_id' AND state='new' LIMIT 1");
        if(!empty($rows)){
            $line_to_update = $rows[0]->line_id;
            $result = $wpdb->update($wpdb->prefix."fx_orders_data", $info_to_add, array('line_id'=>$rows[0]->line_id));
        }else{
            $wpdb->insert($wpdb->prefix."fx_orders_data", $info_to_add);
            $line_to_update = $wpdb->insert_id;
        }

        //redirect
        header('Location: /delivery?cid='.$user_id.'&oid='.$line_to_update);
        exit();
    }else{
        $display_pers_form = true;
        $personal_error = true;
    }

//        else
//            show warnings and errors
//
}else{
    //show personal form, and check if need to create new row
    if(isset($_POST['user_phone_land']) && !empty($_POST['user_phone_land'])){
        $user_phone = validate_fields('phone', $_POST['user_phone_land']);
    }
    if(isset($_POST['user_name_land']) && !empty($_POST['user_name_land'])) {
        $user_name = preg_replace('/[^а-яa-z ]+/iu', '', $_POST['user_name_land']);
    }

    // TODO if id is in db, then get values from db and fill the form

    //add that to db
    if(!empty($user_name) && !empty($user_phone)){
        //generate ID

        /*        if(check_user_id_cookie()){
                    $user_id = $_COOKIE['user_id'];
                }else{*/
        $user_id = generate_user_id();
        //}

        $fx_result = $wpdb->insert($wpdb->prefix.'fx_orders_data', array(
            'adresat' => $user_name,
            'teladdress' => '+'.$user_phone,
            'userid' => $user_id,
            'order_date' => time(),
            'state' => 'new',
        ));
    }

    $display_pers_form = true;


//    4. user submitted a form on landing
//        hav 2 get vars
//        if he has cookie (userid), he was here and has submitted a form earlier
//            so, try to get the rows with that userid and phone. if exists, do not write to db;
//        else{
//            insert new row
//        }
//
//    5. FALLBACK: user clicked a link on landing
//        do nothing, just show the personal form
}

$custom = get_post_custom();

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
                <h1 class="delivery_header page_header"><?php the_title() ?></h1>
            </div>
            <div class="clearfix"></div>
        </div>
        <form id="delivery_form" action="/delivery" method="post">
            <div class="row">
                <div class="col-md-offset-1 col-md-10">
                    <?php if($display_pers_form): ?>
                        <input type="hidden" name="personal_form_submitted" value="yes">
                        <h2 class="delivery_header"><?php echo $custom['fx_personal_header'][0] ?></h2>
                        <div class="personal_info rounded_corner">
                            <?php if($personal_error): ?>
                                <div class="alert alert-warning alert-dismissible" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <?php
                                    $fx_error_fields_array = array();

                                    if($user_surname_error == 'error') $fx_error_fields_array[] = 'Фамилия';
                                    if($user_name_error == 'error') $fx_error_fields_array[] = 'Имя';
                                    if($user_middlename_error == 'error') $fx_error_fields_array[] = 'Отчество';

                                    if($user_phone_error == 'error') $fx_error_fields_array[] = 'Телефон';
                                    if($user_email1_error == 'error') $fx_error_fields_array[] = 'email';

                                    /*if($index_error == 'error' || $index_a_error == 'error') $fx_error_fields_array[] = 'Индекс';
                                    if($region_a_error == 'error'|| $region_error== 'error') $fx_error_fields_array[] = 'Регион';
                                    if($city_a_error == 'error'|| $city_error== 'error') $fx_error_fields_array[] = 'Город';
                                    if($street_a_error == 'error'|| $street_error== 'error') $fx_error_fields_array[] = 'Улица';
                                    if($dom_a_error == 'error'|| $dom_error== 'error') $fx_error_fields_array[] = 'Дом';*/

                                    if(!empty($fx_error_fields_array)){
                                        echo '<strong>Ошибка.</strong> Не заполнены либо введены неверные значения в следующие поля: ';
                                        echo implode(', ', $fx_error_fields_array);
                                        echo '<br>';
                                    }



                                    ?>Обратите внимание, из полей, помеченных желтым удалены недопустимые символы
                                </div>
                            <?php endif; ?>
                            <p>
                                <input type="hidden" name="order_submitted" value="yes">

                                <input class="personal_info_input <?php echo $user_surname_error ?>" type="text" required name="user_surname" placeholder="Фамилия" value="<?php echo $user_surname ?>">
                                <input class="personal_info_input  <?php echo $user_name_error ?>" type="text" required name="user_name" placeholder="Имя" value="<?php echo $user_name ?>">
                                <input class="personal_info_input  <?php echo $user_middlename_error ?>" type="text" required name="user_middlename" placeholder="Отчество" value="<?php echo $user_middlename ?>">
                            </p>
                            <p>
                                <input required class="tooltipster phone-input personal_info_input <?php echo $user_phone_error ?>"  type="text" name="user_phone" id="user_phone" placeholder="Номер телефона" value="<?php echo $user_phone ?>" title="Номер телефона в формате 79024712345">
                                <input required class="tooltipster email-input personal_info_input <?php echo $user_email1_error ?>" type="text" name="user_email" id="user_email" placeholder="e-mail" value="<?php echo $user_email1 ?>" title="Адрес электронной почты. Например: mail@yandex.ru">
                            </p>
                        </div>
                        <div class="col-md-9">

                        </div>
                        <div class="col-md-3">
                            <input type="submit" class="delivery_next" value="Далее">
                        </div>
                    <?php endif; ?>
                    <?php if($display_delivery_form): ?>
                        <script type="text/javascript">
                            function fx_goal(){
                                setTimeout(function(){
                                    try{
                                        yaCounter<?php echo get_option('fx_yametric_id', '30806466') ?>.reachGoal('delivery_address');
                                    }catch(e){
                                        fx_goal();
                                    }
                                }, 700);
                            }
                            // todo and set the cookie pls, so we don't fire goal 2 times 4 1 person
                            fx_goal();
                        </script>
                        <?php if($delivery_error): ?>
                            <div class="alert alert-warning alert-dismissible" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <?php
                                $fx_error_fields_array = array();
                                if($index_error == 'error' || $index_a_error == 'error') $fx_error_fields_array[] = 'Индекс';
                                if($region_a_error == 'error'|| $region_error== 'error') $fx_error_fields_array[] = 'Регион';
                                if($city_a_error == 'error'|| $city_error== 'error') $fx_error_fields_array[] = 'Город';
                                if($street_a_error == 'error'|| $street_error== 'error') $fx_error_fields_array[] = 'Улица';
                                if($dom_a_error == 'error'|| $dom_error== 'error') $fx_error_fields_array[] = 'Дом';

                                if(!empty($fx_error_fields_array)){
                                    echo '<strong>Ошибка.</strong> Не заполнены либо введены неверные значения в следующие поля: ';
                                    echo implode(', ', $fx_error_fields_array);
                                    echo '<br>';
                                }



                                ?>Обратите внимание, из полей, помеченных желтым удалены недопустимые символы
                            </div>
                        <?php endif; ?>
                        <input type="hidden" name="fx_nal_pay_percent" id="fx_nal_pay_percent" value="<?php echo get_option('fx_nal_pay_percent', '30') ?>">
                        <input type="hidden" name="address_form_submitted" value="yes">
                        <input type="hidden" name="user_id" value="<?php echo $user_id ?>">
                        <input type="hidden" name="order_id" value="<?php echo $order_id ?>">
                        <input type="hidden" id="courier_delivery_price" name="courier_delivery_price" value="<?php echo get_option('fx_courier_delivery_price') ?>">
                        <h2 class="delivery_header"><?php echo $custom['fx_address_header'][0] ?></h2>
                        <p>
                            Количество игр:
                            <select name="quantity" id="quantity_input">
                                <?php
                                $quantity_array = array(
                                    '1 коробка',
                                    '2 коробки',
                                    '3 коробки',
                                    '4 коробки',
                                    '5 коробок',
                                    '6 коробок',
                                    '7 коробок',
                                    '8 коробок',
                                    '9 коробок',
                                    '10 коробок',
                                );
                                $fxi = 1;
                                foreach($quantity_array as $fx_item){
                                    echo '<option ';
                                    if($quantity == $fxi) echo 'selected="selected"';
                                    echo ' value="'.$fxi.'">'.$fx_item.'</option>';

                                    $fxi++;
                                }
                                ?>
                            </select>
                        </p>
                        <p>Тип доставки:</p>
                        <p>
                            <?php
                            if(!isset($delivery_type) || $delivery_type == '') $delivery_type = $default_delivery_method;

                            if(array_search('self', $delivery_methods_enabled) !== false || empty($delivery_methods_enabled)){
                                echo '<input type="radio" class="delivery_type" name="delivery_type" value="self" id="delivery_self" ';
                                if($delivery_type=='self') echo ' checked="checked" ';
                                echo '><label for="delivery_self">Самовывоз: ';
                                echo get_option('fx_self_delivery_address', 'г.Пермь, ул. Мира 45а оф. 604');
                                echo '</label><br>';
                            }
                            if(array_search('courier', $delivery_methods_enabled) !== false || empty($delivery_methods_enabled)) {
                                echo '<input type="radio" class="delivery_type" name="delivery_type" value="courier" id="delivery_courier" ';
                                if ($delivery_type == 'courier') echo ' checked="checked" ';
                                echo '><label id="" for="delivery_courier">Доставка по городу курьером (только ';
                                echo get_option('fx_courier_delivery_city', 'Пермь');
                                echo ')</label><br>';
                            }
                            if(array_search('rus_post', $delivery_methods_enabled) !== false
                            || array_search('ems', $delivery_methods_enabled) !== false
                            || empty($delivery_methods_enabled)){
                                echo '<input type="radio" class="delivery_type" name="delivery_type" value="post" id="delivery_post" ';
                                if($delivery_type=='post' || $delivery_type == 'rus_post' || $delivery_type == 'ems' ) echo ' checked="checked" ';
                                echo '><label for="delivery_post">Доставка почтой, по предоплате</label><br>';
                            }
                            if(array_search('rus_post_nal', $delivery_methods_enabled) !== false || empty($delivery_methods_enabled)) {
                                echo '<input type="radio" class="delivery_type" name="delivery_type" value="rus_post_nal" id="delivery_rus_post_nal" ';
                                if ($delivery_type == 'rus_post_nal') echo ' checked="checked" ';
                                echo '><label id="" for="delivery_rus_post_nal">Доставка почтой России, оплата наложенным платежом '.$custom['fx_nal_text'][0].' </label><br>';
                                //echo '<span id="post_nal_tooltip">При доставке с наложенным платежом вам необходимо оплатить только стоимость доставки.</span><br>';
                            }
                            ?>

                        </p>
                    <?php endif; ?>
                </div>
            </div>
            <?php if($display_delivery_form): ?>
                <div class="row" id="post_delivery_block">
                    <div class="col-md-offset-1 col-md-3">
                        <div class="rounded_corner">
                            <input type="hidden" id="country_holder" name="country_holder" value="<?php echo $country ?>">
                            <div id="country_reg_city_inputs">
                                <select name="country" id="countries" class="address_input">
                                    <option value="RU">РОССИЯ</option><option value="AU">АВСТРАЛИЯ</option><option value="AT">АВСТРИЯ</option><option value="AZ">АЗЕРБАЙДЖАН</option><option value="AL">АЛБАНИЯ</option><option value="DZ">АЛЖИР</option><option value="AI">АНГИЛЬЯ</option><option value="AO">АНГОЛА</option><option value="AG">АНТИГУА И БАРБУДА</option><option value="AR">АРГЕНТИНА</option><option value="AM">АРМЕНИЯ</option><option value="AW">АРУБА</option><option value="AF">АФГАНИСТАН</option><option value="BS">БАГАМСКИЕ О-ВА</option><option value="BD">БАНГЛАДЕШ</option><option value="BB">БАРБАДОС</option><option value="BH">БАХРЕЙН</option><option value="BY">БЕЛАРУСЬ</option><option value="BZ">БЕЛИЗ</option><option value="BE">БЕЛЬГИЯ</option><option value="BJ">БЕНИН</option><option value="BM">БЕРМУДСКИЕ О-ВА</option><option value="BG">БОЛГАРИЯ</option><option value="BO">БОЛИВИЯ</option><option value="BA">БОСНИЯ И ГЕРЦЕГОВИНА</option><option value="BW">БОТСВАНА</option><option value="BR">БРАЗИЛИЯ</option><option value="BN">БРУНЕЙ-ДАРУССАЛАМ</option><option value="BF">БУРКИНА-ФАСО</option><option value="BI">БУРУНДИ</option><option value="BT">БУТАН</option><option value="VU">ВАНУАТУ</option><option value="GB">ВЕЛИКОБРИТАНИЯ</option><option value="HU">ВЕНГРИЯ</option><option value="VE">ВЕНЕСУЭЛА</option><option value="VN">ВЬЕТНАМ</option><option value="GA">ГАБОН</option><option value="HT">ГАИТИ</option><option value="GY">ГАЙАНА</option><option value="GM">ГАМБИЯ</option><option value="GH">ГАНА</option><option value="GT">ГВАТЕМАЛА</option><option value="GN">ГВИНЕЯ</option><option value="DE">ГЕРМАНИЯ</option><option value="GI">ГИБРАЛТАР</option><option value="HN">ГОНДУРАС</option><option value="HK">ГОНКОНГ</option><option value="GD">ГРЕНАДА</option><option value="GR">ГРЕЦИЯ</option><option value="GE">ГРУЗИЯ</option><option value="DK">ДАНИЯ</option><option value="CD">ДЕМОКРАТИЧЕСКАЯ РЕСПУБЛИКА КОНГО</option><option value="DJ">ДЖИБУТИ</option><option value="DM">ДОМИНИКА</option><option value="DO">ДОМИНИКАНСКАЯ РЕСПУБЛИКА</option><option value="EG">ЕГИПЕТ</option><option value="ZM">ЗАМБИЯ</option><option value="ZW">ЗИМБАБВЕ</option><option value="IL">ИЗРАИЛЬ</option><option value="IN">ИНДИЯ</option><option value="ID">ИНДОНЕЗИЯ</option><option value="JO">ИОРДАНИЯ</option><option value="IQ">ИРАК</option><option value="IR">ИРАН</option><option value="IE">ИРЛАНДИЯ</option><option value="IS">ИСЛАНДИЯ</option><option value="ES">ИСПАНИЯ</option><option value="IT">ИТАЛИЯ</option><option value="YE">ЙЕМЕН</option><option value="KZ">КАЗАХСТАН</option><option value="KY">КАЙМАНОВЫ О-ВА</option><option value="KH">КАМБОДЖА</option><option value="CM">КАМЕРУН</option><option value="CA">КАНАДА</option><option value="KE">КЕНИЯ</option><option value="CY">КИПР</option><option value="CN">КИТАЙ</option><option value="CO">КОЛУМБИЯ</option><option value="CG">КОНГО-БРАЗЗАВИЛЬ</option><option value="KR">КОРЕЯ</option><option value="CR">КОСТА-РИКА</option><option value="CI">КОТ-Д'ИВУАР</option><option value="CU">КУБА</option><option value="KW">КУВЕЙТ</option><option value="KG">КЫРГЫЗСТАН</option><option value="CW">КЮРАСАО</option><option value="LA">ЛАОС</option><option value="LV">ЛАТВИЯ</option><option value="LS">ЛЕСОТО</option><option value="LR">ЛИБЕРИЯ</option><option value="LB">ЛИВАН</option><option value="LT">ЛИТВА</option><option value="LU">ЛЮКСЕМБУРГ</option><option value="MU">МАВРИКИЙ</option><option value="MR">МАВРИТАНИЯ</option><option value="MG">МАДАГАСКАР</option><option value="MO">МАКАО</option><option value="MK">МАКЕДОНИЯ</option><option value="MW">МАЛАВИ</option><option value="MY">МАЛАЙЗИЯ</option><option value="ML">МАЛИ</option><option value="MV">МАЛЬДИВЫ</option><option value="MT">МАЛЬТА</option><option value="MA">МАРОККО</option><option value="MX">МЕКСИКА</option><option value="MZ">МОЗАМБИК</option><option value="MD">МОЛДОВА</option><option value="MN">МОНГОЛИЯ</option><option value="MM">МЬЯНМА</option><option value="NA">НАМИБИЯ</option><option value="NP">НЕПАЛ</option><option value="NE">НИГЕР</option><option value="NG">НИГЕРИЯ</option><option value="NL">НИДЕРЛАНДЫ</option><option value="NI">НИКАРАГУА</option><option value="NZ">НОВАЯ ЗЕЛАНДИЯ</option><option value="NC">НОВАЯ КАЛЕДОНИЯ</option><option value="NO">НОРВЕГИЯ</option><option value="AE">ОАЭ</option><option value="OM">ОМАН</option><option value="PK">ПАКИСТАН</option><option value="PA">ПАНАМА</option><option value="PG">ПАПУА - НОВАЯ ГВИНЕЯ</option><option value="PY">ПАРАГВАЙ</option><option value="PE">ПЕРУ</option><option value="PL">ПОЛЬША</option><option value="PT">ПОРТУГАЛИЯ</option><option value="RW">РУАНДА</option><option value="RO">РУМЫНИЯ</option><option value="SV">САЛЬВАДОР</option><option value="ST">САН-ТОМЕ И ПРИНСИПИ</option><option value="SA">САУДОВСКАЯ АРАВИЯ</option><option value="SC">СЕЙШЕЛЬСКИЕ О-ВА</option><option value="SN">СЕНЕГАЛ</option><option value="VC">СЕНТ-ВИНСЕНТ И ГРЕНАДИНЫ</option><option value="KN">СЕНТ-КИТС И НЕВИС</option><option value="LC">СЕНТ-ЛЮСИЯ</option><option value="RS">СЕРБИЯ</option><option value="SG">СИНГАПУР</option><option value="SY">СИРИЯ</option><option value="SK">СЛОВАКИЯ</option><option value="SI">СЛОВЕНИЯ</option><option value="SB">СОЛОМОНОВЫ О-ВА</option><option value="SD">СУДАН</option><option value="SR">СУРИНАМ</option><option value="US">США</option><option value="TJ">ТАДЖИКИСТАН</option><option value="TH">ТАИЛАНД</option><option value="TZ">ТАНЗАНИЯ</option><option value="TC">ТЕРКС И КАЙКОС</option><option value="TG">ТОГО</option><option value="TT">ТРИНИДАД И ТОБАГО</option><option value="TN">ТУНИС</option><option value="TM">ТУРКМЕНИСТАН</option><option value="TR">ТУРЦИЯ</option><option value="UG">УГАНДА</option><option value="UZ">УЗБЕКИСТАН</option><option value="UA">УКРАИНА</option><option value="UY">УРУГВАЙ</option><option value="FJ">ФИДЖИ</option><option value="PH">ФИЛИППИНЫ</option><option value="FI">ФИНЛЯНДИЯ (ВКЛЮЧАЯ АЛАНДСКИЕ О-ВА)</option><option value="FR">ФРАНЦИЯ</option><option value="HR">ХОРВАТИЯ</option><option value="CF">ЦЕНТРАЛЬНАЯ АФРИКАНСКАЯ РЕСПУБЛИКА</option><option value="TD">ЧАД</option><option value="ME">ЧЕРНОГОРИЯ</option><option value="CZ">ЧЕХИЯ</option><option value="CL">ЧИЛИ</option><option value="CH">ШВЕЙЦАРИЯ</option><option value="SE">ШВЕЦИЯ</option><option value="LK">ШРИ-ЛАНКА</option><option value="EC">ЭКВАДОР</option><option value="GQ">ЭКВАТОРИАЛЬНАЯ ГВИНЕЯ</option><option value="ER">ЭРИТРЕЯ</option><option value="EE">ЭСТОНИЯ</option><option value="ET">ЭФИОПИЯ</option><option value="ZA">ЮЖНАЯ АФРИКА</option><option value="JM">ЯМАЙКА</option><option value="JP">ЯПОНИЯ</option><option value="PF">ФРАНЦУЗСКАЯ ПОЛИНЕЗИЯ</option>
                                </select>
                                <input id="index" type="text" name="index" class="address_input 6_digits <?php echo $index_error ?>" placeholder="Индекс (6 цифр)" value="<?php echo $index ?>">
                                <input type="hidden" id="region_holder" name="region_holder" value="<?php echo $region_holder ?>">
                                <input name="region" id="regions" class="address_input <?php echo $region_error ?>" placeholder="Регион/область" value="<?php echo $region ?>">
                                <input type="hidden" id="city_holder" name="city_holder" value="<?php echo $city_holder ?>">
                                <input name="city" id="cities" class="address_input  <?php echo $city_error ?>" placeholder="Город" value="<?php echo $city ?>">
                            </div>
                            <input id="street" type="text" name="street" class="address_input street-input <?php echo $street_error ?>" placeholder="Улица" value="<?php echo $street ?>">
                            <input id="dom" type="text" name="dom" class="address_input mask_number_only <?php echo $dom_error ?>"  placeholder="Дом" value="<?php echo $dom ?>">
                            <input id="korpus" type="text" name="korpus" class="address_input <?php echo $korpus_error ?>" placeholder="Корпус" value="<?php echo $korpus ?>">
                            <input id="kvartira" type="text" name="kvartira" class="address_input mask_number_only <?php echo $kvartira_error ?>" placeholder="Квартира" value="<?php echo $kvartira ?>">

                        </div>
                    </div>
                    <div class="col-md-7">
                        <div class="rounded_corner delivery_company_wrap">
                            <input type="hidden" value="<?php echo $delivery_company ?>" name="delivery_company" id="delivery_company_input">
                            <?php if(array_search('rus_post', $delivery_methods_enabled) !== false): ?>
                            <div id="delivery_company_rus_post" class="delivery_company <?php if($delivery_company == 'rus_post') echo 'company_selected' ?>" data-value="rus_post">
                                <img class="alignleft" src="<?php bloginfo('template_directory') ?>/images/logo2.jpg"><p class="yellow"><?php echo $custom['fx_ruspost_header'][0] ?></p>
                                <p class=""><?php echo $custom['fx_ruspost_text'][0] ?></p>
                                <div class="clearfix"></div>
                            </div>
                            <?php endif; ?>
                            <?php if(array_search('ems', $delivery_methods_enabled) !== false): ?>
                            <div class="delivery_company <?php if($delivery_company == 'ems') echo 'company_selected' ?>" id="delivery_company_ems" data-value="ems">
                                <img class="alignleft" src="<?php bloginfo('template_directory') ?>/images/logo3.jpg"><p class="yellow"><?php echo $custom['fx_ems_header'][0] ?></p>
                                <p class=""><?php echo $custom['fx_ems_text'][0] ?></p>
                                <div class="clearfix"></div>
                            </div>
                            <?php endif; ?>
                            <!--<table class="delivery_company">
                            <tr id="delivery_company_rus_post_wrap">
                                <td class="dlvr_radio">
                                    <input type="radio" class="delivery_company" name="delivery_company" value="rus_post" id="delivery_company_rus_post">
                                </td>
                                <td class="dlvr_text">
                                    <label id="" for="delivery_company_rus_post">
                                        <img class="alignleft" src="<?php bloginfo('template_directory') ?>/images/logo2.jpg"><p class="yellow">Доставка только по России</p>
                                        <p class="">ФГУП Почты России доставка до отделения почтовой связи от з до 10 дней</p>
                                    </label><br>
                                </td>
                            </tr>
                            <tr>
                                <td class="dlvr_radio">
                                    <input type="radio" class="delivery_company" name="delivery_company" value="ems" id="delivery_company_ems">
                                </td>
                                <td class="dlvr_text">
                                    <label id="" for="delivery_company_ems">
                                        <img class="alignleft" src="<?php bloginfo('template_directory') ?>/images/logo3.jpg"><p class="yellow">Доставка по России и в другие страны</p>
                                        <p class="">EMS rp - экспресс доставка до адреса получателя курьером от 2 до 7 дней</p>
                                    </label><br>
                                </td>
                            </tr>
                        </table>-->
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="row">
                    <div class="col-md-offset-1 col-md-3">
                        <div class="delivery_summary">
                            <p>Сумма по игре: <span id="game_summ"><?php echo get_option('fx_game_price'); ?></span> рублей</p>
                            <input type="hidden" name="game_price" id="game_price" value="<?php echo get_option('fx_game_price'); ?>">
                            <p>Доставка: <span id="delivery_summ">0</span> рублей</p>
                            <p>Итого: <span id="full_summ">0</span> рублей</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <input type="hidden" name="discount_perc" id="discount_perc" value="<?php echo get_promo_discount($promo_code) ?>">
                        <input type="text" class="promo_code_input" name="promo_code" value="<?php echo $promo_code ?>" placeholder="Промо код (если есть)"><span id="promo_code_msg"></span>
                    </div>
                    <div class="col-md-3">
                        <input type="submit" class="delivery_next" value="Далее">
                    </div>
                </div>
            <?php endif; ?>
        </form>
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

<script type="text/javascript" src="<?php bloginfo('template_directory') ?>/js/delivery.js?v=1.1"></script>

<?php wp_footer() ?>
</body>

