<?php
/**
 * Конфигурация
 * 
 * @author Dmitry Gavriloff <irvis@imega.ru>
 */

define('APP_PATH', dirname(__FILE__));
/*
 * DB
 */
define('DB_HOST','127.0.0.1'); 
define('DB_USER','novkva'); 
define('DB_PASSWORD','novkva82'); 
define('DB_NAME','novkva');
define('DB_CHARSET', 'UTF8');

define('URL', 'http://myserver');


session_start();
date_default_timezone_set('Europe/Moscow');
/*
 * Установить соединение с БД 
 */
require_once APP_PATH . '/mods/db.php';