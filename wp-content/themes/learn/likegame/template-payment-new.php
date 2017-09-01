<?php /* Template Name: Способ оплаты */

// Прнимаем идентификатор пользователя
// if(isset($_GET['cid']) && isset($_GET['oid'])){
$user_id = preg_replace('/[^a-g0-9]+/iu', '', $_REQUEST['cid']);
$order_id = preg_replace('/[^0-9]+/iu', '', $_REQUEST['oid']);

// Проверяем данных на валидность
fx_check_order_vars($user_id, $order_id);

//Достаем из базы необходимую информацию
$rows = $wpdb->get_results("SELECT * from ".$wpdb->prefix."fx_orders_data where line_id='$order_id' LIMIT 1");
$delivery_type = $rows[0]->delivery_company;

//Пользователь выбрал как он хочет заплатить
if(!empty($_POST['payment_form_action'])){

    $info_to_update = array('payment' => $_POST['payment'],'status' => 'payment');
    $result = $wpdb->update($wpdb->prefix."fx_orders_data", $info_to_update, array('line_id'=>$order_id));

	header('Location: /personal/?cid='.$user_id.'&oid='.$order_id);
	die();
}

// Проверяем какой тип доставки у клиента, при доставке через почту переходим на следующий шаг
if($delivery_type == 'ems' || $delivery_type == 'rus_post' || $delivery_type == 'rus_post_nal'){
    if($delivery_type == 'rus_post_nal'){
        $info_to_update = array('payment' => 'post_nal');
    }else{
        $info_to_update = array('payment' => 'online');
    }

    $result = $wpdb->update($wpdb->prefix."fx_orders_data", $info_to_update, array('line_id'=>$order_id));

    header('Location: /personal/?cid='.$user_id.'&oid='.$order_id);
	die();

		}elseif ($delivery_type == 'self' || $delivery_type == 'courier'){

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
        	<div class="col-md-3 wrap_delivery action">
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
        	<div class="col-md-10 col-md-offset-2">
		        <div class="div-payment-types">
		      		<label>
		                <input class="chk-payment" name="payment" value="online" type="radio">
		                Онлайн оплата
		            </label>
		            <br>
		            <label>
		                <input class="chk-payment" name="payment" value="nal" type="radio">
		                Наличными при получении 
			            </label>
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
<?php 
get_footer();
}else{ 

header('Location: /');
die();
} ?>