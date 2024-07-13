@extends('layouts.backend.admin')

@section('content')
    @include('layouts.backend.alert')
    <div class="row justify-content-center">
        <div class="col-lg-4 col-md-6">
            <div class="card-box mb-30">
                <div class="card-body">
                    <form action="{{ route('kerusakan.perbaikan') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id_fasilitas" value="{{ $kerusakan->id_fasilitas }}">
                        <input type="hidden" name="id_kerusakan" value="{{ $kerusakan->id }}">
                        <div class="mb-4">
                            <label for="">Jenis Kerusakan <span class="text-danger">*</span></label>
                            <select class="form-control" name="jenis_kerusakan" required>
                                <option value="Berat">Kerusakan Berat</option>
                                <option value="Ringan">Kerusakan Ringan</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label for="">Alat yang perlu di ganti <span class="text-danger">*</span></label><br>
                            <small class="text-mutted">List alat apa saja yang perlu di ganti</small>
                            <textarea class="form-control" name="alat_diganti" required></textarea>
                        </div>
                        <div class="mb-4">
                            <label for="">Keterangan <span class="text-danger">*</span></label><br>
                            <small class="text-mutted">Jelaskan secara singkat tentang kerusakan pada PJU</small>
                            <textarea class="form-control" name="keterangan" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
