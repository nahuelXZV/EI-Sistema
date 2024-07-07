<?php

namespace App\Pdfs;

use App\Services\Inventory\FixedAssetService;
use Codedge\Fpdf\Fpdf\Fpdf;

class FixedAssetsPdf extends Fpdf
{
    protected $fpdf;

    public function generate($state, $unit)
    {
        $fpdf = new Fpdf('P', 'mm', 'letter');
        $fpdf->header('Content-type: application/pdf');
        $fpdf->header('Content-Disposition: inline; filename="Activos-Fijos.pdf"');

        if ($state != "" || $unit != 0) {
            $fixedAssets = FixedAssetService::getAllByUnitAndState($state, $unit);
        } else {
            $fixedAssets = FixedAssetService::getAll();
        }

        $fpdf->AddPage();
        $fpdf->SetFont('Arial', 'B', 10);
        $fpdf->Image(public_path() . '/imgs/logo2.jpg', 10, 10, 45, 0, 'JPG');
        $fpdf->Cell(188, 6, 'UNIVERSIDAD AUTONOMA GABRIEL RENE MORENO', 0, 1, 'C');
        $fpdf->Cell(188, 6, 'FACULTAD DE CIENCIAS EXACTA Y TEGNOLOGIA', 0, 1, 'C');
        $fpdf->Cell(188, 6, 'ESCUELA DE INGENIERIA', 0, 1, 'C');
        $fpdf->Ln();
        //cuerpo del reporte

        //DATOS ECONOMICOS
        $fpdf->Cell(188, 6, 'REPORTE DE ACTIVOS FIJOS', 0, 1, 'C');
        $fpdf->Ln();
        $fpdf->SetFont('Arial', 'B', 8);
        $fpdf->Cell(20, 6, 'CODIGO', 1, 0);
        $fpdf->Cell(50, 6, 'NOMBRE', 1, 0);
        $fpdf->Cell(20, 6, 'ESTADO', 1, 0);
        $fpdf->Cell(30, 6, 'AREA', 1, 0);
        $fpdf->Cell(50, 6, 'ENCARGADO', 1, 0);
        $fpdf->Cell(30, 6, 'UNIDAD', 1, 1);

        $fpdf->SetFont('Arial', '', 8);
        foreach ($fixedAssets as $fixedAsset) {
            $fpdf->Cell(20, 6, $fixedAsset->codigo, 1, 0);
            $fpdf->Cell(50, 6, utf8_decode($fixedAsset->nombre), 1, 0);
            $fpdf->Cell(20, 6, $fixedAsset->estado, 1, 0);
            $fpdf->Cell(30, 6, utf8_decode($fixedAsset->area), 1, 0);
            $fpdf->Cell(50, 6, utf8_decode($fixedAsset->name_user . ' ' . $fixedAsset->lastname_user), 1, 0);
            $fpdf->Cell(30, 6, utf8_decode($fixedAsset->unidad_nombre), 1, 1);
        }

        $fpdf->Output("I", "Activos-Fijos.pdf");
        exit;
    }
}
