<nav class="navbar navbar-expand-lg py-4 navigation header-padding " id="navbar">
    <div class="container-fluid">
        <a class="navbar-brand" href="index.html">
            <img src="{{ asset('img') }}/logo.png" alt="" class="img-fluid" style="height: 70px;">
        </a>

        <button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#navbarsExample09"
            aria-controls="navbarsExample09" aria-expanded="false" aria-label="Toggle navigation">
            <span class="fa fa-bars"></span>
        </button>

        <div class="collapse navbar-collapse text-center" id="navbarsExample09">
            <ul class="navbar-nav m-auto">
                <li class="nav-item ">
                    <a class="nav-link" href="index.html">Home</a>
                </li>
                <li class="nav-item"><a class="nav-link" href="about.html">Data Laporan</a></li>
                <li class="nav-item"><a class="nav-link" href="about.html">Data Perbaikan</a></li>
                <li class="nav-item"><a class="nav-link" href="about.html">Tentang</a></li>
                <li class="nav-item"><a class="nav-link" href="contact.html">Kontak</a></li>
            </ul>
            @guest
                <a href="{{ route('login') }}" class="btn btn-solid-border d-none d-lg-block">Login<i
                        class="fa fa-angle-right ml-2"></i></a>
            @else
                <a href="{{ route('home') }}" class="btn btn-solid-border d-none d-lg-block">Dashboard<i
                        class="fa fa-angle-right ml-2"></i></a>
            @endguest
        </div>
    </div>
</nav>
