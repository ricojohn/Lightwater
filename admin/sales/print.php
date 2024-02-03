<?php
require('../../fpdf/fpdf.php');
$conn = mysqli_connect("localhost", "root", "", "light_water_db");
if(isset($_GET['orderid'])){
    $order_id = $_GET['orderid'];
}else{
    header("Refresh:0; url=http://localhost/lightwater/");
}
class PDF extends FPDF {
    protected $widths;
    protected $aligns;

    function SetWidths($w)
    {
        // Set the array of column widths
        $this->widths = $w;
    }

    function SetAligns($a)
    {
        // Set the array of column alignments
        $this->aligns = $a;
    }

    function Row($data)
    {
        // Calculate the height of the row
        $nb = 0;
        for($i=0;$i<count($data);$i++)
            $nb = max($nb,$this->NbLines($this->widths[$i],$data[$i]));
        $h = 5*$nb;
        // Issue a page break first if needed
        $this->CheckPageBreak($h);
        // Draw the cells of the row
        for($i=0;$i<count($data);$i++)
        {
            $w = $this->widths[$i];
            $a = isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
            // Save the current position
            $x = $this->GetX();
            $y = $this->GetY();
            // Draw the border
            $this->Rect($x,$y,$w,$h);
            // Print the text
            $this->MultiCell($w,5,$data[$i],0,$a);
            // Put the position to the right of the cell
            $this->SetXY($x+$w,$y);
        }
        // Go to the next line
        $this->Ln($h);
    }

    function CheckPageBreak($h)
    {
        // If the height h would cause an overflow, add a new page immediately
        if($this->GetY()+$h>$this->PageBreakTrigger)
            $this->AddPage($this->CurOrientation);
    }

    function NbLines($w, $txt)
    {
        // Compute the number of lines a MultiCell of width w will take
        if(!isset($this->CurrentFont))
            $this->Error('No font has been set');
        $cw = $this->CurrentFont['cw'];
        if($w==0)
            $w = $this->w-$this->rMargin-$this->x;
        $wmax = ($w-2*$this->cMargin)*1000/$this->FontSize;
        $s = str_replace("\r",'',(string)$txt);
        $nb = strlen($s);
        if($nb>0 && $s[$nb-1]=="\n")
            $nb--;
        $sep = -1;
        $i = 0;
        $j = 0;
        $l = 0;
        $nl = 1;
        while($i<$nb)
        {
            $c = $s[$i];
            if($c=="\n")
            {
                $i++;
                $sep = -1;
                $j = $i;
                $l = 0;
                $nl++;
                continue;
            }
            if($c==' ')
                $sep = $i;
            $l += $cw[$c];
            if($l>$wmax)
            {
                if($sep==-1)
                {
                    if($i==$j)
                        $i++;
                }
                else
                    $i = $sep+1;
                $sep = -1;
                $j = $i;
                $l = 0;
                $nl++;
            }
            else
                $i++;
        }
        return $nl;
    }

