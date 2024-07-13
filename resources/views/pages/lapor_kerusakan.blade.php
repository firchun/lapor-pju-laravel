@extends('layouts.frontend.app')
@section('content')
    <section class="page-title bg-1">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="block text-center">
                        <span class="text-white">{{ env('APP_NAME') ?? '-' }}</span>
                        <h1 class="text-capitalize mb-5 text-lg">{{ $title ?? '' }}</h1>
                        <ul class="list-inline breadcumb-nav">
                            <li class="list-inline-item"><a href="{{ url('/') }}" class="text-white">Home</a></li>
                            <li class="list-inline-item"><span class="text-white">/</span></li>
                            <li class="list-inline-item"><a href="#" class="text-white-50">{{ $title ?? '' }}</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="section">
        <div class="container">
            <div class="text-center mb-4">
                @if ($fasilitas->foto != null)
                    <img src="{{ Storage::url($fasilitas->foto) }}" style="height: 300px; weidth:200px; object-fit:cover">
                @endif
                <h3 class="mt-2">Laporkan Kerusakan Pada {{ $fasilitas->code }}</h3>
                <p class="text-mutted"><strong>Alamat : </strong>{{ $fasilitas->alamat }}</p>
            </div>
            <form action="{{ route('kerusakan.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group p-4  border border-primary shadow-lg" style="border-radius: 20px;">
                    <input type="hidden" name="id_fasilitas" value="{{ $fasilitas->id }}">
                    <div class="mb-3">
                        <label>Code PJU</label>
                        <input type="text" class="form-control" value="{{ $fasilitas->code }}" readonly>
                    </div>
                    <hr>
                    <strong class="mb-3">Bukti Kerusakan</strong>
                    <div class="mb-3">
                        <label>Foto Anda</label>
                        <input type="file" class="form-control" name="foto_pelapor" required>
                    </div>
                    <div class="mb-3">
                        <label>Foto kerusakan 1</label>
                        <input type="file" class="form-control" name="foto_kerusakan_1" required>
                    </div>
                    <div class="mb-3">
                        <label>Foto kerusakan 2</label>
                        <input type="file" class="form-control" name="foto_kerusakan_2" required>
                    </div>
                    <hr>
                    <div class="mb-3">
                        <label>Nama Pelapor</label>
                        <input type="text" class="form-control" placeholder="Nama Pelapor" name="nama_pelapor" required>
                    </div>
                    <div class="mb-3">
                        <label>No. HP/WA Pelapor</label>
                        <input type="text" class="form-control" value="+62" name="no_hp_pelapor" required>
                    </div>
                    <div class="mb-3">
                        <label>Keterangan pada kerusakan</label>
                        <textarea class="form-control" name="keterangan" required></textarea>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary btn-lg">Laporkan Kerusakan</button>
                    </div>
                </div>
            </form>
        </div>
    </section>
@endsection
