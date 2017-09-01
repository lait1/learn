<?php
/*
UPDATE `franchise_posts` SET `post_type`= "mail" WHERE `post_name` LIKE "ac_%"
UPDATE `franchise_posts` SET `post_type`= "city" WHERE `post_parent` = "17" AND `post_type` = 'page'
SELECT * FROM `franchise_posts` WHERE `post_parent` = '17' AND `post_type` = 'page'
*/

add_action('after_switch_theme', 'create_booking_table');
function create_booking_table(){
    global $wpdb;

    $wpdb->query('CREATE TABLE IF NOT EXISTS `'.$wpdb->prefix.'fx_orders_data` (
          `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
          `CLIENT` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
          `TEL` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
          `EMAIL` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
          `CITY` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
          `CITY_H` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
          `CITY_Q` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
          `DATE_CR` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
          `DATE_CH` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
          `AC_CALL` bigint(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
          `AC_PREZ_INST` bigint(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
          `AC_VIDEO` bigint(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
          `AC_MARKET` bigint(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
          `AC_PROFIT` bigint(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
          `AC_PODROBNO` bigint(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
          `AC_OPEN` bigint(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
          PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=1 ;');

}

add_action( 'wp_ajax_nopriv_fx_submit_form', 'fx_submit_form' );
add_action( 'wp_ajax_fx_submit_form', 'fx_submit_form' );
function fx_submit_form(){
	global $wpdb;

    $debug = false;

	$data = array();

	foreach($_POST['data'] as $field){
		//$$field['name'] = $field['value'];

		$data[$field['name']] = $field['value'];
	}

	$data['user_name'] = preg_replace('/[^а-яa-z]+/iu', '', $data['user_name'] );
	$data['user_phone'] = validate_fields( 'phone', $data['user_phone'] );
	$data['user_email'] = validate_fields( 'email', $data['user_email'] );
	$data['name_city'] = preg_replace('/[^а-яa-z0-9\- ]+/iu', '', $data['name_city'] );
	$data['city_h'] = preg_replace('/[^0-9]+/iu', '', $data['city_h'] );
	$data['city_q'] = preg_replace('/[^0-9]+/iu', '', $data['city_q'] );
	$data['form_id'] = preg_replace('/[^a-z_]+/iu', '', $data['form_id'] );

    if(!($data['form_id'] == 'AC_CALL'
        || $data['form_id'] == 'AC_PREZ_INST'
        || $data['form_id'] == 'AC_VIDEO'
        || $data['form_id'] == 'AC_MARKET'
        || $data['form_id'] == 'AC_PROFIT'
        || $data['form_id'] == 'AC_PODROBNO'
        || $data['form_id'] == 'AC_OPEN'
    ) )  // shit happens
    {
        echo json_encode(array(
            'stat' => 'err',
            'msg' => 'Ошибка передачи данных. Попробуйте еще раз.',
            //'msg' => $data['form_id'] != 'AC_PREZ_INST',
        ));
        die();
    }

	// защита от дурака
    if($data['form_id'] == 'AC_CALL'){
        if(empty($data['user_name']) || empty($data['user_phone'])){
            echo json_encode(array(
                'stat' => 'err',
                'msg' => 'Необходимые поля не заполнены или заполненны не верно, попробуйте еще раз.',
            ));
            die();
        }
    }else{
    	if(empty($data['user_name']) || empty($data['user_phone']) || empty($data['user_email'])){
    		echo json_encode(array(
    			'stat' => 'err',
    			'msg' => 'Необходимые поля не заполнены или заполненны не верно, попробуйте еще раз.',
    		));
    		die();
    	}
    }

    // create array with data
	$data_to_add['CLIENT'] = $data['user_name'];
    $data_to_add['TEL'] = $data['user_phone'];
    if(!empty($data['user_email'])) $data_to_add['EMAIL'] = $data['user_email'];
    if(!empty($data['name_city'])) $data_to_add['CITY'] = $data['name_city'];
    if(!empty($data['city_h'])) $data_to_add['CITY_H'] = $data['city_h'];
    if(!empty($data['city_q'])) $data_to_add['CITY_Q'] = $data['city_q'];
	$data_to_add['DATE_CH'] = time();
	$data_to_add[$data['form_id']] = 1;

    if($data['form_id'] == 'AC_PROFIT'){
        if(!isset($data_to_add['CITY_Q'])){
            $data_to_add['CITY_Q'] = 1;
        }
        if(!isset($data_to_add['CITY_H'])){
            $data_to_add['CITY_H'] = 300000;
        }
    }

    if($debug) echo "Get rows\n";
    $rows = array();

    //get the rows
    if($data['user_email'] != ''){
        if($debug) echo "Email set. get by phone and mail\n";
        $rows = $wpdb->get_results("SELECT * from ".$wpdb->prefix."fx_orders_data WHERE `TEL`='".$data_to_add['TEL']."' AND 'EMAIL`='".$data['user_email']."'");
    }

    if(empty($rows)){
        if($debug) echo "Fail. get by phone ".$data_to_add['TEL']."\n";
        //if($debug) echo "Query: "."SELECT * from ".$wpdb->prefix."fx_orders_data WHERE `TEL`='".$data_to_add['TEL']."'"."\n";
        $rows = $wpdb->get_results("SELECT * from ".$wpdb->prefix."fx_orders_data WHERE `TEL`='".$data_to_add['TEL']."'");
    }

    if(empty($rows) && $data['user_email'] != '' ){
        if($debug) echo "Fail. Get by mail\n";
        $rows = $wpdb->get_results("SELECT * from ".$wpdb->prefix."fx_orders_data WHERE `EMAIL`='".$data['user_email']."'");
    }

    if(!empty($rows)){
        if($debug) echo "Smt found. update. row#".$rows[0]->id." \n";
        // если что-то таки нашли, то надо добавить в ряд данные (если пустые), и обновить поля АС_
        // стало быть логика такая:
        // по очереди проверяем, есть ли в базе представленное значение, и если есть то удаляем его из массива.
        // потом шлем обновлять то, что осталось
        // обновляем первый найденный ряд, без вопросов

        if(isset($data_to_add['EMAIL']) && $rows[0]->EMAIL != '' ) unset($data_to_add['EMAIL']);
        if(isset($data_to_add['TEL']) && $rows[0]->TEL != '' ) unset($data_to_add['TEL']);
        if(isset($data_to_add['CLIENT']) && $rows[0]->CLIENT != '' ) unset($data_to_add['CLIENT']);

        $result = $wpdb->update($wpdb->prefix."fx_orders_data", $data_to_add, array('id'=>$rows[0]->id ));
    }
    else /* insert a new row */ {
        if($debug) echo "Nothing found. create new. \n";
        $data_to_add['DATE_CR'] = time();
        $wpdb->insert( $wpdb->prefix.'fx_orders_data', $data_to_add );

        //msg('Created new row');
    }

    if($debug) echo "Go send mail \n";
    //data in db updated, now we need to send mails
    $msg = 'Ваша заявка успешно отправлена, спасибо.';
    if(get_option('fx_msg_'.$data['form_id']) != '') $msg = get_option('fx_msg_'.$data['form_id']);

    // common function to send mail, just not to fuck the brain
    // send mail to client
    if(get_option($data['form_id'].'_mail', 'no') == 'yes'){
        $page_with_text = page_formatted(strtolower($data['form_id']).'_mail');

        $mail_text = $page_with_text->post_content;
        $mail_subject = get_post_meta($page_with_text->ID, 'fx_mail_subject', true);

        $mail_text = fx_replace_str($mail_text, $data_to_add);

        //msg($mail_text);

        $file1 = '';
        $file2 = '';
        if($data['form_id'] == 'AC_PROFIT'){
            $custom = get_post_custom($page_with_text->ID);
            if($data_to_add['CITY_H'] < $custom['fx_population1'][0]){
                $file1 = $custom['fx_file_p1_q'.$data_to_add['CITY_Q']][0];
            }
            elseif($data_to_add['CITY_H'] < $custom['fx_population2'][0]){
                $file1 = $custom['fx_file_p2_q'.$data_to_add['CITY_Q']][0];
            }
            else{
                $file1 = $custom['fx_file_p3_q'.$data_to_add['CITY_Q']][0];
            }
        }
        else{
            //смотрим, есть ли файлы. читаем если есть
            $file1 = get_post_meta($page_with_text->ID, 'fx_mail_file1', true);
            $file2 = get_post_meta($page_with_text->ID, 'fx_mail_file2', true);
        }


        fx_send_promo_mail($data_to_add['EMAIL'], $mail_subject, $mail_text, $file1, $file2);
    }

    if(get_option($data['form_id'].'_mail_admin', 'no') == 'yes'){
        $page_with_text = page_formatted(strtolower($data['form_id']).'_mail_admin');

        $mail_text = $page_with_text->post_content;
        $mail_subject = get_post_meta($page_with_text->ID, 'fx_mail_subject', true);

        $mail_text = fx_replace_str($mail_text, $data_to_add);

        //msg($mail_subject);
        fx_send_promo_mail(get_option('fx_email_to'), $mail_subject, $mail_text);
    }

    msg($msg, 'ok');


    die();
}

