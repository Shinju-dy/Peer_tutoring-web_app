<?php
require_once '../vendor/autoload.php';

use Dompdf\Dompdf;

function generate_pdf($html) {
    $dompdf = new Dompdf();
    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();
    $dompdf->stream("report.pdf", array("Attachment" => false));
    exit(0);
}
?>

