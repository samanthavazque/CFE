<?php

require 'fpdf/fpdf.php';
require 'conexion/Conexion.php'; //puede que no lo necesiten
class PDF extends FPDF {

// Cabecera de página
	function Header() {
		// Logo
		$this->Image('comision.png', 15, 8, 25, 25, 'png');
		// Título principal
		$this->SetFont('Arial', 'B', 20);
		$this->SetTextColor(33, 136, 56); // Verde institucional
		$this->Cell(0, 15, utf8_decode('Reporte de Pronutario'), 0, 1, 'C');
		// Subtítulo con fecha
		$this->SetFont('Arial', '', 12);
		$this->SetTextColor(60, 60, 60);
		$this->Cell(0, 8, 'Fecha: ' . date('d/m/Y'), 0, 1, 'C');
		// Línea decorativa
		$this->SetDrawColor(33, 136, 56);
		$this->SetLineWidth(1);
		$this->Line(15, $this->GetY(), 195, $this->GetY());
		$this->Ln(8);
	}

// Pie de página

	function Footer() {
		// Pie de página profesional
		$this->SetY(-18);
		$this->SetDrawColor(33, 136, 56);
		$this->SetLineWidth(0.5);
		$this->Line(15, $this->GetY(), 195, $this->GetY());
		$this->SetFont('Arial', 'I', 8);
		$this->SetTextColor(100, 100, 100);
		$this->Cell(0, 8, utf8_decode('Comisión Federal de Electricidad - Todos los derechos reservados'), 0, 1, 'C');
		$this->Cell(0, 8, utf8_decode('Página ') . $this->PageNo() . '/{nb}', 0, 0, 'C');
	}

// --------------------METODO PARA ADAPTAR LAS CELDAS------------------------------
	var $widths;
	var $aligns;

	function SetWidths($w) {
		//Set the array of column widths
		$this->widths = $w;
	}

	function SetAligns($a) {
		//Set the array of column alignments
		$this->aligns = $a;
	}

	function Row($data, $setX) //yo modifique el script a  mi conveniencia :D
	{
		//Calculate the height of the row
		$nb = 0;
		for ($i = 0; $i < count($data); $i++) {
			$nb = max($nb, $this->NbLines($this->widths[$i], $data[$i]));
		}

		$h = 8 * $nb;
		//Issue a page break first if needed
		$this->CheckPageBreak($h, $setX);
		//Draw the cells of the row
		for ($i = 0; $i < count($data); $i++) {
			$w = $this->widths[$i];
			$a = isset($this->aligns[$i]) ? $this->aligns[$i] : 'C';
			//Save the current position
			$x = $this->GetX();
			$y = $this->GetY();
			//Draw the border
			$this->Rect($x, $y, $w, $h, 'DF');
			//Print the text
			$this->MultiCell($w, 8, $data[$i], 0, $a);
			//Put the position to the right of the cell
			$this->SetXY($x + $w, $y);
		}
		//Go to the next line
		$this->Ln($h);
	}

	function CheckPageBreak($h, $setX) {
		//If the height h would cause an overflow, add a new page immediately
		if ($this->GetY() + $h > $this->PageBreakTrigger) {
			$this->AddPage($this->CurOrientation);
			$this->SetX($setX);

			//volvemos a definir el  encabezado cuando se crea una nueva pagina
			$this->SetFont('Arial', 'B', 10);
			$this->Cell(10, 8, 'N', 1, 0, 'C', 0);
			$this->Cell(20, 8, 'categoria', 1, 0, 'C', 0);
			$this->Cell(30, 8, 'numeroerrores', 1, 0, 'C', 0);
			$this->Cell(30, 8, 'descripcion', 1, 0, 'C', 0);
			$this->Cell(30, 8, 'solucionoperativa', 1, 0, 'C', 0);
			$this->Cell(40, 8, 'soluciontecnica', 1, 0, 'C', 0);
			//$this->Cell(40, 8, 'poster', 1, 1, 'C', 0);
			$this->SetFont('Arial', '', 10);

		}

		if ($setX == 100) {
			$this->SetX(100);
		} else {
			$this->SetX($setX);
		}

	}

