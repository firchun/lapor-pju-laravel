@extends('layouts.backend.admin')

@section('content')
    @include('layouts.backend.alert')
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-6">
            <div class="card-box mb-30">
                <div class="card-body">
                    <h3>Form Input Kerusakan</h3>
                    <hr>
                    <form action="{{ url('kerusakan/store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row align-items-end">
                            <div class="col-md-9">

                                <div class="mb-3">
                                    <label>Pilih Fasilitas</label>
                                    <select name="id_fasilitas" id="FasilitasId" class="form-control">
                                        @foreach (App\Models\Fasilitas::all() as $item)
                                            <option value="{{ $item->id }}">{{ $item->code }} - {{ $item->alamat }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <a href="{{ url('/maps') }}" class="btn btn-success" target="__blank"><i
                                            class="bi bi-maps"></i>
                                        Lihat Peta</a>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label>Foto Kerusakan 1</label>
                                    <input type="file" class="form-control" name="foto_kerusakan_1">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label>Foto Kerusakan 1</label>
                                    <input type="file" class="form-control" name="foto_kerusakan_2">
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label>Nama Pelapor</label>
                            <input type="text" value="{{ Auth::user()->name }}" class="form-control" name="nama_pelapor">
                        </div>
                        <div class="mb-3">
                            <label>No. HP</label>
                            <input type="text" value="+628" class="form-control" name="no_hp_pelapor">
                        </div>
                        <div class="mb-3">
                            <label>Keterangan Kerusakan</label>
                            <textarea class="form-control" name="keterangan"></textarea>
                        </div>
                        <input type="hidden" name="id_user" value="{{ Auth::id() }}">
                        <div class="my-3">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
