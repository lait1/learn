<?php
add_theme_support('post-thumbnails');

function fx_redirect(){
    if(is_category() || is_archive()){
        header('Location: /');
        exit;
    }
}
require_once('includes/_include-booking.php');
require_once('includes/_include-promo.php');
require_once('includes/_include_options.php');
require_once('includes/_include_excel_export.php');

function meta_fields($post_type){
    $fx_post_meta_array = array(
        'template-homepage.php' => array(
            'fx_header_l1' => 'Заголовок строка 1',
            'fx_header_l2' => 'Заголовок строка 2',
            'fx_promo_l1' => 'Заголовок в блоке акция',
            'fx_promo_l2' => 'Заголовок таймера',
            'fx_form_header' => 'Заголовок формы',
            'fx_btn_label' => 'Надпись на кнопке',
            'fx_video_id' => 'ID видео с ютуба',
            'get_content_from_main_site' => 'Напишите yes чтобы тянуть содержимое главной с основного сайта',
        ),
        'template-order.php' => array(
            'fx_personal_header' => 'Заголовок формы персональных данных',
            'fx_address_header' => 'Заголовок формы адреса',
            'fx_ruspost_header' => 'Заголовок для почты России',
            'fx_ruspost_text' => 'Текст для почты России',
            'fx_ems_header' => 'Заголовок для EMS',
            'fx_ems_text' => 'Текст для EMS',
            'fx_nal_text' => 'Подсказка для наложенного платежа',
        ),
        'template-order-new.php' => array(
            'fx_curier_prise' => 'Стоимость доаставки курьером',
            'fx_personal_header' => 'Заголовок формы персональных данных',
            'fx_address_header' => 'Заголовок формы адреса',
            'fx_ruspost_header' => 'Заголовок для почты России',
            'fx_ruspost_text' => 'Текст для почты России',
            'fx_ems_header' => 'Заголовок для EMS',
            'fx_ems_text' => 'Текст для EMS',
            'fx_nal_text' => 'Подсказка для наложенного платежа',
        ),
        'template-skills.php' => array(
            'fx_form_header' => 'Заголовок формы',
            'fx_btn_label' => 'Надпись на кнопке'
        ),
        'template-footer.php' => array(
            'fx_link_youtube' => 'Ссылка Youtube',
            'fx_link_fb' => 'Ссылка facebook',
            'fx_link_vk' => 'Ссылка vk',
            'fx_link_insta' => 'Ссылка instagram',
            'fx_link_twitt' => 'Ссылка twitter'
        ),
        'template-emotions.php' => array(
            'fx_video_id' => 'ID видео',
            'fx_btn_label' => 'Надпись на кнопке'
        ),
        'template-gift.php' => array(
            'fx_present_btn_label' => 'Надпись на кнопке',
        ),
        'template-player.php' => array(
            'fx_player_bg_image' => 'Изображение игрока на странице',
            'fx_player_line1' => 'Описание строка 1',
            'fx_player_line2' => 'Описание строка 2',
            'fx_player_name' => 'Имя игрока',
            'fx_player_feedback' => 'Отзыв',
            'fx_player_link' => 'Ссылка',
        ),
        'template-founder.php' => array(
            'fx_player_line1' => 'Описание строка 1',
            'fx_player_line2' => 'Описание строка 2',
        ),
        'template-payment.php' => array(
            'sergey_custom_header' => 'Заголовок перед способами оплаты',
        ),

    );
    if(isset($fx_post_meta_array[$post_type])){
        return($fx_post_meta_array[$post_type]);
    }else{
        return array();
    }
}




    /*====================================================================================
            METABOXES
    ====================================================================================*/
add_action("admin_init", function ()
{
    add_meta_box("page_meta", __("Настройки", 'lost'), "fx_post_meta", "page", "normal", "high");
});

