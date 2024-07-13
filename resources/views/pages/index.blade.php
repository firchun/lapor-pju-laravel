@extends('layouts.frontend.app')
@section('content')
    <!-- Slider Start -->
    <section class="banner d-flex align-items-center">
        <div class="banner-img-part"></div>
        <div class="container">

            <div class="row">
                <div class="col-lg-10 col-md-12 col-xl-8">
                    <div class="block">
                        <span class="text-uppercase text-sm letter-spacing ">{{ env('APP_NAME') }}</span>
                        <h1 class="mb-3 mt-3">Lapor kerusakan penerangan jalan</h1>
                        <p class="mb-5">Website ini digunakan untuk memantau kerusakan lampu jalan pada kota merauke
                            dengan melihat laporan yang di kirim oleh masyarakat melalui website ini</p>

                        <a href="{{ url('/maps') }}" class="btn btn-main">Lihat Peta Sebaran PJU<i
                                class="fa fa-angle-right ml-2"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section process">

        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-5">
                    <div class="process-block pl-4">
                        <span class="text-uppercase text-sm letter-spacing">Apa yang kami kerjakan</span>
                        <h2 class="mb-4 mt-3">Pemeliharaan Penerangan Jalan Umum</h2>
                        <p class="mb-4">Penerangan jalan sangatlah penting untuk masyarakat pada malam hari, bantu kami
                            melaporkan kerusakan penerangan jalan umum agar dapat menerangi jalan di malam hari..</p>
                    </div>
                </div>

                <div class="col-lg-7 col-xs-12 col-md-12">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <div class="icon-block text-center mb-4 mb-lg-0">
                                <i class="ti-light-bulb"></i>
                                <h5>Menerima Laporan</h5>
                                <p>Kami siap menerima laporan kerusakan</p>
                            </div>
                        </div>

                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <div class="icon-block text-center mt-4 mb-4 mb-lg-0">
                                <i class="ti-panel"></i>
                                <h5>Perbaikan</h5>
                                <p>Laporan akan di tindak lanjuti untuk perbaikan PJU</p>
                            </div>
                        </div>

                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <div class="icon-block text-center">
                                <i class="ti-search"></i>
                                <h5>Manajemen Laporan</h5>
                                <p>Kami menganalisa laporan dan memperbaiki kerusakan</p>
                            </div>
                        </div>

                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <div class="icon-block text-center mt-4">
                                <i class="ti-rocket"></i>
                                <h5>Mobilitas</h5>
                                <p>Kemi memperbaiki dengan cepat dan tepat</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- section portfolio END -->
    <!-- section Counter Start -->
    <section class="section counter">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="counter-item text-center mb-5 mb-lg-0">
                        <h2 class="mb-0"><span
                                class="counter-stat font-weight-bold">{{ App\Models\Fasilitas::count() }}</span> +</h2>
                        <p>Penerangan Jalan Umum</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="counter-item text-center mb-5 mb-lg-0">
                        <h2 class="mb-0"><span
                                class="counter-stat font-weight-bold">{{ App\Models\User::where('role', 'Teknisi')->count() }}
                            </span> </h2>
                        <p>Teknisi Kami</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="counter-item text-center mb-5 mb-lg-0">
                        <h2 class="mb-0"><span
                                class="counter-stat font-weight-bold">{{ App\Models\Kerusakan::count() }}</span>
                        </h2>
                        <p>Jumlah Laporan Kerusakan</p>
                    </div>
                </div>

            </div>
        </div>
    </section>
    <!-- section Counter End  -->
    <section class="section testimonial">


        <div class="container-fluid">
            <div class="row">
                @foreach (App\Models\Kerusakan::with(['fasilitas'])->latest()->limit(5)->get() as $item)
                    <div class="col-lg-12 testimonial-wrap">
                        <div class="testimonial-block">
                            <p>
                                <strong>{{ $item->fasilitas->code }}</strong><br>
                                Keterangan : {{ $item->keterangan }}<br>
                                <span class="d-flex mt-3">
                                    <img src="{{ Storage::url($item->foto_kerusakan_1) }}" alt="" class="img-fluid"
                                        style="height: 100px;width:100px;object-fit:cover;">
                                    <img src="{{ Storage::url($item->foto_kerusakan_2) }}" alt="" class="img-fluid"
                                        style="height: 100px;width:100px;object-fit:cover;">
                                </span>
                            </p>

                            <div class="client-info d-flex align-items-center">
                                <div class="client-img">
                                    <img src="{{ Storage::url($item->foto_pelapor) }}" alt="" class="img-fluid"
                                        style="height: 100px;width:100px;object-fit:cover;">
                                </div>
                                <div class="info">
                                    <h6>{{ $item->nama_pelapor }}</h6>
                                    <span>{{ $item->created_at }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection
