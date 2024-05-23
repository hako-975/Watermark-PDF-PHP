<?php
require_once __DIR__ . '/fpdf/fpdf.php';
require_once __DIR__ . '/FPDI/src/autoload.php';

function addWatermark($x, $y, $watermarkText, $angle, $pdf)
{
    $angle = $angle * M_PI / 180;
    $c = cos($angle);
    $s = sin($angle);
    $cx = $x * 1;
    $cy = (300 - $y) * 1;
    $pdf->_out(sprintf('q %.5F %.5F %.5F %.5F %.2F %.2F cm 1 0 0 1 %.2F %.2F cm', $c, $s, - $s, $c, $cx, $cy, - $cx, - $cy));
    $pdf->Text($x, $y, $watermarkText);
    $pdf->_out('Q');
}

$pdf = new \setasign\Fpdi\Fpdi();
$fileInput = 'example.pdf';
$pages_count = $pdf->setSourceFile($fileInput);
for ($i = 1; $i <= $pages_count; $i ++) {
    $pdf->AddPage();
    $tplIdx = $pdf->importPage($i);
    $pdf->useTemplate($tplIdx, 0, 0);
    $pdf->SetFont('Times', 'B', 70);
    $pdf->SetTextColor(192, 192, 192);
    $watermarkText = 'CONFIDENTIAL';
    addWatermark(105, 220, $watermarkText, 45, $pdf);
    $pdf->SetXY(25, 25);
}
$pdf->Output();
?>