<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ __('invoices.invoice', ['id' => $invoice->number]) }}</title>
    <style>
        @page {
            margin: 120px 50px 150px 50px;
        }
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 13px;
            color: #111;
        }
        /* Header */
        header {
            position: fixed;
            top: -90px;
            left: 0;
            right: 0;
            height: 60px;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
        }
        .header-table {
            width: 100%;
            border-collapse: collapse;
        }
        .header-table td {
            vertical-align: middle;
        }
        .header-right {
            text-align: right;
            font-size: 11px;
            line-height: 1.4;
            color: #333;
        }
        
        /* Footer */
        footer {
            position: fixed;
            bottom: -120px;
            left: 0;
            right: 0;
            height: 100px;
            border-top: 1px solid #ccc;
            padding-top: 10px;
            font-size: 10px;
            color: #444;
            line-height: 1.4;
        }
        .footer-table {
            width: 100%;
            border-collapse: collapse;
        }
        .footer-table td {
            vertical-align: top;
            width: 33.33%;
        }

        /* Content */
        .address-window {
            margin-top: 20px;
            float: left;
            width: 60%;
        }
        .sender-line {
            font-size: 9px;
            text-decoration: underline;
            color: #666;
            margin-bottom: 10px;
        }
        .meta-box {
            float: right;
            width: 35%;
            margin-top: 10px;
        }
        .meta-table {
            width: 100%;
            font-size: 12px;
            border-collapse: collapse;
        }
        .meta-table td {
            padding: 3px 0;
        }
        .meta-table td:last-child {
            text-align: right;
        }
        .clearfix {
            clear: both;
        }

        /* Items Table */
        .invoice-items {
            width: 100%;
            border-collapse: collapse;
            margin-top: 50px;
        }
        .invoice-items th {
            text-align: left;
            background-color: #f4f4f4;
            border-top: 1px solid #000;
            border-bottom: 1px solid #000;
            padding: 8px 5px;
            font-size: 12px;
            font-weight: bold;
        }
        .invoice-items th:last-child {
            text-align: right;
        }
        .invoice-items td {
            padding: 10px 5px;
            border-bottom: 1px solid #ddd;
            font-size: 12px;
            vertical-align: top;
        }
        .invoice-items td:last-child {
            text-align: right;
        }

        /* Totals */
        .totals-section {
            width: 100%;
            margin-top: 20px;
        }
        .totals-table {
            float: right;
            width: 40%;
            border-collapse: collapse;
        }
        .totals-table td {
            padding: 5px;
            font-size: 12px;
        }
        .totals-table td:last-child {
            text-align: right;
        }
        .total-row td {
            font-weight: bold;
            font-size: 14px;
            border-top: 2px solid #000;
            border-bottom: 2px solid #000;
            background-color: #f4f4f4;
        }
        
        .tax-note {
            margin-top: 40px;
            font-size: 12px;
            color: #333;
        }
        
        /* Status Badge */
        .status-badge {
            font-size: 12px;
            font-weight: bold;
            padding: 3px 8px;
            border-radius: 4px;
            border: 1px solid #000;
            float: right;
        }
        .status-paid { color: #155724; background-color: #d4edda; border-color: #c3e6cb; }
        .status-pending { color: #856404; background-color: #fff3cd; border-color: #ffeeba; }
        .status-cancelled { color: #721c24; background-color: #f8d7da; border-color: #f5c6cb; }
    </style>
</head>
<body>

    <!-- Header -->
    <header>
        <table class="header-table">
            <tr>
                <td>
                    @if(config('settings.logo'))
                        <img style="height: 35px;" src="{{ public_path('storage/' . config('settings.logo')) }}" alt="Logo">
                    @else
                        <h1 style="margin:0; font-size: 24px;">JURO Digital GbR</h1>
                    @endif
                </td>
                <td class="header-right">
                    <strong>Rechnungssteller:</strong><br>
                    JURO Digital GbR<br>
                    Nachkamp 22<br>
                    48324 Sendenhorst-Albersloh<br><br>
                    <strong>E-Mail:</strong> info@juro-digital.de<br>
                    <strong>Web:</strong> juro-digital.de
                </td>
            </tr>
        </table>
    </header>

    <!-- Footer -->
    <footer>
        <table class="footer-table">
            <tr>
                <td>
                    <strong>Banküberweisung:</strong><br>
                    Banking Circle S.A. - German Branch<br>
                    Empfänger: JURO Digital GbR<br>
                    IBAN: DE63 2022 0800 0045 3413 95<br>
                    BIC: SXPYDEHHXXX<br>
                    <strong>Verwendungszweck: {{ $invoice->number }}</strong>
                </td>
                <td>
                    <strong>Steuerinformationen:</strong><br>
                    Steuernummer: 5304059584232<br>
                    USt-IdNr.: DE465087010<br>
                    
                </td>
                <td>
                    <strong>PayPal Überweisung:</strong><br>
                                        Empfänger: info@juro-digital.de<br>
                    <strong>Verwendungszweck: {{ $invoice->number }}</strong>
                </td>
            </tr>
        </table>
        <!-- Page numbers via DOMPDF inline script -->
        <script type="text/php">
            if (isset($pdf)) {
                $text = "Seite {PAGE_NUM} von {PAGE_COUNT}";
                $size = 9;
                $font = $fontMetrics->getFont("Helvetica");
                $width = $fontMetrics->get_text_width($text, $font, $size) / 2;
                $x = ($pdf->get_width() - $width) / 2;
                $y = $pdf->get_height() - 35;
                $pdf->page_text($x, $y, $text, $font, $size, array(0,0,0));
            }
        </script>
    </footer>

    <!-- Main Content -->
    <main>
        
        <!-- Address & Meta Box -->
        <div>
            <div class="address-window">
                <div class="sender-line">JURO Digital GbR, Nachkamp 22, 48324 Sendenhorst-Albersloh</div>
                <div style="font-size: 13px; line-height: 1.5;">
                    {{ $invoice->user_name }}<br>
                    @if($invoice->user_properties)
                        @foreach($invoice->user_properties as $property)
                            {{ $property }}<br>
                        @endforeach
                    @endif
                </div>
            </div>

            <div class="meta-box">
                @php
                    $statusClass = 'status-pending';
                    $statusText = 'Ausstehend';
                    if($invoice->status == 'paid') {
                        $statusClass = 'status-paid';
                        $statusText = 'Bezahlt';
                    } elseif($invoice->status == 'cancelled') {
                        $statusClass = 'status-cancelled';
                        $statusText = 'Storniert';
                    }
                @endphp
                
                <table class="meta-table">
                    <tr>
                        <td colspan="2" style="text-align:right; padding-bottom:15px;">
                            <span class="status-badge {{ $statusClass }}">{{ $statusText }}</span>
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Rechnungsnr.:</strong></td>
                        <td>{{ $invoice->number }}</td>
                    </tr>
                    <tr>
                        <td><strong>Kundennr.:</strong></td>
                        <td>{{ $invoice->user_id }}</td>
                    </tr>
                    <tr>
                        <td><strong>Datum:</strong></td>
                        <td>{{ $invoice->created_at->translatedFormat('d.m.Y') }}</td>
                    </tr>
                </table>
            </div>
            <div class="clearfix"></div>
        </div>

        <!-- Title & Intro -->
        <div style="margin-top: 60px;">
            <h1 style="font-size: 22px; margin-bottom: 15px;">Rechnung {{ $invoice->number }}</h1>
            <p>
                Ich bitte um eine Begleichung des gesamten Rechnungsbetrages bis spätestens: 
                <strong>{{ $invoice->due_at ? $invoice->due_at->translatedFormat('d.m.Y') : $invoice->created_at->addDays(14)->translatedFormat('d.m.Y') }}</strong>.
            </p>
        </div>

        <!-- Items Table -->
        <table class="invoice-items">
            <thead>
                <tr>
                    <th style="width: 5%;">Pos.</th>
                    <th style="width: 55%;">Bezeichnung</th>
                    <th style="width: 10%; text-align: center;">Menge</th>
                    <th style="width: 15%; text-align: right;">Einzel €</th>
                    <th style="width: 15%; text-align: right;">Gesamt €</th>
                </tr>
            </thead>
            <tbody>
                @php $pos = 1; @endphp
                @foreach($invoice->items as $item)
                <tr>
                    <td>{{ $pos++ }}</td>
                    <td>
                        <strong>{{ $item->description }}</strong>
                        @if($item->reference && $item->reference->label)
                            <br><span style="color: #666; font-size: 11px;">{{ $item->reference->label }}</span>
                        @endif
                    </td>
                    <td style="text-align: center;">{{ $item->quantity }}</td>
                    <td style="text-align: right;">{{ $item->formattedPrice }}</td>
                    <td style="text-align: right;">{{ $item->formattedTotal }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Totals -->
        <div class="totals-section">
            <table class="totals-table">
                @if ($invoice->formattedTotal->tax > 0)
                    <tr>
                        <td>Zwischensumme</td>
                        <td>{{ $invoice->formattedTotal->format($invoice->formattedTotal->price - $invoice->formattedTotal->tax) }}</td>
                    </tr>
                    <tr>
                        <td>{{ $invoice->tax->name }} ({{ $invoice->tax->rate }}%)</td>
                        <td>{{ $invoice->formattedTotal->formatted->tax }}</td>
                    </tr>
                @endif
                <tr class="total-row">
                    <td>Gesamtbetrag</td>
                    <td>{{ $invoice->formattedTotal }}</td>
                </tr>
            </table>
            <div class="clearfix"></div>
        </div>

        <!-- Notes -->
        <div class="tax-note">
            @if ($invoice->formattedTotal->tax == 0)
                <p>*Umsatzsteuerfreie Leistungen gemäß §19 UStG.</p>
            @endif
            <p style="margin-top: 15px;">&lt;----- Zahlungsfrist 14 Tage -----&gt;</p>
            <p><strong>Vermerk:</strong> Kunde muss manuell den Betrag zahlen.</p>
        </div>

    </main>
</body>
</html>
