@extends('layouts.backend.admin')

@section('content')
    @include('layouts.backend.alert')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card-box mb-30">
                <div class="card-body">
                    <b class="text-danger text-center">*Harap arahkan pada QRcode PJU</b>
                    <div id="scanner-container">
                        <video id="scanner" width="100%"></video>
                    </div>
                    <form id="qr-form" action="{{ route('kerusakan.update') }}" method="GET">
                        <div class="mb-4" style="display: none;"> <!-- Hidden input code -->
                            <label for="code">Code PJU</label>
                            <input type="text" id="code" placeholder="Code PJU" class="form-control" name="code"
                                required>
                        </div>
                        <button type="submit" id="submit-btn" class="btn btn-primary btn-block"
                            style="display: none;">Update</button> <!-- Hidden submit button -->
                    </form>
                    <button id="scan-btn" class="btn btn-primary btn-block" style="display: none;">Scan QR Code</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Include Instascan Library -->
    <script src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>

    <script>
        // Function to initialize QR scanner
        function initScanner() {
            let scanner = new Instascan.Scanner({
                video: document.getElementById('scanner')
            });

            scanner.addListener('scan', function(content) {
                // Mengambil 16 karakter terakhir dari content
                let last16Characters = content.substr(-16);

                // Mengisi nilai input 'code' dengan 16 karakter terakhir
                document.getElementById('code').value = last16Characters;

                // Submit form 'qr-form'
                document.getElementById('qr-form').submit();
            });

            Instascan.Camera.getCameras().then(function(cameras) {
                if (cameras.length > 0) {
                    scanner.start(cameras[0]);
                } else {
                    console.error('No cameras found.');
                }
            }).catch(function(e) {
                console.error(e);
            });

            // Menampilkan tombol scan dan menyembunyikan form dan tombol submit
            document.getElementById('scan-btn').addEventListener('click', function() {
                document.getElementById('scanner-container').style.display = 'block';
                document.getElementById('submit-btn').style.display = 'none';
                document.getElementById('qr-form').style.display = 'none';
            });
        }

        // Call initScanner when the page is loaded
        document.addEventListener('DOMContentLoaded', function() {
            initScanner();
        });
    </script>
@endsection