    public function Header(){
        $conn = mysqli_connect("localhost", "root", "", "light_water_db");
        $order_id = $_GET['orderid'];
        $query = "SELECT *
        FROM orders
        INNER JOIN order_list ON orders.id = order_list.order_id
        INNER JOIN sales ON orders.id = sales.order_id 
        INNER JOIN clients ON orders.client_id = clients.id
        INNER JOIN products ON order_list.product_id = products.id
        WHERE orders.paid = '1' AND orders.id = '$order_id'";
        $run = $conn->query($query);
        $row = $run->fetch_assoc();
        $date = date_create($row['date_created']);

        $this->Image('../../uploads/1701871080_received_347587078009688.jpeg', 35, 18, 20);

        
        // ------- Company Name ------ 
        $this->SetFont('Times','B',17);
        $this->Cell(0, 20, 'Light Water Refilling Station', 0, 0, 'C');
        $this->Ln(5);

        // ------- Address ------ 
        $this->SetFont('Times','',10);
        // $this->MultiCell(80,4,''.$address.'', '', 'C',false);
        $this->SetY(-274);    
        $this->Cell(55,20,'','0');
        $this->MultiCell(80, 4, 'Gen. trias Cavite City', '0', 'C', false);
        $this->Cell(0, 5, 'lightwater106@gmail.com', 0, 0, 'C');


        $this->SetFont('Times','B',16);
        $this->Cell(-192, 20, 'Sales Invoice', 0, 0, 'C');
        $this->Ln(5);

        // ------- Checkbox ------ 
        $this->SetFont('Times','',12);
        $this->Cell(90, 25, '', 0, 0, 'C');
        $this->Cell(125, 25, '', 0, .5, 'C');
        $this->Cell(110, -15, '', 0, 0, 'C');
        $this->Ln(0);


        $this->SetFont('Times','B',13);
        $this->Cell(0, 10, 'Date:', 0, 0, 'L');
        $this->Cell(-300, 10, date_format($date,'M d ,Y' ), 0, 0, 'C');
        $this->Ln(5);

        // ------- Date ------ 
        $this->Cell(260, 0, 'Invoice No:', 0, 0, 'C');
        $this->Cell(-210, 0, '00'.rand(1000,9000), 0, 0, 'C');
        $this->Ln(5);

        // ------- Signature ------ 
        $this->Cell(0, 20, 'Name:', 0, 0, 'L');
        $this->Cell(-292, 20, $row['firstname'].' '.$row['lastname'], 0, 0, 'C');
        $this->Ln(1);

        $this->Cell(0, 35, 'Address:', 0, 0, 'L');
        $this->Cell(-247, 35, str_replace(',',' ', $row['default_delivery_address']), 0, 0, 'C');
        $this->Ln(1);

        $this->Cell(0, 50, 'Email:', 0, 0, 'L');
        $this->Cell(-281, 50, $row['email'], 0, 0, 'C');
        $this->Ln(40);

        $this->Cell(190, 10, '', '1', 0, 'C');

        // $remarks =  $sql_row['remarks'];
		// $explode_remarks = explode("<br/>", $remarks);
		// $remark_count = count($explode_remarks);
		// for($i=0; $i<$remark_count; $i++){
		// 	$last_remark = $explode_remarks[$i];

        //     $this->Cell(100, 130, ''.$last_remark.'', 0, 0, 'C');
        //     $this->Ln(8);
		// } 
    }
}      

// Create new object.
$pdf = new PDF('P', 'mm', 'A4');
$pdf->AliasNbPages('{pages}');
$pdf->SetAutoPageBreak(true,70);
// Add new pages
$pdf->AddPage();

$pdf->SetY(114);$pdf->SetX(15);$pdf->Cell(0,0, 'Quantity');
$pdf->SetY(114);$pdf->SetX(70);$pdf->Cell(0,0, 'Description');
$pdf->SetY(114);$pdf->SetX(130);$pdf->Cell(0,0, 'Unit Price');
$pdf->SetY(114);$pdf->SetX(180);$pdf->Cell(0,0, 'Cost');

$query = "SELECT *
FROM orders
INNER JOIN order_list ON orders.id = order_list.order_id
INNER JOIN sales ON orders.id = sales.order_id 
INNER JOIN clients ON orders.client_id = clients.id
INNER JOIN products ON order_list.product_id = products.id
WHERE orders.paid = '1' AND orders.id = '$order_id'";
$total = 0;
$run = $conn->query($query);
$pdf->SetFont('Times','',13);
while ($row = $run->fetch_assoc()){
    $subtotal = $row['quantity'] * $row['price'];
    $tax = $subtotal * .12;
    $pdf->SetY(130);$pdf->SetX(20);$pdf->Cell(0,0, $row['quantity']);
    $pdf->SetY(130);$pdf->SetX(70);$pdf->Cell(0,0, $row['title']);
    $pdf->SetY(130);$pdf->SetX(137);$pdf->Cell(0,0, number_format($row['price'],2));
    $pdf->SetY(130);$pdf->SetX(180);$pdf->Cell(0,0, number_format($row['total'],2));
}
                        

$pdf->SetY(190);$pdf->SetX(155);$pdf->Cell(0,0, 'Sub Total');
$pdf->SetY(190);$pdf->SetX(180);$pdf->Cell(0,0, number_format($subtotal, 2));

$pdf->SetY(200);$pdf->SetX(155);$pdf->Cell(0,0, 'Sub Total');
$pdf->SetY(200);$pdf->SetX(180);$pdf->Cell(0,0, number_format($tax, 2));

$pdf->SetFont('Times','B',13);
$pdf->SetY(210);$pdf->SetX(155);$pdf->Cell(0,0, 'Total', '0', '0');
$pdf->SetY(210);$pdf->SetX(180);$pdf->Cell(0,0, number_format($tax + $subtotal, 2));



$pdf->Output();
?>