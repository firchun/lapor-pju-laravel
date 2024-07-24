@push('js')
    <script>
        $(function() {
            $('#datatable-mitra').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: '{{ url('mitra-datatable') }}',
                columns: [{
                        data: 'id',
                        name: 'id'
                    },

                    {
                        data: 'nama_mitra',
                        name: 'nama_mitra'
                    },
                    {
                        data: 'no_hp',
                        name: 'no_hp'
                    },

                    {
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'alamat',
                        name: 'alamat'
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
                $('#datatable-mitra').DataTable().ajax.reload();
            });
            window.editCustomer = function(id) {
                $.ajax({
                    type: 'GET',
                    url: '/mitra/edit/' + id,
                    success: function(response) {
                        $('#formMitraId').val(response.id);
                        $('#formUpdateCustomerName').val(response.nama_mitra);
                        $('#formUpdateCustomerPhone').val(response.no_hp);
                        $('#formUpdateCustomerEmail').val(response.email);
                        $('#formUpdateCustomerAlamat').val(response.alamat);
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
                    url: '/mitra/store',
                    data: formData,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        alert(response.message);
                        // Refresh DataTable setelah menyimpan perubahan
                        $('#datatable-mitra').DataTable().ajax.reload();
                        $('#customersModal').modal('hide');
                    },
                    error: function(xhr) {
                        alert('Terjadi kesalahan: ' + xhr.responseText);
                    }
                });
            });
            $('#createCustomerBtn').click(function() {
                var formData = $('#createUserForm').serialize();

                $.ajax({
                    type: 'POST',
                    url: '/mitra/store',
                    data: formData,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        alert(response.message);
                        $('#formCustomerName').val('');
                        $('#formCustomerPhone').val('');
                        $('#formCustomerEmail').val('');
                        $('#formCustomerAlamat').val('');
                        $('#datatable-mitra').DataTable().ajax.reload();
                        $('#create').modal('hide');
                    },
                    error: function(xhr) {
                        alert('Terjadi kesalahan: ' + xhr.responseText);
                    }
                });
            });
            window.deleteCustomers = function(id) {
                if (confirm('Apakah Anda yakin ingin menghapus mitra ini?')) {
                    $.ajax({
                        type: 'DELETE',
                        url: '/mitra/delete/' + id,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            // alert(response.message);
                            $('#datatable-mitra').DataTable().ajax.reload();
                        },
                        error: function(xhr) {
                            alert('Terjadi kesalahan: ' + xhr.responseText);
                        }
                    });
                }
            };
        });
    </script>
@endpush
