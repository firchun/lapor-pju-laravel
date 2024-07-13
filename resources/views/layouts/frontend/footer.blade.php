<!-- footer Start -->
<footer class="footer section">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 mr-auto col-sm-6">
                <div class="widget mb-5 mb-lg-0">
                    <div class="logo mb-4">
                        <h3>{{ env('APP_NAME') }}</h3>
                    </div>
                    <p>Sistem Informasi Pelaporan Kerusakan pada Penerangan Jalan Umum di kota Merauke.</p>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="widget widget-contact mb-5 mb-lg-0">
                    <h4 class="text-capitalize mb-4">Kontak Kami</h4>
                    <h6><a href="mailto:admin@mixdev.id"> <i class="ti-headphone-alt mr-3"></i>admin@mixdev.id</a>
                    </h6>
                    <h6><a href="tel:+6282248493036"> <i class="ti-mobile mr-3"></i>+6282248493036</a></h6>

                    <ul class="list-inline footer-socials mt-5">
                        <li class="list-inline-item"><a href=""><i class="ti-facebook mr-2"></i></a></li>
                        <li class="list-inline-item"><a href=""><i class="ti-twitter mr-2"></i></a></li>
                        <li class="list-inline-item"><a href=""><i class="ti-linkedin mr-2 "></i></a></li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="footer-btm py-4 mt-5">
            <div class="row">
                <div class="col-lg-6">
                    <div class="copyright">
                        &copy; {{ date('Y') }} Copyright Reserved to <span
                            class="text-color">{{ env('APP_NAME') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
