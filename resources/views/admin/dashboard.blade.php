@extends('layouts.backend.admin')

@section('content')
    <div class="title pb-20">
        <h2 class="h3 mb-0 text-white">Dashboard Overview</h2>
    </div>
    <div class="row justify-content-center mb-3">
        <div class="col-md-8">
            <div class="card-box">
                <div class="card-body">

                    <canvas id="grafikBar" width="400" height="200"></canvas>
                </div>
            </div>
        </div>
    </div>
    <div class="title pb-20">
        <h2 class="h3 mb-0 text-white">Rincian singkat</h2>
    </div>
    <div class="row justify-content-center">
        @if (Auth::user()->role == 'Admin')
            @include('admin.dashboard_component.card1', [
                'count' => $admin,
                'title' => 'Admin',
                'subtitle' => 'Total akun admin',
                'color' => 'primary',
                'icon' => 'person-circle',
            ])
        @endif
        @include('admin.dashboard_component.card1', [
            'count' => $teknisi,
            'title' => 'teknisi',
            'subtitle' => 'Total akun teknisi',
            'color' => 'primary',
            'icon' => 'person-circle',
        ])
        @include('admin.dashboard_component.card1', [
            'count' => $fasilitas,
            'title' => 'Fasilitas PJU',
            'subtitle' => 'Total fasilitas',
            'color' => 'success',
            'icon' => 'lamp',
        ])
        @include('admin.dashboard_component.card1', [
            'count' => $kerusakan,
            'title' => 'Kerusakan PJU',
            'subtitle' => 'Total kerusakan pada PJU',
            'color' => 'success',
            'icon' => 'lamp',
        ])
        @include('admin.dashboard_component.card1', [
            'count' => $box,
            'title' => 'Box control',
            'subtitle' => 'Total box control',
            'color' => 'success',
            'icon' => 'lamp',
        ])
        @include('admin.dashboard_component.card1', [
            'count' => $pemeliharaan,
            'title' => 'Pemeliharaan ',
            'subtitle' => 'Total pemeliharaan ',
            'color' => 'success',
            'icon' => 'lamp',
        ])
        @include('admin.dashboard_component.card1', [
            'count' => $mitra,
            'title' => 'Mitra',
            'subtitle' => 'Total mitra perbaikan',
            'color' => 'success',
            'icon' => 'lamp',
        ])
    </div>
@endsection
@push('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            fetch('/grafik') // URL API yang diatur di Laravel Route
                .then(response => response.json())
                .then(data => {
                    const ctx = document.getElementById('grafikBar').getContext('2d');
                    new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: data.months.map(month => `Bulan ${month}`),
                            datasets: [{
                                    label: 'Pemeliharaan',
                                    data: data.pemeliharaan,
                                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                                    borderColor: 'rgba(75, 192, 192, 1)',
                                    borderWidth: 1
                                },
                                {
                                    label: 'Kerusakan',
                                    data: data.kerusakan,
                                    backgroundColor: 'rgba(153, 102, 255, 0.2)',
                                    borderColor: 'rgba(153, 102, 255, 1)',
                                    borderWidth: 1
                                }
                            ]
                        },
                        options: {
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            }
                        }
                    });
                });
        });
    </script>
@endpush
