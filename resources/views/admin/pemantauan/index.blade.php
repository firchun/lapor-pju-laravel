@extends('layouts.backend.admin')

@section('content')
    @include('layouts.backend.alert')
    <div class="dt-action-buttons text-end pt-3 pt-md-0 mb-4">
        <div class=" btn-group " role="group">
            <button class="btn btn-secondary refresh btn-default" type="button">
                <span>
                    <i class="bi bi-arrow-clockwise me-sm-1"> </i>
                    <span class="d-none d-sm-inline-block"></span>
                </span>
            </button>
            <button class="btn btn-success btn-default create-new" type="button">
                <span>
                    <i class="bi bi-plus me-sm-1"> </i>
                    <span class="d-none d-sm-inline-block">Tambah Data</span>
                </span>
            </button>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card-box mb-30">
                <div class="card-body">
                    <h2>{{ $title }}</h2>
                </div>
                <div>
                    <table id="datatable-pemantauan" class="table table-hover  display mb-3" style="width: 100%;">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Tanggal</th>
                                <th>Teknisi</th>
                                <th>Nama/Alamat</th>
                                <th>Id Pelanggan</th>
                                <th>Tunggakan</th>
                                <th>Tarif/Daya</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>

                        <tfoot>
                            <tr>
                                <th>ID</th>
                                <th>Tanggal</th>
                                <th>Teknisi</th>
                                <th>Nama/Alamat</th>
                                <th>Id Pelanggan</th>
                                <th>Tunggakan</th>
                                <th>Tarif/Daya</th>
                                <th>Keterangan</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @include('admin.pemantauan.components.modal')
@endsection
@push('js')
    <script>
        $(function() {
            $('#datatable-pemantauan').DataTable({
                processing: true,
                serverSide: false,
                responsive: false,
                ajax: '{{ url('pemantauan-datatable') }}',
                columns: [{
                        data: 'id',
                        name: 'id'
                    },

                    {
                        data: 'created_at',
                        name: 'created_at',
                        render: function(data, type, full, meta) {
                            return moment(full.created_at).format('DD-MM-YYYY');
                        }
                    },
                    {
                        data: 'user.name',
                        name: 'user.name'
                    },
                    {
                        data: 'fasilitas.nama',
                        name: 'fasilitas.nama'
                    },
                    {
                        data: 'fasilitas.id_pelanggan_pln',
                        name: 'fasilitas.id_pelanggan_pln'
                    },

                    {
                        data: 'fasilitas.tarip',
                        name: 'fasilitas.tarip'
                    },
                    {
                        data: 'tunggakan',
                        name: 'tunggakan'
                    },
                    {
                        data: 'keterangan',
                        name: 'keterangan'
                    },

                ],
                scrollX: true,

            });

            $('.refresh').click(function() {
                $('#datatable-pemantauan').DataTable().ajax.reload();
            });
            $('.create-new').click(function() {
                $('#create').modal('show');
            });
            $('#createCustomerBtn').click(function() {
                var formData = $('#createUserForm').serialize();
                $.ajax({
                    type: 'POST',
                    url: '/pemantauan/store',
                    data: formData,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        alert(response.message);
                        $('#datatable-pemantauan').DataTable().ajax.reload();
                        $('#create').modal('hide');
                    },
                    error: function(xhr) {
                        alert('Terjadi kesalahan: ' + xhr.responseText);
                    }
                });
            });
        });
    </script>
    <!-- Moment.js CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <!-- JS DataTables Buttons -->
    <script src="https://cdn.datatables.net/buttons/2.1.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.1.1/js/buttons.html5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
@endpush
