<?php
/*
 * send mail
 */

add_action('wp_ajax_send_mail', 'fx_send_mail');
add_action('wp_ajax_nopriv_send_mail', 'fx_send_mail');
function fx_send_mail(){

    // do not check vars, send every shit user enters ))

    $simpleFormMailRecipient = get_option('fx_email');
    //$simpleFormMailRecipient = "fx3201@yandex.ru";
    $simpleFormMailFrom = "learn@ake88371027.myjino.ru";
    $simpleFormMailSubject = "Сообщение с сайта";
    $simpleFormSuccessMessage = "Спасибо, ваша заявка успешно отправлена!";
    $simpleFormEmptyMessage = "Ошибка, поля не заполнены";
    $simpleFormErrorMessage = "Ошибка при отправке, попробуйте еще раз. Если эта ошибка повторяется, сообщите об этом администратору $simpleFormMailRecipient";

    // field descriptions (4 mail)
    $fieldnames = array(
        'name' => 'Имя',
        'phone' => 'Телефон',
        'message' => 'Сообщение',
        'email' => 'e-mail',
        'date-service' => 'Запись на дату',
        'form_slug' => 'id формы',
    );

    $log = "\n ";

    $log .= date("D M j Y, G:i:s T");
    // Basic header information
    $header = "From: <$simpleFormMailFrom>\n";
    $header .= "Return-path: <$simpleFormMailFrom>\n";
    $header .= "X-Sender-IP: " .$_SERVER['REMOTE_ADDR']."\n";
    $header .= "Content-Type: text/html; \n charset=utf-8 \n";

    // Construct the basic HTML for the message
    $head = "<html><body>";
    $table_start = "<table border='1' width='100%'><td align='center'><strong>Поле</strong></td><td align='center'><strong>Значение</strong></td>";

    // Fetch all the form fields and their values
    $text = "";

    // ------------- 4 CRM ---------------
    // make associative array
    $data = array();

    foreach($_POST['data'] as $field) {
        $name = strip_tags($field['name']);
        $value = strip_tags($field['value']);

        $data[$name] = $value;
    }

    //send_to_amo_crm($data);

    // ------------- END 4 CRM ---------------

    // ------------- 4 SMS ---------------

    //$sms = new sms_ru();
    //$sms->send('', 'Телефон: '.$data['phone'].' Имя: '.$data['name']);

    // ------------- END 4 SMS -----------

    $log .= "\n POST array: \n";
    foreach($_POST['data'] as $field){
        $name = $field['name'];
        $value = $field['value'];

        $fieldname = $name;

        if(isset($fieldnames[$name])){
            $fieldname = $fieldnames[$name];
        }

        if($value != '' && $name != 'action'){
            $text .= "<tr><td>$fieldname</td><td>$value</td></tr>";
            $log .= $name.' ('.$fieldname.') '.' => '.$value . "\n";
        }
        else{
            $log .= $name.' ('.$fieldname.') '." => empty \n";
        }


    }
    $log .= "\n";
    // End the table and add extra footer information
    $table_end = "</table>";
    $info = "<br />Сообщение отправлено с сайта: ".$_SERVER['SERVER_NAME'];
    $info .= "<br />Время отправки: ".date('d m Y H:i', time()+3600*5);
    $footer = "</body></html>";

    // Combine all the information
    $body = "$head $table_start $text $table_end $info $footer";

    // If everything is filled out correctly, send the e-mail
    if ($text != "") {
        $log .= "Text is not empty \n";

        /*echo json_encode(array(
            'stat' => 'ok',
            'msg' => $text,
        ));*/


        if(mail($simpleFormMailRecipient, $simpleFormMailSubject, $body, $header)){
            $log .= "Form sent \n";
            echo json_encode(array(
                'stat' => 'ok',
                'msg' => $simpleFormSuccessMessage,
            ));
        }else{
            $log .= "error sending form \n";
            echo json_encode(array(
                'stat' => 'err',
                'msg' => $simpleFormErrorMessage,
            ));
        }

    }else{
        echo json_encode(array(
            'stat' => 'err',
            'msg' => $simpleFormEmptyMessage,
        ));
        $log .= "Text is empty \n";
    }

    //dump other vars
    $log .= "Header: $header \n";
    $log .= "Subject: $simpleFormMailSubject \n";
    $log .= "Body: $body \n";
    $log .= "Text: $text \n";

    // write log
    $f = fopen("mail_log.txt", "a+");
    fwrite($f,$log);
    fwrite($f,"\n ---------------\n\n");
    fclose($f);

    wp_die();

    die();
}
