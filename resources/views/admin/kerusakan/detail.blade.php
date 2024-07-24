@extends('layouts.backend.admin')

@section('content')
    @include('layouts.backend.alert')
    <div class="mb-3">
        <a href="{{ url('kerusakan') }}" class="btn btn-secondary">Kembali</a>
    </div>
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-6">
            <div class="card-box mb-30">
                <div class="card-body">
                    <table class="table table-hover">
                        <tr>
                            <td><b>PJU</b></td>
                            <td>:</td>
                            <td><strong>{{ $kerusakan->fasilitas->code }}</strong><br><small>{{ $kerusakan->fasilitas->alamat }}</small>
                            </td>
                        </tr>
                        <tr>
                            <td><b>Nama Pelapor</b></td>
                            <td>:</td>
                            <td>{{ $kerusakan->nama_pelapor }} <span
                                    class="badge badge-success">{{ $kerusakan->id_user ? 'Teknisi' : 'Masyarakat' }}</span>
                            </td>
                        </tr>
                        <tr>
                            <td><b>No HP/WA Pelapor</b></td>
                            <td>:</td>
                            <td>{{ $kerusakan->no_hp_pelapor }}</td>
                        </tr>
                        <tr>
                            <td><b>Keterangan Laporan</b></td>
                            <td>:</td>
                            <td>{{ $kerusakan->keterangan }}</td>
                        </tr>
                        <tr>
                            <td><b>Foto Pelapor</b></td>
                            <td>:</td>
                            <td>
                                @if ($kerusakan->foto_pelapor)
                                    <img src="{{ Storage::url($kerusakan->foto_pelapor) }}"
                                        style="width: 100%;height:auto; object-fit:cover;">
                                @else
                                    <span class="text-mutted">Tidak Terlampir</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td><b>Foto Kerusakan 1</b></td>
                            <td>:</td>
                            <td>
                                @if ($kerusakan->foto_kerusakan_1)
                                    <img src="{{ Storage::url($kerusakan->foto_kerusakan_1) }}"
                                        style="width: 100%;height:auto; object-fit:cover;">
                                @else
                                    <span class="text-mutted">Tidak Terlampir</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td><b>Foto Kerusakan 2</b></td>
                            <td>:</td>
                            <td>
                                @if ($kerusakan->foto_kerusakan_2)
                                    <img src="{{ Storage::url($kerusakan->foto_kerusakan_2) }}"
                                        style="width: 100%;height:auto; object-fit:cover;">
                                @else
                                    <span class="text-mutted">Tidak Terlampir</span>
                                @endif
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
