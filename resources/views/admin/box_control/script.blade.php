@push('js')
    <script>
        $(function() {
            $('#datatable-box').DataTable({
                processing: true,
                serverSide: false,
                responsive: false,
                ajax: '{{ url('box-control-datatable') }}',
                columns: [{
                        data: 'id',
                        name: 'id'
                    },

                    {
                        data: 'foto',
                        name: 'foto'
                    },
                    {
                        data: 'nama',
                        name: 'nama'
                    },

                    {
                        data: 'tempat',
                        name: 'tempat'
                    },
                    {
                        data: 'action',
                        name: 'action'
                    }
                ]
            });
            $('.create-new').click(function() {
                $('#create').modal('show');
            });
            $('.refresh').click(function() {
                $('#datatable-box').DataTable().ajax.reload();
            });
            window.editCustomer = function(id) {
                $.ajax({
                    type: 'GET',
                    url: '/box-control/edit/' + id,
                    success: function(response) {
                        $('#customersModalLabel').text('Edit Customer');
                        $('#formCustomerId').val(response.id);
                        $('#formCustomerNama').val(response.nama)
                        $('#formCustomerTempat').val(response.tempat);
                        $('#customersModal').modal('show');
                    },
                    error: function(xhr) {
                        alert('Terjadi kesalahan: ' + xhr.responseText);
                    }
                });
            };
            $('#saveCustomerBtn').click(function() {
                var formData = $('#userForm').serialize();

                $.ajax({
                    type: 'POST',
                    url: '/box-control/store',
                    data: formData,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        alert(response.message);
                        // Refresh DataTable setelah menyimpan perubahan
                        $('#datatable-box').DataTable().ajax.reload();
                        $('#customersModal').modal('hide');
                    },
                    error: function(xhr) {
                        alert('Terjadi kesalahan: ' + xhr.responseText);
                    }
                });
            });
            $('#createCustomerBtn').click(function() {
                // Membuat objek FormData baru
                var formData = new FormData($('#createUserForm')[0]);

                $.ajax({
                    type: 'POST',
                    url: '/box-control/store',
                    data: formData,
                    processData: false, // Jangan mengubah data menjadi query string
                    contentType: false, // Jangan mengatur header Content-Type, biarkan browser melakukannya
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        alert(response.message);
                        $('#datatable-box').DataTable().ajax.reload();
                        $('#create').modal('hide');
                    },
                    error: function(xhr) {
                        alert('Terjadi kesalahan: ' + xhr.responseText);
                    }
                });
            });

            window.deleteCustomers = function(id) {
                if (confirm('Apakah Anda yakin ingin menghapus box ini?')) {
                    $.ajax({
                        type: 'DELETE',
                        url: '/box-control/delete/' + id,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            // alert(response.message);
                            $('#datatable-box').DataTable().ajax.reload();
                        },
                        error: function(xhr) {
                            alert('Terjadi kesalahan: ' + xhr.responseText);
                        }
                    });
                }
            };
            window.qrCode = function(id) {
                var url = '/box-control/print/' + id;

                // Open the URL in a new tab/window
                window.open(url, '_blank');
            };
        });
    </script>
@endpush
