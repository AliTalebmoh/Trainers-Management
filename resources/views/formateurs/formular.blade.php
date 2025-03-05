<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formateur Formular</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            padding: 20px;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
        }

        .info-section {
            margin-bottom: 20px;
        }

        .info-row {
            margin-bottom: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }

        .signature-section {
            margin-top: 50px;
            display: flex;
            justify-content: space-between;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>AL AKHAWAYN UNIVERSITY</h1>
        <h2>AZROU CENTER</h2>
    </div>

    <div class="info-section">
        <div class="info-row">
            <strong>Nom et prénom du formateur:</strong> {{ $formateur->name }}
        </div>
        <div class="info-row">
            <strong>Matières enseignées:</strong> {{ $formateur->matiere }}
        </div>
        <div class="info-row">
            <strong>Période:</strong> {{ request()->month }}/2025
        </div>
        <div class="info-row">
            <strong>Numéro du compte bancaire:</strong> {{ $formateur->rib }} ({{ $formateur->name_bank }})
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>DATE</th>
                <th>HEURE D'ENTREE</th>
                <th>HEURE DE SORTIE</th>
                <th>NOMBRE D'HEURES</th>
                <th>PRIX / HEURE</th>
                <th>Prix Global</th>
            </tr>
        </thead>
        <tbody>
            @foreach($seances as $seance)
            <tr>
                <td>{{ $seance->duration_month }}/2025</td>
                <td>14h30</td>
                <td>17h30</td>
                <td>3</td>
                <td>{{ $salary->price_hour }}</td>
                <td>{{ $salary->price_month }}</td>
            </tr>
            @endforeach
            <tr>
                <td colspan="3">Total</td>
                <td>{{ count($seances) * 3 }}</td>
                <td></td>
                <td>{{ count($seances) * $salary->price_month }} Dhs</td>
            </tr>
        </tbody>
    </table>

    <div class="signature-section">
        <div>
            <p><strong>Centre d'Azrou:</strong> _________________</p>
        </div>
        <div>
            <p><strong>Le formateur:</strong> _________________</p>
        </div>
    </div>
</body>
</html>