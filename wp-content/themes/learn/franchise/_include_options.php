<?php

/*====================================================================================
            Options
====================================================================================*/



add_action( 'admin_menu', 'fx_bb_add_options_page' );
function fx_bb_add_options_page(){
//    add_menu_page( 'Настройки Franchise', 'Настройки Fr', 'manage_options', 'bb-options', 'mt_settings_page' );
    add_submenu_page( 'options-general.php', 'Настройки Franchise', 'Настройки Franchise', 'manage_options', 'bb-options', 'mt_settings_page' );
    //add_submenu_page( 'admin.php?page=bb-options', 'Общие настройки', 'Общие настройки', 'manage_options', 'bb-options', 'mt_settings_page' );
    add_submenu_page( 'options-general.php', 'Настройки писем', 'Настройки писем', 'manage_options', 'fr-mail-opts', 'fx_mail_options' );
    add_submenu_page( 'options-general.php', 'Сообщения при отпавке писем', 'Сообщения при отпавке писем', 'manage_options', 'reply-mail-opts', 'fx_reply_options' );
}

function fx_mail_options(){
//must check that the user has the required capability
    if (!current_user_can('manage_options'))
    {
        wp_die( __('You do not have sufficient permissions to access this page.') );
    }

    $checkboxes_options = array(
        //'AC_CALL_mail' => 'Письмо обратный звонок пользователю',
        'AC_CALL_mail_admin' => 'Письмо обратный звонок админу',
        'AC_PREZ_INST_mail' => 'Письмо "получить презентацию c инструкцией" пользователю',
        'AC_PREZ_INST_mail_admin' => 'Письмо "получить презентацию c инструкцией" админу',
        'AC_VIDEO_mail' => 'Письмо "получить видео" пользователю',
        'AC_VIDEO_mail_admin' => 'Письмо "получить видео" админу',
        'AC_MARKET_mail' => 'Письмо "Анализ рынка" пользователю',
        'AC_MARKET_mail_admin' => 'Письмо "Анализ рынка" админу',
        'AC_PROFIT_mail' => 'Письмо "Расчет прибыли" пользователю',
        'AC_PROFIT_mail_admin' => 'Письмо "Расчет прибыли" админу',
        'AC_PODROBNO_mail' => 'Письмо с подробной презентацией пользователю',
        'AC_PODROBNO_mail_admin' => 'Письмо с подробной презентацией админу',
        'AC_OPEN_mail' => 'Письмо "Открыть квест" пользователю',
        'AC_OPEN_mail_admin' => 'Письмо "Открыть квест" админу',
    );
    //$opt_name = 'mt_favorite_color';
    $hidden_field_name = 'mt_submit_hidden';
    //$data_field_name = 'mt_favorite_color';


    //var_dump($options_vals);
    //$opt_val = get_option( $opt_name );

    // See if the user has posted us some information
    // If they did, this hidden field will be set to 'Y'
    if( isset($_POST[ $hidden_field_name ]) && $_POST[ $hidden_field_name ] == 'Y' ) {
        // update checkboxes
        foreach($checkboxes_options as $key => $val){
            if($_POST[$key] == 'yes'){
                update_option( $key, 'yes' );
            }else{
                update_option( $key, 'no' );
            }
        }

        // Put a "settings saved" message on the screen
        echo '<div class="updated"><p><strong>Настройки сохранены</strong></p></div>';
    }

    echo '<div class="wrap">';
    echo '<h2>Настройки писем</h2>';

    foreach($checkboxes_options as $key => $val){
        $options_vals[$key] = get_option($key);
    }

    //var_dump($options_vals['fx_delivery_methods_enabled']);

    // Now display the settings editing screen

    ?>
    <form name="form1" method="post" action="">
        <input type="hidden" name="<?php echo $hidden_field_name; ?>" value="Y">

        <?php
        //checkboxes
        foreach($checkboxes_options as $key => $val){
            echo "<p><input type='checkbox' name='$key' value='yes' id='$key'";
            if($options_vals[$key] == 'yes') echo 'checked';
            echo " ><label for='$key' >$val</label></p>";
        }




        ?>


        <p class="submit">
            <input type="submit" name="Submit" class="button-primary" value="<?php esc_attr_e('Save Changes') ?>" />
        </p>

    </form>

    </div>
    <?php
}