function fx_post_meta()
{
    global $post, $wpdb;

    $custom = get_post_custom($post->ID);
    //var_dump($custom);

    wp_nonce_field( 'fx_page_metabox', 'fx_page_metabox_nonce' );

    echo '<input type="hidden" name="ignore_this" id="fx_img_btn_id">';

    if(basename(get_page_template()) == 'template-gallery.php'){
        //gallery images form
        echo '<div id="images_input_container"><p><strong>Изображения в галерее</strong></p>';
        //var_dump($custom["fx_gallery_img"][0]);
        $imgs = json_decode($custom["fx_gallery_img"][0]);
        //var_dump($imgs);
        $i = 0;
        foreach ($imgs as $img){
            echo '<p style="border: 1px solid #ddd; padding: 5px; margin-bottom: 15px; border-radius: 5px; text-align: center;"><img style="max-height: 100px; width: auto" src="'.$img.'"><br>
        <input class="fx_upload_image_field" type="text" size="50" name="fx_gallery_img[]" value="'.$img.'" />
        <input id="btn'.$i.'" class="button fx_upload_image_button" type="button" value="Загрузить изображение" />
        <input id="del'.$i.'" class="button fx_delete_image_button" type="button" value="Удалить" /><br>
        </p>';
        $i++;
        }
        echo '<p style="border: 1px solid #ddd; padding: 5px; margin-bottom: 15px; border-radius: 5px; text-align: center;"><img style="max-height: 100px; width: auto" src="null"><br>
        <input class="fx_upload_image_field" type="text" size="50" name="fx_gallery_img[]" value="" />
        <input id="btn'.$i.'" class="button fx_upload_image_button" type="button" value="Загрузить изображение" /></p>';
        echo '</div>';
        echo '<input id="add_img_btn" class="button" type="button" value="Добавить" />';
        echo '<input type="hidden" id="input_img_n" id="'.$i.">";

    }
    /*
    echo '<p><strong>'.__('somewhat', 'lost').'</strong></p>';
    echo '<p>
        <input class="fx_upload_image_field" type="text" size="50" name="fx_quest_main_img_lg" value="'.$custom["fx_quest_main_img_lg"][0].'" />
        <input id="btn0" class="button fx_upload_image_button" type="button" value="Загрузить изображение" />
    </p>';
    */

    $meta_fields = meta_fields(basename(get_page_template()));
    $meta_fields = array_merge($meta_fields, array(
        'fx_description' => 'meta description',
        'fx_keywords' => 'meta keywords',
        'fx_title' => 'title',
    ));
    //var_dump($custom);
    foreach($meta_fields as $fx_meta_slug => $fx_meta_name){
        echo '<p><strong>'.$fx_meta_name.'</strong></p>';
        echo '<input class="" type="text" style="width:100%" name="'.$fx_meta_slug.'" value="'.$custom[$fx_meta_slug][0].'" />';
    }

}

add_action('save_post', function ()
{
    global $post, $_POST;

    if ($post->post_type == 'page') {
        if ( ! isset( $_POST['fx_page_metabox_nonce'] ) ) {
            return;
        }

        // Verify that the nonce is valid.
        if ( ! wp_verify_nonce( $_POST['fx_page_metabox_nonce'], 'fx_page_metabox' ) ) {
            return;
        }

        // If this is an autosave, our form has not been submitted, so we don't want to do anything.
        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
            return;
        }


        $fx_opts = meta_fields($_POST['page_template']);
        $fx_opts = array_merge($fx_opts, array(
            'fx_description' => 'meta description',
            'fx_keywords' => 'meta keywords',
            'fx_title' => 'title',
        ));

        foreach($fx_opts as $fx_opt => $fx_opt_name){
            if (isset($_POST[$fx_opt])) {
                update_post_meta($post->ID, $fx_opt, $_POST[$fx_opt]);
            }
        }

        if(basename(get_page_template()) == 'template-gallery.php'){
            $imgs = array();
            foreach($_POST['fx_gallery_img'] as $val){
                if(!empty($val)) $imgs[] = $val;
            }
            update_post_meta($post->ID, 'fx_gallery_img', json_encode($imgs));
        }
    }
});

// 4 UPLOADING IMAGES

add_action('admin_enqueue_scripts', 'my_admin_scripts');

function my_admin_scripts() {
    //wp_enqueue_media();
    wp_register_script('my-admin-js', get_bloginfo('template_directory').'/js/my-admin.js', array('jquery'));
    wp_enqueue_script('my-admin-js');
}

function fx_quest_qty($custom){
    for($fxi=0; $fxi<(int)$custom["fx_quest_qty_max"][0]; $fxi++ ){
        $fxmin=(int)$custom["fx_quest_qty_min"][0];

        echo '<li>';
        echo '<img src="'.$custom["fx_quest_man_img"][0].'" alt="*" ';
        if($fxi>=$fxmin){
            echo ' style="opacity:0.6" ';
        }
        echo '></li>';
    }
}