function fx_replace_str($mail_text, $data_to_add){
    $mail_text = str_replace('%CLIENT%', $data_to_add['CLIENT'], $mail_text);
    $mail_text = str_replace('%TEL%', $data_to_add['TEL'], $mail_text);
    $mail_text = str_replace('%EMAIL%', $data_to_add['EMAIL'], $mail_text);
    $mail_text = str_replace('%CITY_H%', $data_to_add['CITY_H'], $mail_text);
    $mail_text = str_replace('%CITY_Q%', $data_to_add['CITY_Q'], $mail_text);
    $mail_text = str_replace('%CITY%', $data_to_add['CITY'], $mail_text);
    $mail_text = str_replace('%DATE_CH%', date('d.m.Y h:i', $data_to_add['DATE_CH']), $mail_text);

    return $mail_text;
}

function msg($msg ='', $stat='err'){
    echo json_encode(array(
        'stat' => $stat,
        'msg' => $msg,
    ));
    //die();
}

function validate_fields($type, $value){
	if($type=='phone'){
		$filtered_val = preg_replace('/[^0-9]+/iu', '', $value);
		if(strlen($filtered_val) > 10 && strlen($filtered_val) < 21){
			if($filtered_val[0]=='8'){
				$filtered_val[0]=7;
			}
			return($filtered_val);
		}else{
			return '';
		}
	}elseif($type=='email'){
		if(empty($value)) return '';
		$filtered_val = filter_var($value, FILTER_SANITIZE_EMAIL);
		if(filter_var($filtered_val, FILTER_VALIDATE_EMAIL)){
			return $filtered_val;
		}else{
			return '';
		}
	}
	else{
		return false;
	}

	return $filtered_val;
}