function fx_reply_options(){
    //must check that the user has the required capability
    if (!current_user_can('manage_options'))
    {
        wp_die( __('You do not have sufficient permissions to access this page.') );
    }

    // variables for the field and option names
    $options_names = array(

        'fx_msg_AC_CALL' => 'Сообщение при отправке формы обратного звонка',
        'fx_msg_AC_PREZ_INST' => 'Сообщение при отправке формы "Получить презентацию c инструкцией"',
        'fx_msg_AC_VIDEO' => 'Сообщение при отправке формы "Получить видео"',
        'fx_msg_AC_MARKET' => 'Сообщение при отправке формы "Анализ рынка"',
        'fx_msg_AC_PROFIT' => 'Сообщение при отправке формы "Расчет прибыли"',
        'fx_msg_AC_PODROBNO' => 'Сообщение при отправке формы "Получить подробную презентацию"',
        'fx_msg_AC_OPEN' => 'Сообщение при отправке формы "Открыть квест"',
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

    //var_dump($options_vals['fx_delivery_methods_enabled']);

    // Now display the settings editing screen
    echo '<div class="wrap">';

    // header
    echo "<h2>Настройки</h2>";

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

function mt_settings_page() {

    //must check that the user has the required capability
    if (!current_user_can('manage_options'))
    {
        wp_die( __('You do not have sufficient permissions to access this page.') );
    }

    // variables for the field and option names
    $options_names = array(
        'fx_franchise_phone' => 'Телефон',
        'fx_email_from' => 'Email, от кого отправлять',
        'fx_name_from' => 'Имя, от кого отправлять',
        'fx_email_to' => 'Email, куда отправлять',
        'fx_yametric_id' => 'ID яндекс метрики',

        /*'fx_msg_AC_CALL' => 'Сообщение при отправке формы обратного звонка',
        'fx_msg_AC_PREZ_INST' => 'Сообщение при отправке формы "Получить презентацию c инструкцией"',
        'fx_msg_AC_VIDEO' => 'Сообщение при отправке формы "Получить видео"',
        'fx_msg_AC_MARKET' => 'Сообщение при отправке формы "Анализ рынка"',
        'fx_msg_AC_PROFIT' => 'Сообщение при отправке формы "Расчет прибыли"',
        'fx_msg_AC_PODROBNO' => 'Сообщение при отправке формы "Получить подробную презентацию"',
        'fx_msg_AC_OPEN' => 'Сообщение при отправке формы "Открыть квест"',*/
    );
    $checkboxes_options = array(
        //'AC_CALL_mail' => 'Письмо обратный звонок пользователю',
        'AC_CALL_mail_admin' => 'Письмо обратный звонок админу',
        'AC_PREZ_INST_mail' => 'Письмо "получить презентацию c инструкцией" пользователю',
        'AC_PREZ_INST_mail_admin' => 'Письмо "получить презентацию c инструкцией" админу',
        'AC_VIDEO_mail' => 'Письмо "получить видео" пользователю',
        'AC_VIDEO_mail_admin' => 'Письмо "получить видео" админу',
        'AC_MARKET_mail' => 'Письмо "Анализ рынка" пользователю',
        'AC_MARKET_mail_admin' => 'Письмо "Анализ рынка" админу',
        'AC_PROFIT_mail' => 'Письмо "Расчет прибыли" пользователю',
        'AC_PROFIT_mail_admin' => 'Письмо "Расчет прибыли" админу',
        'AC_PODROBNO_mail' => 'Письмо с подробной презентацией пользователю',
        'AC_PODROBNO_mail_admin' => 'Письмо с подробной презентацией админу',
        'AC_OPEN_mail' => 'Письмо "Открыть квест" пользователю',
        'AC_OPEN_mail_admin' => 'Письмо "Открыть квест" админу',
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
/*
        // update checkboxes
        foreach($checkboxes_options as $key => $val){
            if($_POST[$key] == 'yes'){
                update_option( $key, 'yes' );
            }else{
                update_option( $key, 'no' );
            }
        }
*/
        // Put a "settings saved" message on the screen
        echo '<div class="updated"><p><strong>Настройки сохранены</strong></p></div>';
    }


    // Read in existing option value from database
    $options_vals = array();
    foreach( $options_names as $key => $val){
        $options_vals[$key] = get_option($key);
    }

    foreach($checkboxes_options as $key => $val){
        $options_vals[$key] = get_option($key);
    }

    //var_dump($options_vals['fx_delivery_methods_enabled']);

    // Now display the settings editing screen
    echo '<div class="wrap">';

    // header
    echo "<h2>Настройки</h2>";

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
/*
        //checkboxes
        foreach($checkboxes_options as $key => $val){
            echo "<p><input type='checkbox' name='$key' value='yes' id='$key'";
            if($options_vals[$key] == 'yes') echo 'checked';
            echo " ><label for='$key' >$val</label></p>";
        }

*/


        ?>


        <p class="submit">
            <input type="submit" name="Submit" class="button-primary" value="<?php esc_attr_e('Save Changes') ?>" />
        </p>

    </form>

    </div>

<?php

}
