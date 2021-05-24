<?php
$obj = new PHPExcel();

# get active sheet and assign to variable
$sheet1 = $obj->getActiveSheet();

# set title for active sheet
$sheet1->setTitle("Applicants");

$col = 0;
$row = 2;
$ltr = "";
$highest_column = 0;

foreach($data["applicants"] as $applicant) {
	foreach($applicant as $key => $val) {
		$ltr = PHPExcel_Cell::stringFromColumnIndex($col);
		
		if ($row == 2) {
			$sheet1->setCellValue("{$ltr}1", str_replace("_", " ", $key));			
		}
		
		$sheet1->setCellValue("{$ltr}{$row}", $val);
		$sheet1->getColumnDimension($ltr)->setAutoSize(true);
		
		if (strstr($val, PHP_EOL)) {
			$sheet1->getStyle("{$ltr}{$row}")->getAlignment()->setWrapText(true);
		}

		$col++;
	}
	$highest_column = $col;
	$col = 0;
	$row++;
}

$ltr = PHPExcel_Cell::stringFromColumnIndex($highest_column);
$sheet1->getStyle("A1:{$ltr}1")->getFont()->setBold(true);
$sheet1->getStyle("A2:{$ltr}{$row}")->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
		
header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
header("Content-Disposition: attachment;filename=applicants.xlsx");
header("Cache-Control: max-age=0");

$writer = PHPExcel_IOFactory::createWriter($obj, "Excel2007");
$writer->save("php://output");
?>