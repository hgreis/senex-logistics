<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use PDF;
use App\Mission;
use App\Driver;
use App\Customer;


class Bill extends Model
{
    protected $fillable = [
    	'date', 'priceNet', 'priceGross', 'taxes', 'customer',
    ];
    
    public function missions() {
    	return $this->hasMany('App\Mission');
    }

    public function savePDF($id, $customer) {
    	$bill = Bill::with('missions')->find($id);
        $customer = $this->customer;
        $customer = Customer::where('name', $customer)->first();
    

        $html2 ='
                <p style="text-align: center; font-size:8; font-weight:normal">
                    Bitte buchen Sie innerhalb von 14 Tagen den Rechnungsbetrag auf das Konto:<br>
                    Inhaber: DEKRA Transport GmbH / Steuernummer: <br>
                    Kontonummer: 0648489890  /  BLZ: 50010517<br>
                    IBAN: DE12500105170648489890 <br>
                </p>
        ';
        $pdf = new PDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf::SetTitle('Rechnung');
        $pdf::SetMargins(20,30,20,20);
        $pdf::SetHeaderCallback(function($pdf) {
                // Position at 15 mm from bottom
                $pdf->SetY(15);
                // Set font
                $pdf->SetFont('helvetica', 'b', 20);
                // Page number
                $pdf->Cell(0, 10,'DEKRA-TRANSPORT' , 0, false, 'C', 0, '', 0, false, 'T', 'M');
        });
        $pdf::setFooterCallback(function($pdf) {
                // Position at 15 mm from bottom
                $pdf->SetY(-15);
                // Set font
                $pdf->SetFont('helvetica', '', 8);
                // Page number
                $pdf->Cell(0, 10, 'Seite '.$pdf->getAliasNumPage().'/'.$pdf->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
        });
        $pdf::AddPage();

        //adressfield
        $pdf::Ln(20);
        $pdf::SetFont('helvetica','',7);
        $pdf::Cell(0, 0, 'DEKRA-TRANSPORT - Dahlener Str. 570 - 41239 Mönchengladbach', 0, 1, '', 0, '', 0);
        $pdf::SetFont('times','',10);
        $pdf::Cell(0,0,$customer->name,0,1);
        $pdf::Cell(0,0,$customer->street,0,1);
        $pdf::Cell(0,0,$customer->city,0,1);
        $pdf::Cell(0,0,$customer->country,0,1);

        // Logo
        $image_file = 'images/dekra.jpg';
        $pdf::Image($image_file, 150, 50, 40, '', 'JPG', '', 'R', false, 300, '', false, false, 0, false, false, false);

        // head with invoice-number
        $pdf::Ln(20);
        $pdf::Cell(0,0,'Mönchengladbach, den '.$bill->date ,0,1,'R');
        $pdf::Ln(10);
        $pdf::SetFont('helvetica','B',15);
        $pdf::Cell(0,0,'Rechnungs-Nr.: '.$bill->id,0,1);

        // table with missions
        $pdf::Ln(10);
        $pdf::SetFont('helvetica','B',10);
        $pdf::Cell(25,0,'Auftrags-Nr.',1,0,'C');
        $pdf::Cell(25,0,'Lieferdatum',1,0,'C');
        $pdf::Cell(100,0,'Tourenbeschreibung',1,0,'C');
        $pdf::Cell(20,0,'Preis',1,1,'C');
        $pdf::SetFont('helvetica','',10);
        $pdf::Ln(2);
        foreach ($bill->missions as $mission) {
            if (isset($mission->kundeBemerkung)) {
                $pdf::Cell(50,0,'',0,0,'C');
                $pdf::Cell(100,0,$mission->kundeBemerkung,0,1,'L');
            }
            $pdf::Cell(25,0,$mission->id,0,0,'C');
            $pdf::Cell(25,0,date("d.m.Y", strtotime($mission->zielDatum)),0,0,'C');
            $pdf::Cell(100,0,'Abholung: '.$mission->startOrt,0,0,'L');
            $pdf::Cell(18,0,number_format($mission->preisKunde, 2, ",", "").' €',0,1,'R');
            $pdf::Cell(50,0,'',0,0,'C');
            $pdf::Cell(100,0,'Auslieferung: '.$mission->zielOrt,0,1,'L');
            $pdf::Ln(5);
        };
        $pdf::writeHTML('<hr>');

        //summary with taxes
        $pdf::Cell(50,0,'',0,0);
        $pdf::Cell(100,0,'Summe (netto)',0,0,'R');
        $pdf::Cell(18,0,number_format($bill->priceNet, 2, ',', '').' €',0,1,'R');
        $pdf::Cell(50,0,'',0,0);
        $pdf::Cell(100,0,$customer->taxes.'% Mehrwertsteuer',0,0,'R');
        $pdf::Cell(18,0,number_format($bill->priceNet*($customer->taxes/100), 2, ',', '').' €',0,1,'R');
        $pdf::SetFont('helvetica','b',10);
        $pdf::Cell(50,0,'',0,0);
        $pdf::Cell(100,0,'Rechnungsbetrag (brutto)',0,0,'R');
        $pdf::Cell(18,0,number_format($bill->priceGross, 2, ',', '').' €',0,1,'R');

		// payment advice
		$pdf::SetY(-40);
		$pdf::writeHTML($html2, true, false, true, false, '');

		//save the PDF file 
		$pdf::Output(public_path('Rechnungen/Rechnung ' .$bill->id . '.pdf'), 'F');
		$pdf::reset();
		return;
	}
}
