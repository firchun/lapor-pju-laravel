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
                        name: 'fasilitas.code'
                    },
                    {
                        data: 'pelapor',
                        name: 'pelapor'
                    },

                    {
                        data: 'keterangan',
                        name: 'keterangan'
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
@endpush
