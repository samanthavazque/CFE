<?php
// (A) LOAD & USE PHPSPREADSHEET LIBRARY
require "vendor/autoload.php";
require 'Config/Conexion.php';

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Border;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

 
// (B) CREATE A NEW SPREADSHEET
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
 
// (C) SET CELL VALUE
$sqlfederal = "SELECT * FROM errores";
$federal = $conn->query($sqlfederal);
$sheet->mergeCells('B1:H1');
$sheet->setCellValue('B1', 'Reporte de Pronutario');
$sheet->getStyle('B1')->getFont()->setBold(true)->setSize(18)->getColor()->setARGB('00BB2D');
$sheet->getStyle('B1')->getAlignment()->setHorizontal('center');
$sheet->mergeCells('B2:H2');
$sheet->setCellValue('B2', 'Fecha: ' . date('d/m/Y'));
$sheet->getStyle('B2')->getFont()->setSize(12);
$sheet->getStyle('B2')->getAlignment()->setHorizontal('center');

// Agregar logotipo institucional en la parte superior izquierda
if (file_exists('comision1.png')) {
    $logo = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
    $logo->setName('Logo');
    $logo->setDescription('Logo');
    $logo->setPath('comision1.png');
    $logo->setHeight(60);
    $logo->setCoordinates('A1');
    $logo->setWorksheet($sheet);
}
$sheet->setCellValue('B3','ID');
$sheet->setCellValue('C3','Categoria');
$sheet->setCellValue('D3','Numero Error');
$sheet->setCellValue('E3','Descripción');
$sheet->setCellValue('F3','Solución Operativa');
$sheet->setCellValue('G3','Solucion Tecnica');
$sheet->setCellValue('H3','Imagen');
$i=3;
while($row = $federal->fetch_assoc()){
    $celda3 = 'B'.($i+1);
    $sheet->setCellValue($celda3, $row['id']);
    $celda4 = 'C'.($i+1);
    $idCat = $row['id_categoria'];
    $sql = "SELECT nombre FROM categoria WHERE id = '$idCat'";
    $result2 = $conn->query($sql);
    $cate = '';
    if ($result2 && $result2->num_rows > 0) {
        $fila = mysqli_fetch_assoc($result2);
        $cate = $fila['nombre'];
    }
    $sheet->setCellValue($celda4, $cate);
    $celda5 = 'D'.($i+1);
    $sheet->setCellValue($celda5, utf8_decode($row['numeroerrores']));
    $celda6 = 'E'.($i+1);
    $sheet->setCellValue($celda6, utf8_decode($row['descripcion']));
    $celda7 = 'F'.($i+1);
    $sheet->setCellValue($celda7, utf8_decode($row['solucionoperativa']));
    $celda8 = 'G'.($i+1);
    $sheet->setCellValue($celda8, utf8_decode($row['soluciontecnica']));
    $celda9 = 'H'.($i+1);
    if(file_exists($row['poster'])){
        $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
        $drawing->setPath($row['poster']);
        $drawing->setHeight(60);
        $drawing->setCoordinates($celda9);
        $drawing->setWorksheet($sheet);
    }
    $i+=1;
}
foreach ($sheet->getRowIterator() as $row){
    $sheet->getRowDimension($row->getRowIndex())->setRowHeight(50);
    $sheet->getColumnDimension('B')->setWidth(6);
    $sheet->getColumnDimension('C')->setWidth(10);
    $sheet->getColumnDimension('D')->setWidth(10);
    $sheet->getColumnDimension('E')->setWidth(60);
    $sheet->getColumnDimension('F')->setWidth(60);
    $sheet->getColumnDimension('G')->setWidth(60);
    $sheet->getColumnDimension('H')->setWidth(30);

}

$spreadsheet->getDefaultStyle()->getAlignment()->setWrapText(true);
$spreadsheet->getDefaultStyle()->getAlignment()->setHorizontal('center');
$spreadsheet->getDefaultStyle()->getAlignment()->setVertical('center');


$spreadsheet->getActiveSheet()->getStyle('B3:H3')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('00BB2D');
$spreadsheet->getActiveSheet()->getStyle('B3:H3')->getFont()->getColor()->setARGB('FFFFFFFF');
$spreadsheet->getActiveSheet()->getStyle('B3:H3')->getFont()->setBold(true);


$spreadsheet
    ->getActiveSheet()
    ->getStyle('B3:H'.($i-1))
    ->getBorders()
    ->getAllBorders()
    ->setBorderStyle(Border::BORDER_THIN)
    ->setColor(new Color('00000000'));



// (C) AUTO FILTER
$sheet->setAutoFilter("B3:H3");
// (D) FREEZE PANE
$sheet->freezePane("C4");


// (D) SAVE TO FILE
$writer = new Xlsx($spreadsheet);
$nombreArchivo = 'reporte_de_pronutario_' . date('Y-m-d') . '.xlsx';
header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
header("Content-Disposition: attachment;filename=\"$nombreArchivo\"");
header("Cache-Control: max-age=0");
header("Expires: Fri, 11 Nov 2011 11:11:11 GMT");
header("Last-Modified: ". gmdate("D, d M Y H:i:s") ." GMT");
header("Cache-Control: cache, must-revalidate");
header("Pragma: public");
$writer->save("php://output");
?>
