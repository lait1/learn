<?php /* Template Name: Персональные данные */
$custom = get_post_custom();

$user_id = preg_replace('/[^a-g0-9]+/iu', '', $_REQUEST['cid']);
$order_id = preg_replace('/[^0-9]+/iu', '', $_REQUEST['oid']);

// Проверяем данных на валидность
fx_check_order_vars($user_id, $order_id);

//Достаем из базы необходимую информацию
$rows = $wpdb->get_results("SELECT * from ".$wpdb->prefix."fx_orders_data where line_id='$order_id' LIMIT 1");
$delivery_type = $rows[0]->delivery_company;
$payment = $rows[0]->payment;
$adresat = $rows[0]->adresat;
$email = $rows[0]->email;

// Супер большой кусок проверки данных  
$index_error = '0';
$region_error = '0';
$city_error = '0';
$street_error = '0';
$dom_error = '0';
$korpus_error = '0';
$kvartira_error = '0';

if($delivery_type == 'ems' || $delivery_type == 'rus_post'|| $delivery_type == 'rus_post_nal'){

		$country = validate_fields('text', $_POST['country']);

    	if($country == '') $country = 'RU'; //set RU if wrong (hacked?)

        if($country == 'RU'){
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

    $region_holder = preg_replace('/[^a-z0-9\-]+/iu', '', $_POST['region_holder']);
    $city_holder = preg_replace('/[^a-z0-9\-]+/iu', '', $_POST['city_holder']);

    $index = preg_replace('/[^a-zа-я0-9\- ]+/iu', '', $_POST['index']);
    $region = preg_replace('/[^a-zа-я0-9\- ]+/iu', '', $_POST['region']); // has '-' in ID
    $city = preg_replace('/[^a-zа-я0-9\- ]+/iu', '', $_POST['city']); //the same
    $street = preg_replace('/[^а-я0-9\- ]+/iu', '', $_POST['street']);
    $dom = preg_replace('/[^a-zа-я0-9\- \/]+/iu', '',  $_POST['dom']);
    $korpus = preg_replace('/[^а-я0-9\- ]+/iu', '', $_POST['korpus']);
    $kvartira = preg_replace('/[^a-zа-я0-9\- \/]+/iu', '',  $_POST['kvartira']);




 if(isset($user_id) && isset($order_id)){
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
    <form id="payment_form" action="/payment" method="post">
    <input type="hidden" name='payment_form_action' value='Y'>
    <input type="hidden" name='oid' value='<?php echo $order_id ?>'>
    <input type="hidden" name='cid' value='<?php echo $user_id ?>'>
        <div class="row wrap_broad">
        	<div class="col-md-3 wrap_delivery ">
        		<div class="circle">1</div>
        		<div class="delivery_text">Способ доставки</div>
        		<div class="clearfix"></div>
        	</div>
        	<div class="col-md-3 wrap_delivery ">
        		<div class="circle">2</div>
        		<div class="delivery_text">Способ оплаты</div>
        		<div class="clearfix"></div>
        	</div>
        	<div class="col-md-3 wrap_delivery action">
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
        	<div class="col-md-12">
		        <div class="div-personal-types">
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
		        </div>
	        </div>
        </div>
        <div class="row" id="post_delivery_block">
            <div class="col-md-offset-3 col-md-5">
                <div class="rounded_corner">
                	<!-- Имя показываем всем без исключения -->
                		<input class="address_input" name="user_name" value="<?php echo $adresat ?>" type="text" placeholder="Имя">
					<!-- Фамилию показываем только тем кто заказывает почтой -->
		            <?php if($delivery_type == 'ems' || $delivery_type == 'rus_post'|| $delivery_type == 'rus_post_nal'): ?>
			            <input class="address_input" name="user_surname" value="" type="text" placeholder="Фамилия">
				        <input class="address_input" name="user_middlename" value="" type="text" placeholder="Отчество">
			       	<?php endif; ?>
					<!-- Почту и телефон показываем всем -->
	   	                <input class="address_input" name="user_email" value="<?php echo $email ?>" type="text" placeholder="Email">
				  		<input class="address_input" name="user_phone" value="" type="text" placeholder="Телефон">
					<!-- Если почта то показывем -->
				<?php if($delivery_type == 'ems' || $delivery_type == 'rus_post'|| $delivery_type == 'rus_post_nal'): ?>
                <div id="country_reg_city_inputs">
					<!-- Если выбрана почта россии мы не оставляем выбора -->
                	<?php if($delivery_type == 'rus_post'|| $delivery_type == 'rus_post_nal'){ ?>
                	<input type="hidden" name="country" class="address_input 6_digits" value="RU" disabled="disabled" placeholder="РОССИЯ">
					<?php }else{ ?>
                    <select name="country" id="countries" class="address_input">
                        <option value="RU">РОССИЯ</option><option value="AU">АВСТРАЛИЯ</option><option value="AT">АВСТРИЯ</option><option value="AZ">АЗЕРБАЙДЖАН</option><option value="AL">АЛБАНИЯ</option><option value="DZ">АЛЖИР</option><option value="AI">АНГИЛЬЯ</option><option value="AO">АНГОЛА</option><option value="AG">АНТИГУА И БАРБУДА</option><option value="AR">АРГЕНТИНА</option><option value="AM">АРМЕНИЯ</option><option value="AW">АРУБА</option><option value="AF">АФГАНИСТАН</option><option value="BS">БАГАМСКИЕ О-ВА</option><option value="BD">БАНГЛАДЕШ</option><option value="BB">БАРБАДОС</option><option value="BH">БАХРЕЙН</option><option value="BY">БЕЛАРУСЬ</option><option value="BZ">БЕЛИЗ</option><option value="BE">БЕЛЬГИЯ</option><option value="BJ">БЕНИН</option><option value="BM">БЕРМУДСКИЕ О-ВА</option><option value="BG">БОЛГАРИЯ</option><option value="BO">БОЛИВИЯ</option><option value="BA">БОСНИЯ И ГЕРЦЕГОВИНА</option><option value="BW">БОТСВАНА</option><option value="BR">БРАЗИЛИЯ</option><option value="BN">БРУНЕЙ-ДАРУССАЛАМ</option><option value="BF">БУРКИНА-ФАСО</option><option value="BI">БУРУНДИ</option><option value="BT">БУТАН</option><option value="VU">ВАНУАТУ</option><option value="GB">ВЕЛИКОБРИТАНИЯ</option><option value="HU">ВЕНГРИЯ</option><option value="VE">ВЕНЕСУЭЛА</option><option value="VN">ВЬЕТНАМ</option><option value="GA">ГАБОН</option><option value="HT">ГАИТИ</option><option value="GY">ГАЙАНА</option><option value="GM">ГАМБИЯ</option><option value="GH">ГАНА</option><option value="GT">ГВАТЕМАЛА</option><option value="GN">ГВИНЕЯ</option><option value="DE">ГЕРМАНИЯ</option><option value="GI">ГИБРАЛТАР</option><option value="HN">ГОНДУРАС</option><option value="HK">ГОНКОНГ</option><option value="GD">ГРЕНАДА</option><option value="GR">ГРЕЦИЯ</option><option value="GE">ГРУЗИЯ</option><option value="DK">ДАНИЯ</option><option value="CD">ДЕМОКРАТИЧЕСКАЯ РЕСПУБЛИКА КОНГО</option><option value="DJ">ДЖИБУТИ</option><option value="DM">ДОМИНИКА</option><option value="DO">ДОМИНИКАНСКАЯ РЕСПУБЛИКА</option><option value="EG">ЕГИПЕТ</option><option value="ZM">ЗАМБИЯ</option><option value="ZW">ЗИМБАБВЕ</option><option value="IL">ИЗРАИЛЬ</option><option value="IN">ИНДИЯ</option><option value="ID">ИНДОНЕЗИЯ</option><option value="JO">ИОРДАНИЯ</option><option value="IQ">ИРАК</option><option value="IR">ИРАН</option><option value="IE">ИРЛАНДИЯ</option><option value="IS">ИСЛАНДИЯ</option><option value="ES">ИСПАНИЯ</option><option value="IT">ИТАЛИЯ</option><option value="YE">ЙЕМЕН</option><option value="KZ">КАЗАХСТАН</option><option value="KY">КАЙМАНОВЫ О-ВА</option><option value="KH">КАМБОДЖА</option><option value="CM">КАМЕРУН</option><option value="CA">КАНАДА</option><option value="KE">КЕНИЯ</option><option value="CY">КИПР</option><option value="CN">КИТАЙ</option><option value="CO">КОЛУМБИЯ</option><option value="CG">КОНГО-БРАЗЗАВИЛЬ</option><option value="KR">КОРЕЯ</option><option value="CR">КОСТА-РИКА</option><option value="CI">КОТ-Д'ИВУАР</option><option value="CU">КУБА</option><option value="KW">КУВЕЙТ</option><option value="KG">КЫРГЫЗСТАН</option><option value="CW">КЮРАСАО</option><option value="LA">ЛАОС</option><option value="LV">ЛАТВИЯ</option><option value="LS">ЛЕСОТО</option><option value="LR">ЛИБЕРИЯ</option><option value="LB">ЛИВАН</option><option value="LT">ЛИТВА</option><option value="LU">ЛЮКСЕМБУРГ</option><option value="MU">МАВРИКИЙ</option><option value="MR">МАВРИТАНИЯ</option><option value="MG">МАДАГАСКАР</option><option value="MO">МАКАО</option><option value="MK">МАКЕДОНИЯ</option><option value="MW">МАЛАВИ</option><option value="MY">МАЛАЙЗИЯ</option><option value="ML">МАЛИ</option><option value="MV">МАЛЬДИВЫ</option><option value="MT">МАЛЬТА</option><option value="MA">МАРОККО</option><option value="MX">МЕКСИКА</option><option value="MZ">МОЗАМБИК</option><option value="MD">МОЛДОВА</option><option value="MN">МОНГОЛИЯ</option><option value="MM">МЬЯНМА</option><option value="NA">НАМИБИЯ</option><option value="NP">НЕПАЛ</option><option value="NE">НИГЕР</option><option value="NG">НИГЕРИЯ</option><option value="NL">НИДЕРЛАНДЫ</option><option value="NI">НИКАРАГУА</option><option value="NZ">НОВАЯ ЗЕЛАНДИЯ</option><option value="NC">НОВАЯ КАЛЕДОНИЯ</option><option value="NO">НОРВЕГИЯ</option><option value="AE">ОАЭ</option><option value="OM">ОМАН</option><option value="PK">ПАКИСТАН</option><option value="PA">ПАНАМА</option><option value="PG">ПАПУА - НОВАЯ ГВИНЕЯ</option><option value="PY">ПАРАГВАЙ</option><option value="PE">ПЕРУ</option><option value="PL">ПОЛЬША</option><option value="PT">ПОРТУГАЛИЯ</option><option value="RW">РУАНДА</option><option value="RO">РУМЫНИЯ</option><option value="SV">САЛЬВАДОР</option><option value="ST">САН-ТОМЕ И ПРИНСИПИ</option><option value="SA">САУДОВСКАЯ АРАВИЯ</option><option value="SC">СЕЙШЕЛЬСКИЕ О-ВА</option><option value="SN">СЕНЕГАЛ</option><option value="VC">СЕНТ-ВИНСЕНТ И ГРЕНАДИНЫ</option><option value="KN">СЕНТ-КИТС И НЕВИС</option><option value="LC">СЕНТ-ЛЮСИЯ</option><option value="RS">СЕРБИЯ</option><option value="SG">СИНГАПУР</option><option value="SY">СИРИЯ</option><option value="SK">СЛОВАКИЯ</option><option value="SI">СЛОВЕНИЯ</option><option value="SB">СОЛОМОНОВЫ О-ВА</option><option value="SD">СУДАН</option><option value="SR">СУРИНАМ</option><option value="US">США</option><option value="TJ">ТАДЖИКИСТАН</option><option value="TH">ТАИЛАНД</option><option value="TZ">ТАНЗАНИЯ</option><option value="TC">ТЕРКС И КАЙКОС</option><option value="TG">ТОГО</option><option value="TT">ТРИНИДАД И ТОБАГО</option><option value="TN">ТУНИС</option><option value="TM">ТУРКМЕНИСТАН</option><option value="TR">ТУРЦИЯ</option><option value="UG">УГАНДА</option><option value="UZ">УЗБЕКИСТАН</option><option value="UA">УКРАИНА</option><option value="UY">УРУГВАЙ</option><option value="FJ">ФИДЖИ</option><option value="PH">ФИЛИППИНЫ</option><option value="FI">ФИНЛЯНДИЯ (ВКЛЮЧАЯ АЛАНДСКИЕ О-ВА)</option><option value="FR">ФРАНЦИЯ</option><option value="HR">ХОРВАТИЯ</option><option value="CF">ЦЕНТРАЛЬНАЯ АФРИКАНСКАЯ РЕСПУБЛИКА</option><option value="TD">ЧАД</option><option value="ME">ЧЕРНОГОРИЯ</option><option value="CZ">ЧЕХИЯ</option><option value="CL">ЧИЛИ</option><option value="CH">ШВЕЙЦАРИЯ</option><option value="SE">ШВЕЦИЯ</option><option value="LK">ШРИ-ЛАНКА</option><option value="EC">ЭКВАДОР</option><option value="GQ">ЭКВАТОРИАЛЬНАЯ ГВИНЕЯ</option><option value="ER">ЭРИТРЕЯ</option><option value="EE">ЭСТОНИЯ</option><option value="ET">ЭФИОПИЯ</option><option value="ZA">ЮЖНАЯ АФРИКА</option><option value="JM">ЯМАЙКА</option><option value="JP">ЯПОНИЯ</option><option value="PF">ФРАНЦУЗСКАЯ ПОЛИНЕЗИЯ</option>
                    </select>
					<?php } ?>

                    <input id="index" type="text" name="index" class="address_input 6_digits <?php echo $index_error ?>" placeholder="Индекс (6 цифр)" value="<?php echo $index ?>">
                    <input type="hidden" id="region_holder" name="region_holder" value="<?php echo $region_holder ?>">
                    <input name="region" id="regions" class="address_input <?php echo $region_error ?>" placeholder="Регион/область" value="<?php echo $region ?>">
                    <input type="hidden" id="city_holder" name="city_holder" value="<?php echo $city_holder ?>">
                    <input name="city" id="cities" class="address_input  <?php echo $city_error ?>" placeholder="Город" value="<?php echo $city ?>">
                </div>
                <?php endif; ?>
                <!-- Если почта или курьер выводить формы -->
                <?php if($delivery_type == 'courier' || $delivery_type == 'ems' || $delivery_type == 'rus_post'|| $delivery_type == 'rus_post_nal'): ?>
                    <input id="street" type="text" name="street" class="address_input street-input <?php echo $street_error ?>" placeholder="Улица" value="<?php echo $street ?>">
                    <input id="dom" type="text" name="dom" class="address_input mask_number_only <?php echo $dom_error ?>"  placeholder="Дом" value="<?php echo $dom ?>">
                    <input id="korpus" type="text" name="korpus" class="address_input <?php echo $korpus_error ?>" placeholder="Корпус" value="<?php echo $korpus ?>">
                    <input id="kvartira" type="text" name="kvartira" class="address_input mask_number_only <?php echo $kvartira_error ?>" placeholder="Квартира" value="<?php echo $kvartira ?>">
				<?php endif; ?>
                </div>
            </div>
        </div>    
        <div class="row">
        	<div class="col-md-9"></div>
        	<div class="col-md-3">
                <input type="submit" class="delivery_next" value="Далее">
            </div>
        </div>
    </form>
    </div>  
</div>   
<script>
	function check_fields(){

        $('#index, #street, #dom, #cities, #regions').attr('required', 'required');

        if($('#countries').val() == 'RU'){
            $('#delivery_company_rus_post').slideDown();

            $('#index').rules('add', {required: true, digits: true, minlength: 6, maxlength: 6});

            calc_ems_delivery();
        }
        else{
            $('#delivery_company_rus_post').slideUp().removeClass('company_selected');
            $('#delivery_company_ems').addClass('company_selected');
            $('#delivery_company_input').val('ems');

            // $('#index').rules('remove', 'digits minlength maxlength');

            calc_ems_delivery();
        }

    }
    
	function ems_calculate(to){
    console.log(to);
    if(to != null){
        $.ajax({
            /*
            dataType: "json",
            method: "post",
            url: '/curl.php',
            data: {
                request: 'method=ems.calculate&from=city--perm&to='+to+'&weight=3&type=att'
            },
            */
            method: "post",
            url: '/wp-admin/admin-ajax.php',
            data: {
                action: 'get_delivery',
                qu: $('#quantity_input').val(),
                to: to
            },
            beforeSend: function(){
                $('#delivery_summ').text(' загрузка...');
            },
            success: function(response){
                //dump(response.rsp);
                $('#delivery_summ').text(response);
                /*
                if(response.rsp.stat == 'ok'){
                    $('#delivery_summ').text(response.rsp.price*$('#quantity_input').val());
                    console.log(response.rsp.price + ' x ' + $('#quantity_input').val());
                }*/
                calc_subtotal();
            }
        });
    }
}

function calc_subtotal(){
    $('#game_summ').text(Math.round($('#quantity_input').val()*($('#game_price').val()-$('#game_price').val()*($('#discount_perc').val()/100))));
    if(!($(".delivery_type:checked").val() == 'courier')){
        //$('#delivery_summ').text(Math.round( (Number($('#game_summ').text())) * Number($('#fx_nal_pay_percent').val())/100 ) );
        $('#delivery_summ').text('0');
    }else{
        $('#delivery_summ').text($('.price_item_block').text());
    }
    //else {
        $('#full_summ').text(Math.round(Number($('#game_summ').text()) + Number($('#delivery_summ').text())));
    //}
}
function calc_ems_delivery(){
    if($('#delivery_company_input').val() == 'ems'){
        if($('#countries').val() == 'RU'){
            if($('#city_holder').val() != ''){
                ems_calculate($('#city_holder').val());
            }else if($('#region_holder').val() != ''){
                ems_calculate($('#region_holder').val());
            }else{
                $('#delivery_summ').text('0');
            }
        }else{
            ems_calculate($('#countries').val());
        }
    }
    else{
        $('#delivery_summ').text('0');
    }
}
$(document).ready(function()
{
$.ajax({
        dataType: "json",
        method: "post",
        url: '/curl.php',
        data: {
            request: 'method=ems.get.locations&type=regions&plain=true'
        },
        success: function(response){
            //dump(response.rsp);
            if(response.rsp.stat == 'ok'){
                var collection = [];
                $.each(response.rsp.locations, function (i, location) {
                    var item = {}
                    item["data"] = location.value;
                    item["value"] = location.name;
                    collection.push(item);
                });

                $('#regions').autocomplete({
                    lookup: collection,
                    onSelect: function (suggestion) {
                        $('#region_holder').val(suggestion.data);
                        //console.log(suggestion.data);
                        check_fields();
                    },
                    onInvalidateSelection: function () {
                        if($('#countries').val() == 'RU'){
                            $('#region_holder').val('');
                            $("#regions").val('');
                            console.log('invalidate');
                        }else{
                            $('#region_holder').val('');
                        }
                        //console.log('invalidate');
                        check_fields();
                    }
                });
            }
        }
    });

  $('#regions').blur(function(){
        if($('#region_holder').val() == '' && $('#countries').val() == 'RU'){
            $("#regions").val('');
        }
    });

 $.ajax({
        dataType: "json",
        method: "post",
        url: '/curl.php',
        data: {
            request: 'method=ems.get.locations&type=cities&plain=true'
        },
        success: function(response){
            //dump(response.rsp);
            if(response.rsp.stat == 'ok'){
                var collection = [];
                $.each(response.rsp.locations, function (i, location) {
                    var item = {};
                    item["data"] = location.value;
                    item["value"] = location.name;
                    collection.push(item);
                });

                $('#cities').autocomplete({
                    lookup: collection,
                    onSelect: function (suggestion) {
                        $('#city_holder').val(suggestion.data);
                        //console.log(suggestion.data);
                        check_fields();
                    },
                    onInvalidateSelection: function () {
                        $('#city_holder').val('');

                        check_fields();
                    }
                });
            }
        }
    });

    check_fields();
} );
</script>
<?php 
get_footer();
}else{ 

header('Location: /');
die();
} ?>