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
            @if (Session::has('success'))
                <div class="alert alert-success alert-dismissible mb-4" role="alert">
                    {{ Session::get('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                @elseif (Session::has('danger'))
                    <div class="alert alert-danger alert-dismissible mb-4" role="alert">
                        {{ Session::get('danger') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
            @endif

            <h3 class="my-4 text-center">Data Laporan Kerusakan PJU oleh Masyarakat</h3>
            <div class="row justify-content-center">
                @if ($kerusakan->count() == 0)
                    <div class="col-12">
                        <div class="text-center">
                            <p class="text-mutted p-2 border">Belum ada laporan masyarakat</p>
                        </div>
                    </div>
                @endif
                @foreach ($kerusakan as $item)
                    <div class="col-lg-4 col-md-6">
                        <div class="card mb-3 border-primary shadow-lg" style="border-radius: 10px;">
                            <div class="card-body">
                                <h3>{{ $item->nama_pelapor }}</h3>
                                <small>{{ $item->created_at }}</small>
                                <hr>
                                <div class="d-flex mt-3">
                                    <img src="{{ Storage::url($item->foto_kerusakan_1) }}" alt="" class="img-fluid"
                                        style="height: 100px;width:100px;object-fit:cover;">
                                    <img src="{{ Storage::url($item->foto_kerusakan_2) }}" alt="" class="img-fluid"
                                        style="height: 100px;width:100px;object-fit:cover;">
                                </div>
                                <hr>
                                <b>{{ $item->fasilitas->code }}</b> ({{ $item->fasilitas->alamat }})
                                <p>Status : {{ $item->status }}</p>
                                <p>Keterangan : {{ $item->keterangan }}</p>
                                <hr>
                                <a href="https://www.google.com/maps/dir/?api=1&destination={{ $item->fasilitas->latitude }},{{ $item->fasilitas->longitude }}"
                                    class="btn btn-block btn-success">Lokasi PJU</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="mt-4">
                <div class="d-flex justify-content-center">
                    {{ $kerusakan->links('vendor.pagination.bootstrap-4') }}
                </div>
            </div>
        </div>
    </section>
@endsection
