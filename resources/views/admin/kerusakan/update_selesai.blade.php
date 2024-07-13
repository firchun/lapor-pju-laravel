@extends('layouts.backend.admin')

@section('content')
    @include('layouts.backend.alert')
    <div class="row justify-content-center">
        <div class="col-lg-4 col-md-6">
            <div class="card-box mb-30">
                <div class="card-body">
                    <form action="{{ route('kerusakan.selesai') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id_kerusakan" value="{{ $kerusakan->id }}">
                        <div class="mb-4">
                            <label for="">Foto sebelum <span class="text-danger">*</span></label><br>
                            <small class="text-mutted">Harap Lampirkan foto sebelum diperbaiki</small>
                            <input type="file" class="form-control" name="foto_sebelum" required>
                        </div>
                        <div class="mb-4">
                            <label for="">Foto Proses Perbaikan <span class="text-danger">*</span></label><br>
                            <small class="text-mutted">Harap Lampirkan foto saat diperbaiki</small>
                            <input type="file" class="form-control" name="foto_proses" required>
                        </div>
                        <div class="mb-4">
                            <label for="">Foto Hasil Perbaikan <span class="text-danger">*</span></label><br>
                            <small class="text-mutted">Harap Lampirkan foto hasil perbaikan/selesai</small>
                            <input type="file" class="form-control" name="foto_selesai" required>
                        </div>
                        <div class="mb-4">
                            <label for="">Keterangan <span class="text-danger">*</span></label><br>
                            <small class="text-mutted">Jelaskan secara singkat tentang proses perbaikan pada PJU</small>
                            <textarea class="form-control" name="keterangan" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
