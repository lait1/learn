<?php /* Template Name: Оформление заказа */
$custom = get_post_custom();
// Ловим с главной имя и почту
if(!empty($_POST['user_name_land'])){
	if(strlen(preg_replace('/[^a-zа-я]+/iu', '', $_POST['user_name_land'])) != strlen($_POST['user_name_land'])){
	    $user_name_error = 'Вы не ввели имя или ввели его не верно, попробуйте ещё раз.';
	     header('Location: /?user_name_error='.$user_name_error);
	}
	$user_name = preg_replace('/[^a-zа-я]+/iu', '', $_POST['user_name_land']);

	if(validate_fields('email', $_POST['user_email']) == ''){
	    $user_email_error = 'Вы не ввели email или ввели его не правильно, попробуйте ещё раз.';
	    header('Location: /?user_email_error='.$user_email_error);
	}
	$user_email = preg_replace('/[^a-z0-9 ._\-@]+/iu', '', $_POST['user_email']);

	// Устанавливаем идентификатор пользователя в куки
	if(check_user_id_cookie()){
	        $user_id = $_COOKIE['user_id'];
	    }else{
	        $user_id = generate_user_id();
	   }
	// Добавляем в базу полученные с главной данные
	$info_to_add = array(
	        'userid' => $user_id,
	        'adresat' => $user_name,
	        'email' => $user_email,
	        'order_date' => time(),
	        'state' => 'new',
	    );
	$wpdb->insert($wpdb->prefix."fx_orders_data", $info_to_add);

	header('Location: /delivery/?cid='.$user_id.'&oid='.$wpdb->insert_id);
	die();
};


// хня какая то, надо убрать но боюсь
$delivery_methods_enabled = json_decode(get_option('fx_delivery_methods_enabled'), true);
if($delivery_methods_enabled == null) $delivery_methods_enabled = array();
$default_delivery_method = get_option('fx_default_delivery_method');
$delivery_company = $default_delivery_method;
// Прнимаем идентификатор пользователя
$user_id = $_REQUEST['cid'];
$order_id = $_REQUEST['oid'];

// Проверяем данных на валидность
fx_check_order_vars($user_id, $order_id);


// ВычислениЯ
// Количество(пишем в базу)
$quantity = validate_fields('number', $_POST['quantity']);
if (!is_numeric($quantity)) $quantity = 1;

// Название промо кода(пишем в базу)
$promo_code = validate_fields('promo', $_POST['promo_code']);

// Скидка в %
$discount = 0;
if($promo_code != ''){
    $discount = get_promo_discount($promo_code); 
}

// Цена доставки (пишем в базу)	
$delivery_price = 0;

//Проверка на гика или дал..ба, тип доставкис(пишем в базу)
  if ($_POST['delivery_type'] == 'post') {
    $delivery_type = $_POST['delivery_company'];
}
elseif ($_POST['delivery_type'] == 'courier') {
    $delivery_type = 'courier';
    $delivery_price = $custom['fx_curier_prise'][0]; // цена доставки курьером
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


// Стоимость 1 игры             
$game_price = get_option('fx_game_price', '2900'); 

//Стоимость игры со скидкой(пишем в базу)
$game_price_discounted = round($game_price-$game_price*$discount/100);

// Полная стоимость, пишем в базу
$price_total = round($game_price_discounted*$quantity);

// Добавление в базу данных о доставке, количестве товара и стоимости

if(!empty($_POST['delivery_form_action'])){
	 $info_to_update = array(
                    'order_date' => time(),
                    'state' => 'delivery',
                    'quantity' => $quantity,
                    'promo' => $promo_code,
                    'price' => $game_price_discounted,
                    'delivery_company' => $delivery_type,
                    'delivery_price' => $delivery_price,
                    'summ' => $price_total+$delivery_price,
                );
$result = $wpdb->update($wpdb->prefix."fx_orders_data", $info_to_update, array('line_id'=>$order_id));
header('Location: /payment/?cid='.$user_id.'&oid='.$order_id);
die();
}
get_header(); 
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
                <h1 class="delivery_header page_header"><?php the_title() ?></h1>
            </div>
            <div class="clearfix"></div>
        </div>
    <form id="delivery_form" action="/delivery" method="post">
    <input type="hidden" name='delivery_form_action' value='Y'>
    <input type="hidden" name='oid' value='<?php echo $order_id ?>'>
    <input type="hidden" name='cid' value='<?php echo $user_id ?>'>
        <div class="row wrap_broad">
        	<div class="col-md-3 wrap_delivery action">
        		<div class="circle">1</div>
        		<div class="delivery_text">Способ доставки</div>
        		<div class="clearfix"></div>
        	</div>
        	<div class="col-md-3 wrap_delivery">
        		<div class="circle">2</div>
        		<div class="delivery_text">Способ оплаты</div>
        		<div class="clearfix"></div>
        	</div>
        	<div class="col-md-3 wrap_delivery">
        		<div class="circle">3</div>
        		<div class="delivery_text">Данные получателя </div>
        		<div class="clearfix"></div>
        	</div>
        	<div class="col-md-3 wrap_delivery">
        		<div class="circle">4</div>
        		<div class="delivery_text">Подтверждение </div>
        		<div class="clearfix"></div>
        	</div>
        </div>
        
        <div class="row">
        	<div class="col-md-6 col-md-offset-6">
<!-- 	        	<input id="quantity_input" name="quantity" value="1" >
	 			<label for="quantity_input">2900</label> -->
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
        	</div>
        </div>
        <div class="row">
        	<div class="col-md-12">
	        	<div class="wrap_deli">
	        		<h3>Способ доставки</h3>
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
                        echo '><label for="delivery_post">Доставка почтой EMS(Нуждается в дороботке, не нажимать)</label><br>';
                    }
                    if(array_search('rus_post_nal', $delivery_methods_enabled) !== false || empty($delivery_methods_enabled)) {
                        echo '<input type="radio" class="delivery_type" name="delivery_type" value="rus_post_nal" id="delivery_rus_post_nal" ';
                        if ($delivery_type == 'rus_post_nal') echo ' checked="checked" ';
                        echo '><label id="" for="delivery_rus_post_nal">Доставка почтой России, оплата наложенным платежом </label><br>';
                        //echo '<span id="post_nal_tooltip">При доставке с наложенным платежом вам необходимо оплатить только стоимость доставки.</span><br>';
                    }
                    ?>
	            </div>
                <div class="price_list_deli">
                	<div class="price_item">+ 0 рублей</div>
	        		<div class="price_item">+ <span class="price_item_block"><?php echo $custom['fx_curier_prise'][0] ?></span> рублей</div>
	        		<div class="price_item">Зависит от региона доставки</div>
	        		<div class="price_item">+ 0 рублей</div>
                </div>
        	</div>

        	<div class="col-md-6"></div>
        </div>
        <div class="row" id="post_delivery_block">
      
                    <div class="col-md-12">
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
        </div>
    </div>
</div>
</form>
<script type="text/javascript" src="<?php bloginfo('template_directory') ?>/js/delivery.js?v=1.1"></script>
<script>
 // $(function() {
 //    $( "#quantity_input" ).spinner({
 //      spin: function( event, ui ) {
 //        if ( ui.value > 10 ) {
 //          $( this ).spinner( "value", 1 );
 //          return false;
 //        } else if ( ui.value < 1 ) {
 //          $( this ).spinner( "value", 10 );
 //          return false;
 //        }
                
 //      },
 //      stop: function( event, ui ) {
 //        	check_fields();
 //        }

 //    });
 //  });
  </script>
<?php wp_footer() ?>
</body>
