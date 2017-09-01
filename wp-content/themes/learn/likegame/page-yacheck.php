<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 18.09.2015
 * Time: 14:53
 */

// файл должен выдать XML, в котором сказать что заказ нормален и существует
// сюда приходит обычный POST запрос с хэшем
/*
Пример переменных (описаны на стр 7)

requestDatetime	2011-05-04T20:38:00.000+04:00
action	checkOrder
md5	8256D2A032A35709EAF156270C9EFE2E
shopId
shopArticleId	13
456
invoiceId	1234567
customerNumber	8123294469
orderCreatedDatetime	2011-05-04T20:38:00.000+04:00
orderSumAmount	87.10
orderSumCurrencyPaycash	643
orderSumBankPaycash	1001
shopSumAmount	86.23
shopSumCurrencyPaycash	643
shopSumBankPaycash	1001
paymentPayerCode	42007148320
paymentType	AC
MyField	Добавленное Контрагентом поле

 */

$password = get_option('yashop_password');
$shopid = get_option('yashop_shopid');
$message = '';
global $wpdb;
$md5 = $_POST['action'].';'.$_POST['orderSumAmount'].';'.$_POST['orderSumCurrencyPaycash'].';'.$_POST['orderSumBankPaycash'].';'.$shopid.';'.$_POST['invoiceId'].';'.$_POST['customerNumber'].';'.$password;

$md5 = md5($md5);
if(strtolower($md5) == strtolower($_POST['md5'])){
    // hash ok
    $line_id = $_POST['orderNumber'];
    if(is_numeric($line_id)){
        // проверяем, есть ли такой заказ.
        $rows = $wpdb->get_results("SELECT * from ".$wpdb->prefix."fx_orders_data where line_id='$line_id' LIMIT 1");
        if(!empty($rows)){
            // order exists, check summ only if currency is rubbles (643)
            if($_POST['orderSumCurrencyPaycash'] == '643' || $_POST['orderSumCurrencyPaycash'] == '10643'){
                if($_POST['orderSumAmount'] == $rows[0]->summ){
                    $code = 0;
                }else{
                    $code = 100;
                    $message = 'Нвверная сумма заказа.';
                }
            }else{
                // валюта другая, сумму проверить не можем. стало быть остается выдать подтверждание на оплату
                $code = 0;
            }

        }else{
            // order not found
            $code = 100;
            $message = 'Заказ не найден.';
        }
    }else{
        // shit happens, order ID must be number
        $code = 200;
        $message = 'Неверный номер заказа.';
    }
}else{
    // wrong password or no input
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

// bugfix version - always display ok status

$time = time();
$strdate = date('Y-m-d').'T'.date('H:i:s').'Z';
//echo '<?xml version="1.0" encoding="UTF-8"';
/*
echo $_POST['orderNumber'];
echo "\r\n";
echo $md5;

echo "\r\n";
echo $_POST['md5'];*/
/*
echo '<?xml version="1.0" encoding="UTF-8"?>
<checkOrderResponse
    performedDatetime="'.$strdate.'"
    code="'.$code.'"
    invoiceId="'.$_POST['invoiceId'].'" ';
if($message != '') echo 'message="'.$message.'" ';
echo 'shopId="'.get_option('yashop_shopid').'"/>';
*/
print '<?xml version="1.0" encoding="UTF-8"?>';
print '<checkOrderResponse performedDatetime="'. $_POST['requestDatetime'] .'" code="'.$code.'"'. ' invoiceId="'. $_POST['invoiceId'] .'" shopId="'. $shopid .'"/>';