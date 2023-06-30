<?php
include_once '../data/InvoiceDao.php';
require_once '../vendor/autoload.php';
require_once '../vendor/setasign/fpdf/fpdf.php';

class InvoiceService {
    public function createInvoicePdf($userId, $orderId) {
        $invoiceDao = new InvoiceDao();
        $invoiceData = $invoiceDao->getInvoiceData($userId, $orderId);

        $pdf = new Fpdf();
        $pdf->AddPage();

        $pdf->SetFont('Helvetica', 'B', 16);
        $pdf->Cell(0, 10, 'Rechnung', 0, 1, 'L');

        $pdf->SetFont('Helvetica', '', 12);
        $pdf->Cell(0, 10, 'Rechnungsnummer: ' . $invoiceData['id'], 0, 1, 'L');
        $pdf->Cell(0, 10, 'Kunde: ' . $invoiceData['first_name']." ".$invoiceData['last_name'] , 0, 1, 'L');
        $pdf->Cell(0, 10, 'Erstellt am: ' . $invoiceData['created_at'], 0, 1, 'L');
        $pdf->Cell(0, 10, 'Bestellnummer: ' . $invoiceData['order_fk'], 0, 1, 'L');
        $pdf->Cell(0, 10, 'Lieferadresse: ' . $invoiceData['address']."/ ".$invoiceData['postal_code']." ".$invoiceData['city'] , 0, 1, 'L');
        $pdf->Ln(10);

        $pdf->SetFont('Helvetica', 'B', 12);
        $pdf->Cell(70, 10, 'Produkt', 1, 0, 'C');
        $pdf->Cell(30, 10, 'Preis', 1, 0, 'C');
        $pdf->Cell(25, 10, 'Menge', 1, 0, 'C');
        $pdf->Cell(40, 10, 'Gesamtpreis', 1, 1, 'C');

        $pdf->SetFont('Helvetica', '', 12);
        foreach ($invoiceData['items'] as $item) {
            $pdf->Cell(70, 10, $item['title'], 1, 0, 'L');
            $pdf->Cell(30, 10, $item['price'] . ' EUR', 1, 0, 'L');
            $pdf->Cell(25, 10, $item['quantity'], 1, 0, 'L');
            $pdf->Cell(40, 10, $item['total_position_price'] . ' EUR', 1, 1, 'L');
        }

        $pdf->SetFont('Helvetica', 'B', 12);
        $pdf->Cell(125, 10, 'Gesamtbetrag', 1, 0, 'R');
        $pdf->Cell(40, 10, $invoiceData['total'] . ' EUR', 1, 1, 'L');

        $filename = 'files/invoice_' . $invoiceData['id'] . '.pdf';
        $pdf->Output('F', $filename);

        return $filename;
    }
}