function page_formatted($id)
{
    if (is_integer($id))
    {
        $page_data = get_post( $id );
    }
    else
    {
        $page_data = get_page_by_path($id, OBJECT, 'mail');
    }

    if($page_data == null || $page_data == false){
        return '';
    }

    $page_data->post_content = apply_filters('the_content', $page_data->post_content);
    $page_data->post_content = str_replace(']]&gt;', ']]&amp;gt;', $page_data->post_content);

    return $page_data;
}


function fx_send_promo_mail($to, $subj, $msg_text, $file1='', $file2=''){
    $simpleFormMailRecipient = $to;
    $simpleFormMailFrom = "=?utf-8?B?".base64_encode(get_option('fx_name_from'))."?=".' <'.get_option('fx_email_from').'>';
    $simpleFormMailSubject = $subj;

    if($file1 != ''){
        $path = str_replace(get_option('siteurl'), '', $file1);
        $path = untrailingslashit(get_home_path()).$path;
//        $path = untrailingslashit(dirname($_SERVER['SCRIPT_FILENAME'])).$path;

        $fp = fopen($path,"r");

        if ($fp){
            $file1 = fread($fp, filesize($path));

            fclose($fp);
        }
    }
    if($file2 != ''){
        $path2 = str_replace(get_option('siteurl'), '', $file2);
        //$path2 = untrailingslashit(dirname($_SERVER['SCRIPT_FILENAME'])).$path2;
        $path2 = untrailingslashit(get_home_path()).$path2;

        $fp = fopen($path2,"r");

        if ($fp){
            $file2 = fread($fp, filesize($path2));

            fclose($fp);
        }
    }




    // Construct the basic HTML for the message
    $head = "<html><body>";
    $footer = "</body></html>";

    // Combine all the information
    //$body = "$head $msg_text $footer";
    $body = "<div>$msg_text</div>";

    $boundary = "--".md5(uniqid(time())); // генерируем разделитель
    //$boundary = "----==--bound.63459.web18h.yandex.ru"; // генерируем разделитель
    $headers .= "MIME-Version: 1.0\n";
    $headers = "From: $simpleFormMailFrom\n";
    $headers .= "Return-path: <$simpleFormMailFrom>\n";
    $headers .= "X-Sender-IP: " .$_SERVER['REMOTE_ADDR']."\n";
    $headers .="Content-Type: multipart/mixed; boundary=\"$boundary\"\n";
    $multipart .= "--$boundary\n";
    $kod = 'utf-8'; // или $kod = 'windows-1251';
    //$kod = 'windows-1251'; // или $kod = 'windows-1251';
    $multipart .= "Content-Type: text/html; charset=$kod\n";
    //$multipart .= "Content-Transfer-Encoding: Quot-Printed\n\n";
    $multipart .= "Content-Transfer-Encoding: 8bit\n\n";
    $multipart .= "$body\n\n";

    if($file1 != '') {
        $filename = basename($path);


        $message_part = "--$boundary\n";
        $message_part .= "Content-Disposition: attachment; filename=\""."=?utf-8?B?".base64_encode($filename)."?="."\"\n";
        $message_part .= "Content-Transfer-Encoding: base64\n";
        //$message_part .= "Content-Type: application/octet-stream; name=\""."=?utf-8?B?".base64_encode($filename)."?="."\"\n";
        $message_part .= "Content-Type: application/octet-stream; name=\""."=?utf-8?B?".base64_encode($filename)."?="."\"\n";

        $message_part .= "\n";
        $message_part .= chunk_split(base64_encode($file1));
        $message_part .= "\n--$boundary\n";

        /*
        $message_part = "--$boundary\n";
        $message_part .= "Content-Type: application/octet-stream;name = \"" . basename($path) . "\"\n";
        $message_part .= "Content-Description: ".basename($path)."\n";
        $message_part .= "Content-Transfer-Encoding: base64\n";
        $message_part .= "Content-Disposition: attachment; filename = \"" . basename($path) . "\"\n\n";
        $message_part .= chunk_split(base64_encode($file1)) . "\n";
        $multipart .= $message_part . "--$boundary--\n";*/
    }
    if($file2 != '') {
        $filename = basename($path2);

        //$message_part .= "\n--$boundary\n";
        //$message_part .= "Content-Type: application/octet-stream; name=\""."=?utf-8?B?".base64_encode($filename)."?="."\"\n";
        $message_part .= "Content-Type: application/octet-stream; name=\""."=?utf-8?B?".base64_encode($filename)."?="."\"\n";
        $message_part .= "Content-Transfer-Encoding: base64\n";
        $message_part .= "Content-Disposition: attachment; filename=\""."=?utf-8?B?".base64_encode($filename)."?="."\"\n";
        $message_part .= "\n";
        $message_part .= chunk_split(base64_encode($file2));
        $message_part .= "\n--$boundary--\n";

        /*
        //$message_part = "--$boundary\n";
        $message_part = "";
        $message_part .= "Content-Type: application/octet-stream;name = \"" . basename($path2) . "\"\n";
        $message_part .= "Content-Description: ".basename($path2)."\n";
        $message_part .= "Content-Transfer-Encoding: base64\n";
        $message_part .= "Content-Disposition: attachment; filename = \"" . basename($path2) . "\"\n\n";
        $message_part .= chunk_split(base64_encode($file1)) . "\n";
        $multipart .= $message_part . "--$boundary--\n";
        */
    }
    //$multipart = mb_convert_encoding($multipart, 'windows-1251', 'utf-8');
    $multipart .= $message_part;

    // change encoding
    //$simpleFormMailSubject = mb_convert_encoding($simpleFormMailSubject, 'windows-1251', 'utf-8');
    //$headers = mb_convert_encoding($headers, 'windows-1251', 'utf-8');

    if(mail($simpleFormMailRecipient, $simpleFormMailSubject, $multipart, $headers)){
        return true;
    }else{
        return false;
    }
}

 ?>