<?php

global $wpdb;

$notification_type = $_POST['notification_type'];
$operation_id = $_POST['operation_id'];
$amount = $_POST['amount'];
$currency = $_POST['currency'];
$datetime = $_POST['datetime'];
$sender = $_POST['sender'];
$codepro = $_POST['codepro'];
$notification_secret = get_option('fx_yamoney_pwd', 'pass');
$label = $_POST['label'];

$md5 = $_POST['notification_type'].'&'.$_POST['operation_id'].'&'.$_POST['amount'].'&'.
    $_POST['currency'].'&'.$_POST['datetime'].'&'.
    $_POST['sender'].'&'.$_POST['codepro'].'&'.
    $notification_secret.'&'.$_POST['label'];

$md5 = sha1($md5);
//echo $md5;
$message = '';

if(strtolower($md5) == strtolower($_POST['sha1_hash'])){
    echo 'hash ok <br>';


    $line_id = $_POST['label'];
    if(is_numeric($line_id)){
        $rows = $wpdb->get_results("SELECT * from ".$wpdb->prefix."fx_orders_data where line_id='$line_id' LIMIT 1");
        if(!empty($rows)){
            // yahhoo!
            if($rows[0]->paid == '0'){
                $info_to_add = array(
                    'inv' => $operation_id,
                    'paid' => '1',
                    'paid_summ' => $amount,
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
                    'promo' => $rows[0]->promo,
                    'summ' => $rows[0]->summ,
                    'inv' => $rows[0]->inv,
                ), get_option('admin_email' , "fx3201@yandex.ru"), 'Оплачен новый заказ', 'Через Яндекс-кассу был оплачен новый заказ.', '');

                if($rows[0]->delivery_company == 'Самовывоз'){
                    $mail_text = page_formatted('mail-delivery-self')->post_content;
                }
                if($rows[0]->delivery_company == 'courier'){
                    $mail_text = page_formatted('mail-delivery-courier')->post_content;
                }
                if($rows[0]->delivery_company == 'rus_post_nal'){
                    $mail_text = page_formatted('mail-delivery-post-nal')->post_content;
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
            }else{

            }
            $code = 0;
            $message = 'Заказ оплачен';
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
echo 'code: '.$code.'<br>';
echo 'msg: '.$message;
?>