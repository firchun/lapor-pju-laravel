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
                <table id="datatable-teknisi" class="table table-hover display" style="width: 100%;">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nama Teknisi</th>
                            <th>Pemeriksaan</th>
                            <th>Perbaikan</th>
                        </tr>
                    </thead>

                    <tfoot>
                        <tr>
                            <th>ID</th>
                            <th>nama Teknisi</th>
                            <th>Pemeriksaan</th>
                            <th>Perbaikan</th>
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
            $('#datatable-teknisi').DataTable({
                processing: true,
                serverSide: false,
                responsive: false,
                ajax: '{{ url('laporan-teknisi-datatable') }}',
                columns: [{
                        data: 'id',
                        name: 'id'
                    },

                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'pemeriksaan',
                        name: 'pemeriksaan'
                    },
                    {
                        data: 'perbaikan',
                        name: 'perbaikan'
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
                    action: function(e, dt, button, config) {
                        window.open('{{ route('laporan.print-teknisi') }}', '_blank');
                    }
                }, , {
                    extend: 'excelHtml5',
                    text: '<i class="bi bi-file-excel"></i> Excel',
                    className: 'btn-success',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4]
                    }
                }]
            });

            $('.refresh').click(function() {
                $('#datatable-teknisi').DataTable().ajax.reload();
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
