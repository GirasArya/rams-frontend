<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Record Pemeliharaan</title>
</head>

<body>
    <table style="width: 100%; font-family: Arial, sans-serif; padding: 2rem;">
        <thead>
            <tr>
                <th colspan="7"
                    style="text-align: center; font-size: 36px; text-transform: uppercase; font-weight: bold; padding-bottom: 2rem;">
                    Rencana Anggaran Pemeliharaan
                </th>
            </tr>
        </thead>
        
        <br />

        <tbody>
            <tr>
                <td colspan="7" style="padding: 10px; font-size: 14px;">
                    <table style="width: 100%; font-size: 14px;">
                        <tr>
                            <td style="font-weight: bold; width: 20%;">Nama Pemeliharaan</td>
                            <td><b>: </b> {{ $data['nama'] ?? '-' }}</td>

                            <td style="font-weight: bold;">Ruas Jalan</td>
                            <td><b>: </b> {{ $data['ruas_jalan'][0]['nama'] ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold;">KM Awal</td>
                            <td><b>: </b> {{ $data['km_awal'] ?? '-' }}</td>

                            <td style="font-weight: bold;">KM Akhir</td>
                            <td><b>: </b> {{ $data['km_akhir'] ?? '-' }}</td>

                            <td style="font-weight: bold;">Jalur</td>
                            <td><b>: </b> {{ $data['jalur'] ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold;">Panjang Segmen Pemeliharaan</td>
                            <td><b>: </b> {{ $selisihKM ?? '-' }} Meter</td>

                            <td style="font-weight: bold;">Periode</td>
                            <td><b>: </b> {{ date('Y', strtotime($data['periode_awal'])) }} -
                                {{ date('Y', strtotime($data['periode_akhir'])) }}</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </tbody>
        
        <br />

        <thead>
            <tr style="background-color: #f2f2f2;">
                <th style="padding: 10px; font-size: 14px; text-align: center;">Tahun</th>
                <th style="padding: 10px; font-size: 14px; text-align: center;">Nama Kegiatan</th>
                <th style="padding: 10px; font-size: 14px; text-align: center;">Jenis Pemeliharaan</th>
                <th style="padding: 10px; font-size: 14px; text-align: center;">Frekuensi/Tahun</th>
                <th style="padding: 10px; font-size: 14px; text-align: center;">Anggaran per Meter</th>
                <th style="padding: 10px; font-size: 14px; text-align: center;">Jumlah Tenaga Kerja</th>
                <th style="padding: 10px; font-size: 14px; text-align: center;">Total Biaya Tahunan</th>
            </tr>
        </thead>

        <tbody>
            @php
                $previousYear = null;
            @endphp
            @foreach ($budgetData as $budget)
                <tr>
                    <td style="padding: 10px; font-size: 14px; text-align:center;">
                        @if ($budget['tahun'] != $previousYear)
                            {{ $budget['tahun'] }}
                            @php $previousYear = $budget['tahun']; @endphp
                        @else
                            &nbsp;
                        @endif
                    </td>
                    <td style="padding: 10px; font-size: 14px; text-align:left;">{{ $budget['nama_kegiatan'] }}</td>
                    <td style="padding: 10px; font-size: 14px; text-align:center;">{{ $budget['jenis_pemeliharaan'] }}
                    </td>
                    <td style="padding: 10px; font-size: 14px; text-align:center;">{{ $budget['frekuensi'] }} Kali</td>
                    <td style="padding: 10px; font-size: 14px; text-align:center;">
                        Rp. {{ number_format($budget['anggaran_per_meter_inflasi'], 0, ',', '.') }}
                    </td>
                    <td style="padding: 10px; font-size: 14px; text-align:center;">
                        {{ $budget['jumlah_tenaga_kerja'] }} Orang</td>
                    <td style="padding: 10px; font-size: 14px; text-align:center; text-align: right;">Rp.
                        {{ number_format($budget['total_biaya_tahunan'], 0, ',', '.') }}
                    </td>
                </tr>
            @endforeach
        </tbody>

        <br />

        <tfoot>
            <tr>
                <td colspan="6" style="text-align: right; padding: 10px; font-size: 16px; font-weight: bold;">
                    Total Keseluruhan
                </td>
                <td style="padding: 10px; font-size: 16px; font-weight: bold; text-align: right;">
                    Rp. {{ number_format($totalBiaya, 0, ',', '.') }}
                </td>
            </tr>
        </tfoot>
    </table>
</body>


</html>
