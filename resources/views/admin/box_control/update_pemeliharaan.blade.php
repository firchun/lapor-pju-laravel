@extends('layouts.backend.admin')

@section('content')
    @include('layouts.backend.alert')
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-8">
            <div class="card-box mb-30">
                <div class="card-body">
                    <h4 class="text-center">Pemeliharaan BOX CONTROL</h4>
                    <hr>
                    <div class="row">
                        <div class="col-md-8">

                            <form action="{{ route('pemeliharaan.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="id_box_control" value="{{ $box->id }}">
                                <div class="" id="createAlat">

                                    <label for="">Keterangan <span class="text-danger">*</span></label><br>
                                    <small class="text-mutted">Jelaskan secara singkat tentang kerusakan pada PJU</small>
                                    <div class="input-group mb-3">
                                        <input class="form-control form-control-lg" name="keterangan[]" required>

                                        <button type="button" class="btn btn-primary btn-tambah mx-2"><i
                                                class="bi bi-plus"></i></button>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary btn-block">Update</button>
                            </form>
                        </div>
                        <div class="col-md-4">
                            <img src="{{ Storage::url($box->foto) }}" alt="box"
                                style="width: 100%; height:auto; object-fit:cover;">
                        </div>
                    </div>
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
                    '<button type="button" class="btn btn-danger btn-hapus mx-2"><i class="bi bi-trash"></i></button>'
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
