<?php
/*
 2021
 https://www.linkedin.com/in/legioneroff

*/


require_once 'Classes/PHPExcel.php'; // добавляем стороннюю библиотеку
require_once 'functions.php';

$list = get_list();

// echo "<pre>"; // отладка
// print_r($list);
// echo "</pre>";

$objPHPExel = new PHPExcel(); // создаём объект класса

$objPHPExel->setActiveSheetIndex(0); // задаём активный Лист для работы
//$objPHPExel->createSheet(); // так можно добавлять ещё Листы

$active_sheet = $objPHPExel->getActiveSheet(); // объект для активного Листа для разработки

$active_sheet->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE); // альбомный вид на печать
$active_sheet->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4); // А4 формат
$active_sheet->getPageMargins()->setTop(1); // отступ сверху
$active_sheet->getPageMargins()->setRight(0.75); // отступ справа
$active_sheet->getPageMargins()->setLeft(0.75); // отступ слева
$active_sheet->getPageMargins()->setBottom(1); // отступ снизу

$active_sheet->setTitle("Тестовое задание"); // название активного Листа

$active_sheet->getHeaderFooter()->setOddHeader("&CШапка тестового задания"); //шапка по центру всегда
$active_sheet->getHeaderFooter()->setOddFooter('&L&B' . $active_sheet->getTitle() . '&RСтраница &P из &N'); // Название страницы и номер страницы

$objPHPExel->getDefaultStyle()->getFont()->setName('Arial'); // шрифт
$objPHPExel->getDefaultStyle()->getFont()->setSize(12); // размер шрифта

$active_sheet->getColumnDimension('A')->setWidth(7); // id
$active_sheet->getColumnDimension('B')->setWidth(15); // first_name
$active_sheet->getColumnDimension('C')->setWidth(15); // second_name
$active_sheet->getColumnDimension('D')->setWidth(17); // phone
$active_sheet->getColumnDimension('E')->setWidth(17); // email
$active_sheet->getColumnDimension('F')->setWidth(20); // data

$active_sheet->mergeCells('A1:F1'); // объеденяем верхние ячейки в одну заголовочную
$active_sheet->getRowDimension('1')->setRowHeight(40); // высота первой общей строки
$active_sheet->setCellValue('A1', 'Тестовое задание MySQL PHP Excel www.linkedin.com/in/legioneroff'); // текст заголовка

$active_sheet->mergeCells('A2:F2'); // отступ в виде пустой строки

$active_sheet->mergeCells('A3:E3'); // объеденяем ячейки в одну для даты
$active_sheet->setCellValue('A3', 'Дата cоздания таблицы: '); // дата
$date = date('d-m-Y'); // формат даты
$active_sheet->setCellValue('F3', $date); // присваем значение ячейке
$active_sheet->getStyle('F3')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_XLSX14); // форматирование типа данных ячейки в ДАТА

$active_sheet->setCellValue('A5', '№ п.п.'); // названия столбцов в соответсвии с выводом с БД
$active_sheet->setCellValue('B5', 'Имя'); // названия столбцов в соответсвии с выводом с БД
$active_sheet->setCellValue('C5', 'Фамилия'); // названия столбцов в соответсвии с выводом с БД
$active_sheet->setCellValue('D5', 'Номер телефона'); // названия столбцов в соответсвии с выводом с БД
$active_sheet->setCellValue('E5', 'E-mail'); // названия столбцов в соответсвии с выводом с БД
$active_sheet->setCellValue('F5', 'Время'); // названия столбцов в соответсвии с выводом с БД

$row_start = 6; // старт заполнения ячеек
$i = 0; // счётчик итераций

foreach ($list as $item) { // заполняем ячейки из БД
    $row_next = $row_start + $i;

    $active_sheet->setCellValue('A' . $row_next, $item['id']);
    $active_sheet->setCellValue('B' . $row_next, $item['first_name']);
    $active_sheet->setCellValue('C' . $row_next, $item['last_name']);
    $active_sheet->setCellValue('D' . $row_next, $item['numberphone']);
    $active_sheet->setCellValue('E' . $row_next, $item['email']);
    $active_sheet->setCellValue('F' . $row_next, $item['data']);

    $i++;
}

// НИЖЕ УКРАШАЛКИ И ФОРМАТИРОВАНИЕ СТРОК И ЯЧЕЕК

$style_wrap = array(
    'borders' => array(
        'outline' => array(
            'style' => PHPExcel_Style_Border::BORDER_THICK
        ),
        'allborders' => array(
            'style' => PHPExcel_Style_Border::BORDER_THIN,
            'color' => array(
                'rgb' => '696969'
            )
        )
    )
);
$active_sheet->getStyle('A1:F' . ($i + 5))->applyFromArray($style_wrap); // форматируем через массив стилей

$style_header = array(
    'font' => array(
        'bold' => true,
        'name' => 'Times New Roman',
        'size' => 16
    ),
    'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
    ),
    'fill' => array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'color' => array(
            'rgb' => 'CFCFCF'
        )
    )
);
$active_sheet->getStyle('A1:F1')->applyFromArray($style_header); // форматируем ШАПКУ  через массив стилей




$style_tdate = array(

    'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT
    ),
    'fill' => array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'color' => array(
            'rgb' => 'CFCFCF'
        )
    ),
    'borders' => array(
        'right' => array(
            'style' => PHPExcel_Style_Border::BORDER_NONE
        )
    )
);
$active_sheet->getStyle('A3:D3')->applyFromArray($style_tdate); // форматируем ДАТА  через массив стилей




$style_date = array(


    'fill' => array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'color' => array(
            'rgb' => 'CFCFCF'
        )
    ),
    'borders' => array(
        'left' => array(
            'style' => PHPExcel_Style_Border::BORDER_NONE
        )
    )
);
$active_sheet->getStyle('F3')->applyFromArray($style_date); // фон ячейки ДАТА  через массив стилей





$style_nlist = array(

    'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
    ),
    'fill' => array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'color' => array(
            'rgb' => 'CFCFCF'
        )
    ),

    'font' => array(
        'bold' => true,
        'italic' => true,
        'name' => 'Times New Roman',
        'size' => 10
    )



);
$active_sheet->getStyle('A5:F5')->applyFromArray($style_nlist); // форматируем НАЗВАНИЯ СТОЛБЦОВ  через массив стилей





$style_llist = array(

    'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT
    )

);
$active_sheet->getStyle('A6:F' . ($i + 5))->applyFromArray($style_llist); // форматируем весь текст из БД по правому боку




// сообщаем тип данных для скачивания со страницы
header("Content-Type:application/vnd.ms-excel");
header("Content-Disposition:attachment;filename=тестовое-задание.xls"); // именуем скачиваемый файл

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExel, 'Excel2007'); // устанавливаем стандарт Excel
$objWriter->save('php://output');



exit(); // ФИНИТА ЛЯ КОМЕДИА !!! ))))