	function NbLines($w, $txt) {
		//Computes the number of lines a MultiCell of width w will take
		$cw = &$this->CurrentFont['cw'];
		if ($w == 0) {
			$w = $this->w - $this->rMargin - $this->x;
		}

		$wmax = ($w - 2 * $this->cMargin) * 1000 / $this->FontSize;
		$s = str_replace("\r", '', $txt);
		$nb = strlen($s);
		if ($nb > 0 and $s[$nb - 1] == "\n") {
			$nb--;
		}

		$sep = -1;
		$i = 0;
		$j = 0;
		$l = 0;
		$nl = 1;
		while ($i < $nb) {
			$c = $s[$i];
			if ($c == "\n") {
				$i++;
				$sep = -1;
				$j = $i;
				$l = 0;
				$nl++;
				continue;
			}
			if ($c == ' ') {
				$sep = $i;
			}

			$l += $cw[$c];
			if ($l > $wmax) {
				if ($sep == -1) {
					if ($i == $j) {
						$i++;
					}

				} else {
					$i = $sep + 1;
				}

				$sep = -1;
				$j = $i;
				$l = 0;
				$nl++;
			} else {
				$i++;
			}

		}
		return $nl;
	}
// -----------------------------------TERMINA---------------------------------
}

//------------------OBTENES LOS DATOS DE LA BASE DE DATOS-------------------------
$conexion = getConnexion();
//$conexion = $data->conect();
$strquery = "SELECT * FROM errores";
//$result = $conexion->prepare($strquery);
//$result->execute();
$result=$conexion->query($strquery);
$datos = $result->fetch_all(MYSQLI_ASSOC);

/* IMPORTANTE: si estan usando MVC o algún CORE de php les recomiendo hacer uso del metodo
que se llama *select_all* ya que es el que haria uso del *fetchall* tal y como ven en la linea 161
ya que es el que devuelve un array de todos los registros de la base de datos
si hacen uso de el metodo *select* hara uso de fetch y este solo selecciona una linea*/

//--------------TERMINA BASE DE DATOS-----------------------------------------------

// Creación del objeto de la clase heredada
$pdf = new PDF(); //hacemos una instancia de la clase
$pdf->AliasNbPages();
$pdf->AddPage(); //añade l apagina / en blanco
$pdf->SetMargins(10, 10, 10); //MARGENES
$pdf->SetAutoPageBreak(true, 20); //salto de pagina automatico

// -----------ENCABEZADO PROFESIONAL------------------
$pdf->SetX(15);
$pdf->SetFont('Arial', 'B', 11);
$pdf->SetFillColor(33, 136, 56); // Verde institucional
$pdf->SetTextColor(255,255,255);
$pdf->Cell(10, 10, 'N', 1, 0, 'C', true);
$pdf->Cell(30, 10, 'Categoria', 1, 0, 'C', true);
$pdf->Cell(25, 10, 'Num. Error', 1, 0, 'C', true);
$pdf->Cell(40, 10, 'Descripcion', 1, 0, 'C', true);
$pdf->Cell(40, 10, 'Sol. Operativa', 1, 0, 'C', true);
$pdf->Cell(40, 10, 'Sol. Tecnica', 1, 1, 'C', true);
// -------TERMINA----ENCABEZADO------------------

$pdf->SetFillColor(245, 245, 245); // color de fondo para filas
$pdf->SetDrawColor(200, 200, 200); // color de línea suave
$pdf->SetTextColor(60, 60, 60); // color texto normal
$pdf->SetFont('Arial', '', 10);

//El ancho de las celdas
$pdf->SetWidths(array(10, 30, 25, 40, 40, 40));
$pdf->SetAligns(array('C','C','C','L','L','L'));

for ($i = 0; $i < count($datos); $i++) {
	/* $pdf->Row(array($i + 1, $data[$i]['codigo'], ucwords(strtolower(utf8_decode($data[$i]['nombre']))), '$' . $data[$i]['precio']), 15); */
	$idCat = $datos[$i]['id_categoria'];
	$sql = "SELECT nombre FROM categoria WHERE id = '$idCat'";
	$result2 = $conexion->query($sql);
	$cate = '';
	if ($result2 && $result2->num_rows > 0) {
		$fila = mysqli_fetch_assoc($result2);
		$cate = $fila['nombre'];
	}
	$pdf->Row(array($i + 1, $cate, utf8_decode($datos[$i]['numeroerrores']), utf8_decode($datos[$i]['descripcion']), $datos[$i]['solucionoperativa'], utf8_decode($datos[$i]['soluciontecnica'])), 15);
}

// cell(ancho, largo, contenido,borde?, salto de linea?)

$nombreArchivo = 'reporte_de_pronutario_' . date('Y-m-d') . '.pdf';
$pdf->Output('D', $nombreArchivo);
?>