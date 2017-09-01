<?php

require_once('_include_settings.php');

function fx_redirect(){
    if(is_category() || is_archive()){
        header('Location: /learn');
        exit;
    }
}
function meta_fields($post_type){
	$fx_post_meta_array = array(
        'tmpl-contact.php' => array(
            'fx_adress' => 'Адресс',
            'fx_subheader2' => 'Подзаголовок - расчет прибыли',
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


?>