@extends('layouts.backend.admin')

@section('content')
    @include('layouts.backend.alert')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card-box mb-30">
                <div class="card-body">
                    {{-- <div id="scanner-container">
                        <video id="scanner" width="100%"></video>
                    </div> --}}
                    <div class="form-group text-center">
                        <b class="text-danger text-center">*Harap arahkan pada QRcode PJU</b>
                        <div id="loadingMessage">Tidak dapat mengakses kamera (Mohon untuk mengaktifkan
                            pengaturan kamera)</div>
                        <canvas id="canvas" hidden style="width: 80% !important;"></canvas>
                        <div id="output" hidden>
                            <div id="outputMessage">Qr code tidak terdeteksi, harap perbaiki posisi kamera</div>
                            <div hidden><b>Data:</b> <span id="outputData"></span></div>
                        </div>
                    </div>
                    <form id="qr-form" action="{{ route('kerusakan.update') }}" method="GET">
                        <div class="mb-4" style="display: none;"> <!-- Hidden input code -->
                            <label for="code">Code PJU</label>
                            <input type="text" id="code" placeholder="Code PJU" class="form-control" name="code"
                                required>
                        </div>
                        <button type="submit" id="submit-btn" class="btn btn-primary btn-block"
                            style="display: none;">Update</button>
                        <!-- Hidden submit button -->
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Include Instascan Library -->
    {{-- <script src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script> --}}
    <script src="{{ asset('/') }}js/app-qr.js" type="text/javascript"></script>
    <script src="{{ asset('/') }}js/jsQR.js" type="text/javascript"></script>
    {{-- <script>
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
                let selectedCamera = cameras.find(camera => camera.name.includes('back'));
                if (!selectedCamera) {
                    selectedCamera = cameras[0]; // Pilih kamera pertama jika tidak ada kamera belakang
                }
                scanner.start(selectedCamera);
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
    </script> --}}
    <script>
        function refreshPage() {
            window.location.reload();
        }

        var video = document.createElement("video");
        var canvasElement = document.getElementById("canvas");
        var canvas = canvasElement.getContext("2d");
        var loadingMessage = document.getElementById("loadingMessage");
        var outputContainer = document.getElementById("output");
        var outputMessage = document.getElementById("outputMessage");
        var outputData = document.getElementById("outputData");
        var submit = document.getElementById("submit-btn");
        var outputDatas = document.getElementById("code");

        function drawLine(begin, end, color) {
            canvas.beginPath();
            canvas.moveTo(begin.x, begin.y);
            canvas.lineTo(end.x, end.y);
            canvas.lineWidth = 4;
            canvas.strokeStyle = color;
            canvas.stroke();
        }

        // Use facingMode: environment to attemt to get the front camera on phones
        navigator.mediaDevices.getUserMedia({
            video: {
                facingMode: "environment"
            }
        }).then(function(stream) {
            video.srcObject = stream;
            video.setAttribute("playsinline", true); // required to tell iOS safari we don't want fullscreen
            video.play();
            requestAnimationFrame(tick);
        });

        function tick() {
            loadingMessage.innerText = "Loading camera..."
            if (video.readyState === video.HAVE_ENOUGH_DATA) {
                loadingMessage.hidden = true;
                canvasElement.hidden = false;
                outputContainer.hidden = false;

                // canvasElement.height = video.videoHeight;
                // canvasElement.width = video.videoWidth;
                // Adjust canvas size to match video frame
                canvasElement.height = 400;
                canvasElement.width = 400;
                canvas.drawImage(video, 0, 0, canvasElement.width, canvasElement.height);
                var imageData = canvas.getImageData(0, 0, canvasElement.width, canvasElement.height);
                var code = jsQR(imageData.data, imageData.width, imageData.height, {
                    inversionAttempts: "dontInvert",
                });
                if (code) {
                    drawLine(code.location.topLeftCorner, code.location.topRightCorner, "#FF3B58");
                    drawLine(code.location.topRightCorner, code.location.bottomRightCorner, "#FF3B58");
                    drawLine(code.location.bottomRightCorner, code.location.bottomLeftCorner, "#FF3B58");
                    drawLine(code.location.bottomLeftCorner, code.location.topLeftCorner, "#FF3B58");
                    outputMessage.hidden = true;
                    outputData.parentElement.hidden = true;
                    outputData.innerText = code.data.substr(-16);
                    outputDatas.value = code.data.substr(-16);

                    // Submit form 'qr-form'
                    document.getElementById('qr-form').submit();
                } else {
                    outputMessage.hidden = false;
                    outputData.parentElement.hidden = true;
                }
            }
            requestAnimationFrame(tick);
        }
    </script>
@endsection
