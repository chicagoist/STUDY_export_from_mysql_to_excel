<?php
/*
 2021
 https://www.linkedin.com/in/legioneroff

*/


// Настройки подключения к БД

define('HOST', 'localhost'); // хост к БД
define('USER', '_name_'); // пользователь
define('PASSWORD', '_name_'); // пароль
define('DB', '_name_'); // имя базы данных


$db = mysqli_connect(HOST, USER, PASSWORD); // объект ссылки на подключение к БД

//var_dump($db); //
//var_dump(mysqli_select_db($db, 'testDB'));

if (!$db) {
    exit('WRONG CONNECTION'); // если проблема с доступом к БД
}


if (!mysqli_select_db($db, '_name_')) { // если нет данного имени БД
    exit(DB);
}

mysqli_query($db, 'SET firs_name utf8'); // кодировка кириллицы
mysqli_query($db, 'SET last_name utf8');
