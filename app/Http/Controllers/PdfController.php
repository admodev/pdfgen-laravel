<?php

namespace App\Http\Controllers;

require_once(__DIR__ . "/../../PDF/fpdf.php");

use Illuminate\Http\Request;
use FPDF;
use Illuminate\Support\Facades\Response;

class PdfController extends Controller
{
    private $pdf;

    public function __construct(FPDF $fpdf)
    {
        $this->pdf = $fpdf;
    }

    private function Header()
    {
        $this->pdf->SetFont('Times', 'B', 14);
        $this->pdf->Cell(276, 5, 'PDF GENERADO CON FPDF EN PHP');
        $this->pdf->SetTextColor(0, 0, 255);
        $this->pdf->Ln(20);
        $this->pdf->Cell(200, 10, 'DOCUMENTACION EN PDF', 0, 0, 'c');
        $this->pdf->Ln(20);
    }

    private function Footer()
    {
        $this->pdf->SetY(-25);

        $this->pdf->SetFont('Arial', 'I', 8);

        $this->pdf->Cell(0, 10, 'Page ' .
            $this->pdf->PageNo() . '/{nb}', 0, 0, 'C');
    }

    private function headerAttributes()
    {
        $this->pdf->SetFont('Times', 'B', 10);
        $this->pdf->Cell(40, 10, 'Producto', 1, 0, 'C');
        $this->pdf->Cell(45, 10, 'Descripcion', 1, 0, 'C');
        $this->pdf->Cell(25, 10, 'Cantidad', 1, 0, 'C');
        $this->pdf->Cell(40, 10, 'Precio', 1, 0, 'C');
        $this->pdf->Cell(45, 10, 'Total', 1, 0, 'C');
        $this->pdf->Ln();
        $this->pdf->Cell(40, 10, 'Par de ojotas', 1, 0, 'C');
        $this->pdf->Cell(45, 10, 'Un simple par de ojotas', 1, 0, 'C');
        $this->pdf->Cell(25, 10, '1', 1, 0, 'C');
        $this->pdf->Cell(40, 10, '$5400', 1, 0, 'C');
        $this->pdf->Cell(45, 10, '', 'R', 0, 'C');
        $this->pdf->Ln();
        $this->pdf->Cell(40, 10, 'Jean', 1, 0, 'C');
        $this->pdf->Cell(45, 10, 'Pantalon de jean', 1, 0, 'C');
        $this->pdf->Cell(25, 10, '1', 1, 0, 'C');
        $this->pdf->Cell(40, 10, '$25400', 1, 0, 'C');
        $this->pdf->Cell(45, 10, '', 'R', 0, 'C');
        $this->pdf->Ln();
        $this->pdf->Cell(40, 10, '', 1, 0, 'C');
        $this->pdf->Cell(45, 10, '', 1, 0, 'C');
        $this->pdf->Cell(25, 10, '', 1, 0, 'C');
        $this->pdf->Cell(40, 10, '', 1, 0, 'C');
        $this->pdf->Cell(45, 10, '$30800', 1, 0, 'C');
    }

    public function show()
    {
        $pdfObject = $this->pdf;

        $pdfObject->AliasNbPages();
        $pdfObject->AddPage();
        $this->headerAttributes();
        $pdfObject->SetFont('Times', '', 14);

        $pdfContent = $pdfObject->Output("", "S");

        return Response::make($pdfContent, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="factura.pdf"',
        ]);
    }
}
