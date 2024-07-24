@extends('layouts.backend.admin')

@section('content')
    @include('layouts.backend.alert')
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-8">
            <div class="card-box mb-30">
                <div class="card-body">
                    <form action="{{ route('kerusakan.selesai') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id_kerusakan" value="{{ $kerusakan->id }}">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <label for="">Foto sebelum <span class="text-danger">*</span></label><br>
                                    <small class="text-mutted">Harap Lampirkan foto sebelum diperbaiki</small>
                                    <input type="file" class="form-control" name="foto_sebelum" required>
                                </div>
                                <div class="mb-4">
                                    <label for="">Foto Proses Perbaikan <span
                                            class="text-danger">*</span></label><br>
                                    <small class="text-mutted">Harap Lampirkan foto saat diperbaiki</small>
                                    <input type="file" class="form-control" name="foto_proses" required>
                                </div>
                                <div class="mb-4">
                                    <label for="">Foto Hasil Perbaikan <span
                                            class="text-danger">*</span></label><br>
                                    <small class="text-mutted">Harap Lampirkan foto hasil perbaikan/selesai</small>
                                    <input type="file" class="form-control" name="foto_selesai" required>
                                </div>
                                <div class="mb-4">
                                    <label for="">Keterangan <span class="text-danger">*</span></label><br>
                                    <small class="text-mutted">Jelaskan secara singkat tentang proses perbaikan pada
                                        PJU</small>
                                    <textarea class="form-control" name="keterangan" required></textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label>Pilih Mitra (opsional)</label>
                                    <select class="form-control" name="id_mitra">
                                        <option>Pilih Mitra</option>
                                        @foreach (App\Models\Mitra::all() as $item)
                                            <option value="{{ $item->id_mitra }}">{{ $item->nama_mitra }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label>Biaya Perbaikan Oleh Mitra</label>
                                    <input type="number" name="biaya" value="0" class="form-control">
                                </div>
                                <hr>
                                <div class="mb-3" id="createAlat">
                                    <label for="updateNoImta" class="form-label">Alat Yang diganti</label>
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control" name="nama_alat[]" placeholder="Alat">
                                        <input type="number" class="form-control" name="jumlah[]" placeholder="Jumlah"
                                            value="1">
                                        <button type="button" class="btn btn-sm btn-primary btn-tambah"><i
                                                class="bi bi-plus"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <button type="submit" class="btn btn-lg btn-primary btn-block">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script>
        $(function() {
            // Tombol Tambah
            $('.btn-tambah').click(function() {
                var divParent = $(this).closest('#createAlat');
                var newInput = divParent.find('.input-group:first').clone();
                newInput.find('input').val('');
                divParent.append(newInput);
                newInput.find('.btn-tambah').remove();
                divParent.find('.input-group').last().append(
                    '<button type="button" class="btn btn-sm btn-danger btn-hapus"><i class="bi bi-trash"></i></button>'
                );
            });

            // Tombol Hapus
            $(document).on('click', '.btn-hapus', function() {
                var divParent = $(this).closest('#createAlat');
                if (divParent.find('.input-group').length > 1) {
                    $(this).closest('.input-group').remove();
                }
            });
        });
    </script>
@endpush