function page_formatted($id)
{
    if (is_integer($id))
    {
        $page_data = get_post( $id );
    }
    else
    {
        $page_data = get_page_by_path($id);
    }

    if($page_data == null || $page_data == false){
        return '';
    }

    $page_data->post_content = apply_filters('the_content', $page_data->post_content);
    $page_data->post_content = str_replace(']]&gt;', ']]&amp;gt;', $page_data->post_content);

    return $page_data;
}


add_action( 'wp_ajax_get_delivery', 'ems_get_delivery_summ_ajax' );
add_action( 'wp_ajax_nopriv_get_delivery', 'ems_get_delivery_summ_ajax' );

function ems_get_delivery_summ_ajax(){
    if(is_numeric($_POST['qu'])){
        $price = ems_get_delivery_summ($_POST['to'], $_POST['qu']);
    }
    echo $price;
    die();
}


function ems_get_delivery_summ($to = '', $q=1){
    // никаких ошибок
    // если вес превышает допустимый - считаем достаку несколькими посылками

    if($to == ''){
        $to = $_POST['to'];
    }
    $weight=$q*3;
    $boxes_in_parcel = $q;

    $from = get_option('fx_city_from', 'city--perm');

    $out = curl_get_file_contents('http://emspost.ru/api/rest/?method=ems.calculate&from='.$from.'&to='.$to.'&weight='.$weight.'&type=att');
    $out = json_decode($out, true);
    while($out['rsp']['stat'] == 'fail' && $out['rsp']['err']['code'] == '3'){

        $boxes_in_parcel--;
        //echo '<br>error, lowering boxes to '.$boxes_in_parcel;
        $weight=$boxes_in_parcel*3;
        //echo '<br>weight '.$weight;
        $out = curl_get_file_contents('http://emspost.ru/api/rest/?method=ems.calculate&from=city--perm&to='.$to.'&weight='.$weight.'&type=att');
        $out = json_decode($out, true);
        if($boxes_in_parcel == 0){
            return '0';
        }
    }
    //echo '<br>final, '.$boxes_in_parcel;
    $price = floor($q/$boxes_in_parcel)*$out['rsp']['price'];
    //echo '<br>parcels: '.floor($q/$boxes_in_parcel);
    //echo '<br>price: '.$price;
    // возможно есть еще коробки, которые не вошли в посылки
    if(floor($q/$boxes_in_parcel)<$q/$boxes_in_parcel){

        $remaining_boxes = $q-floor($q/$boxes_in_parcel)*$boxes_in_parcel;
        //echo '<br>have more boxes: '.$remaining_boxes;

        $weight=$remaining_boxes*3;
        //echo '<br>weight '.$weight;

        $out = curl_get_file_contents('http://emspost.ru/api/rest/?method=ems.calculate&from=city--perm&to='.$to.'&weight='.$weight.'&type=att');
        $out = json_decode($out, true);
        //echo '<br>price: '.$out['rsp']['price'];

        $price = $price+$out['rsp']['price'];
        //echo '<br>fonal price: '.$price;

    }

    //$out = json_decode($out, true);

    return $price;
}

function ems_decode($id, $type){
    $out = curl_get_file_contents('http://emspost.ru/api/rest/?method=ems.get.locations&plain=true&type='.$type);
    $out = json_decode($out, true);

    foreach($out['rsp']['locations'] as $loc){
        if($loc['value'] == $id){
            return $loc['name'];
        }
    }
    return $id;
}

