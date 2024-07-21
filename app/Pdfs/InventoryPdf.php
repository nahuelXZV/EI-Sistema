<?php

namespace App\Pdfs;

use App\Services\Inventory\InventoryService;
use Codedge\Fpdf\Fpdf\Fpdf;

class InventoryPdf extends Fpdf
{
    protected $fpdf;

    public function generate($filter)
    {
        $fpdf = new Fpdf('P', 'mm', 'letter');
        $fpdf->header('Content-type: application/pdf');
        $fpdf->header('Content-Disposition: inline; filename="Inventario.pdf"');

        $inventories = InventoryService::getAllExport($filter);

        $fpdf->AddPage();
        $fpdf->SetFont('Arial', 'B', 10);
        $fpdf->Image(public_path() . '/imgs/logo2.jpg', 10, 10, 45, 0, 'JPG');
        $fpdf->Cell(188, 6, 'UNIVERSIDAD AUTONOMA GABRIEL RENE MORENO', 0, 1, 'C');
        $fpdf->Cell(188, 6, 'FACULTAD DE CIENCIAS EXACTA Y TEGNOLOGIA', 0, 1, 'C');
        $fpdf->Cell(188, 6, 'ESCUELA DE INGENIERIA', 0, 1, 'C');
        $fpdf->Ln();
        //cuerpo del reporte

        //DATOS ECONOMICOS
        $fpdf->Cell(188, 6, 'REPORTE DE INVENTARIO', 0, 1, 'C');
        $fpdf->Ln();
        $fpdf->SetFont('Arial', 'B', 8);
        $fpdf->Cell(24, 6, 'COD. PARTIDA', 1, 0);
        $fpdf->Cell(26, 6, 'COD. CATALOGO', 1, 0);
        $fpdf->Cell(70, 6, 'NOMBRE', 1, 0);
        $fpdf->Cell(40, 6, 'TIPO', 1, 0);
        $fpdf->Cell(20, 6, 'CANTIDAD', 1, 0);
        $fpdf->Cell(20, 6, 'UNIDADES', 1, 1);

        $fpdf->SetFont('Arial', '', 8);
        foreach ($inventories as $inventory) {
            $fpdf->Cell(24, 6, utf8_decode($inventory->codigo_partida), 1, 0);
            $fpdf->Cell(26, 6, utf8_decode($inventory->codigo_catalogo), 1, 0);
            $fpdf->Cell(70, 6, utf8_decode($inventory->nombre), 1, 0);
            $fpdf->Cell(40, 6, utf8_decode($inventory->tipo), 1, 0);
            $fpdf->Cell(20, 6, utf8_decode($inventory->cantidad_contenedor), 1, 0);
            $fpdf->Cell(20, 6, utf8_decode($inventory->total_unidades), 1, 1);
        }

        $fpdf->Output("I", "Inventario.pdf", true);
        exit;
    }
}
