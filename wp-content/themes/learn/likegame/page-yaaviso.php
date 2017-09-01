<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 18.09.2015
 * Time: 14:54
 */
$time = time();
$strdate = date('Y-m-d').'T'.date('H:i:s').'Z';
/*
requestDatetime	2011-05-04T20:38:00.000+04:00
action	paymentAviso
md5	45125C95A20A7F25B63D58EA304AFED2
shopId 13
shopArticleId	456
invoiceId	1234567
customerNumber	8123294469
orderCreatedDatetime	2011-05-04T20:38:00.000+04:00
orderSumAmount	87.10
orderSumCurrencyPaycash	643
orderSumBankPaycash	1001
shopSumAmount	86.23
shopSumCurrencyPaycash	643
shopSumBankPaycash	1001
paymentDatetime	2011-05-04T20:38:10.000+04:00
paymentPayerCode
paymentType
cps_user_country_code	42007148320
AC
RU
MyField	Добавленное Контрагентом поле

*/

//action;orderSumAmount;orderSumCurrencyPaycash;orderSumBankPaycash;shopId;invoiceId;customerNumber;shopPassword
global $wpdb;
$password = get_option('yashop_password');
$shopid = get_option('yashop_shopid');
$message = '';
global $wpdb;
$md5 = $_POST['action'].';'.$_POST['orderSumAmount'].';'.$_POST['orderSumCurrencyPaycash'].';'.$_POST['orderSumBankPaycash'].';'.$shopid.';'.$_POST['invoiceId'].';'.$_POST['customerNumber'].';'.$password;
$md5 = md5($md5);
//echo $md5;
if(strtolower($md5) == strtolower($_POST['md5'])){
/*
    $_POST['invoiceId']; // ID платежа в яндексе запихать в базу в 'inv'
    $_POST['paymentDatetime']; // дата платежа
    $_POST['orderSumAmount']; // сумма

    $_POST['customerNumber'];
    $_POST['orderNumber'];
*/
    $line_id = $_POST['orderNumber'];
    if(is_numeric($line_id)){
        $rows = $wpdb->get_results("SELECT * from ".$wpdb->prefix."fx_orders_data where line_id='$line_id' LIMIT 1");
        if(!empty($rows)){
            // yahhoo!
            if($rows[0]->paid == '0'){
                $info_to_add = array(
                    'inv' => $_POST['invoiceId'],
                    'paid' => '1',
                    'paid_summ' => $_POST['orderSumAmount'],
                );
                // update row
                $result = $wpdb->update($wpdb->prefix."fx_orders_data", $info_to_add, array('line_id'=>$line_id));

                if($rows[0]->delivery_company != 'Самовывоз'){
                    $address = $rows[0]->indexto.', '.$rows[0]->country.', '.$rows[0]->region.', '.$rows[0]->city.', улица '.$rows[0]->street.', дом '.$rows[0]->house.', корпус '.$rows[0]->corpus.', квартира '.$rows[0]->room;
                }else{
                    $address = '';
                }
                fx_send_aviso_mail(array(
                    'order_id' => $line_id,
                    'date' => date('d.m.Y H:i:s'),
                    'name' => $rows[0]->adresat,
                    'email' => $rows[0]->email,
                    'phone' => $rows[0]->teladdress,
                    'quantity' => $rows[0]->quantity,
                    'delivery_type' => delivery_string_decode($rows[0]->delivery_company),
                    'address' => $address,
                    'summ' => $rows[0]->summ,
                    'inv' => $rows[0]->inv,
                ), get_option('admin_email' , "fx3201@yandex.ru"), 'Оплачен новый заказ', 'Через Яндекс-кассу был оплачен новый заказ.', '');

                if($rows[0]->delivery_company == 'Самовывоз'){
                    $mail_text = page_formatted('mail-delivery-self')->post_content;
                }
                if($rows[0]->delivery_company == 'courier'){
                    $mail_text = page_formatted('mail-delivery-courier')->post_content;
                }
                else{
                    $mail_text = page_formatted('mail-delivery-post')->post_content;
                }

                fx_send_aviso_mail(array(
                    'order_id' => $line_id,
                    'date' => date('d.m.Y H:i:s'),
                    'name' => $rows[0]->adresat,
                    'quantity' => $rows[0]->quantity,
                    'delivery_type' => delivery_string_decode($rows[0]->delivery_company),
                    'address' => $address,
                    'summ' => $rows[0]->summ,
                    'inv' => $rows[0]->inv,
                ), $rows[0]->email, 'Like Game - Ваш заказ успешно оплачен', $mail_text, "<p>Рустам Зарипов,<br>Аяз Шабутдинов,<br>Алексей Нечаев,<br>Like Game Team<br><br><a href='http://likegame.biz'>www.likegame.biz</a><br><a href='vk.com/biznes.igra'>vk.com/biznes.igra</a><br></p>");
            }
            $code = 0;
        }else{
            $code = 100;
            $message = 'Заказ не найден';
        }
    }else{
        $code = 200;
        $message = 'Неверный номер заказа';
    }
}else{
    $code=1;
    $message = 'Ошибка авторизации.';
}

//header("Content-Type: text/xml");
header("Content-Type: text");
//header("Expires: Thu, 19 Feb 1998 13:24:18 GMT");
//header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT");
header("Cache-Control: no-cache, must-revalidate");
header("Cache-Control: post-check=0,pre-check=0");
header("Cache-Control: max-age=0");
header("Pragma: no-cache");

$strdate = date('Y-m-d').'T'.date('H:i:s').'Z';
/*
echo '<?xml version="1.0" encoding="UTF-8"?>
<paymentAvisoResponse
    performedDatetime ="'.$strdate.'"
    code="'.$code.'" invoiceId="'.$_POST['invoiceId'].'"';
if($message != '') echo 'message="'.$message.'" ';
echo 'shopId="'.$shopid.'"/>';
*/
print '<?xml version="1.0" encoding="UTF-8"?>';
print '<paymentAvisoResponse performedDatetime="'. $_POST['requestDatetime'] .'" code="'.$code.'" invoiceId="'. $_POST['invoiceId'] .'" shopId="'. $shopid .'"/>';

?>