function curl_get_file_contents($URL)
{
    $c = curl_init();
    curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($c, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($c, CURLOPT_URL, $URL);
    $contents = curl_exec($c);
    curl_close($c);

    if ($contents) return $contents;
    else return FALSE;
}

function generate_user_id(){
    global $wpdb;

    $user_id = md5(time());
    $sec = 1;

    while(!empty($wpdb->get_results("SELECT * from ".$wpdb->prefix."fx_orders_data where userid='$user_id' LIMIT 1"))){
        $user_id = md5(time()+$sec);
        $sec++;
    }

    setcookie('user_id', $user_id, time()+3600*24*60, '/');
    return $user_id;
}

function check_user_id_cookie(){
    if(isset($_COOKIE['user_id'])){
        $user_id = $_COOKIE['user_id'];
        $user_id = preg_replace('/[^a-g0-9]+/iu', '', $user_id);

        //check id and try to find uncomplete order in db to update
        if(strlen($user_id) == 32){
            return true;
        }
    }
    return false;
}



function fx_send_aviso_mail($data, $to, $subj, $msg_text, $signature){
    //echo 'Ваше сообщение успешно отправлено. Спасибо.';

    //var_dump($_POST);

    $simpleFormMailRecipient = $to;
    $simpleFormMailFrom = 'Like Game <info@likegame.biz>';
    $simpleFormMailSubject = $subj;
    $simpleFormSuccessMessage = "Спасибо, ваша заявка успешно отправлена!";
    $simpleFormEmptyMessage = "Ошибка, поля не заполнены";
    $simpleFormErrorMessage = "Ошибка при отправке, попробуйте еще раз. Если эта ошибка повторяется, сообщите об этом администратору $simpleFormMailRecipient";

    // field descriptions (4 mail)
    $fieldnames = array(
        'order_id' => 'Номер заказа',
        'date' => 'Дата',
        'name' => 'Имя клиента',
        'email' => 'email',
        'phone' => 'Телефон',
        'quantity' => 'Количество',
        'delivery_type' => 'Тип доставки',
        'address' => 'Адрес',
        'summ' => 'Сумма',
        'inv' => 'Номер транзакции',
        'promo' => 'Промо код',
    );

    $log = "\n ";

    $log .= date("D M j Y, G:i:s T");
    // Basic header information
    $header = "From: $simpleFormMailFrom\n";
    $header .= "Return-path: <$simpleFormMailFrom>\n";
    $header .= "X-Sender-IP: " .$_SERVER['REMOTE_ADDR']."\n";
    $header .= "Content-Type: text/html; \n charset=utf-8 \n";

    // Construct the basic HTML for the message
    $head = "<html><body>";
    $table_start = $msg_text."<table border='1' width='100%'><td align='center'><strong>Поле</strong></td><td align='center'><strong>Значение</strong></td>";

    // Fetch all the form fields and their values
    $text = "";

    $log .= "\n POST array: \n";
    foreach($data as $name => $value) {
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

    $info = $signature;
    $footer = "</body></html>";

    // Combine all the information
    $body = "$head $table_start $text $table_end $info $footer";

    // If everything is filled out correctly, send the e-mail
    if ($text != "") {
        $log .= "Text is not empty \n";
        if(mail($simpleFormMailRecipient, $simpleFormMailSubject, $body, $header)){
            $log .= "Form sent \n";
        }else{
            $log .= "error sending form \n";
        }

    }else{
        $log .= "Text is empty \n";
    }
}

function fx_send_promo_mail($to, $subj, $msg_text){
    //echo 'Ваше сообщение успешно отправлено. Спасибо.';

    //var_dump($_POST);

    $simpleFormMailRecipient = $to;
    $simpleFormMailFrom = 'Like Game <info@likegame.biz>';
    $simpleFormMailSubject = $subj;

    $header = "From: $simpleFormMailFrom\n";
    $header .= "Return-path: <$simpleFormMailFrom>\n";
    $header .= "X-Sender-IP: " .$_SERVER['REMOTE_ADDR']."\n";
    $header .= "Content-Type: text/html; \n charset=utf-8 \n";

    // Construct the basic HTML for the message
    $head = "<html><body>";

    $footer = "</body></html>";

    // Combine all the information
    $body = "$head $msg_text $footer";

    if(mail($simpleFormMailRecipient, $simpleFormMailSubject, $body, $header)){
        return true;
    }else{
        return false;
    }
}

function delivery_string_decode($delivery){
    if( $delivery == 'rus_post' ){
        return 'Почта России';
    }
    elseif( $delivery == 'ems' ){
        return 'Почта EMS';
    }
    elseif( $delivery == 'courier' ){
        return 'Курьер';
    }
    elseif( $delivery == 'rus_post_nal' ){
        return 'Наложенный платеж';
    }
    else{
        return $delivery;
    }
}
// Проверка идентификационных данных пользователя
function fx_check_order_vars($user_id, $order_id){
    global $wpdb;
    
    if(strlen(preg_replace('/[^a-g0-9]+/iu', '', $user_id)) != 32){
         header('Location: /');
         die();
         // echo 'user id invalid';
    }    
    
    if(!is_numeric( $order_id)){
         header('Location: /');
         die();
        // echo 'order id invalid';
    }
    $rows = $wpdb->get_results("SELECT * from ".$wpdb->prefix."fx_orders_data where userid='$user_id' AND line_id='$order_id' LIMIT 1");
     if(empty($rows)){
    header('Location: /');        
 }

}
?>