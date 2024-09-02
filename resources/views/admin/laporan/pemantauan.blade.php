@extends('layouts.backend.admin')

@section('content')
    @include('layouts.backend.alert')
    <div class="dt-action-buttons text-end pt-3 pt-md-0 mb-4">
        <div class=" btn-group " role="group">
            <button class="btn btn-secondary refresh btn-default" type="button">
                <span>
                    <i class="bi bi-arrow-clockwise me-sm-1"> </i>
                    <span class="d-none d-sm-inline-block">Refresh Data</span>
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
                <hr>
                <div class="m-2">
                    <div class="my-2">
                        <label>Filter data : </label>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-md-6">
                            <input type="date" class="form-control" name="date" id="dateFilter">
                        </div>
                        <div class="col-md-2">
                            <button type="button" class="btn btn-primary" id="btnFilter"><i
                                    class="bi bi-filter"></i>Filter</button>
                        </div>
                    </div>
                </div>
                <hr>
                <table id="datatable-pemantauan" class="table table-hover  display mb-3">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Tanggal</th>
                            <th>Nama</th>
                            <th>Alamat</th>
                            <th>Id Pelanggan</th>
                            <th>Tunggakan</th>
                            <th>Tarif</th>
                            <th>Daya</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>

                    <tfoot>
                        <tr>
                            <th>ID</th>
                            <th>Tanggal</th>
                            <th>Nama</th>
                            <th>Alamat</th>
                            <th>Id Pelanggan</th>
                            <th>Tunggakan</th>
                            <th>Tarif</th>
                            <th>Daya</th>
                            <th>Keterangan</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script>
        $(function() {
            var table = $('#datatable-pemantauan').DataTable({
                processing: true,
                serverSide: false,
                responsive: false,
                ajax: {
                    url: '{{ url('pemantauan-datatable') }}',
                    data: function(d) {
                        d.date = $('#dateFilter').val();
                    }
                },
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
                        data: 'fasilitas.nama',
                        name: 'fasilitas.nama'
                    },
                    {
                        data: 'fasilitas.alamat',
                        name: 'fasilitas.alamat'
                    },
                    {
                        data: 'fasilitas.id_pelanggan_pln',
                        name: 'fasilitas.id_pelanggan_pln'
                    },
                    {
                        data: 'tunggakan',
                        name: 'tunggakan'
                    },
                    {
                        data: 'fasilitas.tarip',
                        name: 'fasilitas.tarip'
                    },
                    {
                        data: 'fasilitas.daya',
                        name: 'fasilitas.daya'
                    },

                    {
                        data: 'keterangan',
                        name: 'keterangan'
                    },
                ],
                dom: 'lBfrtip',
                buttons: [{
                        extend: 'pdf',
                        text: '<i class=" i bi-file-pdf"> </i> PDF ',
                        className: 'btn-danger mx-3',
                        action: function(e, dt, button, config) {
                            var date = document.getElementById('dateFilter').value;
                            var url = '{{ url('laporan/print-pemantauan') }}' + (date ? '?date=' +
                                encodeURIComponent(date) : '');
                            window.open(url, '_blank');
                        }
                    },
                    {
                        extend: 'excelHtml5',
                        text: '<i class="bi bi-file-excel"></i> Excel',
                        className: 'btn-success',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4]
                        }
                    }
                ]
            });
            // Event handler untuk tombol filter
            $('#btnFilter').click(function() {
                table.ajax.reload();
            });

            // Event handler untuk tombol refresh
            $('.refresh').click(function() {
                $('#dateFilter').val(''); // Reset filter tanggal
                table.ajax.reload();
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
