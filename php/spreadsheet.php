<?php
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// セルに値を設定
$sheet->setCellValue('A1', 'Hello');
$sheet->setCellValue('B2', 'World!');

// ファイルを保存
$writer = new Xlsx($spreadsheet);
$writer->save('hello world.xlsx');
?>