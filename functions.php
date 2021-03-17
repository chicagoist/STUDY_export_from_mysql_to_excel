<?php

/*
 2021
 https://www.linkedin.com/in/legioneroff

*/

function get_list()
{
    require('config.php'); // подключение к БД

    $sql = "SELECT * FROM customers"; // запрос к вашей таблицы из БД

    $result = mysqli_query($db, $sql); // переменный массив с данными из таблицы из БД
    //var_dump($result); // отладка


    if (!$result) { // варнинг, если вернулся пустой запрос от БД
        exit(mysqli_error($db));
    }

    $row = array(); // создаём массив для вывода всех данных из таблицы БД

    for ($i = 0; $i < mysqli_num_rows($result); $i++) { // цикл по выводу из запроса от БД
        $row[] = mysqli_fetch_assoc($result); // вносим данные в массив
    }

    return $row; // возврат массива данных из таблицы из БД
}
