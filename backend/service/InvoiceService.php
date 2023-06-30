<?php

include_once '../data/InvoiceDao.php';

use setasign\Fpdi\Tcpdf\Fpdi;

class InvoiceService {
    public function createInvoicePdf($userId, $orderId) {
        // Rechnungsdaten aus der Datenbank abrufen
        $invoiceDao = new InvoiceDao();
        $invoiceData = $invoiceDao->getInvoiceData($userId, $orderId);

        // PDF-Datei erstellen und starten
        $pdf = new Fpdi();
        $pdf->AddPage();


        $pdf->SetFont('Helvetica', 'B', 16);
        $pdf->Cell(0, 10, 'Rechnung', 0, 1, 'C');

        // Daten in das PDF einfügen
        foreach ($invoiceData as $item) {
            $pdf->SetFont('Helvetica', '', 12);
            $pdf->Cell(0, 10, 'Rechnungsnummer: ' . $item['id'], 0, 1, 'L');
            $pdf->Cell(0, 10, 'Erstellt am: ' . $item['created_at'], 0, 1, 'L');
            $pdf->Cell(0, 10, 'Produkt: ' . $item['title'], 0, 1, 'L');
            $pdf->Cell(0, 10, 'Preis: ' . $item['price'] . ' EUR', 0, 1, 'L');
            $pdf->Cell(0, 10, 'Menge: ' . $item['quantity'], 0, 1, 'L');
            $pdf->Cell(0, 10, 'Gesamtpreis: ' . $item['total_position_price'] . ' EUR', 0, 1, 'L');
            $pdf->Cell(0, 10, 'Lieferadresse: ' . $item['address'], 0, 1, 'L');
            $pdf->Cell(0, 10, 'Bestellnummer: ' . $item['order_id'], 0, 1, 'L');
            $pdf->Cell(0, 10, 'Gesamtbetrag: ' . $item['total'] . ' EUR', 0, 1, 'L');
        }

        $filename = 'invoice_' . $invoiceData['invoice_number'] . '.pdf';
        $pdf->Output('F', $filename);

        return $filename;
    }
}
