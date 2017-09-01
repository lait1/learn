<?php
// require_once('_include_forms.php');
// require_once('_include_phpthumb.php');
require_once('_include_options.php');
// require_once('_include_display_orders.php');
// require_once('_include_excel_export.php');
// require_once('_include_post_types.php');
// require_once('_include_mail_meta.php');
// require_once('_include_city_meta.php');

// add_theme_support('post-thumbnails');
/*
add_action( 'wp_ajax_nopriv_fx_submit_form', 'fx_submit_form' );
add_action( 'wp_ajax_fx_submit_form', 'fx_submit_form' );

function fx_submit_form(){
	global $wpdb;

	//$data = unserialize($_POST['data']);
	echo json_encode(array(
        'stat' => 'ok',
        'msg' => serialize($_POST['data']),
        //'msg' => "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.",
    ));
	
	die();
}

*/

function fx_redirect(){
    if($GLOBALS['front']!=true){
        header('Location: /');
        exit;
    }
}

function meta_fields($post_type){
	$fx_post_meta_array = array(
		'tmpl-slide.php' => array(
			'fx_slide_line_1' => 'Надпись на слайде, строка 1',
			'fx_slide_line_2' => 'Надпись на слайде, строка 2',
			'fx_slide_line_3' => 'Надпись на слайде, строка 3',
			'fx_slide_video' => 'ID видео',
		),
        'tmpl-slider.php' => array(
            'fx_header_l1' => 'Заголовок, строка 1',
            'fx_header_l2' => 'Заголовок, строка 2',
            'fx_header_l3' => 'Заголовок, строка 3',
            'fx_btn_text' => 'Надпись на кнопке',
            'fx_form_header' => 'Заголовок формы',
        ),
        'tmpl-otziv.php' => array(
            'fx_name_otziv' => 'Кто оставил отзыв',
        ),
        'tmpl-city.php' => array(
            'fx_top' => 'Координата Y',
            'fx_left' => 'Координата X',
            'fx_btn_label' => 'Надпись на кнопке',
            'fx_color' => 'Цвет',
        ),
        'tmpl-map.php' => array(
            'fx_help_maps' => 'Подсказка со стрелкой',
            'fx_title_form' => 'Надпись над формой',
        ),
        'tmpl-profit.php' => array(
            'fx_subheader' => 'Подзаголовок',
            'fx_subheader2' => 'Подзаголовок - расчет прибыли',
            'fx_btn_label' => 'Надпись на кнопке',
            'fx_profit_title1' => 'Надпись строка 1',
            'fx_profit_money1' => 'Деньги строка 1',
            'fx_profit_title2' => 'Надпись строка 2',
            'fx_profit_money2' => 'Деньги строка 2',
            'fx_profit_title3' => 'Надпись строка 3',
            'fx_profit_money3' => 'Деньги строка 3',
            'fx_profit_title4' => 'Надпись строка 4',
            'fx_profit_money4' => 'Деньги строка 4',
            'fx_profit_title5' => 'Надпись строка 5',
            'fx_profit_money5' => 'Деньги строка 5',
            'fx_profit_title6' => 'Надпись строка 6',
            'fx_profit_money6' => 'Деньги строка 6',
            'people_value_min' => 'Минимальное население',
            'people_value_max' => 'Максимальное население',
            'people_pop_slider_title' => 'Заголовок слайдера с населением',
            'people_quest_slider_title' => 'Заголовок слайдера с квестами',

        ),
        'tmpl-video.php' => array(
            'fx_btn_label' => 'Надпись на кнопке',
            'fx_video_id' => 'ID видео',
        ),
        'tmpl-presentation.php' => array(
            'fx_subheader1' => 'Заголовок 1 строка',
            'fx_subheader2' => 'Заголовок 2 строка',
            'fx_btn_label' => 'Надпись на кнопке',
        ),
        'tmpl-mail.php' => array(
            'fx_mail_subject' => 'Тема письма',
            'fx_mail_file1' => 'Прикрепить файл',
            'fx_mail_file2' => 'Прикрепить еще один файл',
        ),
        'tmpl-mail2.php' => array(
            'fx_mail_subject' => 'Тема письма',
            'fx_population1' => 'Граница населения 1 ',
            'fx_population2' => 'Граница населения 2 ',
            'fx_file_p1_q1' => 'Файл до границы 1, 1 квест ',
            'fx_file_p1_q2' => 'Файл до границы 1, 2 квеста ',
            'fx_file_p1_q3' => 'Файл до границы 1, 3 квеста ',
            'fx_file_p2_q1' => 'Файл до границы 2, 1 квест ',
            'fx_file_p2_q2' => 'Файл до границы 2, 2 квеста ',
            'fx_file_p2_q3' => 'Файл до границы 2, 3 квеста ',
            'fx_file_p3_q1' => 'Файл больше границы 2, 1 квест ',
            'fx_file_p3_q2' => 'Файл больше границы 2, 2 квеста ',
            'fx_file_p3_q3' => 'Файл больше границы 2, 3 квеста ',
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
// add_action("admin_init", function ()
// {
//     add_meta_box("page_meta", __("Настройки", 'lost'), "fx_post_meta", "page", "normal", "high");
// });

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

// add_action('admin_enqueue_scripts', 'my_admin_scripts');

function my_admin_scripts() {
    //wp_enqueue_media();
    wp_register_script('my-admin-js', get_bloginfo('template_directory').'/js/my-admin.js', array('jquery'));
    wp_enqueue_script('my-admin-js');
}
