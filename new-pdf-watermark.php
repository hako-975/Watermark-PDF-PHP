<?php
require __DIR__ . '/fpdf/fpdf.php';

class PDF extends FPDF
{

    function Header()
    {
        // setting the font, color and text for watermark
        $this->SetFont('Times', 'B', 48);
        $this->SetTextColor(140, 180, 205);
        $watermarkText = 'New PDF Watermark - PHP';
        $this->addWatermark(35, 190, $watermarkText, 45);
    }

    function addWatermark($x, $y, $watermarkText, $angle)
    {
        $angle = $angle * M_PI / 180;
        $c = cos($angle);
        $s = sin($angle);
        $cx = $x * $this->k;
        $cy = ($this->h - $y) * $this->k;
        $this->_out(sprintf('q %.5F %.5F %.5F %.5F %.2F %.2F cm 1 0 0 1 %.2F %.2F cm', $c, $s, - $s, $c, $cx, $cy, - $cx, - $cy));
        $this->Text($x, $y, $watermarkText);
        $this->_out('Q');
    }
}

$pdf = new PDF();
$pdf->AddPage();
$pdf->SetFont('Arial', '', 12);
$pdfDocumentContent = "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. .\n\n";
for ($i = 0; $i < 15; $i ++) {
    $pdf->MultiCell(0, 5, $pdfDocumentContent, 0, 'J');
}
$pdf->Output();
?>