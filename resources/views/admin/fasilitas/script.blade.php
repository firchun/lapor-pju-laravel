@push('js')
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <!-- Leaflet JavaScript -->
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script>
        $(document).ready(function() {
            var map;
            var marker;

            // Inisialisasi peta Leaflet
            function initMap() {

                map = L.map('map').setView([-8.5093732, 140.3962117], 13); // Koordinat default (misalnya Jakarta)

                // Menambahkan layer peta jalan
                var streetLayer = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    maxZoom: 19,
                    attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                }).addTo(map);

                // Menambahkan layer citra satelit (contoh menggunakan Bing Maps)

                var satelliteLayer = L.tileLayer('https://{s}.google.com/vt/lyrs=s&x={x}&y={y}&z={z}', {
                    maxZoom: 20,
                    subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
                });


                // Menambahkan control untuk memilih layer (peta jalan, citra satelit, hybrid)
                var baseMaps = {
                    "Street Map": streetLayer,
                    "Satellite Map": satelliteLayer,
                };

                L.control.layers(baseMaps).addTo(map);

                // Menambahkan event click untuk menempatkan marker
                map.on('click', function(e) {
                    placeMarker(e.latlng);
                });
            }

            // Fungsi untuk menempatkan marker
            function placeMarker(location) {
                if (marker) {
                    marker.setLatLng(location);
                } else {
                    marker = L.marker(location).addTo(map);
                }

                // Mengisi nilai latitude dan longitude pada input hidden
                $('#formCreateFasilitasLatitude').val(location.lat);
                $('#formCreateFasilitasLongitude').val(location.lng);
            }

            // Memanggil fungsi inisialisasi peta saat modal ditampilkan
            $('#create').on('shown.bs.modal', function() {
                initMap();
            });

            // Mengosongkan peta dan marker saat modal ditutup
            $('#create').on('hidden.bs.modal', function() {
                if (map) {
                    map.remove();
                }
                map = null;
                marker = null;
            });

            // Event listener untuk tombol Save

        });
    </script>
    <script>
        $(document).ready(function() {
            var editMap;
            var editMarker;

            // Inisialisasi peta Leaflet untuk edit
            function initEditMap(latitude, longitude) {
                // Tentukan koordinat awal berdasarkan latitude dan longitude yang diterima
                var initialCoordinate = [latitude, longitude];

                editMap = L.map('editMap').setView(initialCoordinate, 13); // Set view dengan koordinat awal

                // Menambahkan layer peta jalan
                var streetLayer = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    maxZoom: 19,
                    attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                }).addTo(editMap);

                // Menambahkan layer citra satelit (contoh menggunakan Bing Maps)
                var satelliteLayer = L.tileLayer('https://{s}.google.com/vt/lyrs=s&x={x}&y={y}&z={z}', {
                    maxZoom: 20,
                    subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
                });

                // Menambahkan control untuk memilih layer (peta jalan, citra satelit, hybrid)
                var baseMaps = {
                    "Street Map": streetLayer,
                    "Satellite Map": satelliteLayer,
                };

                L.control.layers(baseMaps).addTo(editMap);

                // Menempatkan marker berdasarkan koordinat awal
                placeEditMarker(initialCoordinate);

                // Menambahkan event click untuk menempatkan marker
                editMap.on('click', function(e) {
                    placeEditMarker(e.latlng);
                });
            }

            // Fungsi untuk menempatkan marker pada peta edit
            function placeEditMarker(location) {
                if (editMarker) {
                    editMarker.setLatLng(location);
                } else {
                    editMarker = L.marker(location).addTo(editMap);
                }

                // Mengisi nilai latitude dan longitude pada input hidden
                $('#formEditFasilitasLatitude').val(location.lat);
                $('#formEditFasilitasLongitude').val(location.lng);
            }

            // Memanggil fungsi inisialisasi peta saat modal edit ditampilkan
            $('#edit').on('shown.bs.modal', function() {
                var latitude = parseFloat($('#formEditFasilitasLatitude').val()) || -
                    8.5093732; // Koordinat default jika tidak ada nilai
                var longitude = parseFloat($('#formEditFasilitasLongitude').val()) ||
                    140.3962117; // Koordinat default jika tidak ada nilai
                initEditMap(latitude, longitude);
            });

            // Mengosongkan peta dan marker saat modal edit ditutup
            $('#edit').on('hidden.bs.modal', function() {
                if (editMap) {
                    editMap.remove();
                }
                editMap = null;
                editMarker = null;
            });

            // Event listener untuk tombol Save di modal edit

        });
    </script>


    <script>
        $(function() {
            $('#datatable-fasilitas').DataTable({
                processing: true,
                serverSide: false,
                responsive: false,
                ajax: '{{ url('/fasilitas-datatable') }}',
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'foto',
                        name: 'foto'
                    },

                    {
                        data: 'code',
                        name: 'code'
                    },
                    {
                        data: 'nama',
                        name: 'nama'
                    },
                    {
                        data: 'id_pelanggan_pln',
                        name: 'id_pelanggan_pln'
                    },
                    {
                        data: 'tarip',
                        name: 'tarip'
                    },
                    {
                        data: 'daya',
                        name: 'daya'
                    },


                    {
                        data: 'alamat',
                        name: 'alamat'
                    },
                    {
                        data: 'koordinat',
                        name: 'koordinat'
                    },
                    {
                        data: 'action',
                        name: 'action'
                    }
                ],
                scrollX: true, // Enable horizontal scroll
                scrollCollapse: true,
                paging: true
            });
            $('.create-new').click(function() {
                $('#create').modal('show');
            });
            $('.refresh').click(function() {
                $('#datatable-fasilitas').DataTable().ajax.reload();
            });
            window.qrCode = function(id) {
                var url = '/fasilitas/print/' + id;

                // Open the URL in a new tab/window
                window.open(url, '_blank');
            };
            window.editCustomer = function(id) {
                $.ajax({
                    type: 'GET',
                    url: '/fasilitas/edit/' + id,
                    success: function(response) {
                        $('#idFasilitas').val(response.id);
                        $('#formEditFasilitasIdPelangganPln').val(response.id_pelanggan_pln);
                        $('#formEditFasilitasTarip').val(response.tarip);
                        $('#formEditFasilitasDaya').val(response.daya);
                        $('#formEditFasilitasNama').val(response.nama);
                        $('#formEditFasilitasAlamat').val(response.alamat);
                        $('#formEditFasilitasLatitude').val(response.latitude);
                        $('#formEditFasilitasLongitude').val(response.longitude);
                        $('#edit').modal('show');
                    },
                    error: function(xhr) {
                        alert('Terjadi kesalahan: ' + xhr.responseText);
                    }
                });
            };

            $('#updateFasilitasBtn').click(function(e) {
                e.preventDefault();

                // Lakukan pengiriman data dengan AJAX ke server
                var formData = new FormData($('#editFasilitasForm')[0]);

                $.ajax({
                    url: '{{ route('fasilitas.update') }}', // Sesuaikan dengan route Anda
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        console.log(response);
                        alert(response.message);
                        $('#datatable-fasilitas').DataTable().ajax.reload();
                        $('#edit').modal('hide');
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                        alert('Terjadi kesalahan saat menyimpan data.' + xhr.responseText);
                    }
                });
            });
            $('#createFasilitasBtn').click(function(e) {
                e.preventDefault();

                // Lakukan pengiriman data dengan AJAX ke server
                var formData = new FormData($('#createFasilitasForm')[0]);

                $.ajax({
                    url: '{{ route('fasilitas.store') }}', // Sesuaikan dengan route Anda
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        console.log(response);
                        alert(response.message);
                        $('#datatable-fasilitas').DataTable().ajax.reload();
                        $('#create').modal('hide');
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                        alert('Terjadi kesalahan saat menyimpan data.' + xhr.responseText);
                    }
                });
            });
            window.deleteCustomers = function(id) {
                if (confirm('Apakah Anda yakin ingin menghapus fasilitas ini?')) {
                    $.ajax({
                        type: 'DELETE',
                        url: '/fasilitas/delete/' + id,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            // alert(response.message);
                            $('#datatable-fasilitas').DataTable().ajax.reload();
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
