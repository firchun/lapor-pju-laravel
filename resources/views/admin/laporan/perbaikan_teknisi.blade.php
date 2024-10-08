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
                <table id="datatable-kerusakan" class="table table-h0ver  display mb-3" style="width: 100%;">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Tanggal</th>
                            <th>Code</th>
                            <th>Nama Pelapor</th>
                            <th>Keterangan</th>
                            <th>kerusakan</th>
                        </tr>
                    </thead>

                    <tfoot>
                        <tr>
                            <th>ID</th>
                            <th>Tanggal</th>
                            <th>Code</th>
                            <th>Nama Pelapor</th>
                            <th>Keterangan</th>
                            <th>kerusakan</th>
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
            var table = $('#datatable-kerusakan').DataTable({
                processing: true,
                serverSide: false,
                responsive: false,
                ajax: {
                    url: '{{ url('laporan/datatable-perbaikan-teknisi') }}',
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
                        data: 'fasilitas.code',
                        name: 'fasilitas.code'
                    },
                    {
                        data: 'kerusakan.nama_pelapor',
                        name: 'kerusakan.nama_pelapor'
                    },
                    {
                        data: 'keterangan',
                        name: 'keterangan'
                    },
                    {
                        data: 'jenis_kerusakan',
                        name: 'jenis_kerusakan'
                    },


                ],
                scrollX: true, // Enable horizontal scroll
                scrollCollapse: true,
                paging: true,
                dom: 'lBfrtip',
                buttons: [{
                    extend: 'pdf',
                    text: '<i class=" i bi-file-pdf"> </i> PDF ',
                    className: 'btn-danger mx-3',
                    orientation: 'potrait',
                    title: '{{ $title }}',
                    pageSize: 'A4',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4]
                    },
                    customize: function(doc) {
                        doc.defaultStyle.fontSize = 8;
                        doc.styles.tableHeader.fontSize = 8;
                        doc.styles.tableHeader.fillColor = '#2a6908';
                    },
                    header: true
                }, {
                    extend: 'excelHtml5',
                    text: '<i class="bi bi-file-excel"></i> Excel',
                    className: 'btn-success',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4]
                    }
                }]
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
