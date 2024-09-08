<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Laporan Perbaikan PJU</title>
    <meta http-equiv="Content-Type" content="charset=utf-8" />
    <link rel="stylesheet" href="{{ public_path('css') }}/pdf/bootstrap.min.css" media="all" />
    <style>
        body {
            font-family: 'times new roman';
            font-size: 16px;
        }

        .page_break {
            page-break-before: always;
        }

        table.table_custom th,
        table.table_custom td {
            border-collapse: collapse;
            width: 100%;
            border: 1px solid;
            padding: 5px;
            width: 100%;
        }
    </style>
    {{-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css"> --}}
</head>

<body>
    <main class="mt-0">
        {{-- laporan masyarakat --}}
        <table class="" style="font-size: 18px; padding:5px; width:100%; border:0px;">
            <tr>
                <td style="width: 20%">
                    <img style="width: 80px;" src="{{ public_path('img') }}/logo-dishub.png">
                </td>
                <td class="text-center" style="width: 80%">DINAS PERHUBUNGAN<br>
                    KABUPATEN MERAUKE<br>
                    Jl. Ermasu NO.67 99614
                </td>
                <td style="width: 20%"></td>
            </tr>
        </table>
        <hr style="border: 1px solid black;">
        <div class="my-3">
            <strong>Laporan Pengerjaan Teknisi</strong>
        </div>

        <table class="table_custom" width="100%">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Teknisi</th>
                    <th>Pemeriksaan</th>
                    <th>Perbaikan</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->name }}</td>
                        <td>{{ App\Models\Perbaikan::where('id_user', $item->id)->count() }}</td>
                        <td>{{ App\Models\PerbaikanSelesai::where('id_user', $item->id)->count() }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    </main>

</body>

</html>
