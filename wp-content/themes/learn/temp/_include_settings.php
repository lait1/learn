<?php

add_action( 'admin_menu', 'fx_bb_add_options_page' );
function fx_bb_add_options_page(){
    add_menu_page( 'Настройки Secret', 'Настройки Secret', 'manage_options', 'bb-options', 'mt_settings_page' );
}
//require_once('_include-booking.php');
// mt_settings_page() displays the page content for the Test settings submenu
function mt_settings_page() {

    //must check that the user has the required capability
    if (!current_user_can('manage_options'))
    {
        wp_die( __('You do not have sufficient permissions to access this page.') );
    }

    // variables for the field and option names
    $options_names = array(


        'fx_city_phone' => 'Телефон (для города)',
        'fx_home_title' => 'Заголовок на главной',
        'fx_form_title' => 'Заголовок формы',
        'fx_vk_link' => 'Ссылка ВК',
        'fx_book_link' => 'Ссылка на книжку',
        'fx_vk_id' => 'ID для виджета вконтакте',
        'manager_photo' => 'Ссылка на фото менеджера (250х250), например /wp-content/themes/secret/img/manager-anastasia.jpg',
        'manager_name' => 'Имя менеджера',
        
        'fx_email' => 'email для заявок',
        'prepay_amount' => 'размер предоплаты а рублях (только число)',

    );
    
    //$opt_name = 'mt_favorite_color';
    $hidden_field_name = 'mt_submit_hidden';
    //$data_field_name = 'mt_favorite_color';


    //var_dump($options_vals);
    //$opt_val = get_option( $opt_name );

    // See if the user has posted us some information
    // If they did, this hidden field will be set to 'Y'
    if( isset($_POST[ $hidden_field_name ]) && $_POST[ $hidden_field_name ] == 'Y' ) {
        // Read their posted value
        foreach( $options_names as $key => $val){
            if(isset($_POST[$key])){
                update_option( $key, $_POST[$key] );
            }
        }
        

        // Put a "settings saved" message on the screen
        echo '<div class="updated"><p><strong>Настройки сохранены</strong></p></div>';
    }


    // Read in existing option value from database
    $options_vals = array();
    foreach( $options_names as $key => $val){
        $options_vals[$key] = get_option($key);
    }
    

    // Now display the settings editing screen
    echo '<div class="wrap">';

    // header
    echo "<h2>Настройки Secret</h2>";

    // settings form
    ?>

    <form name="form1" method="post" action="">
        <input type="hidden" name="<?php echo $hidden_field_name; ?>" value="Y">

        <?php
        foreach( $options_names as $key => $val){
            echo '<p>'.$val.'<br>';
            echo '<input type="text" name="'.$key.'" value="'.$options_vals[$key].'" style="width:100%;">';
            echo '</p>';
        }

        
        ?>


        <p class="submit">
            <input type="submit" name="Submit" class="button-primary" value="<?php esc_attr_e('Save Changes') ?>" />
        </p>

    </form>

    </div>

<?php

}
