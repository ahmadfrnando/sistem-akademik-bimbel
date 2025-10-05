<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Laporan Data Siswa</title>
    <style>
        @page {
            margin: 20mm;
        }

        body {
            font-family: "Arial", sans-serif;
            margin: 0;
            padding: 0;
            color: #333;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }

        .header img {
            width: 70px;
            height: 70px;
            object-fit: contain;
            display: block;
            margin: 0 auto 10px;
        }

        .header h1 {
            margin: 0;
            font-size: 20px;
            text-transform: uppercase;
        }

        .header p {
            margin: 5px 0;
            font-size: 14px;
        }

        .table-container {
            margin: 20px auto;
            width: 100%;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 14px;
        }

        th,
        td {
            border: 1px solid #444;
            padding: 8px 10px;
            text-align: left;
        }

        th {
            background-color: #f0f0f0;
        }

        .note {
            margin-top: 30px;
            font-size: 12px;
            text-align: right;
            font-style: italic;
            color: #555;
        }

        /* Style saat print */
        @media print {
            body {
                margin: 0;
            }

            .note {
                page-break-before: avoid;
            }
        }
    </style>
</head>

<body>
    <!-- Header -->
    <div class="header">
        <img src="{{ public_path('images/logo.png') }}"
            alt="Logo Tempat Kursus"
            style="width: 100px; height: 100px; object-fit: contain;" />
        <h1>STAR ONE EDUCATION CENTER</h1>
        <p>Jl. Kapten Muslim Gang Kesehatan No. 13 Medan</p>
    </div>

    <!-- Tabel Data Siswa -->
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Siswa</th>
                    <th>Tanggal Lahir</th>
                    <th>Alamat</th>
                </tr>
            </thead>
            <tbody>
                @foreach($siswa as $index => $s)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $s->nama }}</td>
                    <td>{{ \Carbon\Carbon::parse($s->tanggal_lahir)->translatedFormat('d F Y') }}</td>
                    <td>{{ $s->alamat }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Note -->
    <div class="note">
        Laporan ini dicetak pada tanggal:
        {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y H:i') }}
    </div>
</body>

</html>