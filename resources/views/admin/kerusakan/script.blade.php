@push('js')
    <script>
        $(function() {
            $('#datatable-kerusakan').DataTable({
                processing: true,
                serverSide: false,
                responsive: true,
                ajax: '{{ url('kerusakan-datatable') }}',
                columns: [{
                        data: 'id',
                        name: 'id'
                    },

                    {
                        data: 'fasilitas.code',
                        name: 'fasilitas.code',
                        render: function(data, type, full, meta) {
                            var formattedCode = data + '<br>';
                            var formattedDate = moment(full.created_at).format('DD-MM-YYYY');
                            return formattedCode + '<small>' + formattedDate + '<small>';
                        }
                    },
                    {
                        data: 'pelapor',
                        name: 'pelapor'
                    },

                    {
                        data: 'jenis_laporan',
                        name: 'jenis_laporan'
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'action',
                        name: 'action'
                    }
                ]
            });

            $('.refresh').click(function() {
                $('#datatable-kerusakan').DataTable().ajax.reload();
            });

        });
    </script>
    <!-- Moment.js CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
@endpush
