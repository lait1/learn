<?php
/**
 * Основные параметры WordPress.
 *
 * Скрипт для создания wp-config.php использует этот файл в процессе
 * установки. Необязательно использовать веб-интерфейс, можно
 * скопировать файл в "wp-config.php" и заполнить значения вручную.
 *
 * Этот файл содержит следующие параметры:
 *
 * * Настройки MySQL
 * * Секретные ключи
 * * Префикс таблиц базы данных
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** Параметры MySQL: Эту информацию можно получить у вашего хостинг-провайдера ** //
/** Имя базы данных для WordPress */
define('DB_NAME', 'fx_learn');

/** Имя пользователя MySQL */
define('DB_USER', 'root');

/** Пароль к базе данных MySQL */
define('DB_PASSWORD', '');

/** Имя сервера MySQL */
define('DB_HOST', 'localhost');

/** Кодировка базы данных для создания таблиц. */
define('DB_CHARSET', 'utf8mb4');

/** Схема сопоставления. Не меняйте, если не уверены. */
define('DB_COLLATE', '');

/**#@+
 * Уникальные ключи и соли для аутентификации.
 *
 * Смените значение каждой константы на уникальную фразу.
 * Можно сгенерировать их с помощью {@link https://api.wordpress.org/secret-key/1.1/salt/ сервиса ключей на WordPress.org}
 * Можно изменить их, чтобы сделать существующие файлы cookies недействительными. Пользователям потребуется авторизоваться снова.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '$X!F^;ow!MXJ|5!DFrUDcpOuT$qbFjG4xbDf|8npsLH(HF2w_(Zw5tVp3#3q6*)J');
define('SECURE_AUTH_KEY',  'Xp^a.H*&f#j+?&PPhUhL;%nYtUgS!*4% hTOv`{>qph|_tB4 rR,?gZNf{8Xc&.O');
define('LOGGED_IN_KEY',    'HOC9MH0!$RJ-R=q|Ys>WE1Ru1d!=9{?Wg;`vm>}+C{06PZHWxu+4G^CG#Lpx:N,1');
define('NONCE_KEY',        'fwomZDopiD5_W7,nAlO-N_Qy9X^V)N-Nj:<^%C|pr0)wDDtZ;KU?R[`PtMS]mb}@');
define('AUTH_SALT',        'EkxU?vr=/,M.O_4^QLt!=3nSNOfePeGT/cK|=JN.WZr8niSNaL1SvsynMkh6g6yZ');
define('SECURE_AUTH_SALT', 'it-aIz|`#Uc$tOhQ<+(o&hG6a}jlRx=P#6g$]!}4EjcU<&4NSUvGMtA;PW2`@rM7');
define('LOGGED_IN_SALT',   'M;&:PO;oRRV!#|u/JvrRrT:`#^C8K|.F_E7,*!ragr$Q;]QOPK&Lc_%_(fz&gkgF');
define('NONCE_SALT',       'ojb/2U6*zVoMe qB#jpj+&i=$UyknE*K>.g{6jo]6uTw;3K4DrSX?!}iEnI#Zp3N');

/**#@-*/

/**
 * Префикс таблиц в базе данных WordPress.
 *
 * Можно установить несколько сайтов в одну базу данных, если использовать
 * разные префиксы. Пожалуйста, указывайте только цифры, буквы и знак подчеркивания.
 */
$table_prefix  = 'wp_';

/**
 * Для разработчиков: Режим отладки WordPress.
 *
 * Измените это значение на true, чтобы включить отображение уведомлений при разработке.
 * Разработчикам плагинов и тем настоятельно рекомендуется использовать WP_DEBUG
 * в своём рабочем окружении.
 * 
 * Информацию о других отладочных константах можно найти в Кодексе.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);

/* Это всё, дальше не редактируем. Успехов! */

/** Абсолютный путь к директории WordPress. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Инициализирует переменные WordPress и подключает файлы. */
require_once(ABSPATH . 'wp-settings.php');
