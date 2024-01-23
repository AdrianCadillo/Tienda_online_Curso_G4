<?php
namespace app\lib;

use FPDF;

class pdf extends FPDF
{
// Cabecera de página
function Header()
{
    // Logo
   /** Agregamos un titulo a la hoja */
   $this->SetFont("Arial","B",15);
   $this->SetTextColor(72, 61, 139);
   $this->Cell(200,4,'Reporte de productos',0,1,'C');
   $this->Cell(200,6,'________________________',0,1,'C');
}

// Pie de página
function Footer()
{
    // Posición: a 1,5 cm del final
    $this->SetY(-15);
    // Arial italic 8
    $this->SetFont('Arial',"",12);
    // Número de página
    $this->Cell(0,10,'{nb}',0,0,'C');
}
}