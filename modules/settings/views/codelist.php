<?php

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetTitle('Student Code');

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image ratio
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
    require_once(dirname(__FILE__).'/lang/eng.php');
    $pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// set font
$pdf->SetFont('times', '', 10);

// remove header and footer
$pdf->SetPrintHeader(false);
$pdf->SetPrintFooter(false);

// use the font
$pdf->SetFont('robotolight', '', 12);



// add a page
$pdf->AddPage();

$title = '
<style type="text/css">
    *{
        font-family: slimsansserif;
    }
    .text-center{
        text-align: center;
    }
</style>';
$title .= '<h1 class = "text-center">Student Code</h1>';
$pdf->writeHTML($title, true, false, false, false, ''); 


// set padding
$pdf->setCellPaddings(0,8,0,8);

//Print Table

if(!empty($students) && isset($students)){
$table = '
<style type="text/css">
    *{
        font-family: slimsansserif;
    }
    .text-center{
        text-align: center;
    }

    .table-image{
        width: 150px;
        margin-bottom: 15px;
    }

    .wd30{
        width: 30%;
    }

    .wd40{
         width: 40%;
    }

    .text-left{
        text-align: left;
    }

 
    tr.list td {
        border-bottom:1px solid black;
    }
  

    table { 
        border-collapse: collapse; 
        margin: 10px; 
    }
    .name {
        font-weight: 300;
        font-family: robotolight;
    }

    .code {
        font-weight: 500;
        font-family: robotomedium;
    }
 </style>';

$table .= '<table style="width: 100%"><tbody>';
foreach ($students as $k => $v) { 
$table .= '
        <tr class="list">
            <td class="wd40 text-left"><img class="table-image" src="assets/images/logo_black_medium.png"><br><br>Your access to your daily school life:<br>https://edtools.io/student</td>
            <td class="wd30 text-center"><br><h3>Name</h3>  <p class = "name">'.$v['student_name'].'</p></td>
            <td class="wd30 text-center"><br><h3 style="font-weight: 500;">Code</h3>  <p class = "name">'.$v['code'].'</p></td>
        </tr>';
} 
$table .= '</tbody></table>'; 
$pdf->writeHTML($table, true, false, false, false, '');                                   

}

// move pointer to last page
$pdf->lastPage();

// ---------------------------------------------------------

//Close and output PDF document
ob_clean();
$pdf->Output('student_code.pdf', 'I');



