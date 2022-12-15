<?php
require('fpdf184/fpdf.php');

global $conn;
include "dbconn.php";

class PDF extends FPDF {
	function Header(){
		$this->SetFont('Arial','B',15);
		
		//dummy cell to put logo
		//$this->Cell(12,0,'',0,0);
		//is equivalent to:
		$this->Cell(12);
		
		//put logo
		$this->Image('images/icon.png',10,10,10);
		
		$this->Cell(100,10,'Summary Transaction',0,1);
		
		//dummy cell to give line spacing
		//$this->Cell(0,5,'',0,1);
		//is equivalent to:
		$this->Ln(5);

        $this->SetFont('Arial','B',11);

        $this->SetFillColor(204, 221, 255);
        $this->SetDrawColor(50,50,100);
        $this->Cell(25,5,'Order ID',1,0,'',true);
        $this->Cell(40,5,'Name',1,0,'',true);
        $this->Cell(50,5,'Transaction ID',1,0,'',true);
        $this->Cell(35,5,'Total Amount',1,0,'',true);
        $this->Cell(40,5,'Date',1,1,'',true);

	}
	function Footer(){
		$this->Cell(190,0,'','T',1,'',true);
		//Go to 1.5 cm from bottom
		$this->SetY(-15);
				
		$this->SetFont('Arial','',8);
		
		//width = 0 means the cell is extended up to the right margin
		$this->Cell(0,10,'Page '.$this->PageNo()." / {pages}",0,0,'C');
	}
}

//A4 width : 219mm
//default margin : 10mm each side
//writable horizontal : 219-(10*2)=189mm

$pdf = new PDF('P','mm','A4'); //use new class

//define new alias for total page numbers
$pdf->AliasNbPages('{pages}');

$pdf->SetAutoPageBreak(true,15);
$pdf->AddPage();

$pdf->SetFont('Arial','',9);
$pdf->SetDrawColor(50,50,100);

$query=mysqli_query($conn,"SELECT transtb.orderID, myuser.first_name, myuser.last_name, transtb.transID, transtb.totalAmount, transtb.date FROM transtb INNER JOIN myuser ON transtb.userID = myuser.no");
while($row = mysqli_fetch_array($query)) {
    $pdf->Cell(25,5,$row['orderID'],'LR',0);
    $pdf->Cell(40,5,$row['first_name'] .' ' . $row['last_name'],'LR',0);
    $pdf->Cell(50,5,$row['transID'],'LR',0);
    $pdf->Cell(35,5,$row['totalAmount'],'LR',0);
    $pdf->Cell(40,5,$row['date'],'LR',1);
}

$pdf->Output();
?>

