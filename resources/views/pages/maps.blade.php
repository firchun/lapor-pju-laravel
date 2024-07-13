@extends('layouts.frontend.app')
@section('content')
    <section class="page-title bg-1">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="block text-center">
                        <span class="text-white">{{ env('APP_NAME') ?? '-' }}</span>
                        <h1 class="text-capitalize mb-5 text-lg">{{ $title ?? '' }}</h1>
                        <ul class="list-inline breadcumb-nav">
                            <li class="list-inline-item"><a href="{{ url('/') }}" class="text-white">Home</a></li>
                            <li class="list-inline-item"><span class="text-white">/</span></li>
                            <li class="list-inline-item"><a href="#" class="text-white-50">{{ $title ?? '' }}</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="section">
        <div class="container">
            <div id="map" style="border-radius:20px;" class="shadow-sm mb-5"></div>
            <hr>
            <h3 class="my-4 text-center">Daftar Fasilitas Penerangan Jalan Umum</h3>

            @foreach ($fasilitas as $item)
                <div class="card shadow-sm mb-3" style="border-radius: 20px;">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div class="text-left ">
                                <strong class="text-primary">{{ $item->code }}</strong><br>
                                <small>{{ $item->alamat }}</small>
                            </div>
                            <div class="text-right">
                                <a href="https://www.google.com/maps/dir/?api=1&destination={{ $item->latitude }},{{ $item->longitude }}"
                                    class="btn btn-sm btn-success">Rute</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
            <div class="mt-4">
                <div class="d-flex justify-content-center">
                    {{ $fasilitas->links('vendor.pagination.bootstrap-4') }}
                </div>
            </div>
        </div>
    </section>
@endsection
@push('css')
    <!-- Load Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />

    <!-- Load Leaflet JavaScript -->
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

    <!-- Set CSS for map container -->
    <style>
        #map {
            height: 600px;
        }
    </style>
@endpush
@push('js')
    <script>
        // Inisialisasi peta Leaflet
        var map = L.map('map').setView([-8.4902, 140.4019], 13); // Koordinat Kabupaten Merauke dan zoom level

        // Tambahkan layer peta dari OpenStreetMap
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        // Ambil data marker dari endpoint JSON
        fetch('/fasilitas/getall')
            .then(response => response.json())
            .then(data => {
                // Buat array untuk menyimpan koordinat dan informasi penanda dari data JSON
                var markers = data.map(item => ({
                    coords: [parseFloat(item.latitude), parseFloat(item.longitude)],
                    title: item.code,
                    address: item.alamat,
                    latitude: item.latitude,
                    longitude: item.longitude
                }));
                markers.forEach(function(marker) {
                    // Membuat isi popup dengan alamat dan link
                    var popupContent =
                        `<strong>${marker.title}</strong><br>Alamat : ${marker.address}<br><a href="https://www.google.com/maps/dir/?api=1&destination=${marker.latitude},${marker.longitude}" target="_blank">Rute Ke PJU</a>`;

                    L.marker(marker.coords)
                        .addTo(map)
                        .bindPopup(popupContent);
                });
            })
            .catch(error => console.error('Error fetching markers:', error));
    </script>
@endpush
