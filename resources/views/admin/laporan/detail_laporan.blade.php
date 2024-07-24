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
            <strong>Laporan Masyarakat</strong>
        </div>
        <table class="table_custom" width="100%">
            <tr>
                <td>
                    <b>Nama Pelapor</b>
                </td>

                <td>{{ $data->nama_pelapor }}</td>
            </tr>
            <tr>
                <td>
                    <b>Oleh</b>
                </td>

                <td>{{ $data->id_user ? 'Teknisi' : 'Masyarakat' }}</td>
            </tr>
            <tr>
                <td>
                    <b>Tanggal Laporan</b>
                </td>

                <td>{{ $data->created_at->format('d/m/Y') }}</td>
            </tr>
            <tr>
                <td>
                    <b>No HP Pelapor</b>
                </td>

                <td>{{ $data->no_hp_pelapor }}</td>
            </tr>
            <tr>
                <td>
                    <b>Keterangan</b>
                </td>

                <td>{{ $data->keterangan }}</td>
            </tr>
            <tr>
                <td>
                    <b>Foto Pelapor</b>
                </td>

                <td>
                    @if ($data->foto_pelapor)
                        <img src="{{ storage_path('app/' . $data->foto_pelapor) }}"
                            style="height: 150px; width:150px;object-fit:cover;">
                    @else
                        <span class="text-mutted">Tidak Terlampir</span>
                    @endif
                </td>
            </tr>
            <tr>
                <td>
                    <b>Foto Kerusakan</b>
                </td>

                <td class="mt-3">
                    <div class="d-flex mt-3">
                        @if ($data->foto_kerusakan_1)
                            <img src="{{ storage_path('app/' . $data->foto_kerusakan_1) }}"
                                style="height: 150px; width:150px;object-fit:cover;">
                        @elseif($data->foto_kerusakan_2)
                            <img src="{{ storage_path('app/' . $data->foto_kerusakan_2) }}"
                                style="height: 150px; width:150px;object-fit:cover;">
                        @else
                            <span class="text-mutted">Tidak Terlampir</span>
                        @endif
                    </div>
                </td>
            </tr>
        </table>
        <div class="page_break">
        </div>
        @if ($perbaikan)
            {{-- laporan perbaikan --}}
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
                <strong>Laporan Perbaikan</strong>
            </div>
            <table class="table_custom" width="100%">
                <tr>
                    <td><b>Code PJU</b></td>
                    <td>{{ $perbaikan->fasilitas->code }}</td>S
                </tr>
                <tr>
                    <td><b>Alamat PJU</b></td>
                    <td>{{ $perbaikan->fasilitas->alamat }}</td>
                </tr>
                <tr>
                    <td><b>koordinat PJU</b></td>
                    <td>{{ $perbaikan->fasilitas->latitude }},{{ $perbaikan->fasilitas->longitude }}</td>
                </tr>
                <tr>
                    <td><b>Teknisi</b></td>
                    <td>{{ $perbaikan->user->name }}</td>
                </tr>
                <tr>
                    <td><b>Tanggal Pemeriksaan</b></td>
                    <td>{{ $perbaikan->created_at->format('d/m/Y') }}</td>
                </tr>
                <tr>
                    <td><b>Alat diganti</b></td>
                    <td>{{ $perbaikan->alat_diganti }}</td>
                </tr>
                <tr>
                    <td><b>keterangan</b></td>
                    <td>{{ $perbaikan->keterangan }}</td>
                </tr>
            </table>
            <div class="page_break">
            </div>
        @endif
        @if ($selesai)
            {{-- laporan selesai --}}
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
                <strong>Laporan Penyelesaian</strong>
            </div>
            <table class="table_custom" width="100%">
                <tr>
                    <td><b>Code PJU</b></td>
                    <td>{{ $perbaikan->fasilitas->code }}</td>
                </tr>
                <tr>
                    <td><b>Alamat PJU</b></td>
                    <td>{{ $perbaikan->fasilitas->alamat }}</td>
                </tr>
                <tr>
                    <td><b>koordinat PJU</b></td>
                    <td>{{ $perbaikan->fasilitas->latitude }},{{ $perbaikan->fasilitas->longitude }}</td>
                </tr>
                <tr>
                    <td><b>Teknisi</b></td>
                    <td>{{ $selesai->user->name }}</td>
                </tr>
                @php
                    $perbaikan_mitra = App\Models\PerbaikanMitra::where('id_kerusakan', $selesai->id_kerusakan);
                    $mitra = $perbaikan_mitra->latest()->first();
                @endphp
                @if ($perbaikan_mitra->count() != 0)
                    <tr>
                        <td><b>Mitra</b></td>
                        <td>{{ $mitra->mitra->nama_mitra }}</td>
                    </tr>
                    <tr>
                        <td><b>Biaya</b></td>
                        <td>{{ $mitra->mitra->biaya }}</td>
                    </tr>
                @endif
                @php
                    $alat_perbaikan = App\Models\AlatPerbaikan::where('id_kerusakan', $selesai->id_kerusakan);
                    $alat = $alat_perbaikan->get();
                @endphp
                @if ($perbaikan_mitra->count() != 0)
                    <tr>
                        <td><b>Alat diperbaiki</b></td>
                        <td>
                            <ol>
                                @foreach ($alat as $alatItem)
                                    <li>{{ $alatItem->nama_alat }} - {{ $alatItem->jumlah }}</li>
                                @endforeach
                            </ol>
                        </td>
                    </tr>
                @endif
                <tr>
                    <td><b>Tanggal Pengerjaan</b></td>
                    <td>{{ $selesai->created_at->format('d/m/Y') }}</td>
                </tr>
                <tr>
                    <td><b>keterangan</b></td>
                    <td>{{ $selesai->keterangan }}</td>
                </tr>
                <tr>
                    <td><b>Foto Sebelum</b></td>
                    <td> <img src="{{ storage_path('app/' . $selesai->foto_sebelum) }}"
                            style="height: 150px;  width:150px; object-fit:cover;"></td>
                </tr>
                <tr>
                    <td><b>Foto Proses</b></td>
                    <td> <img src="{{ storage_path('app/' . $selesai->foto_proses) }}"
                            style="height: 150px;  width:150px; object-fit:cover;"></td>
                </tr>
                <tr>
                    <td><b>Foto Hasil</b></td>
                    <td> <img src="{{ storage_path('app/' . $selesai->foto_selesai) }}"
                            style="height: 150px;  width:150px; object-fit:cover;"></td>
                </tr>
            </table>
        @endif
    </main>

</body>

</html>
